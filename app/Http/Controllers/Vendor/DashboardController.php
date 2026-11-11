<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user   = $request->user();
        $vendor = $user->vendor; // vendors table er row (na thakle null)

        $stats = ['products' => 0, 'orders' => 0, 'sales' => 0];
        $recentItems = collect();

        if ($vendor) {
            $items = OrderItem::where('vendor_id', $vendor->id);

            $stats['orders'] = (clone $items)->distinct('order_id')->count('order_id');
            $stats['sales']  = (clone $items)->sum('total_price');

            if (Schema::hasColumn('products', 'vendor_id')) {
                $stats['products'] = Product::where('vendor_id', $vendor->id)->count();
            }

            $recentItems = (clone $items)->with('order')->latest()->take(8)->get();
        }

        return view('vendor.dashboard.index', compact('vendor', 'stats', 'recentItems'));
    }
}
