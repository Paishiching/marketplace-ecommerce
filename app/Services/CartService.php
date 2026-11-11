<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartService
{
    /**
     * Session key যেখানে guest cart-এর token রাখা হবে
     */
    protected string $sessionKey = 'cart_session_id';

    /**
     * Login করা customer এর cart (customer_id ভিত্তিক), না হলে guest/session cart।
     */
    public function getCurrentCart(): Cart
    {
        $customerId = $this->currentCustomerId();

        if ($customerId) {
            return Cart::firstOrCreate(['customer_id' => $customerId]);
        }

        $sessionId = session($this->sessionKey);

        if (! $sessionId) {
            $sessionId = (string) Str::uuid();
            session([$this->sessionKey => $sessionId]);
        }

        return Cart::firstOrCreate([
            'session_id'  => $sessionId,
            'customer_id' => null,
        ]);
    }

    protected function currentCustomerId(): ?int
    {
        if (! Auth::check()) {
            return null;
        }

        $customer = Auth::user()->customer;

        return $customer ? (int) $customer->id : null;
    }

    /**
     * Login এর পর guest cart এর item গুলো customer cart এ merge করে।
     */
    public function mergeGuestCartIntoCustomer(int $customerId): void
    {
        $customerCart = Cart::firstOrCreate(['customer_id' => $customerId]);
        $sessionId    = session($this->sessionKey);

        if (! $sessionId) {
            return;
        }

        $guestCart = Cart::where('session_id', $sessionId)
            ->whereNull('customer_id')
            ->first();

        if ($guestCart && $guestCart->id !== $customerCart->id) {
            foreach ($guestCart->cartItems as $item) {
                $existing = CartItem::where('cart_id', $customerCart->id)
                    ->where('product_id', $item->product_id)
                    ->where('variant_id', $item->variant_id)
                    ->first();

                if ($existing) {
                    $existing->update([
                        'quantity' => $existing->quantity + $item->quantity,
                        'price'    => $item->price,
                    ]);
                    $item->delete();
                } else {
                    $item->update(['cart_id' => $customerCart->id]);
                }
            }

            $guestCart->delete();
        }

        session()->forget($this->sessionKey);
    }

    /**
     * Cart-এ product/variant add করা। আগে থেকে থাকলে quantity বাড়িয়ে দেয়,
     * না থাকলে নতুন row বানায়। Stock এর বাইরে qty যেতে দেয় না।
     *
     * @throws \Exception
     */
    public function addItem(int $productId, ?int $variantId, int $qty = 1): CartItem
    {
        $cart = $this->getCurrentCart();

        $product = Product::findOrFail($productId);

        // Unit price ও available stock বের করা
        [$unitPrice, $availableStock] = $this->resolvePriceAndStock($product, $variantId);

        if ($availableStock <= 0) {
            throw new \Exception('This product is out of stock.');
        }

        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        $newQty = $qty + ($existingItem->quantity ?? 0);

        if ($newQty > $availableStock) {
            $newQty = $availableStock;
        }

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $newQty,
                'price'    => $unitPrice,
            ]);

            return $existingItem->fresh();
        }

        return CartItem::create([
            'cart_id'    => $cart->id,
            'product_id' => $productId,
            'variant_id' => $variantId,
            'quantity'   => $newQty,
            'price'      => $unitPrice,
        ]);
    }

    /**
     * নির্দিষ্ট cart item-এর quantity আপডেট করা (stock limit মেনে)।
     *
     * @throws \Exception
     */
    public function updateQuantity(int $cartItemId, int $qty): CartItem
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        if ($qty < 1) {
            $qty = 1;
        }

        [, $availableStock] = $this->resolvePriceAndStock($cartItem->product, $cartItem->variant_id);

        if ($qty > $availableStock) {
            $qty = $availableStock;
        }

        $cartItem->update(['quantity' => $qty]);

        return $cartItem->fresh();
    }

    /**
     * Cart থেকে একটা item সরিয়ে দেওয়া।
     */
    public function removeItem(int $cartItemId): bool
    {
        $cartItem = CartItem::find($cartItemId);

        if (! $cartItem) {
            return false;
        }

        return (bool) $cartItem->delete();
    }

    /**
     * পুরো cart খালি করে দেওয়া (সব item মুছে ফেলা)।
     */
    public function clearCart(): void
    {
        $cart = $this->getCurrentCart();

        $cart->cartItems()->delete();
    }

    /**
     * Cart-এর সব item, relation সহ লোড করে ফেরত দেয় (cart page দেখানোর জন্য)।
     */
    public function getCartItems()
    {
        $cart = $this->getCurrentCart();

        return $cart->cartItems()->with(['product', 'productVariant'])->get();
    }

    /**
     * Cart-এ মোট কত ধরনের item / মোট qty আছে (navbar cart icon count এর জন্য)।
     */
    public function getCartCount(): int
    {
        $cart = $this->getCurrentCart();

        return (int) $cart->cartItems()->sum('quantity');
    }

    /**
     * Cart-এর সব item-এর subtotal যোগফল (grand total, shipping ছাড়া)।
     */
    public function getCartTotal(): float
    {
        $items = $this->getCartItems();

        return (float) $items->sum(fn ($item) => $item->price * $item->quantity);
    }

    /**
     * Product/variant থেকে সঠিক unit price ও available stock বের করা।
     *
     * @return array{0: float, 1: int}
     */
    protected function resolvePriceAndStock(Product $product, ?int $variantId): array
    {
        if ($variantId) {
            $variant = ProductVariant::where('id', $variantId)
                ->where('product_id', $product->id)
                ->first();

            if (! $variant) {
                throw new \Exception('Selected variant not found for this product.');
            }

            return [(float) $variant->price, (int) $variant->stock_quantity];
        }

        // variant না দেওয়া থাকলে — product-এর is_on_sale অনুযায়ী price, আর সব variant stock যোগফল
        $unitPrice = $product->is_on_sale ? $product->discount_price : $product->price;
        $stock = $product->productVariants()->sum('stock_quantity');

        return [(float) $unitPrice, (int) $stock];
    }

    /**
     * Session-এ coupon code সেভ করে, validate করে।
     *
     * @throws \Exception
     */
    public function applyCoupon(string $code): \App\Models\Coupon
    {
        $coupon = \App\Models\Coupon::where('code', $code)->live()->first();

        if (! $coupon) {
            throw new \Exception('Invalid or expired coupon code.');
        }

        $cartTotal = $this->getCartTotal();

        if ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
            throw new \Exception('Minimum order amount for this coupon is ৳' . number_format($coupon->min_order_amount, 2));
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            throw new \Exception('This coupon has reached its usage limit.');
        }

        session(['applied_coupon_code' => $coupon->code]);

        return $coupon;
    }

    /**
     * Session থেকে coupon সরিয়ে দেওয়া।
     */
    public function removeCoupon(): void
    {
        session()->forget('applied_coupon_code');
    }

    /**
     * বর্তমানে apply করা coupon (থাকলে) রিটার্ন করে, না থাকলে null।
     */
    public function getAppliedCoupon(): ?\App\Models\Coupon
    {
        $code = session('applied_coupon_code');

        if (! $code) {
            return null;
        }

        $coupon = \App\Models\Coupon::where('code', $code)->live()->first();

        // Coupon মেয়াদ শেষ হয়ে গেলে বা inactive হয়ে গেলে session থেকে সরিয়ে দাও
        if (! $coupon) {
            $this->removeCoupon();
            return null;
        }

        return $coupon;
    }

    /**
     * Applied coupon অনুযায়ী discount amount হিসাব করে।
     */
    public function getDiscountAmount(): float
    {
        $coupon = $this->getAppliedCoupon();

        if (! $coupon) {
            return 0;
        }

        $cartTotal = $this->getCartTotal();

        if ($coupon->type === 'percentage') {
            return round($cartTotal * ((float) $coupon->value / 100), 2);
        }

        // fixed amount discount — cart total এর বেশি discount হতে পারবে না
        return min((float) $coupon->value, $cartTotal);
    }

    /**
     * Discount বাদ দিয়ে grand total।
     */
    public function getGrandTotal(): float
    {
        return max(0, $this->getCartTotal() - $this->getDiscountAmount());
    }
}