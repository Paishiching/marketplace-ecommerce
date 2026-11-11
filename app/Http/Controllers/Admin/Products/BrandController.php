<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(20);

        return view('admin.products.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Brand
        ]);

        $brand = Brand::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand)
    {
        return view('admin.products.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('admin.products.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Brand
        ]);

        $brand->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('admin.products.index')->with('success', 'Brand deleted successfully.');
    }
}
