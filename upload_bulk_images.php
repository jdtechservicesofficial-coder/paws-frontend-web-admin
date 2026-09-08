<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$folderPath = public_path('bulk_image');
if (!is_dir($folderPath)) {
    die("Folder not found: " . $folderPath . "\n");
}

$files = \File::files($folderPath);
$total = count($files);
$success = 0;
$failed = 0;

echo "Found {$total} files in bulk_images folder.\n";

foreach ($files as $file) {
    $filename = $file->getFilename();
    // Extract ID from filename (e.g., "1.jpg" -> 1)
    $id = pathinfo($filename, PATHINFO_FILENAME);
    
    if (is_numeric($id)) {
        $product = \Modules\Product\Models\Product::find($id);
        if ($product) {
            try {
                // Remove existing feature_image if any to prevent duplicates
                $product->clearMediaCollection('feature_image');
                
                // Create an UploadedFile instance to bypass the HasHashedMediaTrait requirement
                $uploadedFile = new \Illuminate\Http\UploadedFile(
                    $file->getPathname(),
                    $filename,
                    mime_content_type($file->getPathname()),
                    null,
                    true // true means it's for testing/local file, bypassing is_uploaded_file check
                );
                
                // Add the new image
                $product->addMedia($uploadedFile)
                        ->preservingOriginal()
                        ->toMediaCollection('feature_image', 'cloudinary');
                
                echo "[SUCCESS] Uploaded and linked {$filename} to Product ID {$id} ({$product->name})\n";
                $success++;
            } catch (\Exception $e) {
                echo "[ERROR] Failed to process {$filename}: " . $e->getMessage() . "\n";
                $failed++;
            }
        } else {
            echo "[SKIP] Product ID {$id} not found in database for file {$filename}.\n";
            $failed++;
        }
    } else {
        echo "[SKIP] Filename {$filename} is not numeric.\n";
        $failed++;
    }
}

echo "\n--- SUMMARY ---\n";
echo "Total files: {$total}\n";
echo "Successfully uploaded and linked: {$success}\n";
echo "Failed/Skipped: {$failed}\n";
