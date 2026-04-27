	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart ">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25 ">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					سله المشتريات
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full" id="sideCartItems">
					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="" alt="IMG">
						</div>


                        <div class="header-cart-item-txt p-t-8">

                            <div class="d-flex align-items-center">
                                <a href="#" class="header-cart-item-name hov-cl1 trans-04 mr-3">
                                    White Shirt Pleat
                                </a>

                                <button class="btn btn-link p-0 cl2 fs-25 ml-2 hov-cl1" data-product-id=''>
                                    <i class="zmdi zmdi-close "></i>
                                </button>
                            </div>

                            <span class="header-cart-item-info">
                                1 x ج.م19.00
                            </span>
                        </div>
					</li>
				</ul>

				<div class="w-full">
                    <div class="header-cart-total w-full p-tb-40" id="sideCartTotal">
                        اجمالي: ج.م0.00
                    </div>

					<div class="header-cart-buttons flex-w w-full">
						<button id="clearCart" class="  flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10 ">
							تفريغ السله
						</button>

						<a href="{{ route('shopingcart') }}" class="flex-c-m stext-101 cl0 size-107 bg1 bor2  p-lr-15  m-b-10 cl0 mini_pay  bor1 hov-btn1 trans-04">
							الدفع
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

    <style>
        @media (max-width: 992px) {
            .header-cart {
                margin-top: 70px;
                height: calc(100vh - 75px);
            }
        }
    </style>
