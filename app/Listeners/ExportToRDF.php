<?php

namespace App\Listeners;

use App\Events\DataChanged;
use App\Services\RDFService;
use Illuminate\Support\Facades\Log;

class ExportToRDF
{
    protected $rdfService;

    /**
     * Create the event listener.
     */
    public function __construct(RDFService $rdfService)
    {
        $this->rdfService = $rdfService;
    }

    /**
     * Handle the event.
     */
    public function handle(DataChanged $event): void
    {
        try {
            // Export RDF whenever data changes
            $filepath = $this->rdfService->saveToFile();
            
            Log::info("RDF auto-exported: {$event->modelType} {$event->action}", [
                'file' => $filepath,
                'timestamp' => now()->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            Log::error("RDF auto-export failed: " . $e->getMessage());
        }
    }
}
