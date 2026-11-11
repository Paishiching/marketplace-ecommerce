@extends('layouts.frontend.app')

@section('title','Home')

@section('content')

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-home.css?v=19">

    {{-- ================= HERO : main slider + side sliders (desktop 2 tile, mobile 4 tile) ================= --}}
    @php
        $sideBanners = isset($heroSides)
            ? collect($heroSides)->filter()->values()
            : collect([$heroSideTop ?? null, $heroSideBot ?? null])->filter()->values();
        $sn = $sideBanners->count();
    @endphp

    @if($heroMain->isNotEmpty())
        <section class="eb-hero">
            <div class="container">
                <div class="eb-hero-grid {{ $sn ? '' : 'no-side' }}">

                    <div class="eb-hero-main">
                        <div class="swiper-container eb-hero-slider">
                            <div class="swiper-wrapper">
                                @foreach($heroMain as $banner)
                                    <div class="swiper-slide">
                                        <a href="{{ $banner->link ?: route('categories.shop') }}" class="eb-banner">
                                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?? 'Banner' }}" @if(!$loop->first) loading="lazy" @endif>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @if($heroMain->count() > 1)
                                <div class="swiper-pagination eb-hero-dots"></div>
                            @endif
                        </div>
                    </div>

                    @if($sn)
                        <div class="eb-hero-side">
                            @foreach([0, 1, 2, 3] as $slot)
                                @php
                                    // protita tile e sob banner, tile onujayi alada starting point
                                    $list = collect(range(0, $sn - 1))
                                        ->map(fn ($k) => $sideBanners[($slot + $k) % $sn])
                                        ->values();
                                    // loop smooth korte kom hole duplicate
                                    if ($sn > 1 && $sn < 4) {
                                        $list = $list->concat($list)->values();
                                    }
                                @endphp
                                <div class="swiper-container eb-side-slider {{ $slot > 1 ? 'eb-side-extra' : '' }}"
                                     data-slides="{{ $sn }}">
                                    <div class="swiper-wrapper">
                                        @foreach($list as $side)
                                            <div class="swiper-slide">
                                                <a href="{{ $side->link ?: route('categories.shop') }}" class="eb-banner">
                                                    <img src="{{ $side->image_url }}" alt="{{ $side->title ?? 'Banner' }}" @if($slot > 0) loading="lazy" @endif>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </section>
    @endif

    {{-- ================= FEATURE STRIP : text config/home.php te ================= --}}
    @include('frontend.partials.home-features')


    {{-- ================= FEATURED CATEGORIES ================= --}}
    @if($featuredCategories->isNotEmpty())
        <section class="eb-block">
            <div class="container">
                <div class="eb-sec-head">
                    <h2>Featured Categories</h2>
                </div>
                <div class="eb-cat-row">
                    @foreach($featuredCategories as $category)
                        <a href="{{ route('categories.shop', ['category' => $category->slug]) }}" class="eb-cat-card" title="{{ $category->name }}">
                            <span class="eb-cat-img">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy">
                                @else
                                    <b>{{ mb_strtoupper(mb_substr($category->name, 0, 1)) }}</b>
                                @endif
                            </span>
                            <span class="eb-cat-name">{{ $category->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    {{-- ================= PROMO STRIP (wide) ================= --}}
    @if($promoStrip)
        <section class="eb-block">
            <div class="container">
                <a href="{{ $promoStrip->link ?: route('categories.shop') }}" class="eb-banner eb-strip">
                    <img src="{{ $promoStrip->image_url }}" alt="{{ $promoStrip->title ?? 'Promo' }}" loading="lazy">
                </a>
            </div>
        </section>
    @endif


    {{-- ================= HOT DEALS ================= --}}
    @if($hotDeals->isNotEmpty())
        <section class="eb-block">
            <div class="container">
                <div class="eb-sec-head">
                    <h2>Hot Deals</h2>
                </div>
                <div class="eb-prod-marquee" style="--prod-dur: {{ max(20, $hotDeals->count() * 4) }}s">
                    <div class="eb-prod-track">
                        @foreach([false, true] as $duplicate)
                            <div class="eb-prod-group" @if($duplicate) aria-hidden="true" @endif>
                                @foreach($hotDeals as $product)
                                    @include('frontend.partials.product-card', ['product' => $product, 'duplicate' => $duplicate])
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ================= CATEGORY WISE SECTIONS (+ dual banners after 2nd) ================= --}}
    @foreach($categorySections as $category)
        <section class="eb-block">
            <div class="container">
                <div class="eb-sec-head">
                    <h2>{{ $category->section_title ?? $category->name }}</h2>
                    <a href="{{ route('categories.shop', ['category' => $category->slug]) }}" class="eb-all-btn">
                        All Products
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2l4 4-4 4"/></svg>
                    </a>
                </div>
                <div class="eb-prod-marquee" style="--prod-dur: {{ max(20, $category->sectionProducts->count() * 4) }}s">
                    <div class="eb-prod-track">
                        @foreach([false, true] as $duplicate)
                            <div class="eb-prod-group" @if($duplicate) aria-hidden="true" @endif>
                                @foreach($category->sectionProducts as $product)
                                    @include('frontend.partials.product-card', ['product' => $product, 'duplicate' => $duplicate])
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        @if($loop->iteration === 2 && ($dualLeft || $dualRight))
            <section class="eb-block">
                <div class="container">
                    <div class="eb-dual">
                        @foreach([$dualLeft, $dualRight] as $dual)
                            @if($dual)
                                <a href="{{ $dual->link ?: route('categories.shop') }}" class="eb-banner eb-dual-banner">
                                    <img src="{{ $dual->image_url }}" alt="{{ $dual->title ?? 'Banner' }}" loading="lazy">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    {{-- ================= FEATURED BRANDS (after Small Appliances section) ================= --}}
    @if($featuredBrands->isNotEmpty())
        <section class="eb-block eb-brand-block">
            <div class="container">
                <div class="eb-brand-head">
                    <div>
                        <h2>Featured brands</h2>
                        <p>Authentic products from official and verified brand partners.</p>
                    </div>
                    <a href="{{ route('brands.index') }}" class="eb-brand-browse">
                        Browse all
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </a>
                </div>
                <div class="eb-brand-grid">
                    @foreach($featuredBrands as $brand)
                        <a class="eb-brand-card" href="{{ route('categories.shop', ['brands' => [$brand->slug]]) }}" title="Browse {{ $brand->name }} products">
                            @if($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" loading="lazy">
                            @endif
                            <span class="eb-brand-name">{{ $brand->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Category section 2ta'r kom hole dual banner shesh e dekhabe --}}
    @if($categorySections->count() < 2 && ($dualLeft || $dualRight))
        <section class="eb-block">
            <div class="container">
                <div class="eb-dual">
                    @foreach([$dualLeft, $dualRight] as $dual)
                        @if($dual)
                            <a href="{{ $dual->link ?: route('categories.shop') }}" class="eb-banner eb-dual-banner">
                                <img src="{{ $dual->image_url }}" alt="{{ $dual->title ?? 'Banner' }}" loading="lazy">
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ================= SEO CONTENT ================= --}}
    @include('frontend.partials.home-seo')

    <script>
        window.addEventListener('load', function () {
            if (typeof Swiper === 'undefined') return;

            // Main banner
            @if($heroMain->count() > 1)
            new Swiper('.eb-hero-slider', {
                loop: true,
                speed: 600,
                autoplay: { delay: 4500, disableOnInteraction: false },
                pagination: { el: '.eb-hero-dots', clickable: true }
            });
            @endif

            // Side banner : 2 ba beshi banner thakle sob tile slide kore
            document.querySelectorAll('.eb-side-slider').forEach(function (el) {
                if (parseInt(el.getAttribute('data-slides')) < 2) return;
                new Swiper(el, {
                    loop: true,
                    speed: 600,
                    observer: true,
                    observeParents: true,
                    autoplay: { delay: 4500, disableOnInteraction: false }
                });
            });
        });
    </script>

    @include('frontend.partials.static-area')

@endsection
