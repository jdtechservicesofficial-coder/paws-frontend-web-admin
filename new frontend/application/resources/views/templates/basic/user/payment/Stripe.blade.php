@extends($activeTemplate.'layouts.master')
@section('content')
<style>
    .payment-confirm-card {
        background: #ffffff !important;
        border-radius: 24px;
        padding: 32px;
        border: 2px solid #fdcd01 !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    .payment-confirm-card .card-header {
        background: transparent;
        border-bottom: 2px dashed #f1f5f9;
        padding-bottom: 16px;
        margin-bottom: 24px;
        border-radius: 0;
    }
    .payment-confirm-card .card-title {
        font-weight: 800;
        color: #0047b3 !important;
        font-size: 22px;
        margin: 0;
    }
    .btn-payment {
        background: #fdcd01 !important;
        color: #0047b3 !important;
        padding: 16px 24px;
        border-radius: 14px;
        font-weight: 800;
        font-size: 18px;
        border: none;
        width: 100%;
        margin-top: 24px;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(253, 205, 1, 0.3);
    }
    .btn-payment:hover {
        background: #eab308 !important;
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(253, 205, 1, 0.4);
    }
    .form--label {
        font-weight: 600;
        color: #475569 !important;
    }
    .form--control {
        border-radius: 12px;
        background: #f8fafc !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1;
    }
    .form--control:focus {
        border-color: #fdcd01;
        background: #ffffff !important;
    }
</style>
<div class="container pb-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="payment-confirm-card">
                <div class="card-header">
                    <h5 class="card-title text-center">@lang('Stripe Checkout')</h5>
                </div>
                <div class="card-body p-0">
                    <div class="card-wrapper mb-4"></div>
                    <form role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                        @csrf
                        <input type="hidden" value="{{$data->track}}" name="track">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label form--label">@lang('Name on Card')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form--control" name="name"
                                        value="{{ old('name') }}" required autocomplete="off" autofocus />
                                    <span class="input-group-text"><i class="fa fa-font"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label form--label">@lang('Card Number')</label>
                                <div class="input-group">
                                    <input type="tel" class="form-control form--control" name="cardNumber"
                                        autocomplete="off" value="{{ old('cardNumber') }}" required autofocus />
                                    <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label form--label">@lang('Expiration Date')</label>
                                <input type="tel" class="form-control form--control" name="cardExpiry"
                                    value="{{ old('cardExpiry') }}" autocomplete="off" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label form--label">@lang('CVC Code')</label>
                                <input type="tel" class="form-control form--control" name="cardCVC"
                                    value="{{ old('cardCVC') }}" autocomplete="off" required />
                            </div>
                        </div>
                        <button class="btn-payment" type="submit">
                            @lang('Pay Now') <i class="las la-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
<script src="{{ asset('assets/common/js/card.js') }}"></script>

<script>
    (function ($) {
        "use strict";
        var card = new Card({
            form: '#payment-form',
            container: '.card-wrapper',
            formSelectors: {
                numberInput: 'input[name="cardNumber"]',
                expiryInput: 'input[name="cardExpiry"]',
                cvcInput: 'input[name="cardCVC"]',
                nameInput: 'input[name="name"]'
            }
        });
    })(jQuery);
</script>
@endpush
