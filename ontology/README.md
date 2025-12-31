# Uri Blog Ontology - Semantic Web Documentation

## 📚 Overview

This ontology represents the domain model for **Uri Blog**, a semantic web-enabled blog system. It defines the structure and relationships between blog posts, authors, categories, comments, and tags using OWL (Web Ontology Language).

## 🎯 Purpose

The Uri Blog Ontology enables:
- **Machine-readable** blog content
- **Semantic search** and querying with SPARQL
- **Knowledge graph** representation of blog data
- **Interoperability** with other semantic web applications
- **Automated reasoning** about blog relationships

## 📁 Files

1. **uri-blog-ontology.owl** - Main ontology file (OWL/RDF XML format)
2. **uri-blog-instances.ttl** - Sample data instances (Turtle format)
3. **README.md** - This documentation

## 🏗️ Ontology Structure

### Classes

| Class | Description |
|-------|-------------|
| `Blog` | Represents the blog website itself |
| `Post` | Represents a blog post article |
| `Author` | Represents a blog post author (subclass of foaf:Person) |
| `Category` | Represents a blog post category |
| `Comment` | Represents a comment on a blog post |
| `Tag` | Represents a tag for categorizing posts |

### Object Properties

| Property | Domain | Range | Description |
|----------|--------|-------|-------------|
| `hasAuthor` | Post | Author | Relates a post to its author |
| `writtenBy` | Author | Post | Inverse of hasAuthor |
| `hasCategory` | Post | Category | Relates a post to its category |
| `belongsToCategory` | Category | Post | Inverse of hasCategory |
| `hasComment` | Post | Comment | Relates a post to its comments |
| `commentOn` | Comment | Post | Inverse of hasComment |
| `hasTag` | Post | Tag | Relates a post to its tags |
| `containsPost` | Blog | Post | Relates a blog to its posts |

### Data Properties

#### Post Properties
- `postTitle` (string) - Title of the post
- `postContent` (string) - Content of the post
- `postSlug` (string) - URL-friendly slug
- `publishedDate` (dateTime) - Publication date
- `updatedDate` (dateTime) - Last update date

#### Author Properties
- `authorName` (string) - Author's full name
- `authorEmail` (string) - Author's email
- `authorUsername` (string) - Author's username
- `authorBio` (string) - Author's biography

#### Category Properties
- `categoryName` (string) - Category name
- `categorySlug` (string) - URL-friendly slug
- `categoryColor` (string) - Display color (CSS class)

#### Comment Properties
- `commentContent` (string) - Comment text
- `commentDate` (dateTime) - Comment date

#### Tag Properties
- `tagName` (string) - Tag name

#### Blog Properties
- `blogName` (string) - Blog name
- `blogDescription` (string) - Blog description
- `blogURL` (anyURI) - Blog URL

## 🚀 How to Use with Protégé

### Step 1: Open Ontology in Protégé

1. **Launch Protégé** (Desktop version)
2. **File → Open**
3. Navigate to: `C:\wpucourse\uriblog\ontology\uri-blog-ontology.owl`
4. Click **Open**

### Step 2: Explore the Ontology

#### View Classes
1. Click on **Entities** tab
2. Select **Classes** tab
3. You'll see the class hierarchy:
   ```
   owl:Thing
   ├── Blog
   ├── Post
   ├── Author (subclass of foaf:Person)
   ├── Category
   ├── Comment
   └── Tag
   ```

#### View Object Properties
1. Click on **Object properties** tab
2. Explore relationships like:
   - `hasAuthor`
   - `hasCategory`
   - `hasComment`
   - `hasTag`

#### View Data Properties
1. Click on **Data properties** tab
2. See properties like:
   - `postTitle`
   - `authorName`
   - `categoryName`
   - etc.

### Step 3: Import Sample Data

1. **File → Open** (in Protégé)
2. Select: `uri-blog-instances.ttl`
3. Or **File → Import** to merge with existing ontology

### Step 4: View Individuals (Instances)

1. Click on **Individuals** tab
2. You'll see sample instances:
   - **Blog**: UriBlog
   - **Authors**: Author_KholilMustofa, Author_JohnDoe
   - **Categories**: Category_Laravel, Category_WebDevelopment, etc.
   - **Posts**: Post_BelajarLaravel, Post_SemanticWebIntro, etc.
   - **Comments**: Comment_1, Comment_2, Comment_3

