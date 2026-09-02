@php
$content = getContent('call_out.content', true);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Call-to-action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="call-to-action-section pt-120 pb-60">
    <div class="container">
        <div style="position: relative; border-radius: 24px; overflow: hidden; min-height: 280px; display: flex; align-items: center; box-shadow: 0 20px 40px -10px rgba(253, 205, 1, 0.3); background: #fdcd01;">
            
            <!-- We removed the dark image overlay to make it a clean, premium yellow card -->
            
            <div class="container position-relative py-5 px-4 px-md-5" style="z-index: 3;">
                <div class="row align-items-center justify-content-between g-4">
                    <div class="col-lg-8 col-md-7">
                        <span style="color: #0047b3; font-weight: 800; font-size: 14px; text-transform: uppercase; letter-spacing: 1.5px; display: inline-block; margin-bottom: 8px; background: rgba(0, 71, 179, 0.1); padding: 4px 14px; border-radius: 20px;">@lang('Join PAW&Paws Today')</span>
                        <h2 style="font-weight: 900; color: #0f172a; font-size: 38px; line-height: 1.25; margin-bottom: 12px; letter-spacing: -0.5px;">{{__($content->data_values->heading)}}</h2>
                        <p style="color: #334155; font-size: 16px; margin: 0; max-width: 540px; line-height: 1.6; font-weight: 500;">@lang('Book appointments, shop essentials, and monitor your furry friend\'s wellness all in one trusted platform.')</p>
                    </div>
                    <div class="col-lg-4 col-md-5 text-md-end text-start">
                        <a class="btn btn-primary" href="{{ route('home').$content->data_values->button_url }}" style="padding: 16px 36px; font-weight: 800; font-size: 16px; border-radius: 12px; background: #0047b3; color: #ffffff; border: none; box-shadow: 0 8px 24px rgba(0, 71, 179, 0.3); display: inline-flex; align-items: center; transition: all 0.3s;" onmouseover="this.style.background='#0f172a'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 28px rgba(15, 23, 42, 0.4)';" onmouseout="this.style.background='#0047b3'; this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 24px rgba(0, 71, 179, 0.3)';">
                            {{__($content->data_values->button_text)}} <i class="las la-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Call-to-action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->