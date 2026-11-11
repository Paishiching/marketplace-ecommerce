<?php

namespace App\Http\Controllers\Admin\Vendors;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::latest()->paginate(20);

        return view('admin.vendors.index', compact('withdrawals'));
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Withdrawal
        ]);

        $withdrawal = Withdrawal::create($validated);

        return redirect()->route('admin.vendors.index')->with('success', 'Withdrawal created successfully.');
    }

    public function show(Withdrawal $withdrawal)
    {
        return view('admin.vendors.show', compact('withdrawal'));
    }

    public function edit(Withdrawal $withdrawal)
    {
        return view('admin.vendors.edit', compact('withdrawal'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Withdrawal
        ]);

        $withdrawal->update($validated);

        return redirect()->route('admin.vendors.index')->with('success', 'Withdrawal updated successfully.');
    }

    public function destroy(Withdrawal $withdrawal)
    {
        $withdrawal->delete();

        return redirect()->route('admin.vendors.index')->with('success', 'Withdrawal deleted successfully.');
    }
}
