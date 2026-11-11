@extends('layouts.frontend.app')

@section('title', 'Vendor Login')

@section('content')
<section class="py-5" style="background:#f5f7fb;min-height:65vh">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold mb-2">Vendor sign in</h1>
                        <p class="text-muted mb-0">Sign in to manage your shop and orders.</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="status">{{ session('status') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('vendor.login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control form-control-lg" autocomplete="username" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input id="password" name="password" type="password" class="form-control form-control-lg" autocomplete="current-password" required>
                        </div>
                        <div class="form-check mb-4">
                            <input id="remember" name="remember" type="checkbox" value="1" class="form-check-input">
                            <label for="remember" class="form-check-label">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">Sign in</button>
                    </form>

                    <p class="text-center text-muted mt-4 mb-0">
                        New to the marketplace? <a href="{{ route('vendor.register') }}">Apply as a vendor</a>
                    </p>
                    <p class="small text-center text-muted mt-3 mb-0">Vendor access is available after Super Admin approval.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
