$(document).on('click', '.trRow', function () {
    const row = $(this);
    $('#order_number').text(row.find('.order_number').text());
    $('#product_name').text(row.find('.product_name').text());
    $('#subtotal').text(row.find('.subtotal').text());
    $('#shipping_cost').text(row.find('.shipping_cost').text());
    $('#total_modal').text(row.find('.total_modal').text());
    $('#governorate').text(row.find('.governorate').text());
    $('#created_at').text(row.find('.created_at').text());
    $('#full_name').text(row.find('.full_name').val() || row.find('.full_name').text());
    $('#phone_modeal').text(row.find('.phone_modeal').val() || row.find('.phone_modeal').text());
    $('#area_modal').text(row.find('.area_modal').val() || row.find('.area_modal').text());
    $('#floor_number_modal').text(row.find('.floor_number_modal').val() || row.find('.floor_number_modal').text());
    $('#building_modal').text(row.find('.building_modal').val() || row.find('.building_modal').text());
    $('#address_modal').text(row.find('.address_modal').val() || row.find('.address_modal').text());
    $('#status').text(row.find('.status_modal').val());

    // Set Image
    const imgSrc = row.find('.product_image').val();
    if (imgSrc) {
        $('#modal_product_image').attr('src', imgSrc);
    }
});
