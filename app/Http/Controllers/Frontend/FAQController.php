<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $fAQs = FAQ::latest()->paginate(20);

        return view('frontend.index', compact('fAQs'));
    }

    public function create()
    {
        return view('frontend.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for FAQ
        ]);

        $fAQ = FAQ::create($validated);

        return redirect()->route('frontend.index')->with('success', 'FAQ created successfully.');
    }

    public function show(FAQ $fAQ)
    {
        return view('frontend.show', compact('fAQ'));
    }

    public function edit(FAQ $fAQ)
    {
        return view('frontend.edit', compact('fAQ'));
    }

    public function update(Request $request, FAQ $fAQ)
    {
        $validated = $request->validate([
            // TODO: add validation rules for FAQ
        ]);

        $fAQ->update($validated);

        return redirect()->route('frontend.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(FAQ $fAQ)
    {
        $fAQ->delete();

        return redirect()->route('frontend.index')->with('success', 'FAQ deleted successfully.');
    }
}
