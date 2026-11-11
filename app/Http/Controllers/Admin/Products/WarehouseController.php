<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(20);

        return view('admin.products.index', compact('warehouses'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Warehouse
        ]);

        $warehouse = Warehouse::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Warehouse created successfully.');
    }

    public function show(Warehouse $warehouse)
    {
        return view('admin.products.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('admin.products.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Warehouse
        ]);

        $warehouse->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return redirect()->route('admin.products.index')->with('success', 'Warehouse deleted successfully.');
    }
}
