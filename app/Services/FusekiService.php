<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FusekiService
{
    protected $host;
    protected $dataset;
    protected $timeout;

    public function __construct()
    {
        $this->host = config('semantic.fuseki.host');
        $this->dataset = config('semantic.fuseki.dataset');
        $this->timeout = config('semantic.fuseki.timeout');
    }

    /**
     * Upload RDF file to Fuseki
     */
    public function uploadRDF(string $filepath, string $graph = 'default'): bool
    {
        try {
            $content = file_get_contents($filepath);
            
            $url = $this->host . '/' . $this->dataset . '/data';
            
            if ($graph !== 'default') {
                $url .= '?graph=' . urlencode($graph);
            }

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Content-Type' => 'text/turtle',
                ])
                ->withBody($content, 'text/turtle')
                ->post($url);

            if ($response->successful()) {
                Log::info('RDF uploaded to Fuseki successfully', [
                    'dataset' => $this->dataset,
                    'graph' => $graph,
                ]);
                return true;
            }

            Log::error('Failed to upload RDF to Fuseki', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Error uploading RDF to Fuseki', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Clear dataset (delete all data)
     */
    public function clearDataset(): bool
    {
        try {
            $url = $this->host . '/' . $this->dataset . '/update';
            
            $sparql = 'DELETE WHERE { ?s ?p ?o }';

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Content-Type' => 'application/sparql-update',
                ])
                ->withBody($sparql, 'application/sparql-update')
                ->post($url);

            if ($response->successful()) {
                Log::info('Fuseki dataset cleared successfully');
                return true;
            }

            return false;

        } catch (\Exception $e) {
            Log::error('Error clearing Fuseki dataset', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Execute SPARQL query
     */
    public function query(string $sparql): ?array
    {
        try {
            $url = $this->host . '/' . $this->dataset . '/sparql';

            $response = Http::timeout($this->timeout)
                ->asForm()
                ->post($url, [
                    'query' => $sparql,
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('SPARQL query failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Error executing SPARQL query', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Get all posts from Fuseki
     */
    public function getPosts(): ?array
    {
        $prefixes = $this->buildPrefixes();
        
        $sparql = $prefixes . "
SELECT ?post ?title ?slug ?publishedDate ?authorName ?categoryName
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?title .
  ?post :postSlug ?slug .
  ?post :publishedDate ?publishedDate .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
  ?post :hasCategory ?category .
  ?category :categoryName ?categoryName .
}
ORDER BY DESC(?publishedDate)
";

        $result = $this->query($sparql);
        
        if ($result && isset($result['results']['bindings'])) {
            return $result['results']['bindings'];
        }

        return null;
    }

    /**
     * Get statistics from Fuseki
     */
    public function getStatistics(): ?array
    {
        $prefixes = $this->buildPrefixes();
        
        $sparql = $prefixes . "
SELECT 
  (COUNT(DISTINCT ?post) AS ?totalPosts)
  (COUNT(DISTINCT ?user) AS ?totalUsers)
  (COUNT(DISTINCT ?category) AS ?totalCategories)
WHERE {
  OPTIONAL { ?post rdf:type :Post }
  OPTIONAL { ?user rdf:type :User }
  OPTIONAL { ?category rdf:type :Category }
}
";

        $result = $this->query($sparql);
        
        if ($result && isset($result['results']['bindings'][0])) {
            $data = $result['results']['bindings'][0];
            return [
                'posts' => (int) $data['totalPosts']['value'],
                'authors' => (int) $data['totalUsers']['value'],
                'categories' => (int) $data['totalCategories']['value'],
            ];
        }

        return null;
    }

    /**
     * Check if Fuseki is available
     */
    public function isAvailable(): bool
    {
        try {
            $response = Http::timeout(5)->get($this->host . '/$/ping');
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Build SPARQL prefixes
     */
    protected function buildPrefixes(): string
    {
        $output = '';
        foreach (config('semantic.prefixes') as $prefix => $uri) {
            if ($prefix === '') {
                $output .= "PREFIX : <{$uri}>\n";
            } else {
                $output .= "PREFIX {$prefix}: <{$uri}>\n";
            }
        }
        return $output . "\n";
    }

    /**
     * Get Fuseki info
     */
    public function getInfo(): array
    {
        return [
            'host' => $this->host,
            'dataset' => $this->dataset,
            'available' => $this->isAvailable(),
            'sparql_endpoint' => $this->host . '/' . $this->dataset . '/sparql',
            'update_endpoint' => $this->host . '/' . $this->dataset . '/update',
            'data_endpoint' => $this->host . '/' . $this->dataset . '/data',
        ];
    }

    /**
     * Search posts using SPARQL
     */
    public function searchPosts(?string $search = null, ?string $category = null, ?string $author = null, int $limit = 6): ?array
    {
        $prefixes = $this->buildPrefixes();
        
        // Build filter conditions
        $filters = [];
        
        if ($search) {
            $search = addslashes($search);
            $filters[] = "(regex(?title, \"{$search}\", \"i\") || regex(?content, \"{$search}\", \"i\"))";
        }
        
        if ($category) {
            $category = addslashes($category);
            $filters[] = "regex(?categoryName, \"{$category}\", \"i\")";
        }
        
        if ($author) {
            $author = addslashes($author);
            $filters[] = "regex(?authorName, \"{$author}\", \"i\")";
        }
        
        $filterString = !empty($filters) ? 'FILTER (' . implode(' && ', $filters) . ')' : '';
        
        $sparql = $prefixes . "
SELECT DISTINCT ?post ?title ?slug ?content ?publishedDate ?authorName ?categoryName ?categoryColor
WHERE {
  ?post rdf:type :Post .
  ?post :postTitle ?title .
  ?post :postSlug ?slug .
  ?post :postContent ?content .
  ?post :publishedDate ?publishedDate .
  ?post :hasAuthor ?author .
  ?author :authorName ?authorName .
  ?post :hasCategory ?category .
  ?category :categoryName ?categoryName .
  OPTIONAL { ?category :categoryColor ?categoryColor }
  {$filterString}
}
ORDER BY DESC(?publishedDate)
LIMIT {$limit}
";

        Log::info('SPARQL Query:', ['query' => $sparql]);

        $result = $this->query($sparql);
        
        if ($result) {
            Log::info('SPARQL Result received', [
                'has_results' => isset($result['results']),
                'has_bindings' => isset($result['results']['bindings']),
                'bindings_count' => isset($result['results']['bindings']) ? count($result['results']['bindings']) : 0
            ]);
        } else {
            Log::warning('SPARQL Result is null');
        }
        
        if ($result && isset($result['results']['bindings'])) {
            Log::info('Returning SPARQL results', ['count' => count($result['results']['bindings'])]);
            return $result['results']['bindings'];
        }

        Log::warning('No SPARQL bindings found, returning null');
        return null;
    }

    /**
     * Get all categories for filter
     */
    public function getAllCategories(): array
    {
        $prefixes = $this->buildPrefixes();
        
        $sparql = $prefixes . "
SELECT DISTINCT ?categoryName (COUNT(?post) as ?postCount)
WHERE {
  ?category rdf:type :Category .
  ?category :categoryName ?categoryName .
  OPTIONAL {
    ?post :hasCategory ?category .
  }
}
GROUP BY ?categoryName
ORDER BY ?categoryName
";

        $result = $this->query($sparql);
        
        if ($result && isset($result['results']['bindings'])) {
            return $result['results']['bindings'];
        }

        return [];
    }
}
