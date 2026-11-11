<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact.index');
    }

    public function store(Request $request)
    {
        $successMessage = 'আপনার বার্তা সফলভাবে পাঠানো হয়েছে। আমরা শীঘ্রই যোগাযোগ করব।';

        // Honeypot: bot hole ei field fill kore, silently success dekhai
        if ($request->filled('website')) {
            return $request->expectsJson()
                ? response()->json(['message' => $successMessage])
                : back()->with('success', $successMessage);
        }

        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($data);

        if ($request->expectsJson()) {
            return response()->json(['message' => $successMessage]);
        }

        return back()->with('success', $successMessage);
    }
}
