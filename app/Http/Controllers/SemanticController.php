<?php

namespace App\Http\Controllers;

use App\Services\FusekiService;
use App\Services\RDFService;
use Illuminate\Http\Request;

class SemanticController extends Controller
{
    protected $fusekiService;
    protected $rdfService;

    public function __construct(FusekiService $fusekiService, RDFService $rdfService)
    {
        $this->fusekiService = $fusekiService;
        $this->rdfService = $rdfService;
    }

    /**
     * Show semantic web dashboard
     */
    public function index()
    {
        $fusekiAvailable = $this->fusekiService->isAvailable();
        $fusekiInfo = $this->fusekiService->getInfo();
        
        $dbStats = $this->rdfService->getStatistics();
        $fusekiStats = $fusekiAvailable ? $this->fusekiService->getStatistics() : null;

        return view('semantic.index', compact('fusekiAvailable', 'fusekiInfo', 'dbStats', 'fusekiStats'));
    }

    /**
     * Show posts from Fuseki (SPARQL query)
     */
    public function posts()
    {
        if (!$this->fusekiService->isAvailable()) {
            return view('semantic.posts', [
                'posts' => null,
                'error' => 'Fuseki server is not available'
            ]);
        }

        $posts = $this->fusekiService->getPosts();

        return view('semantic.posts', compact('posts'));
    }

    /**
     * Execute custom SPARQL query
     */
    public function query(Request $request)
    {
        if (!$this->fusekiService->isAvailable()) {
            return response()->json([
                'error' => 'Fuseki server is not available'
            ], 503);
        }

        $sparql = $request->input('query');
        
        if (!$sparql) {
            return response()->json([
                'error' => 'SPARQL query is required'
            ], 400);
        }

        $result = $this->fusekiService->query($sparql);

        return response()->json($result);
    }

    /**
     * Export RDF via web interface
     */
    public function export()
    {
        $filepath = $this->rdfService->saveToFile();
        $stats = $this->rdfService->getStatistics();

        return response()->json([
            'success' => true,
            'filepath' => $filepath,
            'statistics' => $stats,
        ]);
    }

    /**
     * Sync to Fuseki via web interface
     */
    public function sync()
    {
        if (!$this->fusekiService->isAvailable()) {
            return response()->json([
                'error' => 'Fuseki server is not available'
            ], 503);
        }

        // Export first
        $filepath = $this->rdfService->saveToFile();

        // Upload to Fuseki
        $success = $this->fusekiService->uploadRDF($filepath);

        if ($success) {
            $stats = $this->fusekiService->getStatistics();
            return response()->json([
                'success' => true,
                'message' => 'Data synced successfully',
                'statistics' => $stats,
            ]);
        }

        return response()->json([
            'error' => 'Failed to sync data to Fuseki'
        ], 500);
    }

    /**
     * Download RDF file
     */
    public function download()
    {
        $filepath = config('semantic.export.output_path') . '/' . config('semantic.export.filename');

        if (!file_exists($filepath)) {
            // Generate if not exists
            $filepath = $this->rdfService->saveToFile();
        }

        return response()->download($filepath, 'uri-blog-data.ttl', [
            'Content-Type' => 'text/turtle',
        ]);
    }
}
