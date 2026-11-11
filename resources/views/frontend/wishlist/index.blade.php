@extends('layouts.frontend.app')

@section('title','Wishlist')

@section('content')
    @php $currency = '$'; @endphp

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('homes') }}">Home</a></li>
                            <li>Wishlist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <!-- Wishlist area start -->
    <div class="cart-main-area mtb-60px">
        <div class="container">
            <h3 class="cart-page-title">Your wishlist items</h3>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    @if($items->count())
                        <div class="table-content table-responsive cart-table-content">
                            <table>
                                <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Add To Cart</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    @php
                                        $product = $item->product;

                                        // Image priority: primaryImage -> thumbnail -> placeholder
                                        $imagePath = $product->primaryImage->image_path
                                            ?? $product->thumbnail
                                            ?? null;

                                        $image = $imagePath
                                            ? asset($imagePath)
                                            : asset('frontend/assets/images/product-image/2-1.jpg');

                                        $unitPrice = $product->is_on_sale
                                            ? $product->discount_price
                                            : $product->price;
                                    @endphp
                                    <tr data-price="{{ $unitPrice }}">
                                        <td class="product-thumbnail">
                                            <a href="{{ route('products.details', $product->slug) }}">
                                                <img class="img-responsive" src="{{ $image }}" alt="{{ $product->name }}" style="max-width:80px;" />
                                            </a>
                                        </td>
                                        <td class="product-name">
                                            <a href="{{ route('products.details', $product->slug) }}">{{ $product->name }}</a>
                                        </td>
                                        <td class="product-price-cart">
                                            @if($product->is_on_sale)
                                                <span class="amount">{{ $currency }}{{ number_format($product->discount_price, 2) }}</span>
                                                <del style="color:#999;font-size:13px;">{{ $currency }}{{ number_format($product->price, 2) }}</del>
                                            @else
                                                <span class="amount">{{ $currency }}{{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" name="quantity"
                                                       value="1" form="add-to-cart-{{ $item->id }}" />
                                            </div>
                                        </td>
                                        <td class="product-subtotal">{{ $currency }}{{ number_format($unitPrice, 2) }}</td>
                                        <td class="product-wishlist-cart">
                                            <form id="add-to-cart-{{ $item->id }}" action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" style="background:none;border:0;padding:0;cursor:pointer;">add to cart</button>
                                            </form>
                                        </td>
                                        <td class="product-remove">
                                            <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST"
                                                  onsubmit="return confirm('Remove this product from wishlist?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background:none;border:0;cursor:pointer;color:#e74c3c;">
                                                    <i class="ion-android-close"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center" style="padding:60px 0;">
                            <h4>Your wishlist is empty.</h4>
                            <a href="{{ route('homes') }}" class="btn btn-primary mt-3">Continue Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Wishlist area end -->

    <script>
        // Qty +/- করলে row-এর Subtotal update হবে
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.cart-plus-minus .qtybutton');
            if (!btn) return;

            var row = btn.closest('tr');
            setTimeout(function () {
                var qty = parseInt(row.querySelector('.cart-plus-minus-box').value) || 1;
                var price = parseFloat(row.dataset.price) || 0;
                row.querySelector('.product-subtotal').textContent = '{{ $currency }}' + (qty * price).toFixed(2);
            }, 50);
        });
    </script>
@endsection
