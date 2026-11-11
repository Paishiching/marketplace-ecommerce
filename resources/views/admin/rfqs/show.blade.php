@extends('layouts.admin.app')
@section('title', 'Buyer request details')
@section('panel_content')
<div class="card mb-3"><div class="card-body"><div class="d-flex flex-wrap justify-content-between gap-2"><div><h4>{{ $rfq->product_name }}</h4><p class="text-muted">{{ number_format($rfq->quantity) }} {{ $rfq->unit }} · Received {{ $rfq->created_at->format('d M Y, g:i A') }}</p></div><a class="btn btn-outline-secondary align-self-start" href="{{ route('admin.rfqs.index') }}">Back to inquiries</a></div>
<h6>Customer question / requirements</h6><p class="border rounded p-3" style="white-space:pre-wrap;overflow-wrap:anywhere">{{ $rfq->requirements }}</p>
<h6>Customer</h6><p>{{ $rfq->user->name }} · {{ $rfq->user->email }} @if($rfq->share_business_card && $rfq->user->phone) · {{ $rfq->user->phone }} @endif @unless($rfq->share_business_card)<span class="text-muted">(contact details not shared with suppliers)</span>@endunless</p>
@if($rfq->attachments)<h6>Reference images</h6><div class="d-flex gap-2 flex-wrap">@foreach($rfq->attachments as $path)<a href="{{ asset('storage/'.$path) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/'.$path) }}" alt="Product reference" style="width:100px;height:100px;object-fit:cover;border-radius:8px"></a>@endforeach</div>@endif
</div></div>
<div class="card"><div class="card-body"><h5>Supplier responses</h5><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Supplier</th><th>Unit price</th><th>Lead time</th><th>Message</th></tr></thead><tbody>@forelse($rfq->quotes as $quote)<tr><td>{{ $quote->supplier->company_name }}</td><td>BDT {{ number_format($quote->unit_price, 2) }}</td><td>{{ $quote->lead_time_days ? $quote->lead_time_days.' days' : '—' }}</td><td>{{ $quote->message ?: '—' }}</td></tr>@empty<tr><td colspan="4" class="text-muted">No supplier responses yet.</td></tr>@endforelse</tbody></table></div></div></div>
@endsection
