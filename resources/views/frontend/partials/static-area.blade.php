@php
    $currency = $site->currency_symbol ?: '৳';
    $freeShipMin = (float) ($site->free_shipping_min_amount ?? 0);

    $features = [
        [
            'route' => 'policy.shipping',
            'icon'  => 'ion-android-car',
            'color' => 'orange',
            'title' => 'Free Shipping',
            'text'  => $freeShipMin > 0
                ? 'On orders over ' . $currency . number_format($freeShipMin, 0)
                : 'Free delivery on selected orders',
        ],
        [
            'route' => 'policy.returns',
            'icon'  => 'ion-refresh',
            'color' => 'navy',
            'title' => 'Free Returns',
            'text'  => 'Free returns within 9 days',
        ],
        [
            'route' => 'policy.support',
            'icon'  => 'ion-headphone',
            'color' => 'orange',
            'title' => '24/7 Support',
            'text'  => 'Contact us 24 hours a day',
        ],
        [
            'route' => 'policy.payment',
            'icon'  => 'ion-locked',
            'color' => 'navy',
            'title' => '100% Secure Payment',
            'text'  => 'Your payment is safe with us',
        ],
        [
            'route' => 'policy.faq',
            'icon'  => 'ion-help-buoy',
            'color' => 'orange',
            'title' => 'FAQ & Guarantee',
            'text'  => 'Genuine products, warranty & answers',
        ],
    ];
@endphp

<style>
    /* ===== Static features (sf) — only #fd6801, #2a3582, #ffffff ===== */
    .sf-area{padding:20px 0}
    .sf-card,a.sf-card{position:relative;display:flex!important;align-items:center;gap:16px;height:100%;padding:22px 20px!important;background:#ffffff!important;border:1px solid rgba(42,53,130,.14)!important;border-radius:18px!important;box-shadow:0 8px 24px rgba(42,53,130,.10);text-decoration:none!important;overflow:hidden;transition:all .3s ease}
    .sf-card:before{content:"";position:absolute;left:0;right:0;top:0;height:4px;background:var(--sf-c);transform:scaleX(.25);transform-origin:left;transition:transform .35s ease}
    .sf-card:after{content:"";position:absolute;right:-30px;bottom:-30px;width:100px;height:100px;border-radius:50%;background:var(--sf-c);opacity:.08;transition:all .35s ease}
    .sf-card:hover{transform:translateY(-8px);border-color:transparent!important;box-shadow:0 20px 44px rgba(42,53,130,.20)}
    .sf-card:hover:before{transform:scaleX(1)}
    .sf-card:hover:after{transform:scale(1.8);opacity:.12}

    .sf-ico{flex:0 0 58px;width:58px;height:58px;border-radius:16px;display:inline-flex;align-items:center;justify-content:center;font-size:28px;color:#ffffff;background:var(--sf-c);box-shadow:0 8px 20px var(--sf-sh);transition:transform .3s ease}
    .sf-card:hover .sf-ico{transform:rotate(-8deg) scale(1.1)}

    .sf-meta{position:relative;z-index:1;min-width:0}
    .sf-meta h4{margin:0 0 4px;font-size:17px;font-weight:800;color:#2a3582;line-height:1.3}
    .sf-meta p{margin:0;color:#2a3582;opacity:.75;font-size:13.5px;line-height:1.5}

    .sf-arrow{margin-left:auto;flex:0 0 auto;width:30px;height:30px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:rgba(42,53,130,.08);color:#2a3582;font-size:14px;opacity:0;transform:translateX(-8px);transition:all .3s ease;position:relative;z-index:1}
    .sf-card:hover .sf-arrow{opacity:1;transform:translateX(0);background:var(--sf-c);color:#ffffff}

    .sf-orange{--sf-c:#fd6801;--sf-sh:rgba(253,104,1,.40)}
    .sf-navy{--sf-c:#2a3582;--sf-sh:rgba(42,53,130,.40)}

    /* 5 cards in one row on large screens */
    @media(min-width:992px){.sf-col{flex:0 0 20%;max-width:20%}}
    @media(min-width:992px) and (max-width:1399px){
        .sf-card{flex-direction:column;text-align:center;gap:12px;padding:20px 14px!important}
        .sf-arrow{display:none}
    }

    @media(max-width:575px){.sf-card{padding:18px 16px!important}.sf-ico{flex-basis:50px;width:50px;height:50px;font-size:24px}}
</style>

<!-- Static Area Start -->
<div class="static-area sf-area mtb-60px">
    <div class="container">
        <div class="row g-4">
            @foreach($features as $f)
                <div class="sf-col col-md-6 col-12 mb-4 mb-lg-0">
                    <a href="{{ route($f['route']) }}" class="sf-card sf-{{ $f['color'] }}">
                        <span class="sf-ico"><i class="{{ $f['icon'] }}"></i></span>
                        <div class="sf-meta">
                            <h4>{{ $f['title'] }}</h4>
                            <p>{{ $f['text'] }}</p>
                        </div>
                        <span class="sf-arrow"><i class="ion-android-arrow-forward"></i></span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Static Area End -->