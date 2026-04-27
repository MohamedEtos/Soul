@extends('store.layouts.master')

@section('head')
    <!-- ===== PRELOAD LCP IMAGES ===== -->
    @if($setting)
    <link rel="preload" as="image" href="{{ asset($setting->slider1_image) }}" type="image/avif" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset($setting->slider2_image) }}" type="image/avif" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset($setting->slider3_image) }}" type="image/avif" fetchpriority="high">
    @endif

    <style>
        .block1.wrap-pic-w {
            overflow: hidden;
            position: relative;
        }
        
        .block1.wrap-pic-w img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        /* Large banners (2 columns) */
        .col-md-6 .block1.wrap-pic-w {
            position: relative;
            padding-bottom: 64.91%; /* 370/570 = aspect ratio */
        }
        
        /* Small banners (3 columns) */
        .col-lg-4 .block1.wrap-pic-w {
            position: relative;
            padding-bottom: 64.86%; /* 240/370 = aspect ratio */
        }
    </style>
@endsection
@section('content')

	<!-- Slider -->
	<section class="section-slide">
		<div class="wrap-slick1 rs2-slick1">
			<div class="slick1">

                @for($i = 1; $i <= 3; $i++)
				<div class="item-slick1 bg-overlay1" style="background-image: url('{{ asset($setting->{'slider'.$i.'_image'}) }}');" role="img"
  aria-label="{{ $setting->{'slider'.$i.'_title'} }}" data-thumb="{{ asset($setting->{'slider'.$i.'_thumb'}) }}" data-caption="{{ $setting->{'slider'.$i.'_title'} }}">
					<div class="container h-full">
						<div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-202 txt-center cl0 respon2 alt_{{ $i }}">
                                    {{ $setting->{'slider'.$i.'_title'} }}
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h1 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
									{{ $setting->{'slider'.$i.'_caption'} }}
                                </h1>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="{{ $setting->{'slider'.$i.'_link'} }}" class="flex-c-m  stext-101 bbc cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
									{{ $setting->{'slider'.$i.'_btn_text'} }}
								</a>
							</div>
						</div>
					</div>
				</div>
                @endfor

			</div>

			<div class="wrap-slick1-dots p-lr-10"></div>
		</div>
	</section>


	<!-- Banner -->
	<div class="sec-banner bg0 p-t-95 p-b-55">
		<div class="container">
			<div class="row">

                @for($i = 1; $i <= 2; $i++)
				<div class="col-md-6 p-b-30 m-lr-auto">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w">
						<img src="{{ asset($setting->{'banner'.$i.'_image'}) }}" alt="IMG-BANNER" width="570" height="370" loading="lazy">

						<a href="{{ $setting->{'banner'.$i.'_link'} }}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{ $setting->{'banner'.$i.'_title'} }}
								</span>

								<span class="block1-info stext-102 trans-04">
									{{ $setting->{'banner'.$i.'_info'} }}
								</span>
							</div>

							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									اكتشف الان
								</div>
							</div>
						</a>
					</div>
				</div>
                @endfor

                @for($i = 3; $i <= 5; $i++)
				<div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w">
						<img src="{{ asset($setting->{'banner'.$i.'_image'}) }}" alt="IMG-BANNER" width="370" height="240" loading="lazy">

						<a href="{{ $setting->{'banner'.$i.'_link'} }}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{ $setting->{'banner'.$i.'_title'} }}
								</span>

								<span class="block1-info stext-102 trans-04">
									{{ $setting->{'banner'.$i.'_info'} }}
								</span>
							</div>

							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									اكتشف الان
								</div>
							</div>
						</a>
					</div>
				</div>
                @endfor

			</div>
		</div>
	</div>


	<!-- Product -->
	<section class="bg0 p-t-23 p-b-130 arabic_section">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
				{{ $setting->home_section_title ?? 'اكتشفي جمال التفاصيل...' }}
				</h3>
			</div>

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

                        <form method="GET" action="{{ route('home') }}" class="mb-4 w-100">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="ابحث عن منتج..."
                                class="mtext-107 cl2 size-114 plh2 p-r-15"
                            >
                        </form>

						{{-- <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Search"> --}}
					</div>
				</div>

				<!-- Filter -->
				<div class="dis-none panel-filter w-full p-t-10">
					<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
						<div class="filter-col1 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Sort By
							</div>

							<ul>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										Default
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										Popularity
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										Average rating
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
										Newness
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										Price: Low to High
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										Price: High to Low
									</a>
								</li>
							</ul>
						</div>

						<div class="filter-col2 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Price
							</div>

							<ul>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
										All
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$0.00 - $50.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$50.00 - $100.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$100.00 - $150.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$150.00 - $200.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$200.00+
									</a>
								</li>
							</ul>
						</div>

						<div class="filter-col3 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Color
							</div>

							<ul>
								<li class="p-b-6">
									<span class="fs-15 lh-12 m-r-6" style="color: #222;">
										<i class="zmdi zmdi-circle"></i>
									</span>

									<a href="#" class="filter-link stext-106 trans-04">
										Black
									</a>
								</li>

								<li class="p-b-6">
									<span class="fs-15 lh-12 m-r-6" style="color: #4272d7;">
										<i class="zmdi zmdi-circle"></i>
									</span>

									<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
										Blue
									</a>
								</li>

								<li class="p-b-6">
									<span class="fs-15 lh-12 m-r-6" style="color: #b3b3b3;">
										<i class="zmdi zmdi-circle"></i>
									</span>

									<a href="#" class="filter-link stext-106 trans-04">
										Grey
									</a>
								</li>

								<li class="p-b-6">
									<span class="fs-15 lh-12 m-r-6" style="color: #00ad5f;">
										<i class="zmdi zmdi-circle"></i>
									</span>

									<a href="#" class="filter-link stext-106 trans-04">
										Green
									</a>
								</li>

								<li class="p-b-6">
									<span class="fs-15 lh-12 m-r-6" style="color: #fa4251;">
										<i class="zmdi zmdi-circle"></i>
									</span>

									<a href="#" class="filter-link stext-106 trans-04">
										Red
									</a>
								</li>

								<li class="p-b-6">
									<span class="fs-15 lh-12 m-r-6" style="color: #aaa;">
										<i class="zmdi zmdi-circle-o"></i>
									</span>

									<a href="#" class="filter-link stext-106 trans-04">
										White
									</a>
								</li>
							</ul>
						</div>

						<div class="filter-col4 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Tags
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

			<div class="row  isotope-grid" id="products-wrapper">
                @include('store.parts.product_loop')
			</div>

			{{-- <!-- Pagination -->
			<div class="flex-c-m flex-w w-full p-t-38">
				<a href="#" class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1">
					1
				</a>

				<a href="#" class="flex-c-m how-pagination1 trans-04 m-all-7">
					2
				</a>

            </div> --}}

			<!-- Load more (Hidden / Replaced by Infinite Scroll) -->
            <div id="loading" style="display:none; text-align:center; padding-top: 20px;">
                <!-- Optional: Add a spinner here if desired, otherwise the skeleton serves as loading indicator -->
            </div>
        </div>
	</section>

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

{{-- Great after order celebration script --}}

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <script src="{{ asset('admin/vendors/js/extensions/toastr.min.js') }}"></script>

    <script>
        function celebrateOrder() {
            confetti({ particleCount: 140, spread: 70, origin: { y: 0.6 } });
            setTimeout(() => confetti({ particleCount: 100, spread: 120, origin: { y: 0.7 } }), 250);
        }
    </script>

        @if(Session::has('success'))
            <script>toastr.success('{{ session('success') }}', 'تمت العمليه ');</script>
            <script>celebrateOrder()</script>
            @endif

        @if(Session::has('error'))
            <script>toastr.error('{{ session('error') }}', ' error ');</script>
        @endif



    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Cache Isotope container (using jQuery because Isotope is a jQuery plugin here)
        var $grid = $('.isotope-grid');

        // Function to trigger layout update safely
        function updateLayout() {
            $grid.isotope('layout');
        }

        // Debounce function to prevent excessive layout updates
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        const debouncedLayout = debounce(updateLayout, 100);

        // 1. Lazy Loading Setup (for new/dynamic images)
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.dataset.src;
                    const srcset = img.dataset.srcset;
                    
                    // Assign onload BEFORE setting src to catch immediate loads
                    img.onload = () => {
                        img.classList.remove('skeleton'); 
                        img.classList.add('loaded');
                        
                        // Remove overlay
                        const placeholder = img.parentElement.querySelector('.skeleton-overlay');
                        if (placeholder) {
                            placeholder.remove();
                        }

                        // Trigger Isotope layout update
                        debouncedLayout();
                    };

                    if (src) {
                        img.src = src;
                        img.removeAttribute('data-src');
                    }
                    if (srcset) {
                        img.srcset = srcset;
                        img.removeAttribute('data-srcset');
                    }

                    // Check if image is already complete (cached)
                    if (img.complete && img.naturalHeight !== 0) {
                         img.onload(); // Manually trigger logic
                    }
                    
                    observer.unobserve(img);
                }
            });
        });

        function observeImages(container = document) {
            const images = container.querySelectorAll('img.lazy-load');
            images.forEach(img => imageObserver.observe(img));
        }
        observeImages();

        // 2. Fix for Initial Images (that use native loading="lazy")
        // Select all images in the grid that are NOT marked for manual lazy load
        const initialImages = document.querySelectorAll('.isotope-grid img:not(.lazy-load)');
        initialImages.forEach(img => {
            if (img.complete) {
                 debouncedLayout();
            } else {
                img.addEventListener('load', debouncedLayout);
            }
        });


        // 3. Infinite Scroll with Skeleton
        let loading = false;
        let productsWrapper = document.getElementById('products-wrapper'); // Keep this for reference if needed, but we use $grid mostly

        // Skeleton HTML Template
        function getSkeletonHTML(count = 4) {
            let html = '';
            for (let i = 0; i < count; i++) {
                html += `
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 skeleton-item isotope-item"> <!-- Added isotope-item class -->
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
                    // detailed removal to avoid layout breaks
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
                        
                        // Observe new images for lazy loading if they have the class
                        // Note: Our load_more.blade.php uses native loading currently, so we need to bind load listeners manually
                        $newItems.find('img').each(function() {
                             if (this.complete) {
                                 debouncedLayout();
                             } else {
                                 this.addEventListener('load', debouncedLayout);
                             }
                        });


                        observeImages(productsWrapper); // or pass document, observer handles duplicates gracefully
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

    <script>
    (function ($) {
    "use strict";
    // [ Fixed Header ]*/
    var headerDesktop = $('.container-menu-desktop');
    var wrapMenu = $('.wrap-menu-desktop');
    if($('.top-bar').length > 0) {
        var posWrapHeader = $('.top-bar').height();
    }
    else {
        var posWrapHeader = 0;
    }


    if($(window).scrollTop() > posWrapHeader) {
        $(headerDesktop).addClass('fix-menu-desktop');
        $(wrapMenu).css('top',0);
    }
    else {
        $(headerDesktop).removeClass('fix-menu-desktop');
        $(wrapMenu).css('top',posWrapHeader - $(this).scrollTop());
    }

    $(window).on('scroll',function(){
        if($(this).scrollTop() > posWrapHeader) {
            $(headerDesktop).addClass('fix-menu-desktop');
            $(wrapMenu).css('top',0);
        }
        else {
            $(headerDesktop).removeClass('fix-menu-desktop');
            $(wrapMenu).css('top',posWrapHeader - $(this).scrollTop());
        }
    });
    })(jQuery);
    </script>

@endsection
