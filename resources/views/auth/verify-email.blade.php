@extends('auth.layout')

@section('title', 'Verify Email')

@section('content')
    <p class="au-text">Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="au-status">A new verification link has been sent to the email address you provided in your profile settings.</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="au-btn">Resend Verification Email</button>
    </form>

    <div class="au-actions">
        @if (Route::has('profile.show'))
            <a href="{{ route('profile.show') }}" class="au-link">Edit Profile</a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="au-link">Log Out</button>
        </form>
    </div>
@endsection