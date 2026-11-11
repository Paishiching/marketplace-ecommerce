<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAffiliateAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('affiliate')->check()) {
            return redirect()->route('affiliate.login')
                ->with('error', 'Please log in to continue.');
        }

        $user = Auth::guard('affiliate')->user();

        if (isset($user->status) && $user->status !== 'active') {
            Auth::guard('affiliate')->logout();

            return redirect()->route('affiliate.login')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        return $next($request);
    }
}
