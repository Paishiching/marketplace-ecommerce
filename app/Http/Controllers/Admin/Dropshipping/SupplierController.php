<?php

namespace App\Http\Controllers\Admin\Dropshipping;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(20);

        return view('admin.dropshipping.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.dropshipping.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Supplier
        ]);

        $supplier = Supplier::create($validated);

        return redirect()->route('admin.dropshipping.index')->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
    {
        return view('admin.dropshipping.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.dropshipping.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Supplier
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.dropshipping.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('admin.dropshipping.index')->with('success', 'Supplier deleted successfully.');
    }
}
