@php
    $headerAlerts        = $headerAlerts ?? collect();
    $headerAlertCount    = $headerAlertCount ?? 0;
    $headerPendingOrders = $headerPendingOrders ?? 0;
    $headerOrders        = $headerOrders ?? collect();
    $authUser            = auth()->user();
    $hCurrency           = '৳';

    $quickLinks = [
        ['Products',  'bx-cart-alt',     'bg-gradient-cosmic',  route('superadmin.products.index')],
        ['Orders',    'bx-receipt',      'bg-gradient-burning', route('superadmin.orders.index')],
        ['Vendors',   'bx-store',        'bg-gradient-lush',    route('superadmin.vendors.index')],
        ['Suppliers', 'bx-buildings',    'bg-gradient-kyoto',   route('superadmin.suppliers.index')],
        ['Customers', 'bx-group',        'bg-gradient-blues',   route('superadmin.customers.index')],
        ['Reports',   'bx-line-chart',   'bg-gradient-moonlit', route('superadmin.reports')],
    ];

    $orderColor = fn ($s) => match ($s) {
        'completed', 'delivered' => 'success',
        'cancelled', 'returned'  => 'danger',
        'processing', 'shipped'  => 'info',
        default                  => 'warning',
    };
@endphp
<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>
            <div class="top-menu-left d-none d-lg-block">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('superadmin.supports') }}" title="Support Tickets"><i class='bx bx-envelope'></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('superadmin.notifications.index') }}" title="Notifications"><i class='bx bx-message'></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('superadmin.reports') }}" title="Reports"><i class='bx bx-calendar'></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('superadmin.orders.index', ['status' => 'pending']) }}" title="Pending Orders"><i class='bx bx-check-square'></i></a>
                    </li>
                </ul>
            </div>
            <div class="search-bar flex-grow-1">
                <div class="position-relative search-bar-box">
                    <form action="{{ route('superadmin.orders.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control search-control" placeholder="Search orders (order no, name, phone)..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
                        <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
                    </form>
                </div>
            </div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon">
                        <a class="nav-link" href="javascript:;"><i class='bx bx-search'></i>
                        </a>
                    </li>
                    <li class="nav-item dark-mode d-none d-sm-flex">
                        <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
                        </a>
                    </li>

                    {{-- Quick links --}}
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class='bx bx-category'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="row row-cols-3 g-3 p-3">
                                @foreach ($quickLinks as [$label, $icon, $gradient, $url])
                                    <div class="col text-center">
                                        <a href="{{ $url }}" class="text-reset text-decoration-none">
                                            <div class="app-box mx-auto {{ $gradient }}"><i class='bx {{ $icon }}'></i>
                                            </div>
                                            <div class="app-title">{{ $label }}</div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </li>

                    {{-- Alerts (pending actions) --}}
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if ($headerAlertCount > 0)
                                <span class="alert-count">{{ $headerAlertCount > 99 ? '99+' : $headerAlertCount }}</span>
                            @endif
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Needs Attention</p>
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                @forelse ($headerAlerts as $alert)
                                    <a class="dropdown-item" href="{{ $alert['url'] }}">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-{{ $alert['color'] }} text-{{ $alert['color'] }}"><i class="bx {{ $alert['icon'] }}"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">{{ $alert['title'] }}</h6>
                                                <p class="msg-info">{{ $alert['text'] }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center text-secondary py-4">
                                        <i class='bx bx-check-circle font-30 d-block mb-1'></i>
                                        Everything is up to date
                                    </div>
                                @endforelse
                            </div>
                            <a href="{{ route('superadmin.notifications.index') }}">
                                <div class="text-center msg-footer">View All Notifications</div>
                            </a>
                        </div>
                    </li>

                    {{-- Latest orders --}}
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if ($headerPendingOrders > 0)
                                <span class="alert-count">{{ $headerPendingOrders > 99 ? '99+' : $headerPendingOrders }}</span>
                            @endif
                            <i class='bx bx-cart-alt'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Latest Orders</p>
                                </div>
                            </a>
                            <div class="header-message-list">
                                @forelse ($headerOrders as $o)
                                    @php $oc = $orderColor($o->status); @endphp
                                    <a class="dropdown-item" href="{{ route('superadmin.orders.show', $o->id) }}">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-{{ $oc }} text-{{ $oc }}"><i class="bx bx-receipt"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">{{ $o->name ?: 'Guest' }} <span class="msg-time float-end">{{ $o->created_at?->diffForHumans(null, true, true) }}</span></h6>
                                                <p class="msg-info">#{{ $o->order_number }} &bull; {{ $hCurrency }}{{ number_format((float) $o->total, 2) }} &bull; {{ ucfirst($o->status) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center text-secondary py-4">No orders yet</div>
                                @endforelse
                            </div>
                            <a href="{{ route('superadmin.orders.index') }}">
                                <div class="text-center msg-footer">View All Orders</div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- User box --}}
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if ($authUser->avatar)
                        <img src="{{ asset('storage/' . $authUser->avatar) }}" class="user-img" alt="user avatar">
                    @else
                        <img src="{{ asset('superadmin/assets/images/avatars/avatar-2.png') }}" class="user-img" alt="user avatar">
                    @endif
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ $authUser->name }}</p>
                        <p class="designattion mb-0">{{ $authUser->getRoleNames()->first() ?? 'Super Admin' }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('superadmin.profile.edit') }}">
                            <i class="bx bx-user"></i><span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('superadmin.settings.website') }}">
                            <i class="bx bx-cog"></i><span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('superadmin.dashboards') }}">
                            <i class='bx bx-home-circle'></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ url('/') }}" target="_blank" rel="noopener">
                            <i class='bx bx-link-external'></i><span>Visit Website</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class='bx bx-log-out-circle'></i><span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>