<?php

namespace App\Http\Controllers\Dropshipping;

use App\Http\Controllers\Controller;
use App\Models\DropshipperOrder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = DropshipperOrder::with(['sourceOrder', 'supplier', 'customer.user', 'items'])
            ->where('dropshipper_id', $request->user()->dropshipper->id)
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dropshipping.orders.index', compact('orders'));
    }
}
