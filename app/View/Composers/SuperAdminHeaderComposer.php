<?php

namespace App\View\Composers;

use App\Models\Order;
use App\Models\Supplier;
use App\Models\Vendor;
use App\Models\Withdrawal;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class SuperAdminHeaderComposer
{
    public function compose(View $view): void
    {
        $headerData = Cache::remember('superadmin.header.data.v1', now()->addSeconds(30), function () {
            $pendingOrders      = Order::where('status', 'pending')->count();
            $pendingVendors     = Vendor::where('status', 'pending')->count();
            $pendingSuppliers   = Supplier::where('status', 'pending')->count();
            $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();
            $alerts = collect([
                ['count' => $pendingOrders, 'icon' => 'bx-cart-alt', 'color' => 'danger', 'title' => 'Pending Orders', 'text' => $pendingOrders . ' order(s) waiting for processing', 'url' => route('superadmin.orders.index', ['status' => 'pending'])],
                ['count' => $pendingVendors, 'icon' => 'bx-store', 'color' => 'primary', 'title' => 'Vendor Requests', 'text' => $pendingVendors . ' vendor(s) awaiting approval', 'url' => route('superadmin.vendors.index', ['status' => 'pending'])],
                ['count' => $pendingSuppliers, 'icon' => 'bx-buildings', 'color' => 'info', 'title' => 'Supplier Requests', 'text' => $pendingSuppliers . ' supplier(s) awaiting approval', 'url' => route('superadmin.suppliers.index', ['status' => 'pending'])],
                ['count' => $pendingWithdrawals, 'icon' => 'bx-wallet', 'color' => 'warning', 'title' => 'Withdrawal Requests', 'text' => $pendingWithdrawals . ' withdrawal(s) pending', 'url' => route('superadmin.withdrawals.index')],
            ])->filter(fn ($a) => $a['count'] > 0)->values();

            return [
                'headerAlerts' => $alerts,
                'headerAlertCount' => $alerts->sum('count'),
                'headerPendingOrders' => $pendingOrders,
                'headerOrders' => Order::latest()->limit(8)->get(['id', 'order_number', 'name', 'total', 'status', 'created_at']),
            ];
        });

        $view->with($headerData);
    }
}
