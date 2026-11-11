@extends('auth.layout')

@section('title', 'Reset Password')

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="au-field">
            <label for="email" class="au-label">Email</label>
            <input id="email" class="au-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="you@example.com">
        </div>

        <div class="au-field">
            <label for="password" class="au-label">Password</label>
            <input id="password" class="au-input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
        </div>

        <div class="au-field">
            <label for="password_confirmation" class="au-label">Confirm Password</label>
            <input id="password_confirmation" class="au-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
        </div>

        <button type="submit" class="au-btn">Reset Password</button>
    </form>
@endsection