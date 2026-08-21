@extends($activeTemplate.'layouts.auth')
@section('content')
<section style="background-color: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 15px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div style="background: #ffffff; padding: 50px 40px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}">
                            <img src="{{siteLogoDark()}}" alt="logo" style="max-width: 180px; margin-bottom: 20px;">
                        </a>
                        <h3 style="font-weight: 700; color: #1e293b; font-size: 28px; margin-bottom: 10px;">@lang('Reset Password')</h3>
                        <p style="color: #64748b; font-size: 15px;">@lang('Please provide a new password to continue.')</p>
                    </div>
                    <form method="post" action="{{ route('user.password.update') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('New Password')</label>
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
                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Confirm Password')</label>
                            <input type="password" class="form-control" name="password_confirmation" required style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;">
                        </div>
                        
                        <button type="submit" class="btn btn--base w-100" style="padding: 14px; font-weight: 600; font-size: 16px; border-radius: 8px; border: none; box-shadow: none;"> @lang('Save New Password')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
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
