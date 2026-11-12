<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <title>MarketPlace–@yield('title')</title>

    <meta name="robots" content="noindex, follow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Phone browser address bar color -->
    <meta name="theme-color" content="#fd6801">
    <!-- Favicon -->
    <!-- Favicon (Admin > Settings > Website theke upload kora, na thakle default) -->
    @php
        $faviconUrl = !empty($site->favicon)
            ? asset('storage/' . $site->favicon) . '?v=' . optional($site->updated_at)->timestamp
            : asset('frontend/assets/images/favicon/favicon.png');
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}" />
    <link rel="shortcut icon" href="{{ $faviconUrl }}" />
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&amp;family=Poppins:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('/')}}frontend/assets/css/vendor/vendor.min.css" />
    <link rel="stylesheet" href="{{asset('/')}}frontend/assets/css/plugins/plugins.min.css" />
    <link rel="stylesheet" href="{{asset('/')}}frontend/assets/css/style.min.css">
    <!-- EB Theme (navy + orange, electronicsbangladesh style) - must load AFTER style.min.css -->
    <link rel="stylesheet" href="{{asset('/')}}frontend/assets/css/eb-theme.css?v=6">
    <link rel="stylesheet" href="{{ asset('css/responsive-overrides.css') }}?v=1">
    @stack('styles')
    <style>
        html,body{max-width:100%;overflow-x:hidden} img,video,iframe{max-width:100%} .container,.row,[class*="col-"]{min-width:0}
        .eb-search .eb-image-search-link{align-self:stretch;height:100%;box-sizing:border-box;display:flex;align-items:center;justify-content:center;padding-top:4px;line-height:1;flex:0 0 42px}
        .eb-search .eb-image-search-link svg{display:block;width:21px;height:21px;flex:none}
        body.is-product-detail .eb-bottom-nav{display:none!important}
        @media(max-width:767px){body{padding-bottom:62px}body.is-product-detail{padding-bottom:0!important}.container{width:100%;padding-left:14px;padding-right:14px}.table-responsive{max-width:100%;overflow-x:auto}.modal-dialog{margin:10px}.eb-bottom-nav{padding-bottom:env(safe-area-inset-bottom)}}
    </style>
    </head>

<body class="{{ request()->routeIs('products.details') ? 'is-product-detail' : '' }}">

<!-- Header Section Start From Here -->
@include('layouts.frontend.header')
<!-- Header Section End Here -->

<!-- Mobile Header Section Start -->
@include('layouts.frontend.mobile-header')
<!-- Mobile Header Section End -->

@include('layouts.frontend.mobile-offCanvas')
<div class="offcanvas-overlay"></div>


<!-- content home area start -->
@yield('content')
<!-- content home area end -->

<!-- Footer Area Start -->
@include('layouts.frontend.footer')
<!-- Footer Area End -->

