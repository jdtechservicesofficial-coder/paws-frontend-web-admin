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
                        <h3 style="font-weight: 700; color: #1e293b; font-size: 28px; margin-bottom: 10px;">@lang('Welcome Back')</h3>
                        <p style="color: #64748b; font-size: 15px;">@lang('Please log in to your account to continue.')</p>
                    </div>
                    <form method="post" action="{{ route('user.login') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Email')</label>
                            <input type="email" class="form-control" name="username" value="{{ old('username') }}" placeholder="@lang('Email Address')" style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;" required>
                        </div>
                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Password')</label>
                            <input type="password" class="form-control" name="password" placeholder="@lang('Password')" style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div></div>
                            <a href="{{ route('user.password.request') }}" class="text--base" style="font-weight: 600; font-size: 14px; text-decoration: none;">@lang('Forgot Password?')</a>
                        </div>
                        <x-captcha></x-captcha>
                        <button type="submit" class="btn btn--base w-100" style="padding: 14px; font-weight: 600; font-size: 16px; border-radius: 8px; border: none; box-shadow: none;">@lang('Login')</button>
                        
                        <div class="text-center mt-4">
                            <p style="color: #64748b; font-size: 15px; margin: 0;">@lang("Don't have an account?") <a href="{{ route('user.register') }}" class="text--base" style="font-weight: 600; text-decoration: none;">@lang('Register Now')</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
