@php
$content = getContent('about.content', true);
@endphp
<section class="about-section ptb-120" style="background: #0047b3;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="about-thumb" style="position: relative; border-radius: 24px; overflow: hidden; background: #f8fafc; border: 1px solid #e2e8f0; box-shadow: 0 15px 35px -5px rgba(0,0,0,0.06); padding: 12px;">
                    <img src="{{getImage(getFilePath('frontend').'/about/'.$content->data_values->image)}}" alt="about" style="width: 100%; border-radius: 18px; object-fit: cover;">
                    <div style="position: absolute; bottom: 24px; left: 24px; background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(8px); border-radius: 14px; padding: 12px 20px; color: #ffffff; display: flex; align-items: center; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                        <i class="fas fa-heart text-danger me-3" style="font-size: 24px;"></i>
                        <div>
                            <h5 style="color: #ffffff; margin: 0; font-size: 15px; font-weight: 800;">100% Pet Focused</h5>
                            <span style="font-size: 12px; color: #cbd5e1;">Trusted by caring pet parents</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <span class="section-sub-title" style="color: #fdcd01; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; font-size: 13px; display: inline-block; background: #eff6ff; padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;">{{__($content->data_values->subheading ?? 'About PAW&Paws')}}</span>
                    <h2 class="section-title" style="font-weight: 800; color: #ffffff; font-size: 34px; line-height: 1.25; margin-bottom: 12px; letter-spacing: -0.5px;">{{__($content->data_values->heading)}}</h2>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape" class="section-header-shpae my-3" style="max-width: 80px;">
                    <div class="about-premium-list mt-3">
                        @php echo __($content->data_values->description) @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>