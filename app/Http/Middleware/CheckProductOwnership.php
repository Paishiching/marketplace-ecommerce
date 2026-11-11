<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Ensures a vendor can only view/edit/delete products that belong to them.
 * Expects a {product} route parameter bound to App\Models\Product.
 */
class CheckProductOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $product = $request->route('product');
        $vendor = Auth::guard('vendor')->user();

        if (! $product || ! $vendor || $product->vendor_id !== $vendor->id) {
            abort(403, 'You do not have access to this product.');
        }

        return $next($request);
    }
}
