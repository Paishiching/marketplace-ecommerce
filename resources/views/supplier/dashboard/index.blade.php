@extends('layouts.supplier.app')

@section('title', 'Supplier Dashboard')

@section('panel_content')
    <div class="card mb-3"><div class="card-body p-4"><h4 class="fw-bold mb-1">Welcome, {{ $user->name }}!</h4><p class="text-muted mb-0">Manage supplier products and review incoming orders from your dashboard.</p></div></div>
    <div class="row row-cols-1 row-cols-md-3 g-3">
        @foreach ($stats as $stat)
            <div class="col"><div class="card radius-10"><div class="card-body"><p class="mb-1 text-secondary">{{ $stat['label'] }}</p><h4 class="mb-0">{{ number_format((int) $stat['value']) }}</h4></div></div></div>
        @endforeach
    </div>
@endsection
