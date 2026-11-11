@php
    $siteName = $site->site_name ?: config('app.name', 'Buydorbd');
    $phones = array_values(array_unique(array_filter([
        $site->phone_1, $site->phone_2, $site->phone_3, $site->phone_4,
    ])));
    $emails = array_values(array_unique(array_filter([
        $site->email_1, $site->email_2, $site->email_3,
    ])));
    $socials = array_filter([
        ['icon' => 'ion-social-facebook',  'url' => $site->facebook_url,  'label' => 'Facebook'],
        ['icon' => 'ion-social-instagram', 'url' => $site->instagram_url, 'label' => 'Instagram'],
        ['icon' => 'ion-social-twitter',   'url' => $site->twitter_url,   'label' => 'Twitter'],
        ['icon' => 'ion-social-youtube',   'url' => $site->youtube_url,   'label' => 'YouTube'],
        ['icon' => 'ion-social-linkedin',  'url' => $site->linkedin_url,  'label' => 'LinkedIn'],
    ], fn ($s) => !empty($s['url']));
    $whatsapp = preg_replace('/[^0-9]/', '', (string) $site->whatsapp_number);
    $logoDark = $site->logo_dark ? asset('storage/' . $site->logo_dark) : null;
    $payImg   = asset('/') . 'frontend/assets/images/icons/payment.png';

    $footerAbout = $site->footer_about ?: "Welcome to Buydor, your trusted destination for top-tier electronics. We are committed to redefining your shopping experience by offering an unmatched selection of authentic domestic and international brands. Driven by a passion for quality and innovation, our core mission is to ensure absolute customer satisfaction at every step. At Buydor, we don't just sell electronics—we build lasting relationships through reliability, excellence, and exceptional service.";
@endphp


