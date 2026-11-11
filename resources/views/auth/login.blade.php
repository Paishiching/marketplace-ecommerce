@extends('auth.layout')

@section('title', 'Login')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="au-field">
            <label for="email" class="au-label">Email</label>
            <div class="au-input-wrap">
                <svg class="au-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <input id="email" class="au-input has-icon" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
            </div>
        </div>

        <div class="au-field">
            <label for="password" class="au-label">Password</label>
            <div class="au-input-wrap">
                <svg class="au-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4"/></svg>
                <input id="password" class="au-input has-icon has-toggle" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                <button type="button" class="au-toggle" id="togglePass" aria-label="Show password">
                    <svg class="eye-on" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg class="eye-off" style="display:none" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
        </div>

        <div class="au-row">
            <label for="remember_me" class="au-check">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="au-link">Forgot your password?</a>
            @endif
        </div>

        <button type="submit" class="au-btn">Log in</button>
    </form>

    @if (Route::has('register'))
        <p class="au-alt">
            Don't have an account?
            <a href="{{ route('register') }}" class="au-link">Register</a>
        </p>
    @endif
@endsection

@push('scripts')
    <script>
        (function () {
            var btn   = document.getElementById('togglePass');
            var input = document.getElementById('password');

            btn.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.querySelector('.eye-on').style.display  = show ? 'none' : '';
                btn.querySelector('.eye-off').style.display = show ? '' : 'none';
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        })();
    </script>
@endpush