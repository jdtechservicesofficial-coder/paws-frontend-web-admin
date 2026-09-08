<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$images = [
    'animal1.jpg',
    'animal2.jpg',
    'animal3.jpg',
    'animal4.jpg',
    'animal5.jpg',
];

$sourceDir = __DIR__.'/../assets/images/frontend/product/';
$storageDir = __DIR__.'/../pawlly_storage/';

if (!is_dir($storageDir)) {
    // If the symlink doesn't exist, create the directory inside public
    $storageDir = __DIR__.'/public/pawlly_storage/';
    if (!is_dir($storageDir)) {
        mkdir($storageDir, 0755, true);
    }
}

// Clear old media for products to avoid duplicates
\Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Product\Models\Product')->delete();

$products = \Illuminate\Support\Facades\DB::table('products')->get();
$count = 0;

foreach($products as $product) {
    $randomImage = $images[array_rand($images)];
    $sourcePath = $sourceDir . $randomImage;
    
    if(!file_exists($sourcePath)) continue;
    
    // Insert into media table
    $mediaId = \Illuminate\Support\Facades\DB::table('media')->insertGetId([
        'model_type' => 'Modules\Product\Models\Product',
        'model_id' => $product->id,
        'uuid' => \Illuminate\Support\Str::uuid()->toString(),
        'collection_name' => 'product_image',
        'name' => pathinfo($randomImage, PATHINFO_FILENAME),
        'file_name' => $randomImage,
        'mime_type' => 'image/jpeg',
        'disk' => 'public',
        'conversions_disk' => 'public',
        'size' => filesize($sourcePath),
        'manipulations' => '[]',
        'custom_properties' => '[]',
        'generated_conversions' => '[]',
        'responsive_images' => '[]',
        'order_column' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    // Create directory for this media item
    $mediaDir = $storageDir . $mediaId;
    if (!is_dir($mediaDir)) {
        mkdir($mediaDir, 0755, true);
    }
    
    // Copy the file
    copy($sourcePath, $mediaDir . '/' . $randomImage);
    $count++;
}

echo "Successfully mapped $count real images to the Spatie media table!\n";
