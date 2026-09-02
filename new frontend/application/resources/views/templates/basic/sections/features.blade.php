@php
$content = getContent('features.content', true);
$categories = getContent('features.element', false, 4);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="feature-section ptb-120" style="background: #0047b3;">
    <div class="container">
        <div class="row align-items-center mb-30-none">
            <div class="col-xl-5 col-lg-5 mb-30">
                <div class="section-header mb-0">
                    <span class="section-sub-title" style="color: #fdcd01; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 13px;">{{__($content->data_values->tag)}}</span>
                    <h2 class="section-title" style="font-weight: 800; color: #ffffff; font-size: 34px; line-height: 1.25; margin-top: 8px;">{{__($content->data_values->heading)}}</h2>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape" class="section-header-shpae my-3" style="max-width: 80px;">
                    <p style="color: #ffffff; font-size: 15px; line-height: 1.7;">{{__($content->data_values->description)}}</p>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 mb-30">
                <div class="feature-item-area">
                    <div class="row g-4">
                        @foreach($categories as $item)
                        <div class="col-md-6">
                            <div class="feature-item" style="background: #f8fafc; border-radius: 16px; padding: 26px 22px; border: 1px solid #e2e8f0; transition: all 0.3s ease; height: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                                <div class="thumb mb-3" style="display: inline-flex; align-items: center; justify-content: center; width: 52px; height: 52px; border-radius: 12px; background: #eff6ff; color: #2563eb; font-size: 22px;">
                                    @php echo $item->data_values->icon; @endphp
                                </div>
                                <div class="content">
                                    <h3 class="title" style="font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">{{__($item->data_values->title)}}</h3>
                                    <p style="color: #64748b; font-size: 13.5px; line-height: 1.6; margin: 0;">{{__($item->data_values->description)}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
