<style>
    /* Vendor sidebar: menu text always readable (active / open / hover) */
    .sidebar-wrapper .metismenu a,
    .sidebar-wrapper .metismenu a .menu-title,
    .sidebar-wrapper .metismenu a .parent-icon i,
    .sidebar-wrapper .metismenu ul a,
    .sidebar-wrapper .metismenu ul a i {
        color: #4b5563 !important;
    }
    .sidebar-wrapper .metismenu li.mm-active > a,
    .sidebar-wrapper .metismenu li.mm-active > a .menu-title,
    .sidebar-wrapper .metismenu li.mm-active > a .parent-icon i,
    .sidebar-wrapper .metismenu a:hover,
    .sidebar-wrapper .metismenu a:hover .menu-title,
    .sidebar-wrapper .metismenu a:hover .parent-icon i,
    .sidebar-wrapper .metismenu a:focus,
    .sidebar-wrapper .metismenu ul a:hover,
    .sidebar-wrapper .metismenu ul a:hover i,
    .sidebar-wrapper .metismenu ul li.mm-active > a {
        color: #6f42c1 !important;
    }
    .sidebar-wrapper .metismenu li.mm-active > a,
    .sidebar-wrapper .metismenu a:hover {
        background: #efe9fb !important;
    }
    .sidebar-wrapper .metismenu ul {
        background: transparent !important;
    }
    .sidebar-wrapper .metismenu .menu-label {
        color: #9ca3af !important;
    }
</style>

<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('/') }}superadmin/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Vendor Panel</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i></div>
    </div>

    <ul class="metismenu" id="menu">

        <li class="menu-label">Main</li>
        <li class="{{ request()->routeIs('vendor.dashboards') ? 'mm-active' : '' }}">
            <a href="{{ route('vendor.dashboards') }}">
                <div class="parent-icon"><i class='bx bx-home'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="menu-label">Catalog</li>
        <li class="{{ request()->routeIs('vendor.products.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart-alt'></i></div>
                <div class="menu-title">Products</div>
            </a>
            <ul>
                <li><a href="{{ route('vendor.products.products.index') }}"><i class="bx bx-right-arrow-alt"></i>My Products</a></li>
                <li><a href="{{ route('vendor.products.products.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a></li>
                <li><a href="{{ route('vendor.products.inventories.index') }}"><i class="bx bx-right-arrow-alt"></i>Inventory</a></li>
                <li><a href="{{ route('vendor.products.variants') }}"><i class="bx bx-right-arrow-alt"></i>Variants</a></li>
            </ul>
        </li>

        <li class="menu-label">Sales</li>
        <li class="{{ request()->routeIs('vendor.orders.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-receipt'></i></div>
                <div class="menu-title">Orders</div>
            </a>
            <ul>
                <li><a href="{{ route('vendor.orders.orders.index') }}"><i class="bx bx-right-arrow-alt"></i>All Orders</a></li>
                <li><a href="{{ route('vendor.orders.shipments.index') }}"><i class="bx bx-right-arrow-alt"></i>Shipments</a></li>
                <li><a href="{{ route('vendor.orders.trackings') }}"><i class="bx bx-right-arrow-alt"></i>Tracking</a></li>
                <li><a href="{{ route('vendor.orders.returns') }}"><i class="bx bx-right-arrow-alt"></i>Returns</a></li>
                <li><a href="{{ route('vendor.orders.refunds.index') }}"><i class="bx bx-right-arrow-alt"></i>Refunds</a></li>
            </ul>
        </li>

        <li class="menu-label">Finance</li>
        <li class="{{ request()->routeIs('vendor.finance.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-wallet'></i></div>
                <div class="menu-title">Finance</div>
            </a>
            <ul>
                <li><a href="{{ route('vendor.finance.earnings') }}"><i class="bx bx-right-arrow-alt"></i>Earnings</a></li>
                <li><a href="{{ route('vendor.finance.balances') }}"><i class="bx bx-right-arrow-alt"></i>Balance</a></li>
                <li><a href="{{ route('vendor.finance.withdrawals.index') }}"><i class="bx bx-right-arrow-alt"></i>Withdrawals</a></li>
            </ul>
        </li>

        <li class="menu-label">Account</li>
        <li class="{{ request()->routeIs('vendor.shops*') ? 'mm-active' : '' }}">
            <a href="{{ route('vendor.shops') }}">
                <div class="parent-icon"><i class='bx bx-store-alt'></i></div>
                <div class="menu-title">My Shop</div>
            </a>
        </li>
        <li class="{{ request()->routeIs('vendor.profiles*') ? 'mm-active' : '' }}">
            <a href="{{ route('vendor.profiles') }}">
                <div class="parent-icon"><i class='bx bx-user-pin'></i></div>
                <div class="menu-title">My Profile</div>
            </a>
        </li>
        <li>
            <a href="{{ route('homes') }}" target="_blank">
                <div class="parent-icon"><i class='bx bx-store'></i></div>
                <div class="menu-title">View Website</div>
            </a>
        </li>
    </ul>
</div>