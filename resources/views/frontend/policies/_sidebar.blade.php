<style>
    /* ===== Support / Policy pages (sp) — only #fd6801, #2a3582, #ffffff ===== */
    :root{--sp-o:#fd6801;--sp-n:#2a3582;--sp-w:#ffffff}

    /* Hero */
    .sp-hero{position:relative;overflow:hidden;text-align:center;padding:56px 0 84px;background:var(--sp-n);border-bottom:5px solid var(--sp-o)}
    .sp-hero:before,.sp-hero:after{content:"";position:absolute;border-radius:50%;background:var(--sp-w);opacity:.07}
    .sp-hero:before{width:260px;height:260px;top:-100px;left:-70px}
    .sp-hero:after{width:200px;height:200px;bottom:-90px;right:-50px}
    .sp-hero .container{position:relative;z-index:1}
    .sp-hero h1{color:var(--sp-w)!important;font-size:2.3rem;font-weight:800;line-height:1.3;margin-bottom:12px}
    .sp-hero p{color:var(--sp-w)!important;opacity:.9;max-width:620px;margin:0 auto;font-size:1.05rem}
    .sp-crumb{display:flex;justify-content:center;gap:8px;margin-bottom:14px;font-size:13px;color:var(--sp-w)}
    .sp-crumb a{color:var(--sp-w)}
    .sp-crumb a:hover{color:var(--sp-o)}
    .sp-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.35);color:var(--sp-w);border-radius:50px;padding:6px 16px;font-size:13px;font-weight:600;margin-bottom:16px}
    .sp-badge:before{content:"";width:8px;height:8px;border-radius:50%;background:var(--sp-o);box-shadow:0 0 0 0 rgba(253,104,1,.7);animation:spPulse 1.8s infinite}
    @keyframes spPulse{70%{box-shadow:0 0 0 10px rgba(253,104,1,0)}100%{box-shadow:0 0 0 0 rgba(253,104,1,0)}}

    /* Top cards */
    .sp-pull{margin-top:-52px;position:relative;z-index:2}
    .sp-card{background:var(--sp-w);border:1px solid rgba(42,53,130,.12);border-radius:18px;padding:28px 22px;height:100%;text-align:center;box-shadow:0 10px 30px rgba(42,53,130,.10);transition:all .3s ease}
    .sp-card:hover{transform:translateY(-8px);box-shadow:0 20px 44px rgba(42,53,130,.20);border-color:var(--sp-o)}
    .sp-icon{width:64px;height:64px;border-radius:18px;display:inline-flex;align-items:center;justify-content:center;font-size:30px;color:var(--sp-w);margin-bottom:16px;transition:transform .3s ease}
    .sp-card:hover .sp-icon{transform:rotate(-8deg) scale(1.08)}
    /* old color class names kept so the pages keep working */
    .sp-ic-blue,.sp-ic-purple{background:var(--sp-n);box-shadow:0 8px 20px rgba(42,53,130,.40)}
    .sp-ic-green,.sp-ic-orange{background:var(--sp-o);box-shadow:0 8px 20px rgba(253,104,1,.40)}
    .sp-card h5{font-size:18px;font-weight:700;margin-bottom:10px;color:var(--sp-n)}
    .sp-card a.sp-link{display:block;color:var(--sp-n);font-weight:600;word-break:break-word;margin-bottom:4px}
    .sp-card a.sp-link:hover{color:var(--sp-o)}
    .sp-card small{display:block;margin-top:10px;color:var(--sp-n);opacity:.6}
    .sp-card p.sp-desc{color:var(--sp-n);opacity:.75;margin:0;line-height:1.6}
    .sp-card .sp-big{display:block;font-size:28px;font-weight:800;color:var(--sp-o);line-height:1.2;margin-bottom:4px}

    /* Section titles */
    .sp-section-title{font-size:24px;font-weight:800;color:var(--sp-n);margin-bottom:6px}
    .sp-section-sub{color:var(--sp-n);opacity:.7;margin-bottom:26px}

    /* Topic boxes */
    .sp-topic{display:flex;align-items:center;gap:14px;background:var(--sp-w);border:1px solid rgba(42,53,130,.12);border-radius:14px;padding:16px 18px;height:100%;transition:all .25s ease}
    .sp-topic:hover{border-color:var(--sp-o);box-shadow:0 10px 26px rgba(253,104,1,.15);transform:translateY(-3px)}
    .sp-topic i{flex:0 0 44px;height:44px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;background:rgba(253,104,1,.12);color:var(--sp-o);font-size:22px}
    .sp-topic span{font-weight:600;color:var(--sp-n);line-height:1.5}

    /* Stat boxes */
    .sp-stat{text-align:center;background:var(--sp-w);border:1px solid rgba(42,53,130,.15);border-top:4px solid var(--sp-o);border-radius:16px;padding:24px 16px;height:100%}
    .sp-stat b{display:block;font-size:26px;font-weight:800;color:var(--sp-o);line-height:1.2}
    .sp-stat span{display:block;color:var(--sp-n);opacity:.7;margin-top:6px}
    .sp-stat em{display:block;font-style:normal;font-weight:700;color:var(--sp-n);margin-bottom:6px}

    /* Address */
    .sp-address{display:flex;align-items:center;gap:16px;background:var(--sp-w);border:1px solid rgba(42,53,130,.12);border-left:5px solid var(--sp-o);border-radius:14px;padding:20px 22px;box-shadow:0 6px 20px rgba(42,53,130,.08)}
    .sp-address i{font-size:30px;color:var(--sp-o)}
    .sp-address h6{font-weight:700;margin-bottom:2px;color:var(--sp-n)}
    .sp-address p{margin:0;color:var(--sp-n);opacity:.75}

    /* CTA */
    .sp-cta{position:relative;overflow:hidden;border-radius:20px;padding:36px 28px;text-align:center;background:var(--sp-n);border-bottom:5px solid var(--sp-o);box-shadow:0 18px 40px rgba(42,53,130,.30)}
    .sp-cta h4{color:var(--sp-w)!important;font-weight:800;margin-bottom:8px}
    .sp-cta p{color:var(--sp-w);opacity:.9;margin-bottom:20px}
    .sp-cta .sp-btn{display:inline-block;background:var(--sp-o);color:var(--sp-w)!important;font-weight:700;padding:13px 34px;border-radius:50px;box-shadow:0 10px 24px rgba(0,0,0,.25);transition:all .3s ease}
    .sp-cta .sp-btn:hover{background:var(--sp-w);color:var(--sp-n)!important;transform:translateY(-3px)}

    /* Policy side menu */
    .sp-menu{background:var(--sp-w);border:1px solid rgba(42,53,130,.12);border-radius:16px;overflow:hidden;box-shadow:0 6px 20px rgba(42,53,130,.08);margin-bottom:24px}
    .sp-menu h6{margin:0;padding:16px 20px;color:var(--sp-w)!important;font-weight:700;background:var(--sp-n)}
    .sp-menu a{display:flex;align-items:center;gap:10px;padding:14px 20px;color:var(--sp-n);font-weight:600;border-bottom:1px solid rgba(42,53,130,.08);border-left:4px solid transparent}
    .sp-menu a:last-child{border-bottom:0}
    .sp-menu a:hover,.sp-menu a.active{color:var(--sp-o);background:rgba(253,104,1,.06);border-left-color:var(--sp-o);padding-left:24px}
    .sp-help{background:var(--sp-w);border:1px solid rgba(42,53,130,.15);border-top:4px solid var(--sp-o);border-radius:16px;padding:20px;text-align:center}
    .sp-help h6{font-weight:700;margin-bottom:6px;color:var(--sp-n)}
    .sp-help p{color:var(--sp-n);opacity:.75;margin-bottom:14px}
    .sp-help a{display:inline-block;background:var(--sp-o);color:var(--sp-w)!important;font-weight:700;padding:10px 24px;border-radius:50px}
    .sp-help a:hover{background:var(--sp-n)}

    /* ----- Payment page ----- */
    .sp-tips{list-style:none;margin:0;padding:0}
    .sp-tips li{display:flex;align-items:flex-start;gap:12px;padding:14px 0;border-bottom:1px dashed rgba(42,53,130,.2);color:var(--sp-n);font-weight:600;line-height:1.6}
    .sp-tips li:last-child{border-bottom:0;padding-bottom:0}
    .sp-tips li:first-child{padding-top:0}
    .sp-tips li i{flex:0 0 28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:rgba(253,104,1,.12);color:var(--sp-o);font-size:16px}

    /* ----- Shared panel / note (payment, returns, shipping) ----- */
    .sp-panel{background:var(--sp-w);border:1px solid rgba(42,53,130,.12);border-radius:18px;padding:24px 22px;box-shadow:0 6px 20px rgba(42,53,130,.08);height:auto}
    .sp-panel-ok,.sp-panel-no{height:100%}
    .sp-panel h5{font-weight:800;color:var(--sp-n);margin-bottom:16px;font-size:18px}
    .sp-panel-warn{border-left:5px solid var(--sp-o)}
    .sp-panel-ok{border-top:5px solid var(--sp-n)}
    .sp-panel-no{border-top:5px solid var(--sp-o)}
    .sp-note{display:flex;align-items:flex-start;gap:16px;background:var(--sp-w);border:1px solid rgba(42,53,130,.15);border-left:5px solid var(--sp-o);border-radius:14px;padding:20px 22px}
    .sp-note i{font-size:30px;color:var(--sp-o);line-height:1}
    .sp-note h6{font-weight:700;margin-bottom:4px;color:var(--sp-n)}
    .sp-note p{margin:0;color:var(--sp-n);opacity:.75;line-height:1.7}

    /* ----- Returns page ----- */
    .sp-checks{list-style:none;margin:0;padding:0}
    .sp-checks li{display:flex;align-items:flex-start;gap:12px;padding:11px 0;border-bottom:1px dashed rgba(42,53,130,.2);color:var(--sp-n);font-weight:600;line-height:1.6}
    .sp-checks li:last-child{border-bottom:0;padding-bottom:0}
    .sp-checks li:first-child{padding-top:0}
    .sp-checks li i{flex:0 0 26px;height:26px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:15px}
    .sp-checks.ok li i{background:rgba(42,53,130,.10);color:var(--sp-n)}
    .sp-checks.no li i{background:rgba(253,104,1,.12);color:var(--sp-o)}

    .sp-steps{list-style:none;margin:0;padding:0;position:relative}
    .sp-steps:before{content:"";position:absolute;left:21px;top:10px;bottom:10px;width:2px;background:rgba(42,53,130,.25)}
    .sp-steps li{position:relative;display:flex;gap:18px;align-items:flex-start;margin-bottom:18px}
    .sp-steps li:last-child{margin-bottom:0}
    .sp-steps .sp-num{flex:0 0 44px;height:44px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:var(--sp-o);color:var(--sp-w);font-weight:800;font-size:17px;box-shadow:0 6px 16px rgba(253,104,1,.35);position:relative;z-index:1}
    .sp-steps .sp-step-body{flex:1;background:var(--sp-w);border:1px solid rgba(42,53,130,.12);border-radius:14px;padding:14px 18px;transition:all .25s ease}
    .sp-steps li:hover .sp-step-body{border-color:var(--sp-o);box-shadow:0 10px 26px rgba(253,104,1,.15);transform:translateX(4px)}
    .sp-steps .sp-step-body b{display:block;color:var(--sp-n);margin-bottom:2px}
    .sp-steps .sp-step-body span{color:var(--sp-n);opacity:.75;line-height:1.6}

    /* ----- Shipping page ----- */
    .sp-table{width:100%;border-collapse:separate;border-spacing:0;overflow:hidden;border:1px solid rgba(42,53,130,.15);border-radius:14px;margin:0}
    .sp-table thead th{background:var(--sp-n);color:var(--sp-w);font-weight:700;padding:14px 18px;border:0;white-space:nowrap}
    .sp-table tbody td{padding:14px 18px;color:var(--sp-n);font-weight:600;border-top:1px solid rgba(42,53,130,.10);background:var(--sp-w)}
    .sp-table tbody tr:nth-child(even) td{background:rgba(42,53,130,.04)}
    .sp-table tbody tr:hover td{background:rgba(253,104,1,.08)}
    .sp-table .sp-price{color:var(--sp-o);font-weight:800}

    @media(max-width:767px){.sp-hero{padding:44px 0 76px}.sp-hero h1{font-size:1.7rem}}
</style>
@php
    $policyLinks = [
        'policy.shipping' => ['Free Shipping', 'ion-android-car'],
        'policy.returns'  => ['Free Returns', 'ion-refresh'],
        'policy.support'  => ['24/7 Support', 'ion-headphone'],
        'policy.payment'  => ['100% Secure Payment', 'ion-locked'],
        'policy.faq'      => ['FAQ & Guarantee', 'ion-help-buoy'],
    ];
@endphp

<div class="sp-menu">
    <h6>Our Policies</h6>
    @foreach($policyLinks as $routeName => $item)
        <a href="{{ route($routeName) }}" class="{{ request()->routeIs($routeName) ? 'active' : '' }}">
            <i class="{{ $item[1] }}"></i> {{ $item[0] }}
        </a>
    @endforeach
</div>

<div class="sp-help">
    <h6>Need Help?</h6>
    <p>Our support team is always by your side.</p>
    <a href="{{ route('contacts.index') }}">Contact Us</a>
</div>