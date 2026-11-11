@extends('customer.account.layout')
@section('title', 'My sourcing requests')
@section('account')
<div class="dsh-card"><div class="dsh-card-head"><h3>My sourcing requests</h3><a class="dsh-view" href="{{ route('customer.rfqs.create') }}">New request</a></div>
    @forelse($rfqs as $rfq)
        <a class="rfq-row" href="{{ route('customer.rfqs.show', $rfq) }}"><span><strong>{{ $rfq->product_name }}</strong><small>{{ number_format($rfq->quantity) }} {{ $rfq->unit }} · {{ $rfq->created_at->format('d M Y') }}</small></span><span class="dsh-badge">{{ $rfq->quotes_count }} {{ \Illuminate\Support\Str::plural('quote', $rfq->quotes_count) }}</span></a>
    @empty <p class="rfq-empty">No requests yet. Post a sourcing request and collect supplier quotes.</p> @endforelse
    <div class="dsh-foot">{{ $rfqs->links() }}</div></div>
<style>.rfq-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:18px 22px;border-bottom:1px solid #edf0f5;color:#24324a;text-decoration:none;min-width:0}.rfq-row>span:first-child{min-width:0}.rfq-row strong,.rfq-row small{display:block;overflow-wrap:anywhere}.rfq-row small{color:#667085;margin-top:5px}.rfq-empty{padding:24px}.dsh-foot{padding:16px;overflow:auto}</style>
@endsection
