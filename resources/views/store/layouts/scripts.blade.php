
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	{{-- <script src="{{ asset('store/vendor/animsition/js/animsition.min.js') }}"></script> --}}
	{{-- <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/js/animsition.min.js') }}"></script> --}}
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/bootstrap/js/popper.js') }}"></script>
	{{-- <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js') }}"></script> --}}
	<script src="{{ asset('store/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	{{-- <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-v4.0.0-alpha@0.1.6/dist/js/bootstrap.min.js') }}"></script> --}}
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/select2/select2.min.js') }}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('store/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('store/js/slick-custom.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/parallax100/parallax100.js') }}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	{{-- <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js') }}"></script> --}}
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/isotope/isotope.pkgd.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/sweetalert/sweetalert.min.js') }}"></script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').text();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		// $('.js-addcart-detail').each(function(){
		// 	var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').text();
		// 	$(this).on('click', function(){
		// 		swal(nameProduct, "تمت الاضافه", "success");
		// 	});
		// });

        // Global Flash Messages (Success/Error)
        @if(Session::has('success'))
            swal("نجاح", "{{ session('success') }}", "success");
        @endif

        @if(Session::has('error'))
            swal("خطأ", "{{ session('error') }}", "error");
        @endif
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('store/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	{{-- <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.1.0/perfect-scrollbar.min.js') }}"></script> --}}
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});

        $('.slick1').on('init', function(event, slick){
            $('.slick1-dots li').attr('role', 'tab');
            $('.slick1-dots li').each(function(index){
                $(this).attr('id', 'tab-'+(index+1));
                $(this).attr('aria-controls', 'panel-'+(index+1));
                if(index === 0) $(this).attr('aria-selected', 'true');
                else $(this).attr('aria-selected', 'false');
            });
        });


	</script>
<!--===============================================================================================-->
	<script src="{{ asset('store/js/main.js') }}"></script>

<!--===============================================================================================-->
	{{-- Visitor Activity Tracking --}}
	<script>
		(function() {
			// Skip tracking for admin pages
			if (window.location.pathname.startsWith('/admin')) {
				return;
			}

			let startTime = Date.now();
			let durationSeconds = 0;
			let isPageVisible = true;

			// Function to send activity to server
			function sendActivity() {
				const duration = Math.floor((Date.now() - startTime) / 1000);

				if (duration < 1) {
					return; // Don't send if less than 1 second
				}

				// Use sendBeacon for better reliability when page is unloading
				const formData = new FormData();
				formData.append('_token', '{{ csrf_token() }}');
				formData.append('url', window.location.href);
				formData.append('duration_seconds', duration);
				formData.append('page_title', document.title);
				formData.append('started_at', new Date(startTime).toISOString());

				// Try sendBeacon first (better for page unload)
				if (navigator.sendBeacon) {
					const blob = new Blob([new URLSearchParams(formData).toString()], {
						type: 'application/x-www-form-urlencoded'
					});
					navigator.sendBeacon('{{ route("storeVisitorActivity") }}', blob);
				} else {
					// Fallback to fetch
					fetch('{{ route("storeVisitorActivity") }}', {
						method: 'POST',
						body: formData,
						keepalive: true
					}).catch(err => console.error('Activity tracking error:', err));
				}
			}

			// Track page visibility to pause timer when tab is hidden
			document.addEventListener('visibilitychange', function() {
				if (document.hidden) {
					// Page is hidden, pause timer
					durationSeconds += Math.floor((Date.now() - startTime) / 1000);
					isPageVisible = false;
				} else {
					// Page is visible again, resume timer
					startTime = Date.now();
					isPageVisible = true;
				}
			});

			// Send activity when user leaves the page
			window.addEventListener('beforeunload', function() {
				if (isPageVisible) {
					durationSeconds += Math.floor((Date.now() - startTime) / 1000);
				}

				const totalDuration = durationSeconds || Math.floor((Date.now() - startTime) / 1000);

				if (totalDuration >= 1) {
					const formData = new FormData();
					formData.append('_token', '{{ csrf_token() }}');
					formData.append('url', window.location.href);
					formData.append('duration_seconds', totalDuration);
					formData.append('page_title', document.title);
					formData.append('started_at', new Date(startTime).toISOString());

					// Use sendBeacon for reliable delivery during page unload
					if (navigator.sendBeacon) {
						const blob = new Blob([new URLSearchParams(formData).toString()], {
							type: 'application/x-www-form-urlencoded'
						});
						navigator.sendBeacon('{{ route("storeVisitorActivity") }}', blob);
					}
				}
			});

			// Also send activity periodically (every 30 seconds) while user is on page
			setInterval(function() {
				if (isPageVisible) {
					const currentDuration = Math.floor((Date.now() - startTime) / 1000);
					if (currentDuration >= 30) { // Send every 30 seconds
						sendActivity();
						startTime = Date.now(); // Reset timer
						durationSeconds = 0;
					}
				}
			}, 30000);

			// Send activity when page is about to be hidden (for better tracking)
			document.addEventListener('pagehide', function() {
				if (isPageVisible) {
					durationSeconds += Math.floor((Date.now() - startTime) / 1000);
				}

				const totalDuration = durationSeconds || Math.floor((Date.now() - startTime) / 1000);

				if (totalDuration >= 1) {
					const formData = new FormData();
					formData.append('_token', '{{ csrf_token() }}');
					formData.append('url', window.location.href);
					formData.append('duration_seconds', totalDuration);
					formData.append('page_title', document.title);
					formData.append('started_at', new Date(startTime).toISOString());

					if (navigator.sendBeacon) {
						const blob = new Blob([new URLSearchParams(formData).toString()], {
							type: 'application/x-www-form-urlencoded'
						});
						navigator.sendBeacon('{{ route("storeVisitorActivity") }}', blob);
					}
				}
			});
		})();
	</script>
