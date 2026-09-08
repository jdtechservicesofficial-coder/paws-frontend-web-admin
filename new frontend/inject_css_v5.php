<?php
$layouts = [
    __DIR__ . '/application/resources/views/templates/basic/layouts/frontend.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/master.blade.php',
    __DIR__ . '/application/resources/views/templates/basic/layouts/auth.blade.php',
];

$css = '
    <!-- INJECTED THEME CSS v5 -->
    <style>
        /* 1. All sections must have a blue background */
        section, .bg_img, .ptb-120, .pt-120, .pb-120, body, .page-wrapper, .bg-white, .bg-light, .white-bg { 
            background-color: #0047b3 !important; 
            background-image: none !important; 
        }

        /* 2. All section titles, subtitles, and standard paragraphs on the blue background MUST be visible (white/yellow) */
        h1.section-title, h2.section-title, h3.section-title, .section-title, .page-title, .about-content h1, .about-content h2, .about-content h3 { 
            color: #ffffff !important; 
        }
        span.section-sub-title, .section-sub-title, .text--primary { 
            color: #fdcd01 !important; 
            background-color: transparent !important; 
        }
        
        /* Apply white text to generic paragraphs, but explicitly EXCLUDE paragraphs inside cards */
        section > .container p:not(.service-card p):not(.feature-item p):not(.blog-item p):not(.contact-card p):not(.testimonial-item p), 
        .about-content p, .section-header p, .about-premium-list > p, .section-header .section-title { 
            color: #ffffff !important; 
        }

        /* 3. Protect the white cards so their text remains dark! */
        .service-card, .feature-item, .blog-item, .faq-item, .testimonial-item, .contact-card, .about-thumb, .about-premium-list .bg-white { 
            background-color: #ffffff !important; 
            border: 1px solid #3b82f6 !important; 
        }
        /* Ensure text inside the white cards is dark */
        .service-card *, .feature-item *, .blog-item *, .faq-title .title, .testimonial-item *, .contact-card *, .about-thumb *, .about-premium-list .bg-white * { 
            color: #0f172a !important; 
        }
        /* Except paragraph text inside white cards can be a bit lighter dark */
        .service-card p, .feature-item p, .blog-item p, .contact-card p, .faq-content, .testimonial-item p { 
            color: #475569 !important; 
        }

        /* 4. Shop Cards (Yellow Background, White Text) */
        .product-card, .product-item { 
            background-color: #fdcd01 !important; 
            border: 1px solid #eab308 !important; 
        }
        /* Make text inside product card white, EXCEPT the wishlist button icon */
        .product-card *:not(.addToWishList):not(.addToWishList i), .product-item *:not(.addToWishList):not(.addToWishList i) { 
            color: #ffffff !important; 
        }
        
        /* 5. Fix Cart & Wishlist Icons */
        .addToWishList i { color: #ef4444 !important; }
        .flyingaddToCart i { color: #ffffff !important; }

        /* 6. Buttons (Yellow) */
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

        /* 7. Fix images/dividers that sit on the blue background */
        .service-shape-bg, .section-header-shpae, .bg-shape { 
            filter: brightness(0) invert(1) !important; 
            opacity: 0.8 !important; 
        } 
    </style>
    
    <!-- JavaScript Fallback to Guarantee Header Colors Even if CSS specificity fails -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const subtitles = document.querySelectorAll(".section-sub-title, .text--primary");
            subtitles.forEach(el => {
                el.style.setProperty("color", "#fdcd01", "important");
            });
            
            const titles = document.querySelectorAll("h1.section-title, h2.section-title, h3.section-title, .section-title, .page-title");
            titles.forEach(el => {
                el.style.setProperty("color", "#ffffff", "important");
            });
        });
    </script>
    <!-- END INJECTED THEME CSS v5 -->
';

foreach ($layouts as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        // Remove previous injected CSS if any
        $content = preg_replace('/<!-- INJECTED THEME CSS.*?<!-- END INJECTED THEME CSS(?: v[0-9]+)? -->/is', '', $content);
        
        $content = str_replace('</head>', $css . "\n</head>", $content);
        file_put_contents($file, $content);
        echo "Injected CSS v5 into " . basename($file) . "!\n";
    }
}
