<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index()
    {
        $vendor = $this->vendor();

        return view('vendor.shop.index', compact('vendor'));
    }

    public function update(Request $request)
    {
        $vendor = $this->vendor();

        $data = $request->validate([
            'shop_name'     => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:2000'],
            'logo'          => ['nullable', 'image', 'max:2048'],
            'banner'        => ['nullable', 'image', 'max:4096'],
            'remove_logo'   => ['nullable', 'boolean'],
            'remove_banner' => ['nullable', 'boolean'],
        ]);

        $update = [
            'shop_name'   => $data['shop_name'],
            'description' => $data['description'] ?? null,
        ];

        foreach (['logo' => 'vendors/logos', 'banner' => 'vendors/banners'] as $field => $dir) {
            if ($request->hasFile($field)) {
                $update[$field] = $request->file($field)->store($dir, 'public');
                if ($vendor->{$field}) {
                    Storage::disk('public')->delete($vendor->{$field});
                }
            } elseif ($request->boolean('remove_' . $field) && $vendor->{$field}) {
                Storage::disk('public')->delete($vendor->{$field});
                $update[$field] = null;
            }
        }

        $vendor->update($update);

        return redirect()->route('vendor.shops')->with('success', 'Shop update hoyeche.');
    }

    private function vendor(): Vendor
    {
        $vendor = Vendor::where('user_id', auth()->id())->first();

        abort_unless(
            $vendor && in_array((string) $vendor->status, ['approved', '1'], true),
            403,
            'Apnar vendor account ekhono approved noi.'
        );

        return $vendor;
    }
}