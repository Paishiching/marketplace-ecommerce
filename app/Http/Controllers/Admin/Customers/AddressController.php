<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::latest()->paginate(20);

        return view('admin.customers.index', compact('addresses'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Address
        ]);

        $address = Address::create($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Address created successfully.');
    }

    public function show(Address $address)
    {
        return view('admin.customers.show', compact('address'));
    }

    public function edit(Address $address)
    {
        return view('admin.customers.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Address
        ]);

        $address->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Address updated successfully.');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Address deleted successfully.');
    }
}
