@extends('customer.account.layout')
@section('title', $rfq->product_name)
@section('account')
<div class="dsh-card"><div class="dsh-card-head"><h3>{{ $rfq->product_name }}</h3><a href="{{ route('customer.rfqs.index') }}">All requests</a></div>
    <div class="rfq-content"><p><b>Quantity:</b> {{ number_format($rfq->quantity) }} {{ $rfq->unit }}</p><h4>Requirements</h4><p class="rfq-text">{{ $rfq->requirements }}</p>
        @if($rfq->attachments)<h4>Photos</h4><div class="rfq-images">@foreach($rfq->attachments as $path)<a href="{{ asset('storage/'.$path) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/'.$path) }}" alt="Product reference photo"></a>@endforeach</div>@endif
        <h4>Supplier quotes ({{ $rfq->quotes->count() }})</h4>
        @forelse($rfq->quotes as $quote)<article class="rfq-quote"><b>{{ $quote->supplier->company_name }}</b><strong>BDT {{ number_format($quote->unit_price, 2) }} / {{ $rfq->unit }}</strong>@if($quote->lead_time_days)<span>{{ $quote->lead_time_days }} days lead time</span>@endif @if($quote->message)<p>{{ $quote->message }}</p>@endif</article>
        @empty<p>Suppliers have not responded yet. New quotes will appear here.</p>@endforelse
    </div>
</div>
<style>.rfq-content{padding:22px;overflow-wrap:anywhere}.rfq-content h4{margin:22px 0 8px}.rfq-text{white-space:pre-wrap}.rfq-images{display:flex;gap:10px;flex-wrap:wrap}.rfq-images img{width:96px;height:96px;object-fit:cover;border-radius:8px}.rfq-quote{display:grid;gap:6px;padding:16px;margin:12px 0;border:1px solid #e8edf5;border-radius:12px}.rfq-quote strong{color:#de5c0a}</style>
@endsection
