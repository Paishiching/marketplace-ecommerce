<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\BrandController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\StoreController;
use App\Http\Controllers\Frontend\SupplierController;
use App\Http\Controllers\Frontend\DropshippingController;
use App\Http\Controllers\Frontend\DropshipperStoreController;
use App\Http\Controllers\Frontend\WholesaleController;
use App\Http\Controllers\Frontend\ResellerController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\CouponController;
use App\Http\Controllers\Frontend\CampaignController;
use App\Http\Controllers\Frontend\AffiliateController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\PartnerRegistrationController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\FAQController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PolicyController;
use App\Http\Controllers\Frontend\ContactController;

Route::get('/ref/{code}', [AffiliateController::class, 'track'])->name('affiliate.track');

// Vendor / Supplier / Affiliate / Reseller hishebe apply (ek controller, ek view)
Route::get('/become-a-vendor', [PartnerRegistrationController::class, 'create'])->defaults('type', 'vendor')->name('become-vendor.create');
Route::post('/become-a-vendor', [PartnerRegistrationController::class, 'store'])->defaults('type', 'vendor')->name('become-vendor.store');
Route::get('/become-a-supplier', [PartnerRegistrationController::class, 'create'])->defaults('type', 'supplier')->name('become-supplier.create');
Route::post('/become-a-supplier', [PartnerRegistrationController::class, 'store'])->defaults('type', 'supplier')->name('become-supplier.store');
Route::get('/become-an-affiliate', [PartnerRegistrationController::class, 'create'])->defaults('type', 'affiliate')->name('become-affiliate.create');
Route::post('/become-an-affiliate', [PartnerRegistrationController::class, 'store'])->defaults('type', 'affiliate')->name('become-affiliate.store');
Route::get('/become-a-reseller', [PartnerRegistrationController::class, 'create'])->defaults('type', 'reseller')->name('become-reseller.create');
Route::post('/become-a-reseller', [PartnerRegistrationController::class, 'store'])->defaults('type', 'reseller')->name('become-reseller.store');

