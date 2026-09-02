@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $validImages = [];
    if (!empty($productImages)) {
        foreach($productImages as $img) {
            try {
                if (isset($img->id)) {
                    $mediaModel = \Illuminate\Support\Facades\DB::table('media')->where('id', $img->id)->first();
                    if ($mediaModel) {
                        $validImages[] = getCloudinaryOrLocalUrl($mediaModel);
                    }
                }
            } catch (\Exception $e) {
                // Ignore
            }
        }
    }
    if (empty($validImages)) {
        $validImages[] = getImage('');
    }
@endphp

<!-- ==================== Our Products Start Here ==================== -->
<section class="ecommerce-products single-shop pt-5 pb-5" style="background: #f8fafc;">
    <div class="container">
        <div class="row g-4 align-items-start">
            <!-- Left: Product Image Gallery -->
            <div class="col-lg-6">
                <div style="background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.04); padding: 24px;">
                    <div class="tab-content mb-3" id="myTabContent">
                        @foreach($validImages as $index => $imgUrl)
                        <div class="tab-pane fade{{ $index === 0 ? ' show active' : '' }}" id="tab-pane-{{ $index }}" role="tabpanel" aria-labelledby="tab-{{ $index }}" tabindex="0">
                            <div style="position: relative; display: flex; align-items: center; justify-content: center; min-height: 380px; background: #f8fafc; border-radius: 18px; padding: 20px; overflow: hidden;">
                                <a class="image-popup" href="{{ $imgUrl }}" style="position: absolute; top: 16px; right: 16px; width: 38px; height: 38px; border-radius: 10px; background: #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.1); color: #0f172a; text-decoration: none;">
                                    <i class="fas fa-expand"></i>
                                </a>
                                <img src="{{ $imgUrl }}" alt="{{ $product->name }}" style="max-height: 340px; max-width: 100%; object-fit: contain; display: block;">
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if(count($validImages) > 1)
                    <div class="product-details-left__nav">
                        <ul class="nav nav-tabs gap-2 border-0 justify-content-center" id="myTab" role="tablist">
                            @foreach($validImages as $index => $imgUrl)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link p-1 border rounded-3 {{ $index === 0 ? ' active' : '' }}" id="tab-{{ $index }}" data-bs-toggle="tab" data-bs-target="#tab-pane-{{ $index }}" type="button" role="tab" style="width: 65px; height: 65px; background: #f8fafc;">
                                    <img src="{{ $imgUrl }}" alt="thumb" style="width: 100%; height: 100%; object-fit: contain;">
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right: Product Details -->
            <div class="col-lg-6">
                <div style="background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.04); padding: 32px;">
                    <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 12px; line-height: 1.3;">{{ __($product->name) }}</h2>
                    
                    <div class="d-flex align-items-center flex-wrap gap-3 mb-3 pb-3" style="border-bottom: 1px solid #f1f5f9;">
                        @if($product->quantity > 0)
                        <span style="background: #dcfce7; color: #15803d; font-size: 13px; font-weight: 700; padding: 4px 12px; border-radius: 8px;">
                            <i class="las la-check-circle me-1"></i> @lang('In Stock') ({{ __($product->quantity) }})
                        </span>
                        @else
                        <span style="background: #fee2e2; color: #b91c1c; font-size: 13px; font-weight: 700; padding: 4px 12px; border-radius: 8px;">
                            <i class="las la-times-circle me-1"></i> @lang('Out of Stock')
                        </span>
                        @endif

                        <div class="d-flex align-items-center">
                            <ul class="rating-list d-flex align-items-center mb-0 ps-0" style="list-style: none; color: #f59e0b; font-size: 14px;">
                                @php
                                    $averageRatingHtml = calculateAverageRating(0);
                                    echo $averageRatingHtml['ratingHtml'];
                                @endphp
                            </ul>
                            <span class="ms-2 text-muted" style="font-size: 13px; font-weight: 600;">({{ __( $product->review_count ?? 0 ) }} reviews)</span>
                        </div>
                    </div>

                    @if($product->short_desc)
                    <p style="color: #475569; font-size: 15px; line-height: 1.7; margin-bottom: 20px;">
                        {{ __($product->short_desc) }}
                    </p>
                    @endif

                    <div class="mb-4">
                        @if(isset($product->discount) && $product->discount > 0)
                        <div class="d-flex align-items-center gap-3">
                            <span style="font-size: 32px; font-weight: 800; color: #2563eb;">{{ $general->cur_sym }}{{ showAmount(($product->price) - ($product->price * $product->discount/100 )) }}</span>
                            <span style="font-size: 20px; font-weight: 600; color: #94a3b8; text-decoration: line-through;">{{ $general->cur_sym }}{{ showAmount($product->price) }}</span>
                            <span style="background: #fee2e2; color: #ef4444; font-size: 13px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">-{{ $product->discount }}% OFF</span>
                        </div>
                        @else
                        <span style="font-size: 32px; font-weight: 800; color: #2563eb;">{{ $general->cur_sym }}{{ showAmount($product->price) }}</span>
                        @endif
                    </div>

                    <!-- Quantity & Action Buttons -->
                    <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
                        <div class="quantity_box" style="display: inline-flex; align-items: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 4px;">
                            <button type="button" class="sub btn btn-sm" style="width: 36px; height: 36px; border: none; background: transparent; color: #0f172a; font-size: 14px;"><i class="fa fa-minus"></i></button>
                            <input type="number" id="quantityInput" value="1" min="1" max="{{ $product->quantity }}" readonly style="width: 45px; text-align: center; border: none; background: transparent; font-weight: 800; color: #0f172a; font-size: 16px;">
                            <button type="button" class="add btn btn-sm" style="width: 36px; height: 36px; border: none; background: transparent; color: #0f172a; font-size: 14px;"><i class="fa fa-plus"></i></button>
                        </div>

                        <button class="btn btn-primary addToCart" data-id="{{$product->id}}" data-quantity="1" style="background: #2563eb; color: #fff; border: none; border-radius: 12px; font-weight: 700; padding: 12px 24px; box-shadow: 0 4px 14px rgba(37,99,235,0.35); display: inline-flex; align-items: center;">
                            <i class="fas fa-cart-plus me-2"></i> @lang('Add To Cart')
                        </button>

                        <button class="btn btn-dark buyNow" data-id="{{$product->id}}" style="background: #0f172a; color: #fff; border: none; border-radius: 12px; font-weight: 700; padding: 12px 24px; display: inline-flex; align-items: center;">
                            <i class="fas fa-bolt me-2"></i> @lang('Buy Now')
                        </button>
                    </div>

                    <!-- Shipping -->
                    @if(!empty($shippings) && count($shippings) > 0)
                    <div class="mb-4">
                        <label class="form-label" style="font-size: 13.5px; font-weight: 700; color: #334155;">@lang('Shipping Options')</label>
                        <select class="form-select form-control shipping-form" name="shipping" required style="border-radius: 10px; border-color: #cbd5e1; font-size: 14px; padding: 10px 14px;">
                            @foreach($shippings as $item)
                               <option value="{{$item->id}}">{{ __($item->name) }} - @lang('within') {{__($item->day)}} @lang('days')</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <!-- Social Share -->
                    <div class="d-flex align-items-center gap-2 mb-4 pt-3" style="border-top: 1px solid #f1f5f9;">
                        <span style="font-size: 13.5px; font-weight: 700; color: #475569;">@lang('Share This'):</span>
                        <div class="d-flex gap-2">
                            <a href="<?php echo getProductShareLinks($product->id)['facebook']; ?>" target="_blank" style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 13px;"><i class="fab fa-facebook-f"></i></a>
                            <a href="<?php echo getProductShareLinks($product->id)['twitter']; ?>" target="_blank" style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #0284c7; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 13px;"><i class="fab fa-twitter"></i></a>
                            <a href="<?php echo getProductShareLinks($product->id)['linkedin']; ?>" target="_blank" style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #0369a1; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 13px;"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <!-- Payment Safe Checkout Badge -->
                    <div style="background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                        <span style="font-size: 12.5px; font-weight: 700; color: #475569;">
                            <i class="las la-shield-alt text-success me-1"></i> @lang('Guaranteed Safe Checkout')
                        </span>
                        <div style="font-size: 20px; color: #64748b; display: flex; gap: 12px;">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <i class="fab fa-cc-stripe"></i>
                            <i class="fab fa-cc-paypal"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Our Products End Here ==================== -->

