# SPARQL Queries untuk Uri Blog - Tugas Kuliah

## Prefix yang Digunakan
```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
```

---

## 📊 Query 1: Menampilkan Semua Classes

```sparql
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

SELECT DISTINCT ?class ?label ?comment
WHERE {
  ?class rdf:type owl:Class .
  OPTIONAL { ?class rdfs:label ?label }
  OPTIONAL { ?class rdfs:comment ?comment }
}
ORDER BY ?class
```

**Hasil yang Diharapkan:**
- Blog
- Post
- Author
- Category
- Comment
- Tag

---

## 📝 Query 2: Menampilkan Semua Posts dengan Detail

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?post ?title ?slug ?publishedDate
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?title .
  ?post :postSlug ?slug .
  ?post :publishedDate ?publishedDate .
}
ORDER BY DESC(?publishedDate)
```

**Kegunaan:** Menampilkan daftar semua artikel blog

---

## 👤 Query 3: Menampilkan Posts dengan Author

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?postTitle ?authorName ?authorEmail
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?postTitle .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
  ?author :authorEmail ?authorEmail .
}
ORDER BY ?authorName
```

**Kegunaan:** Menampilkan artikel beserta penulisnya

---

## 🏷️ Query 4: Menampilkan Posts dengan Category

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?postTitle ?categoryName ?categoryColor
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?postTitle .
  ?post :hasCategory ?category .
  ?category :categoryName ?categoryName .
  ?category :categoryColor ?categoryColor .
}
ORDER BY ?categoryName
```

**Kegunaan:** Menampilkan artikel berdasarkan kategori

---

## 📊 Query 5: Menghitung Jumlah Posts per Author

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?authorName (COUNT(?post) AS ?totalPosts)
WHERE {
  ?post rdf:type :Post .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
}
GROUP BY ?authorName
ORDER BY DESC(?totalPosts)
```

**Kegunaan:** Statistik produktivitas penulis

---

## 📊 Query 6: Menghitung Jumlah Posts per Category

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?categoryName (COUNT(?post) AS ?totalPosts)
WHERE {
  ?post rdf:type :Post .
  ?post :hasCategory ?category .
  ?category :categoryName ?categoryName .
}
GROUP BY ?categoryName
ORDER BY DESC(?totalPosts)
```

**Kegunaan:** Statistik artikel per kategori

---

## 💬 Query 7: Menampilkan Posts dengan Comments

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?postTitle ?commentContent ?commentDate
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?postTitle .
  ?post :hasComment ?comment .
  ?comment :commentContent ?commentContent .
  ?comment :commentDate ?commentDate .
}
ORDER BY ?commentDate
```

**Kegunaan:** Menampilkan komentar pada artikel

---

## 🔍 Query 8: Mencari Post Berdasarkan Keyword di Title

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?post ?title
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?title .
  FILTER(CONTAINS(LCASE(?title), "laravel"))
}
```

**Kegunaan:** Search functionality

---

## 📅 Query 9: Posts yang Dipublish dalam Periode Tertentu

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>

SELECT ?postTitle ?publishedDate
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?postTitle .
  ?post :publishedDate ?publishedDate .
  FILTER(?publishedDate >= "2025-12-01T00:00:00"^^xsd:dateTime &&
         ?publishedDate <= "2025-12-31T23:59:59"^^xsd:dateTime)
}
ORDER BY DESC(?publishedDate)
```

**Kegunaan:** Filter artikel berdasarkan tanggal

---

## 🏷️ Query 10: Posts dengan Multiple Tags

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?postTitle (GROUP_CONCAT(?tagName; separator=", ") AS ?tags)
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?postTitle .
  ?post :hasTag ?tag .
  ?tag :tagName ?tagName .
}
GROUP BY ?postTitle
```

**Kegunaan:** Menampilkan semua tag untuk setiap artikel

---

## 👥 Query 11: Informasi Lengkap Author

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?authorName ?authorUsername ?authorEmail ?authorBio (COUNT(?post) AS ?totalPosts)
WHERE {
  ?author rdf:type :Author .
  ?author :authorName ?authorName .
  ?author :authorUsername ?authorUsername .
  ?author :authorEmail ?authorEmail .
  OPTIONAL { ?author :authorBio ?authorBio }
  OPTIONAL { 
    ?post :hasAuthor ?author .
  }
}
GROUP BY ?authorName ?authorUsername ?authorEmail ?authorBio
```

**Kegunaan:** Profile lengkap penulis

---

