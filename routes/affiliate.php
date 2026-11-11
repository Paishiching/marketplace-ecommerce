<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Affiliate\DashboardController;
use App\Http\Controllers\Affiliate\ProfileController;
use App\Http\Controllers\Affiliate\ProductController;
use App\Http\Controllers\Affiliate\LinkController;
use App\Http\Controllers\Affiliate\ClickController;
use App\Http\Controllers\Affiliate\SaleController;
use App\Http\Controllers\Affiliate\CommissionController;
use App\Http\Controllers\Affiliate\EarningController;
use App\Http\Controllers\Affiliate\WithdrawalController;
use App\Http\Controllers\Affiliate\CampaignController;
use App\Http\Controllers\Affiliate\ReportController;
use App\Http\Controllers\Affiliate\NotificationController;
use App\Http\Controllers\Partner\PartnerAuthController;
use App\Http\Controllers\Frontend\PartnerRegistrationController;

Route::get('affiliate/login', [PartnerAuthController::class, 'showLogin'])->defaults('type', 'affiliate')->name('affiliate.login');
Route::post('affiliate/login', [PartnerAuthController::class, 'login'])->defaults('type', 'affiliate')->middleware('throttle:partner-login')->name('affiliate.login.submit');
Route::post('affiliate/logout', [PartnerAuthController::class, 'logout'])->defaults('type', 'affiliate')->middleware(['auth', 'role:affiliate'])->name('affiliate.logout');
Route::get('affiliate/register', [PartnerRegistrationController::class, 'create'])->defaults('type', 'affiliate')->name('affiliate.register');
Route::post('affiliate/register', [PartnerRegistrationController::class, 'store'])->defaults('type', 'affiliate')->middleware('throttle:partner-register')->name('affiliate.register.submit');

Route::prefix('affiliate')->name('affiliate.')->middleware(['auth', 'partner.approved:affiliate'])->group(function () {
    Route::get('dashboards', [DashboardController::class, 'index'])->name('dashboards');
    Route::get('profiles', [ProfileController::class, 'index'])->name('profiles');
    Route::resource('products', ProductController::class)->names('products');
    Route::get('links', [LinkController::class, 'index'])->name('links');
    Route::get('clicks', [ClickController::class, 'index'])->name('clicks');
    Route::get('sales', [SaleController::class, 'index'])->name('sales');
    Route::resource('commissions', CommissionController::class)->names('commissions');
    Route::get('earnings', [EarningController::class, 'index'])->name('earnings');
    Route::resource('withdrawals', WithdrawalController::class)->names('withdrawals');
    Route::resource('campaigns', CampaignController::class)->names('campaigns');
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::resource('notifications', NotificationController::class)->names('notifications');
});
