<?php

namespace App\Http\Controllers\Wholesale;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WholesaleProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $wholesaler = $request->user()->wholesaler;
        $products = WholesaleProduct::with('product')
            ->withCount(['wholesaleTiers', 'bulkOrders'])
            ->where('wholesaler_id', $wholesaler->id)
            ->latest()
            ->paginate(15);

        return view('wholesale.products.index', compact('products'));
    }

    public function create(Request $request): View
    {
        $wholesaler = $request->user()->wholesaler;
        $products = Product::query()
            ->where('status', 'published')
            ->whereDoesntHave('wholesaleListing', fn ($query) => $query->where('wholesaler_id', $wholesaler->id))
            ->orderBy('name')
            ->get(['id', 'name', 'sku', 'price', 'thumbnail']);

        return view('wholesale.products.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $wholesaler = $request->user()->wholesaler;
        $data = $request->validate([
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where('status', 'published'),
                Rule::unique('wholesale_products', 'product_id')->where('wholesaler_id', $wholesaler->id),
            ],
        ]);

        WholesaleProduct::create([
            'wholesaler_id' => $wholesaler->id,
            'product_id' => $data['product_id'],
            'is_wholesale_enabled' => true,
        ]);

        return redirect()->route('wholesale.products.index')->with('success', 'Product added to your wholesale catalog.');
    }

    public function toggle(Request $request, WholesaleProduct $product): RedirectResponse
    {
        abort_unless($product->wholesaler_id === $request->user()->wholesaler?->id, 404);
        $product->update(['is_wholesale_enabled' => ! $product->is_wholesale_enabled]);

        return back()->with('success', 'Wholesale listing status updated.');
    }

    public function destroy(Request $request, WholesaleProduct $product): RedirectResponse
    {
        abort_unless($product->wholesaler_id === $request->user()->wholesaler?->id, 404);
        $product->delete();

        return back()->with('success', 'Product removed from your wholesale catalog.');
    }
}
