<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Works out which guard the current request is authenticated under
 * (admin, vendor, supplier, affiliate, reseller, customer) and shares
 * the resolved user + role with the view/request for convenience.
 */
class IdentifyUser
{
    protected array $guards = ['admin', 'vendor', 'supplier', 'affiliate', 'reseller', 'customer', 'web'];

    public function handle(Request $request, Closure $next)
    {
        foreach ($this->guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $request->attributes->set('auth_guard', $guard);
                $request->attributes->set('auth_user', Auth::guard($guard)->user());

                view()->share('currentGuard', $guard);
                view()->share('currentUser', Auth::guard($guard)->user());

                break;
            }
        }

        return $next($request);
    }
}
