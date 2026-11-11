<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div><img src="{{ asset('/') }}superadmin/assets/images/logo-icon.png" class="logo-icon" alt="logo icon"></div>
        <div><h4 class="logo-text">Supplier Panel</h4></div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i></div>
    </div>

    <ul class="metismenu" id="menu">
        <li class="menu-label">Main</li>
        <li class="{{ request()->routeIs('supplier.dashboards') ? 'mm-active' : '' }}">
            <a href="{{ route('supplier.dashboards') }}">
                <div class="parent-icon"><i class='bx bx-home'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="menu-label">Catalog</li>
        <li class="{{ request()->routeIs('supplier.products.products.*') ? 'mm-active' : '' }}"><a href="{{ route('supplier.products.products.index') }}"><div class="parent-icon"><i class='bx bx-cart-alt'></i></div><div class="menu-title">Products</div></a></li>
        <li class="{{ request()->routeIs('supplier.products.inventories.*') ? 'mm-active' : '' }}"><a href="{{ route('supplier.products.inventories.index') }}"><div class="parent-icon"><i class='bx bx-package'></i></div><div class="menu-title">Inventory</div></a></li>
        <li class="{{ request()->routeIs('supplier.products.pricings') ? 'mm-active' : '' }}"><a href="{{ route('supplier.products.pricings') }}"><div class="parent-icon"><i class='bx bx-purchase-tag-alt'></i></div><div class="menu-title">Pricing</div></a></li>

        <li class="menu-label">Orders</li>
        <li class="{{ request()->routeIs('supplier.orders.orders.*') ? 'mm-active' : '' }}"><a href="{{ route('supplier.orders.orders.index') }}"><div class="parent-icon"><i class='bx bx-receipt'></i></div><div class="menu-title">Orders</div></a></li>
        <li class="{{ request()->routeIs('supplier.orders.purchase-orders') ? 'mm-active' : '' }}"><a href="{{ route('supplier.orders.purchase-orders') }}"><div class="parent-icon"><i class='bx bx-file'></i></div><div class="menu-title">Purchase Orders</div></a></li>
        <li class="{{ request()->routeIs('supplier.rfqs.*') ? 'mm-active' : '' }}"><a href="{{ route('supplier.rfqs.index') }}"><div class="parent-icon"><i class='bx bx-message-square-detail'></i></div><div class="menu-title">Buyer requests (RFQs)</div></a></li>
        <li class="{{ request()->routeIs('supplier.orders.shipments.*') ? 'mm-active' : '' }}"><a href="{{ route('supplier.orders.shipments.index') }}"><div class="parent-icon"><i class='bx bx-car'></i></div><div class="menu-title">Shipments</div></a></li>

        <li class="menu-label">Finance</li>
        <li class="{{ request()->routeIs('supplier.finance.earnings') ? 'mm-active' : '' }}"><a href="{{ route('supplier.finance.earnings') }}"><div class="parent-icon"><i class='bx bx-wallet'></i></div><div class="menu-title">Earnings</div></a></li>
        <li class="{{ request()->routeIs('supplier.finance.withdrawals.*') ? 'mm-active' : '' }}"><a href="{{ route('supplier.finance.withdrawals.index') }}"><div class="parent-icon"><i class='bx bx-money'></i></div><div class="menu-title">Withdrawals</div></a></li>
        <li><a href="{{ route('supplier.profiles') }}"><div class="parent-icon"><i class='bx bx-user'></i></div><div class="menu-title">Profile</div></a></li>

        <li class="menu-label">Account</li>
        <li>
            <a href="{{ route('homes') }}" target="_blank">
                <div class="parent-icon"><i class='bx bx-store'></i></div>
                <div class="menu-title">View Website</div>
            </a>
        </li>
    </ul>
</div>