// Login korar por role onujayi dashboard e pathabe
// (Customer account routes ekhon routes/customer.php te)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::group([], function () {
    Route::get('/', [HomeController::class, 'index'])->name('homes');
    Route::get('/mobile-deal-feed', [HomeController::class, 'mobileDealFeed'])->name('mobile-deals.feed');
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/categories-index', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories-shop', [CategoryController::class, 'shop'])->name('categories.shop');
    Route::get('/products-details/{product:slug}', [ProductController::class, 'show'])->name('products.details');
      Route::get('/product-specs', function (\Illuminate\Http\Request $request) {
        $ids = collect(explode(',', (string) $request->query('ids')))
            ->map(fn ($i) => (int) $i)->filter()->unique()->take(100)->values();

        return response()->json(
            \App\Models\Product::whereIn('id', $ids)
                ->with('productSpecifications')
                ->get()
                ->mapWithKeys(fn ($p) => [$p->id => [
                    'sku'   => $p->sku,
                    'specs' => $p->productSpecifications->map(fn ($s) => ['name' => $s->name, 'value' => $s->value])->values(),
                ]])
        );
    })->name('product.specs');
    Route::get('searches', [SearchController::class, 'index'])->name('searches');
    Route::post('searches/image', [SearchController::class, 'image'])->middleware('throttle:10,1')->name('searches.image');
    Route::get('stores', [StoreController::class, 'index'])->name('stores');
    Route::get('dropshippings', [DropshippingController::class, 'index'])->name('dropshippings');
    Route::get('dropship-products/{dropshipperProduct}', [DropshipperStoreController::class, 'show'])->name('dropship-products.show');
    Route::post('dropship-products/{dropshipperProduct}/orders', [DropshipperStoreController::class, 'order'])
        ->middleware(['auth', 'throttle:10,1'])
        ->name('dropship-products.orders.store');
    Route::get('my-dropshipping-orders', [DropshipperStoreController::class, 'myOrders'])
        ->middleware('auth')
        ->name('dropship-products.orders.mine');
    Route::get('wholesales', [WholesaleController::class, 'index'])->name('wholesales');
    Route::get('wholesales/{wholesaleProduct}', [WholesaleController::class, 'show'])->name('wholesales.show');
    Route::post('wholesales/{wholesaleProduct}/orders', [WholesaleController::class, 'placeBulkOrder'])
        ->middleware(['auth', 'throttle:10,1'])
        ->name('wholesales.orders.store');

    Route::get('/cart-index', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])
        ->middleware(\App\Http\Middleware\RequireLoginForCart::class)
        ->name('cart.add');
    Route::get('/cart/mini', [CartController::class, 'mini'])->name('cart.mini');
    Route::post('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
    Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

    Route::get('/policy/free-shipping', [PolicyController::class, 'shipping'])->name('policy.shipping');
    Route::get('/policy/free-returns', [PolicyController::class, 'returns'])->name('policy.returns');
    Route::get('/policy/support', [PolicyController::class, 'support'])->name('policy.support');
    Route::get('/policy/secure-payment', [PolicyController::class, 'payment'])->name('policy.payment');
    Route::get('/policy/faq', [PolicyController::class, 'faq'])->name('policy.faq');

    Route::get('/checkout-index', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/coupon/apply', [CheckoutController::class, 'applyCoupon'])->name('checkout.coupon.apply');
    Route::post('/checkout/coupon/remove', [CheckoutController::class, 'removeCoupon'])->name('checkout.coupon.remove');
    Route::post('/checkout/shipping-cost', [CheckoutController::class, 'shippingCost'])->name('checkout.shipping-cost');
    Route::post('/checkout/place-order', [CheckoutController::class, 'store'])->name('checkout.store');

    // Checkout address : save / edit / delete (DB te thake)
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.address.store');
    Route::delete('/checkout/address/{address}', [CheckoutController::class, 'destroyAddress'])->name('checkout.address.destroy');

    Route::get('/checkout-success/{order:order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/compare-index', [CompareController::class, 'index'])->name('compare.index');
    Route::post('/compare/toggle', [CompareController::class, 'toggle'])->name('compare.toggle');
    Route::delete('/compare/remove/{item}', [CompareController::class, 'destroy'])->name('compare.destroy');
    Route::get('/wishlist-index', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/remove/{item}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::get('/blog-index', [BlogController::class, 'index'])->name('blog.index');
    Route::get('page-index', [PageController::class, 'index'])->name('page.index');
    Route::get('customer-complaint', [PageController::class, 'complaint'])->name('complaint.index');
    Route::get('warranty-period-enquiry', [PageController::class, 'warranty'])
    ->middleware('throttle:20,1')
    ->name('warranty.index');
    Route::post('warranty-period-enquiry', [PageController::class, 'warrantyCheck'])
    ->middleware('throttle:20,1')
    ->name('warranty.check');
    
    Route::get('contacts-index', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('contacts-store', [ContactController::class, 'store'])->name('contacts.store');

    Route::get('/login-verify', [\App\Http\Controllers\Frontend\OtpLoginController::class, 'showLogin'])->name('otp.login');
    Route::post('/login-verify/send', [\App\Http\Controllers\Frontend\OtpLoginController::class, 'send'])->middleware('throttle:6,1')->name('otp.send');
    Route::get('/login-verify/code', [\App\Http\Controllers\Frontend\OtpLoginController::class, 'showVerify'])->name('otp.verify.form');
    Route::post('/login-verify/code', [\App\Http\Controllers\Frontend\OtpLoginController::class, 'verify'])->middleware('throttle:10,1')->name('otp.verify');
    Route::post('/login-verify/resend', [\App\Http\Controllers\Frontend\OtpLoginController::class, 'resend'])->middleware('throttle:6,1')->name('otp.resend');
    Route::post('/login-verify/password', [\App\Http\Controllers\Frontend\OtpLoginController::class, 'passwordLogin'])->middleware('throttle:6,1')->name('otp.password');
    Route::get('/auth/google/redirect', [\App\Http\Controllers\Frontend\GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [\App\Http\Controllers\Frontend\GoogleAuthController::class, 'callback'])->name('google.callback');
});

/*
|--------------------------------------------------------------------------
| Uploaded file serve (logo, banner, category, product image)
| Live server-e public/storage symlink na thakleo storage/app/public theke
| file serve korbe. Symlink thakle web server nijei file dey, ei route lagbe na.
|--------------------------------------------------------------------------
*/
Route::get('/storage/{path}', function (string $path) {
    if (str_contains($path, '..')) {
        abort(404);
    }

    $disk = Storage::disk('public');

    if (! $disk->exists($path)) {
        abort(404);
    }

    return response()->file($disk->path($path), [
        'Cache-Control' => 'public, max-age=604800',
    ]);
})->where('path', '.*');
