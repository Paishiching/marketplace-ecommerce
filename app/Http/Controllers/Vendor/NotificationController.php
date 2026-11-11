<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(20);

        return view('vendor.index', compact('notifications'));
    }

    public function create()
    {
        return view('vendor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Notification
        ]);

        $notification = Notification::create($validated);

        return redirect()->route('vendor.index')->with('success', 'Notification created successfully.');
    }

    public function show(Notification $notification)
    {
        return view('vendor.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        return view('vendor.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Notification
        ]);

        $notification->update($validated);

        return redirect()->route('vendor.index')->with('success', 'Notification updated successfully.');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('vendor.index')->with('success', 'Notification deleted successfully.');
    }
}
