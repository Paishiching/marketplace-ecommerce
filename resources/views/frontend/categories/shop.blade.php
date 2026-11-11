@extends('layouts.frontend.app')

@section('title','Shop Details')

@section('content')

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-home.css?v=3">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-shop.css?v=2">

    @php
        // Category image helper : column er naam 'image' na hole ekhane bodlan
        $catImg = function ($c) {
            return !empty($c->image) ? asset('storage/' . $c->image) : null;
        };

        // Page heading : ?category=slug thakle oi category er naam
        $pageTitle  = 'All Products';
        $openParent = null;
        $parentObj  = null;
        if (request('category')) {
            foreach ($categories as $c) {
                if ($c->slug === request('category')) { $pageTitle = $c->name; $openParent = $c->id; $parentObj = $c; break; }
                foreach ($c->children as $ch) {
                    if ($ch->slug === request('category')) { $pageTitle = $ch->name; $openParent = $c->id; $parentObj = $c; break 2; }
                }
            }
        }

        // Sub-category tile : parent/child hole parent er children, na hole sob parent category
        if ($parentObj) { $tiles = $parentObj->children; $tilesTitle = $parentObj->name; }
        else            { $tiles = $categories;           $tilesTitle = 'Shop by Category'; }
    @endphp

    <nav class="eb-crumb" aria-label="Breadcrumb">
        <div class="container">
            <a href="{{ route('homes') }}">Home</a>
            <span>/</span>
            <span>Shop</span>
            @if($pageTitle !== 'All Products')
                <span>/</span>
                <span>{{ $pageTitle }}</span>
            @endif
        </div>
    </nav>

    <section class="eb-shop">
        <div class="container">

            <div class="eb-page-head">
                <h1>{{ $pageTitle }}</h1>
            </div>

            <div class="eb-shop-layout">

                {{-- ================= SIDEBAR ================= --}}
                <aside class="eb-side" id="ebSide">

                    <div class="eb-side-box">
                        <h3>Categories</h3>
                        @foreach($categories as $category)
                            <details class="eb-acc" {{ $openParent === $category->id ? 'open' : '' }}>
                                <summary>
                                    <span class="eb-acc-ico">
                                        @if($catImg($category))
                                            <img src="{{ $catImg($category) }}" alt="{{ $category->name }}">
                                        @else
                                            <i>{{ mb_strtoupper(mb_substr($category->name, 0, 1)) }}</i>
                                        @endif
                                    </span>
                                    <span class="eb-acc-name">{{ $category->name }}</span>
                                    <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l4 4 4-4"/></svg>
                                </summary>
                                <ul>
                                    <li>
                                        <a href="{{ route('categories.shop', ['category' => $category->slug]) }}"
                                           class="{{ request('category') == $category->slug ? 'is-active' : '' }}">All {{ $category->name }}</a>
                                    </li>
                                    @foreach($category->children as $child)
                                        <li>
                                            <a href="{{ route('categories.shop', ['category' => $child->slug]) }}"
                                               class="{{ request('category') == $child->slug ? 'is-active' : '' }}">{{ $child->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                        @endforeach
                    </div>

                    <form method="GET" action="{{ route('categories.shop') }}" id="filterForm">
                        {{-- filter korle category / sort jeno hariye na jay --}}
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <div class="eb-side-box">
                            <h3>Price</h3>
                            <div class="eb-price">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" min="0">
                                <span>–</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" min="0">
                            </div>
                            <button type="submit" class="eb-apply">Apply</button>
                        </div>

                        @if($brands->isNotEmpty())
                            <div class="eb-side-box">
                                <h3>Brand</h3>
                                <ul class="eb-check">
                                    @foreach($brands as $brand)
                                        <li>
                                            <label>
                                                <input type="checkbox" name="brands[]" value="{{ $brand->slug }}"
                                                       onchange="document.getElementById('filterForm').submit()"
                                                    {{ in_array($brand->slug, (array) request('brands', [])) ? 'checked' : '' }}>
                                                <span>{{ $brand->name }}</span>
                                                <em>({{ $brand->products_count }})</em>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>

                </aside>

                {{-- ================= PRODUCTS ================= --}}
                <div class="eb-shop-main">

                    {{-- ===== Sub-category tiles (Flipkart style) ===== --}}
                    @if($tiles->isNotEmpty())
                        <div class="eb-subcats">
                            <h2 class="eb-subcats-title">{{ $tilesTitle }}</h2>
                            <div class="eb-subcats-grid">
                                @if($parentObj)
                                    <a href="{{ route('categories.shop', ['category' => $parentObj->slug]) }}"
                                       class="eb-subcat {{ request('category') == $parentObj->slug ? 'is-active' : '' }}">
                                        <span class="eb-subcat-ico">
                                            @if($catImg($parentObj))
                                                <img src="{{ $catImg($parentObj) }}" alt="{{ $parentObj->name }}">
                                            @else
                                                <i>{{ mb_strtoupper(mb_substr($parentObj->name, 0, 1)) }}</i>
                                            @endif
                                        </span>
                                        <em>View All</em>
                                    </a>
                                @endif
                                @foreach($tiles as $tile)
                                    <a href="{{ route('categories.shop', ['category' => $tile->slug]) }}"
                                       class="eb-subcat {{ request('category') == $tile->slug ? 'is-active' : '' }}">
                                        <span class="eb-subcat-ico">
                                            @if($catImg($tile))
                                                <img src="{{ $catImg($tile) }}" alt="{{ $tile->name }}">
                                            @else
                                                <i>{{ mb_strtoupper(mb_substr($tile->name, 0, 1)) }}</i>
                                            @endif
                                        </span>
                                        <em>{{ $tile->name }}</em>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="eb-bar">
                        <button type="button" class="eb-filter-btn"
                                onclick="document.getElementById('ebSide').classList.toggle('is-open')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                            Filters
                        </button>

                        <p class="eb-count">{{ $products->total() }} Products</p>

                        <div class="eb-view nav">
                            <a class="active" href="#shop-1" data-bs-toggle="tab" aria-label="Grid view">
                                <svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                            </a>
                            <a href="#shop-2" data-bs-toggle="tab" aria-label="List view">
                                <svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="4" width="18" height="4" rx="1.5"/><rect x="3" y="10" width="18" height="4" rx="1.5"/><rect x="3" y="16" width="18" height="4" rx="1.5"/></svg>
                            </a>
                        </div>

                        <form method="GET" action="{{ route('categories.shop') }}" id="sortForm" class="eb-sort">
                            @foreach(request()->except(['sort','page']) as $key => $value)
                                @if(is_array($value))
                                    @foreach($value as $v)
                                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <label for="ebSort">Sort By:</label>
                            <select name="sort" id="ebSort" onchange="document.getElementById('sortForm').submit()">
                                <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Sort by newness</option>
                                <option value="a-z" {{ request('sort') == 'a-z' ? 'selected' : '' }}>A to Z</option>
                                <option value="z-a" {{ request('sort') == 'z-a' ? 'selected' : '' }}>Z to A</option>
                                <option value="in_stock" {{ request('sort') == 'in_stock' ? 'selected' : '' }}>In stock</option>
                            </select>
                        </form>
                    </div>

                    <div class="tab-content">
                        {{-- Grid --}}
                        <div id="shop-1" class="tab-pane active">
                            <div class="row eb-shop-row">
                                @forelse($products as $product)
                                    @include('frontend.categories.partials.product-list-item', ['product' => $product])
                                @empty
                                    <div class="col-12">
                                        <div class="eb-empty">No Products Found.</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- List --}}
                        <div id="shop-2" class="tab-pane">
                            <div class="row eb-shop-row">
                                @forelse($products as $product)
                                    @include('frontend.categories.partials.product-list-item', ['product' => $product, 'colClass' => 'col-12 eb-list-col'])
                                @empty
                                    <div class="col-12">
                                        <div class="eb-empty">No Products Found.</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="eb-pagi-wrap">
                        {{ $products->onEachSide(1)->links('pagination.custom') }}
                    </div>

                </div>
            </div>

        </div>
    </section>

@endsection