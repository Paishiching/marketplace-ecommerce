@extends('layouts.frontend.app')

@section('title', 'Cart')

@section('content')

    <style>
        /* ===== Cart (ct) : only 3 colors => #2a3582 navy | #fd6801 orange | #ffffff white ===== */
        .ct-page{
            --ct-navy:#2a3582;
            --ct-navy-rgb:42,53,130;
            --ct-orange:#fd6801;
            --ct-orange-rgb:253,104,1;
            --ct-line:rgba(42,53,130,.16);
            --ct-tint:rgba(42,53,130,.07);
            background:var(--ct-tint);
            color:var(--ct-navy);
            padding:22px 0 50px;
            font-family:'Poppins','Open Sans',sans-serif;
        }
        .ct-page a{text-decoration:none}

        .ct-grid{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:0;align-items:start}

        /* ---------- Left : cart table ---------- */
        .ct-left{background:#fff;padding:20px 22px 22px;min-height:340px;display:flex;flex-direction:column}
        .ct-title{display:flex;align-items:center;gap:10px;margin-bottom:14px}
        .ct-title svg{width:28px;height:28px;color:var(--ct-navy)}
        .ct-title h1{margin:0;font-size:17px;font-weight:700;color:var(--ct-navy)}

        .ct-thead,.ct-item{display:grid;grid-template-columns:minmax(0,1fr) 120px 130px 110px;gap:14px;align-items:center}
        .ct-thead{padding:10px 0;border-top:1px solid var(--ct-line);border-bottom:1px solid var(--ct-line);font-size:11px;font-weight:600;color:rgba(var(--ct-navy-rgb),.65)}
        .ct-thead span:nth-child(1){text-align:left}
        .ct-thead span:nth-child(n+2){text-align:center}
        .ct-thead span:nth-child(4){text-align:right}

        .ct-item{padding:16px 0;border-bottom:1px solid var(--ct-line)}
        .ct-prod{display:flex;align-items:flex-start;gap:12px;min-width:0}
        .ct-thumb{flex:0 0 64px;width:64px;height:64px;border:1px solid var(--ct-line);border-radius:4px;overflow:hidden;background:#fff;display:block}
        .ct-thumb img{width:100%;height:100%;object-fit:cover}
        .ct-info{min-width:0}
        .ct-name{display:block;font-size:12.5px;font-weight:600;line-height:1.5;color:var(--ct-navy);word-break:break-word}
        .ct-name:hover{color:var(--ct-orange)}
        .ct-brand{display:block;margin-top:4px;font-size:11px;color:rgba(var(--ct-navy-rgb),.7)}
        .ct-variant{display:inline-block;margin-top:4px;padding:1px 8px;border-radius:50px;background:var(--ct-tint);color:var(--ct-navy);font-size:11px;font-weight:600}

        .ct-price{text-align:center;font-size:13px;font-weight:700;color:var(--ct-navy);white-space:nowrap}

        .ct-qty{display:inline-flex;align-items:center;justify-content:center;gap:8px;justify-self:center}
        .ct-qty button{width:22px!important;height:22px!important;border:1.5px solid var(--ct-navy)!important;border-radius:50%!important;background:#fff!important;color:var(--ct-navy)!important;font-size:15px!important;font-weight:700!important;line-height:1!important;padding:0!important;display:inline-flex!important;align-items:center;justify-content:center;cursor:pointer;box-shadow:none!important;transition:all .2s}
        .ct-qty button:hover{background:var(--ct-navy)!important;color:#fff!important}
        .ct-qty input{width:34px!important;height:26px!important;border:0!important;background:transparent!important;text-align:center;font-size:13px;font-weight:700;color:var(--ct-navy);outline:none;padding:0!important;box-shadow:none!important}

        .ct-last{display:flex;flex-direction:column;align-items:flex-end;gap:14px}
        .ct-sub{font-size:13px;font-weight:700;color:var(--ct-navy);white-space:nowrap}
        .ct-remove{width:24px;height:24px;display:inline-flex;align-items:center;justify-content:center;color:var(--ct-orange)!important;transition:transform .2s}
        .ct-remove svg{width:17px;height:17px}
        .ct-remove:hover{transform:scale(1.2)}

        .ct-continue{margin-top:auto;padding-top:36px;display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:600;color:var(--ct-navy)!important}
        .ct-continue svg{width:12px;height:12px}
        .ct-continue:hover{color:var(--ct-orange)!important}

        /* ---------- Right : order summary ---------- */
        .ct-side{padding:20px 18px;position:sticky;top:90px}
        .ct-side h2{margin:0 0 12px;padding-bottom:10px;border-bottom:1px solid var(--ct-line);font-size:14px;font-weight:700;color:var(--ct-navy)}
        .ct-code-t{font-size:12px;font-weight:600;margin:0 0 6px;color:var(--ct-navy)}
        .ct-code-d{font-size:11px;margin:-2px 0 6px;color:rgba(var(--ct-navy-rgb),.8)}
        .ct-code{display:flex;gap:6px;margin-bottom:14px}
        .ct-code input{flex:1;min-width:0;height:32px;padding:0 10px;border:1px solid var(--ct-line);border-radius:3px;background:#fff;font-size:11px;color:var(--ct-navy);outline:none;box-shadow:none}
        .ct-code input:focus{border-color:var(--ct-navy)}
        .ct-code button{flex:0 0 auto;height:32px;padding:0 14px;border:0;border-radius:3px;background:var(--ct-navy);color:#fff;font-size:11px;font-weight:600;cursor:pointer;transition:background .2s}
        .ct-code button:hover{background:var(--ct-orange)}

        .ct-applied{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:14px;padding:8px 10px;border-radius:3px;border:1px solid var(--ct-navy);border-left:4px solid var(--ct-orange);background:#fff;font-size:12px;font-weight:600;color:var(--ct-navy)}
        .ct-applied button{border:0;background:rgba(var(--ct-orange-rgb),.15);color:var(--ct-orange);border-radius:50px;padding:3px 12px;font-size:11px;font-weight:700;cursor:pointer}
        .ct-applied button:hover{background:var(--ct-orange);color:#fff}
        .ct-msg{margin-bottom:8px;font-size:12px;font-weight:600;color:var(--ct-orange)}

        .ct-line{display:flex;justify-content:space-between;padding:5px 0;font-size:12px;font-weight:600;color:var(--ct-navy)}
        .ct-line .val{font-weight:700}
        .ct-line.tot{margin-top:8px;padding-top:10px;border-top:1px solid var(--ct-line);font-size:13px}
        .ct-line.tot .val{font-size:15px}

        .ct-checkout{display:flex;align-items:center;justify-content:center;width:100%;height:38px;margin-top:14px;border-radius:3px;background:var(--ct-navy);color:#fff!important;font-size:14px;font-weight:700;transition:background .2s}
        .ct-checkout:hover{background:var(--ct-orange)}

        /* ---------- Offer products ---------- */
        .ct-offer{margin-top:22px}
        .ct-offer h3{margin:0 0 12px;font-size:13px;font-weight:700;color:var(--ct-navy)}
        .ct-offer-row{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:12px}
        .ct-ocard{display:block;background:#fff;border:1px solid transparent;border-radius:6px;padding:10px;color:var(--ct-navy)!important;transition:border-color .2s,box-shadow .2s}
        .ct-ocard:hover{border-color:var(--ct-navy);box-shadow:0 4px 14px rgba(var(--ct-navy-rgb),.15)}
        .ct-ocard .im{aspect-ratio:1/1;display:flex;align-items:center;justify-content:center;overflow:hidden;margin-bottom:8px}
        .ct-ocard .im img{max-width:100%;max-height:100%;object-fit:contain}
        .ct-ocard .nm{font-size:11px;font-weight:600;line-height:1.5;height:33px;overflow:hidden}
        .ct-ocard .pr{margin-top:6px;font-size:13px;font-weight:700;color:var(--ct-navy)}

        /* ---------- Empty ---------- */
        .ct-empty{text-align:center;background:#fff;border-radius:10px;padding:54px 24px;max-width:520px;margin:20px auto}
        .ct-empty svg{width:56px;height:56px;color:var(--ct-navy)}
        .ct-empty h4{font-weight:700;color:var(--ct-navy);margin:12px 0 6px}
        .ct-empty p{color:rgba(var(--ct-navy-rgb),.75)}
        .ct-empty a{display:inline-block;margin-top:8px;background:var(--ct-navy);color:#fff;font-weight:600;padding:12px 32px;border-radius:50px}
        .ct-empty a:hover{background:var(--ct-orange)}

        @media (max-width:991px){
            .ct-grid{grid-template-columns:minmax(0,1fr)}
            .ct-side{position:static;padding:20px 0 0}
            .ct-offer-row{grid-template-columns:repeat(3,minmax(0,1fr))}
        }
        @media (max-width:767px){
            .ct-left{padding:16px 14px}
            .ct-thead{display:none}
            .ct-item{
                grid-template-columns:minmax(0,1fr) auto auto;
                grid-template-areas:
                    "prod prod prod"
                    "price qty last";
                gap:12px;
            }
            .ct-prod{grid-area:prod}
            .ct-price{grid-area:price;text-align:left}
            .ct-qty{grid-area:qty;justify-self:center}
            .ct-last{grid-area:last;flex-direction:row;align-items:center;gap:12px}
        }
        @media (max-width:575px){
            .ct-offer-row{grid-template-columns:repeat(2,minmax(0,1fr))}
        }
    </style>

    @php
        $cartIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h3l2.4 11.2a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.5L21.5 7H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/></svg>';
        $itemCount = $cartItems->count();

        // "Offer products" er card view (thakle sheta use hobe, na thakle simple card)
        $cardView = 'frontend.partials.product-card';
    @endphp

    <div class="ct-page">
        <div class="container">

            @if($cartItems->isEmpty())

                <div class="ct-empty">
                    {!! $cartIcon !!}
                    <h4>Your cart is empty</h4>
                    <p>এখনো কার্টে কোনো পণ্য নেই। পছন্দের পণ্য যোগ করে শুরু করুন।</p>
                    <a href="{{ route('homes') }}">Continue Shopping</a>
                </div>

            @else

                <div class="ct-grid">

                    {{-- ================= LEFT : Shopping Cart ================= --}}
                    <div class="ct-left">

                        <div class="ct-title">
                            {!! $cartIcon !!}
                            <h1>Shopping Cart ({{ $itemCount }})</h1>
                        </div>

                        <div class="ct-thead">
                            <span>Products details</span>
                            <span>Price</span>
                            <span>Quantity</span>
                            <span>Subtotal</span>
                        </div>

                        <div id="cartItemsBody">
                            @foreach($cartItems as $item)
                                @php
                                    $stockQty  = optional($item->productVariant)->stock_quantity
                                        ?? $item->product->productVariants->sum('stock_quantity');
                                    $brandName = optional($item->product->brand ?? null)->name;
                                @endphp
                                <div class="ct-item" data-cart-item-id="{{ $item->id }}">

                                    <div class="ct-prod">
                                        <a class="ct-thumb" href="{{ route('products.details', $item->product->slug) }}">
                                            <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}">
                                        </a>
                                        <div class="ct-info">
                                            <a class="ct-name" href="{{ route('products.details', $item->product->slug) }}">{{ $item->product->name }}</a>
                                            @if($item->productVariant)
                                                <span class="ct-variant">{{ $item->productVariant->display_name }}</span>
                                            @endif
                                            @if($brandName)
                                                <span class="ct-brand">Brand: {{ $brandName }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="ct-price">৳{{ number_format($item->price) }}</div>

                                    <div class="ct-qty">
                                        <button type="button" class="cart-qty-minus" data-id="{{ $item->id }}" aria-label="Decrease">−</button>
                                        <input class="cart-qty-input" type="text" value="{{ $item->quantity }}" data-id="{{ $item->id }}" data-stock="{{ $stockQty }}">
                                        <button type="button" class="cart-qty-plus" data-id="{{ $item->id }}" aria-label="Increase">+</button>
                                    </div>

                                    <div class="ct-last">
                                        <span class="ct-sub cart-item-subtotal" data-id="{{ $item->id }}">৳{{ number_format($item->price * $item->quantity) }}</span>
                                        <a href="javascript:void(0)" class="ct-remove cart-remove-btn" data-id="{{ $item->id }}" title="Remove" aria-label="Remove">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 7V4h6v3"/></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ route('homes') }}" class="ct-continue">
                            <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2L4 6l4 4"/></svg>
                            Continue shopping
                        </a>
                    </div>

                    {{-- ================= RIGHT : Order Summary ================= --}}
                    <aside class="ct-side">
                        <h2>Order Summary</h2>

                        <div id="couponMessage"></div>

                        <div class="ct-code-t">Apply discount code</div>
                        @if($appliedCoupon)
                            <div class="ct-applied">
                                <span><strong>{{ $appliedCoupon->code }}</strong> applied</span>
                                <button type="button" id="removeCouponBtn">Remove</button>
                            </div>
                        @else
                            <div class="ct-code">
                                <input type="text" id="couponCodeInput" placeholder="Enter discount code">
                                <button type="button" id="applyCouponBtn">Apply</button>
                            </div>
                        @endif

                        <div class="ct-code-t">Use reward points</div>
                        <div class="ct-code-d">You have 0 club points available.</div>
                        <div class="ct-code">
                            <input type="text" id="rewardInput" placeholder="Enter reward amount">
                            <button type="button" class="js-soon">Apply</button>
                        </div>

                        <div class="ct-line">
                            <span>Subtotal ({{ $itemCount }}):</span>
                            <span class="val" id="cartSubtotal">৳{{ number_format($cartTotal) }}</span>
                        </div>
                        <div class="ct-line" id="discountRow">
                            <span>Discount:</span>
                            <span class="val" id="cartDiscount">৳ {{ number_format($discount) }}</span>
                        </div>
                        <div class="ct-line">
                            <span>Points Discount:</span>
                            <span class="val">৳ 0</span>
                        </div>
                        <div class="ct-line">
                            <span>Shipping:</span>
                            <span class="val">will be added</span>
                        </div>
                        <div class="ct-line tot">
                            <span>Total:</span>
                            <span class="val" id="cartGrandTotal">৳{{ number_format($grandTotal) }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="ct-checkout">Checkout</a>
                    </aside>
                </div>

                {{-- ================= Offer products only for you ================= --}}
                @if(isset($offerProducts) && $offerProducts->count())
                    <div class="ct-offer">
                        <h3>Offer products only for you</h3>
                        <div class="ct-offer-row">
                            @foreach($offerProducts->take(5) as $p)
                                @if(view()->exists($cardView))
                                    @include($cardView, ['product' => $p])
                                @else
                                    <a class="ct-ocard" href="{{ route('products.details', $p->slug) }}">
                                        <div class="im"><img src="{{ asset('storage/' . $p->thumbnail) }}" alt="{{ $p->name }}"></div>
                                        <div class="nm">{{ $p->name }}</div>
                                        @if(isset($p->price))
                                            <div class="pr">৳{{ number_format($p->price) }}</div>
                                        @endif
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

            @endif
        </div>
    </div>

    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        function formatMoney(num) {
            return '৳' + parseFloat(num).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
        }
        function refreshTotals(data) {
            if (data.cart_total !== undefined) {
                document.getElementById('cartSubtotal').textContent = formatMoney(data.cart_total);
            }
            if (data.discount !== undefined) {
                document.getElementById('cartDiscount').textContent = '৳ ' + parseFloat(data.discount).toLocaleString('en-US', { maximumFractionDigits: 2 });
            }
            if (data.grand_total !== undefined) {
                document.getElementById('cartGrandTotal').textContent = formatMoney(data.grand_total);
            }

            // ---- Header cart icon (count + subtotal) sathe sathe update ----
            if (data.cart_count !== undefined) {
                var headerIcon = document.getElementById('cartIconLink');
                if (headerIcon) {
                    headerIcon.setAttribute('data-number', data.cart_count);
                }
                var headerIconMobile = document.getElementById('cartIconLinkMobile');
                if (headerIconMobile) {
                    headerIconMobile.setAttribute('data-number', data.cart_count);
                }
            }
            if (data.cart_total !== undefined) {
                var headerSubtotal = document.getElementById('cartSubtotalDisplay');
                if (headerSubtotal) {
                    headerSubtotal.textContent = 'Tk. ' + parseFloat(data.cart_total).toLocaleString('en-US');
                }
            }
        }

        // ---- Quantity update (+/- button o sorasori type) ----
        function sendQtyUpdate(cartItemId, qty) {
            fetch("{{ url('/cart/update') }}/" + cartItemId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: qty })
            })
                .then(function(res){ return res.json(); })
                .then(function(data){
                    if (data.success) {
                        var row = document.querySelector('[data-cart-item-id="' + cartItemId + '"]');
                        row.querySelector('.cart-qty-input').value = data.quantity;
                        row.querySelector('.cart-item-subtotal').textContent = formatMoney(data.subtotal);
                        refreshTotals(data);
                    } else {
                        alert(data.message || 'Could not update quantity.');
                    }
                });
        }
        document.querySelectorAll('.cart-qty-plus').forEach(function(btn){
            btn.addEventListener('click', function(){
                var id = this.getAttribute('data-id');
                var input = document.querySelector('.cart-qty-input[data-id="' + id + '"]');
                var stock = parseInt(input.getAttribute('data-stock')) || 0;
                var newQty = (parseInt(input.value) || 1) + 1;

                if (newQty > stock) {
                    showToast('Stock Limit', 'Sorry, only ' + stock + ' items available in stock.', 'error');
                    return;
                }
                sendQtyUpdate(id, newQty);
            });
        });

        document.querySelectorAll('.cart-qty-minus').forEach(function(btn){
            btn.addEventListener('click', function(){
                var id = this.getAttribute('data-id');
                var input = document.querySelector('.cart-qty-input[data-id="' + id + '"]');
                var newQty = (parseInt(input.value) || 1) - 1;
                if (newQty < 1) newQty = 1;
                sendQtyUpdate(id, newQty);
            });
        });

        document.querySelectorAll('.cart-qty-input').forEach(function(input){
            input.addEventListener('change', function(){
                var id = this.getAttribute('data-id');
                var stock = parseInt(this.getAttribute('data-stock')) || 0;
                var newQty = parseInt(this.value) || 1;

                if (newQty > stock) {
                    showToast('Stock Limit', 'Sorry, only ' + stock + ' items available in stock.', 'error');
                    newQty = stock;
                    this.value = stock;
                }
                sendQtyUpdate(id, newQty);
            });
        });

        // ---- Remove item ----
        document.querySelectorAll('.cart-remove-btn').forEach(function(btn){
            btn.addEventListener('click', function(){
                var id = this.getAttribute('data-id');

                if (!confirm('Remove this item from cart?')) return;

                fetch("{{ url('/cart/remove') }}/" + id, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                    .then(function(res){ return res.json(); })
                    .then(function(data){
                        if (data.success) {
                            document.querySelector('[data-cart-item-id="' + id + '"]').remove();
                            refreshTotals(data);

                            // shob item faka hole page reload kore empty message dekhao
                            if (document.querySelectorAll('#cartItemsBody .ct-item').length === 0) {
                                location.reload();
                            }
                        }
                    });
            });
        });

        // ---- Apply Coupon ----
        var applyCouponBtn = document.getElementById('applyCouponBtn');
        if (applyCouponBtn) {
            applyCouponBtn.addEventListener('click', function(){
                var code = document.getElementById('couponCodeInput').value.trim();
                var messageBox = document.getElementById('couponMessage');

                if (!code) {
                    messageBox.innerHTML = '<div class="ct-msg">Please enter a coupon code.</div>';
                    return;
                }

                fetch("{{ route('cart.coupon.apply') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ code: code })
                })
                    .then(function(res){ return res.json(); })
                    .then(function(data){
                        if (data.success) {
                            showToast('Coupon Applied', 'Discount has been applied to your cart.', 'success');
                            setTimeout(function(){ location.reload(); }, 1000);
                        } else {
                            showToast('Invalid Coupon', data.message, 'error');
                        }
                    });
            });
        }

        // ---- Remove Coupon ----
        var removeCouponBtn = document.getElementById('removeCouponBtn');
        if (removeCouponBtn) {
            removeCouponBtn.addEventListener('click', function(){
                fetch("{{ route('cart.coupon.remove') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                    .then(function(res){ return res.json(); })
                    .then(function(data){
                        if (data.success) {
                            location.reload();
                        }
                    });
            });
        }

        // ---- Reward points (ekhono available na) ----
        document.querySelectorAll('.js-soon').forEach(function(b){
            b.addEventListener('click', function(){
                if (typeof showToast === 'function') {
                    showToast('Not available', 'This option is not available yet.', 'error');
                }
            });
        });
    </script>

@endsection