@extends($activeTemplate.'layouts.frontend')
@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="service-section ptb-120" style="background: #0047b3;">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8 col-lg-8 mb-30">
                <div class="row justify-content-center mb-30-none">
                    <div class="col-xl-12 mb-30">
                        @php
                        $pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
                        $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Service\Models\SystemService')->where('model_id', $service->id)->first();
                        $imageUrl = $media ? getCloudinaryOrLocalUrl($media) : getImage('');
                        @endphp
                        <div class="service-item single">
                            <div class="service-thumb">
                                <img src="{{$imageUrl}}"
                                    alt="service">
                            </div>
                            <div class="service-content wyg">
                                <h2 class="title">{{__($service->name)}}</h2>
                                @php echo __($service->description) @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 mb-30">
                <div class="sidebar">
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">@lang('Related Services')</h4>
                        <div class="category-widget-box">
                            <ul class="category-list">
                                @foreach($services as $item)
                                <li><a
                                        href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}">{{__($item->name)}}</a>
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