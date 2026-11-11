@extends('layouts.supplier.app')
@section('title', 'Buyer sourcing requests')
@section('content')
<div class="card"><div class="card-body"><h4 class="mb-3">Buyer sourcing requests</h4><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Product</th><th>Quantity</th><th>Posted</th><th>Quotes</th><th></th></tr></thead><tbody>
@forelse($rfqs as $rfq)<tr><td>{{ $rfq->product_name }}</td><td>{{ number_format($rfq->quantity) }} {{ $rfq->unit }}</td><td>{{ $rfq->created_at->format('d M Y') }}</td><td>{{ $rfq->quotes_count }}</td><td><a class="btn btn-sm btn-outline-primary" href="{{ route('supplier.rfqs.show', $rfq) }}">View / quote</a></td></tr>
@empty<tr><td colspan="5" class="text-center py-4">No open requests right now.</td></tr>@endforelse
</tbody></table></div>{{ $rfqs->links() }}</div></div>
<style>@media(max-width:767px){.card-body{padding:16px}.table{min-width:560px}}</style>
@endsection
