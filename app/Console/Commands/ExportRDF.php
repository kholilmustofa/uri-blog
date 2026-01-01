<?php

namespace App\Console\Commands;

use App\Services\RDFService;
use Illuminate\Console\Command;

class ExportRDF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rdf:export 
                            {--output= : Output file path (optional)}
                            {--format=turtle : Output format (turtle, rdfxml, ntriples)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export database to RDF format';

    protected $rdfService;

    public function __construct(RDFService $rdfService)
    {
        parent::__construct();
        $this->rdfService = $rdfService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting RDF export...');
        $this->newLine();

        // Get statistics
        $stats = $this->rdfService->getStatistics();
        
        $this->info('Database Statistics:');
        $this->table(
            ['Type', 'Count'],
            [
                ['Posts', $stats['posts']],
                ['Authors', $stats['authors']],
                ['Categories', $stats['categories']],
            ]
        );
        $this->newLine();

        // Generate RDF
        $this->info('Generating RDF...');
        $filepath = $this->rdfService->saveToFile();

        $this->info('✓ RDF exported successfully!');
        $this->newLine();
        
        $this->info('Output file: ' . $filepath);
        $this->info('File size: ' . $this->formatBytes(filesize($filepath)));
        $this->newLine();

        // Show sample
        $this->info('Sample output (first 10 lines):');
        $this->showSample($filepath);

        $this->newLine();
        $this->info('Next step: Run "php artisan rdf:sync" to upload to Fuseki');

        return Command::SUCCESS;
    }

    /**
     * Show sample of generated RDF
     */
    protected function showSample(string $filepath)
    {
        $lines = file($filepath);
        $sample = array_slice($lines, 0, 10);
        
        foreach ($sample as $line) {
            $this->line('  ' . rtrim($line));
        }
        
        if (count($lines) > 10) {
            $this->line('  ...');
            $this->line('  (Total ' . count($lines) . ' lines)');
        }
    }

    /**
     * Format bytes to human readable
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
