@extends(auth()->user()->hasRole('superadmin') ? 'layouts.superadmin.panel' : 'layouts.admin.app')
@section('title', 'Delivery transport')
@section('panel_content')
@php($transportIndexRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.index' : 'admin.orders.shipments.index')
@php($transportStoreRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.store' : 'admin.orders.shipments.store')
<style>
    .transport-form{--tr-orange:#fd6801;--tr-navy:#2a3582}.transport-form .card{border:0;border-radius:14px;box-shadow:0 5px 24px rgba(42,53,130,.08)}
    .transport-form .form-label{font-weight:600;color:var(--tr-navy)}.transport-form .form-control,.transport-form .form-select{min-height:48px;border:1px solid #dfe3f0;border-radius:10px}
    .transport-form .btn-primary{background:var(--tr-orange);border-color:var(--tr-orange)}.transport-form .party-card{background:#f5f7ff;border:1px solid #e3e8fa;border-radius:12px;padding:16px}.transport-form .party-number{color:var(--tr-orange);font-weight:700}
</style>
<div class="transport-form">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"><div><h3 class="mb-1">Delivery Transport</h3><p class="text-muted mb-0">Record self transport details for an order.</p></div><a href="{{ route($transportIndexRoute) }}" class="btn btn-outline-secondary">Back to transport list</a></div>
    @if($errors->any())<div class="alert alert-danger"><strong>Please check the form:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if(!$orders->count())<div class="alert alert-info">Every current order already has a delivery transport entry. A new entry can be added when another order is ready.</div>@endif
    <form method="POST" action="{{ route($transportStoreRoute) }}">
        @csrf
        <div class="card mb-3"><div class="card-body p-4">
            <h5 class="mb-3" style="color:#2a3582;font-weight:700">Customer and order</h5>
            <label class="form-label" for="orderSelect">Select order <span class="text-danger">*</span></label>
            <select class="form-select" name="order_id" id="orderSelect" required @disabled(!$orders->count())><option value="">Choose an order</option>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}" data-party="{{ $order->customer_id ? '#'.$order->customer_id : '—' }}" data-name="{{ $order->name ?: $order->customer?->user?->name }}" data-phone="{{ $order->phone }}" @selected(old('order_id') == $order->id)>
                        {{ $order->order_number }} · {{ $order->name ?: $order->customer?->user?->name ?: 'Customer' }} · {{ $order->phone }}
                    </option>
                @endforeach
            </select>
            <div class="party-card mt-3" id="partyCard" hidden><div class="row g-3"><div class="col-sm-3"><div class="small text-muted">Party number</div><strong class="party-number" id="partyNumber">—</strong></div><div class="col-sm-5"><div class="small text-muted">Name</div><strong id="partyName">—</strong></div><div class="col-sm-4"><div class="small text-muted">Mobile</div><span id="partyPhone">—</span></div></div></div>
        </div></div>
        <div class="card mb-3"><div class="card-body p-4">
            <h5 class="mb-1" style="color:#2a3582;font-weight:700">Self Transport Info</h5><p class="text-muted mb-4">Enter the driver and vehicle responsible for delivery.</p>
            <div class="row g-3"><div class="col-md-6"><label class="form-label" for="driverName">Driver name <span class="text-danger">*</span></label><input class="form-control" id="driverName" name="driver_name" value="{{ old('driver_name') }}" placeholder="Enter driver name" maxlength="150" required></div>
                <div class="col-md-6"><label class="form-label" for="driverPhone">Mobile number <span class="text-danger">*</span></label><input class="form-control" id="driverPhone" name="driver_phone" value="{{ old('driver_phone') }}" placeholder="Enter driver mobile number" maxlength="30" inputmode="tel" required></div>
                <div class="col-md-6"><label class="form-label" for="vehicleNumber">Vehicle number <span class="text-danger">*</span></label><input class="form-control" id="vehicleNumber" name="vehicle_number" value="{{ old('vehicle_number') }}" placeholder="Enter vehicle number" maxlength="50" required></div>
                <div class="col-md-6"><label class="form-label" for="vehicleOwner">Vehicle owner / agency <span class="text-danger">*</span></label><input class="form-control" id="vehicleOwner" name="vehicle_owner" value="{{ old('vehicle_owner') }}" placeholder="Enter owner or agency name" maxlength="150" required></div>
                <div class="col-md-6"><label class="form-label" for="expectedArrival">Expected arrival date <span class="text-danger">*</span></label><input class="form-control" type="date" id="expectedArrival" name="expected_arrival_at" value="{{ old('expected_arrival_at') }}" min="{{ now()->toDateString() }}" required></div>
            </div>
        </div></div>
        <div class="d-flex justify-content-end gap-2"><a href="{{ route($transportIndexRoute) }}" class="btn btn-outline-secondary px-4">Cancel</a><button class="btn btn-primary px-4" type="submit" @disabled(!$orders->count())>Submit transport details</button></div>
    </form>
</div>
<script>
(() => {const select=document.getElementById('orderSelect');if(!select)return;const update=()=>{const option=select.selectedOptions[0],card=document.getElementById('partyCard');if(!option?.value){card.hidden=true;return;}card.hidden=false;document.getElementById('partyNumber').textContent=option.dataset.party||'—';document.getElementById('partyName').textContent=option.dataset.name||'Customer';document.getElementById('partyPhone').textContent=option.dataset.phone||'—';};select.addEventListener('change',update);if(select.value)update();})();
</script>
@endsection
