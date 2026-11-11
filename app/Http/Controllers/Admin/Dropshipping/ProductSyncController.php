<?php

namespace App\Http\Controllers\Admin\Dropshipping;

use App\Http\Controllers\Controller;
use App\Models\ProductSync;
use Illuminate\Http\Request;

class ProductSyncController extends Controller
{
    public function index()
    {
        $productSyncs = ProductSync::latest()->paginate(20);

        return view('admin.dropshipping.index', compact('productSyncs'));
    }

    public function create()
    {
        return view('admin.dropshipping.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for ProductSync
        ]);

        $productSync = ProductSync::create($validated);

        return redirect()->route('admin.dropshipping.index')->with('success', 'ProductSync created successfully.');
    }

    public function show(ProductSync $productSync)
    {
        return view('admin.dropshipping.show', compact('productSync'));
    }

    public function edit(ProductSync $productSync)
    {
        return view('admin.dropshipping.edit', compact('productSync'));
    }

    public function update(Request $request, ProductSync $productSync)
    {
        $validated = $request->validate([
            // TODO: add validation rules for ProductSync
        ]);

        $productSync->update($validated);

        return redirect()->route('admin.dropshipping.index')->with('success', 'ProductSync updated successfully.');
    }

    public function destroy(ProductSync $productSync)
    {
        $productSync->delete();

        return redirect()->route('admin.dropshipping.index')->with('success', 'ProductSync deleted successfully.');
    }
}
