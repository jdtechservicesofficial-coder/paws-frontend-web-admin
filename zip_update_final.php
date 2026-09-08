<?php
$filesToZip = [
    'Modules/Booking/Trait/CommissionCalculatorTrait.php',
    'Modules/Product/Http/Controllers/Backend/API/OrdersController.php',
    'Modules/Product/Http/Controllers/Backend/OrdersController.php', // Added Backend OrdersController
    'Modules/Product/Resources/views/backend/order/invoice.blade.php',
    'Modules/Product/Resources/views/backend/order/show.blade.php', // Added show.blade.php
    'Modules/Product/Transformers/OrderItemResource.php',
    'Modules/Product/Transformers/ProductDetailResource.php',
    'Modules/Product/Transformers/ProductResource.php',
    'Modules/Product/routes/api.php', // Added Product API routes
    'app/Http/Controllers/Backend/API/AdminDashboardApiController.php',
    'app/Support/CloudinaryUrlGenerator.php',
    'app/helpers.php',
    'config/media-library.php',
    'routes/api.php'
];

$zipPath = __DIR__ . '/backend_update_FINAL.zip';
if (file_exists($zipPath)) {
    unlink($zipPath);
}

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die("Failed to create zip\n");
}

foreach ($filesToZip as $relativePath) {
    $fullPath = __DIR__ . '/' . $relativePath;
    if (file_exists($fullPath)) {
        $zip->addFile($fullPath, $relativePath);
        echo "Added $relativePath\n";
    } else {
        echo "Missing $relativePath\n";
    }
}

if (!$zip->close()) {
    echo "Failed to close zip. Error: " . $zip->getStatusString() . "\n";
} else {
    echo "\nZip created successfully at: " . $zipPath . "\n";
}
