@extends($activeTemplate.'layouts.master')
@section('content')

<div class="row mb-30">
    <div class="col-md-12">
        <div class="row justify-content-center mb-30-none">

            <div class="col-lg-3 col-sm-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Total Orders')</h4>
                        <h2>{{ __($ordersCount) }}</h2>
                        <a href="{{ route('user.orders') }}"
                            class="btn btn-sm btn--primary rounded text-white">@lang('
                            View Orders')</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Total Wishlists')</h4>
                        <h2>{{ __($wishlistCount) }}</h2>
                        <a href="{{ route('user.get.wishlist') }}"
                            class="btn btn-sm btn--primary rounded text-white">@lang('
                            View Wishlists')</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Support Tickets')</h4>
                        <h2> {{ $user->tickets->count() }}</h2>
                        <a href="{{ route('ticket') }}" class="btn btn-sm btn--primary rounded text-white">@lang('View Details')</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card mb-30 dashboard">
                    <div class="card-body">
                        <h4 class="title">@lang('Member Since')</h4>
                        <h2> {{ showDateTime($user->created_at,'M Y') }}</h2>
                        <span class="text-dark">@lang('Registered') {{ diffForHumans($user->created_at) }}</span>
                    </div>
                </div>
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
