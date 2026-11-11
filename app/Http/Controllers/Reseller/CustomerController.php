<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(20);

        return view('reseller.index', compact('customers'));
    }

    public function create()
    {
        return view('reseller.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Customer
        ]);

        $customer = Customer::create($validated);

        return redirect()->route('reseller.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('reseller.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('reseller.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Customer
        ]);

        $customer->update($validated);

        return redirect()->route('reseller.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('reseller.index')->with('success', 'Customer deleted successfully.');
    }
}
