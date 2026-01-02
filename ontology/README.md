# uriblog Ontology Documentation

## Overview

The uriblog ontology is a formal representation of the knowledge domain for the uriblog premium editorial management system. It defines the core concepts (classes), their properties (attributes), and the relationships between them using OWL (Web Ontology Language).

## Ontology Information

- **Namespace**: http://www.uriblog.com/ontology#
- **Version**: 2.0
- **Creator**: Kholil Mustofa
- **Description**: An ontology for representing blog posts, authors, categories, and their relationships in uriblog

## Classes

### 1. Blog
Represents the uriblog platform itself.

**Properties**:
- `blogName` (string): The name of the blog
- `blogDescription` (string): A description of the blog
- `blogURL` (anyURI): The URL of the blog website

**Relationships**:
- `containsPost`: Links the blog to its posts

### 2. User
Represents a registered user who can create and manage posts.

**Properties**:
- `authorName` (string): The full name of the user
- `authorUsername` (string): The unique username
- `authorEmail` (string): The email address
- `authorAvatar` (string): Path to the user's avatar image
- `emailVerified` (boolean): Indicates if the user's email has been verified

**Relationships**:
- `writtenBy`: Links the user to posts they have written

### 3. Post
Represents a blog post article with title, content, and metadata.

**Properties**:
- `postTitle` (string): The title of the post
- `postContent` (string): The main content/body of the post
- `postSlug` (string): URL-friendly identifier for the post
- `postImage` (string): Path to the post's featured image
- `publishedDate` (dateTime): Date and time when the post was created
- `updatedDate` (dateTime): Date and time when the post was last updated

**Relationships**:
- `hasAuthor`: Links the post to its author (User)
- `hasCategory`: Links the post to its category
- `belongsToCategory`: Inverse relationship to category

### 4. Category
Represents a content category for organizing posts.

**Properties**:
- `categoryName` (string): The name of the category
- `categorySlug` (string): URL-friendly identifier for the category
- `categoryColor` (string): Hex color code for category badge display

**Relationships**:
- `hasCategory`: Inverse relationship from posts

## Object Properties

### hasAuthor
- **Domain**: Post
- **Range**: User
- **Description**: Relates a post to its author
- **Inverse**: writtenBy

### writtenBy
- **Domain**: User
- **Range**: Post
- **Description**: Relates a user to their posts
- **Inverse**: hasAuthor

### hasCategory
- **Domain**: Post
- **Range**: Category
- **Description**: Relates a post to its category
- **Inverse**: belongsToCategory

### belongsToCategory
- **Domain**: Post
- **Range**: Category
- **Description**: Relates a post to the category it belongs to
- **Inverse**: hasCategory

### containsPost
- **Domain**: Blog
- **Range**: Post
- **Description**: Relates the blog to its posts

## Data Properties Summary

| Property | Domain | Range | Description |
|----------|--------|-------|-------------|
| authorName | User | string | Full name of the user |
| authorUsername | User | string | Unique username |
| authorEmail | User | string | Email address |
| authorAvatar | User | string | Path to avatar image |
| emailVerified | User | boolean | Email verification status |
| blogName | Blog | string | Name of the blog |
| blogDescription | Blog | string | Blog description |
| blogURL | Blog | anyURI | Blog website URL |
| categoryName | Category | string | Category name |
| categorySlug | Category | string | URL-friendly category identifier |
| categoryColor | Category | string | Hex color code for UI |
| postTitle | Post | string | Post title |
| postContent | Post | string | Post body content |
| postSlug | Post | string | URL-friendly post identifier |
| postImage | Post | string | Path to featured image |
| publishedDate | Post | dateTime | Creation timestamp |
| updatedDate | Post | dateTime | Last update timestamp |

## Usage with Apache Jena Fuseki

### 1. Setting Up Fuseki

Download and install Apache Jena Fuseki from: https://jena.apache.org/download/

Start the Fuseki server:
```bash
cd apache-jena-fuseki-x.x.x
./fuseki-server
```

Access the web interface at: http://localhost:3030

### 2. Creating a Dataset

1. Open the Fuseki web interface
2. Click "Manage datasets"
3. Click "Add new dataset"
4. Enter dataset name: `uriblog`
5. Select "Persistent (TDB2)"
6. Click "Create dataset"

### 3. Uploading the Ontology

1. Select the `uriblog` dataset
2. Click "Upload data"
3. Select the file: `ontology/uri-blog-ontology.owl`
4. Choose format: "RDF/XML"
5. Click "Upload"

### 4. Example SPARQL Queries

#### Query 1: Get All Posts with Authors
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
```

#### Query 2: Get Posts by Specific Author
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?postTitle ?publishedDate
WHERE {
  ?post a :Post .
  ?post :postTitle ?postTitle .
  ?post :publishedDate ?publishedDate .
  ?post :hasAuthor ?author .
  ?author :authorUsername "kholil" .
}
ORDER BY DESC(?publishedDate)
```

