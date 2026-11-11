@extends('layouts.frontend.app')

@section('title', 'My Account')

@section('content')

    <style>
        .dsh{padding:40px 0 70px;background:#f6f8fc}
        .dsh-grid{display:grid;grid-template-columns:280px 1fr;gap:24px;align-items:start}
        .dsh-side{background:#fff;border:1px solid #e9eef6;border-radius:18px;box-shadow:0 10px 30px rgba(16,42,90,.06);overflow:hidden;position:sticky;top:20px}
        .dsh-profile{padding:28px 20px 22px;text-align:center;background:linear-gradient(135deg,#f2630a,#ff9e32);color:#fff}
        .dsh-avatar{width:76px;height:76px;border-radius:50%;background:rgba(255,255,255,.2);border:3px solid rgba(255,255,255,.7);display:flex;align-items:center;justify-content:center;font-size:30px;font-weight:800;margin:0 auto 12px;text-transform:uppercase}
        .dsh-profile h5{margin:0;font-size:18px;font-weight:800;color:#fff}
        .dsh-profile small{display:block;margin-top:4px;opacity:.85;font-size:13px;word-break:break-all}

        /* ---------- Sidebar nav (theme override proof) ---------- */
        .dsh .dsh-nav{display:block!important;list-style:none!important;margin:0!important;padding:12px!important}
        .dsh .dsh-nav li{display:block!important;float:none!important;width:100%!important;margin:0!important;padding:0!important;list-style:none!important}
        .dsh .dsh-nav li form{margin:0;width:100%}
        .dsh .dsh-nav a,
        .dsh .dsh-nav button{display:flex!important;align-items:center;gap:12px;width:100%!important;padding:12px 14px!important;border:0!important;background:transparent!important;border-radius:12px!important;color:#475569!important;font-size:15px!important;font-weight:600!important;text-align:left;cursor:pointer;transition:all .2s ease;text-decoration:none!important;height:auto!important;line-height:1.4!important;box-shadow:none!important}
        .dsh .dsh-nav a:hover,
        .dsh .dsh-nav button:hover{background:#fff4eb!important;color:#e85d04!important}
        .dsh .dsh-nav a.active{background:#fff0e3!important;color:#e85d04!important}
        .dsh .dsh-nav svg{width:19px;height:19px;flex:0 0 19px}
        .dsh .dsh-nav button.logout{color:#dc2626!important}
        .dsh .dsh-nav button.logout:hover{background:#fef2f2!important;color:#b91c1c!important}
        .dsh .dsh-nav .dsh-sep{height:1px!important;width:auto!important;background:#eef1f6;margin:8px 6px!important}

        /* ---------- Main ---------- */
        .dsh-alert{background:#f0fdf4;border:1px solid #bbf7d0;border-left:5px solid #22c55e;color:#166534;border-radius:12px;padding:14px 18px;margin-bottom:20px;font-weight:600}
        .dsh-hero{background:#fff;border:1px solid #e9eef6;border-radius:18px;padding:26px 28px;box-shadow:0 10px 30px rgba(16,42,90,.06);display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:20px}
        .dsh-hero h2{margin:0 0 4px;font-size:24px;font-weight:800;color:#14213d}
        .dsh-hero p{margin:0;color:#64748b;font-size:15px}

        /* ---------- Buttons (theme override proof) ---------- */
        .dsh .dsh-btn,
        .dsh button.dsh-btn{
            display:inline-flex!important;align-items:center;justify-content:center;gap:8px;
            min-width:140px;height:auto!important;line-height:1.4!important;
            padding:12px 28px!important;border:0!important;border-radius:50px!important;
            background:linear-gradient(135deg,#ff8a24,#f2630a)!important;
            color:#fff!important;font-weight:700!important;font-size:14px!important;
            box-shadow:0 8px 18px rgba(242,99,10,.24)!important;
            transition:all .2s ease;text-decoration:none!important;cursor:pointer
        }
        .dsh .dsh-btn:hover,
        .dsh button.dsh-btn:hover{
            background:linear-gradient(135deg,#ed6814,#d94e00)!important;
            color:#fff!important;transform:translateY(-1px)
        }

        .dsh-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px}
        .dsh-stat{background:#fff;border:1px solid #e9eef6;border-radius:18px;padding:20px;box-shadow:0 10px 30px rgba(16,42,90,.06);display:flex;align-items:center;gap:16px}
        .dsh-ico{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;flex:0 0 52px}
        .dsh-ico svg{width:26px;height:26px}
        .dsh-ico.blue{background:#eaf2ff;color:#146cda}
        .dsh-ico.amber{background:#fef3c7;color:#b45309}
        .dsh-ico.green{background:#dcfce7;color:#15803d}
        .dsh-stat small{display:block;color:#94a3b8;font-weight:600;font-size:13px;margin-bottom:2px}
        .dsh-stat b{font-size:24px;font-weight:800;color:#14213d;line-height:1.1}

        .dsh-card{background:#fff;border:1px solid #e9eef6;border-radius:18px;box-shadow:0 10px 30px rgba(16,42,90,.06);overflow:hidden;margin-bottom:20px}
        .dsh-card-head{padding:20px 24px;border-bottom:1px solid #eef1f6;display:flex;align-items:center;justify-content:space-between}
        .dsh-card-head h3{margin:0;font-size:19px;font-weight:800;color:#14213d}
        .dsh-card-head a{font-size:14px;font-weight:700;color:#146cda}
        .dsh-body{padding:24px}
        .dsh-table{width:100%;border-collapse:collapse}
        .dsh-table th{background:#f8fafc;font-size:12px;color:#64748b;font-weight:700;padding:13px 20px;text-transform:uppercase;letter-spacing:.5px;text-align:left;white-space:nowrap}
        .dsh-table td{padding:16px 20px;border-bottom:1px solid #f1f4f9;color:#1e293b;vertical-align:middle;font-size:14.5px;white-space:nowrap}
        .dsh-table tbody tr:hover{background:#fafcff}
        .dsh-table tbody tr:last-child td{border-bottom:0}
        .dsh-ordno{font-weight:800;color:#146cda}
        .dsh-date small{display:block;color:#94a3b8;font-size:12px}

        .dsh-badge{display:inline-block;border-radius:50px;padding:4px 13px;font-size:12px;font-weight:700;text-transform:capitalize;background:#eaf2ff;color:#146cda}
        .dsh-badge.pending{background:#fef3c7;color:#b45309}
        .dsh-badge.processing{background:#e0e7ff;color:#4338ca}
        .dsh-badge.shipped{background:#cffafe;color:#0e7490}
        .dsh-badge.delivered,.dsh-badge.completed,.dsh-badge.paid{background:#dcfce7;color:#15803d}
        .dsh-badge.cancelled,.dsh-badge.failed{background:#fee2e2;color:#b91c1c}
        .dsh-badge.unpaid{background:#f1f5f9;color:#475569}

        .dsh-view{display:inline-block;padding:7px 16px;border-radius:50px;border:1px solid #cfe1fb;color:#146cda;font-weight:700;font-size:13px;text-decoration:none;transition:all .2s ease}
        .dsh-view:hover{background:#146cda;color:#fff;border-color:#146cda}
        .dsh-foot{padding:16px 24px;border-top:1px solid #eef1f6}
        .dsh-empty{text-align:center;padding:60px 20px;color:#64748b}
        .dsh-empty svg{width:64px;height:64px;color:#cbd5e1;margin-bottom:14px}
        .dsh-empty p{font-size:16px;margin-bottom:18px}

        /* ---------- Forms (theme override proof) ---------- */
        .dsh-row{display:grid;grid-template-columns:1fr 1fr;gap:18px}
        .dsh-f{margin-bottom:18px}
        .dsh-f label{display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px}
        .dsh .dsh-f input,
        .dsh .dsh-f select{
            display:block;width:100%!important;height:48px!important;padding:0 14px!important;
            border:1px solid #d8e1ee!important;border-radius:10px!important;
            font-size:14px;color:#1e293b;background:#fff!important;box-shadow:none!important;outline:none;
            transition:border-color .2s
        }
        .dsh .dsh-f input:focus,
        .dsh .dsh-f select:focus{border-color:#146cda!important}
        .dsh .dsh-f input[readonly]{background:#f1f5f9!important;color:#64748b}
        .dsh-err{display:block;color:#dc2626;font-size:12px;font-weight:600;margin-top:4px}
        .dsh-hint{font-size:13px;color:#64748b;margin:0 0 18px}

        /* ---------- Address cards ---------- */
        .dsh-addr-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .dsh-addr{border:1px solid #e9eef6;border-radius:14px;padding:18px}
        .dsh-addr strong{display:block;font-size:16px;color:#14213d;margin-bottom:6px}
        .dsh-addr span{display:block;font-size:14px;color:#64748b;line-height:1.6}
        .dsh-addr form{margin-top:12px}
        .dsh .dsh-del{border:1px solid #fecaca!important;background:#fff!important;color:#dc2626!important;border-radius:50px!important;padding:6px 16px!important;font-size:13px!important;font-weight:700!important;cursor:pointer;height:auto!important}
        .dsh .dsh-del:hover{background:#dc2626!important;color:#fff!important}

        .dsh,.dsh-grid,.dsh-side,.dsh-grid>main{min-width:0;max-width:100%}.dsh{overflow:hidden}.dsh-table{min-width:620px}.dsh .table-responsive{max-width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}
        @media(max-width:991px){.dsh-grid{grid-template-columns:minmax(0,1fr)}.dsh-side{position:static}}
        @media(max-width:767px){.dsh-stats,.dsh-row,.dsh-addr-grid{grid-template-columns:minmax(0,1fr)}.dsh-hero{padding:20px}.dsh-hero h2{font-size:21px;overflow-wrap:anywhere}.dsh-profile,.dsh-body,.dsh-card-head{min-width:0}.dsh-profile{display:flex;align-items:center;gap:12px;text-align:left;padding:12px 14px}.dsh-avatar{width:44px;height:44px;flex:0 0 44px;font-size:19px;margin:0}.dsh-profile h5{font-size:15px}.dsh-profile small{font-size:12px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.dsh-card-head{gap:10px;padding:16px}.dsh-body{padding:16px}.dsh{padding:20px 0 44px}.dsh .container{padding-left:14px;padding-right:14px}.dsh .dsh-nav{display:flex!important;align-items:center;gap:6px;overflow-x:auto;overscroll-behavior-x:contain;scrollbar-width:none;padding:8px!important;-webkit-overflow-scrolling:touch}.dsh .dsh-nav::-webkit-scrollbar{display:none}.dsh .dsh-nav li{display:flex!important;flex:0 0 auto!important;width:auto!important}.dsh .dsh-nav li form{width:auto}.dsh .dsh-nav a,.dsh .dsh-nav button{width:auto!important;white-space:nowrap;padding:9px 11px!important;gap:7px;font-size:13px!important}.dsh .dsh-nav .dsh-sep{display:none!important}.dsh-alert{position:fixed;z-index:1200;top:calc(124px + env(safe-area-inset-top));left:12px;right:12px;margin:0;box-shadow:0 8px 28px rgba(16,42,90,.18);animation:dsh-toast-in .25s ease-out}.dsh-alert-close{float:right;margin-left:12px;border:0;background:transparent;color:inherit;font-size:20px;line-height:1;cursor:pointer}@keyframes dsh-toast-in{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}}
        .dsh-menu-toggle{display:none}
        @media(max-width:767px){.dsh-profile-meta{flex:1;min-width:0}.dsh-menu-toggle{display:flex;align-items:center;justify-content:center;width:42px;height:42px;flex:0 0 42px;padding:0;border:1px solid rgba(255,255,255,.7);border-radius:12px;background:rgba(255,255,255,.16);color:#fff;cursor:pointer}.dsh-menu-toggle svg{width:23px;height:23px}.dsh .dsh-nav{display:none!important;flex-direction:column;align-items:stretch;gap:0;overflow:visible;padding:8px!important}.dsh .dsh-nav.is-open{display:flex!important}.dsh .dsh-nav li{display:flex!important;flex:0 0 auto!important;width:100%!important}.dsh .dsh-nav li form{width:100%}.dsh .dsh-nav a,.dsh .dsh-nav button{width:100%!important;white-space:normal;padding:10px 12px!important;gap:9px;font-size:14px!important}.dsh .dsh-nav .dsh-sep{display:block!important}}
    </style>

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('homes') }}">Home</a></li>
                            <li>My Account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="dsh">
        <div class="container">
            <div class="dsh-grid">

                <aside class="dsh-side">
                    <div class="dsh-profile">
                        <div class="dsh-avatar">{{ mb_substr(Auth::user()->name, 0, 1) }}</div>
                        <div class="dsh-profile-meta"><h5>{{ Auth::user()->name }}</h5>
                        <small>{{ Auth::user()->email }}</small></div>
                        <button type="button" class="dsh-menu-toggle" aria-label="Open account menu" aria-expanded="false" aria-controls="customerAccountMenu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button>
                    </div>

                    <ul class="dsh-nav" id="customerAccountMenu">
                        <li>
                            <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10"/></svg> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('account.orders') }}" class="{{ request()->routeIs('account.orders') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg> My Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.rfqs.index') }}" class="{{ request()->routeIs('customer.rfqs.*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 5h16v14H4zM8 9h8M8 13h6"/></svg> Sourcing requests
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('account.addresses') }}" class="{{ request()->routeIs('account.addresses*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg> Addresses
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6h15l-1.5 9h-12zM6 6L5 3H2M9 20a1 1 0 100-2 1 1 0 000 2zM18 20a1 1 0 100-2 1 1 0 000 2z"/></svg> My Cart
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('wishlist.index') }}">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.3-9.2C1.2 8.5 3 5 6.4 5c2 0 3.4 1.1 4.1 2.3h3C14.2 6.1 15.6 5 17.6 5 21 5 22.800 8.500 21.300 11.800 19 16.400 12 21 12 21z"/></svg> Wishlist
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('compare.index') }}">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6M4 4l5 5"/></svg> Compare
                            </a>
                        </li>
                        <li class="dsh-sep"></li>
                        <li>
                            <a href="{{ route('account.profile') }}" class="{{ request()->routeIs('account.profile*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg> Edit Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('account.password') }}" class="{{ request()->routeIs('account.password*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 018 0v4"/></svg> Password
                            </a>
                        </li>
                        <li class="dsh-sep"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </aside>

                <main>
                    @if(session('success'))
                        <div class="dsh-alert" role="status" aria-live="polite"><button class="dsh-alert-close" type="button" aria-label="Close notification">&times;</button>{{ session('success') }}</div>
                    @endif

                    @yield('account')
                </main>
            </div>
        </div>
    </section>
    <script>
        const customerMenuToggle=document.querySelector('.dsh-menu-toggle');
        const customerMenu=document.getElementById('customerAccountMenu');
        customerMenuToggle?.addEventListener('click',function(){const isOpen=customerMenu.classList.toggle('is-open');this.setAttribute('aria-expanded',String(isOpen));this.setAttribute('aria-label',isOpen?'Close account menu':'Open account menu');});
        document.querySelector('.dsh-alert-close')?.addEventListener('click',function(){this.parentElement.remove()});
        window.setTimeout(function(){document.querySelector('.dsh-alert')?.remove()},6000);
    </script>
@endsection
