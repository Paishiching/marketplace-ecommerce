@extends('layouts.frontend.app')

@section('title', $label . ' account status')

@section('content')
<section class="py-5" style="background:#f5f7fb;min-height:65vh"><div class="container"><div class="row justify-content-center"><div class="col-12 col-md-8 col-lg-6">
    <div class="card border-0 shadow-sm rounded-4"><div class="card-body p-4 p-md-5 text-center">
        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width:64px;height:64px;background:#fff3e8;color:#fd6801"><i class="bx bx-info-circle fs-2"></i></div>
        @if ($status === 'wrong_role')
            <h1 class="h3 fw-bold">Use your {{ strtolower($label) }} account</h1>
            <p class="text-secondary">You are signed in with an account that does not have the {{ strtolower($label) }} role. Sign in with the correct account to continue.</p>
            <a class="btn btn-primary" href="{{ route($loginRoute) }}">Go to {{ $label }} sign in</a>
        @elseif ($status === 'missing')
            <h1 class="h3 fw-bold">Complete your {{ strtolower($label) }} application</h1>
            <p class="text-secondary">Your account does not have a {{ strtolower($label) }} profile yet. Submit an application, then sign in to the dashboard after Super Admin approval.</p>
            <a class="btn btn-primary" href="{{ route($applyRoute) }}">Apply as {{ $label }}</a>
        @elseif ($status === 'pending')
            <h1 class="h3 fw-bold">Application awaiting approval</h1>
            <p class="text-secondary">Your {{ strtolower($label) }} application is being reviewed. The dashboard will open after Super Admin approves it.</p>
        @elseif ($status === 'rejected')
            <h1 class="h3 fw-bold">Application not approved</h1>
            <p class="text-secondary">Your {{ strtolower($label) }} application was rejected. Contact support if you need help.</p>
        @else
            <h1 class="h3 fw-bold">Account temporarily unavailable</h1>
            <p class="text-secondary">Your {{ strtolower($label) }} account is suspended. Contact Super Admin for assistance.</p>
        @endif
        <a href="{{ route('homes') }}" class="btn btn-outline-secondary mt-2">Back to store</a>
        @if ($status !== 'wrong_role')<form method="POST" action="{{ route($logoutRoute) }}" class="mt-2">@csrf<button class="btn btn-link">Sign out</button></form>@endif
    </div></div>
</div></div></section>
@endsection
