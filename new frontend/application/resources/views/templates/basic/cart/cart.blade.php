@extends($activeTemplate . 'layouts.frontend')
@section('content')
<!-- ==================== Card Start Here ==================== -->
<style>
/* Modern Cart Redesign */
.cart-page-bg {
    background: #f8fafc;
    min-height: 100vh;
    padding: 60px 0 100px 0;
}
.cart-header {
    margin-bottom: 40px;
}
.cart-header h1 {
    font-size: 36px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
}
.cart-item-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 20px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    display: flex;
    align-items: center;
    gap: 24px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.cart-item-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.06);
    border-color: #e2e8f0;
}
.cart-item-img-wrapper {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    border-radius: 16px;
    overflow: hidden;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
}
.cart-item-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cart-item-details {
    flex-grow: 1;
}
.cart-item-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 8px;
    display: block;
    text-decoration: none;
}
.cart-item-title:hover {
    color: #2563eb;
}
.cart-item-price {
    font-size: 16px;
    font-weight: 600;
    color: #64748b;
}
.qty-wrapper {
    display: inline-flex;
    align-items: center;
    background: #f8fafc;
    border-radius: 12px;
    padding: 4px;
    border: 1px solid #e2e8f0;
}
.qty-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    background: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    color: #475569;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}
.qty-btn:hover {
    background: #2563eb;
    color: #ffffff;
}
.quantity-input {
    width: 48px;
    text-align: center;
    border: none;
    background: transparent;
    font-weight: 800;
    color: #0f172a;
    font-size: 16px;
}
.cart-item-total {
    font-size: 20px;
    font-weight: 800;
    color: #2563eb;
    min-width: 100px;
    text-align: right;
}
.remove-btn-modern {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    background: #fef2f2;
    color: #ef4444;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.2s;
    flex-shrink: 0;
}
.remove-btn-modern:hover {
    background: #ef4444;
    color: #ffffff;
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(239,68,68,0.2);
}
.cart-summary {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-radius: 24px;
    padding: 32px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    border: 1px solid rgba(255, 255, 255, 0.8);
    position: sticky;
    top: 40px;
}
.summary-title {
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 24px;
    font-size: 22px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f1f5f9;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}
.summary-label {
    font-weight: 600;
    color: #475569;
    font-size: 16px;
}
.summary-value {
    font-size: 28px;
    font-weight: 800;
    color: #2563eb;
}
.checkout-btn {
    background: #2563eb;
    color: #ffffff;
    padding: 18px;
    border-radius: 16px;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    transition: all 0.3s;
    box-shadow: 0 10px 20px rgba(37,99,235,0.2);
    border: none;
    width: 100%;
}
.checkout-btn:hover {
    background: #1d4ed8;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(37,99,235,0.3);
}
.empty-cart-state {
    background: #ffffff;
    border-radius: 24px;
    padding: 60px 20px;
    text-align: center;
    border: 1px dashed #cbd5e1;
}

