<?php

use App\Http\Controllers\Frontend\PartnerRegistrationController;
use App\Http\Controllers\Partner\PartnerAuthController;
use App\Http\Controllers\Partner\PartnerSettingsController;
use App\Http\Controllers\Dropshipping\DashboardController;
use App\Http\Controllers\Dropshipping\ProductController;
use App\Http\Controllers\Dropshipping\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('dropshipping/login', [PartnerAuthController::class, 'showLogin'])->defaults('type', 'dropshipping')->name('dropshipping.login');
Route::post('dropshipping/login', [PartnerAuthController::class, 'login'])->defaults('type', 'dropshipping')->middleware('throttle:partner-login')->name('dropshipping.login.submit');
Route::get('dropshipping/register', [PartnerRegistrationController::class, 'create'])->defaults('type', 'dropshipping')->name('dropshipping.register');
Route::post('dropshipping/register', [PartnerRegistrationController::class, 'store'])->defaults('type', 'dropshipping')->middleware('throttle:partner-register')->name('dropshipping.register.submit');
Route::post('dropshipping/logout', [PartnerAuthController::class, 'logout'])->defaults('type', 'dropshipping')->middleware(['auth', 'role:dropshipping'])->name('dropshipping.logout');

Route::prefix('dropshipping')->name('dropshipping.')->middleware(['auth', 'partner.approved:dropshipping'])->group(function () {
    Route::get('dashboards', [DashboardController::class, 'index'])->name('dashboards');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::patch('products/{product}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('settings', [PartnerSettingsController::class, 'edit'])->defaults('type', 'dropshipping')->name('settings');
    Route::put('settings', [PartnerSettingsController::class, 'update'])->defaults('type', 'dropshipping')->name('settings.update');
});
