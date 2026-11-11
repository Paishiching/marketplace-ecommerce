<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::latest()->paginate(20);

        return response()->json($carts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Cart
        ]);

        $cart = Cart::create($validated);

        return response()->json($cart, 201);
    }

    public function show(Cart $cart)
    {
        return response()->json($cart);
    }

    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Cart
        ]);

        $cart->update($validated);

        return response()->json($cart);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json(null, 204);
    }
}
