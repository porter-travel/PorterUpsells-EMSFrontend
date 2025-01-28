<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FulfilmentController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelEmailController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResDiaryController;
use App\Http\Controllers\WelcomeController;
use App\Models\Hotel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/submit-contact-form',[WelcomeController::class, 'submit_form'] )->name('welcome.submit-form');

Route::get('/hotel/{id}/welcome', [HotelController::class, 'welcome'] )->name('hotel.welcome');

Route::post('/createSession', [WelcomeController::class, 'createSession']);

Route::get('/hotel/{id}/dashboard', function($id){
    return redirect()->route('hotel.dashboard', ['id' => $id]);
})->name('hotel.dashboard-old');

Route::post('/set-user-stay-dates', [WelcomeController::class, 'setUserStayDates']);

Route::get('/hotel/{id}/', [HotelController::class, 'dashboard'] )->name('hotel.dashboard');
Route::get('/hotel/{hotel_id}/item/{item_id}', [ProductController::class, 'show'] )->name('hotel.item');
Route::get('/hotel/{hotel_id}/cart', [CartController::class, 'show'] )->name('cart.show');

Route::post('/cart/add', [CartController::class, 'addToCart'] )->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'] )->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'updateCartQty'] )->name('cart.update');

Route::get('/checkout/initiate/{hotel_id}', [CheckoutController::class, 'initiateCheckout'] )->name('checkout.initiate');
Route::get('/checkout/complete', [CheckoutController::class, 'checkoutComplete'] )->name('checkout.complete');
Route::get('/checkout/cancelled', [CheckoutController::class, 'checkoutCancelled'] )->name('checkout.cancelled');

Route::post('/checkout/stripe/checkoutSessionWebhook', [CheckoutController::class, 'checkoutSessionWebhook'] )->name('checkout.webhook');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/fulfilment/{key}', [FulfilmentController::class, 'fulfilment'])->name('fulfilment');
Route::post('/fulfil-order/', [FulfilmentController::class, 'fulfilOrder'])->name('fulfil-order');

Route::post('/resdiary/get-availability', [ResDiaryController::class, 'getAvailability'])->name('resdiary.get-availability');

Route::post('/get-times-available-for-calendar-products', [ProductController::class, 'getTimesAvailableForCalendarProducts'])->name('get-times-available-for-calendar-products');


