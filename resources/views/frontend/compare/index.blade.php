@extends('layouts.frontend.app')

@section('title','Compare')

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
                            <li>Compare</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <!-- Compare area start -->
    <div class="compare-area mtb-60px">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-12">
                @if($items->count())
                    <!-- Compare Table -->
                        <div class="compare-table table-responsive">
                            <table class="table mb-0">
                                <tbody>

                                {{-- Product --}}
                                <tr>
                                    <td class="first-column">Product</td>
                                    @foreach($items as $item)
                                        @php
                                            $product = $item->product;
                                            $imagePath = $product->primaryImage->image_path
                                                ?? $product->thumbnail
                                                ?? null;
                                            $image = $imagePath
                                                ? asset($imagePath)
                                                : asset('frontend/assets/images/product-image/19.jpg');
                                        @endphp
                                        <td class="product-image-title">
                                            <a href="{{ route('products.details', $product->slug) }}" class="image">
                                                <img class="img-responsive" src="{{ $image }}" alt="{{ $product->name }}" />
                                            </a>
                                            <a href="#" class="category">{{ $product->category->name ?? 'Uncategorized' }}</a>
                                            <a href="{{ route('products.details', $product->slug) }}" class="title">{{ $product->name }}</a>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- Description --}}
                                <tr>
                                    <td class="first-column">Description</td>
                                    @foreach($items as $item)
                                        <td class="pro-desc">
                                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->product->short_description ?: $item->product->description), 150) }}</p>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- Price --}}
                                <tr>
                                    <td class="first-column">Price</td>
                                    @foreach($items as $item)
                                        @php $product = $item->product; @endphp
                                        <td class="pro-price">
                                            @if($product->is_on_sale)
                                                {{ $currency }}{{ number_format($product->discount_price, 2) }}
                                                <del style="color:#999;font-size:13px;">{{ $currency }}{{ number_format($product->price, 2) }}</del>
                                            @else
                                                {{ $currency }}{{ number_format($product->price, 2) }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- Color --}}
                                <tr>
                                    <td class="first-column">Color</td>
                                    @foreach($items as $item)
                                        <td class="pro-color">
                                            {{ $item->product->colorValues->pluck('value')->implode(', ') ?: '—' }}
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- Stock --}}
                                <tr>
                                    <td class="first-column">Stock</td>
                                    @foreach($items as $item)
                                        @php $stock = (int) ($item->product->inventories_sum_quantity ?? 0); @endphp
                                        <td class="pro-stock">
                                            @if($stock > 0)
                                                <span style="color:#28a745;">In Stock</span>
                                            @else
                                                <span style="color:#dc3545;">Out of Stock</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- Add to cart --}}
                                <tr>
                                    <td class="first-column">Add to cart</td>
                                    @foreach($items as $item)
                                        <td class="pro-addtocart">
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="add-to-cart" style="border:0;background:none;padding:0;">
                                                    <span>ADD TO CART</span>
                                                </button>
                                            </form>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- Delete --}}
                                <tr>
                                    <td class="first-column">Delete</td>
                                    @foreach($items as $item)
                                        <td class="pro-remove">
                                            <form action="{{ route('compare.destroy', $item->id) }}" method="POST"
                                                  onsubmit="return confirm('Remove this product from compare list?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"><i class="ion-trash-b"></i></button>
                                            </form>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- Rating --}}
                                <tr>
                                    <td class="first-column">Rating</td>
                                    @foreach($items as $item)
                                        @php $rating = round(((float) ($item->product->reviews_avg_rating ?? 0)) * 2) / 2; @endphp
                                        <td class="pro-ratting">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($rating >= $i)
                                                    <i class="ion-android-star"></i>
                                                @elseif($rating >= $i - 0.5)
                                                    <i class="ion-android-star-half"></i>
                                                @else
                                                    <i class="ion-android-star-outline"></i>
                                                @endif
                                            @endfor
                                        </td>
                                    @endforeach
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center" style="padding:60px 0;">
                            <h4>Your compare list is empty.</h4>
                            <a href="{{ route('homes') }}" class="btn btn-primary mt-3">Continue Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Compare area end -->
@endsection
