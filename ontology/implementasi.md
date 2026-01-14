# Dokumentasi Implementasi Web Semantic - uriblog

File ini menjelaskan struktur file dan folder yang dibuat untuk mendukung fitur Web Semantic (RDF & Fuseki) pada aplikasi uriblog.

## 1. Direktori Ontologi (`ontology/`)

Folder ini berisi blueprint dan dokumentasi utama untuk Web Semantic.

*   **`uri-blog-ontology.owl`**: File inti ontologi yang mendefinisikan Class (Author, Post, Category), Object Properties (relasi antar data), dan Data Properties (atribut data). Ini adalah "skema" untuk semantic web.
*   **`README.md`**: Panduan penggunaan ontologi, cara setup server Fuseki, dan kumpulan contoh query SPARQL untuk menguji data.
*   **`implementasi.md`**: File ini sendiri, yang menjelaskan pemetaan file dalam sistem.

## 2. Backend Laravel (`app/`)

Berisi logika program untuk memproses data dari database relasional (MySQL) menjadi data semantik (RDF).

### Services (`app/Services/`)
*   **`RDFService.php`**: Berfungsi untuk merubah data dari database MySQL menjadi format Turtle (RDF). File ini menangani pemetaan atribut tabel menjadi properti ontologi.
*   **`FusekiService.php`**: Berfungsi untuk menangani komunikasi antara aplikasi Laravel dengan server Apache Jena Fuseki, seperti mengunggah data RDF, menjalankan query SPARQL, dan membersihkan dataset.

### Automation (`app/Observers/`, `app/Events/`, `app/Listeners/`)
*   **`Observers/`** (`PostObserver.php`, `UserObserver.php`, `CategoryObserver.php`): Mengawasi setiap perubahan data pada model Post, User, dan Category. Jika ada data ditambah/diubah/dihapus, file ini akan memicu proses sinkronisasi.
*   **`Events/DataChanged.php`**: Penanda (event) bahwa telah terjadi perubahan data yang perlu diproses oleh sistem RDF.
*   **`Listeners/ExportToRDF.php`**: Penangan (listener) yang menjalankan perintah export, clear dataset Fuseki, dan sinkronisasi ke Fuseki secara otomatis segera setelah menerima sinyal dari Event.

### Commands (`app/Console/Commands/`)
*   **`ExportRDF.php`**: Perintah Artisan (`php artisan rdf:export`) untuk menjalankan export database ke file RDF secara manual.
*   **`SyncRDF.php`**: Perintah Artisan (`php artisan rdf:sync`) untuk mengunggah file RDF ke server Fuseki secara manual.

### Registrasi (`app/Providers/`)
*   **`AppServiceProvider.php`**: Tempat mendaftarkan Observers dan Event Listeners agar sistem otomatisasi berjalan saat aplikasi dijalankan.

### Controllers (`app/Http/Controllers/`)
*   **`PostController.php`**: Menangani hybrid search - menggunakan SPARQL saat Fuseki online, fallback ke SQL saat offline.

## 3. Konfigurasi dan Penyimpanan

*   **`config/semantic.php`**: File konfigurasi yang berisi pengaturan namespace ontologi, prefix RDF, alamat server Fuseki, dan nama dataset.
*   **`storage/app/rdf/uri-blog-data.ttl`**: File hasil export yang berisi data seluruh website dalam format Turtle (RDF). File ini yang disinkronkan ke server Fuseki.

---

## Alur Singkat Kerja Sistem

1.  **Data Berubah**: User membuat, mengubah, atau menghapus post/category di website.
2.  **Observer Mendeteksi**: Observer memicu `DataChanged` Event.
3.  **Auto-Export**: Listener memanggil `RDFService` untuk memperbarui file `.ttl`.
4.  **Clear Dataset**: Listener memanggil `FusekiService->clearDataset()` untuk menghapus data lama di Fuseki (penting untuk operasi delete).
5.  **Auto-Sync**: Listener memanggil `FusekiService` untuk mengunggah data terbaru ke server Apache Jena Fuseki.
6.  **Siap Query**: Data terbaru langsung bisa di-query menggunakan SPARQL di interface Fuseki atau melalui hybrid search di halaman `/posts`.

