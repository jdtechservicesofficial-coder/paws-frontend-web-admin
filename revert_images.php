<?php
/**
 * Script to revert image renaming by subtracting 1191
 */

$folderPath = __DIR__ . '/public/bulk_images';

if (!is_dir($folderPath)) {
    die("Error: folder public/bulk_images not found.\n");
}

$files = scandir($folderPath);
$offset = 1191;
$reverted = 0;
$skipped = 0;

echo "Starting revert process...\n";
echo str_repeat("-", 40) . "\n";

foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }

    $filePath = $folderPath . '/' . $file;

    if (is_file($filePath)) {
        $pathInfo = pathinfo($file);
        $filename = $pathInfo['filename'];
        $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';

        // Only revert if it's a number and greater than the offset
        if (is_numeric($filename) && (int)$filename > $offset) {
            $oldNumber = (int)$filename - $offset;
            $oldFilename = $oldNumber . $extension;
            $oldFilePath = $folderPath . '/' . $oldFilename;

            if (rename($filePath, $oldFilePath)) {
                echo "Reverted: {$file} -> {$oldFilename}\n";
                $reverted++;
            } else {
                echo "Failed to revert: {$file}\n";
                $skipped++;
            }
        } else {
            echo "Skipped (not reverted): {$file}\n";
            $skipped++;
        }
    }
}

echo str_repeat("-", 40) . "\n";
echo "Done! Successfully reverted {$reverted} files.\n";
