<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WarrantyRegistrationController extends Controller
{
    public function index()
    {
        // নতুন record সবার আগে (DataTable নিজে search/pagination করবে)
        $warranties = WarrantyRegistration::latest('id')->get();

        return view('superadmin.warranties.index', compact('warranties'));
    }

    public function create()
    {
        return view('superadmin.warranties.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        WarrantyRegistration::create($validated);

        return redirect()->route('superadmin.warranties.index')
            ->with('success', 'Warranty record created successfully.');
    }

    public function edit(WarrantyRegistration $warranty)
    {
        return view('superadmin.warranties.edit', compact('warranty'));
    }

    public function update(Request $request, WarrantyRegistration $warranty)
    {
        $validated = $this->validated($request, $warranty);

        $warranty->update($validated);

        return redirect(route('superadmin.warranties.index') . '#warranty-' . $warranty->id)
            ->with('success', 'Warranty record updated successfully.');
    }

    public function destroy(WarrantyRegistration $warranty)
    {
        $warranty->delete();

        return redirect()->route('superadmin.warranties.index')
            ->with('success', 'Warranty record deleted successfully.');
    }

    private function validated(Request $request, ?WarrantyRegistration $warranty = null): array
    {
        // S/N: space bad diye UPPERCASE e save (frontend search er sathe mil rakhte)
        $request->merge([
            'serial_number' => strtoupper(preg_replace('/\s+/', '', (string) $request->input('serial_number'))),
        ]);

        return $request->validate([
            'serial_number'   => [
                'required', 'string', 'max:60',
                Rule::unique('warranty_registrations', 'serial_number')->ignore($warranty?->id),
            ],
            'product_name'    => ['nullable', 'string', 'max:255'],
            'customer_name'   => ['nullable', 'string', 'max:255'],
            'phone'           => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s]{10,20}$/'],
            'purchase_date'   => ['required', 'date'],
            'warranty_months' => ['required', 'integer', 'min:1', 'max:240'],
        ], [
            'phone.regex' => 'Please enter a valid mobile number.',
        ]);
    }
}