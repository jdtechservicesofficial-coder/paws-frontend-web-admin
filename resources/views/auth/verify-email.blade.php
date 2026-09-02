<x-auth-layout>
    <x-slot name="title">
        @lang('Verify Email')
    </x-slot>

    <x-auth-card>
        <x-slot name="logo">
            <div class="text-center">
                <a href="{{ route('login') }}" class="d-inline-block">
                    <x-application-logo />
                </a>
                <h2 style="font-size: 1.75rem; font-weight: 700; color: #ffffff; letter-spacing: -0.03em; margin-top: 0.5rem; margin-bottom: 0.35rem;">
                    {{ __('Verify Your Email') }}
                </h2>
                <p style="color: #94a3b8; font-size: 0.92rem; line-height: 1.5; max-width: 380px; margin: 0 auto 1.5rem;">
                    {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just sent to you.') }}
                </p>
            </div>
        </x-slot>

        @if (session('status') == 'verification-link-sent')
            <div style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 12px; padding: 1rem; color: #4ade80; font-size: 0.9rem; text-align: center; margin-bottom: 1.5rem;">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="d-flex flex-column gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" style="width: 100%; background: linear-gradient(135deg, #38b6ff 0%, #0052cc 100%); border: none; border-radius: 14px; padding: 0.95rem; color: #ffffff; font-size: 1rem; font-weight: 700; letter-spacing: 0.02em; box-shadow: 0 8px 20px -4px rgba(56, 182, 255, 0.4); cursor: pointer; transition: all 0.25s ease;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 25px -4px rgba(56, 182, 255, 0.6)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px -4px rgba(56, 182, 255, 0.4)';">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center mt-2">
                @csrf
                <button type="submit" style="background: transparent; border: none; color: #94a3b8; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: color 0.2s ease;"
                    onmouseover="this.style.color='#ef4444';"
                    onmouseout="this.style.color='#94a3b8';">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-auth-layout>
