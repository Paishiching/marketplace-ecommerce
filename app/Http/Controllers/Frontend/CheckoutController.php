<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\PlaceOrderRequest;
use App\Models\Customer;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Coupon;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected OrderService $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService  = $cartService;
        $this->orderService = $orderService;
    }

    protected array $districts = [
        'Bagerhat','Bandarban','Barguna','Barishal','Bhola','Bogura','Brahmanbaria','Chandpur',
        'Chattogram','Chuadanga','Cox\'s Bazar','Cumilla','Dhaka','Dinajpur','Faridpur','Feni',
        'Gaibandha','Gazipur','Gopalganj','Habiganj','Jamalpur','Jashore','Jhalokati','Jhenaidah',
        'Joypurhat','Khagrachhari','Khulna','Kishoreganj','Kurigram','Kushtia','Lakshmipur','Lalmonirhat',
        'Madaripur','Magura','Manikganj','Meherpur','Moulvibazar','Munshiganj','Mymensingh','Naogaon',
        'Narail','Narayanganj','Narsingdi','Natore','Netrokona','Nilphamari','Noakhali','Pabna',
        'Panchagarh','Patuakhali','Pirojpur','Rajbari','Rajshahi','Rangamati','Rangpur','Satkhira',
        'Shariatpur','Sherpur','Sirajganj','Sunamganj','Sylhet','Tangail','Thakurgaon',
    ];

    public function index()
    {
        // Login/verify na thakle OTP login page e pathao; verify er por abar checkout e ashbe
        if (! Auth::check()) {
            session()->put('url.intended', route('checkout.index'));

            return redirect()->route('otp.login');
        }

        $newOrderCheckout = session('new_order_checkout');
        if ($newOrderCheckout) {
            $ids = collect($newOrderCheckout['items'] ?? [])->pluck('product_id')->unique()->values();
            $products = Product::whereIn('id', $ids)->where('status', '!=', 'rejected')->with(['brand', 'primaryImage'])->get()->keyBy('id');
            if ($products->count() !== $ids->count() || $ids->isEmpty()) {
                session()->forget('new_order_checkout');
                return redirect()->route('customer.new-order.create')->withErrors(['items' => 'Some selected products are no longer available. Please add them again.']);
            }

            $cartItems = collect($newOrderCheckout['items'])->map(function ($line) use ($products) {
                $product = $products->get((int) $line['product_id']);
                $item = new CartItem();
                $item->forceFill([
                    'product_id' => $product->id,
                    'quantity' => (int) $line['quantity'],
                    'price' => (float) ($product->discount_price > 0 ? $product->discount_price : $product->price),
                ]);
                $item->setRelation('product', $product);
                return $item;
            });
            $cartTotal = (float) $cartItems->sum(fn ($item) => $item->price * $item->quantity);
            $discount = $this->checkoutCouponDiscount((float) $cartTotal);
            $grandTotal = $cartTotal - $discount;
        } else {
            $cartItems  = $this->cartService->getCartItems();
            $cartTotal  = $this->cartService->getCartTotal();
            $discount   = session('checkout_coupon_code')
                ? $this->checkoutCouponDiscount((float) $cartTotal)
                : $this->cartService->getDiscountAmount();
            $grandTotal = $this->cartService->getGrandTotal();
        }

        $couponCode = session('checkout_coupon_code') ?: ($newOrderCheckout ? '' : ($this->cartService->getAppliedCoupon()?->code ?? ''));

        // Logged-in customer hole tar save kora thikana list dekhano hobe
        $savedAddresses = Auth::user()->customer
            ? Auth::user()->customer->shippingAddress
            : collect();

        $districts = $this->districts;

        // Verify kora email/name + ager save kora phone => form e auto boshbe (abar type korte hobe na)
        $user    = Auth::user();
        $prefill = [
            'name'  => (string) ($newOrderCheckout['name'] ?? $user->name),
            'email' => (string) ($newOrderCheckout['email'] ?? $user->email),
            'phone' => (string) ($newOrderCheckout['phone'] ?? $this->resolvePhone($user, $user->customer, $savedAddresses->last())),
        ];

        return view('frontend.checkout.index', compact(
            'cartItems', 'cartTotal', 'discount', 'grandTotal', 'savedAddresses', 'districts', 'prefill', 'couponCode'
        ));
    }

    public function applyCoupon(Request $request)
    {
        $data = $request->validate(['code' => ['required', 'string', 'max:50']]);
        $coupon = Coupon::whereRaw('LOWER(code) = ?', [mb_strtolower(trim($data['code']))])->live()->first();
        if (! $coupon) return response()->json(['success' => false, 'message' => 'Coupon code is invalid or expired.'], 422);
        $subtotal = $this->checkoutSubtotal();
        if ($coupon->min_order_amount && $subtotal < (float) $coupon->min_order_amount) {
            return response()->json(['success' => false, 'message' => 'Minimum order amount is ৳'.number_format($coupon->min_order_amount, 2).'.'], 422);
        }
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json(['success' => false, 'message' => 'This coupon has reached its usage limit.'], 422);
        }
        session(['checkout_coupon_code' => $coupon->code]);
        return response()->json(['success' => true, 'message' => 'Coupon applied.', 'code' => $coupon->code, 'discount' => $this->couponDiscount($coupon, $subtotal)]);
    }

    public function removeCoupon()
    {
        session()->forget('checkout_coupon_code');
        return response()->json(['success' => true, 'discount' => 0]);
    }

    protected function checkoutSubtotal(): float
    {
        $manual = session('new_order_checkout');
        if ($manual) {
            $ids = collect($manual['items'] ?? [])->pluck('product_id');
            return (float) Product::whereIn('id', $ids)->where('status', '!=', 'rejected')->get()
                ->sum(fn ($product) => (float) ($product->discount_price > 0 ? $product->discount_price : $product->price)
                    * (int) collect($manual['items'])->firstWhere('product_id', $product->id)['quantity']);
        }
        return $this->cartService->getCartTotal();
    }

    protected function checkoutCouponDiscount(float $subtotal): float
    {
        $code = session('checkout_coupon_code');
        if ($code) {
            $coupon = Coupon::where('code', $code)->live()->first();
            if ($coupon && (! $coupon->min_order_amount || $subtotal >= (float) $coupon->min_order_amount)
                && (! $coupon->usage_limit || $coupon->used_count < $coupon->usage_limit)) {
                return $this->couponDiscount($coupon, $subtotal);
            }
            session()->forget('checkout_coupon_code');
        }
        return 0.0;
    }

    protected function couponDiscount(Coupon $coupon, float $subtotal): float
    {
        return $coupon->type === 'percentage'
            ? min($subtotal, round($subtotal * ((float) $coupon->value / 100), 2))
            : min($subtotal, (float) $coupon->value);
    }

    public function shippingCost(Request $request)
    {
        $request->validate(['city' => 'required|string']);

        $shippingService = app(\App\Services\ShippingService::class);
        $resolved = $shippingService->resolve($request->city);

        return response()->json([
            'success'       => true,
            'shipping_cost' => $resolved['rate'] ? (float) $resolved['rate']->rate : 0,
            'zone_name'     => $resolved['zone']->name ?? 'Standard',
        ]);
    }

    /** Address save (new / edit) - order na korleo DB te thake */
    public function storeAddress(Request $request)
    {
        if (! Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to continue.'], 401);
        }

        $data = $request->validate([
            'address_id'    => ['nullable', 'integer'],
            'name'          => ['nullable', 'string', 'max:120'],
            'phone'         => ['required', 'string', 'max:20'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city'          => ['required', 'string', 'max:100'],
            'address_type'  => ['nullable', 'in:home,office'],
        ]);

        $customer = Customer::firstOrCreate(['user_id' => Auth::id()]);

        $values = [
            'recipient_name' => $data['name'] ?: Auth::user()->name,
            'phone'          => $data['phone'],
            'address_line1'  => $data['address_line1'],
            'address_line2'  => $data['address_line2'] ?? null,
            'city'           => $data['city'],
        ];

        if (! empty($data['address_id'])) {
            // edit : onno customer er address chhuye na
            $address = $customer->shippingAddress()->findOrFail($data['address_id']);
        } else {
            // ekoi address duibar save hobe na
            $address = $customer->shippingAddress()
                ->where('phone', $values['phone'])
                ->where('address_line1', $values['address_line1'])
                ->where('city', $values['city'])
                ->first();

            if (! $address) {
                $address = $customer->shippingAddress()->make();
            }
        }

        if (! empty($data['address_type'])
            && Schema::hasColumn($address->getTable(), 'address_type')) {
            $values['address_type'] = $data['address_type'];
        }

        $address->forceFill($values)->save();

        // Phone ekbar dile account e save thake, porer bar auto boshbe
        $this->rememberPhone(Auth::user(), $customer, $values['phone']);

        return response()->json([
            'success' => true,
            'address' => [
                'id'             => $address->id,
                'recipient_name' => $address->recipient_name,
                'phone'          => $address->phone,
                'address_line1'  => $address->address_line1,
                'address_line2'  => $address->address_line2,
                'city'           => $address->city,
                'address_type'   => $data['address_type'] ?? null,
                'delete_url'     => route('checkout.address.destroy', $address->id),
            ],
        ]);
    }

    /** Saved address delete */
    public function destroyAddress($address)
    {
        if (! Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        $customer = Auth::user()->customer;

        if (! $customer) {
            return response()->json(['success' => false], 404);
        }

        $customer->shippingAddress()->findOrFail($address)->delete();

        return response()->json(['success' => true]);
    }

    /** Phone khuje ber kora : customer -> user -> last saved address */
    protected function resolvePhone($user, $customer, $lastAddress = null): ?string
    {
        foreach ([$customer, $user] as $model) {
            if ($model && Schema::hasColumn($model->getTable(), 'phone') && ! empty($model->phone)) {
                return $model->phone;
            }
        }

        return $lastAddress->phone ?? null;
    }

    /** customer / user te phone column thakle ebong faka hole save kore rakhe */
    protected function rememberPhone($user, $customer, string $phone): void
    {
        foreach ([$customer, $user] as $model) {
            if ($model && Schema::hasColumn($model->getTable(), 'phone') && empty($model->phone)) {
                $model->forceFill(['phone' => $phone])->save();
            }
        }
    }

    public function store(PlaceOrderRequest $request)
    {
        if (! Auth::check()) {
            session()->put('url.intended', route('checkout.index'));

            return redirect()->route('otp.login');
        }

        $customerId = optional(Auth::user()->customer)->id;

        try {
            $newOrderCheckout = session('new_order_checkout');
            $order = $this->orderService->placeOrder([...$request->validated(), 'coupon_code' => session('checkout_coupon_code')], $customerId, $newOrderCheckout['items'] ?? null);
            if ($newOrderCheckout) session()->forget('new_order_checkout');
            session()->forget('checkout_coupon_code');

            return redirect()
                ->route('checkout.success', $order->order_number)
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Throwable $e) {
            Log::error('Order placement failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', $e->getMessage() ?: 'Something went wrong. Please try again.');
        }
    }

    public function success(Order $order)
    {
        // Shudhu nijer order dekhte parbe
        abort_unless(
            Auth::check() && (int) $order->customer_id === (int) optional(Auth::user()->customer)->id,
            403
        );

        $order->load([
            'orderItems.product',
            'shippingAddress',
            'shippingZone',
            'payments.paymentMethod',
        ]);

        return view('frontend.checkout.success', compact('order'));
    }
}
