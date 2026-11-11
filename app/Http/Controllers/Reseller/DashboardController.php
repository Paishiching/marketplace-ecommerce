<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user     = $request->user();
        $reseller = $user->reseller; // resellers table er row (na thakle null)
        $stats = [
            ['label' => 'Products', 'value' => $reseller->resellerProducts()->count()],
            ['label' => 'Orders', 'value' => $reseller->resellerOrders()->count()],
            ['label' => 'Customers', 'value' => $reseller->resellerCustomers()->count()],
        ];

        return view('reseller.dashboard.index', compact('user', 'reseller', 'stats'));
    }
}
