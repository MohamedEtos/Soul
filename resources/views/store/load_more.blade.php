{{-- @foreach ($products as $product)
    <div class="product-card">
        <img
            src="{{ asset($product->product_img_p->mainImage ?? 'default.png') }}"
            alt="{{ $product->name }}"
        >

        <h3>{{ $product->name }}</h3>
        <p>{{ $product->price }} EGP</p>
    </div>
@endforeach

@if ($products->nextPageUrl())
    <span data-next-cursor="{{ $products->nextPageUrl() }}"></span>
@endif --}}




                    @foreach ($products as $product)
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0 label-new" data-label="New">

                                    <img
                                        src="{{ asset(Str::before($product->product_img_p->mainImage, '-') . '-800.webp') }}"
                                        srcset="
                                            {{ asset(Str::before($product->product_img_p->mainImage, '-') . '-320.webp') }} 320w,
                                            {{ asset(Str::before($product->product_img_p->mainImage, '-') . '-480.webp') }} 480w,
                                            {{ asset(Str::before($product->product_img_p->mainImage, '-') . '-800.webp') }} 800w,
                                            {{ asset(Str::before($product->product_img_p->mainImage, '-') . '-1200.webp') }} 1200w
                                        "
                                        sizes="(max-width: 600px) 45vw,
                                            (max-width: 1200px) 25vw,
                                            300px"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                        decoding="async"
                                    >


                                    <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                        Quick View
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
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
                        </div>

                    @endforeach


@if ($products->nextPageUrl())
    <span id="next-cursor" data-url="{{ $products->nextPageUrl() }}"></span>
@endif
