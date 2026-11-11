<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function index()
    {
        $couriers = Courier::latest()->paginate(20);

        return view('admin.delivery.index', compact('couriers'));
    }

    public function create()
    {
        return view('admin.delivery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Courier
        ]);

        $courier = Courier::create($validated);

        return redirect()->route('admin.delivery.index')->with('success', 'Courier created successfully.');
    }

    public function show(Courier $courier)
    {
        return view('admin.delivery.show', compact('courier'));
    }

    public function edit(Courier $courier)
    {
        return view('admin.delivery.edit', compact('courier'));
    }

    public function update(Request $request, Courier $courier)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Courier
        ]);

        $courier->update($validated);

        return redirect()->route('admin.delivery.index')->with('success', 'Courier updated successfully.');
    }

    public function destroy(Courier $courier)
    {
        $courier->delete();

        return redirect()->route('admin.delivery.index')->with('success', 'Courier deleted successfully.');
    }
}
