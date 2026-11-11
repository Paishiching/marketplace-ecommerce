<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->paginate(20);

        return view('customer.index', compact('reviews'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Review
        ]);

        $review = Review::create($validated);

        return redirect()->route('customer.index')->with('success', 'Review created successfully.');
    }

    public function show(Review $review)
    {
        return view('customer.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('customer.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Review
        ]);

        $review->update($validated);

        return redirect()->route('customer.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('customer.index')->with('success', 'Review deleted successfully.');
    }
}
