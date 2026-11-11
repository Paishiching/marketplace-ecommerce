<style>
    /* ===== Mini Cart Popup (orange header theme) ===== */
    #offcanvas-cart .inner{display:flex;flex-direction:column;height:100%;padding:0!important}
    #offcanvas-cart .head{flex:0 0 auto;display:flex;align-items:center;justify-content:space-between;margin:0!important;padding:16px 20px!important;background:#fd6801;border-bottom:0!important}
    #offcanvas-cart .head .title{font-size:18px;font-weight:800;color:#fff;display:flex;align-items:center;gap:8px;margin:0}
    #offcanvas-cart .head .offcanvas-close{position:static!important;width:34px!important;height:34px!important;margin:0!important;padding:0!important;border:0!important;border-radius:50%!important;background:rgba(255,255,255,.2)!important;color:#fff!important;font-size:0!important;line-height:0!important;display:inline-flex!important;align-items:center;justify-content:center;cursor:pointer;transition:background .2s ease,transform .25s ease}
    /* theme er nijer X (pseudo-element / background) lukiye dao, nahole 2ta X dekhay */
    #offcanvas-cart .head .offcanvas-close::before,
    #offcanvas-cart .head .offcanvas-close::after{content:none!important;display:none!important}
    #offcanvas-cart .head .offcanvas-close{background-image:none!important;box-shadow:none!important;overflow:hidden}
    #offcanvas-cart .head .offcanvas-close svg{width:16px;height:16px;display:block;stroke:#fff}
    #offcanvas-cart .head .offcanvas-close:hover{background:#fff!important;transform:rotate(90deg)}
    #offcanvas-cart .head .offcanvas-close:hover svg{stroke:#fd6801}
    .mc-count{font-style:normal;background:#fff;color:#fd6801;font-size:12px;font-weight:700;min-width:22px;height:22px;padding:0 7px;border-radius:50px;display:inline-flex;align-items:center;justify-content:center}
    #miniCartContent{display:flex;flex-direction:column;flex:1 1 auto;min-height:0}

    .mc-body{flex:1 1 auto;overflow-y:auto;padding:6px 18px}
    .mc-item{position:relative;display:flex;gap:14px;padding:16px 0;border-bottom:1px dashed rgba(42,53,130,.15);transition:opacity .25s ease,transform .25s ease}
    .mc-item:last-child{border-bottom:0}
    .mc-item.mc-loading{opacity:.55;pointer-events:none}
    .mc-item.mc-removing{opacity:0;transform:translateX(40px)}

    .mc-thumb{flex:0 0 78px;width:78px;height:78px;border-radius:12px;overflow:hidden;border:1px solid rgba(42,53,130,.1);background:rgba(42,53,130,.04)}
    .mc-thumb img{width:100%;height:100%;object-fit:cover}

    .mc-info{flex:1 1 auto;min-width:0;padding-right:26px}
    .mc-name{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;font-size:14px;font-weight:700;line-height:1.35;color:#2a3582}
    .mc-name:hover{color:#fd6801}
    .mc-variant{display:inline-block;margin-top:4px;background:rgba(42,53,130,.08);color:#2a3582;border-radius:6px;padding:1px 8px;font-size:11px;font-weight:700}
    .mc-unit{display:block;margin-top:4px;color:rgba(42,53,130,.5);font-size:12px;font-weight:600}

    .mc-row{display:flex;align-items:center;justify-content:space-between;margin-top:10px;gap:10px}
    .mc-qty{display:inline-flex;align-items:center;border:1.5px solid rgba(42,53,130,.15);border-radius:10px;overflow:hidden;background:#fff}
    .mc-qty button{width:30px;height:32px;border:0;background:rgba(42,53,130,.08);color:#2a3582;font-size:17px;font-weight:700;line-height:1;cursor:pointer;padding:0;display:flex;align-items:center;justify-content:center;transition:all .2s ease}
    .mc-qty button:hover{background:#fd6801;color:#fff}
    .mc-qty input{width:38px;height:32px;border:0;border-left:1px solid rgba(42,53,130,.15);border-right:1px solid rgba(42,53,130,.15);text-align:center;font-size:14px;font-weight:700;color:#2a3582;background:#fff;padding:0;outline:none;box-shadow:none}
    .mc-sub{font-size:15px;font-weight:800;color:#2a3582;white-space:nowrap}

    .mc-remove{position:absolute;top:14px;right:0;width:26px;height:26px;border:0;border-radius:50%;background:rgba(253,104,1,.12);color:#fd6801;font-size:11px;display:flex;align-items:center;justify-content:center;cursor:pointer;padding:0;transition:all .2s ease}
    .mc-remove:hover{background:#fd6801;color:#fff;transform:rotate(90deg)}

    .mc-foot{flex:0 0 auto;padding:18px 22px 22px;border-top:1px solid rgba(42,53,130,.1);background:#fff;box-shadow:0 -8px 24px rgba(42,53,130,.06)}
    .mc-total{display:flex;justify-content:space-between;align-items:center;font-size:16px;color:rgba(42,53,130,.8);font-weight:600}
    .mc-total strong{font-size:22px;font-weight:800;color:#2a3582}
    .mc-note{margin:6px 0 14px;font-size:12px;color:rgba(42,53,130,.5)}

    .mc-btn,a.mc-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px 16px;border-radius:12px;font-size:14px;font-weight:800;letter-spacing:.4px;text-transform:uppercase;text-decoration:none;transition:all .25s ease;line-height:1.2}
    .mc-btn-primary,a.mc-btn-primary{background:#fd6801;color:#fff!important;box-shadow:0 10px 22px rgba(253,104,1,.35)}
    .mc-btn-primary:hover{transform:translateY(-2px);box-shadow:0 14px 28px rgba(253,104,1,.45)}
    .mc-btn-outline,a.mc-btn-outline{margin-top:10px;background:#fff;color:#2a3582!important;border:1.5px solid rgba(42,53,130,.25)}
    .mc-btn-outline:hover{background:#2a3582;color:#fff!important;border-color:#2a3582}

    .mc-empty{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:40px 28px}
    .mc-empty-ico{width:90px;height:90px;border-radius:50%;background:rgba(253,104,1,.1);color:#fd6801;font-size:38px;display:flex;align-items:center;justify-content:center;margin-bottom:16px}
    .mc-empty h4{font-weight:800;color:#2a3582;margin-bottom:6px}
    .mc-empty p{color:rgba(42,53,130,.7);margin-bottom:20px}
    .mc-empty .mc-btn{width:auto;padding:12px 32px}
</style>

@if($cartItems->isEmpty())
    <div class="mc-empty">
        <div class="mc-empty-ico"><i class="icon-bag"></i></div>
        <h4>Your cart is empty</h4>
        <p>Looks like you haven't added anything yet.</p>
        <a href="{{ route('homes') }}" class="mc-btn mc-btn-primary">Start Shopping</a>
    </div>
@else
    <div class="mc-body customScroll">
        @foreach($cartItems as $item)
            @php
                $stockQty = optional($item->productVariant)->stock_quantity
                    ?? $item->product->productVariants->sum('stock_quantity');
            @endphp
            <div class="mc-item" data-id="{{ $item->id }}" data-price="{{ $item->price }}">
                <a href="{{ route('products.details', $item->product->slug) }}" class="mc-thumb">
                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}">
                </a>

                <div class="mc-info">
                    <a href="{{ route('products.details', $item->product->slug) }}" class="mc-name">{{ $item->product->name }}</a>
                    @if($item->productVariant)
                        <span class="mc-variant">{{ $item->productVariant->display_name }}</span>
                    @endif
                    <span class="mc-unit">Tk. {{ number_format($item->price, 2) }}</span>

                    <div class="mc-row">
                        <div class="mc-qty">
                            <button type="button" class="mc-minus" aria-label="Decrease">−</button>
                            <input type="text" class="mc-qty-input" value="{{ $item->quantity }}" data-stock="{{ $stockQty }}" readonly>
                            <button type="button" class="mc-plus" aria-label="Increase">+</button>
                        </div>
                        <div class="mc-sub">Tk. {{ number_format($item->price * $item->quantity, 2) }}</div>
                    </div>
                </div>

                <button type="button" class="mc-remove" title="Remove" aria-label="Remove">
                    <i class="ion-close-round"></i>
                </button>
            </div>
        @endforeach
    </div>

    <div class="mc-foot">
        <div class="mc-total">
            <span>Subtotal</span>
            <strong id="mcSubtotal">Tk. {{ number_format($cartTotal, 2) }}</strong>
        </div>
        <p class="mc-note">Shipping & discount calculated at checkout</p>
        <a href="{{ route('checkout.index') }}" class="mc-btn mc-btn-primary">
            <i class="ion-android-checkmark-circle"></i> Checkout
        </a>
        <a href="{{ route('cart.index') }}" class="mc-btn mc-btn-outline">View Cart</a>
    </div>
@endif