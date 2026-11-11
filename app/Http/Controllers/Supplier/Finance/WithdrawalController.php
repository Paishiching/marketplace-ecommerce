<?php

namespace App\Http\Controllers\Supplier\Finance;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::latest()->paginate(20);

        return view('supplier.finance.index', compact('withdrawals'));
    }

    public function create()
    {
        return view('supplier.finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Withdrawal
        ]);

        $withdrawal = Withdrawal::create($validated);

        return redirect()->route('supplier.finance.index')->with('success', 'Withdrawal created successfully.');
    }

    public function show(Withdrawal $withdrawal)
    {
        return view('supplier.finance.show', compact('withdrawal'));
    }

    public function edit(Withdrawal $withdrawal)
    {
        return view('supplier.finance.edit', compact('withdrawal'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Withdrawal
        ]);

        $withdrawal->update($validated);

        return redirect()->route('supplier.finance.index')->with('success', 'Withdrawal updated successfully.');
    }

    public function destroy(Withdrawal $withdrawal)
    {
        $withdrawal->delete();

        return redirect()->route('supplier.finance.index')->with('success', 'Withdrawal deleted successfully.');
    }
}
