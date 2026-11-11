<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DropshippingSetting;
use Illuminate\Http\Request;

class DropshippingSettingController extends Controller
{
    public function index()
    {
        $settings = DropshippingSetting::with('vendor')->latest()->paginate(15);

        return view('superadmin.dropshipping.settings.index', compact('settings'));
    }

    public function update(Request $request, DropshippingSetting $dropshippingSetting)
    {
        $data = $request->validate([
            'markup_percentage' => 'required|numeric|min:0|max:1000',
        ]);

        $dropshippingSetting->update([
            'auto_sync'         => $request->boolean('auto_sync'),
            'markup_percentage' => $data['markup_percentage'],
        ]);

        return back()->with('success', 'Setting updated.');
    }
}
