<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::latest()->paginate(20);

        return view('customer.index', compact('carts'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Cart
        ]);

        $cart = Cart::create($validated);

        return redirect()->route('customer.index')->with('success', 'Cart created successfully.');
    }

    public function show(Cart $cart)
    {
        return view('customer.show', compact('cart'));
    }

    public function edit(Cart $cart)
    {
        return view('customer.edit', compact('cart'));
    }

    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Cart
        ]);

        $cart->update($validated);

        return redirect()->route('customer.index')->with('success', 'Cart updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('customer.index')->with('success', 'Cart deleted successfully.');
    }
}
