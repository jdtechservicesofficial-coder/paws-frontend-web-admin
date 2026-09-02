@php
$content = getContent('blog.content', true);
$pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
$pawllyBlogs = \Illuminate\Support\Facades\DB::table('blogs')->where('status', 1)->orderBy('id', 'desc')->take(3)->get();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section pt-120 pb-120" style="background: #0047b3;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 text-center mb-5">
                <div class="section-header mb-0">
                    <span class="section-sub-title" style="color: #fdcd01; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; font-size: 13px; display: inline-block; background: #eff6ff; padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;">{{__($content->data_values->tag ?? 'Pet Care Blog')}}</span>
                    <h2 class="section-title" style="font-weight: 800; color: #ffffff; font-size: 36px; line-height: 1.25; margin-bottom: 12px; letter-spacing: -0.5px;">{{__($content->data_values->heading ?? 'Latest News & Expert Pet Advice')}}</h2>
                    <p style="color: #ffffff; font-size: 15px; line-height: 1.7; max-width: 620px; margin: 0 auto;">{{__($content->data_values->subheading ?? 'Stay updated with valuable tips on pet health, grooming routines, nutrition, and training guides from our pet experts.')}}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape" class="section-header-shpae my-3" style="max-width: 80px;">
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4">
            @foreach($pawllyBlogs as $item)
            @php
            $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Blog\Models\Blog')->where('model_id', $item->id)->first();
            $imageUrl = $media ? getCloudinaryOrLocalUrl($media) : getImage('');
            $formattedDate = \Carbon\Carbon::parse($item->created_at)->format('d M, Y');
            @endphp
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="blog-item" style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 6px 20px rgba(0,0,0,0.03); overflow: hidden; height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 35px -10px rgba(37,99,235,0.12)'; this.style.borderColor='#93c5fd';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.03)'; this.style.borderColor='#e2e8f0';">
                    <div>
                        <div class="blog-thumb" style="position: relative; height: 220px; overflow: hidden; background: #f1f5f9;">
                            <a href="{{ route('blog.details', ['slug' => slug($item->name), 'id' => $item->id])}}" style="display: block; width: 100%; height: 100%;">
                                <img src="{{$imageUrl}}" alt="blog" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                            <div style="position: absolute; top: 14px; right: 14px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #ffffff; padding: 5px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                <i class="las la-calendar me-1"></i> {{$formattedDate}}
                            </div>
                        </div>
                        <div class="blog-content" style="padding: 24px 20px;">
                            <span class="category" style="color: #2563eb; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.8px; display: inline-block; margin-bottom: 8px;">@lang('Pet Care News')</span>
                            <h4 class="title" style="font-size: 18px; font-weight: 800; line-height: 1.4; margin-bottom: 12px;">
                                <a href="{{ route('blog.details', ['slug' => slug($item->name), 'id' => $item->id])}}" style="color: #0f172a; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#0f172a'">{{__($item->name)}}</a>
                            </h4>
                        </div>
                    </div>
                    <div style="padding: 0 20px 24px 20px;">
                        <a href="{{ route('blog.details', ['slug' => slug($item->name), 'id' => $item->id])}}" style="color: #2563eb; font-weight: 700; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; transition: gap 0.2s;" onmouseover="this.style.color='#1d4ed8'">
                            @lang('Read Full Article') <i class="las la-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="browse-more-btn text-center mt-5">
            <a href="{{ route('blogs') }}" class="btn btn--base" style="padding: 12px 36px; font-weight: 700; font-size: 15px; border-radius: 10px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);">@lang('Browse All Articles') <i class="las la-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
