<?php

namespace App\Http\Controllers\Admin\Dropshipping;

use App\Http\Controllers\Controller;
use App\Models\ProductImport;
use Illuminate\Http\Request;

class ProductImportController extends Controller
{
    public function index()
    {
        $productImports = ProductImport::latest()->paginate(20);

        return view('admin.dropshipping.index', compact('productImports'));
    }

    public function create()
    {
        return view('admin.dropshipping.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for ProductImport
        ]);

        $productImport = ProductImport::create($validated);

        return redirect()->route('admin.dropshipping.index')->with('success', 'ProductImport created successfully.');
    }

    public function show(ProductImport $productImport)
    {
        return view('admin.dropshipping.show', compact('productImport'));
    }

    public function edit(ProductImport $productImport)
    {
        return view('admin.dropshipping.edit', compact('productImport'));
    }

    public function update(Request $request, ProductImport $productImport)
    {
        $validated = $request->validate([
            // TODO: add validation rules for ProductImport
        ]);

        $productImport->update($validated);

        return redirect()->route('admin.dropshipping.index')->with('success', 'ProductImport updated successfully.');
    }

    public function destroy(ProductImport $productImport)
    {
        $productImport->delete();

        return redirect()->route('admin.dropshipping.index')->with('success', 'ProductImport deleted successfully.');
    }
}
