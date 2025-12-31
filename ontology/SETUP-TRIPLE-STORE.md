# Setup Triple Store untuk Uri Blog - Tugas Kuliah Web Semantic

## 📚 Tujuan
Membuat Semantic Web lengkap dengan:
1. ✅ Ontologi OWL (sudah dibuat)
2. ✅ Sample instances (sudah dibuat)
3. ⬜ Triple Store (Apache Jena Fuseki)
4. ⬜ SPARQL Endpoint
5. ⬜ Query Interface

---

## 🚀 Langkah 1: Download & Install Apache Jena Fuseki

### Download
1. Kunjungi: https://jena.apache.org/download/
2. Download: **Apache Jena Fuseki 5.6.0** (atau versi terbaru)
   - File: `apache-jena-fuseki-5.6.0.zip` (untuk Windows)
3. Extract ke folder: `C:\fuseki` atau `C:\Program Files\fuseki`

### Persyaratan
- **Java 17 atau lebih baru** harus terinstall
- Cek dengan: `java -version`
- Jika belum ada, download dari: https://www.oracle.com/java/technologies/downloads/

---

## 🚀 Langkah 2: Jalankan Fuseki Server

### Windows (Command Prompt)
```cmd
cd C:\fuseki\apache-jena-fuseki-5.6.0
fuseki-server.bat
```

### Windows (PowerShell)
```powershell
cd C:\fuseki\apache-jena-fuseki-5.6.0
.\fuseki-server.bat
```

### Linux/Mac
```bash
cd /path/to/fuseki
./fuseki-server
```

### Output yang Diharapkan
```
[2025-12-31 18:56:00] Server     INFO  Apache Jena Fuseki 5.6.0
[2025-12-31 18:56:00] Server     INFO  Fuseki Server started on port 3030
[2025-12-31 18:56:00] Server     INFO  http://localhost:3030/
```

---

## 🚀 Langkah 3: Akses Fuseki Web Interface

1. **Buka browser**
2. **Navigate ke**: http://localhost:3030
3. **Login** (jika diminta):
   - Username: `admin`
   - Password: `admin` (atau buat password baru)

---

## 🚀 Langkah 4: Buat Dataset Baru

### Via Web Interface
1. Klik **"Manage datasets"**
2. Klik **"Add new dataset"**
3. Isi form:
   - **Dataset name**: `uriblog`
   - **Dataset type**: **Persistent (TDB2)**
4. Klik **"Create dataset"**

### Via Command Line (Alternatif)
```bash
cd C:\fuseki\apache-jena-fuseki-5.6.0
fuseki-server --update --mem /uriblog
```

---

## 🚀 Langkah 5: Upload Ontologi ke Fuseki

### Metode 1: Via Web Interface (Recommended)

1. **Buka**: http://localhost:3030
2. **Pilih dataset**: `uriblog`
3. **Klik tab**: "upload data"
4. **Upload file**:
   - **File 1**: `uri-blog-ontology.owl`
     - Select file
     - Graph name: `http://www.uriblog.com/ontology`
     - Klik "Upload"
   - **File 2**: `uri-blog-instances.ttl`
     - Select file
     - Graph name: `http://www.uriblog.com/data`
     - Klik "Upload"

### Metode 2: Via Command Line

```bash
# Upload ontology
curl -X POST \
  -H "Content-Type: application/rdf+xml" \
  --data-binary @uri-blog-ontology.owl \
  http://localhost:3030/uriblog/data?graph=http://www.uriblog.com/ontology

# Upload instances
curl -X POST \
  -H "Content-Type: text/turtle" \
  --data-binary @uri-blog-instances.ttl \
  http://localhost:3030/uriblog/data?graph=http://www.uriblog.com/data
```

### Metode 3: Via s-put (Fuseki CLI)

```bash
cd C:\wpucourse\uriblog\ontology

# Upload ontology
s-put http://localhost:3030/uriblog/data http://www.uriblog.com/ontology uri-blog-ontology.owl

# Upload instances
s-put http://localhost:3030/uriblog/data http://www.uriblog.com/data uri-blog-instances.ttl
```

---

## 🚀 Langkah 6: Test SPARQL Query

### Via Web Interface

1. **Buka**: http://localhost:3030
2. **Pilih dataset**: `uriblog`
3. **Klik tab**: "query"
4. **Masukkan query**:

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

# Query 1: Get all classes
SELECT ?class
WHERE {
  ?class rdf:type owl:Class .
}
```

5. **Klik**: "Run query"

### Contoh Query Lainnya

#### Query 2: Get all posts with authors
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?post ?title ?authorName
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?title .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
}
```

#### Query 3: Get posts by category
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?post ?title ?categoryName
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?title .
  ?post :hasCategory ?category .
  ?category :categoryName ?categoryName .
}
ORDER BY ?categoryName
```

#### Query 4: Count posts per author
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?authorName (COUNT(?post) AS ?postCount)
WHERE {
  ?post rdf:type :Post .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
}
GROUP BY ?authorName
ORDER BY DESC(?postCount)
```

