@php
$content = getContent('contact_us.content', true);
$pawllyEmail = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'inquriy_email')->value('val') ?? @$content->data_values->email_address;
$pawllyPhone = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'helpline_number')->value('val') ?? @$content->data_values->contact_number;
$socialIcons = getContent('social_icon.element', false, 4);
$languages = App\Models\Language::all();
$wishlistCount = \Illuminate\Support\Facades\Schema::hasTable('wishlists') ? App\Models\Wishlist::where('user_id',@auth()->user()->id)->count() : 0;
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<header class="header-section">
    <div class="header">
        <div class="header-top-area" style="background: #0b132b; border-bottom: 1px solid rgba(255,255,255,0.08); padding: 8px 0;">
            <div class="container">
                <div class="header-top-menu d-flex align-items-center justify-content-between">
                    <div class="left">
                        <ul class="header-contact-list list-unstyled mb-0 d-flex align-items-center gap-4">
                            <li>
                                <a href="mailto:{{$pawllyEmail}}" style="color: #cbd5e1; font-size: 13px; font-weight: 500; text-decoration: none; display: flex; align-items: center;">
                                    <i class="las la-envelope me-2" style="color: #60a5fa; font-size: 16px;"></i> {{$pawllyEmail}}
                                </a>
                            </li>
                            <li>
                                <a href="tel:{{$pawllyPhone}}" style="color: #cbd5e1; font-size: 13px; font-weight: 500; text-decoration: none; display: flex; align-items: center;">
                                    <i class="las la-phone me-2" style="color: #60a5fa; font-size: 16px;"></i> {{$pawllyPhone}}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="right d-flex align-items-center gap-3">
                        <ul class="header-social list-unstyled mb-0 d-flex align-items-center gap-2">
                            @foreach($socialIcons as $icon)
                            <li>
                                <a href="{{$icon->data_values->url}}" style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.08); color: #cbd5e1; display: flex; align-items: center; justify-content: center; font-size: 14px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#2563eb'; this.style.color='#fff';" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#cbd5e1';">
                                    @php echo $icon->data_values->social_icon; @endphp
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="language-select-area">
                            <select class="language-select" style="background: rgba(255,255,255,0.08); color: #ffffff; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 4px 10px; font-size: 12px; font-weight: 600;">
                                @foreach($languages as $lang)
                                <option value="{{ $lang->code }}" @if(Session::get('lang')===$lang->code) selected @endif style="color: #000;">{{ __($lang->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="header-action ms-2">
                            @guest
                            <a href="{{ route('user.login') }}" class="btn btn-primary" style="background: #2563eb; color: #fff; font-weight: 700; font-size: 13.5px; border-radius: 10px; padding: 6px 18px; border: none; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35); text-decoration: none; display: inline-flex; align-items: center;">
                               @lang('Login') <i class="las la-sign-in-alt ms-1"></i>
                            </a>
                            @else
                            <a href="{{ route('user.dashboard') }}" class="btn btn-primary" style="background: #2563eb; color: #fff; font-weight: 700; font-size: 13.5px; border-radius: 10px; padding: 6px 18px; border: none; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35); text-decoration: none; display: inline-flex; align-items: center;">
                                @lang('Dashboard') <i class="las la-tachometer-alt ms-1"></i>
                            </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom-area" style="padding: 10px 0;">
            <div class="container">
                <div class="header-menu-content" style="background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 70%, #0f172a 100%); backdrop-filter: blur(12px); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.18); padding: 8px 24px;">
                    <nav class="navbar navbar-expand-lg p-0 align-items-center">
                        <a class="site-logo site-title" href="{{ route('home') }}">
                            <img src="{{siteLogo()}}" alt="logo" style="max-height: 46px; object-fit: contain;">
                        </a>
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation" style="border: 1px solid rgba(0,0,0,0.1); padding: 6px 10px; border-radius: 8px;">
                            <span class="fas fa-bars" style="color: #1e293b;"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ms-auto align-items-center mb-0" id="mobile-menu">
                                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" style="color: #ffffff;">@lang('Home')</a></li>
                                <li><a href="{{ route('pages', 'about') }}" class="{{ request()->is('about') ? 'active' : '' }}" style="color: #ffffff;">@lang('About')</a></li>
                                <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop*') ? 'active' : '' }}" style="color: #ffffff;">@lang('Shop')</a></li>
                                <li><a href="{{ route('services') }}" class="{{ request()->routeIs('service*') ? 'active' : '' }}" style="color: #ffffff;">@lang('Services')</a></li>
                                <li><a href="{{ route('blogs') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}" style="color: #ffffff;">@lang('Blog')</a></li>
                                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}" style="color: #ffffff;">@lang('Contact')</a></li>
                                <li class="d-flex align-items-center ms-lg-3 mt-3 mt-lg-0">
                                    <a href="{{route('get.cart')}}" title="Cart" style="width: 42px; height: 42px; border-radius: 12px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; position: relative; text-decoration: none; margin-right: 8px; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                                        <i class="fas fa-shopping-cart" style="color: #1e293b; font-size: 16px; transition: all 0.2s;"></i>
                                        <span id="cartItem" style="position: absolute; top: -6px; right: -6px; background: #2563eb; color: #ffffff; border-radius: 50%; width: 20px; height: 20px; font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; border: 2px solid #ffffff;">{{ auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->count() : count((array) session('cart')) }}</span>
                                    </a>
                                    <a href="{{route('user.get.wishlist')}}" title="Wishlist" style="width: 42px; height: 42px; border-radius: 12px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; position: relative; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                                        <i class="fas fa-heart" style="color: #f87171; font-size: 16px; transition: all 0.2s;"></i>
                                        <span id="wishlistItem" style="position: absolute; top: -6px; right: -6px; background: #ef4444; color: #ffffff; border-radius: 50%; width: 20px; height: 20px; font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; border: 2px solid #ffffff;">{{ auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0 }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>


<button class="scrollToTop">
    <i class="las la-arrow-up"></i>
</button>



<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
