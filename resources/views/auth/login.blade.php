<x-auth-layout>
    <x-slot name="title">
        @lang('Login')
    </x-slot>

    <!-- Plain Colors Custom Styling -->
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

        /* Checkbox & Switch */
        .remember-forgot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .checkbox-container {
            display: inline-flex;
            align-items: center;
            color: #475569;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-container input {
            margin-right: 0.5rem;
            accent-color: #38b6ff;
            width: 16px;
            height: 16px;
        }

        .forgot-link {
            color: #38b6ff;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
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

        /* Demo Section */
        .demo-shelf {
            margin-top: 2.5rem;
            border-top: 1px solid #e2e8f0;
            padding-top: 2rem;
        }

        .demo-shelf-title {
            text-align: center;
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .demo-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        .demo-pill {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.65rem 0.5rem;
            color: #475569;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.35rem;
            user-select: none;
            transition: background-color 0.2s ease;
        }

        .demo-pill svg {
            width: 18px;
            height: 18px;
            stroke-width: 2px;
            color: #64748b;
        }

        .demo-pill:hover {
            background-color: #e2e8f0;
        }

        .demo-pill.active {
            background-color: #eff6ff !important;
            border-color: #bfdbfe !important;
            color: #1d4ed8 !important;
        }

        .demo-pill.active svg {
            color: #1d4ed8 !important;
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
            .demo-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="login-wrapper container-fluid p-0">
        <div class="row g-0 w-100">
            <!-- Left Side Feature Column -->
            <div class="col-lg-5 feature-banner">
                <div class="banner-logo">
                    <img src="{{ asset(setting('logo')) }}" alt="{{ app_name() }}">
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
                        <h2>Admin Portal</h2>
                        <p>Welcome back! Please log in to your account.</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ $url ?? route('login') }}" id="loginForm">
                        @csrf

                        <!-- Email Address -->
                        <div class="input-group-custom">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input id="email" type="email" name="email" :value="old('email')" class="input-custom" placeholder="name@pawandpaws.com" required autofocus pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address.">
                            <span id="emailError" class="text-danger mt-1 d-block" style="display: none; font-size: 0.8rem;">Invalid email format</span>
                        </div>

                        <!-- Password -->
                        <div class="input-group-custom">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" name="password" class="input-custom" placeholder="••••••••" required minlength="8" autocomplete="current-password" title="Password must be at least 8 characters.">
                            <span id="passwordError" class="text-danger mt-1 d-block" style="display: none; font-size: 0.8rem;">Password must be at least 8 characters</span>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="remember-forgot">
                            <label for="remember_me" class="checkbox-container">
                                <input type="checkbox" id="remember_me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="forgot-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn-solid">
                            {{ __('Log In') }}
                        </button>
                    </form>

                    <!-- Premium Demo Account Badges Grid -->
                    @if(env('IS_DEMO'))
                    <div class="demo-shelf">
                        <div class="demo-shelf-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Demo Accounts Shelf
                        </div>
                        <div class="demo-grid">
                            <!-- Admin Badge -->
                            <div class="demo-pill" onclick="setDemoCredentials('demo@pawandpawspetstore.com', '12345678', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span>Admin</span>
                            </div>

                            <!-- Boarder Badge -->
                            <div class="demo-pill" onclick="setDemoCredentials('miles@gmail.com', '12345678', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Boarder</span>
                            </div>

                            <!-- Veterinarian Badge -->
                            <div class="demo-pill" onclick="setDemoCredentials('felix@gmail.com', '12345678', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span>Vet Clinic</span>
                            </div>

                            <!-- Groomer Badge -->
                            <div class="demo-pill" onclick="setDemoCredentials('richard@gmail.com', '12345678', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7h7m-7-7h7M6 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>Groomer</span>
                            </div>

                            <!-- Trainer Badge -->
                            <div class="demo-pill" onclick="setDemoCredentials('tristan@gmail.com', '12345678', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>Trainer</span>
                            </div>

                            <!-- Walker Badge -->
                            <div class="demo-pill" onclick="setDemoCredentials('pedro@gmail.com', '12345678', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                <span>Walker</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Script handling dynamic actions -->
    <script type="text/javascript">
        function setDemoCredentials(email, password, element) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;

            // Remove active class from all pills
            var pills = document.querySelectorAll('.demo-pill');
            pills.forEach(function(pill) {
                pill.classList.remove('active');
            });

            // Add active class to clicked pill
            if (element) {
                element.classList.add('active');
            }
        }

        document.getElementById('password').addEventListener('input', function() {
            var passwordField = document.getElementById('password');
            var passwordError = document.getElementById('passwordError');

            if (passwordField.value.length > 0 && passwordField.value.length < 8) {
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });

        document.getElementById('email').addEventListener('input', function() {
            var emailField = document.getElementById('email');
            var emailError = document.getElementById('emailError');
            var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;

            if (emailField.value && !emailPattern.test(emailField.value)) {
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
            }
        });
    </script>
</x-auth-layout>
