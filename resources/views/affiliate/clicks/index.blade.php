@extends('layouts.affiliate.app')

@section('title', 'Clicks')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Performance</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('affiliate.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Clicks</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <h6 class="mb-0 text-uppercase">Click History</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Product</th>
                                <th>Link Code</th>
                                <th>Visitor IP</th>
                                <th>Referrer</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($clicks as $click)
                                <tr>
                                    <td>#{{ $click->id }}</td>
                                    <td>{{ $click->link->product->name ?? '—' }}</td>
                                    <td><code>{{ $click->link->code ?? '—' }}</code></td>
                                    {{-- Visitor er privacy: IP er sesh part hide --}}
                                    <td>{{ preg_replace('/\.\d+$/', '.xxx', $click->ip_address) }}</td>
                                    <td>{{ $click->referrer ? \Illuminate\Support\Str::limit($click->referrer, 40) : 'Direct' }}</td>
                                    <td>{{ $click->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No clicks yet.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $clicks->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
