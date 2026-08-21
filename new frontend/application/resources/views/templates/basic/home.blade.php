    @extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $banners = getContent('banner.element', false);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="banner-section bg_img">
    <div class="banner-slider swiper-container" style="overflow: visible !important;">
        <div class="swiper-wrapper">
            @foreach($banners as $banner)
            <div class="swiper-slide">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-lg-6">
                            <div class="banner-content">
                                <h1 class="title">{{__($banner->data_values->heading)}}</h1>
                                <p>{{__($banner->data_values->description)}}</p>
                                @if(!empty($banner->data_values->button_text))
                                <div class="banner-btn">
                                    <a href="{{ url($banner->data_values->button_url) }}"
                                        class="btn--base color-rev">{{__($banner->data_values->button_text)}}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="banner-right-img">
                                <img src="{{getImage(getFilePath('frontend').'/banner/'.$banner->data_values->background_image)}}" alt="Banner Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination" style="display: flex; justify-content: center; align-items: center; position: absolute; bottom: 0px; left: 0; width: 100%; z-index: 10;"></div>
    </div>
    <div class="banner-shape home-shape-01" style="z-index: 20;">
        <img src="{{asset($activeTemplateTrue.'images/inner-shape.png')}}" alt="shape">
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@if($sections->secs != null)
@foreach(json_decode($sections->secs) as $sec)
@include($activeTemplate.'sections.'.$sec)
@endforeach
@endif

@endsection

@push('script')
<script>
    var swiperBanner = new Swiper(".banner-slider", {
        slidesPerView: 1,
        loop: true,
        effect: "fade",
        fadeEffect: {
            crossFade: true
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        speed: 1500,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>
@endpush
