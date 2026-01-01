<?php

namespace App\Console\Commands;

use App\Services\RDFService;
use App\Services\FusekiService;
use Illuminate\Console\Command;

class SyncRDF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rdf:sync 
                            {--clear : Clear existing data before upload}
                            {--export : Force re-export before sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync RDF data to Fuseki triple store';

    protected $rdfService;
    protected $fusekiService;

    public function __construct(RDFService $rdfService, FusekiService $fusekiService)
    {
        parent::__construct();
        $this->rdfService = $rdfService;
        $this->fusekiService = $fusekiService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting RDF sync to Fuseki...');
        $this->newLine();

        // Check if Fuseki is available
        if (!$this->fusekiService->isAvailable()) {
            $this->error('✗ Fuseki server is not available!');
            $this->error('Please make sure Fuseki is running at: ' . config('semantic.fuseki.host'));
            return Command::FAILURE;
        }

        $this->info('✓ Fuseki server is available');
        $this->newLine();

        // Show Fuseki info
        $info = $this->fusekiService->getInfo();
        $this->info('Fuseki Configuration:');
        $this->table(
            ['Property', 'Value'],
            [
                ['Host', $info['host']],
                ['Dataset', $info['dataset']],
                ['SPARQL Endpoint', $info['sparql_endpoint']],
            ]
        );
        $this->newLine();

        // Export if requested
        if ($this->option('export')) {
            $this->info('Exporting RDF from database...');
            $this->call('rdf:export');
            $this->newLine();
        }

        // Get RDF file path
        $filepath = config('semantic.export.output_path') . '/' . config('semantic.export.filename');
        
        if (!file_exists($filepath)) {
            $this->error('✗ RDF file not found: ' . $filepath);
            $this->error('Please run "php artisan rdf:export" first');
            return Command::FAILURE;
        }

        $this->info('RDF file: ' . $filepath);
        $this->info('File size: ' . $this->formatBytes(filesize($filepath)));
        $this->newLine();

        // Clear existing data if requested
        if ($this->option('clear')) {
            if ($this->confirm('Are you sure you want to clear all existing data in Fuseki?', false)) {
                $this->info('Clearing existing data...');
                if ($this->fusekiService->clearDataset()) {
                    $this->info('✓ Dataset cleared');
                } else {
                    $this->warn('⚠ Failed to clear dataset');
                }
                $this->newLine();
            }
        }

        // Upload to Fuseki
        $this->info('Uploading RDF to Fuseki...');
        $bar = $this->output->createProgressBar(100);
        $bar->start();

        $success = $this->fusekiService->uploadRDF($filepath);

        $bar->finish();
        $this->newLine(2);

        if ($success) {
            $this->info('✓ RDF uploaded successfully!');
            $this->newLine();

            // Get statistics from Fuseki
            $this->info('Fetching statistics from Fuseki...');
            $stats = $this->fusekiService->getStatistics();

            if ($stats) {
                $this->info('Fuseki Statistics:');
                $this->table(
                    ['Type', 'Count'],
                    [
                        ['Posts', $stats['posts']],
                        ['Authors', $stats['authors']],
                        ['Categories', $stats['categories']],
                    ]
                );
            }

            $this->newLine();
            $this->info('SPARQL Endpoint: ' . $info['sparql_endpoint']);
            $this->info('You can now query your data using SPARQL!');

            return Command::SUCCESS;
        } else {
            $this->error('✗ Failed to upload RDF to Fuseki');
            $this->error('Check the logs for more details');
            return Command::FAILURE;
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
