<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureVendorAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.login')
                ->with('error', 'Please log in to continue.');
        }

        $user = Auth::guard('vendor')->user();

        if (isset($user->status) && $user->status !== 'active') {
            Auth::guard('vendor')->logout();

            return redirect()->route('vendor.login')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        return $next($request);
    }
}
