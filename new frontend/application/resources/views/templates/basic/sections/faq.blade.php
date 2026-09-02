@php
$content = getContent('faq.content', true);
$faqs = getContent('faq.element', false, 4);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Faq
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="faq-section ptb-120" style="background: #0047b3;">
    <img src="{{asset($activeTemplateTrue.'images/service-bg.png')}}" alt="shape" class="service-shape-bg">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none flex-wrap-reverse">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="faq-thumb">
                    <img src="{{getImage(getFilePath('frontend').'/faq/'.$content->data_values->image)}}" alt="faq">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="section-header">
                    <span class="section-sub-title" style="color: #fdcd01; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 13px;">{{__($content->data_values->tag)}}</span>
                    <h2 class="section-title" style="font-weight: 800; color: #ffffff; font-size: 34px; line-height: 1.25; margin-top: 8px;">{{__($content->data_values->heading)}}</h2>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape" class="section-header-shpae my-3" style="max-width: 80px;">
                    <p style="color: #ffffff; font-size: 15px; line-height: 1.7;">{{__($content->data_values->subheading)}}</p>
                </div>
                <div class="faq-wrapper mt-4">
                    @foreach($faqs as $item)
                    <div class="faq-item faq-premium-item {{ $loop->index == 0 ? 'active open' : null }}" style="border-radius: 14px; margin-bottom: 15px; border: 1px solid #e2e8f0; background: #ffffff; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <h3 class="faq-title" style="padding: 18px 20px; font-size: 16px; font-weight: 700; color: #1e293b;"><span class="title">{{ __($item->data_values->question) }}</span><span class="right-icon"></span></h3>
                        <div class="faq-content" style="padding: 0 20px 18px 20px; color: #64748b; font-size: 14.5px; line-height: 1.7;">
                            @php echo __($item->data_values->answer) @endphp
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Faq
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
