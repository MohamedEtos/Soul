@extends('store.layouts.master')
@section('head')
<style>
    .avatar-initials {
        width: 40px;
        height: 40px;
        background-color: #e6e6e6;
        color: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        margin-left: 10px; /* Space between avatar and name in RTL */
    }
    
    /* Option Selectors */
    .option-btn {
        min-width: 40px;
        height: 40px;
        border: 1px solid #e6e6e6;
        border-radius: 3px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px 5px 0;
        cursor: pointer;
        padding: 0 10px;
        transition: all 0.3s;
        font-size: 14px;
        color: #666;
    }
    .option-btn:hover {
        border-color: #333;
    }
    .option-btn.active {
        border-color: #333;
        background-color: #333;
        color: #fff;
    }
    .option-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #f5f5f5;
        text-decoration: line-through;
    }

    .color-option {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin: 0 8px 8px 0;
        cursor: pointer;
        border: 2px solid transparent;
        box-shadow: 0 0 0 1px #e6e6e6; /* Inner border for white colors */
        transition: all 0.2s;
        display: inline-block;
    }
    .color-option.active {
        box-shadow: 0 0 0 2px #fff, 0 0 0 4px #333; /* Ring effect */
        transform: scale(1.1);
    }
</style>
    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:description" content="{{ $product->productDetalis }}" />
    <meta property="og:image" content="{{ asset($product->product_img_p->mainImage) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="product" />
@endsection

