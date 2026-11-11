@extends('layouts.admin.app')
@section('title', 'Admin Dashboard')
@section('panel_content')
<style>
    .admin-dashboard{--ad-navy:#2a3582;--ad-orange:#fd6801}.admin-dashboard .welcome-card{overflow:hidden;position:relative;border:0;border-radius:17px;background:linear-gradient(120deg,#2a3582,#4054b5);color:#fff;box-shadow:0 12px 32px rgba(42,53,130,.16)}.admin-dashboard .welcome-card p{color:rgba(255,255,255,.82)}.admin-dashboard .welcome-card .welcome-mark{position:absolute;right:28px;top:50%;transform:translateY(-50%);width:112px;height:112px;border:1px solid rgba(255,255,255,.28);border-radius:50%;display:grid;place-items:center;font-size:46px;color:rgba(255,255,255,.8)}.admin-dashboard .stat-card,.admin-dashboard .action-card{height:100%;border:1px solid #e9ebf2;border-radius:15px;box-shadow:0 8px 28px rgba(35,47,103,.05)}.admin-dashboard .stat-icon{width:42px;height:42px;border-radius:12px;display:grid;place-items:center;color:var(--ad-orange);background:#fff1e8;font-size:21px}.admin-dashboard .stat-value{font-size:25px;font-weight:800;color:var(--ad-navy)}.admin-dashboard .action-card{transition:transform .18s,box-shadow .18s}.admin-dashboard .action-card:hover{transform:translateY(-2px);box-shadow:0 12px 30px rgba(35,47,103,.1)}.admin-dashboard .action-icon{font-size:25px;color:var(--ad-orange)}.admin-dashboard .action-link{color:var(--ad-navy);font-weight:700;text-decoration:none}.admin-dashboard .empty-state{border:1px dashed #ccd1e5;border-radius:14px;padding:28px;background:#fff}
    @media(max-width:575px){.admin-dashboard .welcome-card .welcome-mark{right:16px;width:72px;height:72px;font-size:30px;opacity:.6}.admin-dashboard .welcome-card .card-body{position:relative;z-index:1;padding-right:85px!important}}
</style>
<div class="admin-dashboard">
    <div class="card welcome-card mb-4"><div class="card-body p-4 p-lg-5"><div class="small text-uppercase mb-2" style="letter-spacing:.12em;color:#ffd5bd">Admin workspace</div><h2 class="fw-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2><p class="mb-0">Manage the catalog and the areas your superadmin has assigned to you.</p><div class="welcome-mark"><i class="bx bx-store-alt"></i></div></div></div>

    @php($visibleStats = collect($stats)->filter(fn($value) => $value !== null))
    @if($visibleStats->isNotEmpty())
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3 mb-4">
        @if($stats['products'] !== null)<div class="col"><div class="card stat-card"><div class="card-body d-flex align-items-center justify-content-between"><div><div class="text-muted mb-1">Products</div><div class="stat-value">{{ number_format($stats['products']) }}</div></div><div class="stat-icon"><i class="bx bx-package"></i></div></div></div></div>@endif
        @if($stats['categories'] !== null)<div class="col"><div class="card stat-card"><div class="card-body d-flex align-items-center justify-content-between"><div><div class="text-muted mb-1">Categories</div><div class="stat-value">{{ number_format($stats['categories']) }}</div></div><div class="stat-icon"><i class="bx bx-category"></i></div></div></div></div>@endif
        @if($stats['orders'] !== null)<div class="col"><div class="card stat-card"><div class="card-body d-flex align-items-center justify-content-between"><div><div class="text-muted mb-1">Orders</div><div class="stat-value">{{ number_format($stats['orders']) }}</div></div><div class="stat-icon"><i class="bx bx-receipt"></i></div></div></div></div>@endif
    </div>
    @endif

    @if(count($actions))
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3"><div><h4 class="mb-1" style="color:#2a3582;font-weight:750">Quick actions</h4><p class="text-muted mb-0">Start with one of the tasks available to your account.</p></div></div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
            @foreach($actions as $action)<div class="col"><a href="{{ route($action['route']) }}" class="text-reset text-decoration-none"><div class="card action-card"><div class="card-body p-4"><div class="d-flex justify-content-between align-items-start mb-3"><div class="stat-icon"><i class="bx {{ $action['icon'] }}"></i></div><i class="bx bx-right-arrow-alt action-link" style="font-size:22px"></i></div><h5 class="action-link mb-1">{{ $action['label'] }}</h5><p class="text-muted mb-0">{{ $action['description'] }}</p></div></div></a></div>@endforeach
        </div>
    @else
        <div class="empty-state text-center"><div class="stat-icon mx-auto mb-3"><i class="bx bx-lock-alt"></i></div><h5 style="color:#2a3582;font-weight:750">No sections assigned yet</h5><p class="text-muted mb-0">Ask your superadmin to grant the sections you need. They will appear here and in your menu.</p></div>
    @endif
</div>
@endsection
