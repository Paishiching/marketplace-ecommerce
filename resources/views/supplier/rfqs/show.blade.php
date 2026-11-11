@extends('layouts.supplier.app')
@section('title', 'Quote on '.$rfq->product_name)
@section('content')
<div class="card mb-3"><div class="card-body"><h4>{{ $rfq->product_name }}</h4><p class="text-muted mb-2">Requested {{ number_format($rfq->quantity) }} {{ $rfq->unit }} · {{ $rfq->created_at->format('d M Y') }}</p><h6>Requirements</h6><p style="white-space:pre-wrap;overflow-wrap:anywhere">{{ $rfq->requirements }}</p>
@if($rfq->attachments)<div class="d-flex flex-wrap gap-2 mb-3">@foreach($rfq->attachments as $path)<a href="{{ asset('storage/'.$path) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/'.$path) }}" alt="Reference product" style="width:90px;height:90px;object-fit:cover;border-radius:8px"></a>@endforeach</div>@endif
@if($rfq->share_business_card)<div class="alert alert-info mb-0"><b>Buyer contact</b>: {{ $rfq->user->name }} · {{ $rfq->user->email }} @if($rfq->user->phone) · {{ $rfq->user->phone }} @endif</div>@endif
</div></div>
<div class="card"><div class="card-body"><h5>{{ $quote ? 'Update your quote' : 'Send a quote' }}</h5><form action="{{ route('supplier.rfqs.quote', $rfq) }}" method="POST" class="row g-3">@csrf
<div class="col-12 col-md-5"><label class="form-label">Unit price (BDT) *</label><input class="form-control" type="number" name="unit_price" step="0.01" min="0.01" required value="{{ old('unit_price', $quote?->unit_price) }}">@error('unit_price')<small class="text-danger">{{ $message }}</small>@enderror</div>
<div class="col-12 col-md-4"><label class="form-label">Lead time (days)</label><input class="form-control" type="number" name="lead_time_days" min="1" value="{{ old('lead_time_days', $quote?->lead_time_days) }}"></div>
<div class="col-12"><label class="form-label">Message</label><textarea class="form-control" name="message" rows="4" maxlength="2000">{{ old('message', $quote?->message) }}</textarea></div><div class="col-12"><button class="btn btn-primary" type="submit">Send quote to buyer</button></div>
</form></div></div>
@endsection
