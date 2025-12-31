# Uri Blog - Semantic Web Blog Application

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/Semantic_Web-OWL-blue?style=for-the-badge" alt="Semantic Web">
  <img src="https://img.shields.io/badge/Protégé-5.6-green?style=for-the-badge" alt="Protégé">
  <img src="https://img.shields.io/badge/Apache_Jena-Fuseki-orange?style=for-the-badge" alt="Fuseki">
</p>

## Tentang Project

**Uri Blog** adalah aplikasi blog berbasis Laravel yang diintegrasikan dengan teknologi **Semantic Web**. Project ini dibuat sebagai tugas kuliah Web Semantic yang menggabungkan pengembangan web modern dengan konsep knowledge graph dan ontologi.

### Tujuan Project

1. Membangun aplikasi blog fungsional dengan Laravel
2. Membuat ontologi OWL untuk domain blog
3. Mengimplementasikan Semantic Web dengan triple store
4. Menyediakan SPARQL endpoint untuk query semantic data
5. Mendemonstrasikan integrasi web tradisional dengan Semantic Web

## Fitur Utama

### Web Application (Laravel)
- **Authentication & Authorization** - Login, register, dan manajemen user
- **CRUD Posts** - Create, read, update, delete artikel blog
- **Categories & Tags** - Kategorisasi artikel
- **Author Management** - Profil penulis
- **Responsive Design** - Mobile-friendly dengan Tailwind CSS
- **Semantic HTML5** - Struktur HTML yang semantic
- **SEO Optimized** - Meta tags dan Schema.org markup

### Semantic Web Features
- **OWL Ontology** - Ontologi lengkap untuk domain blog
- **RDF Data** - Data dalam format RDF/Turtle
- **Triple Store** - Apache Jena Fuseki integration
- **SPARQL Endpoint** - Query interface untuk semantic data
- **Knowledge Graph** - Representasi relasi antar entitas

## Teknologi yang Digunakan

### Backend
- **Laravel 11.x** - PHP Framework
- **MySQL** - Relational Database
- **PHP 8.2+** - Programming Language

### Frontend
- **Blade Templates** - Laravel templating engine
- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework
- **Flowbite** - UI components

### Semantic Web Stack
- **Protégé 5.6** - Ontology editor
- **Apache Jena Fuseki** - Triple store & SPARQL server
- **OWL 2** - Web Ontology Language
- **RDF/Turtle** - Data serialization formats
- **SPARQL 1.1** - Query language

## Struktur Project

```
uri-blog/
├── app/                    # Laravel application code
├── database/              # Migrations, seeders, factories
├── public/                # Public assets
├── resources/
│   ├── views/            # Blade templates (Semantic HTML5)
│   └── css/              # Stylesheets
├── routes/               # Web routes
├── ontology/             # Semantic Web Files
│   ├── uri-blog-ontology.owl      # OWL Ontology
│   ├── uri-blog-instances.ttl     # Sample RDF data
│   ├── README.md                  # Ontology documentation
│   ├── SETUP-TRIPLE-STORE.md      # Fuseki setup guide
│   └── SPARQL-QUERIES.md          # Query examples
└── README.md             # This file
```

## Instalasi & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL
- Java 17+ (untuk Fuseki)
- Apache Jena Fuseki
- Protégé (opsional, untuk editing ontology)