Route::get('/view-customer-email', function(){
    $hotel = Hotel::find(1);
//    dd($hotel);
    return view('email.customer-email', ['hotel' => $hotel]);
});
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::post('admin/hotel/create', [HotelController::class, 'store'] )->name('hotel.store');
    Route::get('admin/hotel/create', [HotelController::class, 'create'] )->name('hotel.create');

    Route::get('admin/hotel/{id}/edit', [HotelController::class, 'edit'] )->name('hotel.edit');
    Route::post('admin/hotel/{id}/update', [HotelController::class, 'update'] )->name('hotel.update');

    Route::get('admin/hotel/{id}/product/create/{type?}', [ProductController::class, 'create'] )->name('product.create');
    Route::get('admin/hotel/{hotel_id}/product/{product_id}/edit', [ProductController::class, 'edit'] )->name('product.edit');
    Route::post('admin/hotel/{hotel_id}/product/{product_id}/delete', [ProductController::class, 'softDeleteProduct'] )->name('product.delete');
    Route::post('admin/hotel/{hotel_id}/list-products-as-json', [ProductController::class, 'listProductsAsJson'] )->name('product.list-as-json');
    Route::post('admin/product/{product_id}/get-as-json', [ProductController::class, 'getProductAsJson'] )->name('product.get-as-json');

    Route::get('admin/hotel/{hotel_id}/orders', [\App\Http\Controllers\OrderController::class, 'listOrdersByHotel'] )->name('orders.list');
    Route::get('admin/hotel/{hotel_id}/order-pick-list', [\App\Http\Controllers\OrderController::class, 'listOrderItemsForPicking'] )->name('orders.listItemsForPicking');

    Route::post('admin/order-item/{id}/update', [\App\Http\Controllers\OrderItemController::class, 'update'] )->name('orderItem.update');
    Route::post('admin/product/store', [ProductController::class, 'store'] )->name('product.store');
    Route::post('admin/product/update', [ProductController::class, 'update'] )->name('product.update');

    Route::get('admin/hotel/{id}/create-booking', [\App\Http\Controllers\BookingController::class, 'create'] )->name('booking.create');
    Route::post('admin/hotel/{id}/store-booking', [\App\Http\Controllers\BookingController::class, 'store'] )->name('booking.store');
    Route::get('admin/hotel/{id}/list-bookings', [\App\Http\Controllers\BookingController::class, 'list'] )->name('bookings.list');
    Route::post('admin/booking/{booking_id}/update', [\App\Http\Controllers\BookingController::class, 'updateBooking'] )->name('booking.update');
    Route::post('admin/hotel/{hotel_id}/fetch-bookings-by-date', [\App\Http\Controllers\BookingController::class, 'fetchBookingsByDate'] )->name('booking.fetch-by-date');


    Route::get('admin/hotel/{id}/calendar', [\App\Http\Controllers\CalendarBookingController::class, 'list'] )->name('calendar.list');
    Route::get('admin/hotel/{id}/calendar/product-grid', [\App\Http\Controllers\CalendarBookingController::class, 'listProductGrid'] )->name('calendar.list-product-grid');
    Route::get('admin/hotel/{hotel_id}/calendar/{product_id}', [\App\Http\Controllers\CalendarBookingController::class, 'listBookingsForProduct'] )->name('calendar.list-bookings-for-product');
    Route::post('admin/hotel/{hotel_id}/calendar/{product_id}/store-booking', [\App\Http\Controllers\CalendarBookingController::class, 'storeBooking'] )->name('calendar.store-booking');
    Route::post('admin/update-booking', [\App\Http\Controllers\CalendarBookingController::class, 'updateBooking'] )->name('calendar.update-booking');
    Route::post('admin/delete-booking', [\App\Http\Controllers\CalendarBookingController::class, 'deleteBooking'] )->name('calendar.delete-booking');
    Route::post('admin/calendar/{product_id}/get-future-availability-on-same-day', ['\App\Http\Controllers\CalendarBookingController', 'getFutureAvailabilityOnSameDayForProduct'])->name('calendar.get-future-availability-on-same-day');

    Route::post('/admin/hotel/{id}/email/send-customer-email', [\App\Http\Controllers\CustomerEmailController::class, 'send'] )->name('email.send');

    Route::post('/admin/create-connected-account', [\App\Http\Controllers\StripeController::class, 'create_connected_account'])->name('connected-account.create');
    Route::get('/admin/create-connected-account/return', [\App\Http\Controllers\StripeController::class, 'return_connected_account'])->name('connected-account.return');
    Route::get('/admin/create-connected-account/refresh', [\App\Http\Controllers\StripeController::class, 'refresh_connected_account'])->name('connected-account.refresh');

    Route::get('/admin/fulfilment-keys/list', [\App\Http\Controllers\FulfilmentKeyController::class, 'list'])->name('fulfilment-keys.list');
    Route::get('/admin/fulfilment-keys/create', [\App\Http\Controllers\FulfilmentKeyController::class, 'create'])->name('fulfilment-keys.create');
    Route::post('/admin/fulfilment-keys/store', [\App\Http\Controllers\FulfilmentKeyController::class, 'store'])->name('fulfilment-keys.store');
    Route::get('/admin/fulfilment-keys/{id}/edit', [\App\Http\Controllers\FulfilmentKeyController::class, 'edit'])->name('fulfilment-keys.edit');
    Route::post('/admin/fulfilment-keys/{id}/update', [\App\Http\Controllers\FulfilmentKeyController::class, 'update'])->name('fulfilment-keys.update');
    Route::delete('/admin/fulfilment-keys/{key}/delete', [\App\Http\Controllers\FulfilmentKeyController::class, 'delete'])->name('fulfilment-keys.delete');

    Route::post('/admin/order/update/', [\App\Http\Controllers\OrderController::class, 'updateOrder'])->name('order.update');

    Route::post('/admin/product/{id}/unavailability/store', [\App\Http\Controllers\UnavailabilityController::class, 'store'])->name('unavailability.store');
    Route::get('/admin/unavailability/{id}/delete', [\App\Http\Controllers\UnavailabilityController::class, 'delete'])->name('unavailability.delete');

    Route::get('/resdiary/install', [ResDiaryController::class, 'install'])->name('resdiary.install');
    Route::get('/resdiary/callback', [ResDiaryController::class, 'callback'])->name('resdiary.callback');
    Route::post('/resdiary/set-hotel', [ResDiaryController::class, 'setHotel'])->name('resdiary.set-hotel');

    Route::get('/admin/performance/{hotel_id?}', [PerformanceController::class, 'index'])->name('performance.index');

    Route::get('/admin/hotel/{id}/email/customise', [HotelEmailController::class, 'show'])->name('email.customise');
    Route::post('/admin/hotel/{hotel_id}/email/store-customisations', [HotelEmailController::class, 'storeCustomisations'])->name('email.store-customisations');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
