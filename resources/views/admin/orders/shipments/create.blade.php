@extends(auth()->user()->hasRole('superadmin') ? 'layouts.superadmin.panel' : 'layouts.admin.app')
@section('title', 'Delivery transport')
@section('panel_content')
@php($transportIndexRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.index' : 'admin.orders.shipments.index')
@php($transportStoreRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.store' : 'admin.orders.shipments.store')
@php($transportSearchRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.search' : 'admin.orders.shipments.search')
<style>
    .transport-form{--tr-orange:#fd6801;--tr-navy:#2a3582}.transport-form .card{border:0;border-radius:14px;box-shadow:0 5px 24px rgba(42,53,130,.08)}
    .transport-form .form-label{font-weight:600;color:var(--tr-navy)}.transport-form .form-control,.transport-form .form-select{min-height:48px;border:1px solid #dfe3f0;border-radius:10px}
    .transport-form .btn-primary{background:var(--tr-orange);border-color:var(--tr-orange)}.transport-form .party-card{background:#f5f7ff;border:1px solid #e3e8fa;border-radius:12px;padding:16px}.transport-form .party-number{color:var(--tr-orange);font-weight:700}
</style>
<div class="transport-form">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"><div><h3 class="mb-1">Delivery Transport</h3><p class="text-muted mb-0">Record self transport details for an order.</p></div><a href="{{ route($transportIndexRoute) }}" class="btn btn-outline-secondary">Back to transport list</a></div>
    @if($errors->any())<div class="alert alert-danger"><strong>Please check the form:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route($transportStoreRoute) }}">
        @csrf
        <div class="card mb-3"><div class="card-body p-4">
            <h5 class="mb-3" style="color:#2a3582;font-weight:700">Customer and order</h5>
            <label class="form-label" for="orderSearch">Select order <span class="text-danger">*</span></label>
            <div class="position-relative">
                <input class="form-control" id="orderSearch" autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false" placeholder="Search order ID, order number, or customer name">
                <input type="hidden" name="order_id" id="orderId" value="{{ old('order_id') }}">
                <div id="orderResults" class="dropdown-menu w-100" role="listbox" style="max-height:260px;overflow:auto"></div>
            </div>
            <div id="selectedOrder" class="small text-success mt-2" aria-live="polite"></div>
            <div class="party-card mt-3" id="partyCard" hidden><div class="row g-3"><div class="col-sm-3"><div class="small text-muted">Party number</div><strong class="party-number" id="partyNumber">—</strong></div><div class="col-sm-5"><div class="small text-muted">Name</div><strong id="partyName">—</strong></div><div class="col-sm-4"><div class="small text-muted">Mobile</div><span id="partyPhone">—</span></div></div></div>
        </div></div>
        <div class="card mb-3"><div class="card-body p-4">
            <h5 class="mb-1" style="color:#2a3582;font-weight:700">Self Transport Info</h5><p class="text-muted mb-4">Enter the driver and vehicle responsible for delivery.</p>
            <div class="row g-3"><div class="col-md-6"><label class="form-label" for="driverName">Driver name <span class="text-danger">*</span></label><input class="form-control" id="driverName" name="driver_name" value="{{ old('driver_name') }}" placeholder="Enter driver name" maxlength="150" required></div>
                <div class="col-md-6"><label class="form-label" for="driverPhone">Mobile number <span class="text-danger">*</span></label><input class="form-control" id="driverPhone" name="driver_phone" value="{{ old('driver_phone') }}" placeholder="Enter driver mobile number" maxlength="30" inputmode="tel" required></div>
                <div class="col-md-6"><label class="form-label" for="vehicleNumber">Vehicle number <span class="text-danger">*</span></label><input class="form-control" id="vehicleNumber" name="vehicle_number" value="{{ old('vehicle_number') }}" placeholder="Enter vehicle number" maxlength="50" required></div>
                <div class="col-md-6"><label class="form-label" for="vehicleOwner">Vehicle owner / agency <span class="text-danger">*</span></label><input class="form-control" id="vehicleOwner" name="vehicle_owner" value="{{ old('vehicle_owner') }}" placeholder="Enter owner or agency name" maxlength="150" required></div>
                <div class="col-md-6"><label class="form-label" for="expectedArrival">Expected arrival date <span class="text-danger">*</span></label><input class="form-control" type="date" id="expectedArrival" name="expected_arrival_at" value="{{ old('expected_arrival_at') }}" min="{{ now()->toDateString() }}" required></div>
                <div class="col-md-6"><label class="form-label" for="deliveryDate">Delivery date</label><input class="form-control" type="date" id="deliveryDate" name="delivery_date" value="{{ old('delivery_date') }}" min="{{ now()->toDateString() }}"></div>
                <div class="col-md-6"><label class="form-label" for="deliveryEstimate">Estimated delivery time</label><input class="form-control" id="deliveryEstimate" name="delivery_estimate" value="{{ old('delivery_estimate') }}" maxlength="120" placeholder="e.g. Within 2 days"></div>
            </div>
        </div></div>
        <div class="d-flex justify-content-end gap-2"><a href="{{ route($transportIndexRoute) }}" class="btn btn-outline-secondary px-4">Cancel</a><button class="btn btn-primary px-4" type="submit">Submit transport details</button></div>
    </form>
</div>
<script>
(() => {const input=document.getElementById('orderSearch'),id=document.getElementById('orderId'),results=document.getElementById('orderResults'),card=document.getElementById('partyCard');let timer;const close=()=>{results.classList.remove('show');input.setAttribute('aria-expanded','false');};const show=()=>{results.classList.add('show');input.setAttribute('aria-expanded','true');};const choose=o=>{id.value=o.id;input.value=`${o.order_number} · ${o.name} · ${o.phone}`;document.getElementById('selectedOrder').textContent='Selected';document.getElementById('partyNumber').textContent=o.party;document.getElementById('partyName').textContent=o.name;document.getElementById('partyPhone').textContent=o.phone;card.hidden=false;results.innerHTML='';close();};input.addEventListener('input',()=>{id.value='';document.getElementById('selectedOrder').textContent='';card.hidden=true;clearTimeout(timer);const q=input.value.trim();results.innerHTML='';close();if(q.length<2&&!/^\d+$/.test(q))return;timer=setTimeout(async()=>{results.innerHTML='<span class="dropdown-item-text">Searching…</span>';show();try{const res=await fetch(`{{ route($transportSearchRoute) }}?q=${encodeURIComponent(q)}`,{headers:{Accept:'application/json'}});const rows=await res.json();results.innerHTML='';if(!rows.length){results.innerHTML='<span class="dropdown-item-text text-muted">No eligible orders found.</span>';return;}rows.forEach(o=>{const b=document.createElement('button');b.type='button';b.className='dropdown-item text-wrap';b.textContent=`${o.order_number} · ${o.name} · ${o.phone}`;b.addEventListener('click',()=>choose(o));results.appendChild(b);});}catch(e){results.innerHTML='<span class="dropdown-item-text text-danger">Could not search orders. Try again.</span>'; }},250);});input.addEventListener('keydown',e=>{if(e.key==='Escape')close();});document.addEventListener('click',e=>{if(!results.contains(e.target)&&e.target!==input)close();});if(id.value){fetch(`{{ route($transportSearchRoute) }}?q=${encodeURIComponent(id.value)}`,{headers:{Accept:'application/json'}}).then(r=>r.json()).then(rows=>{const o=rows.find(x=>String(x.id)===id.value);if(o)choose(o);}).catch(()=>{});}})();
</script>
@endsection
