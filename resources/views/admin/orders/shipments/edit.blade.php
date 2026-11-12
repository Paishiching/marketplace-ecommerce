@extends(auth()->user()->hasRole('superadmin') ? 'layouts.superadmin.panel' : 'layouts.admin.app')
@section('title', 'Edit delivery transport')
@section('panel_content')
@php($transportIndexRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.index' : 'admin.orders.shipments.index')
@php($transportUpdateRoute = auth()->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.update' : 'admin.orders.shipments.update')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div><h3 class="mb-1">Edit delivery transport</h3><p class="text-muted mb-0">Order: {{ $shipment->order?->order_number ?? '#'.$shipment->order_id }}</p></div>
    <a href="{{ route($transportIndexRoute) }}" class="btn btn-outline-secondary">Back to transport list</a>
</div>
@if($errors->any())<div class="alert alert-danger"><strong>Please check the form:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route($transportUpdateRoute, $shipment) }}" class="card">
    @csrf @method('PUT')
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="driverName">Driver name</label><input class="form-control" id="driverName" name="driver_name" value="{{ old('driver_name', $shipment->driver_name) }}" maxlength="150" required></div>
            <div class="col-md-6"><label class="form-label" for="driverPhone">Mobile number</label><input class="form-control" id="driverPhone" name="driver_phone" value="{{ old('driver_phone', $shipment->driver_phone) }}" maxlength="30" required></div>
            <div class="col-md-6"><label class="form-label" for="vehicleNumber">Vehicle number</label><input class="form-control" id="vehicleNumber" name="vehicle_number" value="{{ old('vehicle_number', $shipment->vehicle_number) }}" maxlength="50" required></div>
            <div class="col-md-6"><label class="form-label" for="vehicleOwner">Vehicle owner / agency</label><input class="form-control" id="vehicleOwner" name="vehicle_owner" value="{{ old('vehicle_owner', $shipment->vehicle_owner) }}" maxlength="150" required></div>
            <div class="col-md-6"><label class="form-label" for="expectedArrival">Expected arrival date</label><input class="form-control" type="date" id="expectedArrival" name="expected_arrival_at" value="{{ old('expected_arrival_at', $shipment->expected_arrival_at?->format('Y-m-d')) }}" required></div>
            <div class="col-md-6"><label class="form-label" for="deliveryDate">Delivery date</label><input class="form-control" type="date" id="deliveryDate" name="delivery_date" value="{{ old('delivery_date', $shipment->delivery_date?->format('Y-m-d')) }}"></div>
            <div class="col-md-6"><label class="form-label" for="deliveryEstimate">Estimated delivery time</label><input class="form-control" id="deliveryEstimate" name="delivery_estimate" value="{{ old('delivery_estimate', $shipment->delivery_estimate) }}" maxlength="120" placeholder="e.g. Within 2 days"></div>
            <div class="col-md-6"><label class="form-label" for="status">Delivery status</label><select class="form-select" id="status" name="status" required><option value="pending" @selected(old('status', $shipment->status) === 'pending')>Pending</option><option value="processing" @selected(old('status', $shipment->status) === 'processing')>Processing</option><option value="out_for_delivery" @selected(old('status', $shipment->status) === 'out_for_delivery')>Out for delivery</option><option value="completed" @selected(old('status', $shipment->status) === 'completed')>Complete</option><option value="cancelled" @selected(old('status', $shipment->status) === 'cancelled')>Cancel</option></select></div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end gap-2"><a href="{{ route($transportIndexRoute) }}" class="btn btn-outline-secondary">Cancel</a><button type="submit" class="btn btn-primary">Save changes</button></div>
</form>
@endsection
