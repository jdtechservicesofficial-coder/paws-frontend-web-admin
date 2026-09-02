@php
$content = getContent('consultation.content', true);
$services = \Illuminate\Support\Facades\DB::table('system_services')->where('status', 1)->get();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Get-in-toch
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="get-in-touch-section pt-120 pb-120" style="background: #0047b3;">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="section-header mb-4">
                    <span class="section-sub-title" style="color: #fdcd01; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 13px;">{{__($content->data_values->tag)}}</span>
                    <h2 class="section-title" style="font-weight: 800; color: #ffffff; font-size: 34px; line-height: 1.25; margin-top: 8px;">{{__($content->data_values->heading)}}</h2>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape" class="section-header-shpae my-3" style="max-width: 80px;">
                    <p style="color: #ffffff; font-size: 15px; line-height: 1.7;">{{__($content->data_values->subheading)}}</p>
                </div>
                <div style="background: #ffffff; border-radius: 20px; padding: 35px 30px; border: 1px solid #e2e8f0; box-shadow: 0 15px 35px -10px rgba(0,0,0,0.06);">
                    <form class="get-in-touch-form" action="{{ route('book.consultation') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Select Service')</label>
                            <select class="form-control" name="service_name" required style="height: 48px; border-radius: 10px; border: 1.5px solid #cbd5e1; background: #f8fafc; color: #1e293b; font-size: 14px;">
                                <option value="">@lang('Choose a service...')</option>
                                @foreach($services as $item)
                                <option value="{{ $item->name }}">{{__($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Preferred Date')</label>
                            <input type="date" class="form-control" name="time" required style="height: 48px; border-radius: 10px; border: 1.5px solid #cbd5e1; background: #f8fafc; color: #1e293b; font-size: 14px;">
                        </div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Your Email Address')</label>
                            <input type="email" name="email" class="form-control" placeholder="@lang('name@example.com')" required style="height: 48px; border-radius: 10px; border: 1.5px solid #cbd5e1; background: #f8fafc; color: #1e293b; font-size: 14px;">
                        </div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Your Message / Inquiry')</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="@lang('Tell us about your pet or any specific questions...')" style="border-radius: 10px; border: 1.5px solid #cbd5e1; background: #f8fafc; color: #1e293b; font-size: 14px; padding: 12px;"></textarea>
                        </div>
                        <x-captcha></x-captcha>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary w-100" style="height: 50px; font-weight: 700; font-size: 15px; border-radius: 10px; background: #fdcd01; border: none; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35); transition: all 0.2s;">
                                <i class="las la-paper-plane me-1"></i> @lang('Book Consultation Now')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="get-in-touch-thumb text-center">
                    <img src="{{getImage(getFilePath('frontend').'/consultation/'.$content->data_values->image)}}" alt="contact" style="max-height: 520px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Get-in-touch
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
