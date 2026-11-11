<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate(20);

        return view('admin.finance.index', compact('transactions'));
    }

    public function create()
    {
        return view('admin.finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Transaction
        ]);

        $transaction = Transaction::create($validated);

        return redirect()->route('admin.finance.index')->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        return view('admin.finance.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        return view('admin.finance.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Transaction
        ]);

        $transaction->update($validated);

        return redirect()->route('admin.finance.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('admin.finance.index')->with('success', 'Transaction deleted successfully.');
    }
}