<style>
    /* ===== Site Footer (sf) ===== */
    .sf-footer{position:relative;background:radial-gradient(900px 400px at 85% -10%,rgba(255,255,255,.10),transparent 60%),radial-gradient(700px 380px at 5% 110%,rgba(253,104,1,.22),transparent 60%),linear-gradient(180deg,#2a3582 0%,#2a3582 100%);color:rgba(255,255,255,.85);overflow:hidden}
    .sf-footer:before{content:"";position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#fd6801,#ffffff,#ffffff,#fd6801);background-size:200% 100%;animation:sfShine 6s linear infinite}
    @keyframes sfShine{0%{background-position:0 0}100%{background-position:200% 0}}
    .sf-footer ul,.sf-footer li{list-style:none;margin:0;padding:0}
    .sf-footer li{display:block}
    .sf-footer h5,.sf-footer h6,.sf-footer .sf-brand{color:#fff!important}
    .sf-footer a{color:rgba(255,255,255,.85);text-decoration:none;transition:all .25s ease}
    .sf-footer a:hover{color:#fff}
    .sf-footer p{line-height:1.7}

    /* Brand */
    .sf-brand{font-size:1.9rem;font-weight:800;letter-spacing:.3px;display:inline-block}

    /* Column titles */
    .sf-title{position:relative;color:#fff!important;font-size:15px;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;padding-bottom:14px;margin-bottom:22px}
    .sf-title:after{content:"";position:absolute;left:0;bottom:0;width:42px;height:3px;border-radius:3px;background:linear-gradient(90deg,#fd6801,#ffffff);box-shadow:0 0 12px rgba(253,104,1,.9)}

    /* Links */
    .sf-links li{margin-bottom:12px}
    .sf-links a{position:relative;display:inline-block;padding-left:0;font-size:14px}
    .sf-links a:before{content:"\203A";position:absolute;left:-14px;top:-1px;opacity:0;color:#fd6801;font-size:18px;transition:all .25s ease}
    .sf-links a:hover{padding-left:16px;color:#fff}
    .sf-links a:hover:before{opacity:1;left:0}

    /* Contact rows */
    .sf-contact{margin-top:6px;margin-bottom:22px}
    .sf-contact li{display:flex;align-items:flex-start;gap:14px;margin-bottom:18px}
    .sf-contact .sf-ico{flex:0 0 24px;width:24px;height:24px;color:#fff;margin-top:2px}
    .sf-contact .sf-ico svg{width:24px;height:24px;display:block}
    .sf-contact .sf-text{font-size:15px;line-height:1.6;color:#fff}
    .sf-contact .sf-text a{display:block;color:#fff;word-break:break-word}
    .sf-contact .sf-text a:hover{color:#fd6801}

    /* Social (white circle, navy icon) */
    .sf-social{display:flex;flex-wrap:wrap;gap:14px;margin-top:8px}
    .sf-social a{width:48px;height:48px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:24px;line-height:1;color:#2a3582;background:#fff;border:0;transition:all .25s ease}
    .sf-social a i{color:#2a3582;font-size:26px;line-height:1}
    .sf-social a:hover{background:#fd6801;transform:translateY(-4px);box-shadow:0 10px 24px rgba(253,104,1,.6)}
    .sf-social a:hover i{color:#fff}

    /* About Us strip */
    .sf-aboutbar{border-top:1px solid rgba(255,255,255,.12);padding:30px 0}
    .sf-aboutbar .sf-title{margin-bottom:16px}
    .sf-aboutbar p{margin:0;max-width:980px;font-size:14.5px;line-height:1.9;color:rgba(255,255,255,.85)}

    /* Mobile only block : payment + social (copyright-er upore) */
    .sf-mob{border-top:1px solid rgba(255,255,255,.18);padding:22px 0 0;text-align:center}
    .sf-mob .sf-pay-wrap{padding:0 12px 22px}
    .sf-mob .sf-social{justify-content:center;gap:16px;margin:0;padding:22px 12px;border-top:1px solid rgba(255,255,255,.18);border-bottom:1px solid rgba(255,255,255,.18)}
    .sf-mob .sf-social a{width:46px;height:46px}
    .sf-mob .sf-social a i{font-size:28px}

    /* Bottom bar */
    .sf-bottom{border-top:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.06);padding:18px 0}
    .sf-bottom p{margin:0;font-size:13px;color:rgba(255,255,255,.7)}
    .sf-sep{display:inline-block;margin:0 8px;opacity:.5}
    .sf-dev a{color:#fff;font-weight:600;text-decoration:none;transition:color .2s ease}
    .sf-dev a:hover{color:#fd6801}
    .sf-pay{background:#fff;border-radius:10px;padding:6px 12px;max-width:100%;height:auto;box-shadow:0 6px 18px rgba(42,53,130,.3)}

    @media (max-width:767px){
        .sf-title{margin-top:8px}
        .sf-aboutbar{padding:24px 0}
        .sf-mob{border-top:0;padding-top:0}
        .sf-bottom{border-top:0;background:transparent;padding:18px 12px 86px}  /* 86px = bottom nav-er jaiga */
        .sf-bottom p{text-align:center;font-size:13px;font-weight:600;color:#fff;line-height:1.8}
        .sf-sep{display:none}
        .sf-dev{display:block}
    }
</style>
<footer class="sf-footer">
    <div class="container pt-5">

        <div class="row g-4 g-lg-5 pb-5">

            {{-- Brand + Contact + Social (social ekhane shudhu desktop-e) --}}
            <div class="col-12 col-lg-4">
                <a href="{{ route('homes') }}" class="d-inline-block mb-4">
                    @if($logoDark)
                        <img src="{{ $logoDark }}" alt="{{ $siteName }}" style="max-height:50px;width:auto;">
                    @else
                        <span class="sf-brand">{{ $siteName }}</span>
                    @endif
                </a>

                <ul class="sf-contact">
                    @if($site->address)
                        <li>
                            <span class="sf-ico">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
                            </span>
                            <span class="sf-text">{{ $site->address }}</span>
                        </li>
                    @endif

                    @if(count($phones))
                        <li>
                            <span class="sf-ico">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25c1.1.37 2.3.57 3.6.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.6 21 3 13.4 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1z"/></svg>
                            </span>
                            <span class="sf-text">
                                @foreach($phones as $phone)
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">{{ $phone }}</a>
                                @endforeach
                            </span>
                        </li>
                    @endif

                    @if(count($emails))
                        <li>
                            <span class="sf-ico">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4.2-8 5-8-5V6l8 5 8-5v2.2z"/></svg>
                            </span>
                            <span class="sf-text">
                                @foreach($emails as $email)
                                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                                @endforeach
                            </span>
                        </li>
                    @endif

                    @if($whatsapp !== '' || $site->messenger_link)
                        <li>
                            <span class="sf-ico">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"/></svg>
                            </span>
                            <span class="sf-text">
                                @if($whatsapp !== '')
                                    <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener">WhatsApp: {{ $site->whatsapp_number }}</a>
                                @endif
                                @if($site->messenger_link)
                                    <a href="{{ $site->messenger_link }}" target="_blank" rel="noopener">Chat on Messenger</a>
                                @endif
                            </span>
                        </li>
                    @endif
                </ul>

                @if(count($socials))
                    <div class="sf-social d-none d-md-flex">
                        @foreach($socials as $s)
                            <a href="{{ $s['url'] }}" target="_blank" rel="noopener" title="{{ $s['label'] }}" aria-label="{{ $s['label'] }}">
                                <i class="{{ $s['icon'] }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Information --}}
            <div class="col-6 col-lg-3">
                <h6 class="sf-title">Information</h6>
                <ul class="sf-links">
                    <li><a href="{{ route('policy.shipping') }}">Delivery</a></li>
                    <li><a href="{{ route('policy.returns') }}">Returns &amp; Refunds</a></li>
                    <li><a href="{{ route('policy.payment') }}">Secure Payment</a></li>
                    <li><a href="{{ route('policy.support') }}">Support</a></li>
                    <li><a href="{{ route('policy.faq') }}">FAQ</a></li>
                    <li><a href="{{ route('warranty.index') }}">Warranty</a></li>
                </ul>
            </div>

            {{-- Quick links --}}
            <div class="col-6 col-lg-3">
                <h6 class="sf-title">Quick Links</h6>
                <ul class="sf-links">
                    <li><a href="{{ route('categories.shop') }}">All Products</a></li>
                    <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                    <li><a href="{{ route('compare.index') }}">Compare</a></li>
                    <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('stores') }}">Stores</a></li>
                    {{-- <li><a href="{{ route('become-vendor.create') }}">Become a Vendor</a></li>
                    <li><a href="{{ route('become-supplier.create') }}">Become a Supplier</a></li>
                    <li><a href="{{ route('become-affiliate.create') }}">Become an Affiliate</a></li>
                    <li><a href="{{ route('become-reseller.create') }}">Become a Reseller</a></li> --}}
                    @guest
                        @if(\Illuminate\Support\Facades\Route::has('login'))
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @endif
                        @if(\Illuminate\Support\Facades\Route::has('register'))
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('dashboard') }}">My Dashboard</a></li>
                    @endguest
                </ul>
            </div>

            {{-- About (right side) --}}
            <div class="col-12 col-lg-2">
                <h6 class="sf-title">About</h6>
                <ul class="sf-links">
                    <li><a href="{{ route('page.index') }}">About Us</a></li>
                    <li><a href="{{ route('contacts.index') }}">Contact Us</a></li>
                    <li><a href="{{ route('complaint.index') }}">Customer Complaint</a></li>
                </ul>
            </div>

        </div>
    </div>

    {{-- About Us text --}}
    <div class="sf-aboutbar">
        <div class="container">
            <h6 class="sf-title">About Us</h6>
            <p>{{ $footerAbout }}</p>
        </div>
    </div>

    {{-- MOBILE ONLY : payment logo -> social icons (divider soho) --}}
    <div class="sf-mob d-md-none">
        <div class="sf-pay-wrap">
            <img class="sf-pay" src="{{ $payImg }}" alt="Accepted payment methods">
        </div>
        @if(count($socials))
            <div class="sf-social">
                @foreach($socials as $s)
                    <a href="{{ $s['url'] }}" target="_blank" rel="noopener" title="{{ $s['label'] }}" aria-label="{{ $s['label'] }}">
                        <i class="{{ $s['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Bottom bar (copyright) --}}
    <div class="sf-bottom">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-8 text-center text-lg-start">
                    <p>
                        {{ $site->copyright_text ?: '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.' }}
                        <span class="sf-sep">|</span>
                        <span class="sf-dev">Developed by <a href="https://creativezoneit.com/" target="_blank" rel="noopener">Creative Zone IT</a></span>
                    </p>
                </div>
                {{-- Desktop only payment logo --}}
                <div class="col-lg-4 text-lg-end d-none d-lg-block">
                    <img class="sf-pay" src="{{ $payImg }}" alt="Accepted payment methods">
                </div>
            </div>
        </div>
    </div>
</footer>