@media(max-width: 991px) {
    .cart-summary {
        margin-top: 40px;
        position: static;
    }
}
@media(max-width: 768px) {
    .cart-item-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    .cart-item-img-wrapper {
        width: 100%;
        height: 200px;
    }
    .cart-item-actions {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .cart-item-total {
        text-align: left;
    }
}
</style>

<section class="cart-page-bg">
    <div class="container">
        <div class="cart-header">
            <h1>@lang('Your Cart')</h1>
            <p style="color: #64748b; font-weight: 500; margin-top: 8px;">Review your items before proceeding to checkout.</p>
        </div>

        <div class="row">
            @if(isset($cartItem) && count($cartItem) > 0)
                <!-- Cart Items List (Left Side) -->
                <div class="col-lg-8">
                    @foreach($cartItem as $product)
                        @php @$total += @$product['price'] * @$product['quantity'] @endphp
                        <div class="cart-item-card" data-product-id="{{$product['id']}}">
                            <!-- Image -->
                            <div class="cart-item-img-wrapper">
                                @php
                                    $mediaModel = isset($product['image_id']) ? \Illuminate\Support\Facades\DB::table('media')->where('id', $product['image_id'])->first() : null;
                                    $imageUrl = $mediaModel ? getCloudinaryOrLocalUrl($mediaModel) : getImage('');
                                @endphp
                                <img src="{{ $imageUrl }}" alt="product-image" class="cart-item-img">
                            </div>

                            <!-- Details -->
                            <div class="cart-item-details">
                                <a href="javascript:void(0)" class="cart-item-title">{{ @$product['name'] }}</a>
                                <div class="cart-item-price">{{__($general->cur_sym)}}{{showAmount(@$product['price'])}}</div>
                                
                                <div class="mt-3">
                                    <div class="qty-wrapper">
                                        @php
                                            $productModel = \App\Models\Product::find($product['id']);
                                            $maxQty = $productModel ? $productModel->quantity : 1;
                                        @endphp
                                        <button type="button" class="qty-btn sub"><i class="fa fa-minus"></i></button>
                                        <input type="number" class="quantity-input" value="{{ $product['quantity'] }}" max="{{ $maxQty }}" pattern="[1-9]" data-product-id="{{ $product['id'] }}" readonly>
                                        <button type="button" class="qty-btn add"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- Total & Remove -->
                            <div class="cart-item-actions" style="display: flex; align-items: center; gap: 24px;">
                                <div class="cart-item-total total-amount" id="total-amount-{{ $product['id'] }}">
                                    {{$general->cur_sym}}{{ showAmount($product['quantity'] * $product['price']) }}
                                </div>
                                <button class="remove-btn-modern remove-btn"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary (Right Side) -->
                <div class="col-lg-4" id="cartTotalSection">
                    <div class="cart-summary">
                        <h3 class="summary-title">@lang('Order Summary')</h3>
                        
                        <div class="summary-row">
                            <span class="summary-label">@lang('Subtotal')</span>
                            <span class="summary-value total-product-price">{{__($general->cur_sym)}}{{showAmount(__( @$total)) }}</span>
                        </div>
                        
                        <div style="background: #eff6ff; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
                            <p style="margin: 0; color: #1e3a8a; font-size: 14px; font-weight: 600; line-height: 1.5;">
                                <i class="las la-info-circle me-1" style="font-size: 18px;"></i>
                                Shipping and taxes will be calculated at checkout.
                            </p>
                        </div>

                        <a href="{{route('get.checkout')}}" class="checkout-btn text-decoration-none">
                            @lang('Proceed to Checkout') <i class="las la-arrow-right"></i>
                        </a>
                        
                        <div class="mt-4 text-center">
                            <span style="font-size: 13px; color: #94a3b8; font-weight: 600;">
                                <i class="las la-shield-alt me-1 text-success"></i> Secure Checkout Guaranteed
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart State -->
                <div class="col-lg-12">
                    <div class="empty-cart-state">
                        <i class="las la-shopping-bag mb-4" style="font-size: 64px; color: #cbd5e1;"></i>
                        <h3 style="font-weight: 800; color: #0f172a; margin-bottom: 12px;">@lang('Your cart is empty')</h3>
                        <p style="color: #64748b; font-size: 16px; margin-bottom: 30px;">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary px-5 py-3" style="border-radius: 12px; font-weight: 700; background: #2563eb; border: none; box-shadow: 0 8px 16px rgba(37,99,235,0.2);">
                            @lang('Continue Shopping')
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- ==================== Card End Here ==================== -->

@endsection

@push('script')

<script>
    $(document).ready(function() {

        // add quantity
        $('.add').on('click', function() {
            var quantityInput = $(this).siblings('.quantity-input');
            var productId = quantityInput.data('product-id');
            var quantity = parseInt(quantityInput.val()) || 0;
            var max = parseInt(quantityInput.attr('max')) || 1;

            if (quantity < max) {
                updateQuantity(productId, quantity + 1);
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'You cannot exceed the available stock quantity'
                });
            }
        });

        // sub quantity
        $('.sub').on('click', function() {
            var quantityInput = $(this).siblings('.quantity-input');
            var productId = quantityInput.data('product-id');
            var quantity = parseInt(quantityInput.val()) || 0;

            if (quantity > 1) {
                updateQuantity(productId, quantity - 1);
            }
        });

        // update quantity
        function updateQuantity(productId, quantity) {
            $.ajax({
                url: '{{ route("update.quantity") }}',
                type: 'get',
                data: {
                    productId: productId,
                    quantity: quantity
                },
                success: function(response) {
                    $('#total-amount-' + productId).text('{{$general->cur_sym}} ' + response.totalAmount);
                    $('[data-product-id="' + productId + '"]').val(response.quantity);
                    updateTotalPrice();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errorMessage = xhr.responseJSON.error;
                        Toast.fire({
                            icon: 'warning',
                            title: errorMessage
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'An error occurred.'
                        });
                    }
                }
            });
        }


        // remove card and update quantity
        $(document).on('click', '.remove-btn', function() {
            var row = $(this).closest('.cart-item-card');
            var productId = row.data('product-id');

            removeCartItem(productId, row);

            function removeCartItem(productId, row) {
                $.ajax({
                    url: '{{ route("cart.remove") }}',
                    type: 'get',
                    data: {
                        productId: productId
                    },
                    success: function(response) {

                        if (response.hasOwnProperty('message')) {
                            Toast.fire({
                            icon: 'success',
                            title: response.message
                            });
                            row.remove();
                            updateTotalPrice();
                            updateCartItemCount(response.cartItemCount);
                            var emptyCart =response.cartItemCount
                            if (parseInt(emptyCart) === 0) {
                                $('#cartTotalSection').empty();
                            }

                        }

                    }
                });
            }

            function updateCartItemCount(count) {
                $('#cartItem').text(count);
            }
        });


        // update price
        function updateTotalPrice() {
            var total = 0;
            $('.total-amount').each(function() {
                var amountText = $(this).text();
                // strip out any currency symbols or letters, leaving just the number
                var amount = parseFloat(amountText.replace(/[^0-9.]/g, ''));
                if (!isNaN(amount)) {
                    total += amount;
                }
            });

            $('.total-product-price').text('{{$general->cur_sym}} ' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        }


    });


</script>

@endpush

