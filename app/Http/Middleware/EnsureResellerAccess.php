<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureResellerAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('reseller')->check()) {
            return redirect()->route('reseller.login')
                ->with('error', 'Please log in to continue.');
        }

        $user = Auth::guard('reseller')->user();

        if (isset($user->status) && $user->status !== 'active') {
            Auth::guard('reseller')->logout();

            return redirect()->route('reseller.login')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        return $next($request);
    }
}
