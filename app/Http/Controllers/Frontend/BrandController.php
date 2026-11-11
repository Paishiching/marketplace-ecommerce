<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::query()
            ->where('status', true)
            ->whereHas('products', fn ($query) => $query->where('status', 1))
            ->orderBy('name')
            ->paginate(48);

        return view('frontend.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('frontend.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Brand
        ]);

        $brand = Brand::create($validated);

        return redirect()->route('frontend.index')->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand)
    {
        return view('frontend.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('frontend.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Brand
        ]);

        $brand->update($validated);

        return redirect()->route('frontend.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('frontend.index')->with('success', 'Brand deleted successfully.');
    }
}
