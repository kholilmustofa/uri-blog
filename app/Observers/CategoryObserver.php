<?php

namespace App\Observers;

use App\Events\DataChanged;
use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        event(new DataChanged('Category', 'created'));
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        event(new DataChanged('Category', 'updated'));
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        event(new DataChanged('Category', 'deleted'));
    }
}
