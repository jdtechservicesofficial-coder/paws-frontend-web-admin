@extends($activeTemplate.'layouts.master')
@section('content')

<div class="row g-4 mb-4 mt-2">
    <div class="col-xl-3 col-sm-6">
        <div style="background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 80%, #0f172a 100%); border-radius: 20px; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 10px 30px rgba(0,0,0,0.25); padding: 24px 20px; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <span style="font-size: 13px; font-weight: 700; color: #93c5fd; text-transform: uppercase; letter-spacing: 0.5px;">@lang('Total Orders')</span>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(37, 99, 235, 0.3); color: #60a5fa; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="las la-shopping-bag"></i>
                    </div>
                </div>
                <h2 style="font-size: 32px; font-weight: 800; color: #ffffff !important; margin-bottom: 16px; line-height: 1;">{{ __($ordersCount) }}</h2>
            </div>
            <a href="{{ route('user.orders') }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 9px 16px; border-radius: 10px; background: #2563eb; color: #ffffff; font-weight: 700; font-size: 13px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#1d4ed8';" onmouseout="this.style.background='#2563eb';">
                @lang('View Orders') <i class="las la-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div style="background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 80%, #0f172a 100%); border-radius: 20px; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 10px 30px rgba(0,0,0,0.25); padding: 24px 20px; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <span style="font-size: 13px; font-weight: 700; color: #fca5a5; text-transform: uppercase; letter-spacing: 0.5px;">@lang('Total Wishlists')</span>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(239, 68, 68, 0.25); color: #f87171; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="las la-heart"></i>
                    </div>
                </div>
                <h2 style="font-size: 32px; font-weight: 800; color: #ffffff !important; margin-bottom: 16px; line-height: 1;">{{ __($wishlistCount) }}</h2>
            </div>
            <a href="{{ route('user.get.wishlist') }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 9px 16px; border-radius: 10px; background: #ef4444; color: #ffffff; font-weight: 700; font-size: 13px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#dc2626';" onmouseout="this.style.background='#ef4444';">
                @lang('View Wishlists') <i class="las la-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div style="background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 80%, #0f172a 100%); border-radius: 20px; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 10px 30px rgba(0,0,0,0.25); padding: 24px 20px; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <span style="font-size: 13px; font-weight: 700; color: #d8b4fe; text-transform: uppercase; letter-spacing: 0.5px;">@lang('Support Tickets')</span>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(147, 51, 234, 0.25); color: #c084fc; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="las la-headset"></i>
                    </div>
                </div>
                <h2 style="font-size: 32px; font-weight: 800; color: #ffffff !important; margin-bottom: 16px; line-height: 1;">{{ $user->tickets->count() }}</h2>
            </div>
            <a href="{{ route('ticket') }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 9px 16px; border-radius: 10px; background: #9333ea; color: #ffffff; font-weight: 700; font-size: 13px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#7e22ce';" onmouseout="this.style.background='#9333ea';">
                @lang('View Tickets') <i class="las la-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div style="background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 80%, #0f172a 100%); border-radius: 20px; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 10px 30px rgba(0,0,0,0.25); padding: 24px 20px; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <span style="font-size: 13px; font-weight: 700; color: #86efac; text-transform: uppercase; letter-spacing: 0.5px;">@lang('Member Since')</span>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(22, 163, 74, 0.25); color: #4ade80; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="las la-calendar-check"></i>
                    </div>
                </div>
                <h2 style="font-size: 24px; font-weight: 800; color: #ffffff !important; margin-bottom: 6px; line-height: 1.2;">{{ showDateTime($user->created_at,'M Y') }}</h2>
                <span style="font-size: 13px; color: #cbd5e1; font-weight: 600;">@lang('Registered') {{ diffForHumans($user->created_at) }}</span>
            </div>
            <div style="margin-top: 16px;">
                <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; background: rgba(22, 163, 74, 0.25); color: #4ade80; font-size: 12px; font-weight: 700; border: 1px solid rgba(74, 222, 128, 0.3);">
                    <i class="las la-check-circle me-1"></i> @lang('Active Member')
                </span>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if ($general -> secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });

        $('[name=password]').focus(function () {
            $(this).closest('.form-group').addClass('hover-input-popup');
        });

        $('[name=password]').focusout(function () {
            $(this).closest('.form-group').removeClass('hover-input-popup');
        });
        @endif
    })(jQuery);
</script>
@endpush
