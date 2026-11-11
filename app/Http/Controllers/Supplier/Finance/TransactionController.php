<?php

namespace App\Http\Controllers\Supplier\Finance;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate(20);

        return view('supplier.finance.index', compact('transactions'));
    }

    public function create()
    {
        return view('supplier.finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Transaction
        ]);

        $transaction = Transaction::create($validated);

        return redirect()->route('supplier.finance.index')->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        return view('supplier.finance.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        return view('supplier.finance.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Transaction
        ]);

        $transaction->update($validated);

        return redirect()->route('supplier.finance.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('supplier.finance.index')->with('success', 'Transaction deleted successfully.');
    }
}
