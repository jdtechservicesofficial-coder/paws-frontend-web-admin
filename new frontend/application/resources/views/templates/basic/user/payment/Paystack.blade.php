@extends($activeTemplate.'layouts.master')
@section('content')
<style>
    .payment-confirm-card {
        background: #ffffff !important;
        border-radius: 20px;
        padding: 40px;
        border: none !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        max-width: 500px;
        margin: 0 auto;
    }
    .payment-confirm-card .card-header {
        background: transparent;
        border-bottom: 1px dashed #e2e8f0;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-radius: 0;
    }
    .payment-confirm-card .card-title {
        font-weight: 900;
        color: #0052cc !important;
        font-size: 24px;
        margin: 0;
    }
    .payment-list {
        background: transparent;
        margin-bottom: 30px;
    }
    .payment-list .list-group-item {
        background: transparent;
        border: none;
        padding: 12px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .payment-list .list-group-item span {
        color: #475569 !important;
        font-weight: 700;
        font-size: 15px;
    }
    .payment-list .list-group-item strong {
        color: #0052cc !important;
        font-weight: 900;
        font-size: 16px;
    }
    
    .payment-list .list-group-item.total-row {
        margin-top: 15px;
        padding-top: 20px;
    }
    .payment-list .list-group-item.total-row span {
        color: #0052cc !important;
        font-weight: 900;
        font-size: 18px;
    }
    .payment-list .list-group-item.total-row strong {
        color: #0052cc !important;
        font-weight: 900;
        font-size: 22px;
    }
    .btn-payment {
        background: #fdcd01 !important;
        color: #0052cc !important;
        padding: 18px 24px;
        border-radius: 12px;
        font-weight: 900;
        font-size: 18px;
        border: none;
        width: 100%;
        transition: all 0.3s;
        box-shadow: 0 8px 25px rgba(253, 205, 1, 0.4);
    }
    .btn-payment:hover {
        background: #eab308 !important;
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(253, 205, 1, 0.5);
    }
</style>
<div class="container pb-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="payment-confirm-card">
                <div class="card-header text-center">
                    <h5 class="card-title">Paystack Checkout</h5>
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                        @csrf
                        <ul class="list-group payment-list">
                            <li class="list-group-item">
                                <span>Total Amount</span>
                                <strong>{{showAmount($deposit->amount - optional($deposit->order)->shipping_cost)}} {{__($general->cur_text)}}</strong>
                            </li>
                            @if(optional($deposit->order)->shipping_cost > 0)
                            <li class="list-group-item">
                                <span>Shipping Fee</span>
                                <strong>{{showAmount(optional($deposit->order)->shipping_cost)}} {{__($general->cur_text)}}</strong>
                            </li>
                            @endif
                            <li class="list-group-item total-row">
                                <span>Total to Pay</span>
                                <strong>{{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong>
                            </li>
                        </ul>
                        <button type="button" class="btn-payment" id="btn-confirm">
                            Pay Now <i class="las la-arrow-right ms-2"></i>
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
