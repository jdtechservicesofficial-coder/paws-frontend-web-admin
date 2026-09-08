<?php
$zipPath = 'C:\\Users\\USER\\Downloads\\backend_deployment.zip';
$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die("Failed to create zip\n");
}
$dir = __DIR__;
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir),
    RecursiveIteratorIterator::LEAVES_ONLY
);
foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($dir) + 1);
        $relativePath = str_replace('\\', '/', $relativePath);
        if (!preg_match('/^(vendor|node_modules|aa|ca|\.git|new frontend\.zip|read\.zip|backend_laravel_app\.zip)/i', $relativePath)) {
            if (is_readable($filePath)) {
                $zip->addFile($filePath, $relativePath);
            }
        }
    }
}
if (!$zip->close()) {
    echo "Failed to close zip. Error: " . $zip->getStatusString() . "\n";
} else {
    echo "Zip created successfully at: " . $zipPath . "\n";
}
