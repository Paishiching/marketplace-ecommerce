{{-- Reusable product card (electronicsbangladesh style). Home ar shop/category duto page-i eta use kore.
     Usage: @include('frontend.partials.product-card', ['product' => $product]) --}}
@php
    $attrs    = $product->getAttributes();

    // price
    $onSale   = $product->discount_price && $product->discount_price < $product->price;
    $current  = $onSale ? $product->discount_price : $product->price;
    $percent  = ($onSale && $product->price > 0)
                    ? round((($product->price - $product->discount_price) / $product->price) * 100)
                    : 0;

    // rating : controller aggregate (withCount / withAvg) dile seta, na hole (shop page) reviews relation theke
    $hasAgg   = array_key_exists('reviews_count', $attrs);
    $reviews  = $hasAgg ? (int) $attrs['reviews_count'] : (int) $product->reviews->count();
    $avgRaw   = array_key_exists('avg_rating', $attrs)
                    ? $attrs['avg_rating']
                    : ($hasAgg ? 0 : $product->reviews->avg('rating'));
    $rating   = (int) round($avgRaw ?? 0);

    $detail   = route('products.details', $product->slug);
    $fallback = asset('frontend/assets/images/imageIcon/image.jpg');
@endphp

<article class="eb-pc" data-pid="{{ $product->id }}">
    @if($percent > 0)
        <span class="eb-pc-badge">-{{ $percent }}%</span>
    @endif

    <div class="eb-pc-actions">
        {{-- .cart-btn + data-product-id = layout er cart popup JS e use hoy --}}
        <a href="#" class="eb-pc-act cart-btn" data-product-id="{{ $product->id }}" title="Add to cart" aria-label="Add to cart" @if($duplicate ?? false) tabindex="-1" @endif>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h3l2.4 11.2a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.5L21.5 7H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/></svg>
        </a>
        <a href="{{ route('wishlist.index') }}?product_id={{ $product->id }}" class="eb-pc-act eb-pc-heart" title="Add to wishlist" aria-label="Add to wishlist" @if($duplicate ?? false) tabindex="-1" @endif>
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-8-5.2-8-11a4.8 4.8 0 0 1 8-3.5A4.8 4.8 0 0 1 20 10c0 5.8-8 11-8 11z"/></svg>
        </a>
    </div>

    <a href="{{ $detail }}" class="eb-pc-img" @if($duplicate ?? false) tabindex="-1" @endif>
        <img src="{{ $product->display_image }}"
             alt="{{ $product->name }}"
             loading="lazy"
             onerror="this.onerror=null;this.src='{{ $fallback }}';">
    </a>

    <h3 class="eb-pc-name"><a href="{{ $detail }}" title="{{ $product->name }}" @if($duplicate ?? false) tabindex="-1" @endif>{{ $product->name }}</a></h3>

    <div class="eb-pc-price">
        <span class="eb-pc-now">৳ {{ number_format($current) }}</span>
        @if($onSale)
            <span class="eb-pc-old">৳ {{ number_format($product->price) }}</span>
        @endif
    </div>

    <div class="eb-pc-rate">
        <span class="eb-stars" aria-label="{{ $rating }} out of 5">
            @for($i = 1; $i <= 5; $i++)
                <svg viewBox="0 0 24 24" class="{{ $i <= $rating ? 'on' : '' }}"><path d="M12 2.5l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.4 6.1 20.5l1.2-6.5L2.5 9.4l6.6-.9z"/></svg>
            @endfor
        </span>
        <span class="eb-rate-count">({{ $reviews }})</span>
    </div>

    {{-- SKU : rating-er niche alada line, click korle specification popup --}}
    @if($product->sku)
        <button type="button" class="eb-sku-link" data-pid="{{ $product->id }}" aria-expanded="false" @if($duplicate ?? false) tabindex="-1" @endif>
            <span class="eb-sku-txt">SKU: <b>{{ $product->sku }}</b></span>
        </button>
    @endif
</article>
