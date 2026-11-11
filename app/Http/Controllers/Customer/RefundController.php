<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::latest()->paginate(20);

        return view('customer.index', compact('refunds'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Refund
        ]);

        $refund = Refund::create($validated);

        return redirect()->route('customer.index')->with('success', 'Refund created successfully.');
    }

    public function show(Refund $refund)
    {
        return view('customer.show', compact('refund'));
    }

    public function edit(Refund $refund)
    {
        return view('customer.edit', compact('refund'));
    }

    public function update(Request $request, Refund $refund)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Refund
        ]);

        $refund->update($validated);

        return redirect()->route('customer.index')->with('success', 'Refund updated successfully.');
    }

    public function destroy(Refund $refund)
    {
        $refund->delete();

        return redirect()->route('customer.index')->with('success', 'Refund deleted successfully.');
    }
}
