@extends('layouts.frontend.app')

@section('title', '100% Secure Payment')

@section('content')
    @php
        // sp-ic-orange = orange icon, sp-ic-blue = navy icon (both defined in _sidebar)
        $methods = [
            ['sp-ic-orange', 'ion-iphone', 'Mobile Banking', 'bKash, Nagad, Rocket'],
            ['sp-ic-blue', 'ion-card', 'Card Payment', 'Visa, Mastercard and local debit/credit cards'],
            ['sp-ic-orange', 'ion-earth', 'Internet Banking', 'Online payment through selected banks'],
            ['sp-ic-blue', 'ion-cash', 'Cash on Delivery', 'Pay when you receive your product'],
        ];

        $security = [
            ['ion-locked', 'The entire website is protected with SSL encryption'],
            ['ion-card', 'Card details are never stored on our servers; transactions go directly through an approved payment gateway'],
            ['ion-eye', 'Automated fraud monitoring is active to detect suspicious transactions'],
            ['ion-android-mail', 'A confirmation is sent by email and SMS after every successful payment'],
        ];

        $tips = [
            'Never share your OTP, PIN or password with anyone.',
            'Before paying, check the website address and the lock icon in your browser.',
            'If someone claiming to be from us asks for your card details, do not share them and let us know.',
        ];
    @endphp

    <!-- Hero -->
    <section class="sp-hero">
        <div class="container">
            <div class="sp-crumb">
                <a href="{{ route('homes') }}">Home</a><span>/</span><span>Secure Payment</span>
            </div>
            <span class="sp-badge">SSL Encrypted Transactions</span>
            <h1>100% Secure Payment</h1>
            <p>The safety of your payment and personal information is our top priority. We protect every transaction with modern security measures.</p>
        </div>
    </section>

    <!-- Payment methods -->
    <section class="container sp-pull">
        <div class="row g-4 justify-content-center">
            @foreach($methods as $m)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="sp-card">
                        <div class="sp-icon {{ $m[0] }}"><i class="{{ $m[1] }}"></i></div>
                        <h5>{{ $m[2] }}</h5>
                        <p class="sp-desc">{{ $m[3] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Body -->
    <section class="container py-5 my-lg-3">
        <div class="row g-4 g-lg-5">
            <div class="col-lg-3">
                @include('frontend.policies._sidebar')
            </div>

            <div class="col-lg-9">
                {{-- Security --}}
                <h3 class="sp-section-title">How We Keep Your Payment Safe</h3>
                <p class="sp-section-sub">What we do at every step to keep you secure.</p>
                <div class="row g-3 mb-5">
                    @foreach($security as $s)
                        <div class="col-12 col-md-6">
                            <div class="sp-topic">
                                <i class="{{ $s[0] }}"></i>
                                <span>{{ $s[1] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Stats --}}
                <div class="row g-3 mb-5">
                    <div class="col-12 col-md-4">
                        <div class="sp-stat"><em>Encryption</em><b>SSL</b><span>On the entire website</span></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="sp-stat"><em>Card Data Stored</em><b>0</b><span>Nothing on our servers</span></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="sp-stat"><em>Automatic Refund</em><b>7 Working Days</b><span>For failed payments</span></div>
                    </div>
                </div>

                {{-- Safety tips --}}
                <h3 class="sp-section-title">What You Can Do to Stay Safe</h3>
                <p class="sp-section-sub">Follow a few simple precautions to stay even safer.</p>
                <div class="sp-panel sp-panel-warn mb-5">
                    <ul class="sp-tips">
                        @foreach($tips as $tip)
                            <li><i class="ion-alert"></i><span>{{ $tip }}</span></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Payment problem --}}
                <div class="sp-note mb-5">
                    <i class="ion-information-circled"></i>
                    <div>
                        <h6>If You Have a Payment Problem</h6>
                        <p>If a payment fails but the money is deducted, it is usually refunded automatically within 7 working days. If it has not arrived by then, contact our support team with your order number and transaction ID.</p>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="sp-cta">
                    <h4>Having Trouble With Payment?</h4>
                    <p>Our 24/7 support team is always by your side.</p>
                    <a href="{{ route('policy.support') }}" class="sp-btn">Contact Support</a>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.partials.static-area')
@endsection