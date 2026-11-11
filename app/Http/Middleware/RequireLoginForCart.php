<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireLoginForCart
{
    /**
     * Guest Add to Cart / Buy Now click korle :
     *  - product ta session e rakhe (login er por cart e add hobe)
     *  - login/verify page e pathay
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }

        session()->put('pending_cart', [
            'product_id' => $request->input('product_id'),
            'variant_id' => $request->input('variant_id'),
            'quantity'   => max(1, (int) $request->input('quantity', 1)),
        ]);

        // Buy Now => verify er por checkout ; Add to Cart => je page theke eshechhe sekhane
        session()->put(
            'url.intended',
            $request->boolean('buy_now') ? route('checkout.index') : $this->previousUrl()
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success'        => false,
                'login_required' => true,
                'redirect'       => route('otp.login'),
                'message'        => 'Please login to continue.',
            ], 401);
        }

        return redirect()->route('otp.login');
    }

    protected function previousUrl(): string
    {
        $prev = url()->previous();

        return str_starts_with($prev, url('/')) ? $prev : route('homes');
    }
}