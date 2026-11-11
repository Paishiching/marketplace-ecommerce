<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('attributeValues')->latest()->get();

        return view('superadmin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('superadmin.attributes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:attributes,name'],
        ]);

        Attribute::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->route('superadmin.attributes.index')->with('success', 'Attribute created successfully.');
    }

    public function edit(Attribute $attribute)
    {
        return view('superadmin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:attributes,name,' . $attribute->id],
        ]);

        $attribute->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->route('superadmin.attributes.index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return back()->with('success', 'Attribute deleted successfully.');
    }

    // Add a value (e.g. "Red") under an attribute (e.g. "Color")
    public function storeValue(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'value' => ['required', 'string', 'max:255'],
        ]);

        $attribute->attributeValues()->create([
            'value' => $validated['value'],
        ]);

        return back()->with('success', 'Value added successfully.');
    }

    public function destroyValue(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return back()->with('success', 'Value deleted successfully.');
    }
}
