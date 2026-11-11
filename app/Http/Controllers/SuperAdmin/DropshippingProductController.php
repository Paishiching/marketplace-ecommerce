<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DropshippingProduct;
use Illuminate\Http\Request;

class DropshippingProductController extends Controller
{
    public function index(Request $request)
    {
        $items = DropshippingProduct::with(['vendor', 'product', 'supplierProduct.supplier'])
            ->when($request->status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('superadmin.dropshipping.products.index', compact('items'));
    }

    public function toggle(DropshippingProduct $dropshippingProduct)
    {
        $dropshippingProduct->update(['is_active' => ! $dropshippingProduct->is_active]);

        return back()->with('success', 'Product status updated.');
    }
}
