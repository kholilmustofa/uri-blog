<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Services\FusekiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected $fusekiService;

    public function __construct(FusekiService $fusekiService)
    {
        $this->fusekiService = $fusekiService;
    }

    /**
     * Display posts with hybrid search (SPARQL or SQL fallback)
     */
    public function index(Request $request)
    {
        // Get search parameters
        $search = $request->input('search');
        $category = $request->input('category');
        $author = $request->input('author');
        
        $posts = null;
        $categories = [];
        $usingSemanticSearch = false;
        
        // Check if Fuseki is available
        $fusekiAvailable = $this->fusekiService->isAvailable();
        
        if ($fusekiAvailable) {
            try {
                // Try SPARQL search
                $sparqlPosts = $this->fusekiService->searchPosts($search, $category, $author, 50);
                $sparqlCategories = $this->fusekiService->getAllCategories();
                
                // Only use SPARQL results if we got data
                if ($sparqlPosts !== null) {
                    $posts = $sparqlPosts;
                    $categories = $sparqlCategories;
                    $usingSemanticSearch = true;
                    
                    Log::info('Using semantic search (SPARQL)', [
                        'search' => $search,
                        'category' => $category,
                        'author' => $author,
                        'results_count' => count($posts)
                    ]);
                } else {
                    $fusekiAvailable = false; // Force fallback
                }
            } catch (\Exception $e) {
                Log::error('Semantic search failed, falling back to SQL', [
                    'error' => $e->getMessage()
                ]);
                $fusekiAvailable = false; // Force fallback
            }
        }
        
        // Fallback to SQL if Fuseki is offline or failed
        if (!$usingSemanticSearch) {
            $posts = Post::latest()
                ->filter(request(['search', 'category', 'author']))
                ->paginate(6)
                ->onEachSide(0)
                ->withQueryString();
            
            $categories = Category::withCount('posts')->get();
            
            Log::info('Using SQL search (fallback)', [
                'search' => $search,
                'category' => $category,
                'author' => $author,
                'results_count' => $posts->count()
            ]);
        }
        
        return view('posts', [
            'title' => 'Blog',
            'posts' => $posts,
            'categories' => $categories,
            'usingSemanticSearch' => $usingSemanticSearch,
            'filters' => [
                'search' => $search,
                'category' => $category,
                'author' => $author
            ]
        ]);
    }
}
