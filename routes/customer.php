<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\RfqController;
use App\Http\Controllers\Customer\NewOrderController;

/*
|--------------------------------------------------------------------------
| Customer routes
|--------------------------------------------------------------------------
| Controller : app/Http/Controllers/Customer
| Views      : resources/views/customer
| Notun customer feature (return, refund, review...) ekhane add korben.
|--------------------------------------------------------------------------
*/
Route::get('/account/rfqs/create', [RfqController::class, 'create'])
    ->middleware(\App\Http\Middleware\RequireOtpLoginForRfq::class)
    ->name('customer.rfqs.create');

Route::middleware('auth')->group(function () {
    Route::get('/customer/dashboard', [AccountController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/account/new-order/search-products', [NewOrderController::class, 'searchProducts'])->name('customer.new-order.search-products');
    Route::get('/account/new-order', [NewOrderController::class, 'create'])->name('customer.new-order.create');
    Route::post('/account/new-order', [NewOrderController::class, 'store'])->name('customer.new-order.store');
    Route::resource('/account/rfqs', RfqController::class)->only(['index', 'store', 'show'])->names('customer.rfqs');
    Route::post('/account/rfqs/draft', [RfqController::class, 'draft'])->middleware('throttle:8,1')->name('customer.rfqs.draft');

    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::patch('/account/shipments/{shipment}/remark', [AccountController::class, 'updateShipmentRemark'])->name('customer.shipments.remark');

    Route::get('/account/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::get('/account/addresses/{address}/edit', [AccountController::class, 'addressEdit'])->name('account.addresses.edit');
    Route::put('/account/addresses/{address}', [AccountController::class, 'addressUpdate'])->name('account.addresses.update');
    Route::delete('/account/addresses/{address}', [AccountController::class, 'addressDestroy'])->name('account.addresses.destroy');

    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::put('/account/profile', [AccountController::class, 'profileUpdate'])->name('account.profile.update');

    Route::get('/account/password', [AccountController::class, 'password'])->name('account.password');
    Route::put('/account/password', [AccountController::class, 'passwordUpdate'])->name('account.password.update');
});