<!-- Mobile Bottom Navigation -->
@include('layouts.frontend.mobile-bottom-nav')
<!-- Floating Contact Popup -->
@include('frontend.partials.contact-popup')

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12 mb-lm-100px mb-sm-30px">
                        <!-- Swiper -->
                        <div class="swiper-container gallery-top">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img class="img-responsive m-auto" src="{{asset('/')}}frontend/assets/images/product-image/11.jpg" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-responsive m-auto" src="{{asset('/')}}frontend/assets/images/product-image/12.jpg" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-responsive m-auto" src="{{asset('/')}}frontend/assets/images/product-image/13.jpg" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-responsive m-auto" src="{{asset('/')}}frontend/assets/images/product-image/14.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img class="img-responsive m-auto" src="{{asset('/')}}frontend/assets/images/product-image/11.jpg" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-responsive m-auto" src="{{asset('/')}}frontend/assets/images/product-image/12.jpg" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-responsive m-auto" src="{{asset('/')}}frontend/assets/images/product-image/13.jpg" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img class="img-responsive m-auto" src="{{asset('/')}}frontend/assets/images/product-image/14.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="product-details-content quickview-content">
                            <h2>Originals Kaval Windbr</h2>
                            <p class="reference">Reference:<span> demo_17</span></p>
                            <div class="pro-details-rating-wrap">
                                <div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                                <span class="read-review"><a class="reviews" href="#">Read reviews (1)</a></span>
                            </div>
                            <div class="pricing-meta">
                                <ul>
                                    <li class="old-price not-cut">€18.90</li>
                                </ul>
                            </div>
                            <p class="quickview-para">Lorem ipsum dolor sit amet, consectetur adipisic elit eiusm tempor incidid ut labore et dolore magna aliqua. Ut enim ad minim venialo quis nostrud exercitation ullamco</p>
                            <div class="pro-details-size-color">
                                <div class="pro-details-color-wrap">
                                    <span>Color</span>
                                    <div class="pro-details-color-content">
                                        <ul>
                                            <li class="blue"></li>
                                            <li class="maroon active"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="pro-details-quality">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                                </div>
                                <div class="pro-details-cart btn-hover">
                                    <a href="#"> + Add To Cart</a>
                                </div>
                            </div>
                            <div class="pro-details-wish-com">
                                <div class="pro-details-wishlist">
                                    <a href="wishlist.html"><i class="ion-android-favorite-outline"></i>Add to wishlist</a>
                                </div>
                                <div class="pro-details-compare">
                                    <a href="compare.html"><i class="ion-ios-shuffle-strong"></i>Add to compare</a>
                                </div>
                            </div>
                            <div class="pro-details-social-info">
                                <span>Share</span>
                                <div class="social-info">
                                    <ul>
                                        <li>
                                            <a href="#"><i class="ion-social-facebook"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-google"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-instagram"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

<script src="{{asset('/')}}frontend/assets/js/vendor/vendor.min.js"></script>
<script src="{{asset('/')}}frontend/assets/js/plugins/plugins.min.js"></script>

<!-- Guest login guard : Add to Cart / Buy Now e login na thakle OTP login page e pathay -->
<script>
    (function () {
        var buyNowClicked = false;

        // Buy Now button chaple flag set (server bujhbe verify er por checkout e jete hobe)
        document.addEventListener('click', function (e) {
            buyNowClicked = !!e.target.closest('.js-buy-now');
        }, true);

        var nativeFetch = window.fetch;
        window.fetch = async function (input, init) {
            var url = (typeof input === 'string') ? input : (input && input.url) || '';
            var isCartAdd = /\/cart\/add(\?|$)/.test(url);

            if (isCartAdd && buyNowClicked && init && typeof init.body === 'string') {
                try {
                    var payload = JSON.parse(init.body);
                    payload.buy_now = true;
                    init = Object.assign({}, init, { body: JSON.stringify(payload) });
                } catch (err) {}
            }
            if (isCartAdd) { buyNowClicked = false; }

            var res = await nativeFetch.call(window, input, init);

            if (isCartAdd && res.status === 401) {
                try {
                    var d = await res.clone().json();
                    if (d && d.login_required && d.redirect) {
                        window.location.href = d.redirect;
                        return new Promise(function () {});   // redirect hoar somoy toast/error jate na dekhay
                    }
                } catch (err) {}
            }
            return res;
        };
    })();
</script>

<!-- Toast Notification (style : eb-theme.css) -->
<div id="toastContainer"></div>

