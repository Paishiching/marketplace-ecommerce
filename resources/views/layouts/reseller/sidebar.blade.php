<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('/') }}superadmin/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Reseller Panel</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i></div>
    </div>

    <ul class="metismenu" id="menu">
        <li class="menu-label">Main</li>
        <li class="{{ request()->routeIs('reseller.dashboards') ? 'mm-active' : '' }}">
            <a href="{{ route('reseller.dashboards') }}">
                <div class="parent-icon"><i class='bx bx-home'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="menu-label">Catalog</li>
        <li class="{{ request()->routeIs('reseller.products.*') ? 'mm-active' : '' }}">
            <a href="{{ route('reseller.products.index') }}">
                <div class="parent-icon"><i class='bx bx-cart-alt'></i></div>
                <div class="menu-title">Products</div>
            </a>
        </li>
        <li class="{{ request()->routeIs('reseller.pricings') ? 'mm-active' : '' }}">
            <a href="{{ route('reseller.pricings') }}">
                <div class="parent-icon"><i class='bx bx-purchase-tag-alt'></i></div>
                <div class="menu-title">Pricing</div>
            </a>
        </li>

        <li class="menu-label">Sales</li>
        <li class="{{ request()->routeIs('reseller.orders.*') ? 'mm-active' : '' }}">
            <a href="{{ route('reseller.orders.index') }}">
                <div class="parent-icon"><i class='bx bx-receipt'></i></div>
                <div class="menu-title">Orders</div>
            </a>
        </li>
        <li class="{{ request()->routeIs('reseller.customers.*') ? 'mm-active' : '' }}">
            <a href="{{ route('reseller.customers.index') }}">
                <div class="parent-icon"><i class='bx bx-user'></i></div>
                <div class="menu-title">Customers</div>
            </a>
        </li>

        <li class="menu-label">Finance</li>
        <li class="{{ request()->routeIs('reseller.earnings') ? 'mm-active' : '' }}">
            <a href="{{ route('reseller.earnings') }}">
                <div class="parent-icon"><i class='bx bx-wallet'></i></div>
                <div class="menu-title">Earnings</div>
            </a>
        </li>
        <li class="{{ request()->routeIs('reseller.withdrawals.*') ? 'mm-active' : '' }}">
            <a href="{{ route('reseller.withdrawals.index') }}">
                <div class="parent-icon"><i class='bx bx-money'></i></div>
                <div class="menu-title">Withdrawals</div>
            </a>
        </li>
        <li><a href="{{ route('reseller.profiles') }}"><div class="parent-icon"><i class='bx bx-user'></i></div><div class="menu-title">Profile</div></a></li>

        <li class="menu-label">Account</li>
        <li>
            <a href="{{ route('homes') }}" target="_blank">
                <div class="parent-icon"><i class='bx bx-store'></i></div>
                <div class="menu-title">View Website</div>
            </a>
        </li>
    </ul>
</div>
