@extends('layouts.superadmin.app')

@section('title','Orders')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Sales</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Orders</li>
                        </ol>
                    </nav>
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

            @if (session('bulk_errors'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Some orders were skipped or failed:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach (session('bulk_errors') as $msg)
                            <li>{{ $msg }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Status tabs --}}
            <ul class="nav nav-pills mb-3 flex-wrap gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request('status') ? '' : 'active' }}"
                       href="{{ route('superadmin.orders.index') }}">
                        All <span class="badge bg-secondary ms-1">{{ $statusCounts->sum() }}</span>
                    </a>
                </li>
                @foreach (config('order.statuses') as $key => $cfg)
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') === $key ? 'active' : '' }}"
                           href="{{ route('superadmin.orders.index', ['status' => $key]) }}">
                            {{ $cfg['label'] }} <span class="badge bg-secondary ms-1">{{ $statusCounts[$key] ?? 0 }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="card">
                <div class="card-body">

                    {{-- Filters --}}
                    <form method="GET" action="{{ route('superadmin.orders.index') }}" class="row g-2 mb-4">
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif

                        <div class="col-lg-3">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                   placeholder="Order no, name, phone, email">
                        </div>
                        <div class="col-lg-2">
                            <select name="payment_status" class="form-select">
                                <option value="">All payments</option>
                                @foreach (config('order.payment_statuses') as $key => $cfg)
                                    <option value="{{ $key }}" @selected(request('payment_status') === $key)>{{ $cfg['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                        </div>
                        <div class="col-lg-2">
                            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                        </div>
                        <div class="col-lg-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Filter</button>
                            <a href="{{ route('superadmin.orders.index', request('status') ? ['status' => request('status')] : []) }}"
                               class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    {{-- Bulk form --}}
                    <form id="bulkForm" method="POST">
                        @csrf

                        <div class="border rounded p-3 mb-3 bg-light">
                            <div class="row g-2 align-items-center">
                                <div class="col-lg-3">
                                    <strong><span id="selectedCount">0</span> selected</strong>
                                    <div class="text-muted small">Max 20 orders for courier</div>
                                </div>
                                <div class="col-lg-3">
                                    <select name="courier_id" id="bulkCourier" class="form-select">
                                        <option value="">Select courier</option>
                                        @foreach ($apiCouriers as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 d-flex flex-wrap gap-2">
                                    <button type="submit" id="btnCourier"
                                            formaction="{{ route('superadmin.orders.bulk.courier') }}"
                                            class="btn btn-success">
                                        <i class="bx bx-send"></i> Send to Courier
                                    </button>
                                    <button type="submit" name="status" value="processing"
                                            formaction="{{ route('superadmin.orders.bulk.status') }}"
                                            class="btn btn-info bulk-status">
                                        Mark Processing
                                    </button>
                                    <button type="submit" name="status" value="completed"
                                            formaction="{{ route('superadmin.orders.bulk.status') }}"
                                            class="btn btn-outline-success bulk-status">
                                        Mark Completed
                                    </button>
                                    <button type="submit" name="status" value="cancelled"
                                            formaction="{{ route('superadmin.orders.bulk.status') }}"
                                            class="btn btn-outline-danger bulk-status">
                                        Cancel
                                    </button>
                                    <button type="submit" id="btnDelete"
                                            formaction="{{ route('superadmin.orders.bulk.delete') }}"
                                            class="btn btn-danger">
                                        <i class="bx bx-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                            @if ($apiCouriers->isEmpty())
                                <div class="text-danger small mt-2">No active API courier. Set up Steadfast from Delivery &gt; Couriers.</div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th style="width:40px;"><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                    <th>Order#</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input row-check" name="order_ids[]" value="{{ $order->id }}">
                                        </td>
                                        <td><h6 class="mb-0 font-14">#{{ $order->order_number ?? $order->id }}</h6></td>
                                        <td>
                                            {{ $order->name ?? '—' }}
                                            <div class="text-muted small">{{ $order->phone ?? $order->email }}</div>
                                        </td>
                                        <td>{{ $order->order_items_count }}</td>
                                        <td>Tk. {{ number_format($order->total, 2) }}</td>
                                        <td>@include('superadmin.orders._badge', ['type' => 'payment_statuses', 'value' => $order->payment_status])</td>
                                        <td>@include('superadmin.orders._badge', ['type' => 'statuses', 'value' => $order->status])</td>
                                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                        <td>
                                            <div class="d-flex gap-1 flex-nowrap">
                                                <a href="{{ route('superadmin.orders.show', $order->id) }}"
                                                   class="btn btn-primary btn-sm radius-30 px-3">View</a>

                                                <a href="{{ route('superadmin.orders.invoice', $order->id) }}"
                                                   target="_blank"
                                                   class="btn btn-outline-secondary btn-sm radius-30 px-3">
                                                    <i class="bx bx-printer"></i> Invoice
                                                </a>

                                                @if (in_array($order->status, config('order.deletable', []), true))
                                                    <button type="submit"
                                                            form="deleteForm{{ $order->id }}"
                                                            class="btn btn-danger btn-sm radius-30 px-3"
                                                            onclick="return confirm('Delete this order?');">
                                                        <i class="bx bx-trash"></i> Delete
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-outline-danger btn-sm radius-30 px-3" disabled
                                                            title="Only cancelled orders can be deleted">
                                                        <i class="bx bx-trash"></i> Delete
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-center py-4">No orders found.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    {{-- Single delete forms (bulk form er baire) --}}
                    @foreach ($orders as $order)
                        @if (in_array($order->status, config('order.deletable', []), true))
                            <form id="deleteForm{{ $order->id }}"
                                  action="{{ route('superadmin.orders.destroy', $order->id) }}"
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    @endforeach

                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const form     = document.getElementById('bulkForm');
            const checkAll = document.getElementById('checkAll');
            const counter  = document.getElementById('selectedCount');
            const courier  = document.getElementById('bulkCourier');
            const rows     = () => document.querySelectorAll('.row-check');
            const checked  = () => document.querySelectorAll('.row-check:checked');

            function refresh() {
                counter.textContent = checked().length;
                checkAll.checked = rows().length > 0 && checked().length === rows().length;
            }

            checkAll.addEventListener('change', function () {
                rows().forEach(b => b.checked = checkAll.checked);
                refresh();
            });
            rows().forEach(b => b.addEventListener('change', refresh));
            refresh();

            form.addEventListener('submit', function (e) {
                const btn = e.submitter;
                const n   = checked().length;

                if (n === 0) {
                    e.preventDefault();
                    alert('Select at least one order.');
                    return;
                }

                if (btn && btn.id === 'btnCourier') {
                    if (!courier.value) {
                        e.preventDefault();
                        alert('Select a courier first.');
                        return;
                    }
                    if (n > 20) {
                        e.preventDefault();
                        alert('Select up to 20 orders at a time.');
                        return;
                    }
                    if (!confirm('Send ' + n + ' order(s) to ' + courier.selectedOptions[0].text + '?')) {
                        e.preventDefault();
                        return;
                    }
                } else if (btn && btn.id === 'btnDelete') {
                    if (!confirm('Delete ' + n + ' order(s)? Only cancelled orders will be deleted.')) {
                        e.preventDefault();
                        return;
                    }
                } else if (btn && btn.classList.contains('bulk-status')) {
                    if (!confirm('Change status of ' + n + ' order(s) to ' + btn.textContent.trim() + '?')) {
                        e.preventDefault();
                        return;
                    }
                }

                if (btn) {
                    // disabled button er name/value jeno haray na jay
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = btn.name || '_';
                    hidden.value = btn.value || '';
                    form.appendChild(hidden);

                    btn.disabled = true;
                    btn.innerHTML = 'Please wait...';
                }
            });
        })();
    </script>
@endpush