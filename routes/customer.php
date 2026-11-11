<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\RfqController;

/*
|--------------------------------------------------------------------------
| Customer routes
|--------------------------------------------------------------------------
| Controller : app/Http/Controllers/Customer
| Views      : resources/views/customer
| Notun customer feature (return, refund, review...) ekhane add korben.
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/customer/dashboard', [AccountController::class, 'dashboard'])->name('customer.dashboard');
    Route::resource('/account/rfqs', RfqController::class)->only(['index', 'create', 'store', 'show'])->names('customer.rfqs');
    Route::post('/account/rfqs/draft', [RfqController::class, 'draft'])->middleware('throttle:8,1')->name('customer.rfqs.draft');

    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');

    Route::get('/account/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::delete('/account/addresses/{address}', [AccountController::class, 'addressDestroy'])->name('account.addresses.destroy');

    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::put('/account/profile', [AccountController::class, 'profileUpdate'])->name('account.profile.update');

    Route::get('/account/password', [AccountController::class, 'password'])->name('account.password');
    Route::put('/account/password', [AccountController::class, 'passwordUpdate'])->name('account.password.update');
});
