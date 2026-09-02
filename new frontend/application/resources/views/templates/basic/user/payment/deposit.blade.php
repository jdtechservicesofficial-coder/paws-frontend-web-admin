@extends($activeTemplate.'layouts.frontend')
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
<div class="cmn-section ptb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="{{route('user.deposit.insert')}}" method="post">
                    @csrf
                    <input type="hidden" name="method_code">
                    <input type="hidden" name="currency">
                    <div class="payment-confirm-card">
                        <div class="card-header text-center">
                            <h5 class="card-title">@lang('Make a Deposit')</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="form-group mb-4">
                                <label class="form-label form--label">@lang('Select Gateway')</label>
                                <select class="form-select form--control" name="gateway" required>
                                    <option value="">@lang('Select One')</option>
                                    @foreach($gatewayCurrency as $data)
                                    <option value="{{$data->method_code}}" @selected(old('gateway')==$data->method_code)
                                        data-gateway="{{ $data }}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label form--label">@lang('Amount')</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: #f1f5f9; border-color: #cbd5e1;">{{ $general->cur_text }}</span>
                                    <input type="number" step="any" name="amount" class="form-control form--control"
                                        value="{{ old('amount') }}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="mt-3 preview-details d-none">
                                <ul class="list-group" style="border: 2px dashed #f1f5f9; border-radius: 12px;">
                                    <li class="list-group-item d-flex justify-content-between" style="border: none; border-bottom: 1px solid #f1f5f9; color: #475569; font-weight: 600;">
                                        <span>@lang('Limit')</span>
                                        <span style="color: #0047b3;"><span class="min fw-bold">0</span> {{__($general->cur_text)}} - <span
                                                class="max fw-bold">0</span> {{__($general->cur_text)}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between" style="border: none; border-bottom: 1px solid #f1f5f9; color: #475569; font-weight: 600;">
                                        <span>@lang('Charge')</span>
                                        <span style="color: #0047b3;"><span class="charge fw-bold">0</span> {{__($general->cur_text)}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between" style="border: none; color: #475569; font-weight: 800; font-size: 18px;">
                                        <span>@lang('Payable')</span> <span style="color: #0047b3;"><span class="payable fw-bold"> 0</span>
                                            {{__($general->cur_text)}}</span>
                                    </li>
                                    <li class="list-group-item justify-content-between d-none rate-element">
                                    </li>
                                    <li class="list-group-item justify-content-between d-none in-site-cur">
                                        <span>@lang('In') <span class="base-currency"></span></span>
                                        <span class="final_amo fw-bold">0</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn-payment">@lang('Submit') <i class="las la-arrow-right ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        $('select[name=gateway]').change(function () {
            if (!$('select[name=gateway]').val()) {
                $('.preview-details').addClass('d-none');
                return false;
            }
            var resource = $('select[name=gateway] option:selected').data('gateway');
            var fixed_charge = parseFloat(resource.fixed_charge);
            var percent_charge = parseFloat(resource.percent_charge);
            var rate = parseFloat(resource.rate)
            if (resource.method.crypto == 1) {
                var toFixedDigit = 8;
                $('.crypto_currency').removeClass('d-none');
            } else {
                var toFixedDigit = 2;
                $('.crypto_currency').addClass('d-none');
            }
            $('.min').text(parseFloat(resource.min_amount).toFixed(2));
            $('.max').text(parseFloat(resource.max_amount).toFixed(2));
            var amount = parseFloat($('input[name=amount]').val());
            if (!amount) {
                amount = 0;
            }
            if (amount <= 0) {
                $('.preview-details').addClass('d-none');
                return false;
            }
            $('.preview-details').removeClass('d-none');
            var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
            $('.charge').text(charge);
            var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
            $('.payable').text(payable);
            var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate).toFixed(toFixedDigit);
            $('.final_amo').text(final_amo);
            if (resource.currency != '{{ $general->cur_text }}') {
                var rateElement = `<span class="fw-bold">@lang('Conversion Rate')</span> <span><span  class="fw-bold">1 {{__($general->cur_text)}} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span></span>`;
                $('.rate-element').html(rateElement)
                $('.rate-element').removeClass('d-none');
                $('.in-site-cur').removeClass('d-none');
                $('.rate-element').addClass('d-flex');
                $('.in-site-cur').addClass('d-flex');
            } else {
                $('.rate-element').html('')
                $('.rate-element').addClass('d-none');
                $('.in-site-cur').addClass('d-none');
                $('.rate-element').removeClass('d-flex');
                $('.in-site-cur').removeClass('d-flex');
            }
            $('.base-currency').text(resource.currency);
            $('.method_currency').text(resource.currency);
            $('input[name=currency]').val(resource.currency);
            $('input[name=method_code]').val(resource.method_code);
            $('input[name=amount]').on('input');
        });
        $('input[name=amount]').on('input', function () {
            $('select[name=gateway]').change();
            $('.amount').text(parseFloat($(this).val()).toFixed(2));
        });
    })(jQuery);
</script>
@endpush