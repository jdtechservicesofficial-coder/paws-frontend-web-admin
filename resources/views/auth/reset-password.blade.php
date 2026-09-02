<x-auth-layout>
    <x-slot name="title">
        @lang('Reset Password')
    </x-slot>

    <!-- Plain Colors Custom Styling matching Login Page -->
    <style>
        body {
            background-color: #ffffff !important;
            margin: 0;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
        }

        /* Split-screen wrapper */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            position: relative;
        }

        /* Left Side Feature Banner */
        .feature-banner {
            background-color: #0f172a;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 4rem;
            color: #ffffff;
        }

        .banner-logo img {
            max-height: 50px;
            object-fit: contain;
        }

        .banner-content {
            margin: auto 0;
            max-width: 480px;
        }

        .banner-title {
            font-size: 3.2rem;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 1.5rem;
            color: #ffffff;
            letter-spacing: -0.04em;
        }

        .banner-title span {
            color: #38b6ff;
        }

        .banner-subtitle {
            font-size: 1.15rem;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 3rem;
            font-weight: 400;
        }

        /* Pet Feature Badge Cards */
        .feature-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }

        .feature-card {
            background-color: #1e293b;
            border-radius: 12px;
            padding: 1.25rem;
            transition: transform 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-2px);
        }

        .feature-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background-color: #38b6ff;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .feature-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.25rem;
        }

        .feature-card-desc {
            font-size: 0.85rem;
            color: #94a3b8;
        }

        .banner-footer {
            font-size: 0.85rem;
            color: #64748b;
            border-top: 1px solid #1e293b;
            padding-top: 1.5rem;
        }

        /* Right Side Form Panel */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: #ffffff;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
        }

        .form-header {
            margin-bottom: 2.5rem;
        }

        .form-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Input Styling */
        .input-group-custom {
            margin-bottom: 1.5rem;
        }

        .input-group-custom label {
            display: block;
            color: #334155;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .input-custom {
            width: 100%;
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 0.95rem 1.25rem !important;
            color: #0f172a !important;
            font-size: 1rem !important;
            transition: border-color 0.2s ease !important;
        }

        .input-custom::placeholder {
            color: #94a3b8 !important;
        }

        .input-custom:focus {
            outline: none !important;
            border-color: #38b6ff !important;
            background-color: #ffffff !important;
        }

        /* Button Redesign */
        .btn-solid {
            width: 100%;
            background-color: #38b6ff !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 1rem !important;
            color: #ffffff !important;
            font-size: 1.05rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: background-color 0.2s ease !important;
        }

        .btn-solid:hover {
            background-color: #299fdf !important;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #38b6ff;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #299fdf;
            text-decoration: underline;
        }

        /* Responsiveness */
        @media (max-width: 991px) {
            .feature-banner {
                display: none !important;
            }
            .form-panel {
                padding: 1.5rem;
            }
            .form-container {
                max-width: 400px;
            }
        }
    </style>

    <div class="login-wrapper container-fluid p-0">
        <div class="row g-0 w-100">
            <!-- Left Side Feature Column -->
            <div class="col-lg-5 feature-banner">
                <div class="banner-logo">
                    @if(setting('logo'))
                        <img src="{{ asset(setting('logo')) }}" alt="{{ app_name() }}" onerror="this.style.display='none'; document.getElementById('reset-logo-fallback').style.display='flex';">
                    @endif
                    <div id="reset-logo-fallback" style="{{ setting('logo') ? 'display: none;' : 'display: flex;' }} align-items: center; gap: 10px;">
                        <div style="width: 38px; height: 38px; border-radius: 8px; background-color: #38b6ff; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.2rem;">🐾</div>
                        <span style="font-size: 1.35rem; font-weight: 800; color: #ffffff; letter-spacing: -0.5px;">{{ app_name() }}</span>
                    </div>
                </div>

                <div class="banner-content">
                    <h1 class="banner-title">Take Control of Your <span>Pet Business</span></h1>
                    <p class="banner-subtitle">Manage boarding bookings, veterinarian clinics, grooming services, walk paths, and training operations from one unified dashboard.</p>
                    
                    <div class="feature-cards">
                        <div class="feature-card">
                            <div class="feature-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="feature-card-title">Pet Boarding</div>
                            <div class="feature-card-desc">Sleek drop-off and pick-up tracker.</div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="feature-card-title">Veterinary Clinic</div>
                            <div class="feature-card-desc">Manage appointments and records.</div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7h7m-7-7h7M6 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="feature-card-title">Grooming & Styles</div>
                            <div class="feature-card-desc">Track custom pet cuts and bookings.</div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="feature-card-title">Expert Training</div>
                            <div class="feature-card-desc">Coordinate specialized trainer courses.</div>
                        </div>
                    </div>
                </div>

                <div class="banner-footer">
                    &copy; {{ date('Y') }} {{ app_name() }}. All rights reserved.
                </div>
            </div>

            <!-- Right Side Form Column -->
            <div class="col-lg-7 form-panel">
                <div class="form-container">
                    <div class="form-header">
                        <h2>Reset Password</h2>
                        <p>Create a new strong password for your account.</p>
                    </div>

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.95rem;">
                            <ul style="margin: 0; padding-left: 1.25rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="input-group-custom">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input id="email" class="input-custom" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="name@example.com">
                        </div>

                        <!-- Password -->
                        <div class="input-group-custom">
                            <label for="password">{{ __('New Password') }}</label>
                            <input id="password" class="input-custom" type="password" name="password" required placeholder="••••••••">
                        </div>

                        <!-- Confirm Password -->
                        <div class="input-group-custom">
                            <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
                            <input id="password_confirmation" class="input-custom" type="password" name="password_confirmation" required placeholder="••••••••">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-solid">
                            {{ __('Reset Password') }}
                        </button>

                        <div style="text-align: center; margin-top: 1.75rem;">
                            <a href="{{ route('login') }}" class="back-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                {{ __('Back to Sign In') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
