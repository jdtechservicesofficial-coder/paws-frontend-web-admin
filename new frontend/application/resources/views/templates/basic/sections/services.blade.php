@php
$content = getContent('services.content', true);
$services = \Illuminate\Support\Facades\DB::table('system_services')->where('status', 1)->take(4)->get();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="service-section ptb-120">
    <img src="{{asset($activeTemplateTrue.'images/service-bg.png')}}" alt="shape" class="service-shape-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 text-center">
                <div class="section-header">
                    <span class="section-sub-title">@lang('Services')</span>
                    <h2 class="section-title">{{ __($content->data_values->heading) }}</h2>
                    <p>{{ __($content->data_values->description) }}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="section-header-shpae">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
@php
$pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
@endphp
            @foreach($services as $item)
            @php
            $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Service\Models\SystemService')->where('model_id', $item->id)->first();
            $imageUrl = $media ? $pawllyDomain . '/storage/' . $media->id . '/' . $media->file_name : getImage('');
            @endphp
            <div class="col-xl-6 col-lg-6 col-md-12 mb-30">
                <div class="service-item d-flex align-items-center flex-wrap flex-sm-nowrap" style="text-align: left; padding: 20px; height: 100%;">
                    <div class="service-thumb" style="width: 200px; flex-shrink: 0; margin-bottom: 0; margin-right: 20px;">
                        <div class="service-shape" style="display: none;"></div>
                        <a href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}">
                            <img src="{{$imageUrl}}" alt="service-image" style="width: 100%; border-radius: 10px;">
                        </a>
                    </div>
                    <div class="service-content" style="flex-grow: 1; padding: 0;">
                        <h3 class="title" style="margin-bottom: 10px;"><a
                                href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}">{{__($item->name)}}</a>
                        </h3>
                        <p style="margin-bottom: 15px;"> {{ __(strip_tags(substr($item->description, 0, 150))) }}... </p>
                        <div class="service-btn">
                            <a class="btn btn-sm btn--base"
                                href="{{route('service.details', ['slug' => $item->slug, 'id' => $item->id])}}">@lang('Learn more')</a>
                        </div>
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
