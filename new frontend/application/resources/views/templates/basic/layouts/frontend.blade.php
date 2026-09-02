<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:ital,wght@0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}?v={{time()}}">
    @stack('style-lib')
    @stack('style')
    <link rel="stylesheet"
        href="{{ asset($activeTemplateTrue.'css/color.php') }}?color=0052cc&secondColor=fdcd01">

    


    


    


    


    


    


    <!-- INJECTED THEME CSS v7 -->
    <style>
        /* 1. All sections must have a blue background */
        section, .bg_img, .ptb-120, .pt-120, .pb-120, body, .page-wrapper, .bg-white, .bg-light, .white-bg { 
            background-color: #0047b3 !important; 
            background-image: none !important; 
        }

        /* 2. Fix ALL wavy paper match dividers to be blue! */
        .service-shape-bg, .section-header-shpae, .bg-shape, .testimonial-top-shape img, .testimonial-bottom-shape img, 
        .banner-shape img, .footer-top-shape img, .cart-details-bg, .single-shop-bg { 
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
    <!-- END INJECTED THEME CSS v7 -->

</head>

<body>
        <div id="loader">
            <span class="loader"></span>
        </div>
    @include($activeTemplate.'partials.header')

    @if(request()->route()->uri != '/')
    <section class="breadcrumb-section bg_img">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="banner-content">
                        <div class="breadcrumb-area">
                            <nav aria-label="breadcrumb">
                                <h1 class="title">{{ __($pageTitle) }}</h1>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endif

    @yield('content')
    @include($activeTemplate.'partials.footer')

    @php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    @endphp
    @if(($cookie && @$cookie->data_values->status == 1) && !\Cookie::get('gdpr_cookie'))
    <!-- cookies dark version start -->
    <div class="cookies-card hide">
        <h2 class="section-title">@lang('GDPR Cookie Policy')</h2>
        <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a
                href="{{ route('cookie.policy') }}" class="text--primary" target="_blank">@lang('learn more')</a></p>
        <div class="cookies-card__btn mt-4">
            <a href="javascript:void(0)" class="btn btn--base policy">@lang('Accept')</a>
        </div>
    </div>
    <!-- cookies dark version end -->
    @endif


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/common/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/common/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/swiper.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/rangeSlider.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>


    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')


    <script>
        (function ($) {
            "use strict";
            $(".language-select").on("change", function () {
                window.location.href = "{{route('home')}}/change/" + $(this).val();
            });

            var inputElements = $('input,select');
            $.each(inputElements, function (index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $('.policy').on('click', function () {
                $.get('{{route('cookie.accept')}}', function (response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function () {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function (index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function (i, element) {

                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }

            });

        })(jQuery);
    </script>

</body>

</html>