## Fitur Hybrid Search

Sistem menggunakan **hybrid search** yang cerdas:
- **Fuseki Online**: Menggunakan SPARQL query untuk pencarian semantik (menampilkan badge "Semantic Search Active")
- **Fuseki Offline**: Otomatis fallback ke SQL query tradisional
- **Seamless**: User tidak perlu tahu perbedaannya, sistem selalu berfungsi

---

## File-File yang Menjalankan Web Semantic

### 🔄 **1. Saat User Mengakses Halaman `/posts` (Blog)**

**File yang Bekerja:**

#### `app/Http/Controllers/PostController.php` (Baris 35-95)
```php
// Cek apakah Fuseki online
$fusekiAvailable = $this->fusekiService->isAvailable();

if ($fusekiAvailable) {
    // Jalankan SPARQL search
    $sparqlPosts = $this->fusekiService->searchPosts(...);
    // Transform data SPARQL ke format yang bisa ditampilkan
    $posts = collect($sparqlPosts)->map(...);
} else {
    // Fallback ke SQL
    $posts = Post::with(['author', 'category'])->get();
}
```

**Alur:**
1. User buka `/posts`
2. `PostController@index` dipanggil
3. Cek Fuseki online/offline via `FusekiService->isAvailable()`
4. **Jika online**: Panggil `FusekiService->searchPosts()` → Query SPARQL ke Fuseki
5. **Jika offline**: Query SQL biasa ke MySQL
6. Transform data → Tampilkan di view

---

### 💾 **2. Saat User Membuat/Edit/Hapus Post**

**File yang Bekerja (Otomatis):**

#### `app/Observers/PostObserver.php`
```php
public function created(Post $post) {
    event(new DataChanged('Post', 'created'));
}
```
- Mendeteksi perubahan data
- Trigger event `DataChanged`

#### `app/Events/DataChanged.php`
```php
public function __construct(string $modelType, string $action) {
    $this->modelType = $modelType;
    $this->action = $action;
}
```
- Membawa informasi: model apa yang berubah (Post/Author/Category)

#### `app/Listeners/ExportToRDF.php`
```php
public function handle(DataChanged $event) {
    // 1. Export ke TTL
    $filepath = $this->rdfService->saveToFile();
    
    // 2. Clear Fuseki
    $this->fusekiService->clearDataset();
    
    // 3. Upload ke Fuseki
    $this->fusekiService->uploadRDF($filepath);
}
```
- Export data ke RDF
- Clear data lama di Fuseki
- Upload data baru

**Alur:**
```
User create post → PostObserver → DataChanged Event → ExportToRDF Listener
                                                            ↓
                                                    RDFService (export)
                                                            ↓
                                                    FusekiService (sync)
```

---

### 🔍 **3. Saat Sistem Query SPARQL ke Fuseki**

**File yang Bekerja:**

#### `app/Services/FusekiService.php` (Method: `searchPosts()`)
```php
public function searchPosts($search, $category, $author, $limit) {
    // Build SPARQL query
    $sparql = "
    SELECT ?post ?title ?slug ?content ?postImage ...
    WHERE {
      ?post rdf:type :Post .
      ?post :postTitle ?title .
      ?post :hasAuthor ?author .
      ...
    }
    ";
    
    // Kirim ke Fuseki
    $response = Http::withHeaders([
        'Accept' => 'application/sparql-results+json'
    ])->post($this->queryEndpoint, [
        'query' => $sparql
    ]);
    
    return $response->json()['results']['bindings'];
}
```

