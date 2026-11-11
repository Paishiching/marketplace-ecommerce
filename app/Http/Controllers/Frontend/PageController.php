<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('frontend.pages.index');
    }

    public function complaint()
    {
        return view('frontend.pages.complaint');
    }

    public function warranty()
    {
        return view('frontend.pages.warranty', [
            'searched' => false,
            'warranty' => null,
        ]);
    }

    public function warrantyCheck(Request $request)
    {
        $data = $request->validate([
            'serial' => 'required|string|max:60',
            'mobile' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]{10,20}$/'],
        ], [
            'serial.required' => 'Product S/N code is required.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex'    => 'Please enter a valid mobile number.',
        ]);

        $serial = strtoupper(preg_replace('/\s+/', '', $data['serial']));
        $mobile = substr(preg_replace('/\D/', '', $data['mobile']), -10);

        $warranty = WarrantyRegistration::where('serial_number', $serial)->first();

        // serial mile gelew mobile number na mille "not found" dekhabe
        if ($warranty) {
            $saved = substr(preg_replace('/\D/', '', (string) $warranty->phone), -10);
            if ($saved === '' || $saved !== $mobile) {
                $warranty = null;
            }
        }

        return view('frontend.pages.warranty', [
            'searched' => true,
            'warranty' => $warranty,
        ]);
    }
}