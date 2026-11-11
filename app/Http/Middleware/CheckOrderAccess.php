<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Ensures the authenticated user (customer, or vendor via their
 * vendor sub-order) is only able to access their own order.
 */
class CheckOrderAccess
{
    public function handle(Request $request, Closure $next)
    {
        $order = $request->route('order');

        if (! $order) {
            return $next($request);
        }

        if ($customer = Auth::guard('customer')->user()) {
            if ($order->customer_id !== $customer->id) {
                abort(403, 'You do not have access to this order.');
            }
        } elseif ($vendor = Auth::guard('vendor')->user()) {
            $ownsOrder = $order->vendorOrders()->where('vendor_id', $vendor->id)->exists();

            if (! $ownsOrder) {
                abort(403, 'You do not have access to this order.');
            }
        }

        return $next($request);
    }
}
