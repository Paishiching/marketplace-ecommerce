<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\AffiliateBalance;
use Illuminate\Http\Request;

class AffiliateBalanceController extends Controller
{
    public function index()
    {
        $affiliateBalances = AffiliateBalance::latest()->paginate(20);

        return view('admin.finance.index', compact('affiliateBalances'));
    }

    public function create()
    {
        return view('admin.finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for AffiliateBalance
        ]);

        $affiliateBalance = AffiliateBalance::create($validated);

        return redirect()->route('admin.finance.index')->with('success', 'AffiliateBalance created successfully.');
    }

    public function show(AffiliateBalance $affiliateBalance)
    {
        return view('admin.finance.show', compact('affiliateBalance'));
    }

    public function edit(AffiliateBalance $affiliateBalance)
    {
        return view('admin.finance.edit', compact('affiliateBalance'));
    }

    public function update(Request $request, AffiliateBalance $affiliateBalance)
    {
        $validated = $request->validate([
            // TODO: add validation rules for AffiliateBalance
        ]);

        $affiliateBalance->update($validated);

        return redirect()->route('admin.finance.index')->with('success', 'AffiliateBalance updated successfully.');
    }

    public function destroy(AffiliateBalance $affiliateBalance)
    {
        $affiliateBalance->delete();

        return redirect()->route('admin.finance.index')->with('success', 'AffiliateBalance deleted successfully.');
    }
}
