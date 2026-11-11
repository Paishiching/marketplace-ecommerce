<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index()
    {
        $affiliates = Affiliate::latest()->paginate(20);

        return view('admin.affiliates.index', compact('affiliates'));
    }

    public function create()
    {
        return view('admin.affiliates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Affiliate
        ]);

        $affiliate = Affiliate::create($validated);

        return redirect()->route('admin.affiliates.index')->with('success', 'Affiliate created successfully.');
    }

    public function show(Affiliate $affiliate)
    {
        return view('admin.affiliates.show', compact('affiliate'));
    }

    public function edit(Affiliate $affiliate)
    {
        return view('admin.affiliates.edit', compact('affiliate'));
    }

    public function update(Request $request, Affiliate $affiliate)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Affiliate
        ]);

        $affiliate->update($validated);

        return redirect()->route('admin.affiliates.index')->with('success', 'Affiliate updated successfully.');
    }

    public function destroy(Affiliate $affiliate)
    {
        $affiliate->delete();

        return redirect()->route('admin.affiliates.index')->with('success', 'Affiliate deleted successfully.');
    }
}
