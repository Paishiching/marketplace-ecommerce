{{-- ===== Desktop Header (>= 1200px) : orange top bar + white category nav ===== --}}
@php
    // Header e white logo dorkar (orange background). Admin > Settings theke logo_dark upload korle seta use hobe, na thakle normal logo.
    $ebLogoPath = $site->logo_dark ?: $site->logo;
    $ebLogo     = $ebLogoPath ? asset('storage/' . $ebLogoPath) : null;
@endphp

<header class="eb-header eb-desktop">

    {{-- Orange top bar --}}
    <div class="eb-top">
        <div class="container">
            <div class="eb-top-row">

                <a href="{{ route('homes') }}" class="eb-logo">
                    @if($ebLogo)
                        <img src="{{ $ebLogo }}" alt="{{ $site->site_name ?: 'Logo' }}">
                    @else
                        {{ $site->site_name ?: 'Marketplace' }}
                    @endif
                </a>

                <form action="{{ route('searches') }}" method="GET" class="eb-search" role="search">
                    <input type="text" name="q" id="searchInput" value="{{ request('q') }}" placeholder="Search for products brands and more" autocomplete="off">
                    <a class="eb-image-search-link" href="{{ route('searches') }}#image-search" aria-label="Search by image"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10" r="1.5"/><path d="m21 15-5-5L5 19"/></svg></a>
                    <button type="submit" aria-label="Search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7.5"/><path d="M21 21l-4.3-4.3"/></svg>
                    </button>
                </form>

                <div class="eb-actions">
                    {{-- Offers: nijer offers route thakle ekhane bodlan --}}
                    <a href="{{ route('categories.shop') }}" class="eb-act-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="8" width="18" height="4" rx="1" fill="#fff"/>
                            <path d="M5 12h14v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1z" fill="#fff"/>
                            <path d="M12 8v13" stroke="#fd6801"/>
                            <path d="M12 8c-1-3-5-4-5-1.5C7 8 9 8 12 8zM12 8c1-3 5-4 5-1.5C17 8 15 8 12 8z" stroke="#fff" fill="none"/>
                        </svg>
                        Offers
                    </a>

                    <a href="{{ route('compare.index') }}" class="eb-act-link eb-badge-host" data-number="{{ $compareCount ?? 0 }}" style="position:relative">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8h15m0 0l-4-4m4 4l-4 4"/><path d="M20 16H5m0 0l4 4m-4-4l4-4"/></svg>
                        Compare
                    </a>

                    {{-- Cart (id cartIconLink = cart popup JS e use hoy, change korben na) --}}
                    <a href="#offcanvas-cart" class="eb-circle eb-badge-host offcanvas-toggle" id="cartIconLink" data-number="{{ $cartCount ?? 0 }}" aria-label="Cart">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h3l2.4 11.2a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.5L21.5 7H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/></svg>
                    </a>

                    {{-- User --}}
                    <div class="eb-user">
                        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="eb-circle" aria-label="Account">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
                        </a>
                        <div class="eb-user-menu">
                            @auth
                                <a href="{{ route('dashboard') }}">My Dashboard</a>
                                <a href="{{ route('wishlist.index') }}">Wishlist</a>
                                <a href="{{ route('checkout.index') }}">Checkout</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}">Sign in</a>
                                <a href="{{ route('register') }}">Register</a>
                                <a href="{{ route('wishlist.index') }}">Wishlist</a>
                                <a href="{{ route('checkout.index') }}">Checkout</a>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- White category nav --}}
    <nav class="eb-nav">
        <div class="container">
            <ul class="eb-nav-list">
                @foreach($headerCategories as $category)
                    <li class="eb-nav-item">
                        <a href="{{ route('categories.shop', ['category' => $category->slug]) }}">
                            {{ $category->name }}
                            @if($category->children->isNotEmpty())
                                <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l4 4 4-4"/></svg>
                            @endif
                        </a>
                        @if($category->children->isNotEmpty())
                            <div class="eb-drop">
                                @foreach($category->children as $subCategory)
                                    <a href="{{ route('categories.shop', ['category' => $subCategory->slug]) }}">{{ $subCategory->name }}</a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>

</header>
