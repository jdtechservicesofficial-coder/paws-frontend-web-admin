@extends($activeTemplate.'layouts.auth')
@section('content')
@php
$policyPages = getContent('policy_pages.element',false,null,true);
@endphp
<section style="background-color: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 15px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10">
                <div style="background: #ffffff; padding: 50px 40px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}">
                            <img src="{{siteLogoDark()}}" alt="logo" style="max-width: 180px; margin-bottom: 20px;">
                        </a>
                        <h3 style="font-weight: 700; color: #1e293b; font-size: 28px; margin-bottom: 10px;">@lang('Register')</h3>
                        <p style="color: #64748b; font-size: 15px;">@lang('Please input your information to register')</p>
                    </div>
                    <form method="post" action="{{ route('user.register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('First Name')</label>
                                <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Last Name')</label>
                                <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Email')</label>
                                <input type="email" class="form-control checkUser" name="email" value="{{ old('email') }}" required style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Country')</label>
                                <select name="country" class="form-control" style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #e2e8f0; pointer-events: none;" readonly>
                                    <option data-mobile_code="234" value="Nigeria" data-code="NG" selected>Nigeria</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Mobile')</label>
                                <div class="input-group">
                                    <span class="input-group-text mobile-code" style="background: #e2e8f0; border: 1px solid #cbd5e1; border-right: none; border-radius: 8px 0 0 8px; padding: 12px 15px; min-width: 50px; text-align: center;"></span>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control checkUser" required style="padding: 12px 15px; border-radius: 0 8px 8px 0; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;">
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Password')</label>
                                <input type="password" class="form-control" name="password" required style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;">
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
                            <div class="col-md-12 form-group mb-4">
                                <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Confirm Password')</label>
                                <input type="password" class="form-control" name="password_confirmation" required style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;">
                            </div>
                        </div>

                        @if($general->agree)
                        <div class="form-group d-flex mb-4">
                            <div class="me-2 mt-1">
                                <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                            </div>
                            <label for="agree" style="color: #475569;">@lang('I agree with') @foreach($policyPages as $policy) <a href="{{ route('policy.details',[slug($policy->data_values->title),$policy->id]) }}" class="text--base">{{ __($policy->data_values->title) }}</a>@if(!$loop->last), @endif @endforeach</label>
                        </div>
                        @endif

                        <div class="form-group mb-4 d-flex justify-content-center">
                            <x-captcha></x-captcha>
                        </div>
                        
                        <button type="submit" id="recaptcha" class="btn btn--base w-100" style="padding: 14px; font-weight: 600; font-size: 16px; border-radius: 8px; border: none; box-shadow: none;"> @lang('Register')</button>
                        
                        <div class="text-center mt-4">
                            <p style="color: #64748b; font-size: 15px; margin: 0;">@lang('Already Have An Account?') <a href="{{ route('user.login') }}" class="text--base" style="font-weight: 600; text-decoration: none;">@lang('Login Now')</a></p>
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <h6 class="text-center">@lang('You already have an account please Login ')</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                <a href="{{ route('user.login') }}" class="btn btn-sm btn-dark">@lang('Login')</a>
            </div>
        </div>
    </div>
</div>
@endsection
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
