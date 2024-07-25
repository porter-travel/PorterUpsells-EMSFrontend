<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Models\Hotel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hotel/{id}/welcome', [\App\Http\Controllers\HotelController::class, 'welcome'] )->name('hotel.welcome');

Route::post('/createSession', [WelcomeController::class, 'createSession']);

Route::get('/hotel/{id}/dashboard', [\App\Http\Controllers\HotelController::class, 'dashboard'] )->name('hotel.dashboard');

Route::get('/hotel/{hotel_id}/item/{item_id}', [\App\Http\Controllers\ProductController::class, 'show'] )->name('hotel.item');

Route::get('/hotel/{hotel_id}/cart', [\App\Http\Controllers\CartController::class, 'show'] )->name('cart.show');

Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'addToCart'] )->name('cart.add');
Route::post('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'removeFromCart'] )->name('cart.remove');
Route::post('/cart/update/{id}', [\App\Http\Controllers\CartController::class, 'updateCartQty'] )->name('cart.update');

Route::get('/checkout/initiate/{hotel_id}', [\App\Http\Controllers\CheckoutController::class, 'initiateCheckout'] )->name('checkout.initiate');
Route::get('/checkout/complete', [\App\Http\Controllers\CheckoutController::class, 'checkoutComplete'] )->name('checkout.complete');
Route::get('/checkout/cancelled', [\App\Http\Controllers\CheckoutController::class, 'checkoutCancelled'] )->name('checkout.cancelled');

Route::post('/checkout/stripe/checkoutSessionWebhook', [\App\Http\Controllers\CheckoutController::class, 'checkoutSessionWebhook'] )->name('checkout.webhook');

Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/view-customer-email', function(){
    $hotel = Hotel::find(1);
//    dd($hotel);
    return view('email.customer-email', ['hotel' => $hotel]);
});
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');

    Route::post('admin/hotel/create', [\App\Http\Controllers\HotelController::class, 'store'] )->name('hotel.store');
    Route::get('admin/hotel/create', [\App\Http\Controllers\HotelController::class, 'create'] )->name('hotel.create');

    Route::get('admin/hotel/{id}/edit', [\App\Http\Controllers\HotelController::class, 'edit'] )->name('hotel.edit');
    Route::post('admin/hotel/{id}/update', [\App\Http\Controllers\HotelController::class, 'update'] )->name('hotel.update');

    Route::get('admin/hotel/{id}/product/create', [\App\Http\Controllers\ProductController::class, 'create'] )->name('product.create');
    Route::get('admin/hotel/{hotel_id}/product/{product_id}/edit', [\App\Http\Controllers\ProductController::class, 'edit'] )->name('product.edit');

    Route::get('admin/hotel/{hotel_id}/orders', [\App\Http\Controllers\OrderController::class, 'listOrdersByHotel'] )->name('orders.list');
    Route::get('admin/hotel/{hotel_id}/order-pick-list', [\App\Http\Controllers\OrderController::class, 'listOrderItemsForPicking'] )->name('orders.listItemsForPicking');

    Route::post('admin/order-item/{id}/update', [\App\Http\Controllers\OrderItemController::class, 'update'] )->name('orderItem.update');
    Route::post('admin/product/store', [\App\Http\Controllers\ProductController::class, 'store'] )->name('product.store');
    Route::post('admin/product/update', [\App\Http\Controllers\ProductController::class, 'update'] )->name('product.update');

    Route::get('admin/hotel/{id}/create-booking', [\App\Http\Controllers\BookingController::class, 'create'] )->name('booking.create');
    Route::post('admin/hotel/{id}/store-booking', [\App\Http\Controllers\BookingController::class, 'store'] )->name('booking.store');
    Route::get('admin/hotel/{id}/list-bookings', [\App\Http\Controllers\BookingController::class, 'list'] )->name('bookings.list');

    Route::post('/admin/hotel/{id}/email/send-customer-email', [\App\Http\Controllers\CustomerEmailController::class, 'send'] )->name('email.send');

    Route::post('/admin/create-connected-account', [\App\Http\Controllers\StripeController::class, 'create_connected_account'])->name('connected-account.create');
    Route::get('/admin/create-connected-account/return', [\App\Http\Controllers\StripeController::class, 'return_connected_account'])->name('connected-account.return');
    Route::get('/admin/create-connected-account/refresh', [\App\Http\Controllers\StripeController::class, 'refresh_connected_account'])->name('connected-account.refresh');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
