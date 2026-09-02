@props(["extra"=>""])

<style>
    body {
        background-color: #0b0f19 !important;
        margin: 0;
        overflow-x: hidden;
        position: relative;
    }

    /* Ambient Fluid Blobs in Background */
    .ambient-blob {
        position: fixed;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.45;
        z-index: 1;
        mix-blend-mode: screen;
        pointer-events: none;
        animation: floatBlob 25s infinite alternate ease-in-out;
    }

    .blob-1 {
        width: 500px;
        height: 500px;
        background: rgba(37, 147, 234, 0.6);
        top: -10%;
        left: -10%;
        animation-duration: 20s;
    }

    .blob-2 {
        width: 600px;
        height: 600px;
        background: rgba(254, 229, 100, 0.45);
        bottom: -15%;
        right: -10%;
        animation-duration: 28s;
    }

    .blob-3 {
        width: 400px;
        height: 400px;
        background: rgba(168, 85, 247, 0.35);
        top: 40%;
        left: 30%;
        animation-duration: 24s;
        animation-delay: -5s;
    }

    @keyframes floatBlob {
        0% { transform: translate(0, 0) scale(1) rotate(0deg); }
        50% { transform: translate(100px, 80px) scale(1.15) rotate(180deg); }
        100% { transform: translate(-50px, -60px) scale(0.9) rotate(360deg); }
    }

    /* Split-screen wrapper */
    .login-wrapper {
        min-height: 100vh;
        display: flex;
        position: relative;
        z-index: 2;
    }

    /* Left Side Feature Banner */
    .feature-banner {
        background: #0f172a;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 4rem;
        color: #ffffff;
        box-shadow: 10px 0 50px rgba(0,0,0,0.3);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .banner-logo { z-index: 3; }
    .banner-logo img { max-height: 50px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1)); }

    .banner-content { margin: auto 0; z-index: 3; max-width: 480px; }

    .banner-title {
        font-size: 3.2rem;
        font-weight: 700;
        line-height: 1.15;
        margin-bottom: 1.5rem;
        color: #ffffff;
        letter-spacing: -0.04em;
    }

    .banner-title span { color: var(--bs-secondary); }

    .banner-subtitle {
        font-size: 1.15rem;
        color: #94a3b8;
        line-height: 1.6;
        margin-bottom: 3rem;
        font-weight: 300;
    }

    /* Pet Feature Badge Cards */
    .feature-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .feature-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 18px;
        padding: 1.25rem;
        backdrop-filter: blur(10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.3);
    }

    .feature-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(37, 147, 234, 0.2);
        color: var(--bs-primary);
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
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .banner-footer {
        z-index: 3;
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.4);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 1.5rem;
    }

    /* Right Side Form Panel */
    .form-panel {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
    }

    /* iOS-style Liquid Glass Card */
    .liquid-glass-card {
        width: 100%;
        max-width: 520px;
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        border-radius: 28px !important;
        padding: 3rem !important;
        backdrop-filter: blur(40px) saturate(220%) !important;
        -webkit-backdrop-filter: blur(40px) saturate(220%) !important;
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.35),
                    inset 0 -1px 1px rgba(0, 0, 0, 0.1),
                    0 24px 64px -16px rgba(15, 23, 42, 0.45) !important;
        transition: all 0.4s ease;
    }

    .liquid-glass-card:hover {
        border-color: rgba(255, 255, 255, 0.35) !important;
        box-shadow: inset 0 2px 2px rgba(255, 255, 255, 0.45),
                    inset 0 -1px 1px rgba(0, 0, 0, 0.1),
                    0 30px 80px -12px rgba(15, 23, 42, 0.55) !important;
    }

    .liquid-glass-card h2, .liquid-glass-card .form-header h2, .liquid-glass-card h1, .liquid-glass-card h3 {
        font-size: 1.85rem;
        font-weight: 700;
        color: #ffffff !important;
        letter-spacing: -0.03em;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .liquid-glass-card p, .liquid-glass-card .form-header p, .liquid-glass-card .text-muted, .liquid-glass-card div.my-4, .liquid-glass-card .text-gray-600 {
        color: #94a3b8 !important;
        font-size: 0.95rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .liquid-glass-card .text-green-600 {
        color: #22c55e !important;
        text-align: center;
    }

    /* Floating Input Styling */
    .liquid-glass-card label, .liquid-glass-card .form-label {
        display: block;
        color: #cbd5e1 !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        margin-bottom: 0.5rem !important;
        letter-spacing: 0.02em !important;
    }

    .liquid-glass-card input[type="text"],
    .liquid-glass-card input[type="email"],
    .liquid-glass-card input[type="password"],
    .liquid-glass-card input[type="number"],
    .liquid-glass-card input[type="tel"],
    .liquid-glass-card .form-control {
        width: 100%;
        background: rgba(15, 23, 42, 0.4) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 14px !important;
        padding: 0.95rem 1.25rem !important;
        color: #ffffff !important;
        font-size: 1rem !important;
        transition: all 0.3s ease !important;
        margin-bottom: 0;
    }
    
    .liquid-glass-card .mb-3, .liquid-glass-card .mt-4 {
        margin-bottom: 1.25rem !important;
    }

    .liquid-glass-card input::placeholder {
        color: rgba(255, 255, 255, 0.3) !important;
    }

    .liquid-glass-card input:focus {
        outline: none !important;
        border-color: var(--bs-primary) !important;
        background: rgba(15, 23, 42, 0.6) !important;
        box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.25) !important;
    }

    /* Checkbox */
    .liquid-glass-card input[type="checkbox"], .liquid-glass-card .form-check-input {
        accent-color: var(--bs-primary) !important;
        width: 16px;
        height: 16px;
        margin-right: 0.5rem;
        background-color: rgba(15, 23, 42, 0.4) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
    }

    .liquid-glass-card a {
        color: var(--bs-primary);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .liquid-glass-card a:hover {
        color: #1a75c2;
        text-decoration: underline;
    }

    /* Button Redesign: Liquid Polish */
    .liquid-glass-card button, .liquid-glass-card .btn, .liquid-glass-card input[type="submit"] {
        width: 100%;
        background-color: var(--bs-primary) !important;
        border: none !important;
        border-radius: 14px !important;
        padding: 1rem !important;
        color: #ffffff !important;
        font-size: 1.05rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.02em !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35) !important;
        cursor: pointer !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        margin-top: 1rem;
        display: block;
        text-align: center;
    }

    .liquid-glass-card button:hover, .liquid-glass-card .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5) !important;
    }

    .liquid-glass-card button:active, .liquid-glass-card .btn:active {
        transform: translateY(1px);
    }

    /* Responsiveness */
    @media (max-width: 991px) {
        .feature-banner { display: none !important; }
        .form-panel { padding: 1.5rem; }
        .liquid-glass-card { padding: 2rem !important; max-width: 460px; }
    }
