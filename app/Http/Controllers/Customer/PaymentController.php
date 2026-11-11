<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::latest()->paginate(20);

        return view('customer.index', compact('payments'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Payment
        ]);

        $payment = Payment::create($validated);

        return redirect()->route('customer.index')->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        return view('customer.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('customer.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Payment
        ]);

        $payment->update($validated);

        return redirect()->route('customer.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('customer.index')->with('success', 'Payment deleted successfully.');
    }
}
