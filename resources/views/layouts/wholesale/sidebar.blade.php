<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header"><div><img src="{{ asset('superadmin/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo"></div><div><h4 class="logo-text">Wholesale</h4></div><div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i></div></div>
    <ul class="metismenu" id="menu">
        <li class="menu-label">Main</li>
        <li class="{{ request()->routeIs('wholesale.dashboards') ? 'mm-active' : '' }}"><a href="{{ route('wholesale.dashboards') }}"><div class="parent-icon"><i class='bx bx-home'></i></div><div class="menu-title">Dashboard</div></a></li>
        <li class="menu-label">Business</li>
        <li class="{{ request()->routeIs('wholesale.products.*') ? 'mm-active' : '' }}"><a href="{{ route('wholesale.products.index') }}"><div class="parent-icon"><i class='bx bx-package'></i></div><div class="menu-title">My Products</div></a></li>
        <li class="{{ request()->routeIs('wholesale.orders.*') ? 'mm-active' : '' }}"><a href="{{ route('wholesale.orders.index') }}"><div class="parent-icon"><i class='bx bx-receipt'></i></div><div class="menu-title">Bulk Orders</div></a></li>
        <li class="{{ request()->routeIs('wholesale.tiers.*') ? 'mm-active' : '' }}"><a href="{{ route('wholesale.tiers.index') }}"><div class="parent-icon"><i class='bx bx-purchase-tag-alt'></i></div><div class="menu-title">Price Tiers</div></a></li>
        <li class="{{ request()->routeIs('wholesale.settings*') ? 'mm-active' : '' }}"><a href="{{ route('wholesale.settings') }}"><div class="parent-icon"><i class='bx bx-store'></i></div><div class="menu-title">Business settings</div></a></li>
        <li class="menu-label">Account</li>
        <li><a href="{{ route('homes') }}" target="_blank" rel="noopener"><div class="parent-icon"><i class='bx bx-link-external'></i></div><div class="menu-title">Visit website</div></a></li>
    </ul>
</div>
