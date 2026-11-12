@extends('layouts.frontend.app')

@section('title', $product->name)

@section('content')
    {{-- product-card partial (.eb-pc) er style --}}
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-home.css?v=8">
    {{-- product details page er style --}}
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-product.css?v=3">

    @php
        $fallbackImg = asset('frontend/assets/images/imageIcon/image.jpg');

        // gallery : thumbnail + extra images
        $gallery = collect([asset('storage/' . $product->thumbnail)])
            ->merge($product->productImages->map(fn ($img) => asset('storage/' . $img->image_path)))
            ->values();

        // stock + price
        $stockQty  = (int) $product->productVariants->sum('stock_quantity');
        $inStock   = $stockQty > 0;
        $onSale    = (bool) $product->is_on_sale;
        $unitPrice = $onSale ? $product->discount_price : $product->price;
        $percent   = ($onSale && $product->price > 0)
                        ? round((($product->price - $product->discount_price) / $product->price) * 100)
                        : 0;

        // rating
        $reviewCount = $product->reviews->count();
        $avgRaw      = $product->reviews->avg('rating') ?? 0;
        $avgRating   = (int) round($avgRaw);

        // Questions (questions er data/relation thakle ekhane count boshan)
        $questionCount = 0;

        // right sidebar products
        $sideProducts = $relatedProducts->take(8);
        $hasSide      = $sideProducts->count() > 0;

        // Specification table : admin-e deya spec gulo (product_specifications table) theke.
        // Kono spec na thakle fallback hishebe Brand / Category / SKU dekhabe.
        $dbSpecs = $product->productSpecifications
            ->mapWithKeys(fn ($s) => [$s->name => $s->value])
            ->all();

        $specGroups = count($dbSpecs)
            ? ['Specification' => $dbSpecs]
            : [
                'General Information' => array_filter([
                    'Brand'        => $product->brand->name ?? null,
                    'Category'     => $product->category->name ?? null,
                    'SKU'          => $product->sku,
                    'Product Type' => $product->product_type ? ucfirst($product->product_type) : null,
                ]),
            ];

        $warrantyText = $product->warranty ?: $product->productSpecifications
            ->first(fn ($spec) => str_contains(strtolower((string) $spec->name), 'warranty'))?->value;
        $emiPlans = $product->productEmiPlans->where('is_active', true)->values();
        $emiBanks = $emiPlans->groupBy('bank_name');

        $starSvg  = '<svg viewBox="0 0 24 24"><path d="M12 2.5l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.4 6.1 20.5l1.2-6.5L2.5 9.4l6.6-.9z"/></svg>';
        $shareUrl = urlencode(url()->current());
        $whatsappNumber = preg_replace('/[^0-9]/', '', (string) ($site->whatsapp_number ?? ''));
        $chatMessage = "Hello Buydor BD, I want to know more about {$product->name}" . ($product->sku ? " (SKU: {$product->sku})" : '') . '. ' . url()->current();
        $productChatUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . rawurlencode($chatMessage);
        $emiMessage = "Hello Buydor BD, please share the current EMI plans for {$product->name}" . ($product->sku ? " (SKU: {$product->sku})" : '') . '. ' . url()->current();

        // ---------- Sponsored popup : video (optional) + offer images ----------
        $slides = [];
        $sponsoredUrl = trim((string) ($product->sponsored_video_url ?? ''));

        if ($sponsoredUrl !== '') {
            if (preg_match('~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $sponsoredUrl, $m)) {
                $slides[] = ['type' => 'embed', 'src' => 'https://www.youtube.com/embed/' . $m[1] . '?rel=0'];
            } elseif (preg_match('~vimeo\.com/(\d+)~', $sponsoredUrl, $m)) {
                $slides[] = ['type' => 'embed', 'src' => 'https://player.vimeo.com/video/' . $m[1]];
            } elseif (preg_match('~^https?://.+\.(mp4|webm)(\?.*)?$~i', $sponsoredUrl)) {
                $slides[] = ['type' => 'file', 'src' => $sponsoredUrl];
            }
        }

        foreach ($product->offerImages as $offerImg) {
            $slides[] = ['type' => 'image', 'src' => asset('storage/' . $offerImg->image_path)];
        }

        $hasSponsored = count($slides) > 0;
    @endphp

    <div class="pd-page">

        {{-- ================= BREADCRUMB ================= --}}
        <nav class="pd-crumb">
            <div class="container">
                <a href="{{ route('homes') }}">Home</a>
                @if($product->category)
                    <span>/</span>
                    <a href="{{ route('categories.shop', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                @endif
                <span>/</span>
                <span class="pd-crumb-now">{{ $product->name }}</span>
            </div>
        </nav>

        {{-- ================= TOP : gallery + info (one white card) ================= --}}
        <div class="container">
            <div class="pd-card pd-top">
                <div class="row g-4">

                    {{-- ---------- Gallery ---------- --}}
                    <div class="col-lg-5">
                        <div class="pd-gallery">
                            @if($gallery->count() > 1)
                                <div class="pd-thumbs">
                                    @foreach($gallery as $src)
                                        <div class="pd-thumb {{ $loop->first ? 'active' : '' }}">
                                            <img src="{{ $src }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ $fallbackImg }}';">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="pd-main" id="mainImageBox">
                                <img src="{{ $gallery->first() }}" alt="{{ $product->name }}" id="mainProductImage"
                                     onerror="this.onerror=null;this.src='{{ $fallbackImg }}';">
                            </div>
                        </div>
                        <a class="pd-gallery-chat" href="{{ $productChatUrl }}" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.52 3.48A11.85 11.85 0 0 0 12.07 0C5.5 0 .16 5.34.16 11.91c0 2.1.55 4.15 1.59 5.96L.06 24l6.28-1.65a11.9 11.9 0 0 0 5.72 1.46h.01c6.57 0 11.91-5.34 11.92-11.91a11.85 11.85 0 0 0-3.47-8.42ZM12.07 21.8a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.73.98.99-3.64-.24-.37a9.88 9.88 0 1 1 8.38 4.62Zm5.42-7.4c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.66.15-.2.3-.76.96-.93 1.16-.17.2-.34.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.04-.17-.3-.02-.46.13-.61.13-.13.3-.34.45-.51.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.66-1.6-.9-2.2-.24-.58-.48-.5-.66-.51h-.56c-.2 0-.52.07-.79.37-.27.3-1.03 1.01-1.03 2.46 0 1.45 1.06 2.85 1.2 3.05.14.2 2.08 3.18 5.03 4.46.7.3 1.24.48 1.66.62.7.22 1.33.19 1.83.12.56-.08 1.75-.72 2-1.42.25-.7.25-1.3.18-1.42-.08-.13-.27-.2-.57-.35Z"/></svg>
                            <span>Chat Now on WhatsApp</span>
                        </a>
                    </div>

                    {{-- ---------- Product info ---------- --}}
                    <div class="col-lg-7">
                        <div class="pd-info">

                            <div class="pd-title-row">
                                <h1 class="pd-title">{{ $product->name }}</h1>
                                <div class="pd-quick">
                                    <a href="{{ route('compare.index') }}?product_id={{ $product->id }}" class="pd-pill" title="Add to compare">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3l4 4-4 4"/><path d="M3 7h18"/><path d="M7 21l-4-4 4-4"/><path d="M21 17H3"/></svg>
                                        Compare
                                    </a>
                                    <a href="{{ route('wishlist.index') }}?product_id={{ $product->id }}" class="pd-icon-btn" title="Add to wishlist" aria-label="Add to wishlist">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-8-5.2-8-11a4.8 4.8 0 0 1 8-3.5A4.8 4.8 0 0 1 20 10c0 5.8-8 11-8 11z"/></svg>
                                    </a>
                                </div>
                            </div>

                            <div class="pd-meta">
                                @if($product->brand)
                                    <span>Brand : <b>{{ $product->brand->name }}</b></span>
                                @endif
                                @if($product->sku)
                                    <span>Reference : <b>{{ $product->sku }}</b></span>
                                @endif
                                @if($product->model_number)
                                    <span>Model : <b>{{ $product->model_number }}</b></span>
                                @endif
                            </div>

                            <div class="pd-rate">
                                <span class="pd-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="pd-star {{ $i <= $avgRating ? 'on' : '' }}">{!! $starSvg !!}</span>
                                    @endfor
                                </span>
                                <a href="#sec-reviews" class="pd-reviews-link">({{ $reviewCount }} Customer reviews)</a>
                            </div>

                            {{-- price --}}
                            <div class="pd-price-row">
                                <span class="pd-price" id="unitPriceDisplay" data-unit-price="{{ $unitPrice }}">৳ {{ number_format($unitPrice) }}</span>
                                @if($onSale)
                                    <span class="pd-old">৳ {{ number_format($product->price) }}</span>
                                    <span class="pd-off">-{{ $percent }}% OFF</span>
                                @endif
                                <span class="pd-stock {{ $inStock ? 'is-in' : 'is-out' }}">{{ $inStock ? 'In Stock' : 'Out of Stock' }}</span>
                            </div>

                            @if($emiPlans->isNotEmpty())
                                <div class="pd-finance-row">
                                    <span><strong>EMI Available</strong></span>
                                    <button type="button" id="openEmiPlans">View Plans <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button>
                                </div>
                            @endif
                            @if($warrantyText)
                                <div class="pd-warranty-row"><span><strong>Warranty:</strong> {{ $warrantyText }}</span></div>
                            @endif

                            @if(!empty($product->short_description))
                                <div class="pd-short">{!! $product->short_description !!}</div>
                            @endif

                            {{-- color / size --}}
                            @if($product->colorValues->count() || $product->sizeValues->count())
                                <div class="pd-variants">
                                    @if($product->colorValues->count())
                                        <div class="pd-variant">
                                            <span class="pd-label">Color</span>
                                            <div class="pd-swatches">
                                                @foreach($product->colorValues as $i => $color)
                                                    <button type="button" class="pd-swatch {{ $i === 0 ? 'is-selected' : '' }}"
                                                            data-color="{{ $color->value }}" title="{{ $color->value }}"
                                                            style="background:{{ $color->value }};"></button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if($product->sizeValues->count())
                                        <div class="pd-variant">
                                            <span class="pd-label">Size</span>
                                            <div class="pd-sizes">
                                                @foreach($product->sizeValues as $i => $size)
                                                    <button type="button" class="pd-size {{ $i === 0 ? 'is-selected' : '' }}">{{ $size->value }}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- quantity (left) + share (right) --}}
                            <div class="pd-qty-share">
                                <div class="pd-qty-row">
                                    <span class="pd-label">Quantity:</span>
                                    <div class="pd-qty">
                                        <button type="button" id="qtyMinus" aria-label="Decrease quantity">&minus;</button>
                                        <input type="text" inputmode="numeric" value="1" id="qtyInput" data-stock="{{ $stockQty }}">
                                        <button type="button" id="qtyPlus" aria-label="Increase quantity">+</button>
                                    </div>
                                    @if($inStock)
                                        <span class="pd-avail">{{ $stockQty }} available</span>
                                    @endif
                                </div>

                                <div class="pd-share">
                                    <span class="pd-label">Share:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on Facebook">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                                    </a>
                                    <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0v1a5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></svg>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on X">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
                                    </a>
                                    <button type="button" id="copyLinkBtn" aria-label="Copy link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="8" width="14" height="14" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="pd-total" id="totalPriceBox">
                                <strong>Total:</strong>
                                <span id="totalPriceDisplay">৳ {{ number_format($unitPrice) }}</span>
                            </div>

                            {{-- desktop buttons (mobile e niche sticky bar) --}}
                            <div class="pd-actions d-none d-lg-flex">
                                <button type="button" class="pd-btn pd-btn-cart js-add-to-cart" data-product-id="{{ $product->id }}" {{ $inStock ? '' : 'disabled' }}>Add To Cart</button>
                                <button type="button" class="pd-btn pd-btn-buy js-buy-now" data-product-id="{{ $product->id }}" {{ $inStock ? '' : 'disabled' }}>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 7h12l1 13H5z"/><path d="M9 7a3 3 0 0 1 6 0"/></svg>
                                    Buy Now
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================= BODY : sections (left) + products (right) ================= --}}
        <div class="container pd-body">
            <div class="row g-3">

                <div class="col-lg-{{ $hasSide ? 9 : 12 }}">

                    {{-- section nav (click = scroll to section) --}}
                    <div class="pd-tabs" id="pdTabs">
                        @if($hasSponsored)
                            <button type="button" class="pd-tab-sponsored" id="sponsoredBtn">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.4 6.1 20.5l1.2-6.5L2.5 9.4l6.6-.9z"/></svg>
                                Sponsored
                            </button>
                        @endif
                        <a class="active" href="#sec-spec">Specification</a>
                        <a href="#sec-desc">Description</a>
                        <a href="#sec-questions">Questions</a>
                        <a href="#sec-reviews">Reviews</a>
                    </div>

                    {{-- ---------- Specification ---------- --}}
                    <section class="pd-card pd-section" id="sec-spec">
                        <h3 class="pd-h">Specification</h3>
                        <table class="pd-spec-table">
                            <tbody>
                                @foreach($specGroups as $groupName => $rows)
                                    @if(count($rows))
                                        <tr class="pd-spec-group"><td colspan="2">{{ $groupName }}</td></tr>
                                        @foreach($rows as $label => $value)
                                            <tr><th>{{ $label }}</th><td>{{ $value }}</td></tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </section>

                    {{-- ---------- Descriptions ---------- --}}
                    <section class="pd-card pd-section" id="sec-desc">
                        <h3 class="pd-h">Descriptions</h3>
                        <div class="pd-desc">
                            @if(!empty($product->description))
                                {!! $product->description !!}
                            @else
                                <p class="pd-muted">No description available.</p>
                            @endif
                        </div>
                    </section>

                    {{-- ---------- Questions ---------- --}}
                    <section class="pd-card pd-section" id="sec-questions">
                        <div class="pd-sec-head">
                            <div>
                                <h3 class="pd-h">Questions ({{ $questionCount }})</h3>
                                <p class="pd-sub">Have question about this product? Get specific details about this product from expert.</p>
                            </div>
                            <button type="button" class="pd-outline-btn" id="askToggle">Ask Question</button>
                        </div>

                        <form action="#" method="POST" class="pd-form pd-collapsible" id="askForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <textarea name="question" rows="3" placeholder="Write your question"></textarea>
                            <button type="submit" class="pd-btn pd-btn-buy pd-btn-auto">Submit Question</button>
                        </form>

                        <div class="pd-empty">
                            <span class="pd-empty-ico">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.3-4.7A8 8 0 1 1 21 12z"/><circle cx="8.5" cy="12" r="1.2" fill="#fff"/><circle cx="12.5" cy="12" r="1.2" fill="#fff"/><circle cx="16.5" cy="12" r="1.2" fill="#fff"/></svg>
                            </span>
                            <p>There are no questions asked yet. Be the first one to ask a question.</p>
                        </div>
                    </section>

                    {{-- ---------- Reviews ---------- --}}
                    <section class="pd-card pd-section" id="sec-reviews">
                        <div class="pd-sec-head">
                            <div>
                                <h3 class="pd-h">Reviews ({{ $reviewCount }})</h3>
                                <p class="pd-sub">Ratings &amp; Reviews of {{ $product->name }}</p>
                            </div>
                            <button type="button" class="pd-outline-btn" id="reviewToggle">Write a Review</button>
                        </div>

                        <form action="#" method="POST" class="pd-form pd-collapsible" id="reviewForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="rating" id="ratingInput" value="">

                            <div class="pd-star-pick">
                                <span>Your rating:</span>
                                <span class="pd-stars" id="starPick">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" class="pd-star" data-value="{{ $i }}" aria-label="{{ $i }} star">{!! $starSvg !!}</button>
                                    @endfor
                                </span>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6"><input type="text" name="name" placeholder="Name"></div>
                                <div class="col-md-6"><input type="email" name="email" placeholder="Email"></div>
                                <div class="col-12"><textarea name="comment" rows="4" placeholder="Message"></textarea></div>
                                <div class="col-12"><button type="submit" class="pd-btn pd-btn-buy pd-btn-auto">Submit Review</button></div>
                            </div>
                        </form>

                        {{-- summary --}}
                        <div class="pd-rating-box">
                            <div class="pd-rating-avg">
                                <div class="pd-avg-num">{{ number_format($avgRaw, 1) }}<small>/5</small></div>
                                <span class="pd-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="pd-star {{ $i <= $avgRating ? 'on' : '' }}">{!! $starSvg !!}</span>
                                    @endfor
                                </span>
                                <span class="pd-avg-note">{{ $reviewCount }} {{ \Illuminate\Support\Str::plural('Rating', $reviewCount) }}</span>
                            </div>

                            <div class="pd-rating-bars">
                                @for ($n = 5; $n >= 1; $n--)
                                    @php
                                        $cnt = $product->reviews->where('rating', $n)->count();
                                        $pct = $reviewCount > 0 ? round(($cnt / $reviewCount) * 100) : 0;
                                    @endphp
                                    <div class="pd-bar-row">
                                        <span class="pd-stars pd-stars-sm">
                                            @for ($s = 1; $s <= 5; $s++)
                                                <span class="pd-star {{ $s <= $n ? 'on' : '' }}">{!! $starSvg !!}</span>
                                            @endfor
                                        </span>
                                        <span class="pd-bar"><i style="width:{{ $pct }}%"></i></span>
                                        <span class="pd-bar-cnt">{{ $cnt }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- review list (scrollable) --}}
                        @if($reviewCount)
                            <div class="pd-review-list">
                                @foreach($product->reviews as $review)
                                    <div class="pd-review">
                                        <span class="pd-avatar">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="3.5"/><path d="M5 20c1-4 4-5.5 7-5.5s6 1.5 7 5.5"/></svg>
                                        </span>
                                        <div class="pd-review-body">
                                            <div class="pd-review-head">
                                                <strong>{{ $review->customer_name ?? 'Anonymous' }}</strong>
                                                <span class="pd-review-meta">
                                                    <span class="pd-stars pd-stars-sm">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span class="pd-star {{ $i <= $review->rating ? 'on' : '' }}">{!! $starSvg !!}</span>
                                                        @endfor
                                                    </span>
                                                    <span class="pd-review-date">{{ optional($review->created_at)->format('F j, Y') }}</span>
                                                </span>
                                            </div>
                                            <p>{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="pd-muted pd-no-review">No reviews yet. Be the first to review this product!</p>
                        @endif
                    </section>

                </div>{{-- /left column --}}

                {{-- ---------- Right sidebar : products ---------- --}}
                @if($hasSide)
                    <div class="col-lg-3">
                        <aside class="pd-card pd-side">
                            <h4 class="pd-side-title">Related Products</h4>
                            <div class="pd-side-list">
                                @foreach($sideProducts as $sideProduct)
                                    @include('frontend.partials.product-card', ['product' => $sideProduct])
                                @endforeach
                            </div>
                        </aside>
                    </div>
                @endif

            </div>
        </div>

        {{-- ================= MOBILE STICKY BAR ================= --}}
        <div class="pd-sticky">
            <button type="button" class="pd-btn pd-btn-cart js-add-to-cart" data-product-id="{{ $product->id }}" {{ $inStock ? '' : 'disabled' }}>Add To Cart</button>
            <button type="button" class="pd-btn pd-btn-buy js-buy-now" data-product-id="{{ $product->id }}" {{ $inStock ? '' : 'disabled' }}>Buy Now</button>
        </div>

        @if($emiPlans->isNotEmpty())
            <dialog class="pd-emi-dialog" id="emiPlansDialog" aria-labelledby="emiDialogTitle">
                <div class="pd-emi-dialog-head"><div><span class="pd-emi-kicker">{{ $product->name }}</span><h2 id="emiDialogTitle">EMI Options</h2></div><button type="button" id="closeEmiPlans" aria-label="Close EMI plans">&times;</button></div>
                <div class="pd-emi-modal-layout">
                    <div class="pd-emi-bank-list" role="tablist" aria-label="Select bank">
                        @foreach($emiBanks as $bankName => $plans)
                            <button type="button" class="pd-emi-bank {{ $loop->first ? 'is-active' : '' }}" data-bank="{{ $loop->index }}" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $bankName }}</button>
                        @endforeach
                    </div>
                    <div class="pd-emi-plan-panels">
                        @foreach($emiBanks as $bankName => $plans)
                            <section class="pd-emi-bank-panel {{ $loop->first ? 'is-active' : '' }}" data-bank-panel="{{ $loop->index }}" role="tabpanel">
                                <h3>{{ $bankName }}</h3>
                                @foreach($plans as $plan)
                                    @php
                                        $monthly = ((float) $unitPrice * (1 + ((float) $plan->fee_percentage / 100))) / max(1, (int) $plan->tenure_months);
                                    @endphp
                                    <div class="pd-emi-plan-row">
                                        <span><strong>{{ $plan->tenure_months }} EMIs</strong><small>Convenience fee {{ number_format((float) $plan->fee_percentage, 2) }}%</small></span>
                                        <b>৳ {{ number_format($monthly, 2) }}<small>/ month</small></b>
                                    </div>
                                @endforeach
                            </section>
                        @endforeach
                    </div>
                </div>
                <p class="pd-emi-disclaimer">Monthly amounts are estimates based on the plan configured for this product. Your bank may apply its own final terms and charges.</p>
            </dialog>
            <script>
                (function(){var dialog=document.getElementById('emiPlansDialog'),open=document.getElementById('openEmiPlans'),close=document.getElementById('closeEmiPlans');if(!dialog||!open||!close)return;open.addEventListener('click',function(){if(dialog.showModal)dialog.showModal();});close.addEventListener('click',function(){dialog.close();});dialog.addEventListener('click',function(event){if(event.target===dialog)dialog.close();});dialog.querySelectorAll('.pd-emi-bank').forEach(function(button){button.addEventListener('click',function(){var key=this.dataset.bank;dialog.querySelectorAll('.pd-emi-bank').forEach(function(item){var active=item===button;item.classList.toggle('is-active',active);item.setAttribute('aria-selected',active?'true':'false');});dialog.querySelectorAll('.pd-emi-bank-panel').forEach(function(panel){panel.classList.toggle('is-active',panel.dataset.bankPanel===key);});});});})();
            </script>
        @endif

        {{-- ================= SPONSORED POPUP (video + offer images) ================= --}}
        @if($hasSponsored)
            <div class="pd-modal" id="spModal" aria-hidden="true">
                <div class="pd-modal-box" role="dialog" aria-modal="true" aria-label="Sponsored offers">
                    <button type="button" class="pd-modal-x" id="spClose" aria-label="Close">&times;</button>
                    <h4 class="pd-modal-title">Sponsored Offers</h4>

                    <div class="pd-sp-stage">
                        @if(count($slides) > 1)
                            <button type="button" class="pd-sp-nav pd-sp-prev" id="spPrev" aria-label="Previous">&#8249;</button>
                            <button type="button" class="pd-sp-nav pd-sp-next" id="spNext" aria-label="Next">&#8250;</button>
                        @endif

                        <div class="pd-sp-slides">
                            @foreach($slides as $s)
                                <div class="pd-sp-slide {{ $loop->first ? 'is-on' : '' }}">
                                    @if($s['type'] === 'embed')
                                        <iframe data-src="{{ $s['src'] }}" title="Sponsored video" allow="accelerometer; encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>
                                    @elseif($s['type'] === 'file')
                                        <video data-src="{{ $s['src'] }}" controls preload="none" playsinline></video>
                                    @else
                                        <img src="{{ $s['src'] }}" alt="Offer {{ $loop->iteration }}" loading="lazy">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if(count($slides) > 1)
                        <div class="pd-sp-thumbs">
                            @foreach($slides as $s)
                                <button type="button" class="pd-sp-thumb {{ $loop->first ? 'active' : '' }}" aria-label="Slide {{ $loop->iteration }}">
                                    @if($s['type'] === 'image')
                                        <img src="{{ $s['src'] }}" alt="">
                                    @else
                                        <svg class="pd-sp-play" viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M8 5v14l11-7z"/></svg>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <script>
        (function () {
            var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            function notify(title, msg, type) {
                if (typeof showToast === 'function') showToast(title, msg, type);
                else alert(msg);
            }

            // ---------- Gallery : thumbnail click ----------
            var mainImg = document.getElementById('mainProductImage');
            var mainBox = document.getElementById('mainImageBox');
            document.querySelectorAll('.pd-thumb').forEach(function (th) {
                th.addEventListener('click', function () {
                    var img = th.querySelector('img');
                    if (img) mainImg.src = img.src;
                    document.querySelectorAll('.pd-thumb').forEach(function (t) { t.classList.remove('active'); });
                    th.classList.add('active');
                });
            });

            // ---------- Hover zoom (desktop only) ----------
            if (window.matchMedia('(hover: hover) and (min-width: 992px)').matches) {
                mainBox.addEventListener('mousemove', function (e) {
                    var r = mainBox.getBoundingClientRect();
                    var x = ((e.clientX - r.left) / r.width) * 100;
                    var y = ((e.clientY - r.top) / r.height) * 100;
                    mainImg.style.transformOrigin = x + '% ' + y + '%';
                    mainImg.style.transform = 'scale(2)';
                });
                mainBox.addEventListener('mouseleave', function () {
                    mainImg.style.transform = 'scale(1)';
                    mainImg.style.transformOrigin = 'center center';
                });
            }

            // ---------- Quantity + total ----------
            var qtyInput = document.getElementById('qtyInput');
            var stockQty = parseInt(qtyInput.getAttribute('data-stock')) || 0;
            var unitPriceEl = document.getElementById('unitPriceDisplay');
            var unitPrice = parseFloat(unitPriceEl ? unitPriceEl.getAttribute('data-unit-price') : 0) || 0;
            var totalPriceEl = document.getElementById('totalPriceDisplay');
            var totalPriceBox = document.getElementById('totalPriceBox');

            function formatMoney(num) {
                return '৳ ' + num.toLocaleString('en-US', { maximumFractionDigits: 0 });
            }
            function updateTotalPrice() {
                var qty = parseInt(qtyInput.value) || 1;
                if (qty < 1) qty = 1;
                totalPriceEl.textContent = formatMoney(unitPrice * qty);
                totalPriceBox.classList.toggle('is-visible', qty > 1);
            }

            document.getElementById('qtyPlus').addEventListener('click', function () {
                var val = parseInt(qtyInput.value) || 1;
                if (val < stockQty) {
                    qtyInput.value = val + 1;
                } else {
                    notify('Stock Limit', 'Sorry, only ' + stockQty + ' items available in stock.', 'error');
                }
                updateTotalPrice();
            });
            document.getElementById('qtyMinus').addEventListener('click', function () {
                var val = parseInt(qtyInput.value) || 1;
                if (val > 1) qtyInput.value = val - 1;
                updateTotalPrice();
            });
            qtyInput.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
                var val = parseInt(this.value) || 1;
                if (val > stockQty) {
                    this.value = stockQty;
                    notify('Stock Limit', 'Sorry, only ' + stockQty + ' items available in stock.', 'error');
                }
                updateTotalPrice();
            });
            updateTotalPrice();

            // ---------- Cart helpers ----------
            function addToCart(productId, qty) {
                return fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        variant_id: null, // variant selector backend e connect hole ekhane variant_id boshbe
                        quantity: qty
                    })
                }).then(function (res) { return res.json(); });
            }

            function updateCartCountBadge(count) {
                var cartIcon = document.getElementById('cartIconLink');
                if (cartIcon) cartIcon.setAttribute('data-number', count);
            }

            // Add to cart (desktop button + mobile sticky bar)
            document.querySelectorAll('.js-add-to-cart').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var original = btn.innerHTML;
                    var qty = parseInt(qtyInput.value) || 1;
                    btn.disabled = true;
                    btn.textContent = 'Adding...';

                    addToCart(btn.getAttribute('data-product-id'), qty)
                        .then(function (data) {
                            btn.disabled = false;
                            btn.innerHTML = original;
                            if (data.success) {
                                updateCartCountBadge(data.cart_count);
                                notify('Added to Cart', 'Product has been added to your cart.', 'success');
                                if (window.loadMiniCart) loadMiniCart(true);
                            } else {
                                notify('Error', data.message || 'Could not add to cart.', 'error');
                            }
                        })
                        .catch(function () {
                            btn.disabled = false;
                            btn.innerHTML = original;
                            notify('Error', 'Something went wrong. Please try again.', 'error');
                        });
                });
            });

            // Buy now (add to cart -> checkout)
            document.querySelectorAll('.js-buy-now').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var qty = parseInt(qtyInput.value) || 1;
                    btn.disabled = true;

                    addToCart(btn.getAttribute('data-product-id'), qty)
                        .then(function (data) {
                            if (data.success) {
                                window.location.href = "{{ route('checkout.index') }}";
                            } else {
                                btn.disabled = false;
                                notify('Error', data.message || 'Could not process. Please try again.', 'error');
                            }
                        })
                        .catch(function () {
                            btn.disabled = false;
                            notify('Error', 'Something went wrong. Please try again.', 'error');
                        });
                });
            });

            // ---------- Color / size selection ----------
            document.querySelectorAll('.pd-swatch').forEach(function (s) {
                s.addEventListener('click', function () {
                    document.querySelectorAll('.pd-swatch').forEach(function (x) { x.classList.remove('is-selected'); });
                    s.classList.add('is-selected');
                });
            });
            document.querySelectorAll('.pd-size').forEach(function (b) {
                b.addEventListener('click', function () {
                    document.querySelectorAll('.pd-size').forEach(function (x) { x.classList.remove('is-selected'); });
                    b.classList.add('is-selected');
                });
            });

            // ---------- Section nav : click = smooth scroll, scroll = highlight ----------
            var tabLinks = Array.prototype.slice.call(document.querySelectorAll('#pdTabs a'));
            var sections = tabLinks.map(function (a) { return document.querySelector(a.getAttribute('href')); });

            function setActive(index) {
                tabLinks.forEach(function (a, i) { a.classList.toggle('active', i === index); });
            }
            tabLinks.forEach(function (a, i) {
                a.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (sections[i]) sections[i].scrollIntoView({ behavior: 'smooth', block: 'start' });
                    setActive(i);
                });
            });

            var ticking = false;
            window.addEventListener('scroll', function () {
                if (ticking) return;
                ticking = true;
                window.requestAnimationFrame(function () {
                    var current = 0;
                    sections.forEach(function (s, i) {
                        if (s && s.getBoundingClientRect().top <= 170) current = i;
                    });
                    setActive(current);
                    ticking = false;
                });
            }, { passive: true });

            // "(N Customer reviews)" link -> Reviews section
            var reviewsLink = document.querySelector('.pd-reviews-link');
            if (reviewsLink) {
                reviewsLink.addEventListener('click', function (e) {
                    e.preventDefault();
                    var target = document.getElementById('sec-reviews');
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }

            // ---------- Ask Question / Write a Review toggles ----------
            function bindToggle(btnId, formId) {
                var btn = document.getElementById(btnId);
                var form = document.getElementById(formId);
                if (!btn || !form) return;
                btn.addEventListener('click', function () {
                    form.classList.toggle('is-open');
                });
            }
            bindToggle('askToggle', 'askForm');
            bindToggle('reviewToggle', 'reviewForm');

            // ---------- Review star picker ----------
            var starPick = document.getElementById('starPick');
            var ratingInput = document.getElementById('ratingInput');
            if (starPick) {
                var starBtns = starPick.querySelectorAll('.pd-star');
                starBtns.forEach(function (sb) {
                    sb.addEventListener('click', function () {
                        var v = parseInt(sb.getAttribute('data-value'));
                        ratingInput.value = v;
                        starBtns.forEach(function (x) {
                            x.classList.toggle('on', parseInt(x.getAttribute('data-value')) <= v);
                        });
                    });
                });
            }

            // ---------- Copy link ----------
            var copyBtn = document.getElementById('copyLinkBtn');
            if (copyBtn) {
                copyBtn.addEventListener('click', function () {
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(window.location.href).then(function () {
                            notify('Link copied', 'Product link copied to clipboard.', 'success');
                        });
                    }
                });
            }
        })();
    </script>

    {{-- ================= Sponsored popup script ================= --}}
    <script>
        (function () {
            var btn   = document.getElementById('sponsoredBtn');
            var modal = document.getElementById('spModal');
            if (!btn || !modal) return;

            var slides = Array.prototype.slice.call(modal.querySelectorAll('.pd-sp-slide'));
            var thumbs = Array.prototype.slice.call(modal.querySelectorAll('.pd-sp-thumb'));
            var cur = 0;

            // video ba iframe khali kore (close korle video bondho hoye jay)
            function stopMedia() {
                slides.forEach(function (s) {
                    var f = s.querySelector('iframe');
                    if (f) f.removeAttribute('src');
                    var v = s.querySelector('video');
                    if (v) v.pause();
                });
            }

            function show(i) {
                cur = (i + slides.length) % slides.length;

                slides.forEach(function (s, k) {
                    var on = (k === cur);
                    s.classList.toggle('is-on', on);

                    var f = s.querySelector('iframe');
                    if (f) {
                        if (on) { if (!f.getAttribute('src')) f.setAttribute('src', f.getAttribute('data-src')); }
                        else    { f.removeAttribute('src'); }
                    }

                    var v = s.querySelector('video');
                    if (v) {
                        if (on) { if (!v.getAttribute('src')) v.setAttribute('src', v.getAttribute('data-src')); }
                        else    { v.pause(); }
                    }
                });

                thumbs.forEach(function (t, k) { t.classList.toggle('active', k === cur); });
            }

            function open() {
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
                show(0);
            }

            function close() {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                stopMedia();
            }

            btn.addEventListener('click', open);
            document.getElementById('spClose').addEventListener('click', close);

            var prev = document.getElementById('spPrev');
            var next = document.getElementById('spNext');
            if (prev) prev.addEventListener('click', function () { show(cur - 1); });
            if (next) next.addEventListener('click', function () { show(cur + 1); });

            thumbs.forEach(function (t, k) {
                t.addEventListener('click', function () { show(k); });
            });

            // bahire click korle bondho
            modal.addEventListener('click', function (e) { if (e.target === modal) close(); });

            document.addEventListener('keydown', function (e) {
                if (!modal.classList.contains('is-open')) return;
                if (e.key === 'Escape') close();
                if (e.key === 'ArrowLeft')  show(cur - 1);
                if (e.key === 'ArrowRight') show(cur + 1);
            });
        })();
    </script>

@endsection
