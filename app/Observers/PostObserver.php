<?php

namespace App\Observers;

use App\Events\DataChanged;
use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        event(new DataChanged('Post', 'created'));
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        event(new DataChanged('Post', 'updated'));
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        event(new DataChanged('Post', 'deleted'));
    }
}
