@extends('customer.account.layout')

@section('account')

    <div class="dsh-card">
        <div class="dsh-card-head"><h3>{{ $hasPassword ? 'Change Password' : 'Set a Password' }}</h3></div>

        <div class="dsh-body">
            @unless($hasPassword)
                <p class="dsh-hint">You are currently signing in with an email code. Set a password to also sign in with your email and password after logging out.</p>
            @endunless

            @if($hasPassword && ! $needsCurrent)
                <p class="dsh-hint">You signed in with an email code, so you can set a new password without entering the current one.</p>
            @endif

            <form method="POST" action="{{ route('account.password.update') }}" style="max-width:460px">
                @csrf
                @method('PUT')

                @if($needsCurrent)
                    <div class="dsh-f">
                        <label>Current Password</label>
                        <input type="password" name="current_password" autocomplete="current-password">
                        @error('current_password')<span class="dsh-err">{{ $message }}</span>@enderror
                    </div>
                @endif

                <div class="dsh-f">
                    <label>New Password</label>
                    <input type="password" name="password" autocomplete="new-password">
                    <small class="dsh-hint" style="display:block;margin:6px 0 0">At least 8 characters, with letters and numbers.</small>
                    @error('password')<span class="dsh-err">{{ $message }}</span>@enderror
                </div>

                <div class="dsh-f">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation" autocomplete="new-password">
                </div>

                <button type="submit" class="dsh-btn">{{ $hasPassword ? 'Update Password' : 'Set Password' }}</button>
            </form>
        </div>
    </div>

@endsection