<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireOtpLoginForRfq
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }

        $request->session()->put('url.intended', route('customer.rfqs.create'));

        return redirect()->route('otp.login');
    }
}
