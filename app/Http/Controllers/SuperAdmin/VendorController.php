<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $vendors = Vendor::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $users = User::whereIn('id', $vendors->pluck('user_id'))->get()->keyBy('id');

        return view('superadmin.vendors.index', compact('vendors', 'users'));
    }

    public function create()
    {
        return redirect()->route('superadmin.vendors.index');
    }

    public function show(Vendor $vendor)
    {
        return redirect()->route('superadmin.vendors.index');
    }

    public function approve(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'commission_rate' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $vendor->forceFill([
            'status'          => 'approved',
            'is_verified'     => true,
            'commission_rate' => $data['commission_rate'],
        ])->save();

        User::find($vendor->user_id)?->assignRole('vendor');

        return back()->with('success', $vendor->shop_name . ' approved hoyeche.');
    }

    // enum e 'rejected' nei, tai reject mane suspended
    public function reject(Vendor $vendor)
    {
        $vendor->forceFill([
            'status'      => 'suspended',
            'is_verified' => false,
        ])->save();

        User::find($vendor->user_id)?->removeRole('vendor');

        return back()->with('success', $vendor->shop_name . ' reject kora hoyeche.');
    }

    public function suspend(Vendor $vendor)
    {
        $vendor->forceFill(['status' => 'suspended'])->save();

        User::find($vendor->user_id)?->removeRole('vendor');

        return back()->with('success', $vendor->shop_name . ' suspend kora hoyeche.');
    }

    public function destroy(Vendor $vendor)
    {
        User::find($vendor->user_id)?->removeRole('vendor');
        $vendor->delete();

        return back()->with('success', 'Vendor delete kora hoyeche.');
    }
}
