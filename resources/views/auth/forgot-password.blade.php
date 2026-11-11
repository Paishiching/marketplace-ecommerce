@extends('auth.layout')

@section('title', 'Forgot Password')

@section('content')
    <p class="au-text">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="au-field">
            <label for="email" class="au-label">Email</label>
            <input id="email" class="au-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
        </div>

        <button type="submit" class="au-btn">Email Password Reset Link</button>
    </form>

    <p class="au-alt">
        <a href="{{ route('login') }}" class="au-link">← Back to login</a>
    </p>
@endsection