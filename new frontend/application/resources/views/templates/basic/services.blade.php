@extends($activeTemplate.'layouts.frontend')
@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="service-section ptb-120" style="background: #0047b3;">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-8 col-lg-8">
                <div class="row g-4">
                    @php
                    $pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
                    @endphp
                    @foreach($services as $item)
                    @php
                    $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Service\Models\SystemService')->where('model_id', $item->id)->first();
                    $imageUrl = $media ? getCloudinaryOrLocalUrl($media) : getImage('');
                    @endphp
                    <div class="col-md-6">
                        <div class="service-card" style="background: #ffffff; border-radius: 20px; padding: 24px; border: 1px solid #e2e8f0; box-shadow: 0 6px 20px rgba(0,0,0,0.03); height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 35px -10px rgba(37,99,235,0.12)'; this.style.borderColor='#93c5fd';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.03)'; this.style.borderColor='#e2e8f0';">
                            <div>
                                <div class="service-thumb mb-3" style="background: #f8fafc; border-radius: 16px; padding: 16px; text-align: center; display: flex; align-items: center; justify-content: center; height: 160px;">
                                    <a href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}">
                                        <img src="{{$imageUrl}}" alt="{{$item->name}}" style="max-height: 130px; max-width: 100%; object-fit: contain;">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="title" style="margin-bottom: 8px; font-size: 18px; font-weight: 800; line-height: 1.3;">
                                        <a href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}" style="color: #0f172a; text-decoration: none;">{{__($item->name)}}</a>
                                    </h3>
                                    <p style="color: #64748b; font-size: 13.5px; line-height: 1.6; margin-bottom: 16px;">{{ __(strip_tags(substr($item->description, 0, 110))) }}...</p>
                                </div>
                            </div>
                            <div class="service-btn mt-auto">
                                <a class="btn btn-primary w-100" href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}" style="padding: 10px 18px; font-weight: 700; font-size: 13.5px; border-radius: 10px; background: #2563eb; border: none; display: flex; align-items: center; justify-content: center;">
                                    @lang('Learn more') <i class="las la-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar" style="position: sticky; top: 100px;">
                    <div style="background: #ffffff; border-radius: 20px; padding: 28px 24px; border: 1px solid #e2e8f0; box-shadow: 0 8px 25px rgba(0,0,0,0.03);">
                        <h4 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 18px; display: flex; align-items: center;">
                            <span style="width: 4px; height: 18px; background: #2563eb; border-radius: 4px; display: inline-block; margin-right: 10px;"></span>
                            @lang('All Pet Services')
                        </h4>
                        <div class="category-widget-box">
                            <ul class="list-unstyled mb-0" style="display: flex; flex-direction: column; gap: 10px;">
                                @foreach($services as $item)
                                <li>
                                    <a href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0; color: #1e293b; font-weight: 700; font-size: 14px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#93c5fd'; this.style.color='#2563eb';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.color='#1e293b';">
                                        <span>{{__($item->name)}}</span>
                                        <i class="las la-angle-right" style="color: #2563eb;"></i>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection