<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::latest()->paginate(20);

        return view('admin.orders.index', compact('refunds'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Refund
        ]);

        $refund = Refund::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Refund created successfully.');
    }

    public function show(Refund $refund)
    {
        return view('admin.orders.show', compact('refund'));
    }

    public function edit(Refund $refund)
    {
        return view('admin.orders.edit', compact('refund'));
    }

    public function update(Request $request, Refund $refund)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Refund
        ]);

        $refund->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Refund updated successfully.');
    }

    public function destroy(Refund $refund)
    {
        $refund->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Refund deleted successfully.');
    }
}
