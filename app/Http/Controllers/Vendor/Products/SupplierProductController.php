<?php

namespace App\Http\Controllers\Vendor\Products;

use App\Http\Controllers\Controller;
use App\Models\SupplierProduct;
use Illuminate\Http\Request;

class SupplierProductController extends Controller
{
    public function index()
    {
        $supplierProducts = SupplierProduct::latest()->paginate(20);

        return view('vendor.products.index', compact('supplierProducts'));
    }

    public function create()
    {
        return view('vendor.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for SupplierProduct
        ]);

        $supplierProduct = SupplierProduct::create($validated);

        return redirect()->route('vendor.products.index')->with('success', 'SupplierProduct created successfully.');
    }

    public function show(SupplierProduct $supplierProduct)
    {
        return view('vendor.products.show', compact('supplierProduct'));
    }

    public function edit(SupplierProduct $supplierProduct)
    {
        return view('vendor.products.edit', compact('supplierProduct'));
    }

    public function update(Request $request, SupplierProduct $supplierProduct)
    {
        $validated = $request->validate([
            // TODO: add validation rules for SupplierProduct
        ]);

        $supplierProduct->update($validated);

        return redirect()->route('vendor.products.index')->with('success', 'SupplierProduct updated successfully.');
    }

    public function destroy(SupplierProduct $supplierProduct)
    {
        $supplierProduct->delete();

        return redirect()->route('vendor.products.index')->with('success', 'SupplierProduct deleted successfully.');
    }
}
