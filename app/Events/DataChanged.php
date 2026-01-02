<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataChanged
{
    use Dispatchable, SerializesModels;

    public $modelType;
    public $action;

    /**
     * Create a new event instance.
     */
    public function __construct(string $modelType, string $action = 'updated')
    {
        $this->modelType = $modelType;
        $this->action = $action;
    }
}
