<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(20);

        return view('admin.marketing.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.marketing.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Promotion
        ]);

        $promotion = Promotion::create($validated);

        return redirect()->route('admin.marketing.index')->with('success', 'Promotion created successfully.');
    }

    public function show(Promotion $promotion)
    {
        return view('admin.marketing.show', compact('promotion'));
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.marketing.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Promotion
        ]);

        $promotion->update($validated);

        return redirect()->route('admin.marketing.index')->with('success', 'Promotion updated successfully.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.marketing.index')->with('success', 'Promotion deleted successfully.');
    }
}
