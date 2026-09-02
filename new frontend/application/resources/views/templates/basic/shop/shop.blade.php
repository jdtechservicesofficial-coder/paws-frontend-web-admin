@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <!-- ==================== Our Products Start Here ==================== -->
    <section class="ecommerce-products single-shop ptb-120 mb-3">
        <img src="{{asset($activeTemplateTrue.'images/service-bg.png')}}" alt="shape" class="single-shop-bg">
        <div class="container-fluid px-sm-5">
            
            <!-- Horizontal Filters Section -->
            <div class="shop-top-filters-area mb-5">
                
                <!-- Categories Horizontal Slider -->
                <div class="categories-horizontal-slider mb-4" style="min-width: 0;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="m-0" style="font-size: 18px; font-weight: 700; color: #0052cc;">@lang('Categories')</h4>
                    </div>
                    <div class="native-category-scroll">
                        <div class="d-flex" style="gap: 15px; overflow-x: auto; padding-bottom: 15px; -webkit-overflow-scrolling: touch;">
                            <style>
                                .category-pill-span {
                                    display: inline-block;
                                    padding: 8px 16px;
                                    background-color: #f1f5f9;
                                    color: #475569;
                                    border-radius: 20px;
                                    font-size: 14px;
                                    font-weight: 600;
                                    transition: all 0.2s;
                                }
                                .filter-by-category:checked + .category-pill-span {
                                    background-color: #0052cc !important;
                                    color: #ffffff !important;
                                    box-shadow: 0 4px 10px rgba(0, 82, 204, 0.3);
                                }
                            </style>
                            @foreach($categories as $item)
                                <div style="flex-shrink: 0;">
                                    <label class="category-pill-label m-0" style="cursor: pointer;">
                                        <input class="form-check-input filter-by-category d-none" name="categories" type="checkbox" value="{{$item->id}}" id="chekbox-{{$loop->index}}">
                                        <span class="category-pill-span">{{$item->name}}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Search and Price Filter -->
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="search-box">
                            <input type="text" id="searchValue" class="form-control form--control" placeholder="@lang('Search for a product...')" value="{{ request('search') }}" style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="price-filter-box">
                            <h5 class="mb-3" style="font-size: 15px; font-weight: 600;">@lang('Price Range'): {{$general->cur_sym}}<span id="minTxt">{{ $minPrice }}</span> - {{$general->cur_sym}}<span id="maxTxt">{{ $maxPrice }}</span></h5>
                            <div class="advance_search_input" style="max-width: 100%;">
                                <div class="range-slider">
                                    <div id="p-range"></div>
                                    <input type="hidden" name="min" id="min" value="{{ $minPrice }}">
                                    <input type="hidden" name="max" id="max" value="{{ $maxPrice }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Products Grid -->
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-12 col-lg-12 main-content">
                    <div class="row gy-4">
                        @forelse($products as $product)
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6">
                            <div class="ecommerce-product">
                                <div class="ecommerce-product__thumb">
                                    @php
                                        $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Product\Models\Product')->where('model_id', $product->id)->first();
                                        $imageUrl = $media ? getCloudinaryOrLocalUrl($media) : getImage('');
                                    @endphp
                                    <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}">
                                        <img src="{{ $imageUrl }}" alt="product-image">
                                    </a>
                                    @if(!empty($product->discount) && $product->discount > 0)
                                    <div class="product-badge bg--danger">
                                        <p>{{$product->discount}}%</p>
                                    </div>
                                    @else
                                    <div class="product-badge bg--base">
                                        <p>@lang('New')</p>
                                    </div>
                                    @endif
                                    <div class="product-action-wrap">
                                        <ul>
                                            <li class="cart-btn">
                                                <button  class="flyingaddToCart" data-id="{{$product->id}}" data-quantity="1"  title="Add to Cart"><i class="fas fa-cart-plus"></i></button>
                                            </li>
                                            <li class="cart-btn">
                                                <button class="addToWishList" data-id="{{$product->id}}" title="Wishlist"><i class="fas fa-heart"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="ecommerce-product__content">
                                    <div class="review-wrap d-flex align-items-center mb-2">
                                        @php
                                        $averageRatingHtml = calculateAverageRating($product->average_rating);
                                            echo $averageRatingHtml['ratingHtml'];
                                        @endphp

                                        <p class="review-count">
                                            ({{__( $product->review_count)}})
                                        </p>
                                    </div>

                                    <h3 class="title">
                                        <a href="{{ route('product.details', ['slug' => slug($product->name), 'id' => $product->id])}}">
                                            @if(strlen(__($product->name)) >25)
                                            {{substr( __($product->name), 0,25).'...' }}
                                            @else
                                            {{__($product->name)}}
                                            @endif
                                        </a>
                                    </h3>
                                    <div class="price-wrap">
                                        @if(!empty($product->discount) && $product->discount > 0)
                                        <span class="product-price old">{{__($general->cur_sym)}}{{showAmount($product->price)}}</span>
                                        <span class="product-price new">{{ $general->cur_sym }}{{ showAmount(($product->price)- ($product->price * $product->discount/100 )) }}</span>
                                        @else
                                        <span class="product-price new">{{__($general->cur_sym)}}{{showAmount($product->price)}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center">{{__($emptyMessage)}}</p>
                        @endforelse

                    </div>

                    <div class="row mt-4">
                        @if ($products->hasPages())
                        <div class="col-md-12 d-flex justify-content-center">
                            {{ paginateLinks($products) }}
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Our Products End Here ==================== -->
@endsection

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


        // filter product

        $("#p-range").slider({
            range: true,
            min: {{ $minPrice }},
            max: {{ $maxPrice }},
            values: [{{ $minPrice }}, {{ $maxPrice }}],
            step: 1,
            slide: function (event, ui) {
                $("#min").val(ui.values[0]),
                $("#max").val(ui.values[1]);
                $("#minTxt").html(ui.values[0]),
                $("#maxTxt").html(ui.values[1]);
            },
            change:function(){
                triggerFilter();
            }
        });

        $("input[name='categories']").on('change', function(){
            triggerFilter();
        });

        $("#searchValue").on('keyup', function () {
            triggerFilter();
        });

        function triggerFilter() {
            var min = $('input[name="min"]').val();
            var max = $('input[name="max"]').val();
            var search = $('#searchValue').val();
            var categories = [];
            
            $('.filter-by-category:checked').each(function() {
                if(!categories.includes(parseInt($(this).val()))){
                    categories.push(parseInt($(this).val()));
                }
            });
            
            getFilteredData(min, max, categories, search);
        }

        function getFilteredData(min, max, categories, search){

            $.ajax({
                type: "get",
                url: "{{ route('product.filtered') }}",
                data:{
                    "min":min,
                    "max":max,
                    "categories": categories,
                    "search": search
                },
                dataType: "json",
                success: function (response) {
                    if(response.html){
                        $('.main-content .row.gy-4').html(response.html);
                    }

                    if(response.error){
                        notify('error', response.error);
                    }
                }
            });
        }
        // end filter product

    })(jQuery);
</script>
@endpush
