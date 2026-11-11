<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCustomerAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('customer')->check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to continue.');
        }

        $user = Auth::guard('customer')->user();

        if (isset($user->status) && $user->status !== 'active') {
            Auth::guard('customer')->logout();

            return redirect()->route('login')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        return $next($request);
    }
}
