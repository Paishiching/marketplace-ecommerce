<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\VendorController;
use App\Http\Controllers\SuperAdmin\DropshipperAccountController;
use App\Http\Controllers\SuperAdmin\WholesalerAccountController;
use App\Http\Controllers\SuperAdmin\SupplierController;
use App\Http\Controllers\SuperAdmin\AffiliateController;
use App\Http\Controllers\SuperAdmin\DropshippingController;
use App\Http\Controllers\SuperAdmin\ResellerController;
use App\Http\Controllers\SuperAdmin\WholesaleController;
use App\Http\Controllers\SuperAdmin\ProductController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\AttributeController;
use App\Http\Controllers\SuperAdmin\BrandController;
use App\Http\Controllers\SuperAdmin\OrderController;
use App\Http\Controllers\SuperAdmin\PaymentController;
use App\Http\Controllers\SuperAdmin\CommissionController;
use App\Http\Controllers\SuperAdmin\WithdrawalController;
use App\Http\Controllers\SuperAdmin\CouponController;
use App\Http\Controllers\SuperAdmin\CampaignController;
use App\Http\Controllers\SuperAdmin\FlashSaleController;
use App\Http\Controllers\SuperAdmin\DeliveryController;
use App\Http\Controllers\SuperAdmin\ReturnController;
use App\Http\Controllers\SuperAdmin\RefundController;
use App\Http\Controllers\SuperAdmin\ReviewController;
use App\Http\Controllers\SuperAdmin\SupportController;
use App\Http\Controllers\SuperAdmin\NotificationController;
use App\Http\Controllers\SuperAdmin\ReportController;
use App\Http\Controllers\SuperAdmin\FraudController;
use App\Http\Controllers\SuperAdmin\DisputeController;
use App\Http\Controllers\SuperAdmin\SliderController;
use App\Http\Controllers\SuperAdmin\BannerController;
use App\Http\Controllers\SuperAdmin\ActivityLogController;
use App\Http\Controllers\SuperAdmin\SettingController;
use App\Http\Controllers\SuperAdmin\ProfileController;
use App\Http\Controllers\SuperAdmin\CourierController;
use App\Http\Controllers\SuperAdmin\ShippingZoneController;
use App\Http\Controllers\SuperAdmin\DeliveryRateController;
use App\Http\Controllers\SuperAdmin\ShipmentTrackingController;
use App\Http\Controllers\SuperAdmin\CommissionRuleController;
use App\Http\Controllers\SuperAdmin\DropshippingProductController;
use App\Http\Controllers\SuperAdmin\DropshippingSupplierController;
use App\Http\Controllers\SuperAdmin\DropshippingImportController;
use App\Http\Controllers\SuperAdmin\DropshippingOrderController;
use App\Http\Controllers\SuperAdmin\DropshippingProfitController;
use App\Http\Controllers\SuperAdmin\DropshippingSettingController;
use App\Http\Controllers\SuperAdmin\WholesaleProductController;
use App\Http\Controllers\SuperAdmin\WholesaleTierController;
use App\Http\Controllers\SuperAdmin\BulkOrderController;
use App\Http\Controllers\SuperAdmin\MinimumOrderQuantityController;
use App\Http\Controllers\Admin\Orders\OrderController as AdminOrdersOrderController;
use App\Http\Controllers\Admin\Orders\ShipmentController as AdminDeliveryTransportController;

use App\Http\Controllers\SuperAdmin\ResellerProductController;
use App\Http\Controllers\SuperAdmin\ResellerPricingController;
use App\Http\Controllers\SuperAdmin\ResellerEarningController;
use App\Http\Controllers\SuperAdmin\CustomerController;

