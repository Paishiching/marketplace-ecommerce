<?php

namespace App\Http\Controllers\Admin\Wholesale;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(20);

        return view('admin.wholesale.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.wholesale.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Customer
        ]);

        $customer = Customer::create($validated);

        return redirect()->route('admin.wholesale.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('admin.wholesale.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.wholesale.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Customer
        ]);

        $customer->update($validated);

        return redirect()->route('admin.wholesale.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.wholesale.index')->with('success', 'Customer deleted successfully.');
    }
}
