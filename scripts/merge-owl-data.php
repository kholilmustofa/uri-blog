#!/usr/bin/env php
<?php

// Read OWL schema
$owlContent = file_get_contents(__DIR__ . '/../ontology/uri-blog-ontology.owl');

// Read TTL data
$ttlContent = file_get_contents(__DIR__ . '/../storage/app/rdf/uri-blog-data.ttl');

// Parse TTL and convert to OWL/RDF format
$individuals = [];
$currentIndividual = null;
$lines = explode("\n", $ttlContent);

foreach ($lines as $line) {
    $line = trim($line);
    
    // Skip comments and empty lines
    if (empty($line) || $line[0] === '#' || strpos($line, '@prefix') === 0) {
        continue;
    }
    
    // New individual (starts with :Something)
    if (preg_match('/^:(\w+)\s+rdf:type\s+:(\w+)/', $line, $matches)) {
        if ($currentIndividual) {
            $individuals[] = $currentIndividual;
        }
        $currentIndividual = [
            'id' => $matches[1],
            'type' => $matches[2],
            'properties' => []
        ];
    }
    // Property line
    elseif ($currentIndividual && preg_match('/:(\w+)\s+"?([^"]+)"?/', $line, $matches)) {
        $property = $matches[1];
        $value = trim($matches[2], ' ;".');
        
        // Handle datatype
        if (strpos($value, '^^') !== false) {
            list($val, $type) = explode('^^', $value);
            $value = trim($val, '"');
            $datatype = trim($type);
        } else {
            $value = trim($value, '"');
            $datatype = 'string';
        }
        
        $currentIndividual['properties'][] = [
            'name' => $property,
            'value' => $value,
            'datatype' => $datatype
        ];
    }
    // End of individual
    elseif ($line === '.' && $currentIndividual) {
        $individuals[] = $currentIndividual;
        $currentIndividual = null;
    }
}

// Generate OWL individuals
$owlIndividuals = "\n    <!-- ============================================= -->\n";
$owlIndividuals .= "    <!-- Individuals from Database (Auto-generated)   -->\n";
$owlIndividuals .= "    <!-- ============================================= -->\n\n";

foreach ($individuals as $individual) {
    $owlIndividuals .= "    <owl:NamedIndividual rdf:about=\"http://www.uriblog.com/ontology#{$individual['id']}\">\n";
    $owlIndividuals .= "        <rdf:type rdf:resource=\"http://www.uriblog.com/ontology#{$individual['type']}\"/>\n";
    
    foreach ($individual['properties'] as $prop) {
        $propName = $prop['name'];
        $value = htmlspecialchars($prop['value'], ENT_XML1, 'UTF-8');
        
        if ($prop['datatype'] === 'xsd:boolean') {
            $owlIndividuals .= "        <{$propName} rdf:datatype=\"http://www.w3.org/2001/XMLSchema#boolean\">{$value}</{$propName}>\n";
        } elseif ($prop['datatype'] === 'xsd:dateTime') {
            $owlIndividuals .= "        <{$propName} rdf:datatype=\"http://www.w3.org/2001/XMLSchema#dateTime\">{$value}</{$propName}>\n";
        } else {
            $owlIndividuals .= "        <{$propName}>{$value}</{$propName}>\n";
        }
    }
    
    $owlIndividuals .= "    </owl:NamedIndividual>\n\n";
}

// Insert before closing </rdf:RDF>
$mergedContent = str_replace('</rdf:RDF>', $owlIndividuals . '</rdf:RDF>', $owlContent);

// Save to new file
file_put_contents(__DIR__ . '/../ontology/uri-blog-complete.owl', $mergedContent);

echo "✓ File created successfully: ontology/uri-blog-complete.owl\n";
echo "  Contains: " . count($individuals) . " individuals\n";
echo "  You can now open this file in Protégé to see property assertions!\n";
