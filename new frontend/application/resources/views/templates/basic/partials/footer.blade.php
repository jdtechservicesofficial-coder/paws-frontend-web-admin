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
<footer class="footer-section pt-100 bg_img" data-background="{{asset($activeTemplateTrue.'images/footer-bg-01.png')}}">

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
