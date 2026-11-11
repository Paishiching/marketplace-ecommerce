@extends('auth.layout')

@section('title', 'Confirm Password')

@section('content')
    <p class="au-text">This is a secure area of the application. Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="au-field">
            <label for="password" class="au-label">Password</label>
            <input id="password" class="au-input" type="password" name="password" required autocomplete="current-password" autofocus placeholder="••••••••">
        </div>

        <button type="submit" class="au-btn">Confirm</button>
    </form>
@endsection