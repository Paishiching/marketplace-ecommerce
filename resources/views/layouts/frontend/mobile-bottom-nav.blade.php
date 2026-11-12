@php
    $navSlides = $navDeals['items'] ?? [];
    $navHasMore = $navDeals['has_more'] ?? false;
    $navWhatsapp = preg_replace('/[^0-9]/', '', (string) ($site->whatsapp_number ?? ''));
@endphp

<nav class="eb-bottom-nav eb-mobile-only" aria-label="Mobile navigation">

    <a href="{{ route('homes') }}" class="eb-bn-item {{ request()->routeIs('homes') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h5v-6h4v6h5V10"/></svg>
        Home
    </a>

    <a href="#offcanvas-mobile-menu" class="eb-bn-item offcanvas-toggle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"><rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="13.5" width="7" height="7" rx="1.5"/></svg>
        Category
    </a>

    {{-- ===== Center : Hot Deals product slider ===== --}}
    @if(count($navSlides))
        @php($firstNavSlide = $navSlides[0])
        <div class="eb-bn-deal" id="ebDealSlider"
             data-feed-url="{{ route('mobile-deals.feed') }}"
             data-next-page="2"
             data-has-more="{{ $navHasMore ? '1' : '0' }}"
             data-items="{{ json_encode($navSlides) }}">
            <div class="eb-bn-deal-ring">
                <div class="eb-bn-deal-win">
                    <a href="{{ route('products.details', $firstNavSlide['slug']) }}"
                       class="eb-bn-slide is-active" aria-label="{{ $firstNavSlide['name'] }}">
                        <img src="{{ $firstNavSlide['image'] }}" alt="{{ $firstNavSlide['name'] }}" loading="eager">
                    </a>
                    <a href="#" class="eb-bn-slide" aria-label="{{ $firstNavSlide['name'] }}" aria-hidden="true" tabindex="-1">
                        <img src="{{ $firstNavSlide['image'] }}" alt="" loading="lazy">
                    </a>
                </div>
            </div>
            <a class="eb-bn-deal-chat" id="ebDealChat" href="https://wa.me/{{ $navWhatsapp }}?text={{ rawurlencode('Hello Buydor BD, I want to know more about '.$firstNavSlide['name'].'. '.url('/products-details/'.$firstNavSlide['slug'])) }}" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp about {{ $firstNavSlide['name'] }}">
                <span>Chat Now</span>
            </a>
        </div>
    @else
        {{-- Product na thakle ager Hot Deals button --}}
        <div class="eb-bn-hot">
            <a href="{{ route('categories.shop') }}" aria-label="Hot Deals">
                <span>
                    <svg viewBox="0 0 24 24" fill="#fff"><path d="M12 2s1 3-1 5-4 3-4 7a6 6 0 0 0 12 0c0-3-2-4-2-6 0 0-3 1-3-2 0-2-1-3-2-4zm0 18a3 3 0 0 1-3-3c0-2 2-3 3-5 1 2 3 3 3 5a3 3 0 0 1-3 3z"/></svg>
                    HOT<br>DEALS
                </span>
            </a>
        </div>
    @endif

    <a href="{{ route('wishlist.index') }}" class="eb-bn-item {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-8-5.2-8-11a4.8 4.8 0 0 1 8-3.5A4.8 4.8 0 0 1 20 10c0 5.8-8 11-8 11z"/></svg>
        Wishlist
    </a>

    @auth
        <a href="{{ route('dashboard') }}" class="eb-bn-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
            Account
        </a>
    @else
        <a href="{{ route('login') }}" class="eb-bn-item {{ request()->routeIs('login') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
            Sign In
        </a>
    @endauth

</nav>