**Alur:**
1. `PostController` panggil `FusekiService->searchPosts()`
2. Build SPARQL query dengan filter (search, category, author)
3. Kirim HTTP POST ke Fuseki endpoint
4. Parse JSON response
5. Return data ke Controller

---

### 📤 **4. Saat Export Data ke RDF**

**File yang Bekerja:**

#### `app/Services/RDFService.php` (Method: `generateRDF()`)
```php
public function generateRDF() {
    $rdf = $this->generatePrefixes();
    $rdf .= $this->generateAuthors();    // Export semua authors
    $rdf .= $this->generateCategories(); // Export semua categories
    $rdf .= $this->generatePosts();      // Export semua posts
    return $rdf;
}
```

**Contoh Output (TTL):**
```turtle
:Author_kholil rdf:type :Author ;
    :authorName "Kholil Mustofa" ;
    :authorEmail "kholil@gmail.com" .

:Post_informatika rdf:type :Post ;
    :postTitle "informatika" ;
    :hasAuthor :Author_kholil ;
    :hasCategory :Category_web-design .
```

---

### ⚙️ **5. Saat Jalankan Command Manual**

**File yang Bekerja:**

#### `app/Console/Commands/ExportRDF.php`
```bash
php artisan rdf:export
```
- Panggil `RDFService->saveToFile()`
- Generate file `.ttl`

#### `app/Console/Commands/SyncRDF.php`
```bash
php artisan rdf:sync
```
- Panggil `RDFService->saveToFile()`
- Panggil `FusekiService->clearDataset()`
- Panggil `FusekiService->uploadRDF()`

---

## 📊 Diagram Lengkap: File yang Terlibat

```
┌─────────────────────────────────────────────────────────────┐
│                    USER INTERACTION                          │
└─────────────────────────────────────────────────────────────┘
                            ↓
        ┌──────────────────┴──────────────────┐
        │                                     │
    BACA DATA                            UBAH DATA
        │                                     │
        ↓                                     ↓
┌───────────────────┐              ┌──────────────────┐
│ PostController    │              │ PostObserver     │
│ (index method)    │              │ (created/updated)│
└────────┬──────────┘              └────────┬─────────┘
         │                                  │
         ↓                                  ↓
┌───────────────────┐              ┌──────────────────┐
│ FusekiService     │              │ DataChanged      │
│ (searchPosts)     │              │ (Event)          │
└────────┬──────────┘              └────────┬─────────┘
         │                                  │
         ↓                                  ↓
┌───────────────────┐              ┌──────────────────┐
│ SPARQL Query      │              │ ExportToRDF      │
│ ke Fuseki         │              │ (Listener)       │
└───────────────────┘              └────────┬─────────┘
                                            │
                                            ↓
                                   ┌──────────────────┐
                                   │ RDFService       │
                                   │ (generateRDF)    │
                                   └────────┬─────────┘
                                            │
                                            ↓
                                   ┌──────────────────┐
                                   │ FusekiService    │
                                   │ (clearDataset +  │
                                   │  uploadRDF)      │
                                   └──────────────────┘
```

---

## 🎯 Kesimpulan: File Kunci Web Semantic

| File | Fungsi | Kapan Dijalankan |
|------|--------|------------------|
| **PostController.php** | Hybrid search (SPARQL/SQL) | Setiap user buka `/posts` |
| **FusekiService.php** | Query SPARQL, upload RDF | Saat search & auto-sync |
| **RDFService.php** | Generate RDF dari database | Saat auto-sync & manual export |
| **PostObserver.php** | Deteksi perubahan data | Saat create/update/delete post |
| **ExportToRDF.php** | Auto-sync ke Fuseki | Setelah data berubah |
| **ExportRDF.php** | Manual export command | `php artisan rdf:export` |
| **SyncRDF.php** | Manual sync command | `php artisan rdf:sync` |

**Semua file ini bekerja sama untuk menjalankan Web Semantic!** 🚀
