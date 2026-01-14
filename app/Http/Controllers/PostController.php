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
                Log::info('Attempting SPARQL search', [
                    'search' => $search,
                    'category' => $category,
                    'author' => $author
                ]);
                
                // Try SPARQL search
                $sparqlPosts = $this->fusekiService->searchPosts($search, $category, $author, 50);
                $sparqlCategories = $this->fusekiService->getAllCategories();
                
                Log::info('SPARQL search completed', [
                    'posts_count' => $sparqlPosts ? count($sparqlPosts) : 0,
                    'categories_count' => $sparqlCategories ? count($sparqlCategories) : 0
                ]);
                
                // Only use SPARQL results if we got data
                if ($sparqlPosts !== null && count($sparqlPosts) > 0) {
                    // Transform SPARQL array to object structure
                    $posts = collect($sparqlPosts)->map(function($item) {
                        $categoryName = $item['categoryName']['value'] ?? 'Uncategorized';
                        $publishedDate = isset($item['publishedDate']['value']) 
                            ? \Carbon\Carbon::parse($item['publishedDate']['value']) 
                            : now();
                        
                        // Use actual image from database if available, otherwise use placeholder
                        $image = isset($item['postImage']['value']) && !empty($item['postImage']['value'])
                            ? asset('storage/' . $item['postImage']['value'])
                            : 'https://picsum.photos/seed/' . md5($item['title']['value'] ?? rand()) . '/800/600';
                        
                        return (object) [
                            'title' => $item['title']['value'] ?? '',
                            'slug' => $item['slug']['value'] ?? '',
                            'content' => $item['content']['value'] ?? '',
                            'body' => $item['content']['value'] ?? '', // Alias for content
                            'image' => $image,
                            'published_at' => $publishedDate,
                            'created_at' => $publishedDate, // Use published date as created date
                            'author' => (object) [
                                'name' => $item['authorName']['value'] ?? 'Unknown',
                                'username' => strtolower(str_replace(' ', '', $item['authorName']['value'] ?? 'unknown')),
                                'avatar' => null // Will use ui-avatars.com in view
                            ],
                            'category' => (object) [
                                'name' => $categoryName,
                                'slug' => strtolower(str_replace(' ', '-', $categoryName)),
                                'color' => $item['categoryColor']['value'] ?? '#6366f1'
                            ]
                        ];
                    });
                    
                    // Transform categories
                    $categories = collect($sparqlCategories)->map(function($item) {
                        $categoryName = $item['categoryName']['value'] ?? '';
                        return (object) [
                            'name' => $categoryName,
                            'slug' => $item['categorySlug']['value'] ?? strtolower(str_replace(' ', '-', $categoryName)),
                            'color' => $item['categoryColor']['value'] ?? '#6366f1',
                            'posts_count' => (int) ($item['postCount']['value'] ?? 0)
                        ];
                    });
                    
                    // Wrap in paginator for view compatibility
                    $posts = new \Illuminate\Pagination\LengthAwarePaginator(
                        $posts,
                        $posts->count(),
                        50, // items per page
                        1, // current page
                        ['path' => request()->url(), 'query' => request()->query()]
                    );
                    
                    $usingSemanticSearch = true;
                    
                    Log::info('Using semantic search (SPARQL)', [
                        'search' => $search,
                        'category' => $category,
                        'author' => $author,
                        'results_count' => $posts->count()
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
