@extends('layouts.superadmin.app')

@section('title','Order #' . ($order->order_number ?? $order->id))

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Orders</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.orders.index') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">#{{ $order->order_number ?? $order->id }}</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="ms-auto">
                   <a href="{{ route('superadmin.orders.invoice', $order->id) }}" target="_blank" class="btn btn-primary btn-sm me-1">
                        <i class="bx bx-printer"></i> Invoice
                    </a>
                    <a href="{{ route('superadmin.orders.index') }}" class="btn btn-outline-secondary btn-sm">Back to orders</a>
                </div>
            </div>

            @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
                @if (session($key))
                    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                        {{ session($key) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                {{-- LEFT --}}
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
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
                            <h5 class="card-title">Items</h5>
                            <hr/>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Vendor</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? 'Deleted product' }}</td>
                                            <td>{{ $item->vendor->shop_name ?? $item->vendor->name ?? '—' }}</td>
                                            <td class="text-end">Tk. {{ number_format($item->unit_price, 2) }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">Tk. {{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center py-3">No items.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="row justify-content-end mt-3">
                                <div class="col-md-5">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td>Subtotal</td><td class="text-end">Tk. {{ number_format($order->subtotal, 2) }}</td></tr>
                                        <tr><td>Discount</td><td class="text-end">- Tk. {{ number_format($order->discount, 2) }}</td></tr>
                                        <tr><td>Shipping</td><td class="text-end">Tk. {{ number_format($order->shipping_cost, 2) }}</td></tr>
                                        <tr><td>Tax</td><td class="text-end">Tk. {{ number_format($order->tax, 2) }}</td></tr>
                                        <tr class="fw-bold border-top"><td>Total</td><td class="text-end">Tk. {{ number_format($order->total, 2) }}</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Payments</h5>
                            <hr/>
                            @forelse ($order->payments as $payment)
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <div>
                                        {{ \Illuminate\Support\Str::headline($payment->paymentMethod?->name ?? $payment->payment_method_code ?? $payment->payment_method ?? $payment->method ?? 'Payment') }}
                                        <div class="text-muted small">{{ $payment->transaction_id ?? '' }} {{ $payment->created_at?->format('M d, Y h:i A') }}</div>
                                    </div>
                                    <div class="text-end">
                                        Tk. {{ number_format($payment->amount ?? 0, 2) }}
                                        <div class="small text-muted text-capitalize">{{ $payment->status ?? '' }}</div>
                                    </div>
                                </div>
                                @if($payment->depositDetails)
                                    @php $receiptRoute = request()->routeIs('superadmin.*') ? 'superadmin.payment-deposits.receipt' : 'admin.payment-deposits.receipt'; @endphp
                                    <div class="border rounded p-3 mb-3 bg-light">
                                        <h6 class="mb-2">Bank deposit submission</h6>
                                        <div class="small">Deposit date: {{ $payment->depositDetails->deposit_date->format('d M Y') }}</div>
                                        <div class="small">Depositor bank: {{ $payment->depositDetails->depositor_bank }} · {{ $payment->depositDetails->depositor_branch }}</div>
                                        <div class="small">Type: {{ \Illuminate\Support\Str::headline($payment->depositDetails->deposit_type) }} · Amount: BDT {{ number_format($payment->depositDetails->amount, 2) }}</div>
                                        <div class="small">Receiving account: {{ $payment->depositDetails->company_account }} · {{ $payment->depositDetails->bank_name }} · {{ $payment->depositDetails->company_name }}</div>
                                        @if($payment->depositDetails->receipt_id)<div class="small">Receipt ID: {{ $payment->depositDetails->receipt_id }}</div>@endif
                                        @if($payment->depositDetails->remark)<p class="small mt-2 mb-2">{{ $payment->depositDetails->remark }}</p>@endif
                                        <a href="{{ route($receiptRoute, $payment->depositDetails) }}" class="btn btn-sm btn-outline-primary mt-2" target="_blank" rel="noopener">View deposit receipt</a>
                                    </div>
                                @endif
                            @empty
                                <div class="text-muted">No payment record.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order Timeline &amp; Notes</h5>
                            <hr/>

                            <form action="{{ route('superadmin.orders.notes.store', $order->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="note" class="form-control" placeholder="Add an internal note" maxlength="1000" required>
                                    <button class="btn btn-primary" type="submit">Add Note</button>
                                </div>
                            </form>

                            @forelse ($order->orderNotes as $note)
                                <div class="border-start border-3 border-primary ps-3 mb-3">
                                    <div>{{ $note->note }}</div>
                                    <div class="text-muted small">
                                        {{ $note->createdBy->name ?? 'System' }} &middot; {{ $note->created_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-muted">No notes yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4">

                    {{-- Courier --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Courier</h5>
                            <hr/>

                            @if ($shipment)
                                <div><span class="text-muted">Courier:</span> {{ $shipment->courier->name ?? '—' }}</div>
                                @if ($shipment->consignment_id)
                                    <div><span class="text-muted">Consignment:</span> #{{ $shipment->consignment_id }}</div>
                                @endif
                                <div>
                                    <span class="text-muted">Tracking:</span>
                                    @if ($shipment->trackingLink())
                                        <a href="{{ $shipment->trackingLink() }}" target="_blank" rel="noopener">{{ $shipment->tracking_number }}</a>
                                    @else
                                        {{ $shipment->tracking_number ?? '—' }}
                                    @endif
                                </div>
                                <div><span class="text-muted">COD:</span> Tk. {{ number_format($shipment->cod_amount, 2) }}</div>
                                <div><span class="text-muted">Status:</span>
                                    <span class="badge bg-info text-capitalize">{{ str_replace('_', ' ', $shipment->courier_status ?? 'n/a') }}</span>
                                </div>
                                <div class="text-muted small mb-3">Last synced: {{ $shipment->last_synced_at?->diffForHumans() ?? 'never' }}</div>

                                @if (($shipment->courier->driver ?? 'manual') !== 'manual')
                                    <form action="{{ route('superadmin.orders.courier.sync', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary w-100">Sync Status</button>
                                    </form>
                                @else
                                    <div class="text-muted small">Manual courier. Delivered hole <b>Update Status</b> theke manually change korun.</div>
                                @endif
                            @elseif ($order->status === 'processing')
                                <form action="{{ route('superadmin.orders.courier.send', $order->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label">Courier</label>
                                        <select name="courier_id" id="courierSelect" class="form-select" required>
                                            @foreach ($couriers as $c)
                                                <option value="{{ $c->id }}" data-driver="{{ $c->driver }}" @selected((int) old('courier_id') === $c->id)>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($couriers->isEmpty())
                                            <div class="form-text text-danger">No active courier. Add one from Delivery &gt; Couriers.</div>
                                        @endif
                                    </div>
                                    <div class="mb-2" id="trackingBox" style="display:none;">
                                        <label class="form-label">Tracking / Booking No.</label>
                                        <input type="text" name="tracking_number" id="trackingInput" class="form-control"
                                               value="{{ old('tracking_number') }}" maxlength="100">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">COD Amount (Tk.)</label>
                                        <input type="number" step="0.01" min="0" name="cod_amount" class="form-control"
                                               value="{{ old('cod_amount', $order->payment_status === 'paid' ? 0 : $order->total) }}" required>
                                        <div class="form-text">Paid order hole 0 rakhun.</div>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="note" rows="2" class="form-control" placeholder="Note for courier (optional)" maxlength="500">{{ old('note') }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100"
                                            onclick="return confirm('Send this order to courier?');">Send to Courier</button>
                                </form>

                                @push('scripts')
                                    <script>
                                        (function () {
                                            const sel = document.getElementById('courierSelect');
                                            if (!sel) return;
                                            const box = document.getElementById('trackingBox');
                                            const inp = document.getElementById('trackingInput');

                                            function toggle() {
                                                const manual = sel.selectedOptions[0]?.dataset.driver === 'manual';
                                                box.style.display = manual ? '' : 'none';
                                                inp.required = manual;
                                                inp.disabled = !manual;
                                            }

                                            sel.addEventListener('change', toggle);
                                            toggle();
                                        })();
                                    </script>
                                @endpush
                            @else
                                <div class="text-muted">Courier booking is available when the order is in Processing status.</div>
                            @endif
                        </div>
                    </div>

                    {{-- Update Status --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Status</h5>
                            <hr/>

                            @if (count($allowedStatuses))
                                <form action="{{ route('superadmin.orders.status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-2">
                                        <select name="status" class="form-select">
                                            @foreach ($allowedStatuses as $key)
                                                <option value="{{ $key }}">{{ config("order.statuses.$key.label", $key) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="note" rows="2" class="form-control" placeholder="Note (optional)" maxlength="1000"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                                </form>
                            @else
                                <div class="text-muted">This order is in a final status and cannot be changed.</div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Payment Status</h5>
                            <hr/>
                            <form action="{{ route('superadmin.orders.payment-status', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-2">
                                    <select name="payment_status" class="form-select">
                                        @foreach (config('order.payment_statuses') as $key => $cfg)
                                            <option value="{{ $key }}" @selected($order->payment_status === $key)>{{ $cfg['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-outline-primary w-100">Update Payment</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Customer</h5>
                            <hr/>
                            <div class="fw-bold">{{ $order->name ?? '—' }}</div>
                            <div>{{ $order->phone ?? '—' }}</div>
                            <div>{{ $order->email ?? '—' }}</div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Shipping Address</h5>
                            <hr/>
                            @if ($order->shippingAddress)
                                @foreach (collect($order->shippingAddress->toArray())->except(['id', 'user_id', 'customer_id', 'created_at', 'updated_at'])->filter() as $label => $val)
                                    <div><span class="text-muted text-capitalize">{{ str_replace('_', ' ', $label) }}:</span> {{ is_array($val) ? json_encode($val) : $val }}</div>
                                @endforeach
                            @else
                                <div class="text-muted">No address.</div>
                            @endif

                            @if ($order->shippingZone)
                                <div class="mt-2 text-muted small">Zone: {{ $order->shippingZone->name ?? '' }}</div>
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
