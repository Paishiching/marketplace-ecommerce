<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Cart page দেখানো
     */
    public function index()
    {
        $cartItems     = $this->cartService->getCartItems();
        $cartTotal     = $this->cartService->getCartTotal();
        $appliedCoupon = $this->cartService->getAppliedCoupon();
        $discount      = $this->cartService->getDiscountAmount();
        $grandTotal    = $this->cartService->getGrandTotal();

        return view('frontend.cart.index', compact(
            'cartItems', 'cartTotal', 'appliedCoupon', 'discount', 'grandTotal'
        ));
    }


    /**
     * Product details page থেকে "ADD TO CART" ক্লিক করলে (AJAX)
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'variant_id' => ['nullable', 'integer', 'exists:product_variants,id'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        try {
            $this->cartService->addItem(
                $validated['product_id'],
                $validated['variant_id'] ?? null,
                $validated['quantity'] ?? 1
            );

            return response()->json([
                'success'    => true,
                'message'    => 'Product added to cart.',
                'cart_count' => $this->cartService->getCartCount(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Add to cart failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    public function mini()
    {
        $cartItems = $this->cartService->getCartItems();
        $cartTotal = $this->cartService->getCartTotal();

        return response()->json([
            'html'  => view('layouts.frontend.partials.mini-cart', compact('cartItems', 'cartTotal'))->render(),
            'count' => $this->cartService->getCartCount(),
            'total' => $cartTotal,
        ]);
    }

    /**
     * Cart page-এ qty +/- করলে (AJAX)
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $updated = $this->cartService->updateQuantity($cartItem->id, $validated['quantity']);
            return response()->json([
                'success'         => true,
                'quantity'        => $updated->quantity,
                'subtotal'        => $updated->price * $updated->quantity,
                'cart_total'      => $this->cartService->getCartTotal(),
                'discount'        => $this->cartService->getDiscountAmount(),
                'grand_total'     => $this->cartService->getGrandTotal(),
                'cart_count'      => $this->cartService->getCartCount(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Update cart failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Could not update quantity.',
            ], 422);
        }
    }

    /**
     * Cart থেকে item remove করা (AJAX)
     */
    public function remove(CartItem $cartItem)
    {
        $this->cartService->removeItem($cartItem->id);
        return response()->json([
            'success'     => true,
            'cart_total'  => $this->cartService->getCartTotal(),
            'discount'    => $this->cartService->getDiscountAmount(),
            'grand_total' => $this->cartService->getGrandTotal(),
            'cart_count'  => $this->cartService->getCartCount(),
        ]);
    }

    /**
     * Navbar cart icon-এর count রিফ্রেশ করার জন্য (optional endpoint)
     */
    public function count()
    {
        return response()->json([
            'cart_count' => $this->cartService->getCartCount(),
        ]);
    }

    /**
     * Coupon code apply করা (AJAX)
     */
    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        try {
            $coupon = $this->cartService->applyCoupon($validated['code']);
            return response()->json([
                'success'     => true,
                'message'     => 'Coupon applied successfully.',
                'coupon_code' => $coupon->code,
                'discount'    => $this->cartService->getDiscountAmount(),
                'grand_total' => $this->cartService->getGrandTotal(),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Applied coupon সরিয়ে দেওয়া (AJAX)
     */
    public function removeCoupon()
    {
        $this->cartService->removeCoupon();

        return response()->json([
            'success'     => true,
            'cart_total'  => $this->cartService->getCartTotal(),
            'discount'    => $this->cartService->getDiscountAmount(),
            'grand_total' => $this->cartService->getGrandTotal(),
        ]);
    }
}
