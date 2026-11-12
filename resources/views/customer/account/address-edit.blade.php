@extends('customer.account.layout')

@section('account')
<div class="dsh-card">
    <div class="dsh-card-head"><h3>Edit saved address</h3><a href="{{ route('account.addresses') }}">Back to addresses</a></div>
    <div class="dsh-body">
        @if($errors->any())<div class="alert alert-danger"><strong>Please check the address:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('account.addresses.update', $address) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="recipientName">Recipient name</label><input class="form-control" id="recipientName" name="recipient_name" value="{{ old('recipient_name', $address->recipient_name) }}" maxlength="120" required></div>
                <div class="col-md-6"><label class="form-label" for="phone">Phone</label><input class="form-control" id="phone" name="phone" value="{{ old('phone', $address->phone) }}" maxlength="20" inputmode="tel" required></div>
                <div class="col-12"><label class="form-label" for="addressLine1">Address line 1</label><input class="form-control" id="addressLine1" name="address_line1" value="{{ old('address_line1', $address->address_line1) }}" maxlength="255" required></div>
                <div class="col-12"><label class="form-label" for="addressLine2">Address line 2 <span class="text-muted">(optional)</span></label><input class="form-control" id="addressLine2" name="address_line2" value="{{ old('address_line2', $address->address_line2) }}" maxlength="255"></div>
                <div class="col-md-6"><label class="form-label" for="city">City / District</label><input class="form-control" id="city" name="city" value="{{ old('city', $address->city) }}" maxlength="100" required></div>
                <div class="col-md-6"><label class="form-label" for="state">Area / Division <span class="text-muted">(optional)</span></label><input class="form-control" id="state" name="state" value="{{ old('state', $address->state) }}" maxlength="100"></div>
                <div class="col-md-6"><label class="form-label" for="postalCode">Postal code <span class="text-muted">(optional)</span></label><input class="form-control" id="postalCode" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}" maxlength="20"></div>
                <div class="col-md-6"><label class="form-label" for="country">Country</label><input class="form-control" id="country" name="country" value="{{ old('country', $address->country ?: 'Bangladesh') }}" maxlength="100"></div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4"><a href="{{ route('account.addresses') }}" class="btn btn-outline-secondary">Cancel</a><button type="submit" class="btn btn-primary">Save address</button></div>
        </form>
    </div>
</div>
@endsection
