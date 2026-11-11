<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\ShopController;
use App\Http\Controllers\Vendor\Products\ProductController;
use App\Http\Controllers\Vendor\Products\VariantController;
use App\Http\Controllers\Vendor\Products\InventoryController;
use App\Http\Controllers\Vendor\Products\SupplierProductController;
use App\Http\Controllers\Vendor\Products\ImportProductController;
use App\Http\Controllers\Vendor\Products\ImportExportController;
use App\Http\Controllers\Vendor\Orders\OrderController as OrdersOrderController;
use App\Http\Controllers\Vendor\Orders\OrderItemController;
use App\Http\Controllers\Vendor\Orders\ShipmentController;
use App\Http\Controllers\Vendor\Orders\TrackingController as OrdersTrackingController;
use App\Http\Controllers\Vendor\Orders\ReturnController;
use App\Http\Controllers\Vendor\Orders\RefundController;
use App\Http\Controllers\Vendor\Dropshipping\DashboardController as DropshippingDashboardController;
use App\Http\Controllers\Vendor\Dropshipping\SupplierController;
use App\Http\Controllers\Vendor\Dropshipping\ProductController as DropshippingProductController;
use App\Http\Controllers\Vendor\Dropshipping\ImportController;
use App\Http\Controllers\Vendor\Dropshipping\SyncController;
use App\Http\Controllers\Vendor\Dropshipping\OrderController as DropshippingOrderController;
use App\Http\Controllers\Vendor\Dropshipping\FulfillmentController;
use App\Http\Controllers\Vendor\Dropshipping\TrackingController as DropshippingTrackingController;
use App\Http\Controllers\Vendor\Dropshipping\ProfitController;
use App\Http\Controllers\Vendor\Wholesale\ProductController as WholesaleProductController;
use App\Http\Controllers\Vendor\Wholesale\PricingController;
use App\Http\Controllers\Vendor\Wholesale\BulkOrderController;
use App\Http\Controllers\Vendor\Wholesale\OrderController as WholesaleOrderController;
use App\Http\Controllers\Vendor\Finance\EarningController;
use App\Http\Controllers\Vendor\Finance\BalanceController;
use App\Http\Controllers\Vendor\Finance\TransactionController;
use App\Http\Controllers\Vendor\Finance\WithdrawalController;
use App\Http\Controllers\Vendor\Marketing\CouponController;
use App\Http\Controllers\Vendor\Marketing\CampaignController;
use App\Http\Controllers\Vendor\Marketing\PromotionController;
use App\Http\Controllers\Vendor\Reviews\ReviewController;
use App\Http\Controllers\Vendor\Reviews\RatingController;
use App\Http\Controllers\Vendor\NotificationController;
use App\Http\Controllers\Vendor\AuthController as VendorAuthController;
use App\Http\Controllers\Frontend\PartnerRegistrationController;

