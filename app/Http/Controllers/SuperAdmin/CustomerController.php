<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /** Ei status er order spent/revenue te dhora hobe na */
    protected array $notCounted = ['cancelled', 'returned'];

    public function index(Request $request)
    {
        $query = Customer::query()
            ->with('user')
            ->withCount('orders')
            ->withSum(['orders as total_spent' => fn ($q) => $q->whereNotIn('status', $this->notCounted)], 'total');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('orders', function ($o) use ($search) {
                    $o->where('phone', 'like', "%{$search}%");
                });
            });
        }

        $customers = $query->latest()->paginate(20)->withQueryString();

        return view('superadmin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['user', 'shippingAddress']);

        $orders = $customer->orders()
            ->withCount('orderItems')
            ->latest()
            ->paginate(10);

        $stats = [
            'total_orders'  => $customer->orders()->count(),
            'delivered'     => $customer->orders()->whereIn('status', ['delivered', 'completed'])->count(),
            'cancelled'     => $customer->orders()->whereIn('status', ['cancelled', 'returned'])->count(),
            'total_spent'   => (float) $customer->orders()->whereNotIn('status', $this->notCounted)->sum('total'),
            'last_order_at' => $customer->orders()->latest()->value('created_at'),
        ];

        // Order er name/phone/email theke fallback
        $latestOrder = $customer->orders()->latest()->first(['id', 'name', 'phone', 'email']);

        return view('superadmin.customers.show', compact('customer', 'orders', 'stats', 'latestOrder'));
    }
}