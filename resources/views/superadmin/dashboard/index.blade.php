@extends('layouts.superadmin.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $money = fn ($v) => $currency . number_format((float) $v, 2);

        $avatar = fn ($user, int $n = 1) => ($user && $user->avatar)
            ? asset('storage/' . $user->avatar)
            : asset('superadmin/assets/images/avatars/avatar-' . ((($n - 1) % 10) + 1) . '.png');

        $orderBadge = fn ($s) => match ($s) {
            'completed', 'delivered' => 'success',
            'cancelled', 'returned'  => 'danger',
            'processing', 'shipped'  => 'info',
            default                  => 'warning',
        };

        $vendorBadge = [
            'approved'  => ['success', 'Active'],
            'pending'   => ['warning', 'Pending'],
            'suspended' => ['danger', 'Suspended'],
        ];

        $withdrawBadge = fn ($s) => match (strtolower((string) $s)) {
            'approved', 'completed', 'paid', 'success' => 'success',
            'rejected', 'failed', 'cancelled'          => 'danger',
            'pending'                                  => 'warning',
            default                                    => 'secondary',
        };

        $roleBadge = [
            'Vendor'    => 'primary',
            'Affiliate' => 'info',
            'Supplier'  => 'secondary',
            'Reseller'  => 'dark',
        ];

        $cards = [
            ['label' => 'Total Orders',    'value' => number_format($stats['orders']),               'icon' => 'bx-cart',   'chart' => 'chart1'],
            ['label' => 'Total Revenue',   'value' => $currency . number_format($stats['revenue']),  'icon' => 'bx-wallet', 'chart' => 'chart2'],
            ['label' => 'Total Customers', 'value' => number_format($stats['customers']),            'icon' => 'bx-group',  'chart' => 'chart3'],
            ['label' => 'Active Vendors',  'value' => number_format($stats['vendors']),              'icon' => 'bx-store',  'chart' => 'chart4'],
        ];

        $zoneDots = ['text-success', 'text-danger', 'text-primary', 'text-warning'];
    @endphp

    <div class="page-wrapper">
        <div class="page-content">

            {{-- ============ Top cards ============ --}}
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
                @foreach ($cards as $card)
                    <div class="col">
                        <div class="card radius-10 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0">{{ $card['label'] }}</p>
                                        <h5 class="mb-0">{{ $card['value'] }}</h5>
                                    </div>
                                    <div class="ms-auto"><i class='bx {{ $card['icon'] }} font-30'></i></div>
                                </div>
                            </div>
                            <div class="" id="{{ $card['chart'] }}"></div>
                        </div>
                    </div>
                @endforeach
            </div><!--end row-->

            {{-- ============ Sales overview + Sales target ============ --}}
            <div class="row">
                <div class="col-12 col-xl-8 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="" id="chart5"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Sales Target</h5>
                                    <p class="mb-0 text-secondary">{{ now()->format('F Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-4" id="chart6"></div>
                            <div class="d-flex align-items-center">
                                <div>
                                    <h2 class="mb-0">{{ number_format($ordersThisMonth) }}</h2>
                                    <p class="mb-0">/{{ number_format($target) }} target</p>
                                </div>
                                <div class="ms-auto d-flex align-items-center border radius-10 px-2">
                                    <i class='bx bxs-checkbox font-22 me-1 text-primary'></i><span>Marketplace Orders</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            {{-- ============ Orders by status + Sales report ============ --}}
            <div class="row row-cols-1 row-cols-xl-2">
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="" id="chart7"></div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Sales Report</h5>
                                    <p class="mb-0 text-secondary">Last 30 days</p>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('superadmin.reports') }}" class="btn btn-primary btn-sm radius-30">Full Report</a>
                                </div>
                            </div>
                            <div class="" id="chart8"></div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            {{-- ============ Overall performance + Top locations ============ --}}
            <div class="row">
                <div class="col-12 col-xl-4 col-xxl-3 d-flex">
                    <div class="card radius-10 w-100 overflow-hidden">
                        <div class="card-body">
                            <p class="mb-1">Overall Sales Performance</p>
                            <div class="">
                                <h2 class="mb-0">{{ $money($thisMonthRevenue) }}</h2>
                                @if (! is_null($revenueChange))
                                    <p class="mb-0 {{ $revenueChange >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $revenueChange >= 0 ? '+' : '' }}{{ $revenueChange }}% vs last month
                                    </p>
                                @else
                                    <p class="mb-0 text-secondary">This month</p>
                                @endif
                            </div>
                        </div>
                        <div class="" id="chart9"></div>
                    </div>
                </div>
                <div class="col-12 col-xl-8 col-xxl-9 d-flex">
                    <div class="card w-100 radius-10">
                        <div class="row g-0">
                            <div class="col-md-4 border-end">
                                <div class="card-body">
                                    <h5 class="card-title">Top Sales Locations</h5>
                                    <h2 class="mt-4 mb-1">{{ number_format($topZones->sum('count')) }}</h2>
                                    <p class="mb-0 text-secondary">
                                        @if ($topZones->isNotEmpty())
                                            Most orders from {{ $topZones->first()->name }}
                                        @else
                                            No zone data yet
                                        @endif
                                    </p>
                                </div>
                                <ul class="list-group mt-4 list-group-flush">
                                    @foreach ($topZones->take(4) as $i => $zone)
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class='bx bxs-circle me-1 {{ $zoneDots[$i] ?? 'text-secondary' }}'></i>
                                            <span>{{ $zone->name }}</span>
                                            <strong class="ms-auto">{{ number_format($zone->count) }}</strong>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-8">
                                <div class="p-3">
                                    <div class="" id="geographic-map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            {{-- ============ New customers / Store metrics / Top products ============ --}}
            <div class="row">
                <div class="col-12 col-xl-4 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-0">New Customers</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('superadmin.customers.index') }}" class="btn btn-primary btn-sm radius-30">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="customers-list p-3 mb-3">
                            @forelse ($newCustomers as $i => $customer)
                                @php $u = $customer->user; @endphp
                                <div class="customers-list-item d-flex align-items-center border-bottom {{ $i === 0 ? 'border-top' : '' }} p-2 cursor-pointer"
                                     onclick="window.location='{{ route('superadmin.customers.show', $customer) }}'">
                                    <div class="">
                                        <img src="{{ $avatar($u, $i + 1) }}" class="rounded-circle" width="46" height="46" alt="" />
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-1 font-14">{{ $u->name ?? 'Customer #' . $customer->id }}</h6>
                                        <p class="mb-0 font-13 text-secondary">{{ $u->email ?? '—' }}</p>
                                    </div>
                                    <div class="list-inline d-flex customers-contacts ms-auto">
                                        @if ($u && $u->email)
                                            <a href="mailto:{{ $u->email }}" class="list-inline-item" onclick="event.stopPropagation()"><i class='bx bxs-envelope'></i></a>
                                        @endif
                                        @if ($u && ! empty($u->phone))
                                            <a href="tel:{{ $u->phone }}" class="list-inline-item" onclick="event.stopPropagation()"><i class='bx bxs-phone'></i></a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-secondary my-4">No customers yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4 d-flex">
                    <div class="card radius-10 w-100 overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-0">Store Metrics</h5>
                                </div>
                            </div>
                        </div>

                        <div class="store-metrics p-3 mb-3">
                            @php
                                $metrics = [
                                    ['Total Products',  $stats['products'],   'bg-light-primary text-primary', 'bxs-shopping-bag'],
                                    ['Total Customers', $stats['customers'],  'bg-light-danger text-danger',   'bxs-group'],
                                    ['Total Categories', $stats['categories'], 'bg-light-success text-success', 'bxs-category'],
                                    ['Total Orders',    $stats['orders'],     'bg-light-info text-info',       'bxs-cart-add'],
                                    ['Total Vendors',   $stats['vendors'],    'bg-light-warning text-warning', 'bxs-user-account'],
                                ];
                            @endphp
                            @foreach ($metrics as $k => $m)
                                <div class="card {{ $k === 0 ? 'mt-3' : '' }} radius-10 border shadow-none {{ $loop->last ? 'mb-0' : '' }}">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">{{ $m[0] }}</p>
                                                <h4 class="mb-0">{{ number_format($m[1]) }}</h4>
                                            </div>
                                            <div class="widgets-icons {{ $m[2] }} ms-auto"><i class='bx {{ $m[3] }}'></i></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Top Products</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('superadmin.products.index') }}" class="btn btn-primary btn-sm radius-30">View All</a>
                                </div>
                            </div>
                        </div>

                        <div class="product-list p-3 mb-3">
                            @forelse ($topProducts as $row)
                                @php $p = $row->product; @endphp
                                <div class="d-flex align-items-center py-3 border-bottom cursor-pointer"
                                     onclick="window.location='{{ route('superadmin.products.show', $p) }}'">
                                    <div class="product-img me-2">
                                        <img src="{{ $p->display_image }}" alt="{{ $p->name }}">
                                    </div>
                                    <div class="">
                                        <h6 class="mb-0 font-14">{{ \Illuminate\Support\Str::limit($p->name, 28) }}</h6>
                                        <p class="mb-0">{{ number_format($row->sold) }} Sales</p>
                                    </div>
                                    <div class="ms-auto">
                                        <h6 class="mb-0">{{ $money($p->discount_price ?? $p->price) }}</h6>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-secondary my-4">No sales yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            {{-- ============ Top vendors + Pending withdrawals ============ --}}
            <div class="row">
                <div class="col-12 col-xl-6 d-flex">
                    <div class="card radius-10 w-100 mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Top Vendors</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('superadmin.vendors.index') }}" class="btn btn-primary btn-sm radius-30">View All Vendors</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Vendor</th>
                                        <th>Products</th>
                                        <th>Orders</th>
                                        <th>Earnings</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($topVendors as $i => $vendor)
                                        @php [$vColor, $vLabel] = $vendorBadge[$vendor->status] ?? ['secondary', ucfirst((string) $vendor->status)]; @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ route('superadmin.vendors.show', $vendor) }}" class="text-reset">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $vendor->logo ? asset('storage/' . $vendor->logo) : asset('superadmin/assets/images/avatars/avatar-' . (($i % 10) + 1) . '.png') }}"
                                                             class="rounded-circle" width="36" height="36" alt="">
                                                        <div class="ms-2">
                                                            <h6 class="mb-0 font-14">{{ $vendor->shop_name }}</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>{{ number_format($vendor->products_count) }}</td>
                                            <td>{{ number_format($vendor->vendor_orders_count) }}</td>
                                            <td>{{ $money($vendor->earnings ?? 0) }}</td>
                                            <td><span class="badge bg-light-{{ $vColor }} text-{{ $vColor }} w-100">{{ $vLabel }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center text-secondary py-4">No vendors yet.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6 d-flex">
                    <div class="card radius-10 w-100 mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Pending Withdrawals</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('superadmin.withdrawals.index') }}" class="btn btn-primary btn-sm radius-30">View All Requests</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Requested By</th>
                                        <th>Role</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($pendingWithdrawals as $w)
                                        @php
                                            $role  = class_basename((string) $w->withdrawable_type);
                                            $rc    = $roleBadge[$role] ?? 'secondary';
                                            $wc    = $withdrawBadge($w->status);
                                        @endphp
                                        <tr>
                                            <td>{{ $w->holder_name ?: '—' }}</td>
                                            <td><span class="badge bg-light-{{ $rc }} text-{{ $rc }}">{{ $role ?: '—' }}</span></td>
                                            <td>{{ $money($w->amount) }}</td>
                                            <td>{{ $w->created_at?->format('d M, Y') }}</td>
                                            <td><span class="badge bg-light-{{ $wc }} text-{{ $wc }} w-100">{{ ucfirst($w->status) }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center text-secondary py-4">No pending withdrawal requests.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!--end row-->

            {{-- ============ Recent orders ============ --}}
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Recent Orders</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('superadmin.orders.index') }}" class="btn btn-primary btn-sm radius-30">View All Orders</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Products Name</th>
                                        <th>Vendor</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($recentOrders as $order)
                                        @php
                                            $first   = $order->orderItems->first();
                                            $extra   = $order->orderItems->count() - 1;
                                            $vendors = $order->orderItems->pluck('vendor.shop_name')->filter()->unique()->values();
                                            $bc      = $orderBadge($order->status);
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ route('superadmin.orders.show', $order) }}">#{{ $order->order_number }}</a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="recent-product-img">
                                                        <img src="{{ $first?->product?->display_image ?? asset('frontend/assets/images/imageIcon/image.jpg') }}" alt="">
                                                    </div>
                                                    <div class="ms-2">
                                                        <h6 class="mb-1 font-14">
                                                            {{ \Illuminate\Support\Str::limit($first?->product?->name ?? 'N/A', 30) }}
                                                            @if ($extra > 0)
                                                                <small class="text-secondary">+{{ $extra }} more</small>
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $vendors->first() ?? '—' }}
                                                @if ($vendors->count() > 1)
                                                    <small class="text-secondary">+{{ $vendors->count() - 1 }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at?->format('d M, Y') }}</td>
                                            <td><span class="badge bg-light-{{ $bc }} text-{{ $bc }} w-100">{{ ucfirst($order->status) }}</span></td>
                                            <td>{{ $money($order->total) }}</td>
                                            <td>
                                                <div class="d-flex order-actions">
                                                    @can('superadmin.orders.destroy')
                                                        <form action="{{ route('superadmin.orders.destroy', $order) }}" method="POST"
                                                              onsubmit="return confirm('Ei order ta delete korben?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-danger bg-light-danger border-0"><i class='bx bxs-trash'></i></button>
                                                        </form>
                                                    @endcan
                                                    <a href="{{ route('superadmin.orders.show', $order) }}" class="ms-4 text-primary bg-light-primary border-0"><i class='bx bxs-show'></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center text-secondary py-4">No orders yet.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!--end row-->

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const D   = @json($chart);
            const cur = @json($currency);

            const mount = function (id, options) {
                const node = document.querySelector(id);
                if (!node) { return; }
                new ApexCharts(node, Object.assign({ noData: { text: 'No data yet' } }, options)).render();
            };

            const money = function (v) { return cur + Number(v).toLocaleString(); };

            // ---- small sparkline charts (cards + overall performance) ----
            const spark = function (id, name, data, color, height) {
                mount(id, {
                    chart: { type: 'area', height: height || 60, sparkline: { enabled: true } },
                    series: [ { name: name, data: data } ],
                    xaxis: { categories: D.sparkLabels },
                    stroke: { curve: 'smooth', width: 2 },
                    colors: [color],
                    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 } },
                    tooltip: { fixed: { enabled: false }, marker: { show: false } }
                });
            };

            spark('#chart1', 'Orders',    D.sparkOrders,    '#0d6efd');
            spark('#chart2', 'Revenue',   D.sparkRevenue,   '#198754');
            spark('#chart3', 'Customers', D.sparkCustomers, '#fd7e14');
            spark('#chart4', 'Vendors',   D.sparkVendors,   '#6f42c1');

            // ---- Sales overview (12 months) ----
            mount('#chart5', {
                chart: { height: 360, type: 'line', toolbar: { show: false } },
                title: { text: 'Sales Overview (last 12 months)', align: 'left' },
                series: [
                    { name: 'Revenue', type: 'column', data: D.monthly.revenue },
                    { name: 'Orders',  type: 'line',   data: D.monthly.orders }
                ],
                stroke: { width: [0, 3], curve: 'smooth' },
                plotOptions: { bar: { columnWidth: '45%', borderRadius: 4 } },
                colors: ['#0d6efd', '#fd3550'],
                dataLabels: { enabled: false },
                xaxis: { categories: D.monthly.labels },
                yaxis: [
                    { title: { text: 'Revenue' }, labels: { formatter: function (v) { return money(Math.round(v)); } } },
                    { opposite: true, title: { text: 'Orders' }, labels: { formatter: function (v) { return Math.round(v); } } }
                ],
                legend: { position: 'bottom' }
            });

            // ---- Sales target (radial) ----
            mount('#chart6', {
                chart: { height: 260, type: 'radialBar' },
                series: [D.target.percent],
                labels: ['Orders'],
                colors: ['#0d6efd'],
                plotOptions: {
                    radialBar: {
                        hollow: { size: '62%' },
                        dataLabels: {
                            name: { fontSize: '14px' },
                            value: { fontSize: '26px', formatter: function (v) { return v + '%'; } }
                        }
                    }
                }
            });

            // ---- Orders by status (donut) ----
            const statusColors = {
                pending: '#ffc107', processing: '#0dcaf0', shipped: '#0d6efd', delivered: '#20c997',
                completed: '#198754', cancelled: '#dc3545', returned: '#6c757d'
            };
            const statusLabels = Object.keys(D.status);

            mount('#chart7', {
                chart: { height: 330, type: 'donut' },
                title: { text: 'Orders by Status', align: 'left' },
                series: statusLabels.map(function (k) { return Number(D.status[k]); }),
                labels: statusLabels.map(function (k) { return k.charAt(0).toUpperCase() + k.slice(1); }),
                colors: statusLabels.map(function (k) { return statusColors[k] || '#adb5bd'; }),
                legend: { position: 'bottom' },
                dataLabels: { enabled: true }
            });

            // ---- Sales report (last 30 days) ----
            const compactNumber = function (v) {
                return new Intl.NumberFormat('en', { notation: 'compact', maximumFractionDigits: 1 }).format(v);
            };

            mount('#chart8', {
                chart: { height: 330, type: 'bar', toolbar: { show: false } },
                series: [ { name: 'Revenue', data: D.daily30.revenue } ],
                xaxis: {
                    categories: D.daily30.labels,
                    tickAmount: 10,
                    labels: { rotate: 0, hideOverlappingLabels: true, style: { fontSize: '11px' } },
                    tooltip: { enabled: false }
                },
                yaxis: {
                    min: 0,
                    labels: { formatter: function (v) { return cur + compactNumber(v); } }
                },
                plotOptions: { bar: { columnWidth: '60%', borderRadius: 3 } },
                colors: ['#0d6efd'],
                dataLabels: { enabled: false },
                grid: { borderColor: '#eef0f3' },
                tooltip: { y: { formatter: function (v) { return money(v); } } }
            });

            // ---- Overall performance sparkline (12 months revenue) ----
            mount('#chart9', {
                chart: { type: 'area', height: 110, sparkline: { enabled: true } },
                series: [ { name: 'Revenue', data: D.monthly.revenue } ],
                xaxis: { categories: D.monthly.labels },
                stroke: { curve: 'smooth', width: 2 },
                colors: ['#198754'],
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 } },
                tooltip: { fixed: { enabled: false }, marker: { show: false } }
            });

            // ---- Top zones (replaces the demo world map) ----
            mount('#geographic-map', {
                chart: { type: 'bar', height: 300, toolbar: { show: false } },
                series: [ { name: 'Orders', data: D.zones.counts } ],
                xaxis: { categories: D.zones.names },
                plotOptions: { bar: { horizontal: true, borderRadius: 4, barHeight: '55%' } },
                colors: ['#0d6efd'],
                dataLabels: { enabled: true }
            });
        })();
    </script>
@endpush