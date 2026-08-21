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
                        <h3 style="font-weight: 700; color: #1e293b; font-size: 28px; margin-bottom: 10px;">{{ __($pageTitle) }}</h3>
                        <p style="color: #64748b; font-size: 15px;">@lang('Please provide your email or username to recover your account.')</p>
                    </div>
                    <form method="post" action="{{ route('user.password.email') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #475569; margin-bottom: 8px; display: block;">@lang('Email or Username')</label>
                            <input type="text" class="form-control" name="value" value="{{ old('value') }}" required autofocus="off" style="padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; width: 100%; background: #f8fafc;">
                        </div>
                        <button type="submit" class="btn btn--base w-100" style="padding: 14px; font-weight: 600; font-size: 16px; border-radius: 8px; border: none; box-shadow: none;">@lang('Send Recovery Link')</button>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('user.login') }}" style="color: #64748b; font-size: 14px; text-decoration: none; font-weight: 500;">
                                <i class="las la-arrow-left"></i> @lang('Back to Login')
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection