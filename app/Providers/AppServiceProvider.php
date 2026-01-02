<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading();
        
        // Register RDF auto-sync listener
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\DataChanged::class,
            \App\Listeners\ExportToRDF::class
        );
        
        // Register model observers for auto RDF export
        \App\Models\Post::observe(\App\Observers\PostObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
    }
}
