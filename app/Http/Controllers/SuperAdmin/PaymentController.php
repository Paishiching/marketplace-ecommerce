<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::latest()->paginate(20);

        return view('super-admin.index', compact('payments'));
    }

    public function create()
    {
        return view('super-admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Payment
        ]);

        $payment = Payment::create($validated);

        return redirect()->route('super-admin.index')->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        return view('super-admin.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('super-admin.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Payment
        ]);

        $payment->update($validated);

        return redirect()->route('super-admin.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('super-admin.index')->with('success', 'Payment deleted successfully.');
    }
}
