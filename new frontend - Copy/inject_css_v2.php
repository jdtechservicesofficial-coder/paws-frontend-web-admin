<?php
$layouts = [
    __DIR__ . '/application/resources/views/templates/basic/layouts/frontend.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/master.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/auth.blade.php',
];

$css = '
    <!-- INJECTED THEME CSS v2 -->
    <style>
        /* Force Blue Backgrounds for all sections, pages, and any hardcoded white backgrounds */
        section, .ptb-120, .pt-120, .pb-120, body, .page-wrapper, .bg-white, .bg-light, .white-bg { 
            background-color: #0047b3 !important; 
            background-image: none !important; 
        }
        
        /* Force White/Yellow Text for Elements directly on the Blue Background */
        .section-title, .page-title, .about-content h1, .about-content h2, .about-content h3 { 
            color: #ffffff !important; 
        }
        .section-sub-title, .text--primary { 
            color: #fdcd01 !important; 
            background-color: transparent !important; 
        }
        /* All general paragraphs inside sections (like the About write-up) */
        section > .container p, .about-content p, .section-header p, .about-premium-list > p { 
            color: #ffffff !important; 
        }
        
        /* PROTECT THE CARDS (White Background, Dark Text) */
        .service-card, .feature-item, .blog-item, .faq-item, .testimonial-item, .contact-card, .about-thumb, .about-premium-list .bg-white { 
            background-color: #ffffff !important; 
            border: 1px solid #3b82f6 !important; 
        }
        /* Make sure text inside WHITE cards is dark so it is visible */
        .service-card h1, .service-card h2, .service-card h3, .service-card h4, .service-card h5, .service-card h6, .service-card .title, .service-card .title a,
        .feature-item h1, .feature-item h2, .feature-item h3, .feature-item .title,
        .blog-item h1, .blog-item h2, .blog-item h3, .blog-item .title, .blog-item .title a,
        .faq-title .title, .testimonial-item .name, .contact-card .title,
        .about-thumb h5, .about-thumb span, .about-premium-list .bg-white * { 
            color: #0f172a !important; 
        }
        .service-card p, .feature-item p, .blog-item p, .contact-card p, .faq-content { 
            color: #475569 !important; 
        }
        
        /* SHOP CARDS (Yellow Background, White Text) */
        .product-card, .product-item { 
            background-color: #fdcd01 !important; 
            border: 1px solid #eab308 !important; 
        }
        .product-card h1, .product-card h2, .product-card h3, .product-card h4, .product-card .title, .product-card .title a, .product-card p, .product-card .price { 
            color: #ffffff !important; 
        }
        
        /* Buttons (Yellow) */
        .btn-primary, .cmn-btn, .btn-main, button.btn { 
            background-color: #fdcd01 !important; 
            border-color: #fdcd01 !important; 
            color: #0f172a !important; 
            box-shadow: 0 4px 12px rgba(253, 205, 1, 0.25) !important; 
        }
        .btn-primary:hover, .cmn-btn:hover, .btn-main:hover, button.btn:hover { 
            background-color: #eab308 !important; 
            border-color: #eab308 !important; 
            color: #0f172a !important; 
        }
        
        /* Fix images/dividers that sit on the blue background */
        .service-shape-bg, .section-header-shpae, .bg-shape { 
            filter: brightness(0) invert(1) !important; 
            opacity: 0.8 !important; 
        } 
    </style>
    <!-- END INJECTED THEME CSS v2 -->
';

foreach ($layouts as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        // Remove previous injected CSS
        $content = preg_replace('/<!-- INJECTED THEME CSS -->.*?<!-- END INJECTED THEME CSS -->/s', '', $content);
        $content = preg_replace('/<!-- INJECTED THEME CSS v2 -->.*?<!-- END INJECTED THEME CSS v2 -->/s', '', $content);
        
        $content = str_replace('</head>', $css . "\n</head>", $content);
        file_put_contents($file, $content);
        echo "Injected refined CSS into " . basename($file) . "!\n";
    }
}