<script>
    function showToast(title, message, type = 'success', duration = 3000) {
        var container = document.getElementById('toastContainer');
        if (!container) return;

        // "Added to Cart" hole shudhu ek line dekhabe
        if (String(title).toLowerCase() === 'added to cart') {
            title = 'Added to cart';
            message = '';
        }

        var isError = (type === 'error');

        var okIcon  = '<svg class="app-toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M7.5 12.5l3 3 6-6.5"/></svg>';
        var errIcon = '<svg class="app-toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 7.5v5.5M12 16.5v.01"/></svg>';

        var toast = document.createElement('div');
        toast.className = 'app-toast' + (isError ? ' toast-error' : '');

        var body = document.createElement('div');
        body.className = 'app-toast-body';

        var t = document.createElement('div');
        t.className = 'app-toast-title';
        t.textContent = title;
        body.appendChild(t);

        if (message) {
            var m = document.createElement('div');
            m.className = 'app-toast-message';
            m.textContent = message;
            body.appendChild(m);
        }

        var close = document.createElement('button');
        close.type = 'button';
        close.className = 'app-toast-close';
        close.setAttribute('aria-label', 'Close');
        close.innerHTML = '&times;';

        toast.insertAdjacentHTML('afterbegin', isError ? errIcon : okIcon);
        toast.appendChild(body);
        toast.appendChild(close);
        container.appendChild(toast);

        setTimeout(function () { toast.classList.add('show'); }, 10);

        function removeToast() {
            toast.classList.remove('show');
            setTimeout(function () { toast.remove(); }, 320);
        }

        var autoRemove = setTimeout(removeToast, duration);
        close.addEventListener('click', function () {
            clearTimeout(autoRemove);
            removeToast();
        });
    }
</script>

<!-- typing  search script start -->
<script>
    (function () {
        var input = document.getElementById('searchInput');
        if (!input) return;

        var phrases = [
            'Search for mobiles...',
            'Search for fashion...',
            'Search for electronics...',
            'Search for home & kitchen...',
            'Search by product name...'
        ];
        var idle = 'Search for products brands and more';
        var p = 0, c = 0, deleting = false;

        function tick() {
            // user type korle ba focus e thakle animation pause
            if (input.value || document.activeElement === input) {
                input.placeholder = idle;
                c = 0; deleting = false;
                return setTimeout(tick, 400);
            }

            var text = phrases[p];
            var delay = deleting ? 35 : 75;

            if (!deleting) {
                c++;
                input.placeholder = text.substring(0, c) + '|';
                if (c === text.length) { deleting = true; delay = 1600; }
            } else {
                c--;
                input.placeholder = text.substring(0, c) + '|';
                if (c === 0) {
                    deleting = false;
                    p = (p + 1) % phrases.length;
                    delay = 400;
                }
            }
            setTimeout(tick, delay);
        }

        tick();
    })();
</script>

<script>
    (function () {
        var input = document.getElementById('mobileSearchInput');
        if (!input) return;

        var phrases = ['Search for mobiles...', 'Search for fashion...', 'Search for electronics...', 'Search by product name...'];
        var idle = 'Search for products brands and more';
        var p = 0, c = 0, deleting = false;

        function tick() {
            if (input.value || document.activeElement === input) {
                input.placeholder = idle;
                c = 0; deleting = false;
                return setTimeout(tick, 400);
            }
            var text = phrases[p];
            var delay = deleting ? 35 : 75;

            if (!deleting) {
                c++;
                input.placeholder = text.substring(0, c) + '|';
                if (c === text.length) { deleting = true; delay = 1600; }
            } else {
                c--;
                input.placeholder = text.substring(0, c) + '|';
                if (c === 0) { deleting = false; p = (p + 1) % phrases.length; delay = 400; }
            }
            setTimeout(tick, delay);
        }
        tick();
    })();
</script>

<!-- typing search script end -->