// Vendor account entry points use the shared web guard and role-based access.
Route::get('vendor/login', [VendorAuthController::class, 'showLogin'])->name('vendor.login');
Route::post('vendor/login', [VendorAuthController::class, 'login'])->middleware('throttle:vendor-login')->name('vendor.login.submit');
Route::post('vendor/logout', [VendorAuthController::class, 'logout'])->middleware(['auth', 'role:vendor'])->name('vendor.logout');
Route::get('vendor/register', [PartnerRegistrationController::class, 'create'])->defaults('type', 'vendor')->name('vendor.register');
Route::post('vendor/register', [PartnerRegistrationController::class, 'store'])->defaults('type', 'vendor')->middleware('throttle:vendor-register')->name('vendor.register.submit');

Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('dashboards', [DashboardController::class, 'index'])->name('dashboards');
    Route::get('categories/{category}/subcategories', [ProductController::class, 'subCategories'])->name('categories.subcategories');

    // Profile
    Route::get('profiles', [ProfileController::class, 'index'])->name('profiles');
    Route::put('profiles', [ProfileController::class, 'update'])->name('profiles.update');
    Route::put('profiles/password', [ProfileController::class, 'updatePassword'])->name('profiles.password.update');

    // Shop
    Route::get('shops', [ShopController::class, 'index'])->name('shops');
    Route::put('shops', [ShopController::class, 'update'])->name('shops.update');


    // Products
    Route::resource('products/products', ProductController::class)->names('products.products');
   
    Route::get('products/variants', [VariantController::class, 'index'])->name('products.variants');
       Route::post('products/variants/attributes/{attribute}/values', [VariantController::class, 'storeValue'])->name('products.variants.values.store');
    Route::resource('products/inventories', InventoryController::class)->only(['index', 'update'])->names('products.inventories');
    Route::resource('products/supplier-products', SupplierProductController::class)->names('products.supplier-products');
    Route::get('products/import-products', [ImportProductController::class, 'index'])->name('products.import-products');
    Route::get('products/import-exports', [ImportExportController::class, 'index'])->name('products.import-exports');

    // Orders
    Route::resource('orders/orders', OrdersOrderController::class)->only(['index', 'show'])->names('orders.orders');
    Route::resource('orders/order-items', OrderItemController::class)->names('orders.order-items');
    Route::resource('orders/shipments', ShipmentController::class)->only(['index'])->names('orders.shipments');
    Route::get('orders/trackings', [OrdersTrackingController::class, 'index'])->name('orders.trackings');
    Route::get('orders/returns', [ReturnController::class, 'index'])->name('orders.returns');
    Route::resource('orders/refunds', RefundController::class)->only(['index'])->names('orders.refunds');
    
    // Dropshipping
    Route::get('dropshipping/dashboards', [DropshippingDashboardController::class, 'index'])->name('dropshipping.dashboards');
    Route::resource('dropshipping/suppliers', SupplierController::class)->names('dropshipping.suppliers');
    Route::resource('dropshipping/products', DropshippingProductController::class)->names('dropshipping.products');
    Route::get('dropshipping/imports', [ImportController::class, 'index'])->name('dropshipping.imports');
    Route::get('dropshipping/syncs', [SyncController::class, 'index'])->name('dropshipping.syncs');
    Route::resource('dropshipping/orders', DropshippingOrderController::class)->names('dropshipping.orders');
    Route::get('dropshipping/fulfillments', [FulfillmentController::class, 'index'])->name('dropshipping.fulfillments');
    Route::get('dropshipping/trackings', [DropshippingTrackingController::class, 'index'])->name('dropshipping.trackings');
    Route::get('dropshipping/profits', [ProfitController::class, 'index'])->name('dropshipping.profits');

    // Wholesale
    Route::resource('wholesale/products', WholesaleProductController::class)->names('wholesale.products');
    Route::get('wholesale/pricings', [PricingController::class, 'index'])->name('wholesale.pricings');
    Route::resource('wholesale/bulk-orders', BulkOrderController::class)->names('wholesale.bulk-orders');
    Route::resource('wholesale/orders', WholesaleOrderController::class)->names('wholesale.orders');

    // Finance
    Route::get('finance/earnings', [EarningController::class, 'index'])->name('finance.earnings');
    Route::get('finance/balances', [BalanceController::class, 'index'])->name('finance.balances');
    Route::resource('finance/transactions', TransactionController::class)->names('finance.transactions');
       Route::resource('finance/transactions', TransactionController::class)->only(['index'])->names('finance.transactions');
    Route::resource('finance/withdrawals', WithdrawalController::class)->only(['index', 'store'])->names('finance.withdrawals');

    // Marketing
    Route::resource('marketing/coupons', CouponController::class)->names('marketing.coupons');
    Route::resource('marketing/campaigns', CampaignController::class)->names('marketing.campaigns');
    Route::resource('marketing/promotions', PromotionController::class)->names('marketing.promotions');
    Route::resource('finance/transactions', TransactionController::class)->only(['index'])->names('finance.transactions');
    // Reviews & Notifications
    Route::resource('reviews/reviews', ReviewController::class)->names('reviews.reviews');
    Route::resource('reviews/ratings', RatingController::class)->names('reviews.ratings');
    Route::resource('notifications', NotificationController::class)->names('notifications');
});
