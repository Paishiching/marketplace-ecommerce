@extends('layouts.superadmin.app')

@section('title', 'Order #' . ($order->order_number ?? $order->id))

@section('sidebar')
    @include('layouts.vendor.sidebar')
@endsection

@section('header')
    @include('layouts.vendor.header')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Orders</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.orders.orders.index') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">#{{ $order->order_number ?? $order->id }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('vendor.orders.orders.index') }}" class="btn btn-outline-secondary btn-sm">Back to orders</a>
                </div>
            </div>

            <div class="row">
                {{-- LEFT --}}
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="mb-0">Order #{{ $order->order_number ?? $order->id }}</h5>
                                <div class="ms-auto d-flex gap-2">
                                    @include('superadmin.orders._badge', ['type' => 'payment_statuses', 'value' => $order->payment_status])
                                    @include('superadmin.orders._badge', ['type' => 'statuses', 'value' => $order->status])
                                </div>
                            </div>
                            <div class="text-muted">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">My Items</h5>
                            <hr/>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                {{ $item->product->name ?? 'Deleted product' }}
                                                @if ($item->productVariant)
                                                    <div class="text-muted small">
                                                        {{ rtrim(rtrim((string) $item->productVariant->unit_value, '0'), '.') }} {{ $item->productVariant->unit_type }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-end">Tk. {{ number_format($item->unit_price, 2) }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">Tk. {{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row justify-content-end mt-3">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td>My items subtotal</td>
                                            <td class="text-end">Tk. {{ number_format($itemsTotal, 2) }}</td>
                                        </tr>
                                        @if ($vendorOrder)
                                            <tr>
                                                <td>Marketplace commission</td>
                                                <td class="text-end text-danger">- Tk. {{ number_format($vendorOrder->commission_amount, 2) }}</td>
                                            </tr>
                                            <tr class="fw-bold border-top">
                                                <td>My earning</td>
                                                <td class="text-end text-success">Tk. {{ number_format($itemsTotal - $vendorOrder->commission_amount, 2) }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                    @if (! $vendorOrder)
                                        <div class="text-muted small mt-1">Commission hisab ekhono hoyni.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Customer</h5>
                            <hr/>
                            <div class="fw-bold">{{ $order->name ?? '—' }}</div>
                            <div>{{ $order->phone ?? '—' }}</div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Shipping Address</h5>
                            <hr/>
                            @php $addr = $order->shippingAddress; @endphp
                            @if ($addr)
                                <div class="fw-bold">{{ $addr->recipient_name ?? $order->name }}</div>
                                <div>{{ $addr->phone ?? $order->phone }}</div>
                                <div>
                                    {{ collect([$addr->address_line1, $addr->address_line2, $addr->city, $addr->state, $addr->postal_code])->filter()->implode(', ') }}
                                </div>
                            @else
                                <div class="text-muted">No address.</div>
                            @endif
                        </div>
                    </div>

                    @if ($order->notes)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Customer Note</h5>
                                <hr/>
                                {{ $order->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection