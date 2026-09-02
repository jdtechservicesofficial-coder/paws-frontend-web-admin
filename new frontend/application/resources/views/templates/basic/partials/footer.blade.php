@php
$content = getContent('contact_us.content', true);
$pawllyEmail = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'inquriy_email')->value('val') ?? @$content->data_values->email_address;
$pawllyPhone = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'helpline_number')->value('val') ?? @$content->data_values->contact_number;
$pawllyCopyright = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'copyright_text')->value('val');
$pawllyFooterText = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'footer_text')->value('val');
$socialIcons = getContent('social_icon.element', false, 4);
$policyPages = \Illuminate\Support\Facades\DB::table('pages')->whereIn('slug', ['privacy-policy', 'terms-conditions'])->get();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<style>
    /* Brand Colors for Footer */
    .footer-section {
        background-color: #0052cc !important; /* Brand Blue */
        background-image: none !important;
    }
    .footer-section:before,
    .footer-section::before {
        display: none !important; /* Remove the old secondary color overlay */
    }
    .footer-section .title {
        color: #ffcc00 !important; /* Brand Yellow for headings */
    }
    .footer-section p,
    .footer-section a,
    .footer-section li,
    .footer-section i,
    .footer-section span {
        color: #ffffff !important;
    }
    .footer-section a:hover {
        color: #ffcc00 !important;
    }
    .footer-section .btn--base {
        background-color: #ffcc00 !important;
        color: #000000 !important;
        border-color: #ffcc00 !important;
        font-weight: bold;
    }
    .footer-section .btn--base:hover {
        background-color: #e6b800 !important;
    }
    .footer-section .footer-shpae {
        display: none !important; /* Hide the old dark shapes */
    }
    .footer-section .form--control {
        background: #ffffff !important;
        color: #000000 !important;
    }
</style>
<footer class="footer-section pt-100">

    <div class="footer-top-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>

    <div class="container">
        <div class="footer-top-area">
            <div class="footer-logo">
                <a class="site-logo site-title" href="{{ route('home') }}"><img
                        src="{{siteLogo()}}" alt="site-logo"></a>
            </div>
            <div class="social-area">
                <ul class="footer-social">
                    @foreach($socialIcons as $icon)
                    <li><a href="{{$icon->data_values->url}}">@php echo $icon->data_values->social_icon;
                            @endphp</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row mb-30-none justify-content-center">
            <div class="col-xl-3 col-lg-4 col-md-6 mb-30">
                <div class="footer-widget">
                    <h3 class="title">@lang('About Us')</h3>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="footer-shpae">
                    <p>{{$pawllyFooterText ?? $content->data_values->footer_short_details}}</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-30">
                <div class="footer-widget">
                    <h3 class="title">@lang('Contact Info')</h3>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="footer-shpae">
                    <ul class="footer-list">
                        <li class="d-flex"><i class="las la-phone"></i><a
                                href="tel:{{$pawllyPhone}}">
                                {{$pawllyPhone}}</a></li>
                        <li class="d-flex"><i class="las la-envelope"></i><a
                                href="mailto:{{$pawllyEmail}}">
                                {{$pawllyEmail}}</a></li>
                        <li class="d-flex"><i class="las la-map-marker-alt"></i><a href="javascript:void(0)">
                                {!! __($content->data_values->address) !!}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-30">
                <div class="footer-widget">
                    <h3 class="title">@lang('Useful Links')</h3>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="footer-shpae">
                    <ul class="footer-list">
                        @foreach($pages as $page)
                        @if($page->slug != 'contact' && $page->slug != 'pricing' && $page->slug != 'shop' && $page->slug != 'about')
                        <li><a href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                        </li>
                        @endif
                        @endforeach
                        @foreach($policyPages as $page)
                        <li><a
                                href="{{ route('policy.details', ['slug' => $page->slug, 'id' => $page->id]) }}">{{
                                __($page->name) }}</a>
                        </li>
                        @endforeach
                        <li><a href="{{ route('cookie.policy') }}">@lang('Cookie Policy')</a>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-30">
                <div class="footer-widget">
                    <h3 class="title">@lang('Newsletter')</h3>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="footer-shpae">
                    <form class="newsletter-form" method="post" action="{{ route('subscribe') }}">
                        @csrf
                        <input type="email" class="form--control" name="email" placeholder="@lang('Your email')...">
                        <button type="submit" class="btn--base w-100">@lang('Subscribe')</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <p class="text-center text-white">@php echo $pawllyCopyright ?? $content->data_values->website_footer; @endphp</p>
        </div>
    </div>
</footer>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
