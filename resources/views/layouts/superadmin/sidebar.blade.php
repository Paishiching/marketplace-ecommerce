@php
    // Logo: Settings > favicon, na thakle logo, na thakle static icon, na thakle icon font
    $sidebarResolve = function (?string $path) {
        if (empty($path)) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (file_exists(public_path('storage/' . $path))
            || \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        return null;
    };

    $sidebarIcon = $sidebarResolve($site->favicon ?? null)
        ?: $sidebarResolve($site->logo ?? null)
        ?: (file_exists(public_path('superadmin/assets/images/logo-icon.png'))
            ? asset('superadmin/assets/images/logo-icon.png')
            : null);

    $sidebarName = $site->site_name ?: 'Marketplace';
@endphp
<div class="sidebar-wrapper" data-simplebar="true">
    @php
        $adminMode = auth()->user()?->hasRole('admin') && ! auth()->user()?->hasRole('superadmin');
        $openBuyerRequests = \Illuminate\Support\Facades\Cache::remember('sidebar.open_buyer_requests', now()->addSeconds(60), fn () => \App\Models\Rfq::where('status', 'open')->count());
    @endphp
    <div class="sidebar-header">
        <div>
            @if ($sidebarIcon)
                <img src="{{ $sidebarIcon }}" class="logo-icon" alt="{{ $sidebarName }}" style="width:35px;height:35px;object-fit:contain;">
            @else
                <i class='bx bx-store-alt font-30 text-primary'></i>
            @endif
        </div>
        <div>
            <h4 class="logo-text">{{ $sidebarName }}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
    @if ($adminMode)
        <li class="menu-label">Main</li>
        <li class="{{ request()->routeIs('admin.dashboards') ? 'mm-active' : '' }}"><a href="{{ route('admin.dashboards') }}"><div class="parent-icon"><i class='bx bx-home'></i></div><div class="menu-title">Dashboard</div></a></li>
        @if (auth()->user()->can('admin.products.products.index') || auth()->user()->can('admin.products.products.create') || auth()->user()->can('admin.products.categories.index') || auth()->user()->can('admin.products.categories.create'))
            <li class="menu-label">Catalog</li>
            <li class="{{ request()->routeIs('admin.products.products.*', 'admin.products.categories.*') ? 'mm-active' : '' }}"><a href="javascript:;" class="has-arrow"><div class="parent-icon"><i class='bx bx-cart-alt'></i></div><div class="menu-title">Products</div></a><ul>
                @can('admin.products.products.index')<li><a href="{{ route('admin.products.products.index') }}"><i class="bx bx-right-arrow-alt"></i>All Products</a></li>@endcan
                @can('admin.products.products.create')<li><a href="{{ route('admin.products.products.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a></li>@endcan
                @can('admin.products.categories.index')<li><a href="{{ route('admin.products.categories.index') }}"><i class="bx bx-right-arrow-alt"></i>Category</a></li>@endcan
                @can('admin.products.categories.create')<li><a href="{{ route('admin.products.categories.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Category</a></li>@endcan
            </ul></li>
        @endif
        @can('admin.products.inventories.index')<li><a href="{{ route('admin.products.inventories.index') }}"><div class="parent-icon"><i class='bx bx-package'></i></div><div class="menu-title">Inventory</div></a></li>@endcan
        @php $showSales = auth()->user()->can('admin.orders.orders.index') || auth()->user()->can('admin.orders.shipments.index') || auth()->user()->can('admin.customers.customers.index') || auth()->user()->can('admin.rfqs.index'); @endphp
        @if ($showSales)<li class="menu-label">Sales</li>@endif
        @can('admin.orders.orders.index')<li class="{{ request()->routeIs('admin.orders.orders.*') ? 'mm-active' : '' }}"><a href="{{ route('admin.orders.orders.index') }}"><div class="parent-icon"><i class='bx bx-receipt'></i></div><div class="menu-title">Orders</div></a></li>@endcan
        @can('admin.orders.shipments.index')<li class="{{ request()->routeIs('admin.orders.shipments.*') ? 'mm-active' : '' }}"><a href="{{ route('admin.orders.shipments.index') }}"><div class="parent-icon"><i class='bx bx-car'></i></div><div class="menu-title">Delivery transport</div></a></li>@endcan
        @can('admin.customers.customers.index')<li><a href="{{ route('admin.customers.customers.index') }}"><div class="parent-icon"><i class='bx bx-user'></i></div><div class="menu-title">Customers</div></a></li>@endcan
        @can('admin.rfqs.index')<li class="{{ request()->routeIs('admin.rfqs.*') ? 'mm-active' : '' }}"><a href="{{ route('admin.rfqs.index') }}"><div class="parent-icon"><i class='bx bx-message-square-detail'></i></div><div class="menu-title">Buyer inquiries ({{ $openBuyerRequests }})</div></a></li>@endcan
        <li class="menu-label">Account</li><li><a href="{{ route('homes') }}" target="_blank"><div class="parent-icon"><i class='bx bx-store'></i></div><div class="menu-title">View Website</div></a></li>
    @else

        <li class="menu-label">Main</li>
        <li class="{{ request()->routeIs('superadmin.dashboards') ? 'mm-active' : '' }}">
            <a href="{{ route('superadmin.dashboards') }}">
                <div class="parent-icon"><i class='bx bx-home'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="menu-label">Catalog</li>
        <li class="{{ request()->routeIs('superadmin.products.*', 'superadmin.categories.*', 'superadmin.brands.*', 'superadmin.attributes.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart-alt'></i></div>
                <div class="menu-title">Products</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.products.index') }}"><i class="bx bx-right-arrow-alt"></i>All Products</a></li>
                <li><a href="{{ route('superadmin.products.index', ['status' => 'pending']) }}"><i class="bx bx-right-arrow-alt"></i>Pending Products</a></li>
                <li><a href="{{ route('superadmin.products.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a></li>
                <li><a href="{{ route('superadmin.categories.index') }}"><i class="bx bx-right-arrow-alt"></i>Category</a></li>
                <li><a href="{{ route('superadmin.brands.index') }}"><i class="bx bx-right-arrow-alt"></i>Brand</a></li>
                <li><a href="{{ route('superadmin.attributes.index') }}"><i class="bx bx-right-arrow-alt"></i>Attributes</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Import / Export</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-package'></i></div>
                <div class="menu-title">Inventory</div>
            </a>
            <ul>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Stock Overview</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Stock Movements</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Warehouses</a></li>
            </ul>
        </li>

        <li class="menu-label">Sales</li>
        <li class="{{ request()->routeIs('superadmin.orders.*', 'superadmin.manual-orders.*', 'superadmin.delivery-transport.*', 'superadmin.returns', 'superadmin.refunds.*', 'superadmin.deliveries') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-receipt'></i></div>
                <div class="menu-title">Orders</div>
            </a>
                   <ul>
                <li><a href="{{ route('superadmin.orders.index') }}"><i class="bx bx-right-arrow-alt"></i>All Orders</a></li>
                <li><a href="{{ route('superadmin.orders.index', ['status' => 'pending']) }}"><i class="bx bx-right-arrow-alt"></i>Pending Orders</a></li>
                <li><a href="{{ route('superadmin.orders.index', ['status' => 'completed']) }}"><i class="bx bx-right-arrow-alt"></i>Completed Orders</a></li>
                <li><a href="{{ route('superadmin.orders.index', ['status' => 'cancelled']) }}"><i class="bx bx-right-arrow-alt"></i>Cancelled Orders</a></li>
                <li><a href="{{ route('superadmin.manual-orders.index') }}"><i class="bx bx-right-arrow-alt"></i>Manual order entry</a></li>
                <li><a href="{{ route('superadmin.delivery-transport.index') }}"><i class="bx bx-right-arrow-alt"></i>Delivery transport</a></li>
                <li><a href="{{ route('superadmin.returns') }}"><i class="bx bx-right-arrow-alt"></i>Returns</a></li>
                <li><a href="{{ route('superadmin.refunds.index') }}"><i class="bx bx-right-arrow-alt"></i>Refunds</a></li>
                <li><a href="{{ route('superadmin.deliveries') }}"><i class="bx bx-right-arrow-alt"></i>Deliveries</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.customers.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-user'></i></div>
                <div class="menu-title">Customers</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.customers.index') }}"><i class="bx bx-right-arrow-alt"></i>All Customers</a></li>
            <li><a href="{{ route('superadmin.rfqs.index') }}"><i class="bx bx-right-arrow-alt"></i>Buyer inquiries ({{ $openBuyerRequests }})</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Addresses</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Wallets</a></li>
            </ul>
        </li>

        <li class="menu-label">Sellers</li>
        <li class="{{ request()->routeIs('superadmin.vendors.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-store'></i></div>
                <div class="menu-title">Vendors</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.vendors.index') }}"><i class="bx bx-right-arrow-alt"></i>All Vendors</a></li>
                <li><a href="{{ route('superadmin.vendors.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Vendor</a></li>
                <li><a href="{{ route('superadmin.vendors.index', ['status' => 'pending']) }}"><i class="bx bx-right-arrow-alt"></i>Verification Requests</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Earnings</a></li>
                <li><a href="{{ route('superadmin.withdrawals.index') }}"><i class="bx bx-right-arrow-alt"></i>Withdrawals</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.suppliers.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-buildings'></i></div>
                <div class="menu-title">Suppliers</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.suppliers.index') }}"><i class="bx bx-right-arrow-alt"></i>All Suppliers</a></li>
                <li><a href="{{ route('superadmin.suppliers.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Supplier</a></li>
                <li><a href="{{ route('superadmin.suppliers.index', ['status' => 'pending']) }}"><i class="bx bx-right-arrow-alt"></i>Verification</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Supplier Products</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Purchase Orders</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Fulfillment</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Balance & Withdrawals</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.dropshippings.*', 'superadmin.dropshipping.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-git-branch'></i></div>
                <div class="menu-title">Dropshipping</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.dropshippings.index') }}"><i class="bx bx-right-arrow-alt"></i>Overview</a></li>
                <li><a href="{{ route('superadmin.dropshipping.products.index') }}"><i class="bx bx-right-arrow-alt"></i>Products</a></li>
                <li><a href="{{ route('superadmin.dropshipping.suppliers.index') }}"><i class="bx bx-right-arrow-alt"></i>Suppliers</a></li>
                <li><a href="{{ route('superadmin.dropshipping.imports.index') }}"><i class="bx bx-right-arrow-alt"></i>Import / Sync</a></li>
                <li><a href="{{ route('superadmin.dropshipping.orders.index') }}"><i class="bx bx-right-arrow-alt"></i>Orders</a></li>
                <li><a href="{{ route('superadmin.dropshipping.profit.index') }}"><i class="bx bx-right-arrow-alt"></i>Profit Report</a></li>
                <li><a href="{{ route('superadmin.dropshipping.settings.index') }}"><i class="bx bx-right-arrow-alt"></i>Settings</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.dropshipper-accounts.*') ? 'mm-active' : '' }}"><a href="{{ route('superadmin.dropshipper-accounts.index') }}"><div class="parent-icon"><i class='bx bx-user-check'></i></div><div class="menu-title">Dropshipping Partners</div></a></li>
        <li class="{{ request()->routeIs('superadmin.wholesales.*', 'superadmin.wholesale.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-box'></i></div>
                <div class="menu-title">Wholesale</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.wholesales.index') }}"><i class="bx bx-right-arrow-alt"></i>Overview</a></li>
                <li><a href="{{ route('superadmin.wholesale.products.index') }}"><i class="bx bx-right-arrow-alt"></i>Products</a></li>
                <li><a href="{{ route('superadmin.wholesale.tiers.index') }}"><i class="bx bx-right-arrow-alt"></i>Pricing Tiers</a></li>
                <li><a href="{{ route('superadmin.wholesale.bulk-orders.index') }}"><i class="bx bx-right-arrow-alt"></i>Bulk Orders</a></li>
                <li><a href="{{ route('superadmin.wholesale.moq.index') }}"><i class="bx bx-right-arrow-alt"></i>Min. Order Qty</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.wholesaler-accounts.*') ? 'mm-active' : '' }}"><a href="{{ route('superadmin.wholesaler-accounts.index') }}"><div class="parent-icon"><i class='bx bx-group'></i></div><div class="menu-title">Wholesale Partners</div></a></li>
        <li class="{{ request()->routeIs('superadmin.affiliates.*', 'superadmin.affiliate.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-share-alt'></i></div>
                <div class="menu-title">Affiliates</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.affiliates.index') }}"><i class="bx bx-right-arrow-alt"></i>All Affiliates</a></li>
                <li><a href="{{ route('superadmin.affiliates.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Affiliate</a></li>
                <li><a href="{{ route('superadmin.affiliates.index', ['status' => 'pending']) }}"><i class="bx bx-right-arrow-alt"></i>Pending Requests</a></li>
                <li><a href="{{ route('superadmin.affiliate.links.index') }}"><i class="bx bx-right-arrow-alt"></i>Links</a></li>
                <li><a href="{{ route('superadmin.affiliate.clicks.index') }}"><i class="bx bx-right-arrow-alt"></i>Clicks</a></li>
                <li><a href="{{ route('superadmin.affiliate.sales.index') }}"><i class="bx bx-right-arrow-alt"></i>Sales</a></li>
                <li><a href="{{ route('superadmin.commissions.index', ['type' => 'affiliate']) }}"><i class="bx bx-right-arrow-alt"></i>Commission</a></li>
                <li><a href="{{ route('superadmin.withdrawals.index', ['type' => 'affiliate']) }}"><i class="bx bx-right-arrow-alt"></i>Withdrawals</a></li>
            </ul>
        </li>

        <li class="{{ request()->routeIs('superadmin.resellers.*', 'superadmin.reseller.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-refresh'></i></div>
                <div class="menu-title">Resellers</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.resellers.index') }}"><i class="bx bx-right-arrow-alt"></i>All Resellers</a></li>
                <li><a href="{{ route('superadmin.resellers.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Reseller</a></li>
                <li><a href="{{ route('superadmin.resellers.index', ['status' => 'pending']) }}"><i class="bx bx-right-arrow-alt"></i>Pending Requests</a></li>
                <li><a href="{{ route('superadmin.reseller.products.index') }}"><i class="bx bx-right-arrow-alt"></i>Products</a></li>
                <li><a href="{{ route('superadmin.reseller.pricing.index') }}"><i class="bx bx-right-arrow-alt"></i>Pricing</a></li>
                <li><a href="{{ route('superadmin.reseller.earnings.index') }}"><i class="bx bx-right-arrow-alt"></i>Earnings</a></li>
            </ul>
        </li>

        <li class="menu-label">Marketing & Finance</li>
        <li class="{{ request()->routeIs('superadmin.coupons.*', 'superadmin.campaigns.*', 'superadmin.flash-sales.*', 'superadmin.sliders.*', 'superadmin.banners.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-purchase-tag-alt'></i></div>
                <div class="menu-title">Marketing</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.coupons.index') }}"><i class="bx bx-right-arrow-alt"></i>Coupons</a></li>
                <li><a href="{{ route('superadmin.campaigns.index') }}"><i class="bx bx-right-arrow-alt"></i>Campaigns</a></li>
                <li><a href="{{ route('superadmin.flash-sales.index') }}"><i class="bx bx-right-arrow-alt"></i>Flash Sales</a></li>
                <li><a href="{{ route('superadmin.sliders.index') }}"><i class="bx bx-right-arrow-alt"></i>Sliders</a></li>
                <li><a href="{{ route('superadmin.banners.index') }}"><i class="bx bx-right-arrow-alt"></i>Banners</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Promotions</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Advertisements</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.payments.*', 'superadmin.commissions.*', 'superadmin.withdrawals.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-wallet'></i></div>
                <div class="menu-title">Finance</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.payments.index') }}"><i class="bx bx-right-arrow-alt"></i>Payments</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Transactions</a></li>
                <li><a href="{{ route('superadmin.commissions.index') }}"><i class="bx bx-right-arrow-alt"></i>Commissions</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Balances (Vendor/Supplier/Affiliate)</a></li>
                <li><a href="{{ route('superadmin.withdrawals.index') }}"><i class="bx bx-right-arrow-alt"></i>Withdrawal Requests</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.couriers.*', 'superadmin.shipping-zones.*', 'superadmin.delivery-rates.*', 'superadmin.shipment-tracking.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-car'></i></div>
                <div class="menu-title">Delivery</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.couriers.index') }}"><i class="bx bx-right-arrow-alt"></i>Couriers</a></li>
                <li><a href="{{ route('superadmin.shipping-zones.index') }}"><i class="bx bx-right-arrow-alt"></i>Shipping Zones</a></li>
                <li><a href="{{ route('superadmin.delivery-rates.index') }}"><i class="bx bx-right-arrow-alt"></i>Delivery Rates</a></li>
                <li><a href="{{ route('superadmin.shipment-tracking.index') }}"><i class="bx bx-right-arrow-alt"></i>Tracking</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.warranties.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-shield-alt-2'></i></div>
                <div class="menu-title">Warranty</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.warranties.index') }}"><i class="bx bx-right-arrow-alt"></i>All Warranties</a></li>
                <li><a href="{{ route('superadmin.warranties.create') }}"><i class="bx bx-right-arrow-alt"></i>Add Warranty</a></li>
            </ul>
        </li>
        <li class="menu-label">Feedback & Reports</li>
        <li class="{{ request()->routeIs('superadmin.reviews.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-star'></i></div>
                <div class="menu-title">Reviews</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.reviews.index') }}"><i class="bx bx-right-arrow-alt"></i>All Reviews</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Ratings</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Reported Reviews</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.reports') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-line-chart'></i></div>
                <div class="menu-title">Reports</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.reports') }}"><i class="bx bx-right-arrow-alt"></i>Overview</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Sales Report</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Product Report</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Vendor Report</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Commission Report</a></li>
                <li><a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Financial Report</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.supports', 'superadmin.disputes.*', 'superadmin.frauds') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-support'></i></div>
                <div class="menu-title">Support</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.supports') }}"><i class="bx bx-right-arrow-alt"></i>Tickets</a></li>
                <li><a href="{{ route('superadmin.disputes.index') }}"><i class="bx bx-right-arrow-alt"></i>Disputes</a></li>
                <li><a href="{{ route('superadmin.frauds') }}"><i class="bx bx-right-arrow-alt"></i>Fraud Reports</a></li>
            </ul>
        </li>

        <li class="menu-label">Administration</li>
            <li class="{{ request()->routeIs('superadmin.users.*', 'superadmin.roles.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-shield-quarter'></i></div>
                <div class="menu-title">Users & Roles</div>
            </a>
            <ul>
                <li><a href="{{ route('superadmin.users.index') }}"><i class="bx bx-right-arrow-alt"></i>Admin Users</a></li>
                <li><a href="{{ route('superadmin.roles.index') }}"><i class="bx bx-right-arrow-alt"></i>Roles & Permissions</a></li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.activity-logs.*') ? 'mm-active' : '' }}">
            <a href="{{ route('superadmin.activity-logs.index') }}">
                <div class="parent-icon"><i class='bx bx-history'></i></div>
                <div class="menu-title">Activity Log</div>
            </a>
        </li>
        <li class="{{ request()->routeIs('superadmin.notifications.*') ? 'mm-active' : '' }}">
            <a href="{{ route('superadmin.notifications.index') }}">
                <div class="parent-icon"><i class='bx bx-bell'></i></div>
                <div class="menu-title">Notifications</div>
            </a>
        </li>
        <li class="{{ request()->routeIs('superadmin.settings.*') ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cog'></i></div>
                <div class="menu-title">Settings</div>
            </a>
            <ul>
                <li class="{{ request()->routeIs('superadmin.settings.website*') ? 'mm-active' : '' }}">
                    <a href="{{ route('superadmin.settings.website') }}"><i class="bx bx-right-arrow-alt"></i>Website Settings</a>
                </li>
                <li class="{{ request()->routeIs('superadmin.settings.payment*') ? 'mm-active' : '' }}">
                    <a href="{{ route('superadmin.settings.payment') }}"><i class="bx bx-right-arrow-alt"></i>Payment Settings</a>
                </li>
                <li class="{{ request()->routeIs('superadmin.settings.shipping*') ? 'mm-active' : '' }}">
                    <a href="{{ route('superadmin.settings.shipping') }}"><i class="bx bx-right-arrow-alt"></i>Shipping Settings</a>
                </li>
                <li class="{{ request()->routeIs('superadmin.settings.commission*') ? 'mm-active' : '' }}">
                    <a href="{{ route('superadmin.settings.commission') }}"><i class="bx bx-right-arrow-alt"></i>Commission Settings</a>
                </li>
            </ul>
        </li>
        <li class="{{ request()->routeIs('superadmin.profile.*') ? 'mm-active' : '' }}">
            <a href="{{ route('superadmin.profile.edit') }}">
                <div class="parent-icon"><i class='bx bx-user-pin'></i></div>
                <div class="menu-title">My Profile</div>
            </a>
        </li>
    @endif
    </ul>
    <!--end navigation-->
</div>
