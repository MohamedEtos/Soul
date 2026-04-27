<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FabrictypeController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\OrdersController as StoreOrdersController; ;

use App\Http\Controllers\CartController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController as StoreProductController;
use App\Http\Controllers\ShapingCoastController;
use Illuminate\Support\Facades\Route;
use App\Models\Orders;


// =============  Front Store =================


    Route::get('/', [IndexController::class, 'index'])->name('home');
    Route::get('/product', [StoreProductController::class, 'index'])->name('product');
    Route::get('/product/{product:slug}', [StoreProductController::class, 'show'])->name('product.show');
    Route::post('/review/store', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
    Route::post('/message/store', [\App\Http\Controllers\MessageController::class, 'store'])->name('message.store');





// ===============  Cart =================


Route::prefix('cart')->name('cart.')->middleware('throttle:60,1')->group(function () {
    Route::get('/', [CartController::class, 'show'])->name('show');              // GET  /cart
    Route::post('/add', [CartController::class, 'add'])->name('add');            // POST /cart/add
    Route::patch('/update', [CartController::class, 'update'])->name('update');  // PATCH /cart/update
    Route::delete('/remove', [CartController::class, 'remove'])->name('remove'); // DELETE /cart/remove
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');    // DELETE /cart/clear
});
Route::post('/prossesCart', [CartController::class, 'prossesCart'])->name('prossesCart');
Route::get('shopingcart', [CartController::class, 'shopingcart'])->name('shopingcart');
Route::patch('/cart/governorate', [CartController::class, 'setGovernorate'])->name('cart.governorate');
// Route::get('sucess_order', [CartController::class, 'sucess_order'])->name('sucess_order');

// Route::get('sucess_order', function () {

//     if (!session()->has('can_view_success')) {
//         abort(404);
//     }

//     $order = Orders::findOrFail(session('success_order_id'));

//     session()->forget(['can_view_success', 'success_order_id']);

//     return view('store.successOrder', compact('order'));
// })->name('sucess_order');


Route::get('sucess_order', [StoreOrdersController::class, 'success'])
    ->name('sucess_order');


// =============== Addmin Routes =================

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::controller(ShapingCoastController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/shaping_coast', 'index')->name('shaping_coast');
    Route::post('/shaping_coast/{id}/toggle-free-shipping', 'toggleFreeShipping')->name('toggle_free_shipping');
    Route::post('/shaping_coast/{id}/update-shipping-cost', 'updateShippingCost')->name('update_shipping_cost');
    Route::post('/shaping_coast/store', 'store')->name('store_shaping_coast');
    Route::post('/shaping_coast/delete/{id}', 'destroy')->name('delete_shaping_coast');
});

Route::controller(CategoryController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/Categorylist', 'index')->name('Categorylist');
    Route::post('/add_Category', 'create')->name('add_Category');
    Route::post('/updateCat/{id}', 'updateCat')->name('updateCat');
    Route::post('/DelCat/{id}', 'DelCat')->name('DelCat');

});

Route::controller(ProductController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/productList', 'index')->name('productList');
    Route::post('/add_product', 'create')->name('add_product');
    Route::post('/edit_product/{productId}', 'edit_product')->name('edit_product');
    Route::post('/destroy/{productId}', 'destroy')->name('destroy');
    Route::post('/toggle_status/{id}', 'toggleStatus')->name('product.toggle_status');
    Route::post('/multideleteProducts', 'multideleteProducts')->name('multideleteProducts');
});

Route::controller(VisitorController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/visitorsList', 'index')->name('visitorsList');
    Route::get('/visitorsActivities', 'activities')->name('visitorsActivities');
    Route::post('/visitorsActivities/store', 'storeActivity')->name('storeVisitorActivity');
});

Route::controller(SettingController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/setting', 'index')->name('setting');
    Route::post('/setting/update', 'update')->name('setting.update');

});

Route::controller(\App\Http\Controllers\Admin\ErrorLogController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/errors', 'index')->name('admin.errors.index');
    Route::get('/errors/delete/{id}', 'destroy')->name('admin.errors.destroy');
    Route::post('/errors/clear', 'clear')->name('admin.errors.clear');
});

Route::controller(FabricTypeController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/fabricList', 'index')->name('fabricList');
    Route::post('/add_fabric', 'create')->name('add_fabric');
    Route::post('/updateFabric/{id}', 'updateFabric')->name('updateFabric');
    Route::post('/fabric/destroy/{id}', 'destroy')->name('fabric.destroy');

});

Route::controller(OrdersController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('Orders', 'index')->name('Orders');
    Route::get('notifications/latest', 'latestNotifications')->name('admin.notifications.latest');
    Route::get('/Orders/{id}/price', 'GetProductInfo')->name('GetProductInfo');
    Route::post('Send_whatsapp', 'Send_whatsapp')->name('Send_whatsapp');
    Route::post('StoreOrder', 'StoreOrder')->name('StoreOrder');
    Route::post('multideleteOrders', 'multideleteOrders')->name('multideleteOrders');
    Route::post('/destroyOrder/{productId}', 'destroyOrder')->name('destroyOrder');
});

Route::controller(\App\Http\Controllers\Admin\ReviewController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/reviews', 'index')->name('admin.reviews.index');
    Route::post('/reviews/status/{review}', 'updateStatus')->name('admin.reviews.updateStatus');
    Route::delete('/reviews/{review}', 'destroy')->name('admin.reviews.destroy');
});

Route::controller(\App\Http\Controllers\Admin\MessageController::class)->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/messages', 'index')->name('admin.messages.index');
    Route::delete('/messages/{id}', 'destroy')->name('admin.messages.destroy');
});



require __DIR__.'/auth.php';
