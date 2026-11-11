@extends('layouts.frontend.app')

@section('title','Show Category')

@section('content')

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-home.css?v=3">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-shop.css?v=2">

    @php
        // controller $category pathale tar naam, na hole "Shop"
        $hasCat    = isset($category) && is_object($category) && !empty($category->name);
        $pageTitle = $hasCat ? $category->name : 'Shop';

        // Category image helper : column er naam 'image' na hole ekhane bodlan
        $catImg = function ($c) {
            return !empty($c->image) ? asset('storage/' . $c->image) : null;
        };

        // Sub-category tiles : nijer children, na thakle bhai-bon (parent er children)
        $tiles = collect();
        $tilesTitle = $pageTitle;
        $viewAll = null;
        if ($hasCat) {
            if (method_exists($category, 'children') && $category->children->isNotEmpty()) {
                $tiles = $category->children;
                $viewAll = $category;
            } elseif (method_exists($category, 'parent') && $category->parent && $category->parent->children->isNotEmpty()) {
                $tiles = $category->parent->children;
                $tilesTitle = $category->parent->name;
                $viewAll = $category->parent;
            }
        }
    @endphp

    <nav class="eb-crumb" aria-label="Breadcrumb">
        <div class="container">
            <a href="{{ route('homes') }}">Home</a>
            <span>/</span>
            <span>{{ $pageTitle }}</span>
        </div>
    </nav>

    <section class="eb-shop">
        <div class="container">

            <div class="eb-page-head">
                <h1>{{ $pageTitle }}</h1>
            </div>

            {{-- ===== Sub-category tiles (Flipkart style) ===== --}}
            @if($tiles->isNotEmpty())
                <div class="eb-subcats">
                    <h2 class="eb-subcats-title">{{ $tilesTitle }}</h2>
                    <div class="eb-subcats-grid">
                        @if($viewAll)
                            <a href="{{ route('categories.shop', ['category' => $viewAll->slug]) }}" class="eb-subcat">
                                <span class="eb-subcat-ico">
                                    @if($catImg($viewAll))
                                        <img src="{{ $catImg($viewAll) }}" alt="{{ $viewAll->name }}">
                                    @else
                                        <i>{{ mb_strtoupper(mb_substr($viewAll->name, 0, 1)) }}</i>
                                    @endif
                                </span>
                                <em>View All</em>
                            </a>
                        @endif
                        @foreach($tiles as $tile)
                            <a href="{{ route('categories.shop', ['category' => $tile->slug]) }}"
                               class="eb-subcat {{ $hasCat && $category->id === $tile->id ? 'is-active' : '' }}">
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
                <p class="eb-count">{{ $products->total() }} Products</p>

                <div class="eb-view nav">
                    <a class="active" href="#shop-1" data-bs-toggle="tab" aria-label="Grid view">
                        <svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                    </a>
                    <a href="#shop-2" data-bs-toggle="tab" aria-label="List view">
                        <svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="4" width="18" height="4" rx="1.5"/><rect x="3" y="10" width="18" height="4" rx="1.5"/><rect x="3" y="16" width="18" height="4" rx="1.5"/></svg>
                    </a>
                </div>

                <form method="GET" action="{{ url()->current() }}" id="sortForm" class="eb-sort">
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
                {{-- Grid (full width = 5 per row) --}}
                <div id="shop-1" class="tab-pane active">
                    <div class="row eb-shop-row">
                        @forelse($products as $product)
                            @include('frontend.categories.partials.product-list-item', ['product' => $product, 'colClass' => 'col-6 col-md-4 col-lg-3 eb-col-5'])
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
    </section>

@endsection