<!-- ==================== Product Details & Reviews Tabs ==================== -->
<section class="pb-5" style="background: #f8fafc;">
    <div class="container">
        <div style="background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.04); padding: 32px;">
            <ul class="nav nav-pills gap-2 mb-4 pb-3" id="productTab" role="tablist" style="border-bottom: 2px solid #f1f5f9;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold px-4 py-2" id="desc-tab" data-bs-toggle="pill" data-bs-target="#description-pane" type="button" role="tab" style="border-radius: 10px;">
                        <i class="las la-align-left me-1"></i> @lang('Description')
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-4 py-2" id="rev-tab" data-bs-toggle="pill" data-bs-target="#reviews-pane" type="button" role="tab" style="border-radius: 10px;">
                        <i class="las la-star me-1"></i> @lang('Customer Reviews') ({{ count($reviews) }})
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="productTabContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description-pane" role="tabpanel">
                    <div style="color: #334155; font-size: 15px; line-height: 1.8;">
                        @if($product->description)
                            {!! $product->description !!}
                        @elseif($product->short_desc)
                            <p>{{ $product->short_desc }}</p>
                        @else
                            <p class="text-muted">@lang('No additional description provided for this product.')</p>
                        @endif
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews-pane" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 20px;">@lang('Customer Feedback')</h5>
                            <div class="review-list">
                                @forelse($reviews as $item)
                                <div class="p-3 mb-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="mb-0" style="font-weight: 700; color: #0f172a;">{{ @$item->user->username ?? 'Customer' }}</h6>
                                        <span class="text-muted" style="font-size: 12px;">{{ diffForHumans($item->created_at) }}</span>
                                    </div>
                                    <p class="mb-0" style="color: #475569; font-size: 14px;">{{ __($item->message) }}</p>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <i class="las la-comment-alt text-muted" style="font-size: 40px;"></i>
                                    <p class="text-muted mt-2">@lang('No reviews yet. Be the first to review this product!')</p>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="p-4 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 6px;">@lang('Write a Review')</h5>
                                <p class="text-muted mb-3" style="font-size: 13.5px;">@lang('Share your experience with other pet owners.')</p>

                                <form action="{{ route('user.reviews.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #334155; font-size: 13.5px;">@lang('Your Message')</label>
                                        <textarea class="form-control" name="message" rows="3" placeholder="@lang('Write your review here...')" required style="border-radius: 10px; border-color: #cbd5e1;"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #334155; font-size: 13.5px;">@lang('Rating')</label>
                                        <div class="rating-stars" style="color: #f59e0b; font-size: 20px; cursor: pointer;">
                                            <input type="hidden" name="rating" id="rating" value="5">
                                            <i class="fas fa-star" data-rating="1"></i>
                                            <i class="fas fa-star" data-rating="2"></i>
                                            <i class="fas fa-star" data-rating="3"></i>
                                            <i class="fas fa-star" data-rating="4"></i>
                                            <i class="fas fa-star" data-rating="5"></i>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary px-4 py-2" style="background: #2563eb; border: none; border-radius: 10px; font-weight: 700;">
                                        @lang('Submit Review')
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@push('script')
<script>
    "use strict"
    $(document).ready(function() {

        // sub quantity
        $('.sub').on('click', function() {
                var quantityInput = $('#quantityInput');
                var quantity = parseInt(quantityInput.val());
                if (quantity > 1) {
                    quantityInput.val(quantity - 1);
                }
        });

        // add quantity
        $('.add').on('click', function() {
                var quantityInput = $('#quantityInput');
                var quantity = parseInt(quantityInput.val()) || 1;
                var max = parseInt(quantityInput.attr('max')) || 1;
                if (quantity < max) {
                    quantityInput.val(quantity + 1);
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Maximum stock reached'
                    });
                }
        });

        // validate manual typing just in case readonly is bypassed
        $('#quantityInput').on('input', function() {
            var max = parseInt($(this).attr('max')) || 1;
            var val = parseInt($(this).val()) || 1;
            if (val > max) {
                $(this).val(max);
                Toast.fire({
                    icon: 'warning',
                    title: 'Maximum stock reached'
                });
            }
        });

        // add to cart
        $(document).on('click', '.addToCart', function() {
            var productId = $(this).data('id');
            var quantity = $('#quantityInput').val();


            $.ajax({
            url: '{{ route("cart.add") }}',
            type: 'get',
            data: {
                product_id: productId,
                quantity: quantity,
            },
            success: function(response) {
                if (response.hasOwnProperty('message')) {
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
                updateCartItemCount(response.cartItemCount);
                }
            },
            error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errorMessage = xhr.responseJSON.error;
                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        } else {
                            var errorMessage = 'Error occurred while adding the product to cart.';
                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        }
                    }
            });
        });

        function updateCartItemCount(count) {
            $('#cartItem').text(count);
        }
        // end add to cart


        // buy now add product
        $(document).on('click', '.buyNow', function() {
            var productId = $(this).data('id');
            var quantity = 1;

            $.ajax({
                url: '{{ route("cart.add") }}',
                type: 'get',
                data: {
                    product_id: productId,
                    quantity: quantity,
                },
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        updateCartItemCount(response.cartItemCount);
                    }

                    // redirect checkout page
                    window.location.href = '{{ route("get.checkout") }}';
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errorMessage = xhr.responseJSON.error;
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    } else {
                        var errorMessage = 'Error occurred while adding the product to cart.';
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                }
            });
        });
        // end buy now add product


        // rating set
        $(document).ready(function() {
            $('.rating-stars i').on('click', function() {
                var rating = parseInt($(this).data('rating'));
                $('#rating').val(rating);
                updateStars(rating);
            });

            $('#rating').on('input', function() {
                var rating = $(this).val();
                updateStars(rating);
            });


            function updateStars(rating) {
                var stars = $('.rating-stars i');
                stars.removeClass('fas').addClass('far');
                stars.each(function(index) {
                    if (index < rating) {
                        $(this).removeClass('far').addClass('fas');
                    }
                });
            }

            var initialRating = parseInt($('#rating').val());
            if (initialRating > 0) {
                updateStars(initialRating);
            }

        });
        // end rating set

    });
</script>
@endpush

