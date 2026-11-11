<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::latest()->paginate(20);

        return response()->json($wishlists);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Wishlist
        ]);

        $wishlist = Wishlist::create($validated);

        return response()->json($wishlist, 201);
    }

    public function show(Wishlist $wishlist)
    {
        return response()->json($wishlist);
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Wishlist
        ]);

        $wishlist->update($validated);

        return response()->json($wishlist);
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();

        return response()->json(null, 204);
    }
}
