$(document).ready(function () {
    let lastCount = -1; // Initialize

    // Initial check to set the count without alert
    // Or we assume the server rendered the initial count in badge-up.
    // Let's rely on the first ajax to sync.

    // Attempt to get initial count from DOM if possible, otherwise first ajax will set it.
    let initialBadge = $('.dropdown-notification .badge-up').text();
    if (initialBadge) {
        lastCount = parseInt(initialBadge);
    }

    setInterval(function () {
        $.ajax({
            url: window.location.origin + '/admin/notifications/latest',
            type: 'GET',
            success: function (response) {
                let currentCount = parseInt(response.count);

                // Check if count increased (new order)
                if (lastCount !== -1 && currentCount > lastCount) {
                    let diff = currentCount - lastCount;
                    // Show Red Alert (Error style) for 1 minute
                    toastr.success('يوجد ' + diff + ' طلبات جديدة بحاجة للتأكيد!', 'تنبيه طلب جديد', {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right", // or top-left depending on RTL
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "60000", // 1 minute
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });

                    // Optional: Play sound
                    // var audio = new Audio('/admin/sounds/notification.mp3');
                    // audio.play().catch(e => console.log('Audio play failed', e));
                }


                // Update Badge
                if (currentCount !== lastCount) {
                    $('.dropdown-notification .badge-up').text(response.count);
                    $('.dropdown-notification .dropdown-header h3').text(response.count + ' New');
                    $('.dropdown-notification .media-list').html(response.html);
                    lastCount = currentCount;
                }
            }
        });
    }, 10000); // Check every 10 seconds
});
