<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\ResellerBalance;
use Illuminate\Http\Request;

class ResellerBalanceController extends Controller
{
    public function index()
    {
        $resellerBalances = ResellerBalance::latest()->paginate(20);

        return view('admin.finance.index', compact('resellerBalances'));
    }

    public function create()
    {
        return view('admin.finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for ResellerBalance
        ]);

        $resellerBalance = ResellerBalance::create($validated);

        return redirect()->route('admin.finance.index')->with('success', 'ResellerBalance created successfully.');
    }

    public function show(ResellerBalance $resellerBalance)
    {
        return view('admin.finance.show', compact('resellerBalance'));
    }

    public function edit(ResellerBalance $resellerBalance)
    {
        return view('admin.finance.edit', compact('resellerBalance'));
    }

    public function update(Request $request, ResellerBalance $resellerBalance)
    {
        $validated = $request->validate([
            // TODO: add validation rules for ResellerBalance
        ]);

        $resellerBalance->update($validated);

        return redirect()->route('admin.finance.index')->with('success', 'ResellerBalance updated successfully.');
    }

    public function destroy(ResellerBalance $resellerBalance)
    {
        $resellerBalance->delete();

        return redirect()->route('admin.finance.index')->with('success', 'ResellerBalance deleted successfully.');
    }
}
