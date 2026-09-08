<?php

$dir = __DIR__ . '/application/resources/views/templates/basic/sections/';
$files = glob($dir . '*.blade.php');

$replacements = [
    // Text hover states
    "color='#0f172a'" => "color='#ffffff'",
    "color='#1e293b'" => "color='#f8fafc'",
    "color='#64748b'" => "color='#e2e8f0'",
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    file_put_contents($file, $content);
}

echo "Secondary replacements done!\n";
