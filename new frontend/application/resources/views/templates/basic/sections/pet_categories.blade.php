@php
$content = getContent('pet_categories.content', true);
$pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
$pawllyCategories = \Illuminate\Support\Facades\DB::table('pets_type')->where('status', 1)->whereNull('deleted_at')->get();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Category
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="category-section ptb-120" style="background: #0047b3;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 text-center mb-5">
                <div class="section-header mb-0">
                    <span class="section-sub-title" style="color: #fdcd01; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; font-size: 13px; display: inline-block; background: #eff6ff; padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;">{{__($content->data_values->tag ?? 'Pet Categories')}}</span>
                    <h2 class="section-title" style="font-weight: 800; color: #ffffff; font-size: 36px; line-height: 1.25; margin-bottom: 12px; letter-spacing: -0.5px;">{{__($content->data_values->heading ?? 'Care for Every Companion')}}</h2>
                    <p style="color: #ffffff; font-size: 15px; line-height: 1.7; max-width: 600px; margin: 0 auto;">{{__($content->data_values->subheading ?? 'From playful dogs and curious cats to small companions, we provide specialized services for every breed.')}}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape" class="section-header-shpae my-3" style="max-width: 80px;">
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4">
            @foreach($pawllyCategories as $item)
            @php
            $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Pet\Models\PetType')->where('model_id', $item->id)->first();
            $imageUrl = $media ? getCloudinaryOrLocalUrl($media) : getImage('');
            @endphp
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 text-center">
                <div class="category-item-card" style="background: #ffffff; border-radius: 24px; padding: 30px 20px; border: 1px solid #e2e8f0; box-shadow: 0 8px 25px rgba(0,0,0,0.03); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 35px -10px rgba(37,99,235,0.12)'; this.style.borderColor='#93c5fd';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.03)'; this.style.borderColor='#e2e8f0';">
                    <div style="width: 140px; height: 140px; border-radius: 50%; overflow: hidden; margin: 0 auto 18px; border: 4px solid #eff6ff; box-shadow: 0 4px 15px rgba(0,0,0,0.06); background: #f1f5f9;">
                        <img src="{{$imageUrl}}" alt="{{$item->name}}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 6px; line-height: 1.3;">{{__($item->name)}}</h3>
                    <span style="display: inline-block; font-size: 13px; color: #2563eb; font-weight: 600; background: #eff6ff; padding: 3px 12px; border-radius: 20px;">@lang('Available Services')</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Category
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
