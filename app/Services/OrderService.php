<?php

namespace App\Services;

use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\VendorOrder;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\CouponUsage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class OrderService
{
    protected CartService $cartService;
    protected ShippingService $shippingService;

    public function __construct(CartService $cartService, ShippingService $shippingService)
    {
        $this->cartService     = $cartService;
        $this->shippingService = $shippingService;
    }

    /**
     * Checkout ফর্ম সাবমিট হলে পুরো অর্ডার তৈরির প্রক্রিয়া।
     *
     * @param  array  $data  validated request data
     * @param  int|null  $customerId  guest হলে null
     */
    public function placeOrder(array $data, ?int $customerId): Order
    {
        $cartItems = $this->cartService->getCartItems();

        if ($cartItems->isEmpty()) {
            throw new Exception('Your cart is empty.');
        }

        return DB::transaction(function () use ($data, $customerId, $cartItems) {

            // ---- ১. Shipping Address resolve/তৈরি করা ----
            $address = $this->resolveShippingAddress($data, $customerId);

            // ---- ২. Shipping zone + cost বের করা ----
            $shipping     = $this->shippingService->resolve($address->city);
            $shippingCost = $shipping['rate'] ? (float) $shipping['rate']->rate : 0.0;

            // ---- ৩. Totals ক্যালকুলেট ----
            $subtotal   = (float) $this->cartService->getCartTotal();
            $discount   = (float) $this->cartService->getDiscountAmount();
            $appliedCoupon = $this->cartService->getAppliedCoupon();
            $grandTotal = $subtotal - $discount + $shippingCost;

            // ---- ৪. Order তৈরি ----
            $order = Order::create([
                'order_number'         => $this->generateOrderNumber(),
                'customer_id'          => $customerId,
                'name'                 => $data['name'] ?? null,
                'phone'                => $data['phone'],
                'email'                => $data['email'] ?? null,
                'subtotal'             => $subtotal,
                'discount'             => $discount,
                'shipping_cost'        => $shippingCost,
                'tax'                  => 0,
                'total'                => $grandTotal,
                'status'               => 'pending',
                'payment_status'       => 'unpaid',
                'coupon_id'            => $appliedCoupon->id ?? null,
                'shipping_address_id'  => $address->id,
                'shipping_zone_id'     => $shipping['zone']->id ?? null,
                'notes'                => $data['notes'] ?? null,
            ]);

            // ---- ৫. Order Items তৈরি ----
            foreach ($cartItems as $item) {
                $order->orderItems()->create([
                    'product_id'         => $item->product_id,
                    'product_variant_id' => $item->product_variant_id ?? null,
                    'vendor_id'          => $item->product->vendor_id ?? null,
                    'quantity'           => $item->quantity,
                    'unit_price'         => $item->price,
                    'total_price'        => $item->price * $item->quantity,
                ]);
            }

            // ---- ৬. Vendor অনুযায়ী ভাগ করা ----
            $order->load('orderItems');
            $order->orderItems->groupBy('vendor_id')->each(function ($items, $vendorId) use ($order) {
                if (! $vendorId) {
                    return;
                }
                VendorOrder::create([
                    'order_id'   => $order->id,
                    'vendor_id'  => $vendorId,
                    'subtotal'   => $items->sum('total_price'),
                    'commission_amount' => 0,
                    'status'     => 'pending',
                ]);
            });

            // ---- ৭. Payment রেকর্ড তৈরি ----
            $paymentMethod = PaymentMethod::where('slug', $data['payment_method'])->first();

            $payment = Payment::create([
                'order_id'          => $order->id,
                'payment_method_id' => $paymentMethod->id ?? null,
                'payment_method_code' => $data['payment_method'],
                'amount'            => $grandTotal,
                'status'            => 'pending',
            ]);

            if (($data['payment_method'] ?? null) === 'bank_deposit') {
                $receiptPath = $data['deposit_attachment']->store('payment-deposits', 'local');
                \App\Models\PaymentDepositDetail::create([
                    'payment_id' => $payment->id,
                    'order_id' => $order->id,
                    'deposit_date' => $data['deposit_date'],
                    'depositor_bank' => $data['depositor_bank'],
                    'depositor_branch' => $data['depositor_branch'],
                    'deposit_type' => $data['deposit_type'],
                    'amount' => $data['deposit_amount'],
                    'company_account' => $data['deposit_company_account'],
                    'bank_name' => $data['deposit_bank_name'],
                    'company_name' => $data['deposit_company_name'],
                    'receipt_id' => $data['deposit_receipt_id'] ?? null,
                    'receipt_path' => $receiptPath,
                    'remark' => $data['deposit_remark'] ?? null,
                ]);
            }

            // ---- ৮. Coupon usage log ----
            if ($appliedCoupon) {
                CouponUsage::create([
                    'coupon_id'   => $appliedCoupon->id,
                    'customer_id' => $customerId,
                    'order_id'    => $order->id,
                ]);
            }

            // ---- ৯. Cart খালি করা ----
            $this->cartService->clearCart();

            return $order;
        });
    }

    /**
     * সেভ করা ঠিকানা সিলেক্ট করা থাকলে সেটাই ব্যবহার হবে,
     * না থাকলে নতুন ShippingAddress তৈরি হবে।
     */
    protected function resolveShippingAddress(array $data, ?int $customerId): ShippingAddress
    {
        if (! empty($data['shipping_address_id'])) {
            return ShippingAddress::findOrFail($data['shipping_address_id']);
        }

        $values = [
            'customer_id'   => $customerId,
            'recipient_name'=> $data['name'] ?? null,
            'phone'         => $data['phone'],
            'address_line1' => $data['address_line1'],
            'address_line2' => $data['address_line2'] ?? null,
            'city'          => $data['city'],
            'state'         => null,
            'country'       => 'Bangladesh',
        ];

        // Keep the first checkout address on the customer profile and update
        // that saved entry on later orders instead of creating duplicates.
        if ($customerId) {
            $address = ShippingAddress::query()
                ->where('customer_id', $customerId)
                ->where('phone', $values['phone'])
                ->where('address_line1', $values['address_line1'])
                ->where('city', $values['city'])
                ->first();

            if ($address) {
                $address->forceFill($values)->save();
                return $address;
            }
        }

        return ShippingAddress::create($values);
    }

    protected function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . date('ymd') . '-' . strtoupper(Str::random(5));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
