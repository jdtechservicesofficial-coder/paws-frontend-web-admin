<?php
$layouts = [
    __DIR__ . '/application/resources/views/templates/basic/layouts/frontend.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/master.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/auth.blade.php',
];

$css = '
    <!-- INJECTED THEME CSS v3 -->
    <style>
        /* Force White Text for Database-Driven About Content */
        .about-premium-list *, .about-content p, .section-header p, section > .container p { 
            color: #ffffff !important; 
        }
        
        /* Protect the white cards text just in case */
        .service-card *, .feature-item *, .blog-item *, .faq-title *, .testimonial-item *, .contact-card *, .about-thumb * {
            color: #0f172a !important;
        }
        
        /* Ensure Shop Cards have white text */
        .product-card *, .product-item * {
            color: #ffffff !important;
        }
    </style>
    <!-- END INJECTED THEME CSS v3 -->
';

foreach ($layouts as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        // Remove previous injected CSS if any
        $content = preg_replace('/<!-- INJECTED THEME CSS.*?<!-- END INJECTED THEME CSS(?: v[0-9]+)? -->/is', '', $content);
        
        $content = str_replace('</head>', $css . "\n</head>", $content);
        file_put_contents($file, $content);
        echo "Injected CSS to fix database text into " . basename($file) . "!\n";
    }
}