</style>

<!-- Floating Background Fluid Blobs -->
<div class="ambient-blob blob-1"></div>
<div class="ambient-blob blob-2"></div>
<div class="ambient-blob blob-3"></div>

<div class="login-wrapper container-fluid p-0">
    <div class="row g-0 w-100">
        <!-- Left Side Feature Column -->
        <div class="col-lg-5 feature-banner">
            <div class="banner-logo">
                @if(setting('logo'))
                    <img src="{{ asset(setting('logo')) }}" alt="{{ app_name() }}" onerror="this.style.display='none'; document.getElementById('banner-logo-fallback').style.display='flex';" style="max-height: 44px; object-fit: contain;">
                @endif
                <div id="banner-logo-fallback" style="{{ setting('logo') ? 'display: none;' : 'display: flex;' }} align-items: center; gap: 10px;">
                    <div style="width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #38b6ff 0%, #0052cc 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.2rem;">🐾</div>
                    <span style="font-size: 1.35rem; font-weight: 800; color: #ffffff; letter-spacing: -0.5px;">{{ app_name() }}</span>
                </div>
            </div>

            <div class="banner-content">
                <h1 class="banner-title">Take Control of Your <span>Pet Business</span></h1>
                <p class="banner-subtitle">Redesigned with state-of-the-art liquid tools. Manage boarding bookings, veterinarian clinics, grooming services, walk paths, and training operations from one unified, beautiful dashboard.</p>
                
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
                        <div class="feature-card-desc">Track custom pet cuts and booking data.</div>
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
            <div class="liquid-glass-card card">
                @if(isset($logo))
                <div class="form-header text-center mb-4">
                    {{ $logo }}
                </div>
                @endif

                <div class="auth-card-content">
                    {{ $slot }}
                </div>

                <div class="text-center mt-4">
                    {{ $extra }}
                </div>
            </div>
        </div>
    </div>
</div>
