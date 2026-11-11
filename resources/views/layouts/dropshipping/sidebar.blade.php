<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header"><div><img src="{{ asset('superadmin/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo"></div><div><h4 class="logo-text">Dropshipping</h4></div><div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i></div></div>
    <ul class="metismenu" id="menu">
        <li class="menu-label">Main</li>
        <li class="{{ request()->routeIs('dropshipping.dashboards') ? 'mm-active' : '' }}"><a href="{{ route('dropshipping.dashboards') }}"><div class="parent-icon"><i class='bx bx-home'></i></div><div class="menu-title">Dashboard</div></a></li>
        <li class="menu-label">Business</li>
        <li class="{{ request()->routeIs('dropshipping.products.*') ? 'mm-active' : '' }}"><a href="{{ route('dropshipping.products.index') }}"><div class="parent-icon"><i class='bx bx-package'></i></div><div class="menu-title">My Products</div></a></li>
        <li class="{{ request()->routeIs('dropshipping.orders.*') ? 'mm-active' : '' }}"><a href="{{ route('dropshipping.orders.index') }}"><div class="parent-icon"><i class='bx bx-receipt'></i></div><div class="menu-title">My Orders</div></a></li>
        <li class="{{ request()->routeIs('dropshipping.settings*') ? 'mm-active' : '' }}"><a href="{{ route('dropshipping.settings') }}"><div class="parent-icon"><i class='bx bx-store'></i></div><div class="menu-title">Business settings</div></a></li>
        <li class="menu-label">Account</li>
        <li><a href="{{ route('homes') }}" target="_blank" rel="noopener"><div class="parent-icon"><i class='bx bx-link-external'></i></div><div class="menu-title">Visit website</div></a></li>
    </ul>
</div>
