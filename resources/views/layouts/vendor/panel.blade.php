<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vendor Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body{background:#f4f6fb;font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}
        .vp-side{width:260px;min-height:100vh;background:#0f1b3d;color:#cbd5e1;position:fixed;top:0;left:0;padding:22px 14px;overflow-y:auto}
        .vp-brand{color:#fff;font-weight:800;font-size:20px;padding:0 10px 18px;border-bottom:1px solid rgba(255,255,255,.1);margin-bottom:14px}
        .vp-brand small{display:block;font-size:12px;font-weight:500;color:#94a3b8}
        .vp-menu{list-style:none;margin:0;padding:0}
        .vp-menu a{display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:10px;color:#cbd5e1;text-decoration:none;font-weight:600;font-size:14.5px;transition:.2s}
        .vp-menu a:hover{background:rgba(255,255,255,.08);color:#fff}
        .vp-menu a.active{background:#146cda;color:#fff}
        .vp-label{font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#64748b;margin:18px 14px 6px}
        .vp-main{margin-left:260px}
        .vp-top{background:#fff;padding:14px 28px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 10px rgba(16,42,90,.06)}
        .vp-body{padding:28px}
        .vp-card{background:#fff;border:1px solid #e9eef6;border-radius:16px;box-shadow:0 8px 24px rgba(16,42,90,.06)}
        @media(max-width:991px){.vp-side{position:static;width:100%;min-height:auto}.vp-main{margin-left:0}}
    </style>
    @stack('styles')
</head>
<body>
<aside class="vp-side">
    <div class="vp-brand">
        {{ $site->site_name ?? 'Marketplace' }}
        <small>Vendor Panel</small>
    </div>

    <ul class="vp-menu">
        <li><a href="{{ route('vendor.dashboards') }}" class="{{ request()->routeIs('vendor.dashboards') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>

        <li class="vp-label">Catalog</li>
        <li><a href="{{ route('vendor.products.products.index') }}" class="{{ request()->routeIs('vendor.products.products.*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i> My Products</a></li>
        <li><a href="{{ route('vendor.products.inventories.index') }}"><i class="bi bi-boxes"></i> Inventory</a></li>

        <li class="vp-label">Sales</li>
        <li><a href="{{ route('vendor.orders.orders.index') }}"><i class="bi bi-cart-check"></i> Orders</a></li>

        <li class="vp-label">Finance</li>
        <li><a href="{{ route('vendor.finance.earnings') }}"><i class="bi bi-cash-coin"></i> Earnings</a></li>
        <li><a href="{{ route('vendor.finance.withdrawals.index') }}"><i class="bi bi-bank"></i> Withdrawals</a></li>

        <li class="vp-label">Account</li>
        <li><a href="{{ route('vendor.profiles') }}"><i class="bi bi-person-circle"></i> Profile</a></li>
        <li><a href="{{ route('homes') }}" target="_blank"><i class="bi bi-shop"></i> View Website</a></li>
    </ul>
</aside>

<div class="vp-main">
    <div class="vp-top">
        <strong>@yield('title', 'Vendor Panel')</strong>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="vp-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>


