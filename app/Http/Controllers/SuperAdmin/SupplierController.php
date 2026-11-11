<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Supplier;

class SupplierController extends PartnerController
{
    protected function cfg(): array
    {
        return [
            'model'  => Supplier::class,
            'role'   => 'supplier',
            'title'  => 'Suppliers',
            'prefix' => 'superadmin.suppliers',
            'name'   => 'company_name',
            'rate'   => null,
            'rate_label' => null,
            'verify' => true,
        ];
    }
}


//    public function index(Request $request)
//    {
//        $suppliers = Supplier::with('user')
//            ->when($request->filled('search'), function ($query) use ($request) {
//                $search = $request->input('search');
//
//                $query->where(function ($q) use ($search) {
//                    $q->where('company_name', 'like', "%{$search}%")
//                        ->orWhereHas('user', function ($u) use ($search) {
//                            $u->where('name', 'like', "%{$search}%")
//                                ->orWhere('email', 'like', "%{$search}%");
//                        });
//                });
//            })
//            ->when($request->filled('status'), function ($query) use ($request) {
//                $query->where('status', $request->input('status'));
//            })
//            ->latest()
//            ->paginate(20)
//            ->withQueryString();
//
//        return view('superadmin.suppliers.index', compact('suppliers'));
//    }
//
//    public function create()
//    {
//        $users = User::doesntHave('supplier')->get(['id', 'name', 'email']);
//
//        return view('superadmin.suppliers.create', compact('users'));
//    }
//
//    public function store(Request $request)
//    {
//        $validated = $request->validate([
//            'user_id'      => ['required', 'exists:users,id', 'unique:suppliers,user_id'],
//            'company_name' => ['required', 'string', 'max:255'],
//            'company_slug' => ['nullable', 'string', 'max:255', 'unique:suppliers,company_slug'],
//            'description'  => ['nullable', 'string'],
//            'status'       => ['required', 'in:pending,approved,suspended'],
//            'logo'         => ['required', 'image', 'max:2048'],
//        ]);
//
//        $logoPath = $request->file('logo')->store('suppliers/logos', 'public');
//
//        try {
//            Supplier::create([
//                'user_id'      => $validated['user_id'],
//                'company_name' => $validated['company_name'],
//                'company_slug' => $validated['company_slug'] ?? $this->generateUniqueSlug($validated['company_name']),
//                'description'  => $validated['description'] ?? null,
//                'status'       => $validated['status'],
//                'is_verified'  => $validated['status'] === 'approved',
//                'logo'         => $logoPath,
//            ]);
//        } catch (\Throwable $e) {
//            Storage::disk('public')->delete($logoPath);
//
//            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
//        }
//
//        return redirect()->route('superadmin.suppliers.index')
//            ->with('success', 'Supplier created successfully.');
//    }
//
//    public function show(Supplier $supplier)
//    {
//        $supplier->load('user');
//
//        return view('superadmin.suppliers.show', compact('supplier'));
//    }
//
//    public function edit(Supplier $supplier)
//    {
//        $supplier->load('user');
//
//        $users = User::doesntHave('supplier')
//            ->orWhere('id', $supplier->user_id)
//            ->get(['id', 'name', 'email']);
//
//        return view('superadmin.suppliers.edit', compact('supplier', 'users'));
//    }
//
//    public function update(Request $request, Supplier $supplier)
//    {
//        $validated = $request->validate([
//            'user_id'      => ['required', 'exists:users,id', 'unique:suppliers,user_id,' . $supplier->id],
//            'company_name' => ['required', 'string', 'max:255'],
//            'company_slug' => ['nullable', 'string', 'max:255', 'unique:suppliers,company_slug,' . $supplier->id],
//            'description'  => ['nullable', 'string'],
//            'logo'         => ['nullable', 'image', 'max:2048'],
//        ]);
//
//        $oldLogo  = $supplier->logo;
//        $logoPath = $oldLogo;
//
//        if ($request->hasFile('logo')) {
//            $logoPath = $request->file('logo')->store('suppliers/logos', 'public');
//        }
//
//        try {
//            // status / is_verified এখানে বদলায় না; approve/suspend button দিয়ে বদলাবে
//            $supplier->update([
//                'user_id'      => $validated['user_id'],
//                'company_name' => $validated['company_name'],
//                'company_slug' => $validated['company_slug'] ?? $supplier->company_slug,
//                'description'  => $validated['description'] ?? null,
//                'logo'         => $logoPath,
//            ]);
//        } catch (\Throwable $e) {
//            if ($request->hasFile('logo')) {
//                Storage::disk('public')->delete($logoPath);
//            }
//
//            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
//        }
//
//        if ($request->hasFile('logo') && $oldLogo) {
//            Storage::disk('public')->delete($oldLogo);
//        }
//
//        return redirect()->route('superadmin.suppliers.index')
//            ->with('success', 'Supplier updated successfully.');
//    }
//
//    public function destroy(Supplier $supplier)
//    {
//        try {
//            $logo = $supplier->logo;
//
//            $supplier->delete();
//
//            if ($logo) {
//                Storage::disk('public')->delete($logo);
//            }
//        } catch (\Throwable $e) {
//            return back()->with('error', 'Could not delete supplier: ' . $e->getMessage());
//        }
//
//        return redirect()->route('superadmin.suppliers.index')
//            ->with('success', 'Supplier deleted successfully.');
//    }
//
//    public function approve(Supplier $supplier)
//    {
//        $supplier->forceFill(['status' => 'approved', 'is_verified' => true])->save();
//
//        return back()->with('success', "{$supplier->company_name} approved successfully.");
//    }
//
//    public function suspend(Supplier $supplier)
//    {
//        $supplier->forceFill(['status' => 'suspended'])->save();
//
//        return back()->with('success', "{$supplier->company_name} suspended.");
//    }
//
//    private function generateUniqueSlug(string $name): string
//    {
//        $slug = Str::slug($name);
//        $original = $slug;
//        $count = 1;
//
//        while (Supplier::where('company_slug', $slug)->exists()) {
//            $slug = "{$original}-{$count}";
//            $count++;
//        }
//
//        return $slug;
//    }
//}
