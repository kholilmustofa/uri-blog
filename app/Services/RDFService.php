<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class RDFService
{
    protected $namespace;
    protected $prefixes;
    protected $triples = [];

    public function __construct()
    {
        $this->namespace = config('semantic.ontology.namespace');
        $this->prefixes = config('semantic.prefixes');
    }

    /**
     * Generate RDF from database
     */
    public function generateRDF(): string
    {
        $this->triples = [];

        // Add prefixes
        $rdf = $this->generatePrefixes();

        // Add blog instance
        $rdf .= $this->generateBlogInstance();

        // Add authors (users)
        $rdf .= $this->generateAuthors();

        // Add categories
        $rdf .= $this->generateCategories();

        // Add posts
        $rdf .= $this->generatePosts();

        return $rdf;
    }

    /**
     * Generate prefixes
     */
    protected function generatePrefixes(): string
    {
        $output = "# RDF Export from Uri Blog Database\n";
        $output .= "# Generated: " . now()->toIso8601String() . "\n\n";

        foreach ($this->prefixes as $prefix => $uri) {
            $prefixName = $prefix === '' ? ':' : $prefix . ':';
            $output .= "@prefix {$prefixName} <{$uri}> .\n";
        }

        $output .= "\n";
        return $output;
    }

    /**
     * Generate blog instance
     */
    protected function generateBlogInstance(): string
    {
        $output = "# ===================================\n";
        $output .= "# Blog Instance\n";
        $output .= "# ===================================\n\n";

        $output .= ":UriBlog rdf:type :Blog ;\n";
        $output .= "    :blogName \"Uri Blog\" ;\n";
        $output .= "    :blogDescription \"Your source for insightful articles and stories\" ;\n";
        $output .= "    :blogURL \"" . config('app.url') . "\"^^xsd:anyURI .\n\n";

        return $output;
    }

    /**
     * Generate users
     */
    protected function generateAuthors(): string
    {
        $output = "# ===================================\n";
        $output .= "# User Instances\n";
        $output .= "# ===================================\n\n";

        $users = User::all();

        foreach ($users as $user) {
            $userId = $this->sanitizeId($user->username ?? $user->name);
            
            $output .= ":User_{$userId} rdf:type :User ;\n";
            $output .= "    :authorName \"{$this->escape($user->name)}\" ;\n";
            $output .= "    :authorUsername \"{$this->escape($user->username ?? $user->email)}\" ;\n";
            $output .= "    :authorEmail \"{$this->escape($user->email)}\" ;\n";
            
            if ($user->avatar) {
                $output .= "    :authorAvatar \"{$this->escape($user->avatar)}\" ;\n";
            }
            
            if ($user->email_verified_at) {
                $output .= "    :emailVerified \"true\"^^xsd:boolean ;\n";
            } else {
                $output .= "    :emailVerified \"false\"^^xsd:boolean ;\n";
            }
            
            $output = rtrim($output, " ;\n") . " .\n\n";
        }

        return $output;
    }

    /**
     * Generate categories
     */
    protected function generateCategories(): string
    {
        $output = "# ===================================\n";
        $output .= "# Category Instances\n";
        $output .= "# ===================================\n\n";

        $categories = Category::all();

        foreach ($categories as $category) {
            $categoryId = $this->sanitizeId($category->slug);
            
            $output .= ":Category_{$categoryId} rdf:type :Category ;\n";
            $output .= "    :categoryName \"{$this->escape($category->name)}\" ;\n";
            $output .= "    :categorySlug \"{$this->escape($category->slug)}\" ;\n";
            
            if (isset($category->color)) {
                $output .= "    :categoryColor \"{$this->escape($category->color)}\" ;\n";
            }
            
            $output = rtrim($output, " ;\n") . " .\n\n";
        }

        return $output;
    }

    /**
     * Generate posts
     */
    protected function generatePosts(): string
    {
        $output = "# ===================================\n";
        $output .= "# Post Instances\n";
        $output .= "# ===================================\n\n";

        $posts = Post::with(['author', 'category'])->get();

        foreach ($posts as $post) {
            $postId = $this->sanitizeId($post->slug);
            $userId = $this->sanitizeId($post->author->username ?? $post->author->name);
            $categoryId = $this->sanitizeId($post->category->slug);
            
            $output .= ":Post_{$postId} rdf:type :Post ;\n";
            $output .= "    :postTitle \"{$this->escape($post->title)}\" ;\n";
            $output .= "    :postSlug \"{$this->escape($post->slug)}\" ;\n";
            $output .= "    :postContent \"{$this->escape(strip_tags($post->body))}\" ;\n";
            
            if ($post->image) {
                $output .= "    :postImage \"{$this->escape($post->image)}\" ;\n";
            }
            
            $output .= "    :publishedDate \"{$post->created_at->toIso8601String()}\"^^xsd:dateTime ;\n";
            $output .= "    :updatedDate \"{$post->updated_at->toIso8601String()}\"^^xsd:dateTime ;\n";
            $output .= "    :hasAuthor :User_{$userId} ;\n";
            $output .= "    :hasCategory :Category_{$categoryId} ;\n";
            
            $output = rtrim($output, " ;\n") . " .\n\n";

            // Add blog contains post relationship
            $output .= ":UriBlog :containsPost :Post_{$postId} .\n\n";
        }

        return $output;
    }

    /**
     * Save RDF to file
     */
    public function saveToFile(): string
    {
        $rdf = $this->generateRDF();
        
        $directory = config('semantic.export.output_path');
        $filename = config('semantic.export.filename');
        
        // Create directory if not exists
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $filepath = $directory . '/' . $filename;
        file_put_contents($filepath, $rdf);

        return $filepath;
    }

    /**
     * Sanitize ID for RDF
     */
    protected function sanitizeId(string $id): string
    {
        // Remove special characters and spaces
        $id = preg_replace('/[^a-zA-Z0-9_-]/', '_', $id);
        // Remove multiple underscores
        $id = preg_replace('/_+/', '_', $id);
        // Remove leading/trailing underscores
        $id = trim($id, '_');
        
        return $id;
    }

    /**
     * Escape string for RDF
     */
    protected function escape(string $str): string
    {
        // Escape quotes and backslashes
        $str = str_replace('\\', '\\\\', $str);
        $str = str_replace('"', '\\"', $str);
        $str = str_replace("\n", '\\n', $str);
        $str = str_replace("\r", '\\r', $str);
        
        return $str;
    }

    /**
     * Get statistics
     */
    public function getStatistics(): array
    {
        return [
            'posts' => Post::count(),
            'authors' => User::count(),
            'categories' => Category::count(),
            'generated_at' => now()->toDateTimeString(),
        ];
    }
}
