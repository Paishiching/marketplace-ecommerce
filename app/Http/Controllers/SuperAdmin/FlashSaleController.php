<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flashSales = FlashSale::latest()->paginate(20);

        return view('super-admin.index', compact('flashSales'));
    }

    public function create()
    {
        return view('super-admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for FlashSale
        ]);

        $flashSale = FlashSale::create($validated);

        return redirect()->route('super-admin.index')->with('success', 'FlashSale created successfully.');
    }

    public function show(FlashSale $flashSale)
    {
        return view('super-admin.show', compact('flashSale'));
    }

    public function edit(FlashSale $flashSale)
    {
        return view('super-admin.edit', compact('flashSale'));
    }

    public function update(Request $request, FlashSale $flashSale)
    {
        $validated = $request->validate([
            // TODO: add validation rules for FlashSale
        ]);

        $flashSale->update($validated);

        return redirect()->route('super-admin.index')->with('success', 'FlashSale updated successfully.');
    }

    public function destroy(FlashSale $flashSale)
    {
        $flashSale->delete();

        return redirect()->route('super-admin.index')->with('success', 'FlashSale deleted successfully.');
    }
}