@section('content')


	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60 m-t-40  " >
		<div class="container">
			<div class="row   ">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
								<div class="item-slick3" data-thumb="{{ asset($product->product_img_p->mainImage) }}">
									<div class="wrap-pic-w pos-relative">
										<img src="{{ asset($product->product_img_p->mainImage) }}" alt="{{ $product->name }}">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset($product->product_img_p->mainImage) }}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="{{ asset($product->product_img_p->img2) }}">
									<div class="wrap-pic-w pos-relative">
										<img src="{{ asset($product->product_img_p->img2) }}" alt="{{ $product->name }}">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset($product->product_img_p->img2) }}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="{{ asset($product->product_img_p->img3) }}">
									<div class="wrap-pic-w pos-relative">
										<img src="{{ asset($product->product_img_p->img3) }}" alt="{{ $product->name }}">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset($product->product_img_p->img3) }}">
											<i class="fa fa-expand"></i>
										</a>
									</div>

								</div>
								<div class="item-slick3" data-thumb="{{ asset($product->product_img_p->img4) }}">
									<div class="wrap-pic-w pos-relative">
										<img src="{{ asset($product->product_img_p->img4) }}" alt="{{ $product->name }}">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset($product->product_img_p->img4) }}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

                                @if($product->product_img_p->img5)
                                <div class="item-slick3" data-thumb="{{ asset($product->product_img_p->img5) }}">
									<div class="wrap-pic-w pos-relative">
										<img src="{{ asset($product->product_img_p->img5) }}" alt="{{ $product->name }}">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset($product->product_img_p->img5) }}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
                                @endif

                                @if($product->product_img_p->img6)
                                <div class="item-slick3" data-thumb="{{ asset($product->product_img_p->img6) }}">
									<div class="wrap-pic-w pos-relative">
										<img src="{{ asset($product->product_img_p->img6) }}" alt="{{ $product->name }}">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset($product->product_img_p->img6) }}">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
                                @endif
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-5 p-b-30" dir="rtl">
					<div class="p-r-50 p-t-5 p-lr-0-lg h4">
							{{ $product->name }} <span style="{{ $product->stock > 0 ? 'color:green' : 'color:red' }}">({{ $product->stock > 0 ? 'متوفر' : 'غير متوفر' }})</span>
                        </h1>

                        <div class="flex-w flex-m   p-t-10">
                            <span class="fs-18 cl11 m-r-10">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= round($product->average_rating))
                                        <i class="zmdi zmdi-star"></i>
                                    @else
                                        <i class="zmdi zmdi-star-outline"></i>
                                    @endif
                                @endfor
                            </span>
                            <span class="stext-102 cl3">
                                ({{ $product->approved_reviews_count }} تقيمات)
                            </span>
                        </div>




						<span class="mtext-106  cl2">
							{{ $product->price }} ج.م
						</span>

						<p class="stext-102 cl3 p-t-23">
							{{ $product->productDetalis }}
						</p>

						<!--  -->
						<div class="p-t-10">
							<div class="flex-w  p-b-10 p-l-10">
								<div class="size-203  flex-c-m respon6">
									المقاس
								</div>

								<div class="size-204 p-r-10 respon6-next">
                                    <div class="flex-w p-t-4 p-b-10">
                                        @if($product->sizes->count() > 0)
                                            @foreach($product->sizes as $size)
                                                <div class="option-btn size-option {{ $size->stock <= 0 ? 'disabled' : '' }}" 
                                                     data-value="{{ $size->size }}" 
                                                     data-stock="{{ $size->stock }}">
                                                    {{ $size->size }}
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="option-btn active" data-value="{{$product->width}} * {{$product->height}}">
                                                '-'
                                            </div>
                                        @endif
                                        <input type="hidden" name="size" id="selected-size" value="{{ $product->sizes->count() == 0 ? $product->width.' * '.$product->height : '' }}">
                                    </div>
								</div>
							</div>

                            @if($product->colors->count() > 0)
                            <div class="flex-w  p-b-10 p-t-10">
                                <div class="size-203 flex-c-m respon6">
                                    اللون
                                </div>

                                <div class="size-204 respon6-next">
                                    <div class="flex-w p-t-4">
                                        @foreach($product->colors as $color)
                                            <div class="color-option {{ $color->stock <= 0 ? 'disabled' : '' }}" 
                                                 data-value="{{ $color->color }}"
                                                 data-stock="{{ $color->stock }}"
                                                 style="background-color: {{ $color->color_code }};"
                                                 title="{{ $color->color }}">
                                            </div>
                                        @endforeach
                                        <input type="hidden" name="color" id="selected-color">
                                    </div>
                                </div>
                            </div>
                            @endif

							<div class="flex-w  p-b-10">
								<div class="size-204 flex-w flex-m respon6-next">
									<div class="wrap-num-product flex-w m-r-20 m-tb-10">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>
                                            <input class="mtext-104 cl3 txt-center qty qty_product num-product "
                                             type="number" name="num-product" value="1"
                                             >

										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>

									<button data-product-id="{{ $product->id }}"  class="flex-c-m stext-101 cl0 size-101 bg1 mr-3 bor1  p-lr-15 trans-04 {{ $product->stock > 0 ? 'js-addcart-detail hov-btn1 ': 'bg2 hov-btn50' }}">
										اضف  الي السله
									</button>
								</div>
							</div>
						</div>

						<!--  -->
                    <div class="flex-w h5 flex-m p-l-100 p-t-20 respon7">
                        شارك المنتج مع اصدقائك
                    </div>
						<div class="flex-w flex-m p-l-100 p-t-20 respon7">

							<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"   target="_blank"  data-tooltip="facebook" aria-label="Visit our Facebook page" class="fs-35 mr-3 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2  tooltip100">
                                <span class="sr-only">facebook</span>
                                <i class="fa fa-facebook"></i>
							</a>

							<a href="https://www.instagram.com/" target="_blank" data-tooltip="instagram" aria-label="Visit our Instagram page" class="fs-35 mr-3 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 tooltip100">
                                <span class="sr-only">instagram</span>
                                <i class="fa fa-instagram"></i>
							</a>

							<a href="https://wa.me/201554063260" data-tooltip="whatsapp" aria-label="Visit our whatsapp " class="fs-35 mr-3 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2  tooltip100">
                                <span class="sr-only">whatsapp</span>
                                <i class="fa fa-whatsapp"></i>
							</a>


						</div>
					</div>
				</div>
			</div>

			<div class="bor10 m-t-50 p-t-43 p-b-40">
				<!-- Tab01 -->
				<div class="tab01 " dir="rtl">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item p-b-10">
							<a class="nav-link active" data-toggle="tab" href="#description" role="tab">الوصف</a>
						</li>

						<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#information" role="tab">تفاصيل</a>
						</li>

						<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#reviews" role="tab">التقيم ({{ $product->approved_reviews_count }})</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content p-t-43">
						<!-- - -->
						<div class="tab-pane fade show active" id="description" role="tabpanel">
							<div class="how-pos2 p-lr-15-md">
								<p class="stext-102 cl6">
									{{ $product->productDetalis }}
								</p>
							</div>
						</div>

						<!-- - -->
						<div class="tab-pane fade" id="information" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<ul class="p-lr-28 p-lr-15-sm">
										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												القسم
											</span>

											<span class="stext-102 cl6 size-206">
												{{ $product->Category->name }}
											</span>
										</li>

                                        <li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Brand
											</span>

											<span class="stext-102 cl6 size-206">
												lunablu
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												المقاس
											</span>

											<span class="stext-102 cl6 size-206">
												{{ $product->sizes->pluck('name')->implode(', ') }}
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												الخامه
											</span>

											<span class="stext-102 cl6 size-206">
												{{ $product->fabricType->name }}
											</span>
										</li>




									</ul>
								</div>
							</div>
						</div>

						<!-- - -->
						<div class="tab-pane fade" id="reviews" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<div class="p-b-30 m-lr-15-sm" id="reviews-list">
										<!-- Review -->
                                    <div id="reviews-list-container">
                                        @foreach($product->reviews->where('is_approved', 1)->all() as $review)
										<div class="flex-w flex-t p-b-68">

											<div class="size-207">
												<div class="flex-w flex-sb-m p-b-17">
                                                    <div class="flex-w flex-m">
                                                        <div class="avatar-initials">
                                                            {{ mb_strtoupper(mb_substr($review->name, 0, 1)) }} {{ mb_strtoupper(mb_substr($review->name, 1, 1)) }}
                                                        </div>
                                                        <span class="mtext-107 cl2 p-r-20">
                                                            {{ $review->name }}
                                                        </span>
                                                    </div>

													<span class="fs-18 cl11">
                                                        @for($i=1; $i<=5; $i++)
                                                            @if($i <= $review->rating)
														        <i class="zmdi zmdi-star"></i>
                                                            @else
                                                                <i class="zmdi zmdi-star-outline"></i>
                                                            @endif
                                                        @endfor
													</span>
												</div>

												<p class="stext-102 cl6">
													{{ $review->comment }}
												</p>
											</div>
										</div>
                                        @endforeach
                                    </div>

										<!-- Add review -->
                                        @if(session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif

										<form class="w-full" id="review-form" action="{{ route('review.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
											<h5 class="mtext-108 cl2 p-b-7">
												أضف تقييمك
											</h5>

											<p class="stext-102 cl6">
												لن يتم نشر رقم هاتفك. الحقول المطلوبة مشار إليها بـ *
											</p>

											<div class="flex-w flex-m p-t-50 p-b-23 ">
												<span class="stext-130 cl3 m-r-16">
													تقييمك
												</span>

												<span class="wrap-rating fs-18 cl11 pointer">
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<input class="dis-none" type="number" name="rating" required>
												</span>
											</div>

											<div class="row p-b-25">
												<div class="col-12 p-b-5">
													<label class="stext-102 cl3" for="review">مراجعتك</label>
													<textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="comment" required></textarea>
												</div>

												<div class="col-sm-6 p-b-5">
													<label class="stext-102 cl3" for="name">الاسم</label>
													<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
												</div>

												<div class="col-sm-6 p-b-5">
													<label class="stext-102 cl3" for="phone">رقم الهاتف</label>
													<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="phone" type="text" name="phone" required>
												</div>
											</div>

											<button type="submit" class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
												إرسال
											</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
			<span class="stext-107 cl6 p-lr-25">
				الخامه :{{ $product->fabricType->name }}
			</span>

			<span class="stext-107 cl6 p-lr-25">
				 {{ $product->name  }}
			</span>
		</div>
	</section>


	<!-- Related Products -->
	<section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<div class="p-b-45">
				<h3 class="ltext-106 cl5 txt-center">
					منتجات ذات صلة
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
                <div class="slick2">
                    @foreach($products as $product)
                        <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                            <!-- Block2 -->
                            <a href="{{ route('product.show', $product->slug) }}">

                                <div class="block2">
                                    <div class="block2-pic hov-img0">
                                            @php
                                                $mainImg = $product->product_img_p->mainImage;
                                                $isResponsive = Str::endsWith($mainImg, '-800.webp');
                                                $baseImg = $isResponsive ? Str::beforeLast($mainImg, '-') : null;
                                            @endphp

                                            <img
                                                loading="lazy"
                                                src="{{ asset($mainImg) }}"
                                                @if($isResponsive)
                                                srcset="
                                                    {{ asset($baseImg . '-320.webp') }} 320w,
                                                    {{ asset($baseImg . '-480.webp') }} 480w,
                                                    {{ asset($baseImg . '-800.webp') }} 800w,
                                                    {{ asset($baseImg . '-1200.webp') }} 1200w
                                                "
                                                sizes="(max-width: 600px) 45vw,
                                                    (max-width: 1200px) 25vw,
                                                    300px"
                                                @endif
                                                alt="{{ $product->product_img_p->alt1 ?? $product->name }}"
                                                decoding="async"
                                            >

                                        <a href="{{ route('product.show', $product->slug) }}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 ">
                                            نظره سريعة
                                        </a>
                                    </div>

                                    <div class="block2-txt flex-w flex-t p-t-14">
                                        <div class="block2-txt-child1 flex-col-l ">
                                            <a href="" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        {{ $product->name }}
                                            </a>

                                            <span class="stext-105 cl3 unit_price" >
                                                {{ $product->price }}
                                            </span>
                                        </div>

                                        <div class="block2-txt-child2 flex-r p-t-3">
                                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                <img class="icon-heart1 dis-block trans-04" src="{{ asset('store/images/icons/icon-heart-01.png') }}" alt="ICON">
                                                <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('store/images/icons/icon-heart-02.png') }}" alt="ICON">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
			</div>
		</div>
	</section>

    {{-- <button onclick="shareProduct()">Share</button> --}}




