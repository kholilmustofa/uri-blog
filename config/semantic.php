<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Semantic Web Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for RDF export and Fuseki integration
    |
    */

    // Fuseki Server Configuration
    'fuseki' => [
        'enabled' => env('FUSEKI_ENABLED', true),
        'host' => env('FUSEKI_HOST', 'http://localhost:3030'),
        'dataset' => env('FUSEKI_DATASET', 'uriblog'),
        'timeout' => env('FUSEKI_TIMEOUT', 30),
    ],

    // Ontology Configuration
    'ontology' => [
        'namespace' => 'http://www.uriblog.com/ontology#',
        'base_uri' => 'http://www.uriblog.com/',
        'version' => '1.0',
    ],

    // RDF Export Configuration
    'export' => [
        'format' => 'turtle', // turtle, rdfxml, ntriples
        'output_path' => storage_path('app/rdf'),
        'filename' => 'uri-blog-data.ttl',
    ],

    // Auto-sync Configuration
    'auto_sync' => [
        'enabled' => env('SEMANTIC_AUTO_SYNC', false),
        'on_create' => true,
        'on_update' => true,
        'on_delete' => true,
    ],

    // Prefixes for SPARQL Queries
    'prefixes' => [
        '' => 'http://www.uriblog.com/ontology#',
        'rdf' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#',
        'rdfs' => 'http://www.w3.org/2000/01/rdf-schema#',
        'owl' => 'http://www.w3.org/2002/07/owl#',
        'xsd' => 'http://www.w3.org/2001/XMLSchema#',
        'foaf' => 'http://xmlns.com/foaf/0.1/',
    ],

];
