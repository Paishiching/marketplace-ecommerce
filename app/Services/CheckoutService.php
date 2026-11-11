<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\VendorOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{
    public function __construct(
        protected PricingService $pricingService,
        protected CouponService $couponService
    ) {
    }

    /**
     * Convert a customer's cart into an Order (and per-vendor sub-orders).
     */
    public function placeOrder(Cart $cart, array $checkoutData): Order
    {
        return DB::transaction(function () use ($cart, $checkoutData) {
            $cartItems = $cart->cartItems()->with('product')->get();

            $subtotal = $cartItems->sum(fn ($item) => $item->quantity * $item->product->price);

            $discount = 0;
            if (! empty($checkoutData['coupon_code'])) {
                $discount = $this->couponService->calculateDiscount($checkoutData['coupon_code'], $subtotal);
            }

            $shippingCost = $checkoutData['shipping_cost'] ?? 0;
            $total = $subtotal - $discount + $shippingCost;

            $order = Order::create([
                'customer_id' => $checkoutData['customer_id'],
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'status' => 'pending',
                'shipping_address_id' => $checkoutData['shipping_address_id'] ?? null,
                'payment_method' => $checkoutData['payment_method'] ?? null,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'vendor_id' => $item->product->vendor_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $item->quantity * $item->product->price,
                ]);
            }

            $this->splitIntoVendorOrders($order);

            $cart->cartItems()->delete();

            return $order->fresh('orderItems');
        });
    }

    /**
     * Split a marketplace order into per-vendor sub-orders so each
     * vendor only sees and fulfills their own items.
     */
    protected function splitIntoVendorOrders(Order $order): void
    {
        $itemsByVendor = $order->orderItems->groupBy('vendor_id');

        foreach ($itemsByVendor as $vendorId => $items) {
            VendorOrder::create([
                'order_id' => $order->id,
                'vendor_id' => $vendorId,
                'subtotal' => $items->sum('total'),
                'status' => 'pending',
            ]);
        }
    }
}
