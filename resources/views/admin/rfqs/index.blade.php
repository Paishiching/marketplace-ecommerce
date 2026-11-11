@extends('layouts.admin.app')
@section('title', 'Buyer inquiries')
@section('panel_content')
<div class="card"><div class="card-body"><div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"><div><h4 class="mb-1">Buyer inquiries</h4><p class="text-muted mb-0">Sourcing requests and product questions from customers.</p></div><span class="badge bg-primary">{{ $rfqs->total() }} total</span></div>
<div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Product / request</th><th>Customer</th><th>Quantity</th><th>Quotes</th><th>Received</th><th></th></tr></thead><tbody>
@forelse($rfqs as $rfq)<tr><td><strong>{{ $rfq->product_name }}</strong><div class="small text-muted text-truncate" style="max-width:280px">{{ $rfq->requirements }}</div></td><td>{{ $rfq->user->name }}<div class="small text-muted">{{ $rfq->user->email }}</div></td><td>{{ number_format($rfq->quantity) }} {{ $rfq->unit }}</td><td>{{ $rfq->quotes_count }}</td><td>{{ $rfq->created_at->format('d M Y, g:i A') }}</td><td><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.rfqs.show', $rfq) }}">View request</a></td></tr>
@empty<tr><td colspan="6" class="text-center py-5 text-muted">No buyer inquiries yet.</td></tr>@endforelse
</tbody></table></div>{{ $rfqs->links() }}</div></div>
@endsection
