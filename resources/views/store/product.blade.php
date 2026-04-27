@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/plugins/extensions/toastr.css') }}">
@endsection
@extends('store.layouts.master')
@section('content')


	<!-- Product -->
	<div class="bg0 m-t-150  p-b-140" dir="rtl">
		<div class="container">
			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
						مجموعتنا
					</button>

                    @foreach ($fabrics as $fabric )
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".{{ $fabric->name }}">
						{{ $fabric->name }}
					</button>
                    @endforeach
				</div>

				<div class="flex-w flex-c-m m-tb-10">
					<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
						<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
						<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						 Filter
					</div>

					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Search
					</div>
				</div>

				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>

                        <form method="GET" action="{{ route('product') }}" class="mb-4 w-100" >
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="ابحث عن منتج..."
                                class="mtext-107 cl2 size-114 plh2 p-r-15"
                            >
                        </form>
                    </div>
				</div>

				<!-- Filter -->
				<div class="dis-none panel-filter w-full p-t-10">
					<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
						<div class="filter-col1 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								ترتيب حسب
							</div>

							<ul>
								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['sort' => 'default'])) }}" class="filter-link stext-106 trans-04 {{ request('sort') == 'default' || !request('sort') ? 'filter-link-active' : '' }}">
										الإفتراضي
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['sort' => 'popularity'])) }}" class="filter-link stext-106 trans-04 {{ request('sort') == 'popularity' ? 'filter-link-active' : '' }}">
										الأكثر شهرة
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['sort' => 'rating'])) }}" class="filter-link stext-106 trans-04 {{ request('sort') == 'rating' ? 'filter-link-active' : '' }}">
										التقييم
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['sort' => 'newness'])) }}" class="filter-link stext-106 trans-04 {{ request('sort') == 'newness' ? 'filter-link-active' : '' }}">
										الأحدث
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['sort' => 'price_low'])) }}" class="filter-link stext-106 trans-04 {{ request('sort') == 'price_low' ? 'filter-link-active' : '' }}">
										السعر: من الأقل للأعلى
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['sort' => 'price_high'])) }}" class="filter-link stext-106 trans-04 {{ request('sort') == 'price_high' ? 'filter-link-active' : '' }}">
										السعر: من الأعلى للأقل
									</a>
								</li>
							</ul>
						</div>

						<div class="filter-col2 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								السعر
							</div>

							<ul>
								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->except(['min_price', 'max_price']))) }}" class="filter-link stext-106 trans-04 {{ !request('min_price') && !request('max_price') ? 'filter-link-active' : '' }}">
										الكل
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['min_price' => 0, 'max_price' => 50])) }}" class="filter-link stext-106 trans-04 {{ request('min_price') == 0 && request('max_price') == 50 ? 'filter-link-active' : '' }}">
										0.00 ج.م - 50.00 ج.م
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['min_price' => 50, 'max_price' => 100])) }}" class="filter-link stext-106 trans-04 {{ request('min_price') == 50 && request('max_price') == 100 ? 'filter-link-active' : '' }}">
										50.00 ج.م - 100.00 ج.م
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['min_price' => 100, 'max_price' => 150])) }}" class="filter-link stext-106 trans-04 {{ request('min_price') == 100 && request('max_price') == 150 ? 'filter-link-active' : '' }}">
										100.00 ج.م - 150.00 ج.م
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['min_price' => 150, 'max_price' => 200])) }}" class="filter-link stext-106 trans-04 {{ request('min_price') == 150 && request('max_price') == 200 ? 'filter-link-active' : '' }}">
										150.00 ج.م - 200.00 ج.م
									</a>
								</li>

								<li class="p-b-6">
									<a href="{{ route('product', array_merge(request()->query(), ['min_price' => 200])) }}" class="filter-link stext-106 trans-04 {{ request('min_price') == 200 && !request('max_price') ? 'filter-link-active' : '' }}">
										200.00+ ج.م
									</a>
								</li>
							</ul>
						</div>

						<div class="filter-col4 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								الوسوم
							</div>

							<div class="flex-w p-t-4 m-r--5">
								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									Fashion
								</a>

								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									Lifestyle
								</a>

								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									Denim
								</a>

								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									Streetstyle
								</a>

								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									Crafts
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

                <div class="row isotope-grid" id="products-wrapper">

                    @foreach ($products as $product)


                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $product->FabricType->name }}">
                            <!-- Block2 -->
                            <a href="{{ route('product.show', $product->slug) }}">
                                <div class="block2">
                                        <div class="block2-pic hov-img0 label-new" data-label="New" style="position: relative; min-height: 300px; background-color: #f0f0f0;">
                                            <!-- Skeleton Overlay (Hidden when loaded via JS) -->
                                            <div class="skeleton-overlay skeleton" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></div>
                                            
                                            @php
                                                $mainImg = $product->product_img_p->mainImage;
                                                // Check if the image follows the responsive pattern (ends with -800.webp)
                                                // We use Str::contains to be safe, assuming our generated images always have this suffix.
                                                $isResponsive = Str::endsWith($mainImg, '-800.webp');
                                                // Get the base name correctly (handling potential multiple hyphens)
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
                                                style="position: relative; z-index: 2;"
                                            >


                                        <a href="{{ route('product.show', $product->slug) }}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 ">
                                            نظره سريعة
                                        </a>
                                    </div>

                                    <div class="block2-txt flex-w flex-t p-t-14">
                                        <div class="block2-txt-child1 flex-col-l ">
                                            <a href="{{ route('product.show', $product->slug) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                {{ $product->name }}

                                            </a>

                                            <span class="stext-105 cl3">
                                                {{ $product->price }}
                                            </span>
                                        </div>

                                        <div class="block2-txt-child2 flex-r p-t-3">
                                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                <img
                                                class="icon-heart1 dis-block trans-04" src="{{ asset('store/images/icons/icon-heart-01.png') }}" alt="ICON">
                                                <img
                                                class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('store/images/icons/icon-heart-02.png') }}" alt="ICON">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    @endforeach
                </div>
            <div class="flex-c-m flex-w w-full p-t-45">
                {{ $products->links('vendor.pagination.bootstrap-5') }}
            </div>

		</div>
	</div>

