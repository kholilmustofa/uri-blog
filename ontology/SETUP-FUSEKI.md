# Panduan Setup Apache Jena Fuseki untuk uriblog

## Daftar Isi
1. [Download dan Instalasi](#1-download-dan-instalasi)
2. [Menjalankan Fuseki Server](#2-menjalankan-fuseki-server)
3. [Membuat Dataset](#3-membuat-dataset)
4. [Upload Data RDF](#4-upload-data-rdf)
5. [Testing SPARQL Query](#5-testing-sparql-query)
6. [Troubleshooting](#troubleshooting)

---

## 1. Download dan Instalasi

### Download Apache Jena Fuseki

1. Buka browser dan kunjungi: https://jena.apache.org/download/
2. Scroll ke bagian **Apache Jena Fuseki**
3. Download versi terbaru (contoh: `apache-jena-fuseki-5.2.0.zip`)
4. Extract file ZIP ke folder pilihan Anda, misalnya:
   ```
   C:\fuseki\apache-jena-fuseki-5.2.0
   ```

### Persyaratan
- **Java 17 atau lebih tinggi** harus sudah terinstall
- Cek versi Java Anda:
  ```bash
  java -version
  ```
- Jika belum ada, download dari: https://www.oracle.com/java/technologies/downloads/

---

## 2. Menjalankan Fuseki Server

### Windows

1. Buka Command Prompt atau PowerShell
2. Masuk ke folder Fuseki:
   ```bash
   cd C:\fuseki\apache-jena-fuseki-5.2.0
   ```
3. Jalankan server:
   ```bash
   fuseki-server.bat
   ```

### Linux/Mac

1. Buka Terminal
2. Masuk ke folder Fuseki:
   ```bash
   cd ~/fuseki/apache-jena-fuseki-5.2.0
   ```
3. Berikan permission execute:
   ```bash
   chmod +x fuseki-server
   ```
4. Jalankan server:
   ```bash
   ./fuseki-server
   ```

### Verifikasi Server Berjalan

Anda akan melihat output seperti ini:
```
[2026-01-02 13:55:00] Server     INFO  Apache Jena Fuseki 5.2.0
[2026-01-02 13:55:00] Server     INFO  Path = /
[2026-01-02 13:55:00] Server     INFO  System
[2026-01-02 13:55:00] Server     INFO    Memory: 4.0 GiB
[2026-01-02 13:55:00] Server     INFO    Java:   17.0.1
[2026-01-02 13:55:00] Server     INFO  Started 2026/01/02 13:55:00 WIB on port 3030
```

Buka browser dan akses: **http://localhost:3030**

Anda akan melihat halaman web Fuseki.

---

## 3. Membuat Dataset

Dataset adalah tempat penyimpanan data RDF di Fuseki.

### Langkah-langkah:

1. Di halaman Fuseki (http://localhost:3030), klik tab **"Manage datasets"**

2. Klik tombol **"Add new dataset"**

3. Isi form:
   - **Dataset name**: `uriblog` (harus lowercase, tanpa spasi)
   - **Dataset type**: Pilih **"Persistent (TDB2)"**
   
4. Klik **"Create dataset"**

5. Dataset `uriblog` akan muncul di daftar

**Screenshot lokasi:**
```
┌─────────────────────────────────────┐
│  Manage datasets                    │
├─────────────────────────────────────┤
│  [+ Add new dataset]                │
│                                     │
│  Datasets:                          │
│  ✓ /uriblog  [query] [update] ...  │
└─────────────────────────────────────┘
```

---

## 4. Upload Data RDF

Ada 2 cara untuk upload data RDF ke Fuseki:

### Cara 1: Via Web Interface (Manual)

1. Di halaman Fuseki, klik dataset **"uriblog"**

2. Klik tab **"Upload data"**

3. Klik tombol **"Select files..."**

4. Pilih file: `C:\wpucourse\uriblog\storage\app\rdf\uri-blog-data.ttl`

5. **Destination graph**: Biarkan kosong (default graph)

6. Klik **"Upload now"**

7. Tunggu sampai muncul pesan sukses

### Cara 2: Via Laravel Command (Otomatis)

**BELUM DIKONFIGURASI** - Untuk menggunakan command ini, Anda perlu:

1. Edit file `.env`:
   ```env
   FUSEKI_ENDPOINT=http://localhost:3030
   FUSEKI_DATASET=uriblog
   ```

2. Jalankan command:
   ```bash
   php artisan rdf:sync
   ```

**Catatan**: Untuk tugas kuliah, cara manual (Cara 1) sudah cukup.

---

## 5. Testing SPARQL Query

Setelah data ter-upload, mari test dengan SPARQL query.

### Langkah-langkah:

1. Di halaman Fuseki, klik dataset **"uriblog"**

2. Klik tab **"Query"**

3. Hapus query default, lalu paste query ini:

```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?postTitle ?authorName ?categoryName
WHERE {
  ?post a :Post .
  ?post :postTitle ?postTitle .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
  ?post :hasCategory ?category .
  ?category :categoryName ?categoryName .
}
LIMIT 10
```

4. Klik tombol **"Run Query"** (atau tekan Ctrl+Enter)

5. Anda akan melihat hasil query di bagian bawah

### Contoh Hasil yang Diharapkan:

| postTitle | authorName | categoryName |
|-----------|------------|--------------|
| "Judul Post 1" | "Kholil Mustofa" | "Technology" |
| "Judul Post 2" | "John Doe" | "Lifestyle" |
| ... | ... | ... |

---

## Query SPARQL Lainnya

### Query 1: Hitung Total Posts per Category
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?categoryName (COUNT(?post) AS ?totalPosts)
WHERE {
  ?category a :Category .
  ?category :categoryName ?categoryName .
  ?post :hasCategory ?category .
}
GROUP BY ?categoryName
ORDER BY DESC(?totalPosts)
```

### Query 2: Posts Terbaru (10 terakhir)
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?postTitle ?authorName ?publishedDate
WHERE {
  ?post a :Post .
  ?post :postTitle ?postTitle .
  ?post :publishedDate ?publishedDate .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
}
ORDER BY DESC(?publishedDate)
LIMIT 10
```

### Query 3: User yang Sudah Verifikasi Email
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?authorName ?authorEmail
WHERE {
  ?user a :User .
  ?user :authorName ?authorName .
  ?user :authorEmail ?authorEmail .
  ?user :emailVerified true .
}
```

### Query 4: Posts dengan Featured Image
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?postTitle ?postImage ?authorName
WHERE {
  ?post a :Post .
  ?post :postTitle ?postTitle .
  ?post :postImage ?postImage .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
}
LIMIT 10
```

### Query 5: Cari Posts Berdasarkan Kata Kunci
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?postTitle ?postContent
WHERE {
  ?post a :Post .
  ?post :postTitle ?postTitle .
  ?post :postContent ?postContent .
  FILTER(CONTAINS(LCASE(?postTitle), "laravel"))
}
```

---

## Troubleshooting

### Error: "Port 3030 already in use"

**Penyebab**: Fuseki sudah berjalan di background

**Solusi**:
1. Cek proses Java yang berjalan:
   ```bash
   # Windows
   tasklist | findstr java
   
   # Linux/Mac
   ps aux | grep fuseki
   ```
2. Kill proses tersebut atau restart komputer

### Error: "Java not found"

**Penyebab**: Java belum terinstall atau tidak ada di PATH

**Solusi**:
1. Install Java 17+: https://www.oracle.com/java/technologies/downloads/
2. Tambahkan Java ke PATH environment variable

### Data Tidak Muncul di Query

**Penyebab**: Data belum ter-upload atau salah dataset

**Solusi**:
1. Pastikan dataset name benar: `uriblog`
2. Upload ulang file RDF
3. Cek di tab "Info" apakah ada triples:
   ```
   Triples: 1,234
   ```
   Jika 0, berarti data belum ter-upload

### Query Timeout

**Penyebab**: Query terlalu kompleks atau data terlalu besar

**Solusi**:
1. Tambahkan `LIMIT` di akhir query
2. Gunakan filter yang lebih spesifik
3. Tingkatkan memory Fuseki:
   ```bash
   set JVM_ARGS=-Xmx4G
   fuseki-server.bat
   ```

---

## Tips Penggunaan

1. **Backup Data**: Dataset Fuseki tersimpan di folder `run/databases/`. Backup folder ini secara berkala.

2. **Re-upload Data**: Jika ada perubahan di database Laravel:
   ```bash
   php artisan rdf:export
   ```
   Lalu upload ulang file `uri-blog-data.ttl` via web interface.

3. **Multiple Datasets**: Anda bisa membuat dataset lain untuk testing tanpa mengganggu data utama.

4. **SPARQL Editor**: Fuseki web interface punya autocomplete. Tekan Ctrl+Space untuk suggestion.

5. **Export Results**: Hasil query bisa di-export ke CSV/JSON dengan klik tombol download.

---

## Referensi

- Apache Jena Documentation: https://jena.apache.org/documentation/
- SPARQL 1.1 Query Language: https://www.w3.org/TR/sparql11-query/
- Fuseki Configuration: https://jena.apache.org/documentation/fuseki2/

---

## Untuk Presentasi Tugas

Saat presentasi, tunjukkan:

1. ✅ Ontologi OWL di Protégé (optional)
2. ✅ File RDF yang ter-generate (`uri-blog-data.ttl`)
3. ✅ Fuseki server berjalan (http://localhost:3030)
4. ✅ Dataset `uriblog` dengan data
5. ✅ Minimal 3-5 SPARQL query yang berhasil
6. ✅ Hasil query yang menampilkan data real dari aplikasi

---

**Dibuat untuk tugas Web Semantic - uriblog**
