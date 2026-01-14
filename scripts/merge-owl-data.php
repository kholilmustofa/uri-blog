#!/usr/bin/env php
<?php

echo "Starting TTL to OWL conversion...\n";

// Read files
$owlContent = file_get_contents(__DIR__ . '/../ontology/uri-blog-ontology.owl');
$ttlContent = file_get_contents(__DIR__ . '/../storage/app/rdf/uri-blog-data.ttl');

// Parse TTL individuals
$individuals = [];
$lines = explode("\n", $ttlContent);
$currentIndividual = null;
$currentProperties = [];

foreach ($lines as $lineNum => $line) {
    $line = trim($line);
    
    // Skip prefixes, comments, empty lines
    if (empty($line) || $line[0] === '#' || strpos($line, '@prefix') === 0) {
        continue;
    }
    
    // Match individual declaration: :Name rdf:type :Class ;
    if (preg_match('/^:(\S+)\s+rdf:type\s+:(\w+)\s*;/', $line, $matches)) {
        // Save previous individual if exists
        if ($currentIndividual) {
            $individuals[] = [
                'id' => $currentIndividual,
                'type' => $currentType,
                'properties' => $currentProperties
            ];
        }
        
        $currentIndividual = $matches[1];
        $currentType = $matches[2];
        $currentProperties = [];
        continue;
    }
    
    // Match property: :propertyName "value" or :propertyName value
    if ($currentIndividual && preg_match('/:(\w+)\s+(.+?)\s*[;.]$/', $line, $matches)) {
        $propName = $matches[1];
        $value = trim($matches[2]);
        
        // Handle different value types
        if (preg_match('/^"(.+?)"(\^\^xsd:(\w+))?$/', $value, $valMatches)) {
            // Quoted string with optional datatype
            $propValue = $valMatches[1];
            $datatype = isset($valMatches[3]) ? $valMatches[3] : 'string';
        } elseif (preg_match('/^:(\w+)$/', $value, $valMatches)) {
            // Object property (reference to another individual)
            $propValue = $valMatches[1];
            $datatype = 'objectProperty';
        } else {
            // Plain value
            $propValue = trim($value, '"');
            $datatype = 'string';
        }
        
        $currentProperties[] = [
            'name' => $propName,
            'value' => $propValue,
            'datatype' => $datatype
        ];
        
        // Check if this is the last property (ends with .)
        if (substr($line, -1) === '.') {
            $individuals[] = [
                'id' => $currentIndividual,
                'type' => $currentType,
                'properties' => $currentProperties
            ];
            $currentIndividual = null;
            $currentProperties = [];
        }
    }
}

// Add last individual if exists
if ($currentIndividual) {
    $individuals[] = [
        'id' => $currentIndividual,
        'type' => $currentType,
        'properties' => $currentProperties
    ];
}

echo "Parsed " . count($individuals) . " individuals\n";

// Generate OWL/RDF XML
$owlIndividuals = "\n    <!-- ============================================= -->\n";
$owlIndividuals .= "    <!-- Individuals from Database (Auto-generated)   -->\n";
$owlIndividuals .= "    <!-- Total: " . count($individuals) . " individuals -->\n";
$owlIndividuals .= "    <!-- ============================================= -->\n\n";

$namespace = "http://www.uriblog.com/ontology#";

foreach ($individuals as $ind) {
    $owlIndividuals .= "    <owl:NamedIndividual rdf:about=\"{$namespace}{$ind['id']}\">\n";
    $owlIndividuals .= "        <rdf:type rdf:resource=\"{$namespace}{$ind['type']}\"/>\n";
    
    foreach ($ind['properties'] as $prop) {
        $propName = $prop['name'];
        $value = htmlspecialchars($prop['value'], ENT_XML1, 'UTF-8');
        
        if ($prop['datatype'] === 'objectProperty') {
            // Object property - reference to another individual
            $owlIndividuals .= "        <{$propName} rdf:resource=\"{$namespace}{$prop['value']}\"/>\n";
        } elseif ($prop['datatype'] === 'boolean') {
            $owlIndividuals .= "        <{$propName} rdf:datatype=\"http://www.w3.org/2001/XMLSchema#boolean\">{$value}</{$propName}>\n";
        } elseif ($prop['datatype'] === 'dateTime') {
            $owlIndividuals .= "        <{$propName} rdf:datatype=\"http://www.w3.org/2001/XMLSchema#dateTime\">{$value}</{$propName}>\n";
        } else {
            // String or other
            $owlIndividuals .= "        <{$propName}>{$value}</{$propName}>\n";
        }
    }
    
    $owlIndividuals .= "    </owl:NamedIndividual>\n\n";
}

// Insert before closing </rdf:RDF>
$mergedContent = str_replace('</rdf:RDF>', $owlIndividuals . '</rdf:RDF>', $owlContent);

// Save
$outputFile = __DIR__ . '/../ontology/uri-blog-complete.owl';
file_put_contents($outputFile, $mergedContent);

echo "✓ Successfully created: ontology/uri-blog-complete.owl\n";
echo "  Total individuals: " . count($individuals) . "\n";
echo "  - Authors: " . count(array_filter($individuals, fn($i) => $i['type'] === 'Author')) . "\n";
echo "  - Categories: " . count(array_filter($individuals, fn($i) => $i['type'] === 'Category')) . "\n";
echo "  - Posts: " . count(array_filter($individuals, fn($i) => $i['type'] === 'Post')) . "\n";
echo "\nYou can now open this file in Protégé!\n";
