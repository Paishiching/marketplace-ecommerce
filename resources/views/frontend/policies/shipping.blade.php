@extends('layouts.frontend.app')

@section('title', 'Free Shipping')

@section('content')
    @php
        $stats = [
            ['sp-ic-orange', 'ion-android-car', '৳5,000+', 'Free delivery on orders'],
            ['sp-ic-blue', 'ion-clock', '1–2 Days', 'Delivery inside Dhaka'],
            ['sp-ic-orange', 'ion-map', '3–5 Days', 'Delivery outside Dhaka'],
        ];

        $conditions = [
            ['ion-pricetag', 'Free shipping applies when the order total (excluding coupons and discounts) is ৳5,000 or more.'],
            ['ion-android-car', 'Free shipping applies to standard delivery only. Express delivery has its own charge.'],
            ['ion-map', 'This benefit is available in all districts across Bangladesh. Remote areas may take extra time.'],
            ['ion-person-stalker', 'If you order from multiple sellers at once, each seller\'s order may be calculated separately.'],
            ['ion-refresh', 'If a cancellation or partial return brings the total below the limit, a delivery charge may apply.'],
        ];

        $charges = [
            ['Inside Dhaka', '1–2 working days', '৳60'],
            ['Outside Dhaka', '3–5 working days', '৳120'],
        ];
    @endphp

    <!-- Hero -->
    <section class="sp-hero">
        <div class="container">
            <div class="sp-crumb">
                <a href="{{ route('homes') }}">Home</a><span>/</span><span>Free Shipping</span>
            </div>
            <span class="sp-badge">Home Delivery All Over Bangladesh</span>
            <h1>Free Shipping Policy</h1>
            <p>On orders at or above a set amount, we deliver your products to your address completely free of charge.</p>
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
                {{-- Conditions --}}
                <h3 class="sp-section-title">Free Shipping Conditions</h3>
                <p class="sp-section-sub">Know the details below to get free delivery.</p>
                <div class="row g-3 mb-5">
                    @foreach($conditions as $c)
                        <div class="col-12 col-md-6">
                            <div class="sp-topic">
                                <i class="{{ $c[0] }}"></i>
                                <span>{{ $c[1] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Charges --}}
                <h3 class="sp-section-title">Delivery Charges</h3>
                <p class="sp-section-sub">Charges that apply to orders outside the free shipping limit.</p>
                <div class="sp-panel mb-5">
                    <div class="table-responsive">
                        <table class="sp-table">
                            <thead>
                            <tr>
                                <th>Area</th>
                                <th>Time</th>
                                <th>Charge</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($charges as $row)
                                <tr>
                                    <td>{{ $row[0] }}</td>
                                    <td>{{ $row[1] }}</td>
                                    <td class="sp-price">{{ $row[2] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tracking --}}
                <div class="sp-note mb-5">
                    <i class="ion-location"></i>
                    <div>
                        <h6>Order Tracking</h6>
                        <p>Once your order is shipped, tracking details are sent to your mobile number and email. You can also see the current status of your order in the "My Orders" section of your account.</p>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="sp-cta">
                    <h4>Have Questions About Delivery?</h4>
                    <p>Our 24/7 support team is always by your side.</p>
                    <a href="{{ route('policy.support') }}" class="sp-btn">Contact Support</a>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.partials.static-area')
@endsection