use App\Http\Controllers\SuperAdmin\AffiliateLinkController;
use App\Http\Controllers\SuperAdmin\AffiliateClickController;
use App\Http\Controllers\SuperAdmin\AffiliateSaleController;
use App\Http\Controllers\SuperAdmin\WarrantyRegistrationController;

Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'route.permission'])->group(function () {
    Route::resource('manual-orders', AdminOrdersOrderController::class)->only(['index', 'create', 'store', 'show'])->parameters(['manual-orders' => 'order'])->names('manual-orders');
    Route::get('delivery-transport/search', [AdminDeliveryTransportController::class, 'searchOrders'])->name('delivery-transport.search');
    Route::patch('delivery-transport/{shipment}/status', [AdminDeliveryTransportController::class, 'updateStatus'])->name('delivery-transport.status');
    Route::resource('delivery-transport', AdminDeliveryTransportController::class)
        ->only(['index', 'create', 'store', 'edit', 'update'])
        ->parameters(['delivery-transport' => 'shipment'])
        ->names('delivery-transport');
    Route::get('payment-deposits/{deposit}/receipt', [\App\Http\Controllers\PaymentDepositReceiptController::class, 'show'])->name('payment-deposits.receipt');
    Route::get('buyer-requests', [\App\Http\Controllers\Admin\RfqController::class, 'index'])->name('rfqs.index');
    Route::get('buyer-requests/{rfq}', [\App\Http\Controllers\Admin\RfqController::class, 'show'])->name('rfqs.show');

    // Dashboard
    Route::get('dashboards', [DashboardController::class, 'index'])->name('dashboards');

    // Marketing (sliders, banners)
    Route::resource('sliders', SliderController::class)->except('show')->names('sliders');
    Route::resource('banners', BannerController::class)->except('show')->names('banners');

    // User & Role Management
    Route::resource('users', UserController::class)->names('users');
    Route::resource('roles', RoleController::class)->except('show')->names('roles');

    // Customers
    Route::resource('customers', CustomerController::class)->only(['index', 'show'])->names('customers');

        // Warranty registrations
    Route::resource('warranties', WarrantyRegistrationController::class)
        ->except('show')
        ->parameters(['warranties' => 'warranty'])
        ->names('warranties');
        
    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Dropshipping (overview + sub pages)
    Route::get('dropshippings', [DropshippingController::class, 'index'])->name('dropshippings.index');
    Route::prefix('dropshipping')->name('dropshipping.')->group(function () {
        Route::get('products', [DropshippingProductController::class, 'index'])->name('products.index');
        Route::patch('products/{dropshippingProduct}/toggle', [DropshippingProductController::class, 'toggle'])->name('products.toggle');
        Route::get('suppliers', [DropshippingSupplierController::class, 'index'])->name('suppliers.index');
        Route::get('imports', [DropshippingImportController::class, 'index'])->name('imports.index');
        Route::get('orders', [DropshippingOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{dropshippingOrder}', [DropshippingOrderController::class, 'show'])->name('orders.show');
        Route::get('profit', [DropshippingProfitController::class, 'index'])->name('profit.index');
        Route::get('settings', [DropshippingSettingController::class, 'index'])->name('settings.index');
        Route::put('settings/{dropshippingSetting}', [DropshippingSettingController::class, 'update'])->name('settings.update');
    });

    // Wholesale (overview + sub pages)
    Route::get('wholesales', [WholesaleController::class, 'index'])->name('wholesales.index');
    Route::prefix('wholesale')->name('wholesale.')->group(function () {
        Route::get('products', [WholesaleProductController::class, 'index'])->name('products.index');
        Route::post('products', [WholesaleProductController::class, 'store'])->name('products.store');
        Route::patch('products/{wholesaleProduct}/toggle', [WholesaleProductController::class, 'toggle'])->name('products.toggle');
        Route::delete('products/{wholesaleProduct}', [WholesaleProductController::class, 'destroy'])->name('products.destroy');

        Route::get('tiers', [WholesaleTierController::class, 'index'])->name('tiers.index');
        Route::post('tiers', [WholesaleTierController::class, 'store'])->name('tiers.store');
        Route::delete('tiers/{wholesaleTier}', [WholesaleTierController::class, 'destroy'])->name('tiers.destroy');

        Route::get('bulk-orders', [BulkOrderController::class, 'index'])->name('bulk-orders.index');

        Route::get('moq', [MinimumOrderQuantityController::class, 'index'])->name('moq.index');
        Route::post('moq', [MinimumOrderQuantityController::class, 'store'])->name('moq.store');
        Route::delete('moq/{minimumOrderQuantity}', [MinimumOrderQuantityController::class, 'destroy'])->name('moq.destroy');
    });

    // Affiliate sub pages
    Route::prefix('affiliate')->name('affiliate.')->group(function () {
        Route::get('links', [AffiliateLinkController::class, 'index'])->name('links.index');
        Route::patch('links/{affiliateLink}/toggle', [AffiliateLinkController::class, 'toggle'])->name('links.toggle');

        Route::get('clicks', [AffiliateClickController::class, 'index'])->name('clicks.index');

        Route::get('sales', [AffiliateSaleController::class, 'index'])->name('sales.index');
        Route::patch('sales/{affiliateSale}/status', [AffiliateSaleController::class, 'updateStatus'])->name('sales.status');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('website', [SettingController::class, 'website'])->name('website');
        Route::put('website', [SettingController::class, 'updateWebsite'])->name('website.update');

        Route::get('payment', [SettingController::class, 'payment'])->name('payment');
        Route::put('payment', [SettingController::class, 'updatePayment'])->name('payment.update');

        Route::get('shipping', [SettingController::class, 'shipping'])->name('shipping');
        Route::put('shipping', [SettingController::class, 'updateShipping'])->name('shipping.update');

        Route::get('commission', [SettingController::class, 'commission'])->name('commission');
        Route::put('commission', [SettingController::class, 'updateCommission'])->name('commission.update');
    });

    // পুরনো link যাতে না ভাঙে (আগের settings.edit / settings.update)
    Route::get('settings', fn () => redirect()->route('superadmin.settings.website'))->name('settings.edit');
    Route::put('settings', [SettingController::class, 'updateWebsite'])->name('settings.update');

    // Delivery
    Route::resource('couriers', CourierController::class);
    Route::resource('shipping-zones', ShippingZoneController::class);
    Route::resource('delivery-rates', DeliveryRateController::class);
    Route::get('shipment-tracking', [ShipmentTrackingController::class, 'index'])->name('shipment-tracking.index');
    Route::get('shipment-tracking/{shipment}', [ShipmentTrackingController::class, 'show'])->name('shipment-tracking.show');

    // Marketplace Roles (approve / reject / suspend)
    Route::resource('vendors', VendorController::class)->names('vendors');
    Route::patch('vendors/{vendor}/approve', [VendorController::class, 'approve'])->name('vendors.approve');
    Route::patch('vendors/{vendor}/reject',  [VendorController::class, 'reject'])->name('vendors.reject');
    Route::patch('vendors/{vendor}/suspend', [VendorController::class, 'suspend'])->name('vendors.suspend');

    Route::resource('suppliers', SupplierController::class)->names('suppliers');
    Route::patch('suppliers/{supplier}/approve', [SupplierController::class, 'approve'])->name('suppliers.approve');
    Route::patch('suppliers/{id}/reject', [SupplierController::class, 'reject'])->name('suppliers.reject');
    Route::patch('suppliers/{supplier}/suspend', [SupplierController::class, 'suspend'])->name('suppliers.suspend');

    Route::resource('affiliates', AffiliateController::class)->names('affiliates');
    Route::patch('affiliates/{affiliate}/approve', [AffiliateController::class, 'approve'])->name('affiliates.approve');
    Route::patch('affiliates/{id}/reject', [AffiliateController::class, 'reject'])->name('affiliates.reject');
    Route::patch('affiliates/{affiliate}/suspend', [AffiliateController::class, 'suspend'])->name('affiliates.suspend');

    Route::resource('resellers', ResellerController::class)->names('resellers');
    Route::patch('resellers/{reseller}/approve', [ResellerController::class, 'approve'])->name('resellers.approve');
    Route::patch('resellers/{id}/reject', [ResellerController::class, 'reject'])->name('resellers.reject');
    Route::patch('resellers/{reseller}/suspend', [ResellerController::class, 'suspend'])->name('resellers.suspend');

    Route::resource('dropshipper-accounts', DropshipperAccountController::class)->names('dropshipper-accounts');
    Route::patch('dropshipper-accounts/{id}/approve', [DropshipperAccountController::class, 'approve'])->name('dropshipper-accounts.approve');
    Route::patch('dropshipper-accounts/{id}/reject', [DropshipperAccountController::class, 'reject'])->name('dropshipper-accounts.reject');
    Route::patch('dropshipper-accounts/{id}/suspend', [DropshipperAccountController::class, 'suspend'])->name('dropshipper-accounts.suspend');

    Route::resource('wholesaler-accounts', WholesalerAccountController::class)->names('wholesaler-accounts');
    Route::patch('wholesaler-accounts/{id}/approve', [WholesalerAccountController::class, 'approve'])->name('wholesaler-accounts.approve');
    Route::patch('wholesaler-accounts/{id}/reject', [WholesalerAccountController::class, 'reject'])->name('wholesaler-accounts.reject');
    Route::patch('wholesaler-accounts/{id}/suspend', [WholesalerAccountController::class, 'suspend'])->name('wholesaler-accounts.suspend');

    // Reseller sub pages
    Route::prefix('reseller')->name('reseller.')->group(function () {
        Route::get('products', [ResellerProductController::class, 'index'])->name('products.index');
        Route::patch('products/{resellerProduct}/toggle', [ResellerProductController::class, 'toggle'])->name('products.toggle');

        Route::get('pricing', [ResellerPricingController::class, 'index'])->name('pricing.index');
        Route::put('pricing/{resellerProduct}', [ResellerPricingController::class, 'update'])->name('pricing.update');

        Route::get('earnings', [ResellerEarningController::class, 'index'])->name('earnings.index');
    });
    

    // Catalog
    Route::patch('products/{product}/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::patch('products/{product}/reject', [ProductController::class, 'reject'])->name('products.reject');
    Route::resource('products', ProductController::class)->names('products');

    Route::resource('categories', CategoryController::class)->names('categories');
    Route::get('categories/{category}/subcategories', [CategoryController::class, 'subCategories'])
        ->name('categories.subcategories');
    Route::resource('brands', BrandController::class)->names('brands');

    // Attributes (Color, Size, etc.)
    Route::resource('attributes', AttributeController::class)->names('attributes');
    Route::post('attributes/{attribute}/values', [AttributeController::class, 'storeValue'])
        ->name('attributes.values.store');
    Route::delete('attribute-values/{attributeValue}', [AttributeController::class, 'destroyValue'])
        ->name('attributes.values.destroy');

    // Orders & Payments
    Route::resource('orders', OrderController::class)->only(['index', 'show'])->names('orders');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::patch('orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.payment-status');
    Route::post('orders/{order}/notes', [OrderController::class, 'storeNote'])->name('orders.notes.store');
    Route::post('orders/{order}/courier/send', [OrderController::class, 'sendToCourier'])->name('orders.courier.send');
    Route::post('orders/{order}/courier/sync', [OrderController::class, 'syncCourier'])->name('orders.courier.sync');

    Route::post('orders/bulk/delete', [OrderController::class, 'bulkDelete'])->name('orders.bulk.delete');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');


    // Bulk actions (list theke select kore)
    Route::post('orders/bulk/courier', [OrderController::class, 'bulkCourier'])->name('orders.bulk.courier');
    Route::post('orders/bulk/status', [OrderController::class, 'bulkStatus'])->name('orders.bulk.status');

    Route::resource('payments', PaymentController::class)->names('payments');
    Route::resource('refunds', RefundController::class)->names('refunds');
    Route::get('returns', [ReturnController::class, 'index'])->name('returns');
    Route::get('deliveries', [DeliveryController::class, 'index'])->name('deliveries');

    // Finance
    Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::get('commissions/{commission}', [CommissionController::class, 'show'])->name('commissions.show');
    Route::patch('commissions/{commission}/status', [CommissionController::class, 'updateStatus'])->name('commissions.status');

    Route::get('commission-rules', [CommissionRuleController::class, 'index'])->name('commission-rules.index');
    Route::post('commission-rules', [CommissionRuleController::class, 'store'])->name('commission-rules.store');
    Route::put('commission-rules/{commissionRule}', [CommissionRuleController::class, 'update'])->name('commission-rules.update');
    Route::delete('commission-rules/{commissionRule}', [CommissionRuleController::class, 'destroy'])->name('commission-rules.destroy');

    Route::resource('withdrawals', WithdrawalController::class)->names('withdrawals');
    Route::patch('withdrawals/{withdrawal}/status', [WithdrawalController::class, 'updateStatus'])->name('withdrawals.status');

    // Marketing
    Route::resource('coupons', CouponController::class)->names('coupons');
    Route::resource('campaigns', CampaignController::class)->names('campaigns');
    Route::resource('flash-sales', FlashSaleController::class)->names('flash-sales');

    // Reviews & Support
    Route::resource('reviews', ReviewController::class)->names('reviews');
    Route::get('supports', [SupportController::class, 'index'])->name('supports');
    Route::get('frauds', [FraudController::class, 'index'])->name('frauds');
    Route::resource('disputes', DisputeController::class)->names('disputes');

    // System
    Route::patch('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::resource('notifications', NotificationController::class)->only(['index', 'show', 'update', 'destroy'])->names('notifications');
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::resource('activity-logs', ActivityLogController::class)->names('activity-logs');
});
