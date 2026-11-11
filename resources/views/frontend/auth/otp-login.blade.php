@extends('layouts.frontend.app')

@section('title', 'Login')

@section('content')

    @php $brandName = 'Buydorbd in Bangladesh'; @endphp

    <style>
        .ebl-page{background:rgba(42,53,130,.06);padding:30px 0 50px;font-family:'Poppins','Open Sans',sans-serif}
        .ebl-card{display:grid;grid-template-columns:1fr 1fr;background:#fff;border-radius:12px;overflow:hidden;max-width:1100px;margin:0 auto;min-height:520px;box-shadow:0 6px 24px rgba(42,53,130,.10)}
        .ebl-left{background:rgba(42,53,130,.04);padding:34px 40px;display:flex;flex-direction:column;justify-content:center}
        .ebl-left h2{margin:0;text-align:center;font-size:26px;font-weight:400;color:#2a3582}
        .ebl-left h1{margin:6px 0 26px;text-align:center;font-size:24px;font-weight:700;color:#fd6801}

        .ebl-input{display:block;width:100%;height:46px;border:1px solid rgba(42,53,130,.25);border-radius:50px;background:#fff;text-align:center;font-size:14px;font-weight:500;color:#2a3582;outline:none;padding:0 18px;transition:border-color .2s,box-shadow .2s}
        .ebl-input::placeholder{color:rgba(42,53,130,.6);opacity:1}
        .ebl-input:focus{border-color:#fd6801;box-shadow:0 0 0 3px rgba(253,104,1,.2)}

        .ebl-or{display:flex;align-items:center;gap:10px;margin:14px 0;font-size:11px;color:#2a3582}
        .ebl-or:before,.ebl-or:after{content:"";flex:1;height:1px;background:rgba(42,53,130,.2)}

        .ebl-err{display:block;color:#fd6801;font-size:12px;font-weight:600;margin:6px 0 0;text-align:center}
        .ebl-ok{background:rgba(42,53,130,.08);border:1px solid #2a3582;color:#2a3582;border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:13px;font-weight:600;text-align:center}

        .ebl-captcha{display:flex;justify-content:center;margin-top:16px}
        @media(max-width:400px){.ebl-captcha .g-recaptcha{transform:scale(.88);transform-origin:center top;margin-bottom:-8px}}
        .ebl-login{display:block;width:100%;height:50px;margin-top:18px;border:0;border-radius:50px;background:#2a3582;color:#fff;font-size:17px;font-weight:600;cursor:pointer;transition:background .2s}
        .ebl-login:hover{background:#fd6801}
        .ebl-login:disabled{opacity:.6;cursor:not-allowed}

        .ebl-google{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;height:48px;border:0;border-radius:50px;background:#fff;color:#2a3582;font-size:18px;font-weight:600;cursor:pointer;box-shadow:0 1px 4px rgba(42,53,130,.12)}
        .ebl-google:hover{box-shadow:0 2px 10px rgba(42,53,130,.22)}
        .ebl-google svg{width:20px;height:20px}

        .ebl-pwtoggle{display:block;margin:14px auto 0;border:0;background:none;color:#fd6801;font-size:14px;font-weight:600;text-decoration:underline;cursor:pointer}
        .ebl-pwnote{margin:12px 0 0;text-align:center;font-size:13px;line-height:1.6;color:#2a3582;opacity:.8}

        .ebl-right{background:#fff;display:flex;align-items:center;justify-content:center;padding:30px}
        .ebl-right img{max-width:100%;max-height:340px;object-fit:contain}

        @media(max-width:767px){
            .ebl-card{grid-template-columns:1fr;min-height:0}
            .ebl-right{display:none}
            .ebl-left{padding:28px 20px}
        }
    </style>

    <div class="ebl-page">
        <div class="container">
            <div class="ebl-card">

                <div class="ebl-left">
                    <h2>Welcome to</h2>
                    <h1>{{ $brandName }}</h1>

                    @if(session('status'))
                        <div class="ebl-ok">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('otp.send') }}" id="otpLoginForm" novalidate>
                        @csrf

                        {{-- Phone ekhane dile account e save thake, checkout e auto boshe --}}
                        <input type="text" name="phone" id="phoneInput" class="ebl-input" value="{{ old('phone') }}" inputmode="tel" placeholder="Enter Your Phone Number" autocomplete="tel">
                        <span class="ebl-err" id="phoneErr" style="{{ $errors->has('phone') ? '' : 'display:none' }}">{{ $errors->first('phone') }}</span>

                        <div class="ebl-or">and</div>

                        <input type="email" name="email" id="emailInput" class="ebl-input" value="{{ old('email') }}" placeholder="Enter Your Email" autocomplete="email">
                        @error('email')<span class="ebl-err">{{ $message }}</span>@enderror

                        @if(config('recaptcha.site_key'))
                            <div class="ebl-captcha">
                                <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.site_key') }}"></div>
                            </div>
                        @endif
                        @error('captcha')<span class="ebl-err">{{ $message }}</span>@enderror

                        <button type="submit" class="ebl-login" id="loginBtn">Login</button>
                    </form>

                    <div class="ebl-or">or</div>

                    <button type="button" class="ebl-google" id="googleBtn" aria-label="Continue with Google">
                        <svg viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9.1 3.6l6.8-6.8C35.8 2.4 30.3 0 24 0 14.6 0 6.5 5.4 2.6 13.2l7.9 6.1C12.4 13.6 17.7 9.5 24 9.5z"/><path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3-2.3 5.5-4.8 7.2l7.5 5.8c4.4-4.1 7.1-10.1 7.1-17.5z"/><path fill="#FBBC05" d="M10.5 28.7a14.5 14.5 0 0 1 0-9.4l-7.9-6.1a24 24 0 0 0 0 21.6l7.9-6.1z"/><path fill="#34A853" d="M24 48c6.5 0 11.9-2.1 15.9-5.8l-7.5-5.8c-2.1 1.4-4.8 2.3-8.4 2.3-6.3 0-11.6-4.1-13.5-9.8l-7.9 6.1C6.5 42.6 14.6 48 24 48z"/></svg>
                        <span>Google</span>
                    </button>

                    {{-- ===== Email + Password login (dashboard theke password set korle) ===== --}}
                    <button type="button" class="ebl-pwtoggle" id="pwToggle">Login with password</button>

                    <form method="POST" action="{{ route('otp.password') }}" id="pwForm" style="{{ $errors->has('pw') ? '' : 'display:none;' }}margin-top:10px" novalidate>
                        @csrf
                        <input type="email" name="email" class="ebl-input" placeholder="Email" value="{{ old('email') }}" autocomplete="email">
                        <input type="password" name="password" class="ebl-input" placeholder="Password" style="margin-top:10px" autocomplete="current-password">
                        @error('pw')<span class="ebl-err">{{ $message }}</span>@enderror
                        <button type="submit" class="ebl-login">Login</button>
                        <p class="ebl-pwnote">
                            Forgot your password? Enter your email in the box above and sign in with the code we send you, then set a new password from your account.
                        </p>
                    </form>
                </div>

                <div class="ebl-right">
                    <img src="{{ asset('frontend/assets/images/login-illustration.png') }}" alt="Secure login" onerror="this.style.display='none'">
                </div>

            </div>
        </div>
    </div>

    @if(config('recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <script>
        (function () {
            var form  = document.getElementById('otpLoginForm');
            var phone = document.getElementById('phoneInput');
            var email = document.getElementById('emailInput');
            var pErr  = document.getElementById('phoneErr');

            function showErr(msg) {
                pErr.textContent = msg;
                pErr.style.display = 'block';
            }

            form.addEventListener('submit', function (e) {
                pErr.style.display = 'none';

                if (!email.value.trim()) {
                    e.preventDefault();
                    showErr('Please enter your email address.');
                    return;
                }

                // phone optional, kintu dile thik format hote hobe (01XXXXXXXXX / +8801XXXXXXXXX)
                var p = phone.value.replace(/[\s\-]/g, '');
                if (p !== '' && !/^(\+?88)?01[3-9]\d{8}$/.test(p)) {
                    e.preventDefault();
                    showErr('Please enter a valid Bangladeshi mobile number (01XXXXXXXXX).');
                    return;
                }

                if (window.grecaptcha && document.querySelector('.g-recaptcha') && !grecaptcha.getResponse()) {
                    e.preventDefault();
                    showErr('Please confirm that you are not a robot.');
                    return;
                }

                var btn = document.getElementById('loginBtn');
                btn.disabled = true;
                btn.textContent = 'Sending code...';
            });

            // Password login form show/hide
            document.getElementById('pwToggle').addEventListener('click', function () {
                var f = document.getElementById('pwForm');
                f.style.display = (f.style.display === 'none') ? 'block' : 'none';
            });

            document.getElementById('googleBtn').addEventListener('click', function () {
                if (typeof showToast === 'function') {
                    showToast('Not available', 'Google login is not available yet.', 'error');
                }
            });
        })();
    </script>

@endsection