#### Query 3: Get All Categories with Post Count
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?categoryName (COUNT(?post) AS ?postCount)
WHERE {
  ?category a :Category .
  ?category :categoryName ?categoryName .
  ?post :hasCategory ?category .
}
GROUP BY ?categoryName
ORDER BY DESC(?postCount)
```

#### Query 4: Get Recent Posts with Images
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?postTitle ?postImage ?publishedDate ?authorName
WHERE {
  ?post a :Post .
  ?post :postTitle ?postTitle .
  ?post :postImage ?postImage .
  ?post :publishedDate ?publishedDate .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
  FILTER(BOUND(?postImage))
}
ORDER BY DESC(?publishedDate)
LIMIT 10
```

#### Query 5: Get Verified Authors
```sparql
PREFIX : <http://www.uriblog.com/ontology#>

SELECT ?authorName ?authorEmail ?authorUsername
WHERE {
  ?author a :User .
  ?author :authorName ?authorName .
  ?author :authorEmail ?authorEmail .
  ?author :authorUsername ?authorUsername .
  ?author :emailVerified true .
}
```

## Automatic RDF Synchronization

The uriblog application includes a **complete automatic synchronization system** that:
1. Exports data to RDF format whenever changes occur
2. Automatically syncs to Fuseki if the server is available

This eliminates the need for manual export and sync in most cases.

### How Auto-Sync Works

The system uses Laravel's Event and Observer patterns:

1. **Model Observers**: Monitor changes to Post, User, and Category models
2. **Event Dispatch**: When data changes, a `DataChanged` event is fired
3. **Listener Action**: The `ExportToRDF` listener:
   - Generates and saves the RDF file
   - Checks if Fuseki is available
   - Uploads to Fuseki automatically if online
4. **Real-time Sync**: Changes are reflected in both RDF file and Fuseki immediately

### Monitored Actions

Auto-sync triggers on these operations:
- **Post**: Created, Updated, Deleted
- **User**: Created, Updated, Deleted  
- **Category**: Created, Updated, Deleted

### Example Workflow

```
User creates a new post
    ↓
PostObserver detects creation
    ↓
DataChanged event fired
    ↓
ExportToRDF listener activated
    ↓
RDF file automatically generated
    ↓
storage/rdf/uri-blog-data.ttl updated
    ↓
Check if Fuseki is online
    ↓
If online: Upload to Fuseki automatically
    ↓
Done! (No manual intervention needed)
```

### Viewing Auto-Sync Logs

Check the Laravel log for auto-sync activity:
```bash
tail -f storage/logs/laravel.log | grep "RDF auto"
```

You'll see logs like:
```
RDF auto-exported: Post created
RDF auto-synced to Fuseki: Post created
```

### When Manual Sync is Needed

You only need to run manual commands if:

1. **Fuseki was offline** during data changes:
   ```bash
   php artisan rdf:sync
   ```

2. **Bulk import** of existing data:
   ```bash
   php artisan rdf:export
   php artisan rdf:sync
   ```

3. **Force re-export** everything:
   ```bash
   php artisan rdf:sync --export --clear
   ```

### Disabling Auto-Sync

If you need to temporarily disable auto-sync (e.g., during bulk imports), comment out the observer registration in `app/Providers/AppServiceProvider.php`:

```php
// \App\Models\Post::observe(\App\Observers\PostObserver::class);
```

## Exporting Data from Laravel to RDF

The uriblog application includes built-in commands to export database data to RDF format:

### Export All Data
```bash
php artisan rdf:export
```

This will generate RDF/Turtle files in the `storage/rdf/` directory.


### Sync with Fuseki
```bash
php artisan rdf:sync
```

This command will:
1. Export data from the database
2. Upload it to the configured Fuseki endpoint
3. Update the triple store with the latest data

## Configuration

Edit `config/semantic.php` to configure Fuseki connection:

```php
return [
    'fuseki' => [
        'endpoint' => env('FUSEKI_ENDPOINT', 'http://localhost:3030'),
        'dataset' => env('FUSEKI_DATASET', 'uriblog'),
    ],
];
```

## Ontology Design Decisions

1. **Simplified Structure**: Removed Comment and Tag classes as they are not currently implemented in the application
2. **User-Centric Model**: User class represents registered members who create content
3. **Added Modern Features**: Included properties for avatar images, post images, and email verification
4. **Self-Contained Ontology**: No external vocabulary dependencies, making it easier to understand and maintain
5. **Practical Properties**: All properties map directly to database columns for easy synchronization

## Tools for Working with the Ontology

### Protégé
A free, open-source ontology editor for viewing and editing OWL files.

Download: https://protege.stanford.edu/

To open the ontology:
1. Launch Protégé
2. File > Open
3. Select `ontology/uri-blog-ontology.owl`

### Useful Protégé Views
- **Classes**: View the class hierarchy
- **Object Properties**: See relationships between classes
- **Data Properties**: View attributes of classes
- **Individuals**: See instance data (if any)
- **DL Query**: Run description logic queries

## Further Reading

- OWL 2 Web Ontology Language: https://www.w3.org/TR/owl2-overview/
- SPARQL 1.1 Query Language: https://www.w3.org/TR/sparql11-query/
- Apache Jena Documentation: https://jena.apache.org/documentation/
- RDF 1.1 Primer: https://www.w3.org/TR/rdf11-primer/

## License

This ontology is part of the uriblog project and is licensed under the MIT License.
