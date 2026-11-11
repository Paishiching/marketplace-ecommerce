<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please log in to continue.');
        }

        $user = Auth::guard('admin')->user();

        if (isset($user->status) && $user->status !== 'active') {
            Auth::guard('admin')->logout();

            return redirect()->route('admin.login')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        return $next($request);
    }
}
