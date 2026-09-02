@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12">
        <div class="card custom--card">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('user.data.submit') }}" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center mb-4 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <div class="col-auto">
                            <div style="background-image: url({{getImage(getFilePath('userProfile').'/'.$user->id.'/'.$user->image)}}); width: 80px; height: 80px; border-radius: 50%; background-size: cover; background-position: center; border: 3px solid #2563eb; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-label" style="color: #ffffff; font-weight: 700; font-size: 15px; margin-bottom: 6px;">@lang('Change Profile Picture')</label>
                            <input type="file" name="image" class="form-control form--control" style="max-width: 320px; font-size: 13px;">
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-xl-4 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('First Name')</label>
                            <input type="text" name="firstname" class="form-control form--control" value="{{ $user->firstname }}" required>
                        </div>
                        <div class="col-xl-4 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Last Name')</label>
                            <input type="text" name="lastname" class="form-control form--control" value="{{ $user->lastname }}" required>
                        </div>
                        <div class="col-xl-4 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Username')</label>
                            <input type="text" name="username" class="form-control form--control" value="{{ $user->username }}" required>
                        </div>
                        <div class="col-xl-4 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Email Address')</label>
                            <input type="email" name="email" class="form-control form--control" value="{{ $user->email }}" disabled readonly style="opacity: 0.8;">
                        </div>
                        <div class="col-xl-4 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Country')</label>
                            <select name="country" class="form-control form--control">
                                @foreach($countries as $key => $country)
                                <option data-mobile_code="{{ $country->dial_code }}"
                                    value="{{ $country->country }}" data-code="{{ $key }}" {{ @$user->address->country == $country->country ? 'selected' : null }} style="background: #0f172a; color: #fff;">{{
                                    __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-4 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Mobile Number')</label>
                            <div class="input-group">
                                <span class="input-group-text mobile-code" style="background: rgba(255,255,255,0.1); color: #60a5fa; border: 1px solid rgba(255,255,255,0.2); font-weight: 700;">+{{ $user->mobile }}</span>
                                <input type="hidden" name="mobile_code">
                                <input type="hidden" name="country_code">
                                <input type="number" name="mobile" value="{{ $user->mobile }}" class="form-control form--control checkUser" placeholder="Enter mobile number">
                            </div>
                            <small class="text-danger mobileExist"></small>
                        </div>
                        <div class="col-xl-6 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Address')</label>
                            <input type="text" name="address" class="form-control form--control" value="{{ @$user->address->address }}" placeholder="Street address">
                        </div>
                        <div class="col-xl-6 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Zip Code')</label>
                            <input type="text" name="zip" class="form-control form--control" value="{{ @$user->address->zip }}" placeholder="Postal / Zip code">
                        </div>
                        <div class="col-xl-6 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('State / Province')</label>
                            <input type="text" name="state" class="form-control form--control" value="{{ @$user->address->state }}" placeholder="State">
                        </div>
                        <div class="col-xl-6 col-md-6 form-group">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('City')</label>
                            <input type="text" name="city" class="form-control form--control" value="{{ @$user->address->city }}" placeholder="City">
                        </div>
                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn--base px-4 py-2" style="font-size: 15px;">@lang('Update Profile')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
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
    })(jQuery);
</script>
@endpush
