<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSupplierAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('supplier')->check()) {
            return redirect()->route('supplier.login')
                ->with('error', 'Please log in to continue.');
        }

        $user = Auth::guard('supplier')->user();

        if (isset($user->status) && $user->status !== 'active') {
            Auth::guard('supplier')->logout();

            return redirect()->route('supplier.login')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        return $next($request);
    }
}
