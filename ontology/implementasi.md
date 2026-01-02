# Dokumentasi Implementasi Web Semantic - uriblog

File ini menjelaskan struktur file dan folder yang dibuat untuk mendukung fitur Web Semantic (RDF & Fuseki) pada aplikasi uriblog.

## 1. Direktori Ontologi (`ontology/`)

Folder ini berisi blueprint dan dokumentasi utama untuk Web Semantic.

*   **`uri-blog-ontology.owl`**: File inti ontologi yang mendefinisikan Class (User, Post, Category), Object Properties (relasi antar data), dan Data Properties (atribut data). Ini adalah "skema" untuk semantic web.
*   **`README.md`**: Panduan penggunaan ontologi, cara setup server Fuseki, dan kumpulan contoh query SPARQL untuk menguji data.
*   **`implementasi.md`**: File ini sendiri, yang menjelaskan pemetaan file dalam sistem.

## 2. Backend Laravel (`app/`)

Berisi logika program untuk memproses data dari database relasional (MySQL) menjadi data semantik (RDF).

### Services (`app/Services/`)
*   **`RDFService.php`**: Berfungsi untuk merubah data dari database MySQL menjadi format Turtle (RDF). File ini menangani pemetaan atribut tabel menjadi properti ontologi.
*   **`FusekiService.php`**: Berfungsi untuk menangani komunikasi antara aplikasi Laravel dengan server Apache Jena Fuseki, seperti mengunggah data RDF dan menjalankan query SPARQL.

### Automation (`app/Observers/`, `app/Events/`, `app/Listeners/`)
*   **`Observers/`** (`PostObserver.php`, `UserObserver.php`, `CategoryObserver.php`): Mengawasi setiap perubahan data pada model Post, User, dan Category. Jika ada data ditambah/diubah/dihapus, file ini akan memicu proses sinkronisasi.
*   **`Events/DataChanged.php`**: Penanda (event) bahwa telah terjadi perubahan data yang perlu diproses oleh sistem RDF.
*   **`Listeners/ExportToRDF.php`**: Penangan (listener) yang menjalankan perintah export dan sinkronisasi ke Fuseki secara otomatis segera setelah menerima sinyal dari Event.

### Commands (`app/Console/Commands/`)
*   **`ExportRDF.php`**: Perintah Artisan (`php artisan rdf:export`) untuk menjalankan export database ke file RDF secara manual.
*   **`SyncRDF.php`**: Perintah Artisan (`php artisan rdf:sync`) untuk mengunggah file RDF ke server Fuseki secara manual.

### Registrasi (`app/Providers/`)
*   **`AppServiceProvider.php`**: Tempat mendaftarkan Observers dan Event Listeners agar sistem otomatisasi berjalan saat aplikasi dijalankan.

## 3. Konfigurasi dan Penyimpanan

*   **`config/semantic.php`**: File konfigurasi yang berisi pengaturan namespace ontologi, prefix RDF, alamat server Fuseki, dan nama dataset.
*   **`storage/app/rdf/uri-blog-data.ttl`**: File hasil export yang berisi data seluruh website dalam format Turtle (RDF). File ini yang disinkronkan ke server Fuseki.

---

## Alur Singkat Kerja Sistem

1.  **Data Berubah**: User membuat post atau category baru di website.
2.  **Observer Mendeteksi**: Observer memicu `DataChanged` Event.
3.  **Auto-Export**: Listener memanggil `RDFService` untuk memperbarui file `.ttl`.
4.  **Auto-Sync**: Listener memanggil `FusekiService` untuk mengunggah data terbaru ke server Apache Jena Fuseki.
5.  **Siap Query**: Data terbaru langsung bisa di-query menggunakan SPARQL di interface Fuseki.
