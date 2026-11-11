@php
    // Category image helper : column er naam 'image' na hole ekhane bodlan
    $catImg = function ($c) {
        return !empty($c->image) ? asset('storage/' . $c->image) : null;
    };
@endphp

<!-- OffCanvas Wishlist Start -->
<div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
    <div class="inner">
        <div class="head">
            <span class="title">Wishlist</span>
            <button class="offcanvas-close">×</button>
        </div>
        <div class="body customScroll">
            <ul class="minicart-product-list">
                <li>
                    <a href="single-product.html" class="image"><img src="{{asset('/')}}frontend/assets/images/product-image/1.jpg" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Walnut Cutting Board</a>
                        <span class="quantity-price">1 x <span class="amount">$100.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="single-product.html" class="image"><img src="{{asset('/')}}frontend/assets/images/product-image/2.jpg" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Lucky Wooden Elephant</a>
                        <span class="quantity-price">1 x <span class="amount">$35.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
                <li>
                    <a href="single-product.html" class="image"><img src="{{asset('/')}}frontend/assets/images/product-image/3.jpg" alt="Cart product Image"></a>
                    <div class="content">
                        <a href="single-product.html" class="title">Fish Cut Out Set</a>
                        <span class="quantity-price">1 x <span class="amount">$9.00</span></span>
                        <a href="#" class="remove">×</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="foot">
            <div class="buttons">
                <a href="wishlist.html" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
            </div>
        </div>
    </div>
</div>
<!-- OffCanvas Wishlist End -->

<!-- OffCanvas Cart Start -->
<div id="offcanvas-cart" class="offcanvas offcanvas-cart">
    <div class="inner">
        <div class="head">
            <span class="title">Shopping Cart <em id="miniCartCount" class="mc-count">0</em></span>
            <button type="button" class="offcanvas-close" aria-label="Close">
                <svg viewBox="0 0 16 16" fill="none" stroke-width="2" stroke-linecap="round"><path d="M3 3l10 10M13 3L3 13"/></svg>
            </button>
        </div>
        <div id="miniCartContent"></div>
    </div>
</div>
<!-- OffCanvas Cart End -->

