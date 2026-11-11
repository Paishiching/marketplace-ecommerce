<?php

use App\Http\Controllers\Frontend\PartnerRegistrationController;
use App\Http\Controllers\Partner\PartnerAuthController;
use App\Http\Controllers\Partner\PartnerSettingsController;
use App\Http\Controllers\Wholesale\DashboardController;
use App\Http\Controllers\Wholesale\ProductController;
use App\Http\Controllers\Wholesale\OrderController;
use App\Http\Controllers\Wholesale\TierController;
use Illuminate\Support\Facades\Route;

Route::get('wholesale/login', [PartnerAuthController::class, 'showLogin'])->defaults('type', 'wholesale')->name('wholesale.login');
Route::post('wholesale/login', [PartnerAuthController::class, 'login'])->defaults('type', 'wholesale')->middleware('throttle:partner-login')->name('wholesale.login.submit');
Route::get('wholesale/register', [PartnerRegistrationController::class, 'create'])->defaults('type', 'wholesale')->name('wholesale.register');
Route::post('wholesale/register', [PartnerRegistrationController::class, 'store'])->defaults('type', 'wholesale')->middleware('throttle:partner-register')->name('wholesale.register.submit');
Route::post('wholesale/logout', [PartnerAuthController::class, 'logout'])->defaults('type', 'wholesale')->middleware(['auth', 'role:wholesale'])->name('wholesale.logout');

Route::prefix('wholesale')->name('wholesale.')->middleware(['auth', 'partner.approved:wholesale'])->group(function () {
    Route::get('dashboards', [DashboardController::class, 'index'])->name('dashboards');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::patch('products/{product}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('tiers', [TierController::class, 'index'])->name('tiers.index');
    Route::post('tiers', [TierController::class, 'store'])->name('tiers.store');
    Route::delete('tiers/{tier}', [TierController::class, 'destroy'])->name('tiers.destroy');
    Route::get('settings', [PartnerSettingsController::class, 'edit'])->defaults('type', 'wholesale')->name('settings');
    Route::put('settings', [PartnerSettingsController::class, 'update'])->defaults('type', 'wholesale')->name('settings.update');
});
