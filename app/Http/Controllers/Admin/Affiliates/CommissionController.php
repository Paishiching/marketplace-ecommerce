<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::latest()->paginate(20);

        return view('admin.affiliates.index', compact('commissions'));
    }

    public function create()
    {
        return view('admin.affiliates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Commission
        ]);

        $commission = Commission::create($validated);

        return redirect()->route('admin.affiliates.index')->with('success', 'Commission created successfully.');
    }

    public function show(Commission $commission)
    {
        return view('admin.affiliates.show', compact('commission'));
    }

    public function edit(Commission $commission)
    {
        return view('admin.affiliates.edit', compact('commission'));
    }

    public function update(Request $request, Commission $commission)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Commission
        ]);

        $commission->update($validated);

        return redirect()->route('admin.affiliates.index')->with('success', 'Commission updated successfully.');
    }

    public function destroy(Commission $commission)
    {
        $commission->delete();

        return redirect()->route('admin.affiliates.index')->with('success', 'Commission deleted successfully.');
    }
}
