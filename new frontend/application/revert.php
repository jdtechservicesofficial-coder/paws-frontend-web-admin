<?php
$files = [
    'resources/views/templates/basic/services.blade.php',
    'resources/views/templates/basic/service.blade.php',
    'resources/views/templates/basic/sections/shop.blade.php',
    'resources/views/templates/basic/sections/services.blade.php',
    'resources/views/templates/basic/sections/pet_categories.blade.php',
    'resources/views/templates/basic/sections/blog.blade.php',
    'resources/views/templates/basic/blog_details.blade.php',
    'resources/views/templates/basic/blogs.blade.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Revert DB::table
    $content = str_replace(
        '\Spatie\MediaLibrary\MediaCollections\Models\Media::where',
        '\Illuminate\Support\Facades\DB::table(\'media\')->where',
        $content
    );
    
    // Replace $media->getUrl() with getCloudinaryOrLocalUrl($media)
    $content = str_replace(
        '$media->getUrl()',
        'getCloudinaryOrLocalUrl($media)',
        $content
    );
    
    file_put_contents($file, $content);
}
echo "Done";
