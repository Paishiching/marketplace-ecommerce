@extends('auth.layout')

@section('title', 'Register')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="au-field">
            <label for="name" class="au-label">Name</label>
            <input id="name" class="au-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your full name">
        </div>

        <div class="au-field">
            <label for="email" class="au-label">Email</label>
            <input id="email" class="au-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com">
        </div>

        <div class="au-field">
            <label for="password" class="au-label">Password</label>
            <div class="au-input-wrap">
                <input id="password" class="au-input has-toggle" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                <button type="button" class="au-toggle" data-target="password" aria-label="Show password">
                    <svg class="eye-on" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg class="eye-off" style="display:none" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
        </div>

        <div class="au-field">
            <label for="password_confirmation" class="au-label">Confirm Password</label>
            <div class="au-input-wrap">
                <input id="password_confirmation" class="au-input has-toggle" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                <button type="button" class="au-toggle" data-target="password_confirmation" aria-label="Show password">
                    <svg class="eye-on" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg class="eye-off" style="display:none" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <label for="terms" class="au-check top">
                <input id="terms" type="checkbox" name="terms" required>
                <span>
                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="au-link">'.__('Terms of Service').'</a>',
                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="au-link">'.__('Privacy Policy').'</a>',
                    ]) !!}
                </span>
            </label>
        @endif

        <button type="submit" class="au-btn">Register</button>
    </form>

    <p class="au-alt">
        Already registered?
        <a href="{{ route('login') }}" class="au-link">Log in</a>
    </p>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.au-toggle[data-target]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.getAttribute('data-target'));
                var show  = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.querySelector('.eye-on').style.display  = show ? 'none' : '';
                btn.querySelector('.eye-off').style.display = show ? '' : 'none';
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        });
    </script>
@endpush