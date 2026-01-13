# uriblog - Premium Editorial Management System

A modern content management platform built with Laravel 12, featuring a sophisticated Indigo design system and integrated semantic web capabilities.

## ✨ Key Features

- **Premium UI/UX**: Sophisticated Indigo theme with fluid animations and 3D isometric elements
- **Full CRUD Management**: Complete content creation, editing, and deletion workflows
- **Category System**: Organize posts with color-coded categories
- **User Authentication**: Secure login, registration, and email verification
- **Profile Management**: Avatar uploads, password changes, and personal info updates
- **Responsive Design**: Mobile-first approach for all devices
- **Hybrid Search**: SPARQL semantic search with SQL fallback for reliability
- **Semantic Web Integration**: RDF export and SPARQL querying capabilities

## 🧬 Semantic Web Implementation

This project includes a **complete Semantic Web implementation** with:
- OWL 2 ontology for blog domain (Post, Author, Category)
- **Automatic RDF export** from MySQL database
- **Real-time synchronization** with Apache Jena Fuseki (auto-clears and uploads on data changes)
- **Hybrid search system**: Uses SPARQL when Fuseki is online, falls back to SQL when offline
- SPARQL endpoint for advanced queries
- Observer pattern for auto-sync on create/update/delete operations

> 📖 **For complete semantic web documentation, setup guides, and SPARQL examples:**  
> **See [ontology/README.md](ontology/README.md)**

## 🛠️ Tech Stack

**Backend:**
- Laravel 12
- PHP 8.2+
- MySQL
- Apache Jena Fuseki (for semantic web)

**Frontend:**
- Tailwind CSS
- Alpine.js
- Blade Templates
- Material Symbols Icons

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

### Installation

1. **Clone Repository**
   ```bash
   git clone https://github.com/kholilmustofa/uri-blog.git
   cd uri-blog
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Configure your database in `.env`:
   ```
   DB_DATABASE=uriblog
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Run Application**
   ```bash
   npm run dev
   php artisan serve
   ```
   
   Access at: `http://127.0.0.1:8000`

### Optional: Semantic Web Setup

For semantic web features (RDF export & SPARQL queries):

```bash
# Export database to RDF
php artisan rdf:export

# Sync to Fuseki (requires Fuseki server running)
php artisan rdf:sync
```

See [ontology/README.md](ontology/README.md) for detailed Fuseki setup instructions.

## 📁 Project Structure

```
uriblog/
├── app/                    # Laravel application logic
│   ├── Services/          # RDFService, FusekiService
│   ├── Observers/         # Auto-sync observers
│   └── Console/Commands/  # RDF export/sync commands
├── ontology/              # Semantic web documentation
│   ├── README.md          # Complete semantic web guide
│   ├── implementasi.md    # Implementation file structure
│   └── uri-blog-ontology.owl  # OWL ontology
├── resources/views/       # Blade templates
├── storage/app/rdf/       # RDF export files
└── config/semantic.php    # Semantic web configuration
```

## 📚 Documentation

- **Main App**: You're reading it!
- **Semantic Web**: [ontology/README.md](ontology/README.md)
- **Implementation Details**: [ontology/implementasi.md](ontology/implementasi.md)

## 👤 Developer

**Kholil Mustofa**  
GitHub: [@kholilmustofa](https://github.com/kholilmustofa)

## 📄 License

MIT License