@endsection

@section('script')

<style>
    /* Skeleton Loading CSS */
    .skeleton {
        background: #f6f7f8;
        background: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
        background-size: 200% 100%; 
        animation: shimmer 1.5s infinite linear;
        border-radius: 4px;
    }

    @keyframes shimmer {
        0% { background-position: 100% 0; }
        100% { background-position: -100% 0; }
    }

    .skeleton-img {
        width: 100%;
        height: 300px; /* Approximate height of product image */
        display: block;
    }

    .skeleton-text {
        height: 14px;
        margin-bottom: 8px;
        width: 80%;
    }

    .skeleton-text.short {
        width: 40%;
    }
    
    .isotope-item {
        transition: opacity 0.3s ease;
    }
    
    img.lazy-load {
        opacity: 0;
        transition: opacity 0.3s ease-in;
    }
    
    img.lazy-load.loaded {
        opacity: 1;
    }
</style>


<script>
    (function ($) {
    "use strict";
        var headerDesktop = $('.container-menu-desktop');
        $(headerDesktop).addClass('fix-menu-desktop');

    })(jQuery);
</script>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Cache Isotope container
        var $grid = $('.isotope-grid');

        // 1. Lazy Loading Setup
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.dataset.src;
                    const srcset = img.dataset.srcset;
                    
                    if (src) {
                        img.src = src;
                        img.removeAttribute('data-src');
                    }
                    if (srcset) {
                        img.srcset = srcset;
                        img.removeAttribute('data-srcset');
                    }
                    
                    img.onload = () => {
                        img.classList.remove('skeleton'); 
                        img.classList.add('loaded');
                        const placeholder = img.parentElement.querySelector('.skeleton-overlay');
                        if (placeholder) {
                            placeholder.remove();
                        }
                        
                        // Trigger Isotope layout update
                        $grid.isotope('layout');
                    };

                    observer.unobserve(img);
                }
            });
        });

        function observeImages(container = document) {
            const images = container.querySelectorAll('img.lazy-load');
            images.forEach(img => imageObserver.observe(img));
        }
        observeImages();


        // 2. Infinite Scroll with Skeleton
        let loading = false;
        let productsWrapper = document.getElementById('products-wrapper');

        // Skeleton HTML Template
        function getSkeletonHTML(count = 4) {
            let html = '';
            for (let i = 0; i < count; i++) {
                html += `
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 skeleton-item isotope-item">
                    <div class="block2">
                        <div class="block2-pic hov-img0 skeleton skeleton-img" style="position: relative;"></div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l">
                                <div class="skeleton skeleton-text"></div>
                                <div class="skeleton skeleton-text short"></div>
                            </div>
                        </div>
                    </div>
                </div>`;
            }
            return html;
        }

        window.addEventListener('scroll', function () {
            if (loading) return;

            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
                let cursorEl = document.getElementById('next-cursor');
                if (!cursorEl) return;

                let url = cursorEl.dataset.url;
                loading = true;
                document.getElementById('loading').style.display = 'block';

                // Append Skeletons using Isotope
                let skeletons = $(getSkeletonHTML(4));
                $grid.append(skeletons).isotope('appended', skeletons);

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(html => {
                    cursorEl.remove();

                    // Remove Skeletons using Isotope
                    $grid.isotope('remove', skeletons).isotope('layout');

                    // Parse New Content
                    let tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    let newItems = [];
                    let nextCursor = null;

                    Array.from(tempDiv.children).forEach(child => {
                         if (child.classList.contains('col-sm-6')) { 
                             newItems.push(child);
                         } else if (child.id === 'next-cursor') {
                             nextCursor = child;
                         }
                    });

                    // Append real items via Isotope
                    if (newItems.length > 0) {
                        let $newItems = $(newItems);
                        $grid.append($newItems).isotope('appended', $newItems);
                        observeImages(productsWrapper);
                    }

                    // Re-add cursor if exists
                    if (nextCursor) {
                        productsWrapper.appendChild(nextCursor);
                    }

                    loading = false;
                    document.getElementById('loading').style.display = 'none';
                })
                .catch(err => {
                    console.error('Error loading products:', err);
                    $grid.isotope('remove', skeletons).isotope('layout');
                    loading = false;
                    document.getElementById('loading').style.display = 'none';
                });
            }
        });
    });
    </script>

@endsection
