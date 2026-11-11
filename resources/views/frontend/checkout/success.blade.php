@extends('layouts.frontend.app')

@section('title', 'Checkout Success')

@section('content')

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-checkout-success.css?v=1">

    <div class="cs-page">
        <div class="container">
            <div class="cs-card">

                <div class="cs-check">
                    <svg class="dots" viewBox="0 0 180 120" aria-hidden="true">
                        <circle cx="14" cy="22" r="3.5" fill="#2a3582"/>
                        <circle cx="30" cy="40" r="2" fill="#fd6801"/>
                        <circle cx="46" cy="14" r="1.8" fill="#2a3582"/>
                        <circle cx="26" cy="64" r="2.4" fill="#2a3582"/>
                        <circle cx="48" cy="86" r="2" fill="#fd6801"/>
                        <circle cx="20" cy="96" r="1.6" fill="#2a3582"/>
                        <circle cx="62" cy="104" r="2.2" fill="#2a3582"/>
                        <circle cx="76" cy="10" r="1.6" fill="#fd6801"/>
                        <circle cx="132" cy="8" r="2" fill="#2a3582"/>
                        <circle cx="150" cy="30" r="2" fill="#fd6801"/>
                        <circle cx="168" cy="52" r="1.6" fill="#2a3582"/>
                        <circle cx="146" cy="62" r="2.6" fill="#2a3582"/>
                        <circle cx="160" cy="86" r="3.4" fill="#fd6801"/>
                        <circle cx="128" cy="100" r="2" fill="#2a3582"/>
                        <circle cx="108" cy="110" r="1.6" fill="#fd6801"/>
                        <circle cx="116" cy="22" r="1.5" fill="#fd6801"/>
                    </svg>
                    <span class="cs-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
                    </span>
                </div>

                <h1>Thank you for your purchase</h1>
                <p>We've received your order and will ship it in 2-3 business days.</p>
                <p>Your order number is <span class="no">#{{ $order->order_number }}</span></p>

                <div class="cs-btns">
                    @if(\Illuminate\Support\Facades\Route::has('customer.dashboard'))
                        <a href="{{ route('customer.dashboard') }}" class="cs-btn outline">View order</a>
                    @endif
                    <a href="{{ route('homes') }}" class="cs-btn fill">Continue Shopping</a>
                </div>

            </div>
        </div>
    </div>

@endsection