## 🔗 Query 12: Relasi Lengkap Sebuah Post

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?postTitle ?authorName ?categoryName ?commentContent
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?postTitle .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
  ?post :hasCategory ?category .
  ?category :categoryName ?categoryName .
  OPTIONAL {
    ?post :hasComment ?comment .
    ?comment :commentContent ?commentContent .
  }
  FILTER(?postTitle = "Belajar Laravel untuk Pemula")
}
```

**Kegunaan:** Detail lengkap satu artikel

---

## 📊 Query 13: Statistik Keseluruhan Blog

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT 
  (COUNT(DISTINCT ?post) AS ?totalPosts)
  (COUNT(DISTINCT ?author) AS ?totalAuthors)
  (COUNT(DISTINCT ?category) AS ?totalCategories)
  (COUNT(DISTINCT ?comment) AS ?totalComments)
  (COUNT(DISTINCT ?tag) AS ?totalTags)
WHERE {
  OPTIONAL { ?post rdf:type :Post }
  OPTIONAL { ?author rdf:type :Author }
  OPTIONAL { ?category rdf:type :Category }
  OPTIONAL { ?comment rdf:type :Comment }
  OPTIONAL { ?tag rdf:type :Tag }
}
```

**Kegunaan:** Dashboard statistics

---

## 🔍 Query 14: Posts Tanpa Comment

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?postTitle
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?postTitle .
  FILTER NOT EXISTS {
    ?post :hasComment ?comment .
  }
}
```

**Kegunaan:** Menemukan artikel yang belum ada komentar

---

## 📝 Query 15: Posts dengan Paling Banyak Comments

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?postTitle (COUNT(?comment) AS ?commentCount)
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?postTitle .
  ?post :hasComment ?comment .
}
GROUP BY ?postTitle
ORDER BY DESC(?commentCount)
LIMIT 5
```

**Kegunaan:** Top 5 artikel paling populer (berdasarkan komentar)

---

## 🔄 Query 16: Inverse Relationship - Author's Posts

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?authorName ?postTitle
WHERE {
  ?author rdf:type :Author .
  ?author :authorName ?authorName .
  ?post :hasAuthor ?author .
  ?post :postTitle ?postTitle .
}
ORDER BY ?authorName ?postTitle
```

**Kegunaan:** Menampilkan semua artikel per penulis (inverse relationship)

---

## 🎨 Query 17: Categories dengan Warna

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT ?categoryName ?categorySlug ?categoryColor (COUNT(?post) AS ?postCount)
WHERE {
  ?category rdf:type :Category .
  ?category :categoryName ?categoryName .
  ?category :categorySlug ?categorySlug .
  ?category :categoryColor ?categoryColor .
  OPTIONAL {
    ?post :hasCategory ?category .
  }
}
GROUP BY ?categoryName ?categorySlug ?categoryColor
ORDER BY ?categoryName
```

**Kegunaan:** Daftar kategori dengan styling info

---

## 🔍 Query 18: CONSTRUCT - Membuat Graph Baru

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

CONSTRUCT {
  ?post :hasAuthor ?author .
  ?author :authorName ?name .
  ?post :postTitle ?title .
}
WHERE {
  ?post rdf:type :Post .
  ?post :hasAuthor ?author .
  ?author :authorName ?name .
  ?post :postTitle ?title .
}
```

**Kegunaan:** Membuat subset graph (untuk export atau visualisasi)

---

## ❓ Query 19: ASK - Cek Keberadaan Data

```sparql
PREFIX : <http://www.uriblog.com/ontology#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

ASK {
  ?post rdf:type :Post .
  ?post :postTitle "Belajar Laravel untuk Pemula" .
}
```

**Kegunaan:** Validasi keberadaan data tertentu (return true/false)

---

## 📊 Query 20: DESCRIBE - Detail Lengkap Resource

```sparql
PREFIX : <http://www.uriblog.com/ontology#>

DESCRIBE :Post_BelajarLaravel
```

**Kegunaan:** Mendapatkan semua informasi tentang satu resource

---

## 💡 Tips Menggunakan Query

### 1. Testing Query
- Mulai dengan query sederhana
- Tambahkan `LIMIT 10` untuk testing
- Gunakan `OPTIONAL` untuk data yang mungkin tidak ada

### 2. Performance
- Gunakan `FILTER` dengan bijak
- Index pada properties yang sering di-query
- Batasi hasil dengan `LIMIT`

### 3. Debugging
- Cek prefix URI
- Gunakan `SELECT *` untuk melihat semua data
- Test di Fuseki query interface dulu

---

## 📚 Resources

- **SPARQL 1.1 Query**: https://www.w3.org/TR/sparql11-query/
- **SPARQL Examples**: https://www.w3.org/2009/sparql/wiki/Main_Page
- **Fuseki Documentation**: https://jena.apache.org/documentation/fuseki2/

---

**Gunakan query-query ini untuk demonstrasi tugas kuliah Anda! 🎓**
