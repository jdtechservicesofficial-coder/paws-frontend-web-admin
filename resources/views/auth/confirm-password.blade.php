<x-auth-layout>
    <x-slot name="title">
        @lang('Confirm Password')
    </x-slot>

    <x-auth-card>
        <x-slot name="logo">
            <div class="text-center">
                <a href="{{ route('login') }}" class="d-inline-block">
                    <x-application-logo />
                </a>
                <h2 style="font-size: 1.75rem; font-weight: 700; color: #ffffff; letter-spacing: -0.03em; margin-top: 0.5rem; margin-bottom: 0.35rem;">
                    {{ __('Security Check') }}
                </h2>
                <p style="color: #94a3b8; font-size: 0.92rem; line-height: 1.5; max-width: 380px; margin: 0 auto 1.5rem;">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </p>
            </div>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-4">
                <label for="password" style="display: block; color: #cbd5e1; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; letter-spacing: 0.02em;">
                    {{ __('Password') }}
                </label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #64748b; pointer-events: none; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" 
                        style="width: 100%; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 14px; padding: 0.9rem 1.25rem 0.9rem 2.75rem; color: #ffffff; font-size: 0.95rem; transition: all 0.25s ease;"
                        onfocus="this.style.borderColor='#38b6ff'; this.style.boxShadow='0 0 0 4px rgba(56, 182, 255, 0.15)';"
                        onblur="this.style.borderColor='rgba(255, 255, 255, 0.15)'; this.style.boxShadow='none';">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #38b6ff 0%, #0052cc 100%); border: none; border-radius: 14px; padding: 0.95rem; color: #ffffff; font-size: 1rem; font-weight: 700; letter-spacing: 0.02em; box-shadow: 0 8px 20px -4px rgba(56, 182, 255, 0.4); cursor: pointer; transition: all 0.25s ease; display: flex; align-items: center; justify-content: center; gap: 8px;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 25px -4px rgba(56, 182, 255, 0.6)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px -4px rgba(56, 182, 255, 0.4)';">
                <span>{{ __('Confirm & Continue') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>
    </x-auth-card>
</x-auth-layout>
