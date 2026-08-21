@php
$content = getContent('blog.content', true);
$pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
$pawllyBlogs = \Illuminate\Support\Facades\DB::table('blogs')->where('status', 1)->orderBy('id', 'desc')->take(3)->get();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section pt-120">
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
        <div class="row justify-content-center mb-30-none">
            @foreach($pawllyBlogs as $item)
            @php
            $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Blog\Models\Blog')->where('model_id', $item->id)->first();
            $imageUrl = $media ? $pawllyDomain . '/storage/' . $media->id . '/' . $media->file_name : getImage('');
            $dateMonth = \Carbon\Carbon::parse($item->created_at)->format('d M');
            $year = \Carbon\Carbon::parse($item->created_at)->format('Y');
            @endphp
            <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
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
        <div class="browse-more-btn text-center mt-4">
            <a href="{{ route('blogs') }}" class="btn--base">@lang('Browse more')</a>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
