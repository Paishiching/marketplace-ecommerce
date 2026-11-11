<?php

namespace App\Http\Controllers\Admin\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::latest()->paginate(20);

        return view('admin.suppliers.index', compact('inventories'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Inventory
        ]);

        $inventory = Inventory::create($validated);

        return redirect()->route('admin.suppliers.index')->with('success', 'Inventory created successfully.');
    }

    public function show(Inventory $inventory)
    {
        return view('admin.suppliers.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        return view('admin.suppliers.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Inventory
        ]);

        $inventory->update($validated);

        return redirect()->route('admin.suppliers.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('admin.suppliers.index')->with('success', 'Inventory deleted successfully.');
    }
}