<style>
    /* ===== Bottom nav center : Hot Deals product slider ===== */
    .eb-bn-deal{position:relative;height:100%;display:flex;justify-content:center}
    .eb-bn-deal-ring{position:absolute;top:-24px;width:66px;height:66px;border-radius:50%;background:#fff;box-shadow:0 -3px 10px rgba(var(--eb-navy-rgb),.15);display:flex;align-items:center;justify-content:center}
    .eb-bn-deal-win{position:relative;width:56px;height:56px;border-radius:50%;overflow:hidden;background:#fff;border:2px solid var(--eb-orange)}
    .eb-bn-deal-chat{position:absolute;top:39px;left:50%;z-index:5;transform:translateX(-50%);display:inline-flex;align-items:center;justify-content:center;width:max-content;max-width:calc(20vw - 4px);height:22px;padding:0 8px;border:1px solid #a9dfbb;border-radius:999px;background:#effbf3;color:#168447;font-size:9px;font-weight:700;line-height:1;text-decoration:none;white-space:nowrap;box-shadow:0 1px 4px rgba(14,90,47,.12)}
    .eb-bn-deal-chat:hover{background:#e4f7eb;color:#0c7138}

    .eb-bn-deal .eb-bn-slide{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:#fff;opacity:0;transform:translateY(100%);transition:transform .5s ease,opacity .5s ease}
    .eb-bn-deal .eb-bn-slide img{width:100%;height:100%;object-fit:contain;padding:5px;display:block}
    .eb-bn-deal .eb-bn-slide.is-active{opacity:1;transform:translateY(0);z-index:2}
    .eb-bn-deal .eb-bn-slide.is-out{opacity:0;transform:translateY(-100%);z-index:1}
</style>

<script>
    (function () {
        var box = document.getElementById('ebDealSlider');
        if (!box) return;
        var slides = Array.from(box.querySelectorAll('.eb-bn-slide'));
        var items = [];
        try { items = JSON.parse(box.dataset.items || '[]'); } catch (err) {}
        if (!slides.length || !items.length) return;

        var current = 0;
        var nextIndex = 1;
        var page = parseInt(box.dataset.nextPage, 10) || 2;
        var hasMore = box.dataset.hasMore === '1';
        var loading = false;
        var mobile = window.matchMedia('(max-width:1199px)');

        function setProduct(slide, item) {
            slide.href = "{{ url('/products-details') }}/" + encodeURIComponent(item.slug);
            slide.setAttribute('aria-label', item.name || 'Product');
            var image = slide.querySelector('img');
            image.src = item.image;
            image.alt = item.name || 'Product';
            var chat = document.getElementById('ebDealChat');
            if (chat) {
                var productUrl = slide.href;
                var message = 'Hello Buydor BD, I want to know more about ' + (item.name || 'this product') + '. ' + productUrl;
                chat.href = 'https://wa.me/{{ $navWhatsapp }}?text=' + encodeURIComponent(message);
                chat.setAttribute('aria-label', 'Chat on WhatsApp about ' + (item.name || 'this product'));
            }
        }

        function loadMore() {
            if (!hasMore || loading) return;
            loading = true;
            fetch(box.dataset.feedUrl + '?page=' + page, { headers: { 'Accept': 'application/json' } })
                .then(function (response) {
                    if (!response.ok) throw new Error('Product feed request failed');
                    return response.json();
                })
                .then(function (data) {
                    items = items.concat(data.items || []);
                    page++;
                    hasMore = !!data.has_more;
                })
                .catch(function () {})
                .finally(function () { loading = false; });
        }

        if (mobile.matches) loadMore();
        if (mobile.addEventListener) {
            mobile.addEventListener('change', function (event) { if (event.matches) loadMore(); });
        } else if (mobile.addListener) {
            mobile.addListener(function (event) { if (event.matches) loadMore(); });
        }

        setInterval(function () {
            if (document.hidden) return;
            if (nextIndex >= items.length) {
                if (hasMore && mobile.matches) { loadMore(); return; }
                nextIndex = 0;
            }

            var cur = slides[current];
            var next = (current + 1) % slides.length;
            var nx = slides[next];
            setProduct(nx, items[nextIndex]);

            cur.classList.remove('is-active');
            cur.classList.add('is-out');
            cur.setAttribute('aria-hidden', 'true');
            cur.setAttribute('tabindex', '-1');
            nx.classList.remove('is-out');
            nx.classList.add('is-active');
            nx.removeAttribute('aria-hidden');
            nx.removeAttribute('tabindex');
            current = next;
            nextIndex++;

            if (mobile.matches && items.length - nextIndex <= 6) loadMore();

            setTimeout(function () { cur.classList.remove('is-out'); }, 600);
        }, 2500);
    })();
</script>
