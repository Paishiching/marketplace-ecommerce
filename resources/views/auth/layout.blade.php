@php
    // Header navy, tai white-text logo (logo) age, na thakle logo_dark
    $authLogoPth = isset($site) ? ($site->logo ?: $site->logo_dark) : null;
    $authLogo    = $authLogoPth ? asset('storage/' . $authLogoPth) : null;
    $authName    = (isset($site) && $site->site_name) ? $site->site_name : config('app.name', 'Buydor');
    $faviconUrl  = (isset($site) && !empty($site->favicon))
        ? asset('storage/' . $site->favicon) . '?v=' . optional($site->updated_at)->timestamp
        : asset('frontend/assets/images/favicon/favicon.png');
    $flashStatus = session('status');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ $authName }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">

    <style>
        /* ===== Auth pages (au) — only #fd6801, #2a3582, #ffffff ===== */
        :root{--au-o:#fd6801;--au-n:#2a3582;--au-w:#ffffff}

        .au-body{margin:0;min-height:100vh;display:flex;flex-direction:column;background:var(--au-w);font-family:system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;color:var(--au-n);box-sizing:border-box}
        .au-body *,.au-body *::before,.au-body *::after{box-sizing:border-box}
        .au-main{flex:1;display:flex;align-items:center;justify-content:center;padding:32px 16px;background:linear-gradient(180deg,rgba(42,53,130,.06) 0%,var(--au-w) 100%)}
        .au-wrap{width:100%;max-width:440px}
        .au-card{background:var(--au-w);border-radius:24px;box-shadow:0 20px 45px rgba(42,53,130,.15);overflow:hidden;border:1px solid rgba(42,53,130,.15);border-top:5px solid var(--au-o)}
        .au-top{padding:26px 32px;text-align:center;background:var(--au-n)}
        .au-top img{height:52px;width:auto;max-width:100%;object-fit:contain;display:block;margin:0 auto}
        .au-top .au-sitename{font-size:24px;font-weight:700;color:var(--au-w)}
        .au-form{padding:28px 32px 30px}
        .au-text{margin:0 0 20px;font-size:14px;line-height:1.6;color:var(--au-n);opacity:.8}
        .au-field{margin-bottom:18px}
        .au-label{display:block;margin-bottom:6px;font-size:14px;font-weight:600;color:var(--au-n)}
        .au-input-wrap{position:relative}
        .au-input{width:100%;height:46px;padding:0 14px;border:1px solid rgba(42,53,130,.3);border-radius:12px;font-size:14px;color:var(--au-n);background:var(--au-w);outline:none;transition:border-color .15s, box-shadow .15s;font-family:inherit}
        .au-input::placeholder{color:var(--au-n);opacity:.45}
        .au-input:focus{border-color:var(--au-n);box-shadow:0 0 0 3px rgba(42,53,130,.18)}
        .au-input.has-icon{padding-left:42px}
        .au-input.has-toggle{padding-right:44px}
        .au-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);width:19px;height:19px;color:var(--au-n);opacity:.5;pointer-events:none}
        .au-toggle{position:absolute;right:6px;top:50%;transform:translateY(-50%);width:36px;height:36px;border:0;background:transparent;color:var(--au-n);opacity:.55;cursor:pointer;border-radius:8px;display:flex;align-items:center;justify-content:center}
        .au-toggle:hover{color:var(--au-o);opacity:1}
        .au-toggle svg{width:19px;height:19px}
        .au-row{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:20px}
        .au-check{display:flex;align-items:center;gap:8px;font-size:14px;color:var(--au-n);cursor:pointer}
        .au-check input{width:16px;height:16px;accent-color:var(--au-o);margin:0}
        .au-check.top{align-items:flex-start;margin-bottom:20px}
        .au-check.top input{margin-top:3px}
        .au-link{color:var(--au-o);font-weight:600;text-decoration:none;font-size:14px;background:none;border:0;padding:0;cursor:pointer;font-family:inherit}
        .au-link:hover{color:var(--au-n);text-decoration:underline}
        .au-btn{width:100%;height:48px;border:0;border-radius:12px;background:var(--au-o);color:var(--au-w);font-size:15px;font-weight:700;cursor:pointer;box-shadow:0 8px 18px rgba(253,104,1,.30);transition:background .15s, transform .05s;font-family:inherit}
        .au-btn:hover{background:var(--au-n)}
        .au-btn:active{transform:translateY(1px)}
        .au-alt{margin:22px 0 0;text-align:center;font-size:14px;color:var(--au-n)}
        .au-back{margin:20px 0 0;text-align:center;font-size:13px}
        .au-back a{color:var(--au-n);opacity:.75;text-decoration:none}
        .au-back a:hover{color:var(--au-o);opacity:1}
        .au-error{margin-bottom:18px;padding:12px 14px;border-radius:12px;background:var(--au-w);border:1px solid var(--au-o);border-left:5px solid var(--au-o);color:var(--au-n);font-size:13px}
        .au-error ul{margin:6px 0 0;padding-left:18px}
        .au-status{margin-bottom:18px;padding:12px 14px;border-radius:12px;background:var(--au-w);border:1px solid var(--au-n);border-left:5px solid var(--au-n);color:var(--au-n);font-size:13px;font-weight:600}
        .au-hide{display:none}
        .au-actions{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-top:20px}

        /* Footer */
        .au-footer{background:var(--au-n);border-top:5px solid var(--au-o);color:var(--au-w);text-align:center;padding:28px 16px}
        .au-footer .au-f-name{font-size:22px;font-weight:800;letter-spacing:.3px;color:var(--au-w);margin:0 0 6px}
        .au-footer .au-f-copy{margin:0;font-size:13px;color:var(--au-w);opacity:.8}

        @media (max-width:480px){.au-top{padding:22px 20px}.au-form{padding:22px 20px 24px}}
    </style>
</head>
<body class="au-body">

    <main class="au-main">
        <div class="au-wrap">
            <div class="au-card">

                <div class="au-top">
                    <a href="{{ route('homes') }}" style="text-decoration:none;display:inline-block;">
                        @if($authLogo)
                            <img src="{{ $authLogo }}" alt="{{ $authName }}">
                        @else
                            <span class="au-sitename">{{ $authName }}</span>
                        @endif
                    </a>
                </div>

                <div class="au-form">

                    @if ($errors->any())
                        <div class="au-error">
                            <strong>Whoops! Something went wrong.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($flashStatus && $flashStatus !== 'verification-link-sent')
                        <div class="au-status">{{ $flashStatus }}</div>
                    @endif

                    @yield('content')
                </div>
            </div>

            <p class="au-back"><a href="{{ route('homes') }}">← Back to home</a></p>
        </div>
    </main>

    <footer class="au-footer">
        <p class="au-f-name">{{ $authName }}</p>
        <p class="au-f-copy">&copy; {{ date('Y') }} {{ $authName }}. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>