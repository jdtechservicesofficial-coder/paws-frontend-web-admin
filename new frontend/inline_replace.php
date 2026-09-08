<?php

$dir = __DIR__ . '/application/resources/views/templates/basic/sections/';
$files = glob($dir . '*.blade.php');

$standalone_dir = __DIR__ . '/application/resources/views/templates/basic/';
$standalone_files = [
    $standalone_dir . 'about.blade.php',
    $standalone_dir . 'blog.blade.php',
    $standalone_dir . 'blog_details.blade.php',
    $standalone_dir . 'contact.blade.php',
    $standalone_dir . 'services.blade.php',
    $standalone_dir . 'service.blade.php',
    $standalone_dir . 'shop.blade.php',
];

$all_files = array_merge($files, array_filter($standalone_files, 'file_exists'));

foreach ($all_files as $file) {
    $content = file_get_contents($file);
    
    // 1. Convert Section Backgrounds (White/Light -> Blue)
    // Find <section ... style="background: ..."> and replace the color with #0047b3
    $content = preg_replace('/(<section[^>]*style="[^"]*?background:\s*)(?:#ffffff|#f8fafc|linear-gradient[^;]+)/is', '$1#0047b3', $content);
    // Add blue background to sections missing it (like ptb-120)
    $content = preg_replace('/(<section class="[^"]*ptb-120[^"]*")\s*>/is', '$1 style="background: #0047b3;">', $content);
    
    // 2. Convert Section Headers (Dark -> White)
    $content = preg_replace('/(<h[1-6][^>]*class="[^"]*section-title[^"]*"[^>]*style="[^"]*?color:\s*)#0f172a/is', '$1#ffffff', $content);
    $content = preg_replace('/(<span[^>]*class="[^"]*section-sub-title[^"]*"[^>]*style="[^"]*?color:\s*)#2563eb/is', '$1#fdcd01', $content);
    
    // Convert paragraphs in section-header to white
    $content = preg_replace('/(<div[^>]*class="[^"]*section-header[^"]*"[^>]*>.*?<p[^>]*style="[^"]*?color:\s*)#64748b/is', '$1#ffffff', $content);
    
    // Convert About section generic text to white
    $content = preg_replace('/(<div class="about-premium-list[^>]*>.*?)(color:\s*#[a-f0-9]+)/is', '$1color: #ffffff', $content);
    
    // 3. Shop Cards (White -> Yellow)
    if (strpos($file, 'shop.blade.php') !== false || strpos($file, 'products.blade.php') !== false) {
        // Change product card background
        $content = preg_replace('/(class="[^"]*product-card[^"]*"[^>]*style="[^"]*?background:\s*)#ffffff/is', '$1#fdcd01', $content);
        // Change product card text to white
        $content = preg_replace('/(class="[^"]*product-card[^"]*".*?color:\s*)#0f172a/is', '$1#ffffff', $content);
        $content = preg_replace('/(class="[^"]*product-card[^"]*".*?color:\s*)#64748b/is', '$1#ffffff', $content);
    }
    
    // 4. All primary buttons (Blue -> Yellow)
    $content = preg_replace('/(class="[^"]*btn-primary[^"]*"[^>]*style="[^"]*?background:\s*)#2563eb/is', '$1#fdcd01', $content);
    $content = preg_replace('/(class="[^"]*btn-primary[^"]*"[^>]*onmouseover="[^"]*?this\.style\.background=\')#1d4ed8/is', '$1#eab308', $content);
    $content = preg_replace('/(class="[^"]*btn-primary[^"]*"[^>]*onmouseout="[^"]*?this\.style\.background=\')#2563eb/is', '$1#fdcd01', $content);
    
    file_put_contents($file, $content);
}

// Ensure the frontend layout CSS injection is removed so it doesn't conflict
$layouts = [
    __DIR__ . '/application/resources/views/templates/basic/layouts/frontend.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/master.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/auth.blade.php',
];
foreach ($layouts as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $content = preg_replace('/<!-- INJECTED THEME CSS.*?<!-- END INJECTED THEME CSS(?: v2)? -->/is', '', $content);
        file_put_contents($file, $content);
    }
}

echo "Precise inline replacements completed!\n";
