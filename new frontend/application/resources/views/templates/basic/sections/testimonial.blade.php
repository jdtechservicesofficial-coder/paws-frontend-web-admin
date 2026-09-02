@php
$content = getContent('testimonial.content', true);
$testimonials = getContent('testimonial.element', false, 4);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
{{-- data-background="{{getImage(getFilePath('shapes').'/client-bg.png')}}" --}}
<section class="testimonial-section bg_img" >
    <div class="testimonial-top-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>
    <div class="testimonial-bottom-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 text-center">
                <div class="section-header">
                    <span class="section-sub-title">{{__($content->data_values->tag)}}</span>
                    <h2 class="section-title">{{__($content->data_values->heading)}}</h2>
                    <p>{{__($content->data_values->subheading)}}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="section-header-shpae">
                </div>
            </div>
        </div>
        <div class="testimonial-area">
            <div class="testimonial-slider">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $item)
                    <div class="swiper-slide">
                        <div class="testimonial-wrapper" style="background: #ffffff; border-radius: 20px; padding: 35px 30px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.04); height: 100%;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="thumb profile-photo me-3" style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; border: 2px solid #2563eb;">
                                    <img src="{{getImage(getFilePath('frontend').'/testimonial/'.$item->data_values->profile_photo)}}" alt="client" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <h3 class="title" style="font-size: 17px; font-weight: 700; color: #0f172a; margin-bottom: 2px;">{{__($item->data_values->name)}}</h3>
                                    <span class="sub-title" style="font-size: 13px; color: #2563eb; font-weight: 600;">{{__($item->data_values->designation)}}</span>
                                </div>
                            </div>
                            <div class="rating-wrap mb-3 text-warning" style="font-size: 14px; color: #f59e0b;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="content">
                                <p style="color: #475569; font-size: 14.5px; line-height: 1.7; font-style: italic; margin: 0;">"{{__($item->data_values->comment)}}"</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
