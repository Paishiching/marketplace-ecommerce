<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use App\Models\ResellerProduct;
use Illuminate\Http\Request;

class ResellerProductController extends Controller
{
    public function index(Request $request)
    {
        $items = ResellerProduct::with(['reseller', 'product', 'price'])
            ->when($request->filled('reseller_id'), fn ($q) => $q->where('reseller_id', $request->reseller_id))
            ->when($request->status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $resellers = Reseller::orderBy('business_name')->get(['id', 'business_name']);

        return view('superadmin.resellers.products.index', compact('items', 'resellers'));
    }

    public function toggle(ResellerProduct $resellerProduct)
    {
        $resellerProduct->update(['is_active' => ! $resellerProduct->is_active]);

        return back()->with('success', 'Product status updated.');
    }
}
