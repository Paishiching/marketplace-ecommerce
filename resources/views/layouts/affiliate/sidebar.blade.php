<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div><img src="{{ asset('/') }}superadmin/assets/images/logo-icon.png" class="logo-icon" alt="logo icon"></div>
        <div><h4 class="logo-text">Affiliate Panel</h4></div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i></div>
    </div>

    <ul class="metismenu" id="menu">
        <li class="menu-label">Main</li>
        <li class="{{ request()->routeIs('affiliate.dashboards') ? 'mm-active' : '' }}">
            <a href="{{ route('affiliate.dashboards') }}">
                <div class="parent-icon"><i class='bx bx-home'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="menu-label">Promote</li>
        <li class="{{ request()->routeIs('affiliate.products.*') ? 'mm-active' : '' }}"><a href="{{ route('affiliate.products.index') }}"><div class="parent-icon"><i class='bx bx-cart-alt'></i></div><div class="menu-title">Products</div></a></li>
        <li class="{{ request()->routeIs('affiliate.links*') ? 'mm-active' : '' }}"><a href="{{ route('affiliate.links') }}"><div class="parent-icon"><i class='bx bx-link'></i></div><div class="menu-title">My Links</div></a></li>
        <li class="{{ request()->routeIs('affiliate.clicks') ? 'mm-active' : '' }}"><a href="{{ route('affiliate.clicks') }}"><div class="parent-icon"><i class='bx bx-pointer'></i></div><div class="menu-title">Clicks</div></a></li>
        <li class="{{ request()->routeIs('affiliate.sales') ? 'mm-active' : '' }}"><a href="{{ route('affiliate.sales') }}"><div class="parent-icon"><i class='bx bx-receipt'></i></div><div class="menu-title">Sales</div></a></li>
        <li class="{{ request()->routeIs('affiliate.campaigns.*') ? 'mm-active' : '' }}"><a href="{{ route('affiliate.campaigns.index') }}"><div class="parent-icon"><i class='bx bx-purchase-tag-alt'></i></div><div class="menu-title">Campaigns</div></a></li>

        <li class="menu-label">Finance</li>
        <li class="{{ request()->routeIs('affiliate.commissions.*', 'affiliate.earnings') ? 'mm-active' : '' }}"><a href="{{ route('affiliate.commissions.index') }}"><div class="parent-icon"><i class='bx bx-wallet'></i></div><div class="menu-title">Commissions</div></a></li>
        <li class="{{ request()->routeIs('affiliate.withdrawals.*') ? 'mm-active' : '' }}"><a href="{{ route('affiliate.withdrawals.index') }}"><div class="parent-icon"><i class='bx bx-money'></i></div><div class="menu-title">Withdrawals</div></a></li>
        <li class="{{ request()->routeIs('affiliate.reports') ? 'mm-active' : '' }}"><a href="{{ route('affiliate.reports') }}"><div class="parent-icon"><i class='bx bx-line-chart'></i></div><div class="menu-title">Reports</div></a></li>
        <li><a href="{{ route('affiliate.profiles') }}"><div class="parent-icon"><i class='bx bx-user'></i></div><div class="menu-title">Profile</div></a></li>

        <li class="menu-label">Account</li>
        <li>
            <a href="{{ route('homes') }}" target="_blank">
                <div class="parent-icon"><i class='bx bx-store'></i></div>
                <div class="menu-title">View Website</div>
            </a>
        </li>
    </ul>
</div>
