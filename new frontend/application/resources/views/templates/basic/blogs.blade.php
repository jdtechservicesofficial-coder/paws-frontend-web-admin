@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="blog-section ptb-120" style="background: #f8fafc;">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-8 col-lg-8">
                <div class="row g-4">
                    @php
                    $pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
                    @endphp
                    @foreach($blogs as $item)
                    @php
                    $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Blog\Models\Blog')->where('model_id', $item->id)->first();
                    $imageUrl = $media ? getCloudinaryOrLocalUrl($media) : getImage('');
                    $formattedDate = \Carbon\Carbon::parse($item->created_at)->format('d M, Y');
                    @endphp
                    <div class="col-md-6">
                        <div class="blog-item" style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 6px 20px rgba(0,0,0,0.03); overflow: hidden; height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 35px -10px rgba(37,99,235,0.12)'; this.style.borderColor='#93c5fd';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.03)'; this.style.borderColor='#e2e8f0';">
                            <div>
                                <div class="blog-thumb" style="position: relative; height: 200px; overflow: hidden; background: #f1f5f9;">
                                    <a href="{{ route('blog.details', ['slug' => slug($item->name), 'id' => $item->id])}}" style="display: block; width: 100%; height: 100%;">
                                        <img src="{{$imageUrl}}" alt="blog" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                                    </a>
                                    <div style="position: absolute; top: 12px; right: 12px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #ffffff; padding: 4px 10px; border-radius: 8px; font-size: 11.5px; font-weight: 700;">
                                        <i class="las la-calendar me-1"></i> {{$formattedDate}}
                                    </div>
                                </div>
                                <div class="blog-content" style="padding: 20px 18px;">
                                    <span class="category" style="color: #2563eb; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.8px; display: inline-block; margin-bottom: 6px;">@lang('Pet Care News')</span>
                                    <h4 class="title" style="font-size: 16px; font-weight: 800; line-height: 1.4; margin-bottom: 8px;">
                                        <a href="{{ route('blog.details', ['slug' => slug($item->name), 'id' => $item->id])}}" style="color: #0f172a; text-decoration: none;">{{__($item->name)}}</a>
                                    </h4>
                                </div>
                            </div>
                            <div style="padding: 0 18px 20px 18px;">
                                <a href="{{ route('blog.details', ['slug' => slug($item->name), 'id' => $item->id])}}" style="color: #2563eb; font-weight: 700; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center;">
                                    @lang('Read Full Article') <i class="las la-arrow-right ms-2"></i>
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
                            @lang('Our Services')
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
@endsection