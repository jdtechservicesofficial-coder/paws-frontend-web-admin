<div class="d-inline-flex flex-column align-items-center justify-content-center">
    @if(setting('logo'))
        <img src="{{ asset(setting('logo')) }}" class="img-fluid mb-3" style="max-height: 48px; object-fit: contain;" alt="{{ app_name() }}" onerror="this.style.display='none'; document.getElementById('auth-logo-fallback').style.display='flex';">
    @endif
    <div id="auth-logo-fallback" style="{{ setting('logo') ? 'display: none;' : 'display: flex;' }} align-items: center; justify-content: center; width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #38b6ff 0%, #0052cc 100%); box-shadow: 0 8px 20px -4px rgba(56, 182, 255, 0.4); margin: 0 auto 1rem;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="28" height="28" style="color: #ffffff;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
    </div>
</div>