@endsection

@section('script')
<script>
    (function ($) {
    "use strict";
        var headerDesktop = $('.container-menu-desktop');
        $(headerDesktop).addClass('fix-menu-desktop');
    })(jQuery);

        /*==================================================================
    [ +/- num product ]*/
     $('.btn-num-product-down').on('click', function(){
         var numProduct = Number($(this).next().val());
         if(numProduct > 0) $(this).next().val(numProduct - 1);
     });

     $('.btn-num-product-up').on('click', function(){
         var numProduct = Number($(this).prev().val());
         $(this).prev().val(numProduct + 1);
     });

    // Size Selection
    $(document).ready(function() {
        // Auto-select size if only one option exists
        var availableSizes = $('.size-option').not('.disabled');
        if (availableSizes.length === 1) {
            availableSizes.addClass('active');
            $('#selected-size').val(availableSizes.data('value'));
        }

        // Auto-select color if only one option exists
        var availableColors = $('.color-option').not('.disabled');
        if (availableColors.length === 1) {
            availableColors.addClass('active');
            $('#selected-color').val(availableColors.data('value'));
        }

        $('.size-option').on('click', function() {
            if($(this).hasClass('disabled')) return;
            
            $('.size-option').removeClass('active');
            $(this).addClass('active');
            $('#selected-size').val($(this).data('value'));
        });

        // Color Selection
        $('.color-option').on('click', function() {
            if($(this).hasClass('disabled')) return;
            
            $('.color-option').removeClass('active');
            $(this).addClass('active');
            $('#selected-color').val($(this).data('value'));
        });
    });

    // Add to cart AJAX
    $('.js-addcart-detail').on('click', function(e){
        e.preventDefault();
        var button = $(this);
        var productId = button.data('product-id');
        var qty = $('input[name="num-product"]').val();
        var size = $('#selected-size').val();
        var color = $('#selected-color').val();

        // Validation
        if ($('.size-option').length > 0 && !size) {
             swal("تنبيه", "يرجى اختيار المقاس أولاً", "warning");
             return;
        }

        if ($('.color-option').length > 0 && !color) {
             swal("تنبيه", "يرجى اختيار اللون أولاً", "warning");
             return;
        }

        $.ajax({
            url: "{{ route('cart.add') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                qty: qty,
                size: size,
                color: color
            },
            success: function(response){
                if(response.success === false) {
                     swal("تنبيه", response.message, "warning");
                } else {
                    swal("تمت الاضافة", "تم اضافة المنتج للسلة بنجاح", "success");
                    
                    // Update cart count
                    if(response.cart && response.cart.count !== undefined) {
                         $('.icon-header-noti').attr('data-notify', response.cart.count);
                    } else if(response.cart_count) {
                         $('.icon-header-noti').attr('data-notify', response.cart_count);
                    }

                    // Refresh Side Cart
                    if(typeof refreshSideCart === 'function') {
                        refreshSideCart();
                    }
                    
                    // Open the cart panel
                    $('.js-panel-cart').addClass('show-header-cart');
                }
            },
            error: function(xhr){
                swal("خطأ", "حدث خطأ أثناء الإضافة للسلة", "error");
            }
        });
    });

    $('#review-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var originalBtnText = submitBtn.text();

        submitBtn.prop('disabled', true).text('جاري الإرسال...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    swal("تم بنجاح", response.message, "success");
                    form[0].reset();
                    // update rating stars visual reset
                    $('.item-rating').removeClass('zmdi-star').addClass('zmdi-star-outline');

                    // Allow user to see the change instantly
                    var review = response.review;
                    var parsedRating = parseInt(review.rating);
                    var starsHtml = '';

                    for(var i=1; i<=5; i++) {
                        if(i <= parsedRating) {
                            starsHtml += '<i class="zmdi zmdi-star"></i>';
                        } else {
                            starsHtml += '<i class="zmdi zmdi-star-outline"></i>';
                        }
                    }

                    // Generate initials
                    var name = review.name;
                    var initials = '';
                    if (name.length >= 1) initials += name.charAt(0).toUpperCase();
                    if (name.length >= 2) initials += ' ' + name.charAt(1).toUpperCase();

                    var reviewHtml = `
                    <div class="flex-w flex-t p-b-68">
                        <div class="size-207">
                            <div class="flex-w flex-sb-m p-b-17">
                                <div class="flex-w flex-m">
                                    <div class="avatar-initials">
                                        ${initials}
                                    </div>
                                    <span class="mtext-107 cl2 p-r-20">
                                        ${review.name}
                                    </span>
                                </div>
                                <span class="fs-18 cl11">
                                    ${starsHtml}
                                </span>
                            </div>
                            <p class="stext-102 cl6">
                                ${review.comment}
                            </p>
                        </div>
                    </div>`;

                    $('#reviews-list-container').prepend(reviewHtml);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                if(errors) {
                     $.each(errors, function(key, value) {
                         errorMessage += value[0] + '\n';
                     });
                } else {
                    errorMessage = 'حدث خطأ ما';
                }
                swal("خطأ", errorMessage, "error");
            },
            complete: function() {
                submitBtn.prop('disabled', false).text(originalBtnText);
            }
        });
    });

</script>




@endsection
