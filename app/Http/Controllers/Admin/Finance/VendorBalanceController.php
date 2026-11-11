<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\VendorBalance;
use Illuminate\Http\Request;

class VendorBalanceController extends Controller
{
    public function index()
    {
        $vendorBalances = VendorBalance::latest()->paginate(20);

        return view('admin.finance.index', compact('vendorBalances'));
    }

    public function create()
    {
        return view('admin.finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for VendorBalance
        ]);

        $vendorBalance = VendorBalance::create($validated);

        return redirect()->route('admin.finance.index')->with('success', 'VendorBalance created successfully.');
    }

    public function show(VendorBalance $vendorBalance)
    {
        return view('admin.finance.show', compact('vendorBalance'));
    }

    public function edit(VendorBalance $vendorBalance)
    {
        return view('admin.finance.edit', compact('vendorBalance'));
    }

    public function update(Request $request, VendorBalance $vendorBalance)
    {
        $validated = $request->validate([
            // TODO: add validation rules for VendorBalance
        ]);

        $vendorBalance->update($validated);

        return redirect()->route('admin.finance.index')->with('success', 'VendorBalance updated successfully.');
    }

    public function destroy(VendorBalance $vendorBalance)
    {
        $vendorBalance->delete();

        return redirect()->route('admin.finance.index')->with('success', 'VendorBalance deleted successfully.');
    }
}
