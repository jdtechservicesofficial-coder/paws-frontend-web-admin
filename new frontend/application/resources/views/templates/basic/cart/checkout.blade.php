@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $total = 0;
        if (session('cart')) {
            foreach (session('cart') as $id => $details) {
                $total += @$details['price'] * @$details['quantity'];
            }
        }
    @endphp
    <style>
        /* Modern Checkout Redesign */
        .checkout-page-bg {
            background: #f8fafc;
            min-height: 100vh;
            padding: 60px 0 100px 0;
        }
        .checkout-header {
            margin-bottom: 40px;
        }
        .checkout-header h1 {
            font-size: 36px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .premium-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        }
        .card-title-modern {
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 24px;
            font-size: 22px;
            padding-bottom: 16px;
            border-bottom: 2px dashed #e2e8f0;
        }
        .info-accordion {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .info-accordion:hover {
            background: #dbeafe;
        }
        .info-accordion h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #1e3a8a;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .form--label {
            font-weight: 600;
            color: #475569;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .form--control {
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            padding: 14px 16px;
            font-size: 15px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.01);
            background: #ffffff;
        }
        .form--control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
            outline: none;
        }
        .order-summary-sticky {
            position: sticky;
            top: 40px;
        }
        .order-item-modern {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .order-item-modern:last-child {
            border-bottom: none;
        }
        .order-item-title {
            font-weight: 700;
            color: #1e293b;
            font-size: 15px;
        }
        .order-item-qty {
            font-size: 13px;
            color: #64748b;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 6px;
            margin-left: 8px;
        }
        .order-item-price {
            font-weight: 700;
            color: #0f172a;
        }
        .summary-row-modern {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            font-size: 15px;
        }
        .summary-label-modern {
            font-weight: 600;
            color: #475569;
        }
        .summary-val-modern {
            font-weight: 700;
            color: #0f172a;
        }
        .grand-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 2px dashed #e2e8f0;
        }
        .grand-total-label {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }
        .grand-total-val {
            font-size: 28px;
            font-weight: 900;
            color: #2563eb;
        }
        .btn-modern {
            background: #2563eb;
            color: #ffffff;
            padding: 16px 24px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 16px;
            border: none;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(37,99,235,0.2);
            cursor: pointer;
        }
        .btn-modern:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(37,99,235,0.3);
            color: #ffffff;
        }
    </style>

    <section class="checkout-page-bg">
        <div class="container">
            <div class="checkout-header">
                <h1>@lang('Checkout')</h1>
                <p style="color: #64748b; font-weight: 500; margin-top: 8px;">Complete your order securely below.</p>
            </div>

            <div class="row">
                <div class="col-lg-7 col-xl-8">
                    <!-- Login / Coupon Accordions -->
                    <div class="info-accordion" id="showlogin">
                        <h4><i class="las la-user-circle" style="font-size: 24px;"></i> @lang('Returning customer? Click here to login')</h4>
                    </div>
                    
                    <div id="checkout-login" class="premium-card" style="display: none;">
                        <h3 class="card-title-modern"> @lang('Sign In') </h3>
                        <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="username" class="form--label"> @lang('Username or Email')</label>
                                        <input type="text" class="form--control" id="username" name="username" value="{{ old('username') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label for="your-password" class="form--label">@lang('Password')</label>
                                    <div class="input-group">
                                        <input id="your-password" type="password" class="form-control form--control" name="password" required>
                                    </div>
                                    <x-captcha></x-captcha>
                                </div>
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold text-secondary" for="remember">@lang('Remember me')</label>
                                        </div>
                                        <a href="{{ route('user.password.request') }}" class="text--base fw-bold">@lang('Forgot Password?')</a>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-4">
                                    <button type="submit" class="btn-modern" style="width: auto; padding: 12px 32px;" id="recaptcha">
                                        @lang('Sign In') <i class="las la-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="info-accordion" id="showcupon">
                        <h4><i class="las la-tags" style="font-size: 24px;"></i> @lang('Have a coupon? Click here to enter your code')</h4>
                    </div>
                    
                    <div id="coupon-checkout" class="premium-card" style="display: none;">
                        <h3 class="card-title-modern"> @lang('Enter Your Coupon Code') </h3>
                        <form action="{{ route('apply.coupon') }}" method="post">
                            @csrf
                            <div class="d-flex gap-3">
                                <input type="text" name="coupon" class="form--control" placeholder="Coupon Code" style="flex-grow: 1;">
                                <button type="submit" class="btn-modern" style="width: auto;">@lang('Apply')</button>
                            </div>
                        </form>
                    </div>

                    <!-- Billing Details -->
                    <div class="premium-card mt-4">
                        <h3 class="card-title-modern">@lang('Billing Details')</h3>
                        <form action="{{ auth()->user() ? route('user.product.payment') : route('product.payment') }}" method="post" id="checkoutPaymentForm">
                            @csrf
                            <input type="hidden" name="method_code">
                            <input type="hidden" name="currency">
                            
                            <div class="row gy-4">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname" class="form--label">@lang('First Name')</label>
                                        <input type="text" class="form--control" id="firstname" name="firstname" value="{{ auth()->user()->firstname ?? '' }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lastname" class="form--label">@lang('Last Name')</label>
                                        <input type="text" class="form--control" id="lastname" name="lastname" value="{{ auth()->user()->lastname ?? '' }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Country')</label>
                                        <select class="select form--control" name="country" required>
                                            <option data-mobile_code="234" value="Nigeria" data-code="NG" selected>Nigeria</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Mobile')</label>
                                        <div class="input-group">
                                            <span class="input-group-text mobile-code" style="background: #f8fafc; border-radius: 12px 0 0 12px; border-color: #cbd5e1; font-weight: 700; color: #475569;"></span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <input type="number" class="form-control form--control" name="mobile" style="border-radius: 0 12px 12px 0;" value="{{ old('mobile') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="your-email" class="form--label">@lang('Email')</label>
                                        <input type="email" class="form--control" id="your-email" name="email" value="{{ auth()->user()->email ?? '' }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Shipping Zone')</label>
                                        <select class="select form--control" name="shipping" id="shipping_zone" required>
                                            <option value="" data-price="0">@lang('Select Shipping Zone')</option>
                                            @foreach ($shippings as $item)
                                                <option value="{{ $item->id }}" data-price="{{ $item->standard_delivery_charge }}">{{ __($item->name) }} - {{ __($general->cur_sym) }}{{ showAmount($item->standard_delivery_charge) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="your-address" class="form--label">@lang('Address')</label>
                                        @php
                                            $fullAddress = '';
                                            if (!empty(auth()->user()) && auth()->user()->address) {
                                                $address = auth()->user()->address;
                                                $fullAddress .= $address->address ? $address->address . ', ' : '';
                                                $fullAddress .= $address->state ? $address->state . ', ' : '';
                                                $fullAddress .= $address->zip ? $address->zip . ', ' : '';
                                                $fullAddress .= $address->city ? $address->city : '';
                                            }
                                        @endphp
                                        <textarea class="form--control" id="your-address" name="address" rows="3">{{ $fullAddress }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="col-lg-5 col-xl-4">
                    <div class="premium-card order-summary-sticky">
                        <h3 class="card-title-modern">@lang('Your Order')</h3>
                        
                        <div class="mb-4">
                            @forelse (session('cart', []) as $id => $details)
                            <div class="order-item-modern">
                                <div class="order-item-title">
                                    {{ $details['name'] }} <span class="order-item-qty">x {{ $details['quantity'] }}</span>
                                </div>
                                <div class="order-item-price">
                                    {{ __($general->cur_sym) }}{{ showAmount(@$details['price'] * @$details['quantity']) }}
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted py-3 fw-bold">@lang('No Products in Cart')</div>
                            @endforelse
                        </div>

                        <div class="summary-details">
                            <div class="summary-row-modern">
                                <span class="summary-label-modern">@lang('Subtotal')</span>
                                <span class="summary-val-modern" id="subtotalAmount" data-subtotal="{{ $total - ($total * (Session::get('coupon')['discount'] ?? 0)) / 100 }}">
                                    {{ __($general->cur_sym) }}
                                    @if (Session::has('coupon'))
                                        {{ showAmount($total - ($total * (Session::get('coupon')['discount'] ?? 0)) / 100) }}
                                    @else
                                        {{ showAmount(__($total)) }}
                                    @endif
                                </span>
                            </div>
                            
                            <!-- This will be displayed via JS -->
                            <div class="summary-row-modern text-success" id="shippingAmountRow" style="display:none;">
                                <span class="summary-label-modern">@lang('Shipping')</span>
                                <span class="summary-val-modern" id="shippingAmount">+ {{ __($general->cur_sym) }} <span>0.00</span></span>
                            </div>

                            <div class="summary-row-modern text-danger">
                                <span class="summary-label-modern">@lang('VAT')</span>
                                <span class="summary-val-modern" id="taxAmount" data-taxvalue="{{ $tax ? $tax->value : 0 }}" data-taxtype="{{ $tax ? $tax->type : 'fixed' }}">
                                    + {{ __($general->cur_sym) }} <span>0.00</span>
                                </span>
                            </div>

                            <div class="grand-total-row">
                                <span class="grand-total-label">@lang('Grand Total')</span>
                                <span class="grand-total-val" id="grandTotalAmount">
                                    {{ __($general->cur_sym) }} <span>0.00</span>
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4" style="border-top: 1px solid #f1f5f9;">
                            <div class="form-group mb-4">
                                <label class="form--label">@lang('Payment Method')</label>
                                <select class="select form--control" name="gateway" form="checkoutPaymentForm" required>
                                    <option value="">@lang('Select One')</option>
                                    @foreach ($gatewayCurrency as $data)
                                        <option value="{{ $data->method_code }}" @selected(old('gateway') == $data->method_code) data-gateway="{{ $data }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4" style="display: none;">
                                <label class="form--label">@lang('Amount To Pay')</label>
                                <div class="input-group">
                                    @if (Session::has('coupon'))
                                        <input type="number" step="any" name="amount" form="checkoutPaymentForm" class="form-control form--control" value="{{ $total - ($total * (Session::get('coupon')['discount'] ?? 0)) / 100 ?? $total }}" required readonly style="border-radius: 12px 0 0 12px;">
                                    @else
                                        <input type="number" step="any" name="amount" form="checkoutPaymentForm" class="form-control form--control" value="{{ $total }}" required readonly style="border-radius: 12px 0 0 12px;">
                                    @endif
                                    <span class="input-group-text" style="background: #f8fafc; border-radius: 0 12px 12px 0; border-color: #cbd5e1; font-weight: 700;">{{ $general->cur_text }}</span>
                                </div>
                            </div>
                            
                            <button form="checkoutPaymentForm" type="submit" class="btn-modern">
                                <i class="las la-lock"></i> @lang('Place Order securely')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            
            function calculateTotals() {
                let subtotal = parseFloat('{{ $total - ($total * (Session::get('coupon')['discount'] ?? 0)) / 100 }}') || 0;
                let taxValue = parseFloat($('#taxAmount').data('taxvalue')) || 0;
                let taxType = $('#taxAmount').data('taxtype');
                
                // Get shipping cost
                let shippingCost = 0;
                let shippingVal = $('#shipping_zone').val();
                if(shippingVal && shippingVal !== "") {
                    let selectedOpt = $('#shipping_zone option[value="' + shippingVal + '"]');
                    shippingCost = parseFloat(selectedOpt.attr('data-price')) || 0;
                }
                
                // Update shipping display
                $('#shippingAmount span').text(shippingCost.toFixed(2));
                
                let taxAmount = 0;
                if(taxType === 'percentage') {
                    taxAmount = subtotal * (taxValue / 100);
                } else {
                    taxAmount = taxValue;
                }
                
                let grandTotal = subtotal + taxAmount + shippingCost;
                
                $('#shippingAmount span').text(shippingCost.toFixed(2));
                $('#taxAmount span').text(taxAmount.toFixed(2));
                $('#grandTotalAmount span').text(grandTotal.toFixed(2));
                $('input[name=amount]').val(grandTotal.toFixed(2));
            }
            
            $(document).ready(function() {
                calculateTotals();
                
                $(document).on('change', '#shipping_zone', function() {
                    calculateTotals();
                    if($('select[name=gateway]').val()) {
                        $('select[name=gateway]').trigger('change');
                    }
                });
            });

            // existing code
            let isCoupon = '{{ Session::has('coupon') }}';
            $('select[name=gateway]').change(function() {
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
                var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate).toFixed(
                    toFixedDigit);
                $('.final_amo').text(final_amo);
                if (resource.currency != '{{ $general->cur_text }}') {
                    var rateElement =
                        `<span class="fw-bold">@lang('Conversion Rate')</span> <span><span  class="fw-bold">1 {{ __($general->cur_text) }} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span></span>`;
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
            $('input[name=amount]').on('input', function() {
                $('select[name=gateway]').change();
                $('.amount').text(parseFloat($(this).val()).toFixed(2));
            });
        })(jQuery);
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
