<div class="sidebar-wrapper" data-simplebar="true">
    @php $openBuyerRequests = \App\Models\Rfq::where('status', 'open')->count(); @endphp
    <div class="sidebar-header">
        <div><img src="{{ asset('/') }}superadmin/assets/images/logo-icon.png" class="logo-icon" alt="logo icon"></div>
        <div><h4 class="logo-text">Admin Panel</h4></div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i></div>
    </div>

    <ul class="metismenu" id="menu">
        <li class="menu-label">Main</li>
        <li class="{{ request()->routeIs('admin.dashboards') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.dashboards') }}">
                <div class="parent-icon"><i class='bx bx-home'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        @if(auth()->user()->can('admin.products.products.index') || auth()->user()->can('admin.products.products.create') || auth()->user()->can('admin.products.categories.index') || auth()->user()->can('admin.products.categories.create'))
        <li class="menu-label">Catalog</li>
        <li class="{{ request()->routeIs('admin.products.products.*', 'admin.products.categories.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow"><div class="parent-icon"><i class='bx bx-cart-alt'></i></div><div class="menu-title">Catalog</div></a>
            <ul>
                @can('admin.products.products.index')<li><a href="{{ route('admin.products.products.index') }}"><i class="bx bx-right-arrow-alt"></i>Products</a></li>@endcan
                @can('admin.products.products.create')<li><a href="{{ route('admin.products.products.create') }}"><i class="bx bx-right-arrow-alt"></i>Add product</a></li>@endcan
                @can('admin.products.categories.index')<li><a href="{{ route('admin.products.categories.index') }}"><i class="bx bx-right-arrow-alt"></i>Categories</a></li>@endcan
                @can('admin.products.categories.create')<li><a href="{{ route('admin.products.categories.create') }}"><i class="bx bx-right-arrow-alt"></i>Add category</a></li>@endcan
            </ul>
        </li>
        @endif
        @can('admin.products.inventories.index')<li><a href="{{ route('admin.products.inventories.index') }}"><div class="parent-icon"><i class='bx bx-package'></i></div><div class="menu-title">Inventory</div></a></li>@endcan

        <li class="menu-label">Sales</li>
        @can('admin.orders.orders.index')<li class="{{ request()->routeIs('admin.orders.orders.*') ? 'mm-active' : '' }}"><a href="{{ route('admin.orders.orders.index') }}"><div class="parent-icon"><i class='bx bx-receipt'></i></div><div class="menu-title">Orders</div></a></li>@endcan
        @can('admin.orders.shipments.index')<li class="{{ request()->routeIs('admin.orders.shipments.*') ? 'mm-active' : '' }}"><a href="{{ route('admin.orders.shipments.index') }}"><div class="parent-icon"><i class='bx bx-car'></i></div><div class="menu-title">Delivery transport</div></a></li>@endcan
        @can('admin.customers.customers.index')<li><a href="{{ route('admin.customers.customers.index') }}"><div class="parent-icon"><i class='bx bx-user'></i></div><div class="menu-title">Customers</div></a></li>@endcan
        @can('admin.rfqs.index')<li class="{{ request()->routeIs('admin.rfqs.*') ? 'mm-active' : '' }}"><a href="{{ route('admin.rfqs.index') }}"><div class="parent-icon"><i class='bx bx-message-square-detail'></i></div><div class="menu-title">Buyer inquiries (RFQs) @if($openBuyerRequests)<span class="badge bg-warning text-dark ms-1">{{ $openBuyerRequests }}</span>@endif</div></a></li>@endcan

        <li class="menu-label">Marketplace</li>
        <li><a href="javascript:;"><div class="parent-icon"><i class='bx bx-store'></i></div><div class="menu-title">Vendors</div></a></li>
        <li><a href="javascript:;"><div class="parent-icon"><i class='bx bx-buildings'></i></div><div class="menu-title">Suppliers</div></a></li>
        <li><a href="javascript:;"><div class="parent-icon"><i class='bx bx-share-alt'></i></div><div class="menu-title">Affiliates</div></a></li>
        <li><a href="javascript:;"><div class="parent-icon"><i class='bx bx-refresh'></i></div><div class="menu-title">Resellers</div></a></li>

        <li class="menu-label">Account</li>
        <li>
            <a href="{{ route('homes') }}" target="_blank">
                <div class="parent-icon"><i class='bx bx-store'></i></div>
                <div class="menu-title">View Website</div>
            </a>
        </li>
    </ul>
</div>
