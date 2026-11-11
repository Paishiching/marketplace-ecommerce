<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\VendorController;
use App\Http\Controllers\Api\V1\SupplierController;
use App\Http\Controllers\Api\V1\AffiliateController;
use App\Http\Controllers\Api\V1\DropshippingController;
use App\Http\Controllers\Api\V1\ResellerController;
use App\Http\Controllers\Api\V1\WholesaleController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ShipmentController;
use App\Http\Controllers\Api\V1\TrackingController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\WishlistController;
use App\Http\Controllers\Api\V1\CouponController;
use App\Http\Controllers\Api\V1\NotificationController;

Route::group([], function () {
    Route::get('v1/auths', [AuthController::class, 'index'])->name('v1.auths');
    Route::apiResource('v1/users', UserController::class)->names('v1.users');
    Route::apiResource('v1/products', ProductController::class)->names('v1.products');
    Route::apiResource('v1/categories', CategoryController::class)->names('v1.categories');
    Route::apiResource('v1/brands', BrandController::class)->names('v1.brands');
    Route::apiResource('v1/vendors', VendorController::class)->names('v1.vendors');
    Route::apiResource('v1/suppliers', SupplierController::class)->names('v1.suppliers');
    Route::apiResource('v1/affiliates', AffiliateController::class)->names('v1.affiliates');
    Route::get('v1/dropshippings', [DropshippingController::class, 'index'])->name('v1.dropshippings');
    Route::apiResource('v1/resellers', ResellerController::class)->names('v1.resellers');
    Route::get('v1/wholesales', [WholesaleController::class, 'index'])->name('v1.wholesales');
    Route::apiResource('v1/carts', CartController::class)->names('v1.carts');
    Route::get('v1/checkouts', [CheckoutController::class, 'index'])->name('v1.checkouts');
    Route::apiResource('v1/orders', OrderController::class)->names('v1.orders');
    Route::apiResource('v1/payments', PaymentController::class)->names('v1.payments');
    Route::apiResource('v1/shipments', ShipmentController::class)->names('v1.shipments');
    Route::get('v1/trackings', [TrackingController::class, 'index'])->name('v1.trackings');
    Route::apiResource('v1/reviews', ReviewController::class)->names('v1.reviews');
    Route::apiResource('v1/wishlists', WishlistController::class)->names('v1.wishlists');
    Route::apiResource('v1/coupons', CouponController::class)->names('v1.coupons');
    Route::apiResource('v1/notifications', NotificationController::class)->names('v1.notifications');
});
