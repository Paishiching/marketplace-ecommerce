@extends('layouts.' . $type . '.app')

@section('title', 'Business settings')

@section('panel_content')
<div class="row"><div class="col-12 col-xl-8">
    <div class="card"><div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
            <div><h4 class="mb-1">Business settings</h4><p class="text-secondary mb-0">Update your account's business name.</p></div>
            <span class="badge rounded-pill text-bg-{{ $profile->status === 'approved' ? 'success' : ($profile->status === 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($profile->status) }}</span>
        </div>
        @if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route($config['settings'] . '.update') }}">
            @csrf @method('PUT')
            <div class="mb-3"><label class="form-label" for="business_name">Business name</label><input class="form-control" id="business_name" name="business_name" value="{{ old('business_name', $profile->business_name) }}" maxlength="150" required></div>
            <div class="mb-3"><label class="form-label">Account email</label><input class="form-control" value="{{ auth()->user()->email }}" readonly></div>
            <button class="btn btn-primary" type="submit">Save changes</button>
        </form>
    </div></div>
</div></div>
@endsection
