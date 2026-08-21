@php
$content = getContent('pet_categories.content', true);
$pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
$pawllyCategories = \Illuminate\Support\Facades\DB::table('pets_type')->where('status', 1)->take(6)->get();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Category
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="category-section bg--gray ptb-120">
    <div class="category-top-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>
    <div class="category-bottom-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>
    {{-- <div class="category-element">
        <img src="{{getImage(getFilePath('shapes').'/cat.png')}}" alt="cat">
    </div> --}}
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
        <div class="category-slider-wrapper">
            <div class="category-slider">
                <div class="swiper-wrapper">
                    @foreach($pawllyCategories as $item)
                    @php
                    $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Pet\Models\PetType')->where('model_id', $item->id)->first();
                    $imageUrl = $media ? $pawllyDomain . '/storage/' . $media->id . '/' . $media->file_name : getImage('');
                    @endphp
                    <div class="swiper-slide">
                        <div class="category-item">
                            <div class="category-thumb">
                                <div class="round-top"></div>
                                <div class="round-bottom"></div>
                                <img src="{{$imageUrl}}" alt="category">
                            </div>
                            <div class="category-content">
                                <h3 class="title">{{__($item->name)}}</h3>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Category
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