### Step 5: Run Reasoner

1. **Reasoner → HermiT** (or Pellet)
2. Click **Start reasoner**
3. The reasoner will infer:
   - Inverse relationships (e.g., `writtenBy` from `hasAuthor`)
   - Class memberships
   - Consistency checking

### Step 6: Query with SPARQL (Optional)

If using Protégé with SPARQL plugin:

```sparql
PREFIX : <http://www.uriblog.com/ontology#>

# Get all posts with their authors
SELECT ?post ?title ?author ?authorName
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?title .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
}
```

## 📊 Visualization

### OntoGraf Plugin
1. **Window → Tabs → OntoGraf**
2. Drag classes to visualize relationships
3. See the knowledge graph structure

### Class Hierarchy
```
owl:Thing
├── Blog
│   └── UriBlog (instance)
├── Post
│   ├── Post_BelajarLaravel
│   ├── Post_SemanticWebIntro
│   ├── Post_WebDevTips
│   └── Post_LaravelTutorial
├── Author (subclass of foaf:Person)
│   ├── Author_KholilMustofa
│   └── Author_JohnDoe
├── Category
│   ├── Category_Laravel
│   ├── Category_WebDevelopment
│   ├── Category_Tutorial
│   └── Category_Technology
├── Comment
│   ├── Comment_1
│   ├── Comment_2
│   └── Comment_3
└── Tag
    ├── Tag_PHP
    ├── Tag_JavaScript
    ├── Tag_SemanticWeb
    ├── Tag_OWL
    └── Tag_RDF
```

## 🔍 Example Queries

### SPARQL Queries

#### 1. Get all posts by a specific author
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?post ?title
WHERE {
  ?post :hasAuthor :Author_KholilMustofa .
  ?post :postTitle ?title .
}
```

#### 2. Get all posts in a category
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?post ?title
WHERE {
  ?post :hasCategory :Category_Laravel .
  ?post :postTitle ?title .
}
```

#### 3. Get posts with comments
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?post ?title ?comment
WHERE {
  ?post :postTitle ?title .
  ?post :hasComment ?commentObj .
  ?commentObj :commentContent ?comment .
}
```

#### 4. Count posts per category
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?category ?categoryName (COUNT(?post) AS ?postCount)
WHERE {
  ?post :hasCategory ?category .
  ?category :categoryName ?categoryName .
}
GROUP BY ?category ?categoryName
```

## 🔗 Integration with Laravel

### Option 1: Export to RDF/XML
1. In Protégé: **File → Save as...**
2. Choose format: **RDF/XML**
3. Use in Laravel with RDF libraries

### Option 2: SPARQL Endpoint
1. Use Apache Jena Fuseki or GraphDB
2. Load ontology + instances
3. Query from Laravel using SPARQL client

### Option 3: Generate from Database
Create a Laravel command to export database to RDF:

```php
// app/Console/Commands/ExportToRDF.php
public function handle()
{
    $posts = Post::with(['author', 'category'])->get();
    
    // Generate RDF triples
    foreach ($posts as $post) {
        // Create RDF statements
    }
}
```

## 📚 Resources

- **Protégé**: https://protege.stanford.edu/
- **OWL 2 Primer**: https://www.w3.org/TR/owl2-primer/
- **SPARQL Tutorial**: https://www.w3.org/TR/sparql11-query/
- **Apache Jena**: https://jena.apache.org/
- **RDF PHP Library**: https://github.com/easyrdf/easyrdf

## 🎓 Learning Path

1. ✅ **Understand the ontology structure** in Protégé
2. ✅ **Add more instances** (your actual blog data)
3. ✅ **Run reasoner** to infer relationships
4. ✅ **Practice SPARQL queries**
5. ⬜ **Integrate with Laravel** (optional)
6. ⬜ **Deploy to triple store** (optional)

## 🤝 Contributing

To extend this ontology:

1. Open in Protégé
2. Add new classes, properties, or instances
3. Run reasoner to check consistency
4. Save and document changes

## 📝 License

This ontology is part of the Uri Blog project.

## 👨‍💻 Author

**Kholil Mustofa**
- GitHub: [@kholilmustofa](https://github.com/kholilmustofa)
- Repository: https://github.com/kholilmustofa/uri-blog

---

**Happy Semantic Web Building! 🚀**
