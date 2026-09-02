@extends($activeTemplate.'layouts.auth')
@section('content')
<section style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 50px 15px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div style="background: #ffffff; padding: 45px 40px; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(15, 23, 42, 0.02);">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" style="display: inline-block; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                            <img src="{{siteLogoDark()}}" alt="logo" style="max-width: 160px; margin-bottom: 16px;">
                        </a>
                        <h2 style="font-weight: 800; color: #0f172a; font-size: 26px; margin-bottom: 6px; letter-spacing: -0.5px;">@lang('Welcome Back')</h2>
                        <p style="color: #64748b; font-size: 14px; margin: 0;">@lang('Log in to manage your bookings, orders & profile')</p>
                    </div>

                    <form method="post" action="{{ route('user.login') }}" class="mt-4">
                        @csrf
                        <div class="form-group mb-3">
                            <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 6px; display: block;">@lang('Email Address')</label>
                            <input type="email" class="form-control custom-input" name="username" value="{{ old('username') }}" placeholder="@lang('name@example.com')" required>
                        </div>
                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label style="font-weight: 600; color: #334155; font-size: 13.5px; margin-bottom: 0; display: block;">@lang('Password')</label>
                                <a href="{{ route('user.password.request') }}" style="font-weight: 600; font-size: 13px; color: #2563eb; text-decoration: none;">@lang('Forgot password?')</a>
                            </div>
                            <input type="password" class="form-control custom-input" name="password" placeholder="••••••••" required>
                        </div>
                        
                        <div class="form-group mb-3 d-flex justify-content-center">
                            <x-captcha></x-captcha>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" style="height: 50px; font-weight: 700; font-size: 15px; border-radius: 10px; background: #2563eb; border: none; box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.35); transition: all 0.2s;" onmouseover="this.style.background='#1d4ed8'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#2563eb'; this.style.transform='translateY(0)';">
                            @lang('Log In')
                        </button>
                        
                        <div class="text-center mt-4">
                            <p style="color: #64748b; font-size: 14px; margin: 0;">
                                @lang("Don't have an account?") 
                                <a href="{{ route('user.register') }}" style="color: #2563eb; font-weight: 700; text-decoration: none; margin-left: 4px;">@lang('Create Account')</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
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
