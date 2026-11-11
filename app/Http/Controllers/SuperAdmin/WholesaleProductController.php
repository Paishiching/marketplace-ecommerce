<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WholesaleProduct;
use Illuminate\Http\Request;

class WholesaleProductController extends Controller
{
    public function index()
    {
        $items = WholesaleProduct::with('product')->latest()->paginate(15);

        $availableProducts = Product::whereNotIn('id', WholesaleProduct::pluck('product_id'))
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('superadmin.wholesale.products.index', compact('items', 'availableProducts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id|unique:wholesale_products,product_id',
        ]);

        WholesaleProduct::create($data + ['is_wholesale_enabled' => true]);

        return back()->with('success', 'Product added to wholesale.');
    }

    public function toggle(WholesaleProduct $wholesaleProduct)
    {
        $wholesaleProduct->update(['is_wholesale_enabled' => ! $wholesaleProduct->is_wholesale_enabled]);

        return back()->with('success', 'Wholesale status updated.');
    }

    public function destroy(WholesaleProduct $wholesaleProduct)
    {
        $wholesaleProduct->delete();

        return back()->with('success', 'Product removed from wholesale.');
    }
}
