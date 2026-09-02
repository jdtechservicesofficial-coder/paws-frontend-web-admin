@php
$content = getContent('contact_us.content', true);
$pawllyEmail = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'inquriy_email')->value('val') ?? @$content->data_values->email_address;
$pawllyPhone = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'helpline_number')->value('val') ?? @$content->data_values->contact_number;
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="contact-section pt-100 pb-100" style="background: #0047b3;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="contact-widget" style="background: #f8fafc; border-radius: 24px; padding: 36px 30px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <div class="contact-form-header mb-4">
                        <span style="color: #2563eb; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; font-size: 13px; display: inline-block; background: #eff6ff; padding: 4px 14px; border-radius: 20px; margin-bottom: 10px;">@lang('Contact Details')</span>
                        <h2 class="title" style="font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1.3; margin-bottom: 8px;">{{ __($content->data_values->title) }}</h2>
                        <p style="color: #64748b; font-size: 14.5px; line-height: 1.6; margin: 0;">{{ __($content->data_values->short_details) }}</p>
                    </div>
                    <ul class="contact-item-list list-unstyled mb-0" style="display: flex; flex-direction: column; gap: 20px;">
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="contact-item-icon me-3" style="width: 52px; height: 52px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);">
                                    <i class="las la-map-marker-alt"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title mb-1" style="font-size: 15px; font-weight: 800; color: #0f172a;">@lang('Our Location')</h5>
                                    <span class="sub-title" style="font-size: 13.5px; color: #64748b; line-height: 1.5;">{!! __($content->data_values->address) !!}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="contact-item-icon me-3" style="width: 52px; height: 52px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);">
                                    <i class="las la-phone-volume"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title mb-1" style="font-size: 15px; font-weight: 800; color: #0f172a;">{{$pawllyPhone}}</h5>
                                    <span class="sub-title" style="font-size: 13.5px; color: #64748b;">{{$content->data_values->office_hour}}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="contact-item-icon me-3" style="width: 52px; height: 52px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);">
                                    <i class="las la-envelope"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title mb-1" style="font-size: 15px; font-weight: 800; color: #0f172a;">@lang('Email Us Directly')</h5>
                                    <span class="sub-title" style="font-size: 13.5px; color: #64748b;">{{$pawllyEmail}}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="map-area" style="border-radius: 24px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; height: 420px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.622431589583!2d3.4655816758622926!3d6.442504424097525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf56f7b463439%3A0x6deb3926ba7a6d45!2sPaw%20and%20Paws%20Pet%20Store!5e0!3m2!1sen!2sng!4v1787296862767!5m2!1sen!2sng" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->