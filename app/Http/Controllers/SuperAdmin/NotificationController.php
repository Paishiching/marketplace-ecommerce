<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::forUser(auth()->id())
            ->when($request->status === 'unread', fn ($q) => $q->whereNull('read_at'))
            ->when($request->status === 'read', fn ($q) => $q->whereNotNull('read_at'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $unreadCount = Notification::forUser(auth()->id())->unread()->count();

        return view('superadmin.notifications.index', compact('notifications', 'unreadCount'));
    }

    /** Khulle read mark hoy, link thakle shekhane niye jay. */
    public function show(Notification $notification)
    {
        $this->markRead($notification);

        return $notification->url
            ? redirect($notification->url)
            : redirect()->route('superadmin.notifications.index');
    }

    /** Ekta notification read mark. */
    public function update(Notification $notification)
    {
        $this->markRead($notification);

        return back()->with('success', 'Notification marked as read.');
    }

    /** Sob read mark. */
    public function readAll()
    {
        Notification::forUser(auth()->id())->unread()->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    private function markRead(Notification $notification): void
    {
        if (is_null($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }
    }
}