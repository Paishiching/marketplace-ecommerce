<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Marks the current request/session as coming through a dropshipping
 * storefront context (?source=dropship&vendor=ID), so downstream
 * checkout logic knows to route fulfillment to the supplier instead
 * of the vendor's own warehouse.
 */
class TrackDropshipping
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->query('source') === 'dropship') {
            $request->session()->put('is_dropshipping_order', true);

            if ($vendorId = $request->query('vendor')) {
                $request->session()->put('dropshipping_vendor_id', $vendorId);
            }
        }

        return $next($request);
    }
}
