<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Ensures a supplier can only manage their own supplier products.
 * Expects a {supplierProduct} route parameter.
 */
class CheckSupplierProduct
{
    public function handle(Request $request, Closure $next)
    {
        $supplierProduct = $request->route('supplierProduct');
        $supplier = Auth::guard('supplier')->user();

        if (! $supplierProduct || ! $supplier || $supplierProduct->supplier_id !== $supplier->id) {
            abort(403, 'You do not have access to this product.');
        }

        return $next($request);
    }
}
