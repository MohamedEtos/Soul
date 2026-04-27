

<script>

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).on('click', '.add_cart', function (e) {
  e.preventDefault();

  const productId = $(this).data('product-id');
  const qty = $('.qty').val();
  const size = $('select[name="size"]').val();

  $.post("{{ route('cart.add') }}", { product_id: productId, qty: qty, size: size })
    .done(function (res) {
            refreshSideCart();

        $(".cartCount").attr("data-notify", res.cart.count);

      console.log(res.cart);
    })
    .fail(function (xhr) {
      handleCartError(xhr, 'إضافة المنتج للسلة');
    });
});


$(document).on('change', '.cart_qty', function () {
  const productId = $(this).data('product-id');
  const qty = $(this).val();

  $.ajax({
    url: "{{ route('cart.update') }}",
    type: "PATCH",
    data: { product_id: productId, qty: qty },
    success: function (res) {
      $(".cartCount").attr("data-notify", res.cart.count);
      console.log(res.cart);
    },
    error: function (xhr) {
      handleCartError(xhr, 'تحديث الكمية');
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
    },
    error: function (xhr) {
      handleCartError(xhr, 'حذف المنتج');
    }
  });
});



$(document).on('click', '#clearCart', function () {
  $.ajax({
    url: "{{ route('cart.clear') }}",
    type: "DELETE",
    success: function (res) {
      $(".cartCount").attr("data-notify", '0');
    },
    error: function (xhr) {
      handleCartError(xhr, 'تفريغ السلة');
    }
  });
});


$(document).ready(function () {
  $.get("{{ route('cart.show') }}", function (res) {
    $('.cartCount').attr('data-notify', res.count);

  });
});






$(document).ready(function () {
  refreshSideCart();
});

// ✅ تجيب السلة وترسمها
function refreshSideCart() {
  $.get("{{ route('cart.show') }}", function (res) {

    // res = { items:[], subtotal:..., count:... }  (زي اللي طالع عندك)

    // 1) رسم العناصر
    const ul = $('#sideCartItems');
    ul.empty();

    if (!res.items || res.items.length === 0) {
      ul.append(`<li class="p-t-20 p-b-20 text-center">السلة فاضية</li>`);
      $('#sideCartTotal').text('اجمالي: ج.م0.00');
      // عداد الأيقونة لو عندك
      $('.cartCount').attr('data-notify', 0);
      return;
    }

    res.items.forEach(item => {
      ul.append(`
        <li class="header-cart-item flex-w flex-t m-b-12">
          <div class="header-cart-item-img">
            <img src="${item.image}" alt="IMG">
          </div>

          <div class="header-cart-item-txt p-t-8">

            <div class="d-flex align-items-center">
              <a href="/product/${item.slug}" class="header-cart-item-name hov-cl1 trans-04 mr-3">
                ${escapeHtml(item.name)}
              </a>

              <button type="button"
                class="btn btn-link p-0 cl2 fs-25 ml-2 hov-cl1 js-remove-sidecart"
                data-product-id="${item.key}">
                <i class="zmdi zmdi-close"></i>
              </button>
            </div>

            <span class="header-cart-item-info d-block">
              ${item.qty} x ج.م${formatMoney(item.price)}
            </span>
            ${item.size ? `<span class="header-cart-item-info d-block fs-12 text-muted">المقاس: ${escapeHtml(item.size)}</span>` : ''}
            ${item.color ? `<span class="header-cart-item-info d-block fs-12 text-muted">اللون: ${escapeHtml(item.color)}</span>` : ''}
          </div>
        </li>
      `);
    });

    // 2) تحديث الإجمالي
    $('#sideCartTotal').text(`اجمالي: ج.م${formatMoney(res.subtotal)}`);
     $("#shipping").text(res.shipping_cost.toFixed(2));
     $("#total").text(res.total.toFixed(2));

    // 3) تحديث عداد أيقونة السلة (لو عندك)
    $('.cartCount').attr('data-notify', res.count);
  });
}

// ✅ حذف عنصر من السلة (زر X)
$(document).on('click', '.js-remove-sidecart', function () {
  const productId = $(this).data('product-id');

  $.ajax({
    url: "{{ route('cart.remove') }}",
    type: "DELETE",
    data: { product_id: productId },
    success: function () {
      refreshSideCart();
    },
    error: function (xhr) {
      handleCartError(xhr, 'حذف المنتج');
      refreshSideCart(); // Refresh anyway to show current state
    }
  });
});

// ✅ تفريغ السلة
$(document).on('click', '#clearCart', function (e) {
  e.preventDefault();

  $.ajax({
    url: "{{ route('cart.clear') }}",
    type: "DELETE",
    success: function () {
      refreshSideCart();
    },
    error: function (xhr) {
      handleCartError(xhr, 'تفريغ السلة');
    }
  });
});

// Helpers
function formatMoney(val) {
  return Number(val || 0).toFixed(2);
}
function escapeHtml(text) {
  return String(text ?? '')
    .replaceAll('&','&amp;')
    .replaceAll('<','&lt;')
    .replaceAll('>','&gt;')
    .replaceAll('"','&quot;')
    .replaceAll("'","&#039;");
}

// Handle cart errors with throttle detection
function handleCartError(xhr, operation) {
  let errorMessage = 'حدث خطأ أثناء ' + operation;
  
  // Check for throttle exception (429 or specific message)
  if (xhr.status === 429 || 
      (xhr.responseJSON && xhr.responseJSON.message === "Too Many Attempts.")) {
    
    if (typeof swal !== 'undefined') {
      swal({
        title: "⚠️ تحذير!",
        text: "عدد كبير من المحاولات! يرجى الانتظار قليلاً قبل المحاولة مرة أخرى.\n\nإذا كنت تحاول التلاعب بالسلة، يرجى العلم أن النظام يراقب هذه التصرفات.",
        icon: "warning",
        button: "حسناً",
        dangerMode: true
      });
    } else {
      alert("⚠️ تحذير!\n\nعدد كبير من المحاولات! يرجى الانتظار قليلاً.\n\nإذا كنت تحاول التلاعب بالسلة، يرجى العلم أن النظام يراقب هذه التصرفات.");
    }
    
    console.warn('🚨 Throttle limit exceeded for cart operation:', operation);
    return;
  }
  
  // Handle other errors
  if (xhr.responseJSON && xhr.responseJSON.message) {
    errorMessage = xhr.responseJSON.message;
  } else if (xhr.status === 500) {
    errorMessage = 'حدث خطأ في الخادم، يرجى المحاولة لاحقاً';
  } else if (xhr.status === 404) {
    errorMessage = 'المنتج غير موجود';
  }
  
  if (typeof swal !== 'undefined') {
    swal("خطأ", errorMessage, "error");
  } else {
    alert(errorMessage);
  }
  
  console.error('Cart error:', xhr);
}




$(document).on('click', '.mini_pay', function (e) {
  const totalText = $('#sideCartTotal').text().trim();

  // شيل أي عملة أو مسافات
  const total = parseFloat(totalText.replace(/[^\d.]/g, ''));

  if (!total || total <= 0) {
    e.preventDefault(); // ❌ امنع الانتقال
    alert('لا يمكن المتابعة للدفع، سلة التسوق فارغة');
    return false;
  }
});



</script>
