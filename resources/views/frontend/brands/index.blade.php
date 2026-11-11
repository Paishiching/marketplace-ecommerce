@extends('layouts.frontend.app')

@section('title', 'Featured Brands')

@section('content')
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-home.css?v=11">

    <section class="eb-block eb-brand-directory">
        <div class="container">
            <div class="eb-brand-head">
                <div>
                    <h2>Featured brands</h2>
                    <p>Authentic products from official and verified brand partners.</p>
                </div>
            </div>

            <div class="eb-brand-grid eb-brand-directory-grid">
                @foreach($brands as $brand)
                    <a class="eb-brand-card" href="{{ route('categories.shop', ['brands' => [$brand->slug]]) }}" title="Browse {{ $brand->name }} products">
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" loading="lazy">
                        @endif
                        <span class="eb-brand-name">{{ $brand->name }}</span>
                    </a>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $brands->links() }}
            </div>
        </div>
    </section>
@endsection
