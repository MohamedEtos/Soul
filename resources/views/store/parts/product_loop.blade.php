@foreach ($products as $product)
    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $product->FabricType->name }}">
        <!-- Block2 -->
        <a href="{{ route('product.show', $product->slug) }}">
            <div class="block2">
                <div class="block2-pic hov-img0 {{ $product->stock > 0 ? 'label-new' : 'label-new-outofstock' }}" data-label="{{ $product->stock > 0 ? 'في المخزن' : 'نفذت ' }}" style="position: relative; min-height: 300px; background-color: #f0f0f0;">
                    
                    <!-- Skeleton Overlay -->
                    <div class="skeleton-overlay skeleton" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></div>

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
                            {{ $product->price }} EGP
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

@if ($products->hasMorePages())
    <div id="next-cursor" data-url="{{ $products->nextPageUrl() }}" style="display:none;"></div>
@endif
