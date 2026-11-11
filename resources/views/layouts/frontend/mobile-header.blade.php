{{-- ===== Mobile Header (< 1200px) : orange bar, logo, cart + full width search ===== --}}
@php
    $ebLogoPathM = $site->logo_dark ?: $site->logo;
    $ebLogoM     = $ebLogoPathM ? asset('storage/' . $ebLogoPathM) : null;
@endphp

<div class="eb-mobile-header eb-mobile-only">
    <div class="container">

        <div class="eb-mh-row">
            <a href="#offcanvas-menu-list" class="eb-burger offcanvas-toggle" aria-label="Menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
            </a>

            <a href="{{ route('homes') }}" class="eb-mh-logo">
                @if($ebLogoM)
                    <img src="{{ $ebLogoM }}" alt="{{ $site->site_name ?: 'Logo' }}">
                @else
                    {{ $site->site_name ?: 'Marketplace' }}
                @endif
            </a>

            <a href="#offcanvas-cart" class="eb-circle eb-mh-cart eb-badge-host offcanvas-toggle" id="cartIconLinkMobile" data-number="{{ $cartCount ?? 0 }}" aria-label="Cart">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h3l2.4 11.2a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.5L21.5 7H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/></svg>
            </a>
        </div>
        <form action="{{ route('searches') }}" method="GET" class="eb-search" role="search">
            <input type="text" name="q" id="mobileSearchInput" value="{{ request('q') }}" placeholder="Search for products brands and more" autocomplete="off">
            <a class="eb-image-search-link" href="{{ route('searches') }}#image-search" aria-label="Search by image"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10" r="1.5"/><path d="m21 15-5-5L5 19"/></svg></a>
            <button type="submit" aria-label="Search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7.5"/><path d="M21 21l-4.3-4.3"/></svg>
            </button>
        </form>
    </div>
</div>
