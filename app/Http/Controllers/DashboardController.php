<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        $user = $request->user();

        return match (true) {
        $user->hasRole('superadmin') => redirect()->route('superadmin.dashboards'),
            $user->hasRole('admin')      => redirect()->route('admin.dashboards'),
            $user->hasRole('vendor')     => redirect()->route('vendor.dashboards'),
            $user->hasRole('supplier')   => redirect()->route('supplier.dashboards'),
            $user->hasRole('affiliate')  => redirect()->route('affiliate.dashboards'),
            $user->hasRole('reseller')   => redirect()->route('reseller.dashboards'),
            $user->hasRole('dropshipping') => redirect()->route('dropshipping.dashboards'),
            $user->hasRole('wholesale') => redirect()->route('wholesale.dashboards'),
            $user->hasRole('customer')   => redirect()->route('customer.dashboards'),
            default                      => redirect()->route('customer.dashboards'),
        };
    }
}
