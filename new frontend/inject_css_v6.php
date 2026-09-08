<?php
$layouts = [
    __DIR__ . '/application/resources/views/templates/basic/layouts/frontend.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/master.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/auth.blade.php',
];

$css = '
    <!-- INJECTED THEME CSS v6 -->
    <style>
        /* 1. All sections must have a blue background */
        section, .bg_img, .ptb-120, .pt-120, .pb-120, body, .page-wrapper, .bg-white, .bg-light, .white-bg { 
            background-color: #0047b3 !important; 
            background-image: none !important; 
        }

        /* 2. Fix the wavy paper match dividers to be blue! */
        .service-shape-bg, .section-header-shpae, .bg-shape, .testimonial-top-shape img, .testimonial-bottom-shape img { 
            /* This filter converts white to the deep blue (#0047b3) */
            filter: brightness(0) invert(16%) sepia(99%) saturate(3475%) hue-rotate(211deg) brightness(85%) contrast(101%) !important; 
            opacity: 1 !important; 
        } 

        /* 3. Section Titles and Subtitles (White and Yellow) */
        h1.section-title, h2.section-title, h3.section-title, .section-title, .page-title, .about-content h1, .about-content h2, .about-content h3 { 
            color: #ffffff !important; 
        }
        span.section-sub-title, .section-sub-title, .text--primary { 
            color: #fdcd01 !important; 
            background-color: transparent !important; 
        }
        
        /* 4. Only target SPECIFIC generic paragraphs on the blue background to be white (safely) */
        .about-content p, .section-header p, .about-premium-list > p, .section-header .section-title { 
            color: #ffffff !important; 
        }

        /* 5. Force the white cards to retain their background */
        .service-card, .feature-item, .blog-item, .faq-item, .testimonial-wrapper, .contact-widget, .about-thumb, .about-premium-list .bg-white { 
            background-color: #ffffff !important; 
            border: 1px solid #3b82f6 !important; 
        }
        
        /* 6. Ensure text inside specific cards is dark (Do NOT use * wildcard to avoid breaking icons/dates) */
        .service-card .title a, .feature-item .title, .blog-item .title a, .faq-title .title, .testimonial-wrapper .title, .contact-widget .title { 
            color: #0f172a !important; 
        }
        .service-card p, .feature-item p, .blog-item p, .contact-widget p, .faq-content, .faq-content p, .testimonial-wrapper p, .testimonial-wrapper .sub-title { 
            color: #475569 !important; 
        }

        /* 7. Shop Cards (Yellow Background, White Text) */
        .product-card, .product-item { 
            background-color: #fdcd01 !important; 
            border: 1px solid #eab308 !important; 
        }
        .product-card .title a, .product-card .price, .product-item .title a, .product-item .price { 
            color: #ffffff !important; 
        }
        
        /* 8. Fix Cart & Wishlist Icons */
        .addToWishList i { color: #ef4444 !important; }
        .flyingaddToCart i { color: #ffffff !important; }

        /* 9. Buttons (Yellow) */
        .btn-primary:not(.call-to-action-section .btn-primary), .cmn-btn, .btn-main, button.btn:not(.addToWishList):not(.flyingaddToCart) { 
            background-color: #fdcd01 !important; 
            border-color: #fdcd01 !important; 
            color: #0f172a !important; 
            box-shadow: 0 4px 12px rgba(253, 205, 1, 0.25) !important; 
        }
        .btn-primary:hover:not(.call-to-action-section .btn-primary), .cmn-btn:hover, .btn-main:hover, button.btn:hover:not(.addToWishList):not(.flyingaddToCart) { 
            background-color: #eab308 !important; 
            border-color: #eab308 !important; 
            color: #0f172a !important; 
        }
    </style>
    
    <!-- JavaScript Fallback to Guarantee Header Colors Even if CSS specificity fails -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const subtitles = document.querySelectorAll(".section-sub-title, .text--primary");
            subtitles.forEach(el => {
                el.style.setProperty("color", "#fdcd01", "important");
                el.style.setProperty("background-color", "transparent", "important");
            });
            
            const titles = document.querySelectorAll("h1.section-title, h2.section-title, h3.section-title, .section-title, .page-title");
            titles.forEach(el => {
                el.style.setProperty("color", "#ffffff", "important");
            });
        });
    </script>
    <!-- END INJECTED THEME CSS v6 -->
';

foreach ($layouts as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        // Remove previous injected CSS if any
        $content = preg_replace('/<!-- INJECTED THEME CSS.*?<!-- END INJECTED THEME CSS(?: v[0-9]+)? -->/is', '', $content);
        
        $content = str_replace('</head>', $css . "\n</head>", $content);
        file_put_contents($file, $content);
        echo "Injected CSS v6 into " . basename($file) . "!\n";
    }
}