### 1. Clone Repository
```bash
git clone https://github.com/kholilmustofa/uri-blog.git
cd uri-blog
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uriblog
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migration
```bash
# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed
```

### 5. Build Assets
```bash
npm run dev
```

### 6. Run Application
```bash
php artisan serve
```

Buka browser: http://127.0.0.1:8000

## Setup Semantic Web (Triple Store)

### 1. Install Apache Jena Fuseki
- Download dari: https://jena.apache.org/download/
- Extract ke folder (misal: `C:\fuseki`)

### 2. Jalankan Fuseki Server
```bash
cd C:\fuseki\apache-jena-fuseki-5.6.0
fuseki-server.bat
```

### 3. Akses Fuseki Web Interface
Buka browser: http://localhost:3030

### 4. Upload Ontology
1. Buat dataset baru: `uriblog`
2. Upload file:
   - `ontology/uri-blog-ontology.owl`
   - `ontology/uri-blog-instances.ttl`

### 5. Test SPARQL Query
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

**Dokumentasi lengkap**: Lihat `ontology/SETUP-TRIPLE-STORE.md`

## Ontologi Uri Blog

### Classes
- **Blog** - Representasi website blog
- **Post** - Artikel blog
- **Author** - Penulis artikel
- **Category** - Kategori artikel
- **Comment** - Komentar pada artikel
- **Tag** - Tag untuk artikel

### Object Properties
- `hasAuthor` - Menghubungkan post dengan author
- `hasCategory` - Menghubungkan post dengan category
- `hasComment` - Menghubungkan post dengan comment
- `hasTag` - Menghubungkan post dengan tag
- `containsPost` - Menghubungkan blog dengan posts

### Data Properties
- Post: `postTitle`, `postContent`, `postSlug`, `publishedDate`
- Author: `authorName`, `authorEmail`, `authorUsername`
- Category: `categoryName`, `categorySlug`, `categoryColor`
- Comment: `commentContent`, `commentDate`

**Dokumentasi lengkap**: Lihat `ontology/README.md`

## Contoh SPARQL Queries

### Query 1: Semua Posts dengan Authors
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?postTitle ?authorName
WHERE {
  ?post :postTitle ?postTitle .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
}
```

### Query 2: Statistik Posts per Category
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?categoryName (COUNT(?post) AS ?total)
WHERE {
  ?post :hasCategory ?category .
  ?category :categoryName ?categoryName .
}
GROUP BY ?categoryName
```

**20+ Query examples**: Lihat `ontology/SPARQL-QUERIES.md`

## Tugas Kuliah - Checklist

- [x] Membuat aplikasi web dengan Laravel
- [x] Implementasi Semantic HTML5
- [x] Membuat ontologi OWL dengan Protégé
- [x] Mendefinisikan classes dan properties
- [x] Membuat sample instances
- [x] Setup Apache Jena Fuseki
- [x] Upload data ke triple store
- [x] Membuat SPARQL queries
- [x] Dokumentasi lengkap
- [ ] Screenshot demonstrasi
- [ ] Laporan tugas

## Screenshots

### Web Application
![Home Page](docs/screenshots/home.png)
![Blog Posts](docs/screenshots/posts.png)

### Protégé - Ontology Editor
![Ontology Classes](docs/screenshots/protege-classes.png)

### Fuseki - SPARQL Interface
![SPARQL Query](docs/screenshots/fuseki-query.png)

## Dokumentasi

- **[Ontology Documentation](ontology/README.md)** - Penjelasan lengkap ontologi
- **[Triple Store Setup](ontology/SETUP-TRIPLE-STORE.md)** - Panduan setup Fuseki
- **[SPARQL Queries](ontology/SPARQL-QUERIES.md)** - Kumpulan query examples

## Kontribusi

Project ini dibuat untuk tugas kuliah Web Semantic. Kontribusi dan saran sangat diterima.

## Author

**Kholil Mustofa**
- GitHub: [@kholilmustofa](https://github.com/kholilmustofa)
- Repository: [uri-blog](https://github.com/kholilmustofa/uri-blog)

## License

Project ini menggunakan [MIT License](LICENSE).

## Acknowledgments

- **Dosen Pengampu** - Mata Kuliah Web Semantic
- **Laravel Community** - Framework yang luar biasa
- **Apache Jena** - Triple store & SPARQL engine
- **Protégé** - Ontology editor

---

<p align="center">
  Made with care for Web Semantic Course
</p>

<p align="center">
  <strong>Uri Blog</strong> - Where Traditional Web Meets Semantic Web
</p>
