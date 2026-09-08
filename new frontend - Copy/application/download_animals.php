<?php
$urls = [
    'https://loremflickr.com/500/500/dog',
    'https://loremflickr.com/500/500/cat',
    'https://loremflickr.com/500/500/puppy',
    'https://loremflickr.com/500/500/kitten',
    'https://loremflickr.com/500/500/dog,cat'
];

$dir = __DIR__.'/../assets/images/frontend/product/';
if (!is_dir($dir)) mkdir($dir, 0777, true);

foreach($urls as $index => $url) {
    $imgId = $index + 1;
    $filename = "animal{$imgId}.jpg";
    $filepath = $dir . $filename;
    
    echo "Downloading {$url} to {$filename}...\n";
    $data = file_get_contents($url);
    if($data) {
        file_put_contents($filepath, $data);
        echo "Saved {$filename}.\n";
    } else {
        echo "Failed to download {$filename}.\n";
    }
}
