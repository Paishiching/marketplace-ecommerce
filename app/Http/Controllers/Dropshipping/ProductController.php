<?php

namespace App\Http\Controllers\Dropshipping;

use App\Http\Controllers\Controller;
use App\Models\DropshipperProduct;
use App\Models\SupplierProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $partner = $request->user()->dropshipper;
        $products = DropshipperProduct::with(['supplierProduct.supplier'])
            ->where('dropshipper_id', $partner->id)
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = trim($request->string('search')->toString());
                $query->whereHas('supplierProduct', fn ($supplierProduct) => $supplierProduct->where('name', 'like', "%{$term}%")->orWhere('sku', 'like', "%{$term}%"));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dropshipping.products.index', compact('products'));
    }

    public function create(Request $request): View
    {
        $partner = $request->user()->dropshipper;
        $availableProducts = SupplierProduct::with('supplier')
            ->whereIn('status', ['approved', 'active', 'published'])
            ->whereHas('supplier', fn ($query) => $query->where('status', 'approved'))
            ->whereDoesntHave('dropshipperProducts', fn ($query) => $query->where('dropshipper_id', $partner->id))
            ->orderBy('name')
            ->get();

        return view('dropshipping.products.create', compact('availableProducts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $partner = $request->user()->dropshipper;
        $data = $request->validate([
            'supplier_product_id' => [
                'required',
                'integer',
                Rule::exists('supplier_products', 'id')->whereIn('status', ['approved', 'active', 'published']),
                Rule::unique('dropshipper_products', 'supplier_product_id')->where('dropshipper_id', $partner->id),
            ],
            'markup_price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
        ]);

        $supplierProduct = SupplierProduct::with('supplier')
            ->whereKey($data['supplier_product_id'])
            ->whereHas('supplier', fn ($query) => $query->where('status', 'approved'))
            ->firstOrFail();

        DropshipperProduct::create([
            'dropshipper_id' => $partner->id,
            'supplier_product_id' => $supplierProduct->id,
            'markup_price' => $data['markup_price'],
            'is_active' => true,
        ]);

        return redirect()->route('dropshipping.products.index')->with('success', 'Product added to your dropshipping catalog.');
    }

    public function toggle(Request $request, DropshipperProduct $product): RedirectResponse
    {
        abort_unless($product->dropshipper_id === $request->user()->dropshipper?->id, 404);
        $product->update(['is_active' => ! $product->is_active]);

        return back()->with('success', 'Product status updated.');
    }

    public function destroy(Request $request, DropshipperProduct $product): RedirectResponse
    {
        abort_unless($product->dropshipper_id === $request->user()->dropshipper?->id, 404);
        $product->delete();

        return back()->with('success', 'Product removed from your catalog.');
    }
}
