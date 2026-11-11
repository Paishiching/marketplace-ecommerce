<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flashSales = FlashSale::latest()->paginate(20);

        return view('admin.marketing.index', compact('flashSales'));
    }

    public function create()
    {
        return view('admin.marketing.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for FlashSale
        ]);

        $flashSale = FlashSale::create($validated);

        return redirect()->route('admin.marketing.index')->with('success', 'FlashSale created successfully.');
    }

    public function show(FlashSale $flashSale)
    {
        return view('admin.marketing.show', compact('flashSale'));
    }

    public function edit(FlashSale $flashSale)
    {
        return view('admin.marketing.edit', compact('flashSale'));
    }

    public function update(Request $request, FlashSale $flashSale)
    {
        $validated = $request->validate([
            // TODO: add validation rules for FlashSale
        ]);

        $flashSale->update($validated);

        return redirect()->route('admin.marketing.index')->with('success', 'FlashSale updated successfully.');
    }

    public function destroy(FlashSale $flashSale)
    {
        $flashSale->delete();

        return redirect()->route('admin.marketing.index')->with('success', 'FlashSale deleted successfully.');
    }
}
