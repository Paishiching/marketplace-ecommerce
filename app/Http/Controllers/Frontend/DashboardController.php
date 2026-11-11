<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $roles = $user->getRoleNames()
            ->map(fn ($r) => str_replace(['_', '-', ' '], '', strtolower($r)))
            ->all();

        $has = fn (string ...$names) => count(array_intersect($roles, $names)) > 0;

        // Fixed role gulo
        if ($has('superadmin')) {
            return redirect()->route('superadmin.dashboards');
        }

        if ($has('admin')) {
            return redirect()->route('admin.dashboards');
        }

        if ($has('vendor')) {
            return redirect()->route('vendor.dashboards');
        }

        if ($has('supplier')) {
            return redirect()->route('supplier.dashboards');
        }

        if ($has('affiliate')) {
            return redirect()->route('affiliate.dashboards');
        }

        if ($has('reseller')) {
            return redirect()->route('reseller.dashboards');
        }

        // Custom role (jemon "Testing"): superadmin panel er kono permission thakle oikhane pathao
        $hasPanelAccess = $user->getAllPermissions()
            ->contains(fn ($p) => str_starts_with($p->name, 'superadmin.'));

        if ($hasPanelAccess) {
            return redirect()->route('superadmin.dashboards');
        }

        return redirect()->route('customer.dashboard');
    }
}