@extends('auth.layout')

@section('title', 'Two-Factor Authentication')

@section('content')
    <p class="au-text" id="tfCodeText">Please confirm access to your account by entering the authentication code provided by your authenticator application.</p>
    <p class="au-text au-hide" id="tfRecoveryText">Please confirm access to your account by entering one of your emergency recovery codes.</p>

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div class="au-field" id="tfCodeBox">
            <label for="code" class="au-label">Code</label>
            <input id="code" class="au-input" type="text" inputmode="numeric" name="code" autofocus autocomplete="one-time-code" placeholder="123456">
        </div>

        <div class="au-field au-hide" id="tfRecoveryBox">
            <label for="recovery_code" class="au-label">Recovery Code</label>
            <input id="recovery_code" class="au-input" type="text" name="recovery_code" autocomplete="one-time-code">
        </div>

        <div class="au-row">
            <button type="button" class="au-link" id="tfToggle">Use a recovery code</button>
        </div>

        <button type="submit" class="au-btn">Log in</button>
    </form>
@endsection

@push('scripts')
    <script>
        (function () {
            var recovery = false;
            var toggle   = document.getElementById('tfToggle');
            var codeBox  = document.getElementById('tfCodeBox');
            var recBox   = document.getElementById('tfRecoveryBox');
            var codeTxt  = document.getElementById('tfCodeText');
            var recTxt   = document.getElementById('tfRecoveryText');
            var codeIn   = document.getElementById('code');
            var recIn    = document.getElementById('recovery_code');

            toggle.addEventListener('click', function () {
                recovery = !recovery;
                codeBox.classList.toggle('au-hide', recovery);
                codeTxt.classList.toggle('au-hide', recovery);
                recBox.classList.toggle('au-hide', !recovery);
                recTxt.classList.toggle('au-hide', !recovery);
                toggle.textContent = recovery ? 'Use an authentication code' : 'Use a recovery code';
                if (recovery) { codeIn.value = ''; recIn.focus(); }
                else { recIn.value = ''; codeIn.focus(); }
            });
        })();
    </script>
@endpush