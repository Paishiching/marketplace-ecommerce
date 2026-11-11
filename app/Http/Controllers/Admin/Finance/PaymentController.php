<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::latest()->paginate(20);

        return view('admin.finance.index', compact('payments'));
    }

    public function create()
    {
        return view('admin.finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Payment
        ]);

        $payment = Payment::create($validated);

        return redirect()->route('admin.finance.index')->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        return view('admin.finance.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('admin.finance.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Payment
        ]);

        $payment->update($validated);

        return redirect()->route('admin.finance.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.finance.index')->with('success', 'Payment deleted successfully.');
    }
}
