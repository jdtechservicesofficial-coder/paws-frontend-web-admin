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
    .payment-list {
        background: transparent;
    }
    .payment-list .list-group-item {
        background: transparent;
        border: none;
        border-bottom: 1px solid #f1f5f9;
        padding: 16px 0;
        color: #475569 !important;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 16px;
    }
    .payment-list .list-group-item:last-child {
        border-bottom: none;
    }
    .payment-list .list-group-item strong {
        color: #0047b3 !important;
        font-weight: 800;
        font-size: 18px;
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
</style>
<div class="container pb-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="payment-confirm-card">
                <div class="card-header">
                    <h5 class="card-title text-center">@lang('Paystack Checkout')</h5>
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                        @csrf
                        <ul class="list-group payment-list text-center">
                            <li class="list-group-item">
                                <span>@lang('Total Amount')</span>
                                <strong>{{showAmount($deposit->amount - optional($deposit->order)->shipping_cost)}}  {{__($general->cur_text)}}</strong>
                            </li>
                            @if(optional($deposit->order)->shipping_cost > 0)
                            <li class="list-group-item">
                                <span>@lang('Shipping Fee')</span>
                                <strong>{{showAmount(optional($deposit->order)->shipping_cost)}}  {{__($general->cur_text)}}</strong>
                            </li>
                            @endif
                            <li class="list-group-item" style="border-top: 2px dashed #f1f5f9; margin-top: 8px;">
                                <span style="font-size: 18px; color: #0047b3 !important; font-weight: 800;">@lang('Total to Pay')</span>
                                <strong style="font-size: 24px; color: #0047b3 !important;">{{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong>
                            </li>
                        </ul>
                        <button type="button" class="btn-payment" id="btn-confirm">
                            @lang('Pay Now') <i class="las la-arrow-right ms-2"></i>
                        </button>
                        <script
                            src="//js.paystack.co/v1/inline.js"
                            data-key="{{ $data->key }}"
                            data-email="{{ $data->email }}"
                            data-amount="{{ round($data->amount) }}"
                            data-currency="{{$data->currency}}"
                            data-ref="{{ $data->ref }}"
                            data-custom-button="btn-confirm"
                        >
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
