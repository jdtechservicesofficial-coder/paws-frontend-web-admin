<?php
/**
 * Bulk Image Uploader for Pawlly (Cloudinary)
 * 
 * Instructions:
 * 1. Place this script in the root directory of your Laravel project (same level as .env).
 * 2. Create a folder named `bulk_images` inside the `public` folder.
 * 3. Put all your renamed images (e.g., 1.jpg, 2.png) inside `public/bulk_images/`.
 * 4. Run this script via terminal: `php bulk_upload_to_cloudinary.php`
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$folderPath = public_path('bulk_images');

if (!is_dir($folderPath)) {
    die("\n[ERROR] The folder 'public/bulk_images' does not exist.\nPlease create it and add your images there before running this script.\n");
}

$files = \File::files($folderPath);
$total = count($files);

if ($total === 0) {
    die("\n[ERROR] No images found in 'public/bulk_images'.\n");
}

$success = 0;
$failed = 0;

echo "Found {$total} images. Starting bulk upload to Cloudinary...\n";
echo str_repeat("-", 50) . "\n";

foreach ($files as $file) {
    $filename = $file->getFilename();
    // Extract product ID from filename (e.g., "1.jpg" -> 1)
    $id = pathinfo($filename, PATHINFO_FILENAME);
    
    if (is_numeric($id)) {
        $product = \Modules\Product\Models\Product::find($id);
        
        if ($product) {
            try {
                // 1. Remove the old image to prevent duplicates
                $product->clearMediaCollection('feature_image');
                
                // 2. Create a simulated uploaded file to satisfy Laravel/Spatie trait requirements
                $uploadedFile = new \Illuminate\Http\UploadedFile(
                    $file->getPathname(),
                    $filename,
                    mime_content_type($file->getPathname()),
                    null,
                    true // Set to true to allow processing of local files
                );
                
                // 3. Upload to Cloudinary and link to product
                $product->addMedia($uploadedFile)
                        ->preservingOriginal()
                        ->toMediaCollection('feature_image');
                
                echo "[SUCCESS] Product #{$id} ({$product->name}) -> Uploaded {$filename}\n";
                $success++;
            } catch (\Exception $e) {
                echo "[ERROR] Product #{$id} -> Failed to process {$filename}: " . $e->getMessage() . "\n";
                $failed++;
            }
        } else {
            echo "[SKIP] File {$filename} -> Product ID {$id} does not exist in the database.\n";
            $failed++;
        }
    } else {
        echo "[SKIP] File {$filename} -> Filename is not a valid ID.\n";
        $failed++;
    }
}

echo str_repeat("-", 50) . "\n";
echo "SUMMARY\n";
echo "Total files processed: {$total}\n";
echo "Successfully uploaded: {$success}\n";
echo "Failed / Skipped: {$failed}\n";
echo str_repeat("-", 50) . "\n";

