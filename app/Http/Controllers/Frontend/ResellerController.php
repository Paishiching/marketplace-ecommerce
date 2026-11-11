<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use Illuminate\Http\Request;

class ResellerController extends Controller
{
    public function index()
    {
        $resellers = Reseller::latest()->paginate(20);

        return view('frontend.index', compact('resellers'));
    }

    public function create()
    {
        return view('frontend.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Reseller
        ]);

        $reseller = Reseller::create($validated);

        return redirect()->route('frontend.index')->with('success', 'Reseller created successfully.');
    }

    public function show(Reseller $reseller)
    {
        return view('frontend.show', compact('reseller'));
    }

    public function edit(Reseller $reseller)
    {
        return view('frontend.edit', compact('reseller'));
    }

    public function update(Request $request, Reseller $reseller)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Reseller
        ]);

        $reseller->update($validated);

        return redirect()->route('frontend.index')->with('success', 'Reseller updated successfully.');
    }

    public function destroy(Reseller $reseller)
    {
        $reseller->delete();

        return redirect()->route('frontend.index')->with('success', 'Reseller deleted successfully.');
    }
}
