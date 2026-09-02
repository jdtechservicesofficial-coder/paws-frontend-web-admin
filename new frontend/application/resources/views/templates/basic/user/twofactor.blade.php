@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center g-4">
        <div class="col-md-6">
            @if(auth()->user()->ts)
            <div class="card custom--card">
                <div class="card-body">
                    <form action="{{route('user.twofactor.disable')}}" method="POST">
                        <h4 class="card-title mb-4" style="color: #ffffff; font-weight: 800;">@lang('Disable Two Factor Authentication')</h4>
                        @csrf
                        <input type="hidden" name="key" value="{{$secret}}">
                        <div class="form-group mb-3">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Google Authenticator OTP')</label>
                            <input type="text" class="form-control form--control" name="code" placeholder="Enter 6-digit code" required>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn--base">@lang('Disable 2FA')</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="card custom--card">
                <div class="card-body">
                    <h4 class="card-title mb-4" style="color: #ffffff; font-weight: 800;">@lang('Enable Two Factor Authentication')</h4>
                    <form action="{{ route('user.twofactor.enable') }}" method="POST">
                        @csrf
                        <input type="hidden" name="key" value="{{$secret}}">
                        <div class="form-group mb-3">
                            <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Google Authenticator App OTP')</label>
                            <input type="text" class="form-control form--control" name="code" placeholder="Enter 6-digit code" required>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn--base">@lang('Verify & Enable')</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @if(!auth()->user()->ts)
        <div class="col-md-6">
            <div class="card custom--card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-3" style="color: #ffffff; font-weight: 800;">@lang('Scan this QR Code')</h4>
                    <p style="color: #94a3b8; font-size: 13.5px; margin-bottom: 20px;">@lang('Use your Google Authenticator app on your phone to scan the QR code below.')</p>
                    
                    <div class="form-group mx-auto text-center mb-4">
                        <div style="background: #ffffff; padding: 14px; border-radius: 18px; display: inline-block; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                            <img class="mx-auto" src="{{$qrCodeUrl}}" alt="QR Code" style="width: 170px; height: 170px; display: block; border-radius: 8px;">
                        </div>
                    </div>

                    <div class="form-group text-start">
                        <label class="form-label" style="color: #cbd5e1; font-weight: 600;">@lang('Or Enter Setup Key Manually')</label>
                        <div class="input-group">
                            <input type="text" name="key" value="{{$secret}}"
                                class="form-control form--control referralURL" readonly style="font-weight: 700; letter-spacing: 1px; color: #60a5fa !important;">
                            <button type="button" class="input-group-text copytext btn btn-primary" id="copyBoard" style="background: #2563eb; color: #fff; border: none; padding: 0 18px;">
                                <i class="fa fa-copy me-1"></i> @lang('Copy')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('style')
<style>
    .copied::after {
        background-color: #{{ $general->base_color }
    }

    ;
    }
</style>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";
        $('#copyBoard').on('click', function () {
            var copyText = document.getElementsByClassName("referralURL");
            copyText = copyText[0];
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            copyText.blur();
            this.classList.add('copied');
            setTimeout(() => this.classList.remove('copied'), 1500);
        });
    })(jQuery);
</script>
@endpush