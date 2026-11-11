<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::latest()->paginate(20);

        return view('customer.index', compact('wishlists'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Wishlist
        ]);

        $wishlist = Wishlist::create($validated);

        return redirect()->route('customer.index')->with('success', 'Wishlist created successfully.');
    }

    public function show(Wishlist $wishlist)
    {
        return view('customer.show', compact('wishlist'));
    }

    public function edit(Wishlist $wishlist)
    {
        return view('customer.edit', compact('wishlist'));
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Wishlist
        ]);

        $wishlist->update($validated);

        return redirect()->route('customer.index')->with('success', 'Wishlist updated successfully.');
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();

        return redirect()->route('customer.index')->with('success', 'Wishlist deleted successfully.');
    }
}
