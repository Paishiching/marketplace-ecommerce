<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Login kora user-er customer row (na thakle toiri hobe)
    private function customerId(): int
    {
        $user = Auth::user();

        $customer = Customer::firstOrCreate(
            ['user_id' => $user->id],
            ['name' => $user->name, 'email' => $user->email]
        );

        return $customer->id;
    }

    // Guest hole login e pathao (AJAX hole 401 JSON, normal hole redirect)
    private function guestResponse(Request $request)
    {
        $loginUrl = route('otp.login');

        if ($request->expectsJson()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Please login to use wishlist.',
                'redirect' => $loginUrl,
            ], 401);
        }

        if ($request->isMethod('get')) {
            session()->put('url.intended', $request->fullUrl());
        }

        return redirect($loginUrl)->with('error', 'Please login to use wishlist.');
    }

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return $this->guestResponse($request);
        }

        $wishlist = Wishlist::firstOrCreate(['customer_id' => $this->customerId()]);

        // /wishlist-index?product_id=59 : product ta wishlist e add kore clean URL e redirect
        if ($request->filled('product_id')) {
            $pid = (int) $request->query('product_id');

            if (\App\Models\Product::whereKey($pid)->exists()
                && !$wishlist->items()->where('product_id', $pid)->exists()) {
                $wishlist->items()->create(['product_id' => $pid]);
            }

            return redirect()->route($request->route()->getName() ?: 'wishlist.index');
        }

        $items = $wishlist->items()
            ->with(['product' => function ($q) {
                $q->with('primaryImage');
            }])
            ->whereHas('product')
            ->latest()
            ->get();

        return view('frontend.wishlist.index', compact('items'));
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return $this->guestResponse($request);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::firstOrCreate(['customer_id' => $this->customerId()]);

        $item = $wishlist->items()->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->delete();
            $added   = false;
            $message = 'Product removed from wishlist.';
        } else {
            $wishlist->items()->create(['product_id' => $request->product_id]);
            $added   = true;
            $message = 'Product added to wishlist.';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'status'  => true,
                'added'   => $added,
                'message' => $message,
                'count'   => $wishlist->items()->count(),
            ]);
        }

        return back()->with('success', $message);
    }

    public function destroy(Request $request, WishlistItem $item)
    {
        if (!Auth::check()) {
            return $this->guestResponse($request);
        }

        abort_unless(
            $item->wishlist && $item->wishlist->customer_id === $this->customerId(),
            403
        );

        $item->delete();

        return back()->with('success', 'Product removed from wishlist.');
    }
}