<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Supplier\DashboardController;
use App\Http\Controllers\Supplier\ProfileController;
use App\Http\Controllers\Supplier\StoreController;
use App\Http\Controllers\Supplier\VerificationController;
use App\Http\Controllers\Supplier\Products\ProductController;
use App\Http\Controllers\Supplier\Products\VariantController;
use App\Http\Controllers\Supplier\Products\InventoryController;
use App\Http\Controllers\Supplier\Products\PricingController;
use App\Http\Controllers\Supplier\Products\ImportExportController;
use App\Http\Controllers\Supplier\Orders\OrderController;
use App\Http\Controllers\Supplier\Orders\PurchaseOrderController;
use App\Http\Controllers\Supplier\Orders\FulfillmentController;
use App\Http\Controllers\Supplier\Orders\ShipmentController;
use App\Http\Controllers\Supplier\Orders\TrackingController;
use App\Http\Controllers\Supplier\Finance\EarningController;
use App\Http\Controllers\Supplier\Finance\BalanceController;
use App\Http\Controllers\Supplier\Finance\TransactionController;
use App\Http\Controllers\Supplier\Finance\WithdrawalController;
use App\Http\Controllers\Supplier\NotificationController;
use App\Http\Controllers\Supplier\RfqController as SupplierRfqController;
use App\Http\Controllers\Partner\PartnerAuthController;
use App\Http\Controllers\Frontend\PartnerRegistrationController;

Route::get('supplier/login', [PartnerAuthController::class, 'showLogin'])->defaults('type', 'supplier')->name('supplier.login');
Route::post('supplier/login', [PartnerAuthController::class, 'login'])->defaults('type', 'supplier')->middleware('throttle:partner-login')->name('supplier.login.submit');
Route::post('supplier/logout', [PartnerAuthController::class, 'logout'])->defaults('type', 'supplier')->middleware(['auth', 'role:supplier'])->name('supplier.logout');
Route::get('supplier/register', [PartnerRegistrationController::class, 'create'])->defaults('type', 'supplier')->name('supplier.register');
Route::post('supplier/register', [PartnerRegistrationController::class, 'store'])->defaults('type', 'supplier')->middleware('throttle:partner-register')->name('supplier.register.submit');

Route::prefix('supplier')->name('supplier.')->middleware(['auth', 'partner.approved:supplier'])->group(function () {
    Route::get('dashboards', [DashboardController::class, 'index'])->name('dashboards');
    Route::get('rfqs', [SupplierRfqController::class, 'index'])->name('rfqs.index');
    Route::get('rfqs/{rfq}', [SupplierRfqController::class, 'show'])->name('rfqs.show');
    Route::post('rfqs/{rfq}/quote', [SupplierRfqController::class, 'quote'])->name('rfqs.quote');
    Route::get('profiles', [ProfileController::class, 'index'])->name('profiles');
    Route::get('stores', [StoreController::class, 'index'])->name('stores');
    Route::get('verifications', [VerificationController::class, 'index'])->name('verifications');
    Route::resource('products/products', ProductController::class)->names('products.products');
    Route::get('products/variants', [VariantController::class, 'index'])->name('products.variants');
    Route::resource('products/inventories', InventoryController::class)->names('products.inventories');
    Route::get('products/pricings', [PricingController::class, 'index'])->name('products.pricings');
    Route::get('products/import-exports', [ImportExportController::class, 'index'])->name('products.import-exports');
    Route::resource('orders/orders', OrderController::class)->names('orders.orders');
    Route::get('orders/purchase-orders', [PurchaseOrderController::class, 'index'])->name('orders.purchase-orders');
    Route::get('orders/fulfillments', [FulfillmentController::class, 'index'])->name('orders.fulfillments');
    Route::resource('orders/shipments', ShipmentController::class)->names('orders.shipments');
    Route::get('orders/trackings', [TrackingController::class, 'index'])->name('orders.trackings');
    Route::get('finance/earnings', [EarningController::class, 'index'])->name('finance.earnings');
    Route::get('finance/balances', [BalanceController::class, 'index'])->name('finance.balances');
    Route::resource('finance/transactions', TransactionController::class)->names('finance.transactions');
    Route::resource('finance/withdrawals', WithdrawalController::class)->names('finance.withdrawals');
    Route::resource('notifications', NotificationController::class)->names('notifications');
});
