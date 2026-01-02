<?php

namespace App\Listeners;

use App\Events\DataChanged;
use App\Services\RDFService;
use App\Services\FusekiService;
use Illuminate\Support\Facades\Log;

class ExportToRDF
{
    protected $rdfService;
    protected $fusekiService;

    /**
     * Create the event listener.
     */
    public function __construct(RDFService $rdfService, FusekiService $fusekiService)
    {
        $this->rdfService = $rdfService;
        $this->fusekiService = $fusekiService;
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

            // Auto-sync to Fuseki if available
            if ($this->fusekiService->isAvailable()) {
                $success = $this->fusekiService->uploadRDF($filepath);
                
                if ($success) {
                    Log::info("RDF auto-synced to Fuseki: {$event->modelType} {$event->action}");
                } else {
                    Log::warning("RDF auto-sync to Fuseki failed: {$event->modelType} {$event->action}");
                }
            } else {
                Log::debug("Fuseki not available, skipping auto-sync");
            }
            
        } catch (\Exception $e) {
            Log::error("RDF auto-export/sync failed: " . $e->getMessage());
        }
    }
}
