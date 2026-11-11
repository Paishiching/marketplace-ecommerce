<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::latest()->paginate(20);

        return view('admin.products.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Attribute
        ]);

        $attribute = Attribute::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Attribute created successfully.');
    }

    public function show(Attribute $attribute)
    {
        return view('admin.products.show', compact('attribute'));
    }

    public function edit(Attribute $attribute)
    {
        return view('admin.products.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Attribute
        ]);

        $attribute->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('admin.products.index')->with('success', 'Attribute deleted successfully.');
    }
}
