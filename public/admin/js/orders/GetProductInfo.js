$(document).ready(function () {

    // ====== عدّاد للصفوف الجديدة ======
    let itemIndex = 1;

    // ====== Cache للأسعار: يمنع تكرار Ajax لنفس المنتج ======
    const priceCache = {};

    // ====== غيّر ده حسب Route بتاعك ======
    // مثال: /products/{id}/price
    const PRICE_URL = (id) => `/admin/Orders/${id}/price`;

    // ====== حساب إجمالي الفاتورة ======
function calcInvoiceTotal() {
    let subtotal = 0;

    $('.invoice-item').each(function () {
        const price = parseFloat($(this).find('.item-price').val()) || 0;
        const qty   = parseFloat($(this).find('.item-qty').val()) || 0;

        subtotal += (price * qty);
    });

    // 🟦 تكلفة الشحن
    const shippingCost = parseFloat(
        $('#shipping_coast').find(':selected').data('cost')
    ) || 0;

    // 🟥 خصم الفاتورة
    const discount = parseFloat($('#descount').val()) || 0;

    let total = subtotal + shippingCost - discount;
    if (total < 0) total = 0;

    $('#subtotalView').text(subtotal.toFixed(2));
    $('#total').val(total.toFixed(2));
}


    // ====== تعيين السعر للصف الصحيح ======
    function setRowPrice($select, price) {
        $select.closest('.invoice-item')
               .find('.item-price')
               .val(parseFloat(price || 0).toFixed(2))
               .trigger('input'); // يعيد الحساب
    }

    // ====== عند اختيار منتج: هات السعر Ajax (مع cache) ======
    $(document).on('change', '.item-product', function () {
        const $select = $(this);
        const productId = $select.val();

        if (!productId) return;

        // لو موجود في الكاش
        if (priceCache[productId] !== undefined) {
            setRowPrice($select, priceCache[productId]);
            return;
        }

        // Ajax
        $.ajax({
            url: PRICE_URL(productId),
            method: 'GET',
            dataType: 'json',
            success: function (res) {
                // متوقع يرجع { price: 150 }
                const price = res.price ?? 0;
                priceCache[productId] = price;
                setRowPrice($select, price);
            },
            error: function () {
                // لو حصل خطأ خليه 0
                setRowPrice($select, 0);
            }
        });
    });

    // ====== أي تغيير في السعر/الكمية/خصم => احسب ======
$(document).on(
    'input change',
    '.item-price, .item-qty, #descount, #shipping_coast',
    function () {
        calcInvoiceTotal();
    }
);


    // ====== إضافة صف جديد ======
    $('#addItemBtn').on('click', function () {
        const optionsHtml = $('#productOptionsTemplate').html();

        const row = `
            <div class="invoice-item border rounded p-2 mt-2">

                <div class="col-sm-12 data-field-col">
                    <label>الاسم</label>
                    <select name="items[${itemIndex}][product_id]" class="form-control item-product">
                        ${optionsHtml}
                    </select>
                </div>

                <div class="col-sm-12 data-field-col">
                    <label>السعر</label>
                    <input required type="number" name="items[${itemIndex}][price]" class="form-control item-price" value="0" min="0" step="0.01">
                </div>

                <div class="col-sm-12 data-field-col">
                    <label>الكميه</label>
                    <input required type="number" name="items[${itemIndex}][qty]" class="form-control item-qty" value="1" min="0" step="1">
                </div>

                <div class="col-sm-12 data-field-col mt-2">
                    <button type="button" class="btn btn-outline-danger w-100 removeItemBtn">حذف المنتج</button>
                </div>

            </div>
        `;

        $('#itemsContainer').append(row);
        itemIndex++;
        calcInvoiceTotal();
    });

    // ====== حذف صف ======
    $(document).on('click', '.removeItemBtn', function () {
        $(this).closest('.invoice-item').remove();
        calcInvoiceTotal();
    });

    // أول تشغيل
    calcInvoiceTotal();

});
