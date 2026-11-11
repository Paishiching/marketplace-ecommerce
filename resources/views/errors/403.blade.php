<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Access restricted</title>
    <style>
        :root{--navy:#2a3582;--orange:#fd6801}*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px;background:#f5f6fb;color:var(--navy);font:16px/1.55 system-ui,-apple-system,"Segoe UI",sans-serif}
        .card{width:min(100%,520px);padding:42px 34px;background:#fff;border:1px solid #e6e8f1;border-radius:22px;box-shadow:0 18px 55px rgba(42,53,130,.1);text-align:center}.icon{width:68px;height:68px;margin:0 auto 20px;display:grid;place-items:center;border-radius:50%;background:#fff1e7;color:var(--orange);font-size:31px;font-weight:800}.code{margin:0;color:var(--orange);font-size:13px;font-weight:800;letter-spacing:.15em;text-transform:uppercase}h1{margin:6px 0 10px;font-size:27px;line-height:1.2}.copy{margin:0 auto 26px;max-width:390px;color:#626982}.actions{display:flex;flex-wrap:wrap;justify-content:center;gap:10px}.btn{display:inline-flex;justify-content:center;align-items:center;min-height:46px;padding:0 20px;border-radius:10px;text-decoration:none;font-weight:700}.primary{background:var(--orange);color:#fff}.secondary{border:1px solid #dfe2ee;color:var(--navy)}@media(max-width:480px){.card{padding:34px 22px}h1{font-size:23px}.btn{width:100%}}
    </style>
</head>
<body>
    @php
        $user = auth()->user();
        $dashboardRoute = $user?->hasRole('superadmin') ? 'superadmin.dashboards' : ($user?->hasRole('admin') ? 'admin.dashboards' : 'dashboard');
    @endphp
    <main class="card" role="alert">
        <div class="icon" aria-hidden="true">!</div>
        <p class="code">Access restricted · 403</p>
        <h1>You don’t have access to this page</h1>
        <p class="copy">Your account is signed in, but this page needs additional permission. Contact your administrator if you need access.</p>
        <div class="actions">
            @if(\Illuminate\Support\Facades\Route::has($dashboardRoute))<a class="btn primary" href="{{ route($dashboardRoute) }}">Go to dashboard</a>@endif
            <a class="btn secondary" href="{{ route('homes') }}">Back to store</a>
        </div>
    </main>
</body>
</html>
