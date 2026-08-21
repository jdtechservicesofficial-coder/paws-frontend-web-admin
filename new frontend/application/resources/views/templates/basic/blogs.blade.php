@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="service-section ptb-120">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8 col-lg-8 mb-30">
                <div class="row justify-content-center mb-30-none">
                    @php
                    $pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
                    @endphp
                    @foreach($blogs as $item)
                    @php
                    $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Blog\Models\Blog')->where('model_id', $item->id)->first();
                    $imageUrl = $media ? $pawllyDomain . '/storage/' . $media->id . '/' . $media->file_name : getImage('');
                    $dateMonth = \Carbon\Carbon::parse($item->created_at)->format('d M');
                    $year = \Carbon\Carbon::parse($item->created_at)->format('Y');
                    @endphp
                    <div class="col-md-6 mb-30">
                        <div class="blog-item">
                            <div class="blog-thumb">
                                <a
                                    href="{{ route('blog.details', ['slug' => slug($item->name), 'id' => $item->id])}}"><img
                                        src="{{$imageUrl}}"
                                        alt="blog"></a>
                            </div>
                            <div class="blog-content">
                                <div class="blog-date">
                                    <h6 class="title">{{$dateMonth}}</h6>
                                    <span class="sub-title">{{$year}}</span>
                                </div>
                                <span class="category">@lang('Latest News')</span>
                                <h4 class="title"><a
                                        href="{{ route('blog.details', ['slug' => slug($item->name), 'id' => $item->id])}}">{{__($item->name)
                                        }}</a></h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 mb-30">
                <div class="sidebar">
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">@lang('Services')</h4>
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
@endsection