<?php

namespace App\Http\Controllers\Supplier\Products;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::latest()->paginate(20);

        return view('supplier.products.index', compact('inventories'));
    }

    public function create()
    {
        return view('supplier.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Inventory
        ]);

        $inventory = Inventory::create($validated);

        return redirect()->route('supplier.products.index')->with('success', 'Inventory created successfully.');
    }

    public function show(Inventory $inventory)
    {
        return view('supplier.products.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        return view('supplier.products.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Inventory
        ]);

        $inventory->update($validated);

        return redirect()->route('supplier.products.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('supplier.products.index')->with('success', 'Inventory deleted successfully.');
    }
}
