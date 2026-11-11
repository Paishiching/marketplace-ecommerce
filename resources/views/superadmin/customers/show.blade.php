@extends('layouts.superadmin.app')

@section('title','Customer #' . $customer->id)

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Customers</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.customers.index') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $customer->user->name ?? 'Customer #' . $customer->id }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('superadmin.customers.index') }}" class="btn btn-outline-secondary btn-sm">Back to customers</a>
                </div>
            </div>

            <div class="row">
                {{-- LEFT --}}
                <div class="col-lg-4">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Profile</h5>
                            <hr/>
                            <div class="fw-bold fs-5">{{ $customer->user->name ?? 'Deleted user' }}</div>
                            <div class="mb-2 text-muted">Customer #{{ $customer->id }}</div>

                            <div><span class="text-muted">Email:</span> {{ $customer->user->email ?? $latestOrder->email ?? '—' }}</div>
                            <div><span class="text-muted">Phone:</span> {{ $customer->user->phone ?? $latestOrder->phone ?? '—' }}</div>
                            <div class="text-capitalize"><span class="text-muted">Gender:</span> {{ $customer->gender ?? '—' }}</div>
                            <div><span class="text-muted">Date of birth:</span> {{ $customer->date_of_birth?->format('M d, Y') ?? '—' }}</div>
                            <div><span class="text-muted">Loyalty points:</span> {{ $customer->loyalty_points ?? 0 }}</div>
                            <div><span class="text-muted">Joined:</span> {{ $customer->created_at?->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order Summary</h5>
                            <hr/>
                            <div class="d-flex justify-content-between py-1"><span>Total orders</span><b>{{ $stats['total_orders'] }}</b></div>
                            <div class="d-flex justify-content-between py-1"><span>Delivered / Completed</span><b>{{ $stats['delivered'] }}</b></div>
                            <div class="d-flex justify-content-between py-1"><span>Cancelled / Returned</span><b>{{ $stats['cancelled'] }}</b></div>
                            <div class="d-flex justify-content-between py-1 border-top mt-1 pt-2">
                                <span>Total spent</span><b>Tk. {{ number_format($stats['total_spent'], 2) }}</b>
                            </div>
                            <div class="text-muted small mt-2">
                                Last order: {{ $stats['last_order_at'] ? \Illuminate\Support\Carbon::parse($stats['last_order_at'])->diffForHumans() : 'never' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Addresses</h5>
                            <hr/>
                            <div class="row g-3">
                                @forelse ($customer->shippingAddress as $address)
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 h-100">
                                            @foreach (collect($address->toArray())->except(['id', 'user_id', 'customer_id', 'created_at', 'updated_at'])->filter() as $label => $val)
                                                <div>
                                                    <span class="text-muted text-capitalize">{{ str_replace('_', ' ', $label) }}:</span>
                                                    {{ is_array($val) ? json_encode($val) : $val }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted">No saved address.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Orders</h5>
                            <hr/>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Order#</th>
                                        <th class="text-center">Items</th>
                                        <th class="text-end">Total</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>#{{ $order->order_number ?? $order->id }}</td>
                                            <td class="text-center">{{ $order->order_items_count }}</td>
                                            <td class="text-end">Tk. {{ number_format($order->total, 2) }}</td>
                                            <td>@include('superadmin.orders._badge', ['type' => 'payment_statuses', 'value' => $order->payment_status])</td>
                                            <td>@include('superadmin.orders._badge', ['type' => 'statuses', 'value' => $order->status])</td>
                                            <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                            <td>
                                                <a href="{{ route('superadmin.orders.show', $order->id) }}"
                                                   class="btn btn-primary btn-sm radius-30 px-4">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center py-4">No orders yet.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection