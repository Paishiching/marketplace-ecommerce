@extends('layouts.superadmin.app')
@section('title','Dropshipping Order #' . $order->id)
@section('content')
    <div class="page-wrapper"><div class="page-content">
            @include('superadmin.partials.page-header', ['title' => 'Dropshipping Orders', 'current' => 'Order #' . $order->id])

            <div class="row">
                <div class="col-lg-6">
                    <div class="card"><div class="card-body">
                            <h5 class="card-title">Order Info</h5><hr/>
                            <table class="table table-sm mb-0">
                                <tr><th style="width:40%">Vendor</th><td>{{ $order->vendor?->shop_name ?? $order->vendor?->name ?? '—' }}</td></tr>
                                <tr><th>Supplier</th><td>{{ $order->supplier?->company_name ?? '—' }}</td></tr>
                                <tr><th>Marketplace Order</th><td>{{ $order->order_id ? '#' . $order->order_id : '—' }}</td></tr>
                                <tr><th>Status</th><td>@include('superadmin.partials.status-badge', ['status' => $order->status])</td></tr>
                                <tr><th>Total Cost</th><td>{{ number_format($order->total_cost, 2) }}</td></tr>
                                <tr><th>Date</th><td>{{ $order->created_at?->format('M d, Y h:i A') }}</td></tr>
                            </table>
                        </div></div>
                </div>
                <div class="col-lg-6">
                    <div class="card"><div class="card-body">
                            <h5 class="card-title">Fulfillment & Shipment</h5><hr/>
                            <table class="table table-sm mb-0">
                                <tr>
                                    <th style="width:40%">Fulfillment</th>
                                    <td>
                                        @if ($order->fulfillment)
                                            @include('superadmin.partials.status-badge', ['status' => $order->fulfillment->status])
                                        @else — @endif
                                    </td>
                                </tr>
                                <tr><th>Courier</th><td>{{ $order->shipment?->courier_name ?? '—' }}</td></tr>
                                <tr><th>Tracking No.</th><td>{{ $order->shipment?->tracking_number ?? '—' }}</td></tr>
                                <tr><th>Shipped At</th><td>{{ $order->shipment?->shipped_at?->format('M d, Y h:i A') ?? '—' }}</td></tr>
                            </table>
                        </div></div>
                </div>
            </div>

            <div class="card"><div class="card-body">
                    <h5 class="card-title">Items</h5><hr/>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                            <tr><th>Product</th><th>SKU</th><th>Qty</th><th>Unit Cost</th><th>Subtotal</th></tr>
                            </thead>
                            <tbody>
                            @forelse ($order->items as $item)
                                <tr>
                                    <td>{{ $item->supplierProduct?->name ?? '#' . $item->supplier_product_id }}</td>
                                    <td>{{ $item->supplierProduct?->sku ?? '—' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_cost, 2) }}</td>
                                    <td>{{ number_format($item->quantity * $item->unit_cost, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4">No items.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div></div>

            <a href="{{ route('superadmin.dropshipping.orders.index') }}" class="btn btn-outline-secondary">Back</a>
        </div></div>
@endsection
