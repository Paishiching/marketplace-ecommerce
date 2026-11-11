@extends('layouts.frontend.app')

@section('title', 'Free Returns')

@section('content')
    @php
        // sp-ic-orange = orange icon, sp-ic-blue = navy icon (both defined in _sidebar)
        $stats = [
            ['sp-ic-orange', 'ion-clock', '9 Days', 'Return window'],
            ['sp-ic-blue', 'ion-android-car', '৳0', 'Return pickup charge'],
            ['sp-ic-orange', 'ion-cash', '5–7 Days', 'Refund processing time'],
        ];

        $accepted = [
            'You received the wrong product, or a different model, color or size.',
            'The product arrived damaged, defective or broken.',
            'The product differs significantly from its description.',
            'The product is unused, intact and comes with original packaging and tags.',
        ];

        $notAccepted = [
            'Innerwear, personal care and cosmetic items.',
            'Food items and perishable goods.',
            'Digital products, gift cards and downloadable software.',
            'Used, washed or altered products, and items marked "No Return".',
        ];

        $steps = [
            ['Select Your Order', 'Log in to your account and choose the order from "My Orders".'],
            ['Submit a Return Request', 'Click the "Return Request" button, write the reason and attach photos if needed.'],
            ['Review', 'Our team will review your request and get back to you within 24 hours.'],
            ['Product Pickup', 'Once approved, our representative will collect the product from your address.'],
            ['Refund / Replacement', 'After the product is checked, your refund or replacement will begin.'],
        ];
    @endphp

    <!-- Hero -->
    <section class="sp-hero">
        <div class="container">
            <div class="sp-crumb">
                <a href="{{ route('homes') }}">Home</a><span>/</span><span>Free Returns</span>
            </div>
            <span class="sp-badge">Hassle-Free Returns Within 9 Days</span>
            <h1>Free Return &amp; Refund Policy</h1>
            <p>You can return a product free of charge within 9 days of receiving it, subject to certain conditions.</p>
        </div>
    </section>

    <!-- Stats -->
    <section class="container sp-pull">
        <div class="row g-4 justify-content-center">
            @foreach($stats as $s)
                <div class="col-12 col-md-4">
                    <div class="sp-card">
                        <div class="sp-icon {{ $s[0] }}"><i class="{{ $s[1] }}"></i></div>
                        <b class="sp-big">{{ $s[2] }}</b>
                        <p class="sp-desc">{{ $s[3] }}</p>
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
                {{-- Accepted / Not accepted --}}
                <h3 class="sp-section-title">Return Eligibility</h3>
                <p class="sp-section-sub">Find out when a return is accepted and which products cannot be returned.</p>
                <div class="row g-4 mb-5">
                    <div class="col-12 col-md-6">
                        <div class="sp-panel sp-panel-ok">
                            <h5>When Returns Are Accepted</h5>
                            <ul class="sp-checks ok">
                                @foreach($accepted as $item)
                                    <li><i class="ion-checkmark"></i><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="sp-panel sp-panel-no">
                            <h5>Products That Cannot Be Returned</h5>
                            <ul class="sp-checks no">
                                @foreach($notAccepted as $item)
                                    <li><i class="ion-close"></i><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Steps --}}
                <h3 class="sp-section-title">Return Steps</h3>
                <p class="sp-section-sub">Complete your return in just 5 easy steps.</p>
                <ul class="sp-steps mb-5">
                    @foreach($steps as $i => $step)
                        <li>
                            <span class="sp-num">{{ $i + 1 }}</span>
                            <div class="sp-step-body">
                                <b>{{ $step[0] }}</b>
                                <span>{{ $step[1] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Refund --}}
                <div class="sp-note mb-5">
                    <i class="ion-cash"></i>
                    <div>
                        <h6>Refund Method</h6>
                        <p>Your refund will be sent back through your original payment method (bKash, Nagad, card or bank). For Cash on Delivery orders, the refund is sent to your preferred mobile banking number. Refunds are usually completed within 5–7 working days after the product is checked.</p>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="sp-cta">
                    <h4>Need Help With a Return?</h4>
                    <p>Our 24/7 support team is always by your side.</p>
                    <a href="{{ route('policy.support') }}" class="sp-btn">Contact Support</a>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.partials.static-area')
@endsection