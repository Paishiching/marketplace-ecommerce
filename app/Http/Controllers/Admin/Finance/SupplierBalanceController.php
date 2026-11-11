<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\SupplierBalance;
use Illuminate\Http\Request;

class SupplierBalanceController extends Controller
{
    public function index()
    {
        $supplierBalances = SupplierBalance::latest()->paginate(20);

        return view('admin.finance.index', compact('supplierBalances'));
    }

    public function create()
    {
        return view('admin.finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for SupplierBalance
        ]);

        $supplierBalance = SupplierBalance::create($validated);

        return redirect()->route('admin.finance.index')->with('success', 'SupplierBalance created successfully.');
    }

    public function show(SupplierBalance $supplierBalance)
    {
        return view('admin.finance.show', compact('supplierBalance'));
    }

    public function edit(SupplierBalance $supplierBalance)
    {
        return view('admin.finance.edit', compact('supplierBalance'));
    }

    public function update(Request $request, SupplierBalance $supplierBalance)
    {
        $validated = $request->validate([
            // TODO: add validation rules for SupplierBalance
        ]);

        $supplierBalance->update($validated);

        return redirect()->route('admin.finance.index')->with('success', 'SupplierBalance updated successfully.');
    }

    public function destroy(SupplierBalance $supplierBalance)
    {
        $supplierBalance->delete();

        return redirect()->route('admin.finance.index')->with('success', 'SupplierBalance deleted successfully.');
    }
}
