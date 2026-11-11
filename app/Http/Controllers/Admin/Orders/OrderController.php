<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\VendorOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer.user')->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::with('user')->whereHas('user')->orderByDesc('id')->get();
        $products = Product::query()->where('status', 'published')->orderBy('name')->get(['id', 'name', 'sku', 'price', 'discount_price']);

        return view('admin.orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:100000'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0', 'max:99999999'],
        ]);

        $order = DB::transaction(function () use ($validated, $request) {
            $products = Product::whereIn('id', collect($validated['items'])->pluck('product_id'))
                ->where('status', 'published')->get()->keyBy('id');
            abort_if($products->count() !== count($validated['items']), 422, 'One or more selected products are unavailable.');

            $subtotal = collect($validated['items'])->sum(fn ($item) => (float) $item['unit_price'] * (int) $item['quantity']);
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => $validated['customer_id'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'subtotal' => $subtotal,
                'discount' => 0,
                'shipping_cost' => 0,
                'extra_charge' => 0,
                'tax' => 0,
                'total' => $subtotal,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'notes' => $validated['notes'] ?? null,
                'source' => 'admin',
                'created_by' => $request->user()->id,
            ]);

            foreach ($validated['items'] as $item) {
                $product = $products->get($item['product_id']);
                $quantity = (int) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'vendor_id' => $product->vendor_id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $unitPrice * $quantity,
                ]);
            }

            $order->load('orderItems');
            foreach ($order->orderItems->whereNotNull('vendor_id')->groupBy('vendor_id') as $vendorId => $vendorItems) {
                VendorOrder::create([
                    'order_id' => $order->id,
                    'vendor_id' => $vendorId,
                    'subtotal' => $vendorItems->sum('total_price'),
                    'status' => 'pending',
                ]);
            }

            return $order;
        });

        $showRoute = $request->user()->hasRole('superadmin') ? 'superadmin.manual-orders.show' : 'admin.orders.orders.show';

        return redirect()->route($showRoute, $order)->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load(['payments.depositDetails', 'orderItems.product', 'shippingAddress', 'shipments']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Order
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