<!-- cart popup start -->
<script>
    var csrfMeta = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var isCartPage = false;

    function money(n) {
        return 'Tk. ' + parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function setHeaderCart(count, total) {
        // desktop + mobile cart badge (data-number attribute)
        var icon = document.getElementById('cartIconLink');
        if (icon) icon.setAttribute('data-number', count);
        var iconM = document.getElementById('cartIconLinkMobile');
        if (iconM) iconM.setAttribute('data-number', count);
        var sub = document.getElementById('cartSubtotalDisplay');
        if (sub) sub.textContent = 'Tk. ' + parseFloat(total).toLocaleString('en-US');
        var badge = document.getElementById('miniCartCount');
        if (badge) badge.textContent = count;
    }

    function loadMiniCart(openPopup) {
        fetch("{{ route('cart.mini') }}", { headers: { 'Accept': 'application/json' } })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                var box = document.getElementById('miniCartContent');
                if (box) box.innerHTML = data.html;
                setHeaderCart(data.count, data.total);

                if (openPopup) {
                    // desktop e cartIconLink, mobile e cartIconLinkMobile - je ta visible seta click hobe
                    var toggle = document.getElementById('cartIconLink');
                    if (!toggle || toggle.offsetParent === null) {
                        toggle = document.getElementById('cartIconLinkMobile') || toggle;
                    }
                    if (toggle) toggle.click();
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        isCartPage = !!document.getElementById('cartItemsBody');
        // Fetch cart contents only when the shopper opens the drawer.
        ['cartIconLink', 'cartIconLinkMobile'].forEach(function (id) {
            var cartLink = document.getElementById(id);
            if (cartLink) cartLink.addEventListener('click', function () { loadMiniCart(false); });
        });
    });

    // ---- Popup: qty update ----
    function miniQtyUpdate(row, qty) {
        var id = row.getAttribute('data-id');
        row.classList.add('mc-loading');

        fetch("{{ url('/cart/update') }}/" + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfMeta,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: qty })
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                row.classList.remove('mc-loading');
                if (!data.success) {
                    showToast('Error', data.message || 'Could not update quantity.', 'error');
                    return;
                }
                row.querySelector('.mc-qty-input').value = data.quantity;
                row.querySelector('.mc-sub').textContent = money(data.subtotal);
                var st = document.getElementById('mcSubtotal');
                if (st) st.textContent = money(data.cart_total);
                setHeaderCart(data.cart_count, data.cart_total);

                if (isCartPage) location.reload();   // cart page sync
            })
            .catch(function () {
                row.classList.remove('mc-loading');
                showToast('Error', 'Something went wrong. Please try again.', 'error');
            });
    }

    document.addEventListener('click', function (e) {
        // plus
        var plus = e.target.closest('.mc-plus');
        if (plus) {
            var row = plus.closest('.mc-item');
            var input = row.querySelector('.mc-qty-input');
            var stock = parseInt(input.getAttribute('data-stock')) || 0;
            var next = (parseInt(input.value) || 1) + 1;
            if (next > stock) {
                showToast('Stock Limit', 'Sorry, only ' + stock + ' items available in stock.', 'error');
                return;
            }
            miniQtyUpdate(row, next);
            return;
        }

        // minus
        var minus = e.target.closest('.mc-minus');
        if (minus) {
            var row2 = minus.closest('.mc-item');
            var input2 = row2.querySelector('.mc-qty-input');
            var cur = parseInt(input2.value) || 1;
            if (cur <= 1) return;   // 1 er niche jabe na, remove button use korben
            miniQtyUpdate(row2, cur - 1);
            return;
        }

        // remove
        var rm = e.target.closest('.mc-remove');
        if (rm) {
            var row3 = rm.closest('.mc-item');
            row3.classList.add('mc-removing');
            fetch("{{ url('/cart/remove') }}/" + row3.getAttribute('data-id'), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfMeta, 'Accept': 'application/json' }
            }).then(function () {
                if (isCartPage) { location.reload(); return; }
                setTimeout(function () { loadMiniCart(false); }, 250);
            });
            return;
        }

        // product card "ADD TO CART"
        var btn = e.target.closest('.cart-btn');
        if (!btn) return;
        e.preventDefault();

        var productId = btn.getAttribute('data-product-id');
        if (!productId) return;

        fetch("{{ route('cart.add') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfMeta,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: productId, variant_id: null, quantity: 1 })
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.success) {
                    showToast('Added to Cart', 'Product has been added to your cart.', 'success');
                    loadMiniCart(true);
                } else {
                    showToast('Error', data.message || 'Could not add to cart.', 'error');
                }
            })
            .catch(function () {
                showToast('Error', 'Something went wrong. Please try again.', 'error');
            });
    });
</script>
<!-- cart popup end -->

<!-- Main Activation JS -->
 @include('frontend.partials.spec-popover')
 
<script src="{{asset('/')}}frontend/assets/js/main.js"></script>
@stack('scripts')
</body>

</html>
