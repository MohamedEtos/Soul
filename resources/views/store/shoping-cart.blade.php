@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/plugins/extensions/toastr.css') }}">
@endsection
@extends('store.layouts.master') {{-- أو layout بتاعك --}}

@section('content')

<form class="bg0 p-t-100 mt-5 p-b-85" id="cartPage" method="POST" action="{{ route('prossesCart') }}">
    @csrf
	<div class="container">
		<div class="row">

			{{-- LEFT: table --}}
			<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
				<div class="m-l-25 m-r--38 m-lr-0-xl">
					<div class="wrap-table-shopping-cart">
						<table class="table-shopping-cart">
							<tr class="table_head">
								<th class="column-1">المنتج</th>
								<th class="column-2"></th>
								<th class="column-3">السعر</th>
								<th class="column-4">الكمية</th>
								<th class="column-5">المجموع</th>
							</tr>

                            <tbody id="cartTableBody">
							@if(!empty($cartData['items']) && count($cartData['items']) > 0)

								@foreach($cartData['items'] as $it)

									<tr class="table_row" data-product-id="{{ $it['key'] }}">

										<td class="column-1">
											<a class="how-itemcart1 mt-2 hov3 trans-04" href="{{ route('product.show', $it['slug']) }}"
                                                 data-product-id="{{ $it['product_id'] }}">
                                            <img src="{{ $it['image'] ?: asset('store/images/placeholder.jpg') }}" alt="{{ $it['name'] }}">
                                            <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $it['product_id'] }}">
                                            <input type="hidden" name="items[{{ $loop->index }}][qty]" value="{{ $it['qty'] }}" class="cart_qty" data-product-id="{{ $it['key'] }}">
                                            <input type="hidden" name="items[{{ $loop->index }}][size]" value="{{ $it['size'] ?? '' }}">
                                            <input type="hidden" name="items[{{ $loop->index }}][color]" value="{{ $it['color'] ?? '' }}">
                                            </a>
										</td>

										<td class="column-2">
                                            {{ $it['name'] }}
                                            @if(!empty($it['size']))
                                                <br><span class="stext-111 cl6">المقاس: {{ $it['size'] }}</span>
                                            @endif
                                            @if(!empty($it['color']))
                                                <br><span class="stext-111 cl6">اللون: {{ $it['color'] }}</span>
                                            @endif
                                        </td>

										<td class="column-3">ج.م {{ number_format($it['price'], 2) }}</td>

										<td class="column-4">
											<div class="wrap-num-product flex-w m-l-auto m-r-0">
												<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m js-qty-minus">
													<i class="fs-16 zmdi zmdi-minus"></i>
												</div>

												<input
                                                    class="mtext-104 cl3 txt-center num-product cart_qty"
                                                    type="number"
                                                    min="1"
                                                    value="{{ (int)$it['qty'] }}"
                                                    data-product-id="{{ $it['key'] }}"

                                                >



												<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m js-qty-plus">
													<i class="fs-16 zmdi zmdi-plus"></i>
												</div>
											</div>

                                            @if(isset($it['stock_available']))
                                                <small class="stext-111 cl6 d-block p-t-5">
                                                    متبقي في المخزن: {{ (int)$it['stock_available'] }}
                                                </small>
                                            @endif

										</td>


										<td class="column-5 row_total">
                                            ج.م {{ number_format($it['line_total'], 2) }}
                                        </td>
									</tr>
								@endforeach

							@else
								<tr>
									<td colspan="5" class="p-4 text-center">
										السلة فاضية
									</td>
								</tr>
							@endif
                            </tbody>

						</table>
					</div>

					<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
						<div class="flex-w flex-m m-r-20 m-tb-5">
							<input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5"
                                   type="text" name="coupon" placeholder="Coupon Code">

							<a class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5" href="{{ route('product') }}">
								متابعه التسوق
                            </a>
						</div>

						<div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10"
                             id="btnUpdateCart">
							تفريغ السله
						</div>
					</div>
				</div>
			</div>

			{{-- RIGHT: totals --}}
			<div class="col-sm-12 col-lg-7 col-xl-5 m-lr-auto m-b-50" style="direction: rtl">
				<div class="bor10 p-lr-40 p-t-30 p-b-40  m-lr-0-xl ">
					<h4 class="mtext-109 cl2 p-b-30" >
						مجموع السلة
					</h4>

					<div class="flex-w flex-t bor12 p-b-13">

                        <div class="size-208">
                            <span class="stext-110 cl2">الشحن:</span>
                        </div>

                        <div class="size-209">
                            <span class="mtext-110 cl2" id="shipping">
                                ج.م {{ number_format($cartData['shipping_cost'] ?? 0, 2) }}
                            </span>
                        </div>
                    </div>

					<div class="flex-w flex-t bor12 p-b-13">
						<div class="size-208">
							<span class="stext-110 cl2">المشتريات:</span>
						</div>

						<div class="size-209">
							<span class="mtext-110 cl2" id="pageSubtotal">
                                ج.م {{ number_format($cartData['subtotal'] ?? 0, 2) }}
							</span>
					    </div>
                    </div>

					{{-- Shipping block (زي ما هو) --}}
					<div class="flex-w flex-t bor12 p-t-15 p-b-30">

						<div class="size-100 p-r-18 p-r-0-sm w-full-ssm">
							<p class="stext-111 cl6 p-t-2">
                                يتم التوصيل عاده خلال 5-7 أيام عمل. يرجى إدخال عنوانك لتقدير وقت الشحن.
							</p>


							<div class="p-t-4">
								<span class="stext-112 cl8">رقم الهاتف</span>

								<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    class="form-control"
                                    placeholder="مثال: 01012345678 "
                                    inputmode="numeric"
                                    autocomplete="tel"
                                    maxlength="11"
                                    pattern="^(?:\+20|0020|0)?1[0125]\d{8}$"
                                    required
                                    value="{{ old('phone') }}"
                                    />

                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


							</div>
							<div class="p-t-4">
								<span class="stext-112 cl8">الاسم الكامل</span>

								<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <input
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    placeholder='مثال: أحمد محمد علي'
                                    autocomplete="name"
                                    required
                                    value="{{ old('name') }}"
                                    />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

							</div>

							<div class="p-t-4">
								<span class="stext-112 cl8">المحافظة </span>

								<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">

                                        <select id="governorate" name="governorate" required class="form-control">
                                        <option value="" selected disabled>اختر المحافظة</option>

                                            @foreach ($governorate as $gov )
                                                <option value="{{ $gov }}" {{ old('governorate') ==  $gov  ? 'selected' : '' }}>{{ $gov }}</option>
                                            @endforeach

                                        </select>

                                    @error('governorate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror


                                    {{-- <div class="invalid-feedback">
                                    رقم الهاتف غير صحيح. أدخل رقم مصري مثل 01012345678 أو +201012345678
                                    </div> --}}
                                </div>


							</div>

                            <div class="p-t-4">
								<span class="stext-112 cl8">المنطقه</span>

								<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <input
                                    id="area"
                                    name="area"
                                    class="form-control"
                                    placeholder='مثال: المهندسين'
                                    autocomplete="area"
                                    required
                                    value="{{ old('area') }}"

                                    />
                                    @error('area')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
							</div>
                            <div class="p-t-4">
								<span class="stext-112 cl8">العنوان</span>

								<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <input
                                    id="address"
                                    name="address"
                                    class="form-control"
                                    placeholder='مثال: 123 شارع النيل، القاهرة، مصر'
                                    autocomplete="address"
                                    required
                                    value="{{ old('address') }}"
                                    />
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
							</div>

                            <div class="p-t-4">
								<span class="stext-112 cl8">مبني رقم</span>

								<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <input
                                    id="building"
                                    name="building"
                                    class="form-control"
                                    placeholder='مثال: 5'
                                    autocomplete="building"
                                    required
                                    value="{{ old('building') }}"
                                    />
                                    @error('building')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
							</div>

                            <div class="p-t-4">
								<span class="stext-112 cl8"> الطابق</span>

								<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <input
                                    id="floor_number"
                                    name="floor_number"
                                    class="form-control"
                                    placeholder='مثال: 2'
                                    autocomplete="floor_number"
                                    required
                                    value="{{ old('floor_number') }}"
                                    />
                                    @error('floor_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
							</div>
                            <div class="p-t-4">
								<span class="stext-112 cl8"> ملاحظات الشحن</span>

								<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <input
                                    id="note"
                                    name="note"
                                    class="form-control"
                                    autocomplete="note"
                                    value="{{ old('note') }}"
                                    />

                                    @error('note')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
							</div>

						</div>

					</div>

					<div class="flex-w flex-t p-t-27 p-b-33">
						<div class="size-208">
							<span class="mtext-101 cl2">Total:</span>
						</div>

						<div class="size-209 p-t-1">
							<span class="mtext-110 cl2" id="total">
                                ج.م {{ number_format($cartData['total'] ?? 0, 2) }}
							</span>
						</div>
					</div>

					@if(!empty($cartData['items']) && count($cartData['items']) > 0)
					<button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                        اتمام الطلب
                    </button>
                    @else
					<button type="button" disabled class="flex-c-m stext-101 cl0 size-116 bg3 bor14 p-lr-15 trans-04 " style="opacity: 0.6; cursor: not-allowed;">
                        السلة فارغة
                    </button>
                    @endif

                    <a href="{{ route('product') }}"  class="d-block text-center p-t-20 stext-101 cl2 hov-cl1">
                         متابعه التسوق
                    </a>

				</div>
			</div>

		</div>
	</div>
</form>

@endsection

@section('script')


<script>
    (function ($) {
    "use strict";
        var headerDesktop = $('.container-menu-desktop');
        $(headerDesktop).addClass('fix-menu-desktop');

    })(jQuery);
</script>
<script>
/**
 * ✅ تكملة على كودك الموجود — نفس الأحداث لكن هنضيف:
 * - plus/minus buttons في صفحة cart
 * - تحديث Subtotal/Total في الصفحة بعد update/remove/clear
 * - إعادة حساب row total في الواجهة (اختياري)
 */

// لما المستخدم يدوس + / -
$(document).on('click', '.js-qty-plus', function () {
  const row = $(this).closest('tr.table_row');
  const input = row.find('.cart_qty');
  let qty = parseInt(input.val() || 1);
  qty++;
  input.val(qty).trigger('change'); // change event بتاعك هيعمل PATCH
});

// لما المستخدم يدوس - / -
$(document).on('click', '.js-qty-minus', function () {
  const row = $(this).closest('tr.table_row');
  const input = row.find('.cart_qty');
  let qty = parseInt(input.val() || 1);

  if (qty <= 1) {
    // حذف المنتج بدلاً من تخفيض الكمية تحت 1
    const productId = row.data('product-id') || input.data('product-id');
    $.ajax({
      url: "{{ route('cart.remove') }}",
      type: "DELETE",
      data: { product_id: productId },
      success: function (res) {
        $(".cartCount").attr("data-notify", res.cart.count);
        row.remove();
        updatePageTotals(res.cart);
        refreshSideCart();
      }
    });
    return;
  }

  qty = Math.max(1, qty - 1);
  input.val(qty).trigger('change');
});

// ✅ بعد أي update/remove/clear نحدّث totals في الصفحة + نعمل refreshSideCart
// ✅ بعد أي update/remove/clear نحدّث totals في الصفحة + نعمل refreshSideCart
function updatePageTotals(cart){
  if(!cart) return;
  
  // Helper to format money if not defined
  const fmt = (window.formatMoney) ? window.formatMoney : (n) => Number(n).toFixed(2);

  $('#pageSubtotal').text(`ج.م ${fmt(cart.subtotal)}`);
  $('#total').text(`ج.م ${fmt(cart.total)}`);
  $('#shipping').text(`ج.م ${fmt(cart.shipping_cost)}`);

  // تحديث row totals لو الريسبونس فيه items
  if(cart.items && cart.items.length){
    cart.items.forEach(it => {
      // Use it.key to match data-product-id
      const row = $(`tr.table_row[data-product-id="${it.key}"]`);
      row.find('.row_total').text(`ج.م ${fmt(it.line_total)}`);
      row.find('.cart_qty').val(it.qty);
    });
  } else {
    // لو السلة فضيت
    $('#cartTableBody').html(`<tr><td colspan="5" class="p-4 text-center">السلة فاضية</td></tr>`);
  }
}

// ✅ Override على success بتاعتك: نخليها تحدث الصفحة كمان
$(document).on('change', '.cart_qty', function () {
  const productId = $(this).data('product-id');
  const qty = $(this).val();

  $.ajax({
    url: "{{ route('cart.update') }}",
    type: "PATCH",
    data: { product_id: productId, qty: qty },
    success: function (res) {
      $(".cartCount").attr("data-notify", res.cart.count);
      updatePageTotals(res.cart);

      refreshSideCart();
    }
  });
});




$(document).on('change', '#governorate', function () {
  const gov = $(this).val();

  $.ajax({
    url: "{{ route('cart.governorate') }}",
    type: "PATCH",
    data: { governorate: gov },
    success: function (res) {
       console.log(res);
      $(".cartCount").attr("data-notify", res.cart.count);

      // نفس اللي بتعمله عند تغيير الكمية
      updatePageTotals(res.cart);
      refreshSideCart();

      // ✅ لو عايز "تحديث الصفحة كمان" اختار واحد:
      // 1) Reload كامل:
      // location.reload();

      // 2) Reload لجزء معين فقط (أنضف):
      // $("#orderSummary").load(location.href + " #orderSummary>*");
    }
  });
});



$(document).on('click', '.remove_item', function () {
  const productId = $(this).data('product-id');

  $.ajax({
    url: "{{ route('cart.remove') }}",
    type: "DELETE",
    data: { product_id: productId },
    success: function (res) {
      $(".cartCount").attr("data-notify", res.cart.count);

      // احذف الصف من الجدول
      $(`tr.table_row[data-product-id="${productId}"]`).remove();

      updatePageTotals(res.cart);
      refreshSideCart();
    }
  });
});

$(document).on('click', '#clearCart', function (e) {
  e.preventDefault();

  $.ajax({
    url: "{{ route('cart.clear') }}",
    type: "DELETE",
    success: function (res) {
      $(".cartCount").attr("data-notify", '0');
      updatePageTotals({subtotal:0, count:0, items:[]});
      refreshSideCart();
    }
  });
});

// زر Update Cart: يحدث كل المنتجات مرة واحدة
$(document).on('click', '#btnUpdateCart', function () {
  const inputs = $('.cart_qty');
  if(!inputs.length) return;

  // هننفذ PATCH لكل منتج (زي نظامك الحالي)
  inputs.each(function(){
    $(this).trigger('change');
  });
});

</script>

    <script src="{{ asset('admin/vendors/js/extensions/toastr.min.js') }}"></script>

    @if(Session::has('success'))
        <script>toastr.success('{{ session('success') }}', 'تمت العمليه ');</script>
        @endif

    @if(Session::has('error'))
        <script>toastr.error('{{ session('error') }}', ' error ');</script>
    @endif

    @if($errors->any())
        <script>
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}', 'Error');
            @endforeach
        </script>
    @endif




@endsection
