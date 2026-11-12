@extends('layouts.frontend.app')

@section('title', 'Verify Email')

@section('content')

    <style>
        .ebl-page{background:rgba(42,53,130,.06);padding:30px 0 50px;font-family:'Poppins','Open Sans',sans-serif}
        .ebl-card{display:grid;grid-template-columns:1fr 1fr;background:#fff;border-radius:12px;overflow:hidden;max-width:1100px;margin:0 auto;min-height:520px;box-shadow:0 6px 24px rgba(42,53,130,.10)}
        .ebl-left{background:rgba(42,53,130,.04);padding:34px 40px;display:flex;flex-direction:column;justify-content:center}
        .ebl-left h1{margin:0 0 20px;text-align:center;font-size:26px;font-weight:700;color:#2a3582}
        .ebl-msg{text-align:center;font-size:14px;line-height:1.7;color:#2a3582;margin:0 0 24px}
        .ebl-msg b{color:#fd6801}

        .ebl-otp{display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:14px}
        .ebl-otp input{display:block;width:100%;max-width:300px;height:54px;border:1px solid rgba(42,53,130,.45);border-radius:12px;background:#fff;text-align:center;font-size:22px;font-weight:600;letter-spacing:10px;color:#2a3582;outline:none;padding:0 12px 0 22px;transition:border-color .2s,box-shadow .2s}
        .ebl-otp input:focus{border-color:#fd6801;box-shadow:0 0 0 3px rgba(253,104,1,.25)}
        .ebl-otp .dash{color:#2a3582;opacity:.6;font-size:14px}

        .ebl-paste{display:flex;align-items:center;justify-content:center;gap:6px;margin:0 auto 20px;padding:8px 18px;border:1px dashed #fd6801;border-radius:50px;background:rgba(253,104,1,.08);color:#fd6801;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s}
        .ebl-paste:hover{background:#fd6801;color:#fff}
        .ebl-paste svg{width:15px;height:15px}

        .ebl-err{display:block;color:#fd6801;font-size:13px;font-weight:600;margin:-4px 0 14px;text-align:center}
        .ebl-ok{background:rgba(42,53,130,.08);border:1px solid #2a3582;color:#2a3582;border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:13px;font-weight:600;text-align:center}

        .ebl-verify{display:block;width:100%;height:54px;border:0;border-radius:50px;background:#2a3582;color:#fff;font-size:19px;font-weight:600;cursor:pointer;transition:background .2s;box-shadow:0 4px 12px rgba(42,53,130,.25)}
        .ebl-verify:hover{background:#fd6801}
        .ebl-verify:disabled{opacity:.6;cursor:not-allowed}

        .ebl-wait{text-align:center;font-size:13px;color:#2a3582;opacity:.7;margin-top:16px}
        .ebl-resend{display:none;margin:16px auto 0;border:0;background:none;color:#fd6801;font-size:14px;font-weight:600;text-decoration:underline;cursor:pointer}
        .ebl-back{display:block;text-align:center;margin-top:10px;font-size:13px;color:#2a3582;opacity:.75}
        .ebl-back:hover{color:#fd6801;opacity:1}

        .ebl-right{background:#fff;display:flex;align-items:center;justify-content:center;padding:30px}
        .ebl-right img{max-width:100%;max-height:340px;object-fit:contain}

        @media(max-width:767px){
            .ebl-card{grid-template-columns:1fr;min-height:0}
            .ebl-right{display:none}
            .ebl-left{padding:28px 18px}
            .ebl-otp input{height:50px;font-size:20px}
        }
    </style>

    <div class="ebl-page">
        <div class="container">
            <div class="ebl-card">

                <div class="ebl-left">
                    <h1>Verify Your Email Address</h1>

                    <p class="ebl-msg">
                        We've sent a 6-digit OTP to <b>{{ $email }}</b>. In Gmail, tap <b>Copy code</b>, return here, then tap <b>Paste code</b>.
                        If the email isn't in your inbox, check Spam or Promotions.
                    </p>

                    @if(session('status'))
                        <div class="ebl-ok">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('otp.verify') }}" id="otpVerifyForm" novalidate>
                        @csrf
                        <div class="ebl-otp" id="otpBoxes">
                            <input type="text" name="otp" id="otpValue" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" maxlength="6" placeholder="Enter 6-digit code" autofocus required>
                        </div>

                        {{-- Email theke copy kora code ek click e boshay --}}
                        <button type="button" class="ebl-paste" id="pasteOtp">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="3" width="8" height="4" rx="1"/><path d="M16 5h2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2"/></svg>
                            Paste code
                        </button>

                        @error('otp')<span class="ebl-err">{{ $message }}</span>@enderror

                        <button type="submit" class="ebl-verify" id="verifyBtn">Verify OTP</button>
                    </form>

                    <div class="ebl-wait" id="waitText" style="display:none">
                        You can request a new OTP after <span id="waitTime">0:00</span> s
                    </div>

                    <form method="POST" action="{{ route('otp.resend') }}" style="text-align:center">
                        @csrf
                        <button type="submit" class="ebl-resend" id="resendBtn">Resend OTP</button>
                    </form>

                    <a href="{{ route('otp.login') }}" class="ebl-back">Use a different email</a>
                </div>

                <div class="ebl-right">
                    <img src="{{ asset('frontend/assets/images/login-illustration.png') }}" alt="Secure login" onerror="this.style.display='none'">
                </div>

            </div>
        </div>
    </div>

    <script>
        (function () {
            var codeInput = document.getElementById('otpValue');
            var form    = document.getElementById('otpVerifyForm');
            var verify  = document.getElementById('verifyBtn');
            var submitted = false;

            function collect() {
                codeInput.value = codeInput.value.replace(/\D/g, '').slice(0, 6);
            }
            function submitNow() {
                if (submitted) return;
                form.requestSubmit ? form.requestSubmit() : form.submit();
            }
            // A single one-time-code field supports browser/email OTP autofill.
            function fillCode(code) {
                code = String(code || '').replace(/\D/g, '').slice(0, 6);
                if (!code) return;
                codeInput.value = code;
                collect();
                codeInput.focus();
                if (code.length === 6) submitNow();
            }

            codeInput.addEventListener('input', function () {
                collect();
                if (codeInput.value.length === 6) submitNow();
            });
            codeInput.addEventListener('paste', function (e) {
                var text = (e.clipboardData || window.clipboardData).getData('text');
                if (!text) return;
                e.preventDefault();
                fillCode(text);
            });

            // Paste code button : clipboard theke 6 digit khuje boshay
            var pasteBtn = document.getElementById('pasteOtp');
            pasteBtn.addEventListener('click', function () {
                if (!navigator.clipboard || !navigator.clipboard.readText) {
                    if (typeof showToast === 'function') showToast('Paste', 'Long-press the code field and choose Paste.', 'error');
                    codeInput.focus();
                    return;
                }
                navigator.clipboard.readText().then(function (t) {
                    var m = String(t || '').match(/\d{6}/);
                    if (m) { fillCode(m[0]); }
                    else if (typeof showToast === 'function') { showToast('Paste', 'No 6-digit code found in clipboard.', 'error'); }
                }).catch(function () {
                    if (typeof showToast === 'function') showToast('Paste', 'Clipboard access denied. Long-press the code field and choose Paste.', 'error');
                });
            });

            // Android Chrome : SMS theke auto read (SMS er shesh line e "@buydorbd.com #123456" format lagbe)
            if ('OTPCredential' in window) {
                var ac = new AbortController();
                navigator.credentials.get({ otp: { transport: ['sms'] }, signal: ac.signal })
                    .then(function (otp) { if (otp && otp.code) fillCode(otp.code); })
                    .catch(function () {});
                form.addEventListener('submit', function () { ac.abort(); });
            }

            form.addEventListener('submit', function (e) {
                collect();
                if (codeInput.value.length !== 6) {
                    e.preventDefault();
                    if (typeof showToast === 'function') showToast('OTP', 'Please enter the 6-digit code.', 'error');
                    return;
                }
                submitted = true;
                verify.disabled = true;
                verify.textContent = 'Verifying...';
            });

            // ---------- Resend countdown ----------
            var left     = {{ (int) $wait }};
            var waitText = document.getElementById('waitText');
            var waitTime = document.getElementById('waitTime');
            var resend   = document.getElementById('resendBtn');

            function fmt(s) {
                var m = Math.floor(s / 60), r = s % 60;
                return m + ':' + (r < 10 ? '0' : '') + r;
            }
            function tick() {
                if (left > 0) {
                    waitText.style.display = 'block';
                    resend.style.display = 'none';
                    waitTime.textContent = fmt(left);
                    left--;
                    setTimeout(tick, 1000);
                } else {
                    waitText.style.display = 'none';
                    resend.style.display = 'block';
                }
            }
            tick();
        })();
    </script>

@endsection
