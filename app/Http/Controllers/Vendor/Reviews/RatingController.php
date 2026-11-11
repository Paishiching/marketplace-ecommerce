<?php

namespace App\Http\Controllers\Vendor\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::latest()->paginate(20);

        return view('vendor.reviews.index', compact('ratings'));
    }

    public function create()
    {
        return view('vendor.reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Rating
        ]);

        $rating = Rating::create($validated);

        return redirect()->route('vendor.reviews.index')->with('success', 'Rating created successfully.');
    }

    public function show(Rating $rating)
    {
        return view('vendor.reviews.show', compact('rating'));
    }

    public function edit(Rating $rating)
    {
        return view('vendor.reviews.edit', compact('rating'));
    }

    public function update(Request $request, Rating $rating)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Rating
        ]);

        $rating->update($validated);

        return redirect()->route('vendor.reviews.index')->with('success', 'Rating updated successfully.');
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();

        return redirect()->route('vendor.reviews.index')->with('success', 'Rating deleted successfully.');
    }
}
