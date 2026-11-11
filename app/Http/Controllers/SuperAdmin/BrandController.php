<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(20);

        return view('superadmin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('superadmin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:brands,slug'],
            'description' => ['nullable', 'string'],
            'logo'        => ['nullable', 'image', 'max:1024'],
            'status'      => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? $this->generateUniqueSlug($validated['name']);
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        Brand::create($validated);

        return redirect()->route('superadmin.brands.index')->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand)
    {
        return view('superadmin.brands.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('superadmin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:brands,slug,' . $brand->id],
            'description' => ['nullable', 'string'],
            'logo'        => ['nullable', 'image', 'max:1024'],
            'status'      => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? $brand->slug;
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('logo')) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }

            $validated['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $brand->update($validated);

        return redirect()->route('superadmin.brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('superadmin.brands.index')->with('success', 'Brand deleted successfully.');
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Brand::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
