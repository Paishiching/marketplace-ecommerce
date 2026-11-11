@extends('layouts.dropshipping.app')

@section('title', 'Dropshipping dashboard')

@section('panel_content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div><h3 class="mb-1">Welcome, {{ auth()->user()->name }}</h3><p class="text-secondary mb-0">Your dropshipping business overview.</p></div>
    <span class="badge rounded-pill text-bg-success px-3 py-2">Account approved</span>
</div>
<div class="row g-3 mb-4">
    @foreach ($stats as $stat)
        <div class="col-12 col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body d-flex justify-content-between align-items-start"><div><div class="text-secondary mb-2">{{ $stat['label'] }}</div><h4 class="mb-0">{{ $stat['value'] }}</h4></div><i class="bx {{ $stat['icon'] }} fs-3 text-primary"></i></div></div></div>
    @endforeach
</div>
<div class="card"><div class="card-body p-4"><h5 class="mb-2">Your dropshipping workspace</h5><p class="text-secondary mb-0">Add products from approved suppliers and track orders assigned to your account.</p></div></div>
@endsection
