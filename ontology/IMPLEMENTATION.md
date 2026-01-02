# Dokumentasi Implementasi Web Semantic - uriblog

## Daftar Isi
1. [Arsitektur Sistem](#arsitektur-sistem)
2. [File-file Ontologi](#file-file-ontologi)
3. [File-file Laravel](#file-file-laravel)
4. [Alur Kerja Sistem](#alur-kerja-sistem)
5. [Penjelasan Kode](#penjelasan-kode)

---

## Arsitektur Sistem

Implementasi Web Semantic di uriblog menggunakan arsitektur 3-layer:

```
┌─────────────────────────────────────────────────────────┐
│                    Web Application                       │
│              (Laravel - MySQL Database)                  │
└────────────────────┬────────────────────────────────────┘
                     │
                     │ Auto-Sync (Event/Observer)
                     ↓
┌─────────────────────────────────────────────────────────┐
│                   RDF Export Layer                       │
│            (RDFService - Turtle Format)                  │
└────────────────────┬────────────────────────────────────┘
                     │
                     │ Upload/Query
                     ↓
┌─────────────────────────────────────────────────────────┐
│                 Semantic Web Layer                       │
│         (Apache Jena Fuseki - SPARQL Endpoint)          │
└─────────────────────────────────────────────────────────┘
```

---

## File-file Ontologi

### 1. `ontology/uri-blog-ontology.owl`

**Tujuan**: Mendefinisikan struktur semantic web (schema/blueprint)

**Isi**:
- **Classes**: Blog, User, Post, Category
- **Object Properties**: hasAuthor, hasCategory, writtenBy, containsPost
- **Data Properties**: 17 properties (authorName, postTitle, dll)

**Format**: OWL 2 (Web Ontology Language) dalam XML/RDF

**Cara Membuka**:
- Text editor: Lihat sebagai XML
- Protégé: Visualisasi grafis ontologi

**Contoh Class Definition**:
```xml
<owl:Class rdf:about="http://www.uriblog.com/ontology#User">
    <rdfs:comment>Represents a registered user who can create and manage posts</rdfs:comment>
    <rdfs:label>User</rdfs:label>
</owl:Class>
```

**Contoh Property Definition**:
```xml
<owl:DatatypeProperty rdf:about="http://www.uriblog.com/ontology#authorName">
    <rdfs:domain rdf:resource="http://www.uriblog.com/ontology#User"/>
    <rdfs:range rdf:resource="http://www.w3.org/2001/XMLSchema#string"/>
    <rdfs:label>author name</rdfs:label>
</owl:DatatypeProperty>
```

---

### 2. `ontology/README.md`

**Tujuan**: Dokumentasi lengkap ontologi dan cara penggunaannya

**Isi**:
- Penjelasan setiap class dan property
- Contoh SPARQL queries
- Panduan setup Fuseki
- Penjelasan sistem auto-sync

**Target Pembaca**: Mahasiswa, dosen, developer

---

### 3. `ontology/SETUP-FUSEKI.md`

**Tujuan**: Panduan step-by-step setup Apache Jena Fuseki

**Isi**:
- Download dan instalasi
- Menjalankan server
- Membuat dataset
- Upload data
- Testing SPARQL
- Troubleshooting

**Target Pembaca**: Pengguna yang baru pertama kali pakai Fuseki

---

## File-file Laravel

### 1. `app/Services/RDFService.php`

**Tujuan**: Service untuk generate RDF dari database

**Fungsi Utama**:

#### `generateRDF(): string`
Menghasilkan seluruh RDF dari database dalam format Turtle.

```php
public function generateRDF(): string
{
    $this->triples = [];
    
    $rdf = $this->generatePrefixes();      // Prefix definitions
    $rdf .= $this->generateBlogInstance(); // Blog instance
    $rdf .= $this->generateAuthors();      // User instances
    $rdf .= $this->generateCategories();   // Category instances
    $rdf .= $this->generatePosts();        // Post instances
    
    return $rdf;
}
```

#### `generateAuthors(): string`
Convert data User dari MySQL ke RDF format.

**Input**: Data dari tabel `users`
**Output**: RDF triples dalam format Turtle

```php
protected function generateAuthors(): string
{
    $users = User::all();
    
    foreach ($users as $user) {
        $userId = $this->sanitizeId($user->username ?? $user->name);
        
        $output .= ":User_{$userId} rdf:type :User ;\n";
        $output .= "    :authorName \"{$this->escape($user->name)}\" ;\n";
        $output .= "    :authorEmail \"{$this->escape($user->email)}\" ;\n";
        // ... dst
    }
}
```

**Contoh Output**:
```turtle
:User_kholil rdf:type :User ;
    :authorName "Kholil Mustofa" ;
    :authorUsername "kholil" ;
    :authorEmail "kholil@example.com" ;
    :emailVerified "true"^^xsd:boolean .
```

#### `generatePosts(): string`
Convert data Post dari MySQL ke RDF format dengan relasi ke User dan Category.

```php
protected function generatePosts(): string
{
    $posts = Post::with(['author', 'category'])->get();
    
    foreach ($posts as $post) {
        $postId = $this->sanitizeId($post->slug);
        $userId = $this->sanitizeId($post->author->username);
        $categoryId = $this->sanitizeId($post->category->slug);
        
        $output .= ":Post_{$postId} rdf:type :Post ;\n";
        $output .= "    :postTitle \"{$this->escape($post->title)}\" ;\n";
        $output .= "    :hasAuthor :User_{$userId} ;\n";
        $output .= "    :hasCategory :Category_{$categoryId} ;\n";
        // ... dst
    }
}
```

**Contoh Output**:
```turtle
:Post_laravel-tutorial rdf:type :Post ;
    :postTitle "Laravel Tutorial" ;
    :postSlug "laravel-tutorial" ;
    :postContent "Ini adalah tutorial Laravel..." ;
    :publishedDate "2026-01-02T10:30:00+00:00"^^xsd:dateTime ;
    :hasAuthor :User_kholil ;
    :hasCategory :Category_technology .
```

#### `saveToFile(): string`
Menyimpan RDF yang sudah di-generate ke file.

**Lokasi Output**: `storage/app/rdf/uri-blog-data.ttl`

---

### 2. `app/Events/DataChanged.php`

**Tujuan**: Event yang dipicu saat ada perubahan data

**Kapan Dipicu**:
- Post created/updated/deleted
- User created/updated/deleted
- Category created/updated/deleted

**Properties**:
```php
public $modelType;  // 'Post', 'User', atau 'Category'
public $action;     // 'created', 'updated', atau 'deleted'
```

**Cara Kerja**:
```php
// Contoh: Saat post baru dibuat
event(new DataChanged('Post', 'created'));
```

---

### 3. `app/Listeners/ExportToRDF.php`

**Tujuan**: Listener yang mendengarkan event DataChanged dan auto-export RDF

**Fungsi Utama**:

```php
public function handle(DataChanged $event): void
{
    try {
        // Export RDF whenever data changes
        $filepath = $this->rdfService->saveToFile();
        
        Log::info("RDF auto-exported: {$event->modelType} {$event->action}", [
            'file' => $filepath,
            'timestamp' => now()->toDateTimeString()
        ]);
    } catch (\Exception $e) {
        Log::error("RDF auto-export failed: " . $e->getMessage());
    }
}
```

**Alur**:
1. Event `DataChanged` dipicu
2. Listener ini otomatis jalan
3. Panggil `RDFService->saveToFile()`
4. File RDF ter-update
5. Log dicatat

---

### 4. `app/Observers/PostObserver.php`

**Tujuan**: Monitor perubahan pada model Post

**Fungsi**:

```php
class PostObserver
{
    public function created(Post $post): void
    {
        event(new DataChanged('Post', 'created'));
    }

    public function updated(Post $post): void
    {
        event(new DataChanged('Post', 'updated'));
    }

    public function deleted(Post $post): void
    {
        event(new DataChanged('Post', 'deleted'));
    }
}
```

**Cara Kerja**:
```
User buat post baru via web
    ↓
Laravel save ke database
    ↓
PostObserver->created() dipanggil otomatis
    ↓
Event DataChanged dipicu
    ↓
Listener ExportToRDF jalan
    ↓
RDF file ter-update
```

---

### 5. `app/Observers/UserObserver.php`

**Tujuan**: Monitor perubahan pada model User

**Sama seperti PostObserver**, tapi untuk User.

**Trigger**:
- User register baru
- User update profile
- User dihapus (soft delete)

---

### 6. `app/Observers/CategoryObserver.php`

**Tujuan**: Monitor perubahan pada model Category

**Sama seperti PostObserver**, tapi untuk Category.

**Trigger**:
- Category baru dibuat
- Category di-update
- Category dihapus

---

### 7. `app/Providers/AppServiceProvider.php`

**Tujuan**: Mendaftarkan Event Listener dan Observer

**Kode Penting**:

```php
public function boot(): void
{
    Model::preventLazyLoading();
    
    // Register RDF auto-sync listener
    \Illuminate\Support\Facades\Event::listen(
        \App\Events\DataChanged::class,
        \App\Listeners\ExportToRDF::class
    );
    
    // Register model observers for auto RDF export
    \App\Models\Post::observe(\App\Observers\PostObserver::class);
    \App\Models\User::observe(\App\Observers\UserObserver::class);
    \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
}
```

**Penjelasan**:
- Baris 6-9: Hubungkan Event dengan Listener
- Baris 12-14: Hubungkan Model dengan Observer

---

### 8. `app/Console/Commands/ExportRDF.php`

**Tujuan**: Command untuk manual export RDF

**Cara Pakai**:
```bash
php artisan rdf:export
```

**Output**:
```
Starting RDF export...

Database Statistics:
+------------+-------+
| Type       | Count |
+------------+-------+
| Posts      | 57    |
| Authors    | 8     |
| Categories | 3     |
+------------+-------+

Generating RDF...
✓ RDF exported successfully!

Output file: C:\wpucourse\uriblog\storage\app/rdf/uri-blog-data.ttl
File size: 42.9 KB
```

**Kapan Digunakan**:
- Pertama kali setup (data sudah ada sebelum auto-sync aktif)
- Setelah bulk import data
- Untuk testing

---

### 9. `app/Console/Commands/SyncRDF.php`

**Tujuan**: Command untuk upload RDF ke Fuseki

**Cara Pakai**:
```bash
php artisan rdf:sync
```

**Catatan**: Perlu konfigurasi di `.env` terlebih dahulu:
```env
FUSEKI_ENDPOINT=http://localhost:3030
FUSEKI_DATASET=uriblog
```

---

### 10. `config/semantic.php`

**Tujuan**: Konfigurasi untuk semantic web

**Isi**:
```php
return [
    'ontology' => [
        'namespace' => 'http://www.uriblog.com/ontology#',
    ],
    
    'prefixes' => [
        '' => 'http://www.uriblog.com/ontology#',
        'rdf' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#',
        'rdfs' => 'http://www.w3.org/2000/01/rdf-schema#',
        'owl' => 'http://www.w3.org/2002/07/owl#',
        'xsd' => 'http://www.w3.org/2001/XMLSchema#',
    ],
    
    'export' => [
        'output_path' => storage_path('app/rdf'),
        'filename' => 'uri-blog-data.ttl',
    ],
    
    'fuseki' => [
        'endpoint' => env('FUSEKI_ENDPOINT', 'http://localhost:3030'),
        'dataset' => env('FUSEKI_DATASET', 'uriblog'),
    ],
];
```

---

## Alur Kerja Sistem

### Skenario 1: User Membuat Post Baru

```
1. User mengisi form "Create Post" di web
   ↓
2. Controller menyimpan ke database MySQL
   POST: {title, body, category_id, user_id}
   ↓
3. PostObserver->created() otomatis terpanggil
   ↓
4. Event DataChanged('Post', 'created') dipicu
   ↓
5. Listener ExportToRDF->handle() jalan
   ↓
6. RDFService->generateRDF() dipanggil
   ↓
7. Query semua data dari MySQL:
   - SELECT * FROM users
   - SELECT * FROM categories
   - SELECT * FROM posts
   ↓
8. Convert setiap record ke format RDF Turtle
   ↓
9. Simpan ke storage/app/rdf/uri-blog-data.ttl
   ↓
10. Log dicatat: "RDF auto-exported: Post created"
```

**Waktu Eksekusi**: ~100-500ms (tergantung jumlah data)

---

### Skenario 2: Manual Export RDF

```
1. Developer run command: php artisan rdf:export
   ↓
2. ExportRDF Command dijalankan
   ↓
3. Tampilkan statistik database
   ↓
4. RDFService->generateRDF() dipanggil
   ↓
5. Generate RDF dari seluruh database
   ↓
6. Simpan ke file .ttl
   ↓
7. Tampilkan info file (path, size, sample)
```

---

### Skenario 3: Query SPARQL di Fuseki

```
1. User buka Fuseki web interface
   ↓
2. Pilih dataset "uriblog"
   ↓
3. Tulis SPARQL query:
   SELECT ?postTitle ?authorName WHERE { ... }
   ↓
4. Fuseki parse query
   ↓
5. Fuseki cari di triple store (TDB2)
   ↓
6. Return hasil dalam format JSON/XML/CSV
   ↓
7. Tampilkan di web interface
```

---

## Penjelasan Kode

### Mengapa Pakai Observer Pattern?

**Tanpa Observer** (Manual):
```php
// Di PostController
public function store(Request $request)
{
    $post = Post::create($request->all());
    
    // Harus manual panggil export
    app(RDFService::class)->saveToFile();
    
    return redirect()->back();
}
```

**Masalah**:
- Harus ingat panggil export di setiap controller
- Mudah lupa
- Code duplication

**Dengan Observer** (Otomatis):
```php
// Di PostController
public function store(Request $request)
{
    $post = Post::create($request->all());
    // Observer otomatis jalan!
    return redirect()->back();
}
```

**Keuntungan**:
- Otomatis, tidak perlu ingat
- Centralized logic
- Clean code

---

### Mengapa Pakai Event/Listener?

**Keuntungan**:
1. **Decoupling**: Observer tidak perlu tahu detail RDFService
2. **Scalability**: Bisa tambah listener lain (misal: kirim notifikasi)
3. **Testing**: Mudah di-mock untuk unit test

**Contoh Multiple Listeners**:
```php
Event::listen(DataChanged::class, [
    ExportToRDF::class,        // Export RDF
    SendNotification::class,   // Kirim notif
    UpdateCache::class,        // Update cache
]);
```

---

### Format RDF Turtle vs RDF/XML

**Turtle** (yang kita pakai):
```turtle
:User_kholil rdf:type :User ;
    :authorName "Kholil Mustofa" ;
    :authorEmail "kholil@example.com" .
```

**RDF/XML** (alternatif):
```xml
<rdf:Description rdf:about="http://www.uriblog.com/ontology#User_kholil">
    <rdf:type rdf:resource="http://www.uriblog.com/ontology#User"/>
    <authorName>Kholil Mustofa</authorName>
    <authorEmail>kholil@example.com</authorEmail>
</rdf:Description>
```

**Mengapa Turtle?**
- Lebih mudah dibaca manusia
- Lebih ringkas
- Standar untuk SPARQL

---

## Checklist Implementasi

### Ontologi
- [x] Class: Blog, User, Post, Category
- [x] Object Properties: hasAuthor, hasCategory, writtenBy, containsPost
- [x] Data Properties: 17 properties
- [x] No external dependencies (FOAF removed)

### Laravel Backend
- [x] RDFService untuk generate RDF
- [x] Event DataChanged
- [x] Listener ExportToRDF
- [x] Observer untuk Post, User, Category
- [x] Command rdf:export
- [x] Command rdf:sync (optional)
- [x] Config semantic.php

### Auto-Sync
- [x] Trigger saat create
- [x] Trigger saat update
- [x] Trigger saat delete
- [x] Logging

### Dokumentasi
- [x] ontology/README.md
- [x] ontology/SETUP-FUSEKI.md
- [x] ontology/IMPLEMENTATION.md (file ini)

### Testing
- [ ] Setup Fuseki
- [ ] Upload RDF
- [ ] Test 5 SPARQL queries
- [ ] Verify auto-sync works

---

## Untuk Presentasi

### Yang Harus Ditunjukkan:

1. **Ontologi**
   - Buka `uri-blog-ontology.owl` di text editor
   - Jelaskan 4 classes
   - Jelaskan beberapa properties

2. **Auto-Sync**
   - Buat post baru di web
   - Tunjukkan log: `tail -f storage/logs/laravel.log`
   - Buka file RDF, tunjukkan data baru muncul

3. **RDF File**
   - Buka `storage/app/rdf/uri-blog-data.ttl`
   - Jelaskan format Turtle
   - Tunjukkan contoh User, Post, Category

4. **Fuseki**
   - Buka http://localhost:3030
   - Tunjukkan dataset `uriblog`
   - Run 3-5 SPARQL queries
   - Tunjukkan hasil query

5. **Code**
   - Buka `RDFService.php`
   - Jelaskan method `generatePosts()`
   - Buka `PostObserver.php`
   - Jelaskan cara kerja auto-sync

---

**Dibuat untuk tugas Web Semantic - uriblog**
**Kholil Mustofa - 2026**
