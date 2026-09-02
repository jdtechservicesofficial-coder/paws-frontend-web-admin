@extends($activeTemplate.'layouts.auth')
@section('content')
@php
$policyPages = getContent('policy_pages.element',false,null,true);
@endphp
<section style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 50px 15px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div style="background: #ffffff; padding: 45px 40px; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(15, 23, 42, 0.02);">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" style="display: inline-block; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                            <img src="{{siteLogoDark()}}" alt="logo" style="max-width: 160px; margin-bottom: 16px;">
                        </a>
                        <h2 style="font-weight: 800; color: #0f172a; font-size: 26px; margin-bottom: 6px; letter-spacing: -0.5px;">@lang('Create Your Account')</h2>
                        <p style="color: #64748b; font-size: 14px; margin: 0;">@lang('Join us today to manage all your pet care services')</p>
                    </div>

                    <form method="post" action="{{ route('user.register') }}" class="mt-4">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6 form-group">
                                <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('First Name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control custom-input" name="firstname" value="{{ old('firstname') }}" placeholder="@lang('e.g. John')" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Last Name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control custom-input" name="lastname" value="{{ old('lastname') }}" placeholder="@lang('e.g. Doe')" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Email Address') <span class="text-danger">*</span></label>
                                <input type="email" class="form-control custom-input checkUser" name="email" value="{{ old('email') }}" placeholder="@lang('name@example.com')" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Country')</label>
                                <select name="country" class="form-control custom-input" style="background: #f1f5f9; cursor: not-allowed;" readonly>
                                    <option data-mobile_code="234" value="Nigeria" data-code="NG" selected>Nigeria</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Mobile Number') <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text mobile-code" style="background: #f1f5f9; border: 1.5px solid #cbd5e1; border-right: none; border-radius: 10px 0 0 10px; font-weight: 600; color: #475569; padding: 0 14px; font-size: 14px;">+234</span>
                                    <input type="hidden" name="mobile_code" value="234">
                                    <input type="hidden" name="country_code" value="NG">
                                    <input type="tel" name="mobile" value="{{ old('mobile') }}" class="form-control custom-input checkUser" placeholder="@lang('8012345678')" required style="border-radius: 0 10px 10px 0; border-left: none;">
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Password') <span class="text-danger">*</span></label>
                                <input type="password" class="form-control custom-input" name="password" placeholder="••••••••" required>
                                @if($general->secure_password)
                                <div class="input-popup">
                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                    <p class="error number">@lang('1 number minimum')</p>
                                    <p class="error special">@lang('1 special character minimum')</p>
                                    <p class="error minimum">@lang('6 character password')</p>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-12 form-group">
                                <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Confirm Password') <span class="text-danger">*</span></label>
                                <input type="password" class="form-control custom-input" name="password_confirmation" placeholder="••••••••" required>
                            </div>
                        </div>

                        @if($general->agree)
                        <div class="form-group d-flex align-items-start my-3">
                            <div class="me-2 mt-1">
                                <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required style="width: 16px; height: 16px; accent-color: #2563eb; cursor: pointer;">
                            </div>
                            <label for="agree" style="color: #64748b; font-size: 13px; line-height: 1.5; margin: 0; cursor: pointer;">
                                @lang('I agree to the') 
                                @foreach($policyPages as $policy) 
                                    <a href="{{ route('policy.details',[slug($policy->data_values->title),$policy->id]) }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">{{ __($policy->data_values->title) }}</a>@if(!$loop->last), @endif 
                                @endforeach
                            </label>
                        </div>
                        @endif

                        <div class="form-group mb-3 d-flex justify-content-center">
                            <x-captcha></x-captcha>
                        </div>
                        
                        <button type="submit" id="recaptcha" class="btn btn-primary w-100" style="height: 50px; font-weight: 700; font-size: 15px; border-radius: 10px; background: #2563eb; border: none; box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.35); transition: all 0.2s;" onmouseover="this.style.background='#1d4ed8'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#2563eb'; this.style.transform='translateY(0)';">
                            @lang('Create Account')
                        </button>
                        
                        <div class="text-center mt-4">
                            <p style="color: #64748b; font-size: 14px; margin: 0;">
                                @lang('Already Have An Account?') 
                                <a href="{{ route('user.login') }}" style="color: #2563eb; font-weight: 700; text-decoration: none; margin-left: 4px;">@lang('Log In')</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 16px 24px;">
                <h5 class="modal-title" id="existModalLongTitle" style="font-weight: 700; font-size: 16px; color: #0f172a;">@lang('Account Exists')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p style="color: #475569; font-size: 15px; margin-bottom: 20px;">@lang('An account with these details already exists. Please log in.')</p>
                <a href="{{ route('user.login') }}" class="btn btn-primary w-100" style="padding: 12px; border-radius: 8px; font-weight: 600;">@lang('Go to Login')</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .custom-input {
        height: 48px;
        padding: 10px 16px;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        background: #f8fafc;
        color: #0f172a;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    .custom-input:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }
</style>
@endpush
@push('style')
<style>
    .country-code .input-group-text {
        background: #e2e8f0 !important;
        border: 1px solid #cbd5e1;
    }

    .country-code select {
        border: none;
    }

    .country-code select:focus {
        border: none;
        outline: none;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    "use strict";
    (function ($) {
        @if ($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
        @endif

        $('select[name=country]').change(function () {
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
        });
        $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
        $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
        $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
        @if ($general -> secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });

        $('[name=password]').focus(function () {
            $(this).closest('.form-group').addClass('hover-input-popup');
        });

        $('[name=password]').focusout(function () {
            $(this).closest('.form-group').removeClass('hover-input-popup');
        });


        @endif

        $('.checkUser').on('focusout', function (e) {
            var url = '{{ route('user.checkUser') }}';
            var value = $(this).val();
            var token = '{{ csrf_token() }}';
            if ($(this).attr('name') == 'mobile') {
                var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                var data = { mobile: mobile, _token: token }
            }
            if ($(this).attr('name') == 'email') {
                var data = { email: value, _token: token }
            }
            if ($(this).attr('name') == 'username') {
                var data = { username: value, _token: token }
            }
            $.post(url, data, function (response) {
                if (response.data != false && response.type == 'email') {
                    $('#existModalCenter').modal('show');
                } else if (response.data != false) {
                    $(`.${response.type}Exist`).text(`${response.type} already exist`);
                } else {
                    $(`.${response.type}Exist`).text('');
                }
            });
        });
    })(jQuery);

</script>
@endpush