#### Query 5: Get posts with comments
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?postTitle ?commentContent ?commentDate
WHERE {
  ?post :postTitle ?postTitle .
  ?post :hasComment ?comment .
  ?comment :commentContent ?commentContent .
  ?comment :commentDate ?commentDate .
}
ORDER BY ?commentDate
```

---

## 🚀 Langkah 7: Test SPARQL Endpoint via API

### GET Request (SELECT Query)
```bash
curl -G http://localhost:3030/uriblog/sparql \
  --data-urlencode "query=PREFIX : <http://www.uriblog.com/ontology#> SELECT * WHERE { ?s ?p ?o } LIMIT 10"
```

### POST Request (UPDATE Query)
```bash
curl -X POST http://localhost:3030/uriblog/update \
  -H "Content-Type: application/sparql-update" \
  --data "PREFIX : <http://www.uriblog.com/ontology#> INSERT DATA { :NewPost rdf:type :Post }"
```

---

## 📊 Langkah 8: Verifikasi Data

### Cek Jumlah Triples
```sparql
SELECT (COUNT(*) AS ?count)
WHERE {
  ?s ?p ?o
}
```

### Cek Semua Classes
```sparql
PREFIX owl: <http://www.w3.org/2002/07/owl#>

SELECT DISTINCT ?class
WHERE {
  ?class rdf:type owl:Class .
}
```

### Cek Semua Individuals
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT DISTINCT ?individual ?type
WHERE {
  ?individual rdf:type ?type .
  FILTER(?type != owl:NamedIndividual)
}
```

---

## 📝 Langkah 9: Dokumentasi untuk Tugas

### Screenshot yang Perlu Diambil:

1. **Fuseki Dashboard**
   - http://localhost:3030
   - Tampilkan dataset `uriblog`

2. **Upload Data**
   - Screenshot proses upload ontology
   - Screenshot proses upload instances

3. **SPARQL Query Interface**
   - Screenshot query editor
   - Screenshot hasil query (minimal 3 query berbeda)

4. **Query Results**
   - Query 1: Semua posts
   - Query 2: Posts dengan authors
   - Query 3: Posts per category
   - Query 4: Count statistics

### File yang Perlu Diserahkan:

1. ✅ `uri-blog-ontology.owl` - Ontologi
2. ✅ `uri-blog-instances.ttl` - Data instances
3. ✅ `README.md` - Dokumentasi ontologi
4. ✅ `SETUP-TRIPLE-STORE.md` - Panduan setup (file ini)
5. ⬜ **Screenshot** - Fuseki interface & query results
6. ⬜ **SPARQL Queries** - Kumpulan query yang digunakan
7. ⬜ **Laporan** - Penjelasan ontologi dan implementasi

---

## 🎓 Langkah 10: Buat Laporan Tugas

### Struktur Laporan yang Disarankan:

#### 1. Pendahuluan
- Latar belakang Semantic Web
- Tujuan pembuatan ontologi Uri Blog

#### 2. Perancangan Ontologi
- Diagram ontologi (gunakan gambar yang sudah di-generate)
- Penjelasan classes
- Penjelasan object properties
- Penjelasan data properties

#### 3. Implementasi
- Tools yang digunakan (Protégé, Fuseki)
- Proses pembuatan ontologi
- Proses upload ke triple store

#### 4. Testing & Query
- Contoh SPARQL queries
- Hasil query dengan screenshot
- Analisis hasil

#### 5. Kesimpulan
- Manfaat Semantic Web untuk blog
- Kemungkinan pengembangan

---

## 🔧 Troubleshooting

### Fuseki tidak bisa start
```bash
# Cek apakah port 3030 sudah digunakan
netstat -ano | findstr :3030

# Atau jalankan di port lain
fuseki-server --port=3031
```

### Upload gagal
- Pastikan file format benar (.owl atau .ttl)
- Cek syntax error di Protégé dulu
- Gunakan validator: http://www.easyrdf.org/converter

### Query tidak ada hasil
- Pastikan data sudah ter-upload
- Cek prefix URI yang digunakan
- Gunakan query sederhana dulu: `SELECT * WHERE { ?s ?p ?o } LIMIT 10`

---

## 📚 Resources Tambahan

- **Apache Jena Fuseki**: https://jena.apache.org/documentation/fuseki2/
- **SPARQL Tutorial**: https://www.w3.org/TR/sparql11-query/
- **Protégé Tutorial**: https://protege.stanford.edu/tutorials/
- **RDF Validator**: http://www.easyrdf.org/converter

---

## ✅ Checklist Tugas

- [ ] Download & install Java 17+
- [ ] Download & install Apache Jena Fuseki
- [ ] Jalankan Fuseki server
- [ ] Buat dataset `uriblog`
- [ ] Upload `uri-blog-ontology.owl`
- [ ] Upload `uri-blog-instances.ttl`
- [ ] Test minimal 5 SPARQL queries
- [ ] Screenshot semua langkah
- [ ] Buat laporan tugas
- [ ] Siapkan presentasi (jika perlu)

---

## 🎯 Tips untuk Presentasi

1. **Demo Live**:
   - Jalankan Fuseki
   - Tunjukkan query interface
   - Execute query real-time

2. **Jelaskan Ontologi**:
   - Tampilkan diagram
   - Jelaskan relasi antar classes
   - Tunjukkan di Protégé

3. **Tunjukkan Hasil Query**:
   - Query sederhana → kompleks
   - Jelaskan syntax SPARQL
   - Tunjukkan hasil yang meaningful

---

**Semoga sukses dengan tugas kuliah Web Semantic Anda! 🎓🚀**

Jika ada pertanyaan atau kendala, silakan tanya!