<!-- OffCanvas Menu Item list (burger icon) Start : only main categories -->
<style>
    /* ===== Menu Item drawer (ml) — only #fd6801, #2a3582, #ffffff ===== */
    #offcanvas-menu-list{width:min(92vw,420px)!important;max-width:420px!important;padding:0!important;margin:0!important;border:0!important;overflow:hidden!important;background:#ffffff;z-index:99995!important}
    #offcanvas-menu-list .inner{padding:0!important;margin:0!important;width:100%!important;max-width:none!important;height:100%!important;max-height:none!important;overflow-y:auto!important;overflow-x:hidden!important;background:#ffffff;display:flex;flex-direction:column}

    .eb-ml-head{flex:0 0 auto;display:flex;align-items:center;justify-content:space-between;gap:10px;background:#2a3582;color:#ffffff;padding:14px 16px;border-bottom:4px solid #fd6801}
    .eb-ml-head span{font-size:18px;font-weight:500;color:#ffffff}
    .eb-ml-head .eb-ml-close{width:36px;height:36px;border-radius:50%;border:0;background:rgba(255,255,255,.18);color:#ffffff;display:inline-flex;align-items:center;justify-content:center;padding:0;margin:0;cursor:pointer;position:static;font-size:0}
    .eb-ml-head .eb-ml-close:hover{background:#fd6801}
    .eb-ml-head .eb-ml-close svg{width:18px;height:18px}
    /* theme er nijer X lukiye dao, nahole 2ta X dekhay */
    .eb-ml-close::before,.eb-ml-close::after{content:none!important;display:none!important}
    .eb-ml-close{background-image:none!important;box-shadow:none!important}

    /* one category per line, full width */
    .eb-ml-list{list-style:none;margin:0;padding:6px 0;flex:1 1 auto;display:block}
    .eb-ml-list li{display:block;width:100%;margin:0;list-style:none;border-bottom:1px solid rgba(42,53,130,.08)}
    .eb-ml-list li:last-child{border-bottom:0}
    .eb-ml-list li a{display:block;width:100%;padding:14px 16px;font-size:15px;font-weight:500;color:#2a3582;text-decoration:none}
    .eb-ml-list li a:hover{color:#fd6801;background:rgba(253,104,1,.06)}

    .eb-ml-foot{flex:0 0 auto;border-top:1px solid rgba(42,53,130,.15);padding:14px 16px 24px}
    .eb-ml-foot a{display:flex;align-items:center;gap:10px;padding:9px 0;font-size:15px;font-weight:600;color:#2a3582;text-decoration:none}
    .eb-ml-foot a:hover{color:#fd6801}
    .eb-ml-foot svg{width:20px;height:20px;flex:0 0 20px;color:#fd6801}
</style>

<div id="offcanvas-menu-list" class="offcanvas offcanvas-mobile-menu">
    <div class="inner">

        <div class="eb-ml-head">
            <span>All Categories</span>
            <button type="button" class="offcanvas-close eb-ml-close" aria-label="Close">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 3l10 10M13 3L3 13"/></svg>
            </button>
        </div>

        @if(isset($headerCategories) && $headerCategories->isNotEmpty())
            <ul class="eb-ml-list">
                @foreach($headerCategories as $category)
                    <li>
                        <a href="{{ route('categories.shop', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="eb-ml-foot">
            <a href="{{ route('compare.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8h15m0 0l-4-4m4 4l-4 4"/><path d="M20 16H5m0 0l4 4m-4-4l4-4"/></svg>
                Compare
            </a>
            <a href="{{ route('categories.shop') }}">
                <svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M5 12h14v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1z"/></svg>
                Offers
            </a>
        </div>

    </div>
</div>
<!-- OffCanvas Menu Item list End -->

<!-- OffCanvas Mobile Menu (Category) Start -->
<div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
    <div class="inner eb-m-drawer">

        <div class="eb-m-head">
            <button type="button" class="offcanvas-close eb-m-close" aria-label="Back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M11 6l-6 6 6 6"/></svg>
            </button>
            <span class="eb-m-title">All Categories</span>
            <a href="{{ route('searches') }}" class="eb-m-act" aria-label="Search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7.5"/><path d="M21 21l-4.3-4.3"/></svg>
            </a>
            <a href="{{ route('cart.index') }}" class="eb-m-act" aria-label="Cart">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h3l2.4 11.2a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.5L21.5 7H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/></svg>
            </a>
        </div>

        @if(isset($headerCategories) && $headerCategories->isNotEmpty())
            <div class="eb-cat-wrap">

                {{-- Left : parent categories --}}
                <ul class="eb-cat-side">
                    @foreach($headerCategories as $i => $category)
                        <li>
                            <button type="button" class="eb-cat-tab {{ $i === 0 ? 'active' : '' }}" data-target="ebCat{{ $category->id }}">
                                @if($catImg($category))
                                    <img src="{{ $catImg($category) }}" alt="{{ $category->name }}">
                                @else
                                    <i class="eb-cat-letter">{{ mb_strtoupper(mb_substr($category->name, 0, 1)) }}</i>
                                @endif
                                <span>{{ $category->name }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>

                {{-- Right : sub categories --}}
                <div class="eb-cat-main">
                    @foreach($headerCategories as $i => $category)
                        <div class="eb-cat-panel {{ $i === 0 ? 'active' : '' }}" id="ebCat{{ $category->id }}">
                            <h4 class="eb-cat-heading">{{ $category->name }}</h4>

                            <div class="eb-cat-grid">
                                {{-- All tile --}}
                                <a href="{{ route('categories.shop', ['category' => $category->slug]) }}" class="eb-cat-tile">
                                    <span class="eb-cat-ico">
                                        @if($catImg($category))
                                            <img src="{{ $catImg($category) }}" alt="{{ $category->name }}">
                                        @else
                                            <i class="eb-cat-letter">{{ mb_strtoupper(mb_substr($category->name, 0, 1)) }}</i>
                                        @endif
                                    </span>
                                    <em>View All</em>
                                </a>

                                @foreach($category->children as $sub)
                                    <a href="{{ route('categories.shop', ['category' => $sub->slug]) }}" class="eb-cat-tile">
                                        <span class="eb-cat-ico">
                                            @if($catImg($sub))
                                                <img src="{{ $catImg($sub) }}" alt="{{ $sub->name }}">
                                            @else
                                                <i class="eb-cat-letter">{{ mb_strtoupper(mb_substr($sub->name, 0, 1)) }}</i>
                                            @endif
                                        </span>
                                        <em>{{ $sub->name }}</em>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        @endif

    </div>
</div>
<!-- OffCanvas Mobile Menu End -->

<script>
    // Category drawer : left tab click -> right panel change
    document.querySelectorAll('.eb-cat-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.eb-cat-tab').forEach(function (t) { t.classList.remove('active'); });
            document.querySelectorAll('.eb-cat-panel').forEach(function (p) { p.classList.remove('active'); });
            tab.classList.add('active');
            var panel = document.getElementById(tab.getAttribute('data-target'));
            if (panel) {
                panel.classList.add('active');
                var main = panel.closest('.eb-cat-main');
                if (main) main.scrollTop = 0;
            }
        });
    });
</script>

<script>
    /* =========================================================
       Cart popup : shudhu HEADER cart icon e (user nijer click) khulbe.
       Add to Cart / Buy Now er por popup khulle sathe sathe bondho hobe,
       tai ekta por ekta product add kora jabe.
       ========================================================= */
    (function () {
        var drawer = document.getElementById('offcanvas-cart');
        if (!drawer) return;

        var userOpened = false;

        // Sotti user click (isTrusted) hole popup khola allowed ; code diye trigger kora click ignore
        ['cartIconLink', 'cartIconLinkMobile'].forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            el.addEventListener('click', function (e) {
                if (!e.isTrusted) return;
                userOpened = true;
                setTimeout(function () { userOpened = false; }, 1000);
            }, true);
        });

        function isOpen() {
            return /(^|\s)(offcanvas-open|open|active|show|is-open)(\s|$)/i.test(drawer.className);
        }

        // Header icon chara onno kono kichu popup khulle bondho kore dao
        new MutationObserver(function () {
            if (isOpen() && !userOpened) {
                var closeBtn = drawer.querySelector('.offcanvas-close');
                if (closeBtn) closeBtn.click();
            }
        }).observe(drawer, { attributes: true, attributeFilter: ['class'] });
    })();
</script>