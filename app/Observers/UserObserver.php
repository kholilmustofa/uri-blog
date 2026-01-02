<?php

namespace App\Observers;

use App\Events\DataChanged;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        event(new DataChanged('User', 'created'));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        event(new DataChanged('User', 'updated'));
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        event(new DataChanged('User', 'deleted'));
    }
}
