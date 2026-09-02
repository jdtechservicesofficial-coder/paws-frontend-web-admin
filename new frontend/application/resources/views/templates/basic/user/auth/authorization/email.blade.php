@extends($activeTemplate .'layouts.auth')
@section('content')
<section style="background-color: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 15px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div style="background: #ffffff; padding: 45px 35px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}">
                            <img src="{{siteLogoDark()}}" alt="logo" style="max-width: 170px; margin-bottom: 20px;">
                        </a>
                        <h3 style="font-weight: 700; color: #1e293b; font-size: 26px; margin-bottom: 8px;">@lang('Verify Your Email')</h3>
                        <p style="color: #64748b; font-size: 14px; margin-bottom: 4px;">@lang('A 6-digit verification code has been sent to')</p>
                        <span style="display: inline-block; background-color: #eff6ff; color: #1d4ed8; font-weight: 600; font-size: 14px; padding: 4px 12px; border-radius: 6px; margin-top: 6px;">{{ showEmailAddress(auth()->user()->email) }}</span>
                    </div>

                    <form action="{{route('user.verify.email')}}" method="POST" class="submit-form">
                        @csrf

                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #475569; margin-bottom: 10px; display: block; text-align: center;">@lang('Enter 6-Digit Code')</label>
                            <input type="text" name="code" id="verification-code-input" 
                                   maxlength="6" 
                                   required 
                                   autofocus 
                                   autocomplete="one-time-code"
                                   placeholder="------"
                                   style="width: 100%; height: 60px; text-align: center; font-size: 30px; font-weight: 700; letter-spacing: 14px; border: 2px solid #cbd5e1; border-radius: 12px; background: #f8fafc; color: #1e293b; outline: none; transition: border-color 0.2s;"
                                   onfocus="this.style.borderColor='#2563eb';"
                                   onblur="this.style.borderColor='#cbd5e1';"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length === 6) { document.querySelector('.submit-form').submit(); }">
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn--base w-100" style="height: 50px; font-weight: 600; font-size: 16px; border-radius: 10px; border: none; box-shadow: none; display: flex; align-items: center; justify-content: center;">
                                @lang('Verify Email')
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p style="color: #64748b; font-size: 14px; margin-bottom: 8px;">
                                @lang('Didn\'t receive code?') 
                                <a href="{{route('user.send.verify.code', 'email')}}" style="color: #2563eb; font-weight: 600; text-decoration: none;">@lang('Resend Code')</a>
                            </p>
                            @if($errors->has('resend'))
                            <small class="text-danger d-block mt-1">{{ $errors->first('resend') }}</small>
                            @endif
                            <a href="{{ route('user.logout') }}" style="color: #94a3b8; font-size: 13px; text-decoration: none; display: inline-block; margin-top: 10px;">
                                <i class="las la-sign-out-alt"></i> @lang('Logout')
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection