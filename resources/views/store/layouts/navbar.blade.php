	<header class="header-v3" >
		<!-- Header desktop -->
		<div class="container-menu-desktop trans-03">
			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop p-l-45">

					<!-- Logo desktop -->
					<a href="{{ url('/') }}" class="logo">
						<img src="{{ asset($setting->mainLogo) }}" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li>
								<a href="/">home</a>
							</li>

							<li>
								<a href="{{ route('product') }}">shop</a>
							</li>

							{{-- <li class="label1" data-label1="hot"> --}}
							<li>
								<a target="_blank" href="https://wa.me/201554063260 ">WhatsApp</a>
							</li>

							<li>
								<a target="_blank" href="https://www.facebook.com/profile.php?id=61583415522354">Facebook</a>
							</li>

							<li>
								<a target="_blank" href="https://www.instagram.com/luna.blustore?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">instagram</a>
							</li>


						</ul>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m h-full">
						<div class="flex-c-m h-full p-r-25 bor6">
							<div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart  cartCount" id="" data-notify="0">
								<i class="zmdi zmdi-shopping-cart"></i>
							</div>
						</div>

						<div class="flex-c-m h-full p-lr-19">
							<div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
								<i class="zmdi zmdi-menu"></i>
							</div>
						</div>
					</div>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
				<a href="/"><img src="{{ asset($setting->whiteLogo) }}" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
				<div class="flex-c-m h-full p-r-5">
					<div class="icon-header-item  hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart cartCount"id="" data-notify="0" style="color: #f0287d">
						<i class="zmdi zmdi-shopping-cart"></i>
					</div>
				</div>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze ">
				<span class="hamburger-box ">
					<span class="hamburger-inner"></span>

				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
						<ul class="main-menu-m">
							<li>
								<a href="/">home</a>
							</li>

							<li>
								<a href="{{ route('product') }}">shop</a>
							</li>

							{{-- <li class="label1" data-label1="hot"> --}}
							<li>
								<a target="_blank" href="https://wa.me/201554063260 ">WhatsApp</a>
							</li>

							<li>
								<a target="_blank" href="https://www.facebook.com/profile.php?id=61583415522354">Facebook</a>
							</li>

							<li>
								<a target="_blank" href="https://www.instagram.com/luna.blustore/">instagram</a>
							</li>

							{{-- <li>
								<a href="contact.html">Contact</a>
							</li> --}}
						</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<button class="flex-c-m btn-hide-modal-search trans-04" aria-label="Close Modal Search">
                  <span class="sr-only">close</span>
				<i class="zmdi zmdi-close"></i>
			</button>

			<form class="container-search-header">
				<div class="wrap-search-header">
					<input class="plh0" type="text" name="search" placeholder="Search...">

					<button class="flex-c-m trans-04" aria-label="Close Modal Search">
						<i class="zmdi zmdi-search"></i>
					</button>
				</div>
			</form>
		</div>
	</header>
