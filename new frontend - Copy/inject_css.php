<?php
$layouts = [
    __DIR__ . '/application/resources/views/templates/basic/layouts/frontend.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/master.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/auth.blade.php',
];

$css = '
    <!-- INJECTED THEME CSS -->
    <style>
        /* Force Blue Backgrounds for all sections and body */
        section, .ptb-120, body, .page-wrapper { background-color: #0047b3 !important; background-image: none !important; }
        
        /* Force White/Yellow Text for Section Headers directly on blue background */
        .section-title { color: #ffffff !important; }
        .section-sub-title { color: #fdcd01 !important; background-color: transparent !important; }
        .section-header p { color: #e2e8f0 !important; }
        
        /* Buttons -> Yellow */
        .btn-primary { background-color: #fdcd01 !important; border-color: #fdcd01 !important; color: #000 !important; box-shadow: 0 4px 12px rgba(253, 205, 1, 0.25) !important; }
        .btn-primary:hover { background-color: #eab308 !important; border-color: #eab308 !important; color: #000 !important; }
        
        /* Fix images/dividers that sit on the blue background */
        .service-shape-bg, .section-header-shpae, .bg-shape { filter: brightness(0) invert(1) !important; opacity: 0.8 !important; } 
        
        /* Standalone page headers */
        .page-header { background-color: #003d99 !important; }
        .page-title { color: #fdcd01 !important; }
        .breadcrumb li { color: #ffffff !important; }
        
        /* Text overrides for elements directly on blue */
        .faq-title { background: #0052cc !important; border-color: #3b82f6 !important; }
        .faq-title .title { color: #ffffff !important; }
        
        .counter-item .title, .counter-item .number { color: #ffffff !important; }
        
    </style>
    <!-- END INJECTED THEME CSS -->
';

foreach ($layouts as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        // Remove previous injected CSS if exists
        $content = preg_replace('/<!-- INJECTED THEME CSS -->.*?<!-- END INJECTED THEME CSS -->/s', '', $content);
        
        $content = str_replace('</head>', $css . "\n</head>", $content);
        file_put_contents($file, $content);
        echo "Injected CSS into " . basename($file) . "!\n";
    }
}
