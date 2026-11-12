@extends('customer.account.layout')

@section('account')

    <div class="dsh-hero">
        <div>
            <h2>Welcome back, {{ Auth::user()->name }}!</h2>
            <p>Apnar order ar account er shob information ekhane dekhte paren.</p>
        </div>
        <a href="{{ route('customer.new-order.create') }}" class="dsh-btn">New Order</a>
        <a href="{{ route('homes') }}" class="dsh-btn">Continue Shopping</a>
        <a href="{{ route('customer.rfqs.create') }}" class="dsh-btn">Request supplier quotes</a>
    </div>

    <div class="dsh-stats">
        <div class="dsh-stat">
            <div class="dsh-ico blue"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg></div>
            <div><small>Total Orders</small><b>{{ $stats['total'] }}</b></div>
        </div>
        <div class="dsh-stat">
            <div class="dsh-ico amber"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
            <div><small>Pending Orders</small><b>{{ $stats['pending'] }}</b></div>
        </div>
        <div class="dsh-stat">
            <div class="dsh-ico green"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v20M17 6H9.500a3.500 3.500 0 000 7h5a3.500 3.500 0 010 7H6"/></svg></div>
            <div><small>Total Spent</small><b>Tk. {{ number_format($stats['spent'], 2) }}</b></div>
        </div>
    </div>

    @if($shipments->isNotEmpty())
        <div class="dsh-card mt-3">
            <div class="dsh-card-head"><h3>Delivery transport</h3></div>
            <div class="row g-3">
                @foreach($shipments as $shipment)
                        <div class="col-12 col-lg-6">
                            <div class="border rounded-3 p-3 h-100">
                                <h5 class="mb-3">Order #{{ $shipment->order?->order_number ?? $shipment->order_id }}</h5>
                                <div class="row g-2 small">
                                    <div class="col-6"><strong>Driver:</strong> {{ $shipment->driver_name ?: '—' }}</div>
                                    <div class="col-6"><strong>Driver phone:</strong> {{ $shipment->driver_phone ?: '—' }}</div>
                                    <div class="col-6"><strong>Vehicle:</strong> {{ $shipment->vehicle_number ?: '—' }}</div>
                                    <div class="col-6"><strong>Agency:</strong> {{ $shipment->vehicle_owner ?: '—' }}</div>
                                    <div class="col-6"><strong>Expected date:</strong> {{ $shipment->expected_arrival_at?->format('d M Y') ?: '—' }}</div>
                                    <div class="col-6"><strong>Delivery date:</strong> {{ $shipment->delivery_date?->format('d M Y') ?: '—' }}</div>
                                    <div class="col-6"><strong>Estimated time:</strong> {{ $shipment->delivery_estimate ?: '—' }}</div>
                                    <div class="col-12"><strong>Status:</strong> {{ str($shipment->status ?: 'pending')->replace('_', ' ')->title() }}</div>
                                </div>
                                <form method="POST" action="{{ route('customer.shipments.remark', $shipment) }}" class="mt-3">
                                    @csrf @method('PATCH')
                                    <label class="form-label fw-semibold" for="remark-{{ $shipment->id }}">Your remark</label>
                                    <textarea class="form-control" id="remark-{{ $shipment->id }}" name="customer_remark" rows="2" maxlength="1000" placeholder="Write a note about delivery">{{ old('customer_remark', $shipment->customer_remark) }}</textarea>
                                    @error('customer_remark')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    <button class="btn btn-primary btn-sm mt-2" type="submit">Update remark</button>
                                </form>
                            </div>
                        </div>
                @endforeach
            </div>
            <div class="mt-3">{{ $shipments->links() }}</div>
        </div>
    @endif

    <div class="dsh-card">
        <div class="dsh-card-head">
            <h3>Recent Orders</h3>
            <a href="{{ route('account.orders') }}">View all</a>
        </div>

        @if($orders->count())
            <div class="table-responsive">
                <table class="dsh-table">
                    <thead>
                    <tr><th>Order No</th><th>Date</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><span class="dsh-ordno">#{{ $order->order_number }}</span></td>
                            <td class="dsh-date">{{ $order->created_at->format('d M Y') }}<small>{{ $order->created_at->format('h:i A') }}</small></td>
                            <td>{{ $order->orderItems->count() }}</td>
                            <td><strong>Tk. {{ number_format($order->total, 2) }}</strong></td>
                            <td><span class="dsh-badge {{ $order->payment_status }}">{{ $order->payment_status ?: 'unpaid' }}</span></td>
                            @php($dashboardStatus = $order->shipments->sortByDesc('id')->first()?->status ?: $order->status)
                            <td><span class="dsh-badge {{ $dashboardStatus }}">{{ str($dashboardStatus)->replace('_', ' ')->title() }}</span></td>
                            <td><a class="dsh-view" href="{{ route('checkout.success', $order->order_number) }}">View</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="dsh-empty">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                <p>Apni ekhono kono order koren ni.</p>
                <a href="{{ route('homes') }}" class="dsh-btn">Start Shopping</a>
            </div>
        @endif
    </div>

@endsection
