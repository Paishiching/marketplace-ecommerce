<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(20);

        return view('reseller.index', compact('products'));
    }

    public function create()
    {
        return view('reseller.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Product
        ]);

        $product = Product::create($validated);

        return redirect()->route('reseller.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('reseller.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('reseller.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Product
        ]);

        $product->update($validated);

        return redirect()->route('reseller.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('reseller.index')->with('success', 'Product deleted successfully.');
    }
}
