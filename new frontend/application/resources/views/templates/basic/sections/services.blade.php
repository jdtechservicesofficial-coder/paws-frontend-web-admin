@php
$content = getContent('services.content', true);
$services = \Illuminate\Support\Facades\DB::table('system_services')->where('status', 1)->take(4)->get();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="service-section ptb-120" style="background: #0047b3;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 text-center mb-5">
                <div class="section-header mb-0">
                    <span class="section-sub-title" style="color: #fdcd01; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; font-size: 13px; display: inline-block; background: #eff6ff; padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;">@lang('Our Services')</span>
                    <h2 class="section-title" style="font-weight: 800; color: #ffffff; font-size: 36px; line-height: 1.25; margin-bottom: 12px; letter-spacing: -0.5px;">{{ __($content->data_values->heading ?? 'Premier Pet Care Services') }}</h2>
                    <p style="color: #ffffff; font-size: 15px; line-height: 1.7; max-width: 600px; margin: 0 auto;">{{ __($content->data_values->description ?? 'From premium pet supplies and expert veterinary wellness to gentle professional grooming, we cater to every need of your beloved pets.') }}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape" class="section-header-shpae my-3" style="max-width: 80px;">
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4">
@php
$pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
$colClass = count($services) == 3 ? 'col-xl-4 col-lg-4 col-md-6' : 'col-xl-6 col-lg-6 col-md-12';
@endphp
            @foreach($services as $item)
            @php
            $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Service\Models\SystemService')->where('model_id', $item->id)->first();
            $imageUrl = $media ? getCloudinaryOrLocalUrl($media) : getImage('');
            @endphp
            <div class="{{ $colClass }}">
                <div class="service-card" style="background: #ffffff; border-radius: 20px; padding: 28px 24px; border: 1px solid #e2e8f0; box-shadow: 0 8px 25px rgba(0,0,0,0.03); height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 35px -10px rgba(37,99,235,0.12)'; this.style.borderColor='#93c5fd';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.03)'; this.style.borderColor='#e2e8f0';">
                    <div>
                        <div class="service-thumb mb-4" style="background: #f8fafc; border-radius: 16px; padding: 20px; text-align: center; display: flex; align-items: center; justify-content: center; height: 180px;">
                            <a href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}" style="display: inline-block;">
                                <img src="{{$imageUrl}}" alt="service-image" style="max-height: 140px; max-width: 100%; object-fit: contain; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                        </div>
                        <div class="service-content">
                            <h3 class="title" style="margin-bottom: 10px; font-size: 20px; font-weight: 800; line-height: 1.3;">
                                <a href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}" style="color: #0f172a; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#0f172a'">{{__($item->name)}}</a>
                            </h3>
                            <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">{{ __(strip_tags(substr($item->description, 0, 150))) }}...</p>
                        </div>
                    </div>
                    <div class="service-btn mt-auto">
                        <a class="btn btn-primary w-100" href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}" style="padding: 11px 20px; font-weight: 700; font-size: 14px; border-radius: 10px; background: #2563eb; border: none; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                            @lang('Learn more') <i class="las la-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
