<?php

use App\Http\Controllers\PostDashboardController;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    $featuredPosts = Post::with(['author', 'category'])
        ->latest()
        ->take(6)
        ->get();
    
    $stats = [
        'posts' => Post::count(),
        'authors' => User::count(),
        'categories' => Category::count(),
    ];
    
    return view('home', [
        'title' => 'Home',
        'featuredPosts' => $featuredPosts,
        'stats' => $stats
    ]);
});

// Posts with Semantic Search
use App\Http\Controllers\PostController;
Route::get('/posts', [PostController::class, 'index']);

Route::get('/posts/{post:slug}', function (Post $post) {
    // Get related posts from same category
    $relatedPosts = Post::with(['author', 'category'])
        ->where('category_id', $post->category_id)
        ->where('id', '!=', $post->id)
        ->latest()
        ->take(3)
        ->get();
    
    return view('post', [
        'title' => 'Single Post',
        'post' => $post,
        'relatedPosts' => $relatedPosts
    ]);
});


Route::get('/about', function () {
    return view('about', ['title' => 'About']);
});

Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact']);
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PostDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [PostDashboardController::class, 'store']);
    Route::get('/dashboard/create', [PostDashboardController::class, 'create']);
    Route::delete('/dashboard/{post:slug}', [PostDashboardController::class, 'destroy']);
    Route::get('/dashboard/{post:slug}/edit', [PostDashboardController::class, 'edit']);
    Route::patch('/dashboard/{post:slug}', [PostDashboardController::class, 'update']);
    Route::get('/dashboard/{post:slug}', [PostDashboardController::class, 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Category Management
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
});

// Semantic Web Routes
use App\Http\Controllers\SemanticController;

Route::prefix('semantic')->name('semantic.')->group(function () {
    Route::get('/', [SemanticController::class, 'index'])->name('index');
    Route::get('/posts', [SemanticController::class, 'posts'])->name('posts');
    Route::post('/query', [SemanticController::class, 'query'])->name('query');
    Route::post('/export', [SemanticController::class, 'export'])->name('export');
    Route::post('/sync', [SemanticController::class, 'sync'])->name('sync');
    Route::get('/download', [SemanticController::class, 'download'])->name('download');
});

require __DIR__ . '/auth.php';

