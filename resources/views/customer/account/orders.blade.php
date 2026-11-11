@extends('customer.account.layout')

@section('account')

    <div class="dsh-card">
        <div class="dsh-card-head"><h3>My Orders</h3></div>

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
                            <td><span class="dsh-badge {{ $order->status }}">{{ $order->status }}</span></td>
                            <td><a class="dsh-view" href="{{ route('checkout.success', $order->order_number) }}">View</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="dsh-foot">{{ $orders->links() }}</div>
            @endif
        @else
            <div class="dsh-empty">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                <p>Apni ekhono kono order koren ni.</p>
                <a href="{{ route('homes') }}" class="dsh-btn">Start Shopping</a>
            </div>
        @endif
    </div>

@endsection