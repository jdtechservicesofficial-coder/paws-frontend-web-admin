@php
$content = getContent('contact_us.content', true);
$pawllyEmail = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'inquriy_email')->value('val') ?? @$content->data_values->email_address;
$pawllyPhone = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'helpline_number')->value('val') ?? @$content->data_values->contact_number;
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="contact-section pt-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-5 col-lg-5 mb-30">
                <div class="contact-widget">
                    <div class="contact-form-header">
                        <h2 class="title">{{ __($content->data_values->title) }}</h2>
                        <p>{{ __($content->data_values->short_details) }}</p>
                    </div>
                    <ul class="contact-item-list">
                        <li>
                            <div class="d-flex">
                                <div class="contact-item-icon">
                                    <i class="las la-map"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title">@lang('Our Location')</h5>
                                    <span class="sub-title">{!! __($content->data_values->address) !!}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex">
                                <div class="contact-item-icon">
                                    <i class="las la-phone-volume"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title">{{$pawllyPhone}}</h5>
                                    <span class="sub-title">{{$content->data_values->office_hour}}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex">
                                <div class="contact-item-icon">
                                    <i class="las la-envelope"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title">@lang('Email Us Directly')</h5>
                                    <span class="sub-title">{{$pawllyEmail}}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 mb-30">
                <div class="map-area">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.622431589583!2d3.4655816758622926!3d6.442504424097525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf56f7b463439%3A0x6deb3926ba7a6d45!2sPaw%20and%20Paws%20Pet%20Store!5e0!3m2!1sen!2sng!4v1787296862767!5m2!1sen!2sng" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->