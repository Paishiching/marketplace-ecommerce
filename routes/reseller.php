<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reseller\DashboardController;
use App\Http\Controllers\Reseller\ProfileController;
use App\Http\Controllers\Reseller\ProductController;
use App\Http\Controllers\Reseller\PricingController;
use App\Http\Controllers\Reseller\OrderController;
use App\Http\Controllers\Reseller\CustomerController;
use App\Http\Controllers\Reseller\EarningController;
use App\Http\Controllers\Reseller\BalanceController;
use App\Http\Controllers\Reseller\WithdrawalController;
use App\Http\Controllers\Reseller\NotificationController;
use App\Http\Controllers\Partner\PartnerAuthController;
use App\Http\Controllers\Frontend\PartnerRegistrationController;

Route::get('reseller/login', [PartnerAuthController::class, 'showLogin'])->defaults('type', 'reseller')->name('reseller.login');
Route::post('reseller/login', [PartnerAuthController::class, 'login'])->defaults('type', 'reseller')->middleware('throttle:partner-login')->name('reseller.login.submit');
Route::post('reseller/logout', [PartnerAuthController::class, 'logout'])->defaults('type', 'reseller')->middleware(['auth', 'role:reseller'])->name('reseller.logout');
Route::get('reseller/register', [PartnerRegistrationController::class, 'create'])->defaults('type', 'reseller')->name('reseller.register');
Route::post('reseller/register', [PartnerRegistrationController::class, 'store'])->defaults('type', 'reseller')->middleware('throttle:partner-register')->name('reseller.register.submit');

Route::prefix('reseller')->name('reseller.')->middleware(['auth', 'partner.approved:reseller'])->group(function () {
    Route::get('dashboards', [DashboardController::class, 'index'])->name('dashboards');
    Route::get('profiles', [ProfileController::class, 'index'])->name('profiles');
    Route::resource('products', ProductController::class)->names('products');
    Route::get('pricings', [PricingController::class, 'index'])->name('pricings');
    Route::resource('orders', OrderController::class)->names('orders');
    Route::resource('customers', CustomerController::class)->names('customers');
    Route::get('earnings', [EarningController::class, 'index'])->name('earnings');
    Route::get('balances', [BalanceController::class, 'index'])->name('balances');
    Route::resource('withdrawals', WithdrawalController::class)->names('withdrawals');
    Route::resource('notifications', NotificationController::class)->names('notifications');
});
