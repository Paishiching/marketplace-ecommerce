<?php

namespace App\Http\Controllers\Vendor\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->paginate(20);

        return view('vendor.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('vendor.reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Review
        ]);

        $review = Review::create($validated);

        return redirect()->route('vendor.reviews.index')->with('success', 'Review created successfully.');
    }

    public function show(Review $review)
    {
        return view('vendor.reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('vendor.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Review
        ]);

        $review->update($validated);

        return redirect()->route('vendor.reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('vendor.reviews.index')->with('success', 'Review deleted successfully.');
    }
}
