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
    <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}" />

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color=0052cc&secondColor=fdcd01">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}?v={{time()}}">
    @stack('style-lib')
    @stack('style')

    


    


    


    


    


    


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
    <div class="hide-overlay"></div>
    {{-- <div id="loader" style="background-image: url({{ asset('assets/images/loader.gif') }});"></div> --}}
    <div id="loader">
        <span class="loader"></span>
    </div>


    @include($activeTemplate.'partials.header')
    @if(request()->route()->uri != '/')
    <section class="inner-hero-section" style="position: relative; background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 55%, #0f172a 100%); padding-top: 190px; padding-bottom: 75px; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 350px; height: 350px; background: radial-gradient(circle, rgba(37,99,235,0.25) 0%, rgba(37,99,235,0) 70%); border-radius: 50%; pointer-events: none;"></div>
        <div style="position: absolute; bottom: -50px; left: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, rgba(59,130,246,0) 70%); border-radius: 50%; pointer-events: none;"></div>
        
        <div class="container position-relative" style="z-index: 2;">
            <div class="row justify-content-center text-center">
                <div class="col-xl-8 col-lg-9">
                    <div class="inner-hero-content">
                        <div style="display: inline-flex; align-items: center; background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 30px; padding: 6px 18px; margin-bottom: 16px;">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 align-items-center" style="background: transparent; padding: 0; font-size: 13.5px; font-weight: 600;">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #94a3b8; text-decoration: none;"><i class="las la-home me-1"></i>@lang('Home')</a></li>
                                    <li class="breadcrumb-item active" aria-current="page" style="color: #60a5fa;">{{ __($pageTitle) }}</li>
                                </ol>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @auth
    <section class="dashboard-section pt-4">
        <div class="container">
            <div class="dashboard-wrapper">
                <div class="dashboard-tab">
                    <nav class="nav">
                        <a href="{{ route('user.dashboard') }}"
                            class="nav-link {{ Request::routeIs('user.dashboard') ? 'active' : '' }}">@lang('Dashboard')</a>
                        <a href="{{ route('user.transactions') }}"
                            class="nav-link {{ Request::routeIs('user.transactions') ? 'active' : '' }}">@lang('Transactions')</a>
                        <li class="submenu-wrap">
                            <a href="javascript: voir(0)"
                            class="nav-link"><i class="fas fa-angle-down"></i> @lang('More')</a>
                            <ul class="submenu">
                                <li><a href="{{ route('user.orders') }}"
                                    class="nav-link {{ Request::routeIs('user.orders') ? 'active' : '' }}">@lang('My Orders')</a></li>
                                <li><a class="nav-link" href="{{route('user.get.wishlist')}}">@lang('My Wishlists')</a></li>
                                <li><a class="nav-link" href="{{route('user.consultations')}}">@lang('Consultations')</a></li>
                            </ul>
                        </li>
                    </nav>
                </div>
                <div class="dashboard-user">
                    <div class="content">
                        <h4 class="title me-2"><i class="fas fa-angle-down"></i> {{ '@'.auth()->user()->username}}</h4>
                    </div>
                    <div class="mobile-menu-dashboard">
                        <ul>
                            <li><a href="{{ route('user.profile') }}">@lang('Profile')</a></li>
                            <li><a href="{{ route('user.change.password') }}">@lang('Password')</a></li>
                            <li><a href="{{ route('user.twofactor') }}">@lang('Two Factor Auth')</a></li>
                            <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                        </ul>
                    </div>
                    <div class="thumb">
                        <img src="{{getImage(getFilePath('userProfile').'/'.auth()->user()->id.'/'.auth()->user()->image)}}"
                            alt="user">
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </section>
    @else
    <section class="ptb-80">
        <div class="container">
            @yield('content')
        </div>
    </section>
    @endauth

    @include($activeTemplate.'partials.footer')

    @php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    @endphp
    @if(($cookie->data_values->status == 1) && !\Cookie::get('gdpr_cookie'))
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
    <script src="{{asset($activeTemplateTrue.'js/swiper.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/rangeSlider.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.min.js')}}"></script>
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

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                matched = event.matches;
                if (matched) {
                    $('body').addClass('dark-mode');
                    $('.navbar').addClass('navbar-dark');
                } else {
                    $('body').removeClass('dark-mode');
                    $('.navbar').removeClass('navbar-dark');
                }
            });

            let matched = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (matched) {
                $('body').addClass('dark-mode');
                $('.navbar').addClass('navbar-dark');
            } else {
                $('body').removeClass('dark-mode');
                $('.navbar').removeClass('navbar-dark');
            }

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
