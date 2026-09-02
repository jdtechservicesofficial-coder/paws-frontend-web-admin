@php
$shop = getContent('shop.content', true);
$pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
$products = App\Models\Product::where('status', 1)->whereNull('deleted_at')->latest()->limit(4)->get();
@endphp

<!-- ==================== Our Products Start Here ==================== -->
<section class="ecommerce-products ptb-120" style="background: #0047b3;">

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 text-center mb-5">
                <div class="section-header mb-0">
                    <span class="section-sub-title" style="color: #fdcd01; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; font-size: 13px; display: inline-block; background: #eff6ff; padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;">{{ __($shop->data_values->heading ?? 'Featured Pet Supplies') }}</span>
                    <h2 class="section-title" style="font-weight: 800; color: #ffffff; font-size: 36px; line-height: 1.25; margin-bottom: 12px; letter-spacing: -0.5px;">{{ __($shop->data_values->subheading ?? 'Our Latest Collection') }}</h2>
                    <p style="color: #ffffff; font-size: 15px; line-height: 1.7; max-width: 600px; margin: 0 auto;">@php echo $shop->data_values->description @endphp</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape" class="section-header-shpae my-3" style="max-width: 80px;">
                </div>
            </div>
        </div>


        <div class="row gy-4 justify-content-center">
            @foreach ($products as $product)
            @php
            $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Product\Models\Product')->where('model_id', $product->id)->first();
            $imageUrl = $media ? getCloudinaryOrLocalUrl($media) : getImage('');
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="ecommerce-product" style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 6px 20px rgba(0,0,0,0.03); overflow: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); height: 100%; display: flex; flex-direction: column; justify-content: space-between;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 35px -10px rgba(37,99,235,0.12)'; this.style.borderColor='#93c5fd';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.03)'; this.style.borderColor='#e2e8f0';">
                    <div>
                        <div class="ecommerce-product__thumb" style="position: relative; background: #f8fafc; border-radius: 18px 18px 0 0; overflow: hidden; padding: 20px; text-align: center;">
                            <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}" style="display: flex; height: 180px; align-items: center; justify-content: center;">
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" style="max-height: 160px; max-width: 100%; object-fit: contain; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                            @if(!empty($product->discount) && $product->discount > 0)
                            <div class="product-badge bg--danger" style="position: absolute; top: 12px; left: 12px; border-radius: 6px; padding: 3px 8px; font-size: 11px; font-weight: 700;">
                                <p style="margin: 0; color: #fff;">{{$product->discount}}% OFF</p>
                            </div>
                            @endif
                            <div class="product-action-wrap">
                                <ul>
                                    <li class="cart-btn">
                                         <button class="flyingaddToCart" data-id="{{$product->id}}" data-quantity="1" title="Add to Cart" style="border-radius: 50%; width: 38px; height: 38px; background: #2563eb; color: #fff; border: none;"><i class="fas fa-cart-plus"></i></button>
                                    </li>
                                    <li class="cart-btn">
                                        <button class="addToWishList" data-id="{{$product->id}}" title="Wishlist" style="border-radius: 50%; width: 38px; height: 38px; background: #ffffff; color: #ef4444; border: 1px solid #e2e8f0;"><i class="fas fa-heart"></i></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="ecommerce-product__content" style="padding: 20px 18px;">
                            <div class="review-wrap d-flex align-items-center mb-2">
                                @php
                                   $averageRatingHtml = calculateAverageRating($product->average_rating);
                                    echo $averageRatingHtml['ratingHtml'];
                                @endphp
                                 <span class="review-count ms-2" style="font-size: 12px; color: #94a3b8; font-weight: 600;">
                                    ({{__( $product->review_count ?? 0)}})
                                </span>
                            </div>

                            <h3 class="title mb-2" style="font-size: 16px; font-weight: 800; line-height: 1.4;">
                                <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}" style="color: #0f172a; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#0f172a'">
                                    @if(strlen(__($product->name)) > 28)
                                    {{ substr(__($product->name), 0, 28).'...' }}
                                    @else
                                    {{ __($product->name) }}
                                    @endif
                                </a>
                            </h3>
                            <div class="price-wrap d-flex align-items-center gap-2">
                                @if(!empty($product->discount) && $product->discount > 0)
                                <span class="product-price old" style="text-decoration: line-through; color: #94a3b8; font-size: 13px; font-weight: 600; background: transparent; padding: 0;">{{__($general->cur_sym)}}{{showAmount($product->price)}}</span>
                                <span class="product-price new" style="color: #2563eb; font-weight: 800; font-size: 17px; background: transparent; padding: 0;">{{ $general->cur_sym }}{{ showAmount(($product->price) - ($product->price * $product->discount/100 )) }}</span>
                                @else
                                <span class="product-price new" style="color: #0f172a; font-weight: 800; font-size: 17px; background: transparent; padding: 0;">{{__($general->cur_sym)}}{{showAmount($product->price)}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mt-5">
            <div class="col-md-12 d-flex justify-content-center">
                <a href="{{route('shop')}}" class="btn btn--base" style="padding: 12px 36px; font-weight: 700; font-size: 15px; border-radius: 10px; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);">@lang('Explore All Products') <i class="las la-arrow-right ms-1"></i></a>
            </div>
        </div>

    </div>
</section>
<!-- ==================== Our Products End Here ==================== -->

@push('script')
<script>
      (function($){
        "use strict";


        // flying add to cart
        $(document).on('click', '.flyingaddToCart', function() {
            var productId = $(this).data('id');
            var quantity = $(this).data('quantity');

            var productImage = $(this).closest('.ecommerce-product__thumb').find('img');

            // any error face then flying animation off
            if (productImage.hasClass('out-of-stock')) {
                return;
            }

            // Get the position of the product image
            var imagePosition = productImage.offset();
            var imageClone = productImage.clone();

            // Append the cloned image to the body with absolute positioning
            imageClone.css({
                position: 'absolute',
                top: imagePosition.top,
                left: imagePosition.left,
                width: productImage.width(),
                height: productImage.height(),
                zIndex: 9999
            }).appendTo('body');

            // Animate the cloned image to the cart item position
            imageClone.animate({
                top: $('#cartItem').offset().top,
                left: $('#cartItem').offset().left,
                opacity: 0.3,
                width: 20,
                height: 20
            }, 1000, function() {
                // Remove the cloned image
                $(this).remove();
            });

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

                    // Remove the cloned image if there is an error
                    imageClone.remove();
                }
            });
        });

        function updateCartItemCount(count) {
            $('#cartItem').text(count);
        }
        // end flying add to cart


          // add to wishlist
          $(document).on('click', '.addToWishList', function() {
            var productId = $(this).data('id');
            $.ajax({
                url: '{{ route("wishlist.add") }}',
                type: 'get',
                data: {
                    product_id:productId,
                },
                success: function(response) {

                    if (response.hasOwnProperty('message')) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    updateWishListCount(response.wishlistCount);
                    }else{
                        Toast.fire({
                        icon: 'warning',
                        title: response.error
                    });
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = 'Error occurred while adding the product to wishlist.';
                    Toast.fire({
                    icon: 'error',
                    title: errorMessage
                    });
                }
            });
        });

        function updateWishListCount(count) {
            $('#wishlistItem').text(count);
        }
        // end wishlist

    })(jQuery);
</script>
@endpush


