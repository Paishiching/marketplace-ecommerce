@extends('layouts.frontend.app')

@section('title', 'FAQ & Policies')

@section('content')
    @php
        $phones = array_values(array_unique(array_filter([
            $site->phone_1, $site->phone_2, $site->phone_3, $site->phone_4,
        ])));
        $emails = array_values(array_unique(array_filter([
            $site->email_1, $site->email_2, $site->email_3,
        ])));
        $whatsapp = preg_replace('/[^0-9]/', '', (string) $site->whatsapp_number);

        $highlights = [
            ['sp-ic-orange', 'ion-checkmark-circled', '100% Genuine', 'Authentic products only'],
            ['sp-ic-blue', 'ion-ribbon-b', 'Warranty', 'On eligible products'],
            ['sp-ic-orange', 'ion-android-car', 'Fast Delivery', 'All over Bangladesh'],
            ['sp-ic-blue', 'ion-refresh', '9-Day Returns', 'Free return pickup'],
        ];

        $guarantees = [
            ['ion-checkmark-circled', '100% Authentic Products', 'Every product is sourced from the brand, its authorized distributor or a verified seller. We do not sell copies or look-alikes.'],
            ['ion-ribbon-b', 'Warranty on Eligible Products', 'Eligible products come with a brand or seller warranty. The warranty type and period are written on the product page.'],
            ['ion-document-text', 'Invoice With Every Order', 'You receive an invoice for every order. Keep it, because it is your proof of purchase for any warranty claim.'],
            ['ion-cube', 'Sealed, Original Packaging', 'Products are delivered in original, sealed brand packaging with accessories and documents included.'],
            ['ion-close-circled', 'Not Genuine? Full Refund', 'If a product is proven not to be genuine, you can return it and get a full refund, with return pickup at no cost to you.'],
            ['ion-headphone', 'Warranty Help From Us', 'If you have trouble with a warranty claim, contact our support team and we will guide you through it.'],
        ];

        $deliveryRows = [
            ['Inside Dhaka', '1–2 working days', '৳60'],
            ['Outside Dhaka', '3–5 working days', '৳120'],
            ['Orders of ৳5,000 or more (standard delivery)', 'As per area', 'Free'],
        ];

        $payments = [
            ['ion-iphone', 'Mobile Banking', 'bKash, Nagad and Rocket'],
            ['ion-card', 'Card Payment', 'Visa, Mastercard and local debit/credit cards'],
            ['ion-earth', 'Internet Banking', 'Online payment through selected banks'],
            ['ion-cash', 'Cash on Delivery', 'Pay when you receive your product'],
        ];

        $warrantySteps = [
            ['Keep Your Invoice', 'Save your invoice and the warranty card (if included in the box). Both are needed for a claim.'],
            ['Contact Us', 'Tell our support team your order number and describe the problem, with photos or a short video if possible.'],
            ['Verification', 'We check your claim against the warranty terms of that product and tell you the next step.'],
            ['Repair or Replacement', 'If the claim is valid, the product is repaired or replaced under the warranty terms.'],
        ];

        $returnSteps = [
            ['Select Your Order', 'Log in and choose the order from "My Orders".'],
            ['Submit a Return Request', 'Click "Return Request", write the reason and add photos if needed.'],
            ['Review', 'Our team reviews your request within 24 hours.'],
            ['Product Pickup', 'After approval, our representative collects the product from your address.'],
            ['Refund / Replacement', 'After the product is checked, the refund or replacement starts. Refunds usually complete in 5–7 working days.'],
        ];

        $trackSteps = [
            ['ion-checkmark', 'Order Placed', 'You get a confirmation by email and SMS.'],
            ['ion-gear-b', 'Processing', 'We check, pack and prepare your product.'],
            ['ion-android-car', 'Shipped', 'Tracking details are sent to your mobile number and email.'],
            ['ion-home', 'Delivered', 'The product reaches your address.'],
        ];

        $faqGroups = [
            'Delivery' => [
                ['How long does delivery take?', 'Inside Dhaka it usually takes 1–2 working days. Outside Dhaka it takes 3–5 working days. Remote areas may take a little longer.'],
                ['Is delivery free?', 'Standard delivery is free on orders of ৳5,000 or more (excluding coupons and discounts). Below that amount, a delivery charge of ৳60 inside Dhaka or ৳120 outside Dhaka applies.'],
                ['Do you deliver all over Bangladesh?', 'Yes, we deliver to all districts of Bangladesh.'],
            ],
            'Payment' => [
                ['Which payment methods do you accept?', 'We accept mobile banking (bKash, Nagad, Rocket), Visa and Mastercard, internet banking and Cash on Delivery.'],
                ['Is it safe to pay online?', 'Yes. The whole website is protected with SSL encryption and we never store your card details on our servers.'],
                ['My payment failed but money was deducted. What now?', 'The amount is usually refunded automatically within 7 working days. If it does not arrive, contact support with your order number and transaction ID.'],
            ],
            'Authenticity & Warranty' => [
                ['Are all your products original?', 'Yes. We sell only authentic products sourced from brands, authorized distributors or verified sellers.'],
                ['How do I know my product has a warranty?', 'The warranty type and period are shown on each product page. Your invoice and the warranty card in the box are your proof.'],
                ['What does the warranty not cover?', 'Usually physical damage, water damage, burn marks, unauthorized repair and misuse are not covered. The exact terms depend on the product, so check its page.'],
                ['What if I receive a product that is not genuine?', 'Contact us right away. If it is proven not to be genuine, you can return it and receive a full refund.'],
            ],
            'Returns & Refunds' => [
                ['How many days do I have to return a product?', 'You can request a return within 9 days of receiving the product.'],
                ['Which products cannot be returned?', 'Innerwear, personal care and cosmetic items, food and perishable goods, digital products and gift cards, used or altered products, and items marked "No Return".'],
                ['How and when will I get my refund?', 'The refund goes back through your original payment method. For Cash on Delivery orders it is sent to your mobile banking number. It usually completes within 5–7 working days after the product is checked.'],
            ],
            'Orders & Support' => [
                ['How can I track my order?', 'Open "My Orders" in your account. Tracking details are also sent to your mobile number and email once the order ships.'],
                ['Can I change or cancel my order?', 'Yes, before it is shipped. Contact support as soon as possible with your order number.'],
                ['How can I reach customer support?', 'Our team is available 24/7 by phone, WhatsApp and live chat. Emails get a reply within 24 hours.'],
            ],
        ];
    @endphp

    <!-- Hero -->
    <section class="sp-hero">
        <div class="container">
            <div class="sp-crumb">
                <a href="{{ route('homes') }}">Home</a><span>/</span><span>FAQ &amp; Policies</span>
            </div>
            <span class="sp-badge">Shop With Confidence</span>
            <h1>FAQ &amp; Policies</h1>
            <p>Everything you need to know about delivery, payment, warranty, returns, order tracking and support, with our promise that every product is genuine.</p>
        </div>
    </section>

    <!-- Highlights -->
    <section class="container sp-pull">
        <div class="row g-4 justify-content-center">
            @foreach($highlights as $h)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="sp-card">
                        <div class="sp-icon {{ $h[0] }}"><i class="{{ $h[1] }}"></i></div>
                        <h5>{{ $h[2] }}</h5>
                        <p class="sp-desc">{{ $h[3] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <style>
        /* ===== FAQ page (fq) — uses only the --sp-* colors ===== */
        .fq-guarantee{background:var(--sp-n);border-bottom:5px solid var(--sp-o);border-radius:20px;padding:34px 28px;box-shadow:0 18px 40px rgba(42,53,130,.30)}
        .fq-guarantee h3{color:var(--sp-w)!important;font-weight:800;font-size:26px;margin-bottom:6px}
        .fq-guarantee .fq-sub{color:var(--sp-w);opacity:.85;margin-bottom:26px}
        .fq-g-item{display:flex;gap:14px;align-items:flex-start;height:100%;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.2);border-radius:14px;padding:18px}
        .fq-g-item i{flex:0 0 44px;height:44px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;background:var(--sp-o);color:var(--sp-w);font-size:22px}
        .fq-g-item b{display:block;color:var(--sp-w);margin-bottom:4px}
        .fq-g-item span{display:block;color:var(--sp-w);opacity:.85;font-size:14px;line-height:1.6}

        .fq-group-title{font-size:18px;font-weight:800;color:var(--sp-n);margin:26px 0 12px;padding-left:12px;border-left:5px solid var(--sp-o)}
        .fq-acc details{background:var(--sp-w);border:1px solid rgba(42,53,130,.12);border-radius:14px;margin-bottom:10px;overflow:hidden;transition:all .25s ease}
        .fq-acc details:hover{border-color:var(--sp-o)}
        .fq-acc details[open]{border-color:var(--sp-o);box-shadow:0 8px 22px rgba(253,104,1,.12)}
        .fq-acc summary{list-style:none;cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 18px;font-weight:700;color:var(--sp-n)}
        .fq-acc summary::-webkit-details-marker{display:none}
        .fq-acc summary:after{content:"+";flex:0 0 28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:rgba(253,104,1,.12);color:var(--sp-o);font-size:20px;font-weight:700;line-height:1}
        .fq-acc details[open] summary:after{content:"\2212";background:var(--sp-o);color:var(--sp-w)}
        .fq-acc .fq-ans{padding:0 18px 18px;color:var(--sp-n);opacity:.8;line-height:1.7}

        .fq-track{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
        .fq-track-item{text-align:center;background:var(--sp-w);border:1px solid rgba(42,53,130,.12);border-top:4px solid var(--sp-o);border-radius:14px;padding:20px 14px}
        .fq-track-item i{display:inline-flex;width:46px;height:46px;border-radius:50%;align-items:center;justify-content:center;background:var(--sp-n);color:var(--sp-w);font-size:22px;margin-bottom:10px}
        .fq-track-item b{display:block;color:var(--sp-n);margin-bottom:4px}
        .fq-track-item span{display:block;color:var(--sp-n);opacity:.75;font-size:14px;line-height:1.5}
        @media(max-width:767px){.fq-track{grid-template-columns:repeat(2,1fr)}.fq-guarantee{padding:26px 18px}}
    </style>

    <!-- Body -->
    <section class="container py-5 my-lg-3">
        <div class="row g-4 g-lg-5">
            <div class="col-lg-3">
                @include('frontend.policies._sidebar')
            </div>

            <div class="col-lg-9">

                {{-- Authenticity & Warranty guarantee --}}
                <div class="fq-guarantee mb-5">
                    <h3>Authenticity &amp; Warranty Guarantee</h3>
                    <p class="fq-sub">Our promise to you: what you order is genuine, and it is backed by a warranty.</p>
                    <div class="row g-3">
                        @foreach($guarantees as $g)
                            <div class="col-12 col-md-6">
                                <div class="fq-g-item">
                                    <i class="{{ $g[0] }}"></i>
                                    <div><b>{{ $g[1] }}</b><span>{{ $g[2] }}</span></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Delivery --}}
                <h3 class="sp-section-title">Delivery Time &amp; Charges</h3>
                <p class="sp-section-sub">How long delivery takes and what it costs.</p>
                <div class="sp-panel mb-5">
                    <div class="table-responsive">
                        <table class="sp-table">
                            <thead>
                            <tr><th>Area</th><th>Time</th><th>Charge</th></tr>
                            </thead>
                            <tbody>
                            @foreach($deliveryRows as $row)
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

                {{-- Payment --}}
                <h3 class="sp-section-title">Payment Methods</h3>
                <p class="sp-section-sub">Choose the option that suits you. All online payments are SSL encrypted.</p>
                <div class="row g-3 mb-5">
                    @foreach($payments as $p)
                        <div class="col-12 col-md-6">
                            <div class="sp-topic">
                                <i class="{{ $p[0] }}"></i>
                                <span><b style="display:block;">{{ $p[1] }}</b>{{ $p[2] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Warranty --}}
                <h3 class="sp-section-title">Warranty Policy</h3>
                <p class="sp-section-sub">How to claim your warranty in 4 simple steps.</p>
                <ul class="sp-steps mb-4">
                    @foreach($warrantySteps as $i => $step)
                        <li>
                            <span class="sp-num">{{ $i + 1 }}</span>
                            <div class="sp-step-body"><b>{{ $step[0] }}</b><span>{{ $step[1] }}</span></div>
                        </li>
                    @endforeach
                </ul>
                <div class="sp-note mb-5">
                    <i class="ion-information-circled"></i>
                    <div>
                        <h6>Warranty terms differ by product</h6>
                        <p>The warranty type (brand or seller) and period are shown on each product page. Damage caused by misuse, water, burning or unauthorized repair is usually not covered.</p>
                    </div>
                </div>

                {{-- Return & refund --}}
                <h3 class="sp-section-title">Return &amp; Refund Process</h3>
                <p class="sp-section-sub">Return a product within 9 days in 5 easy steps.</p>
                <ul class="sp-steps mb-4">
                    @foreach($returnSteps as $i => $step)
                        <li>
                            <span class="sp-num">{{ $i + 1 }}</span>
                            <div class="sp-step-body"><b>{{ $step[0] }}</b><span>{{ $step[1] }}</span></div>
                        </li>
                    @endforeach
                </ul>
                <div class="sp-note mb-5">
                    <i class="ion-cash"></i>
                    <div>
                        <h6>Refund method</h6>
                        <p>Refunds go back through your original payment method. For Cash on Delivery orders, the refund is sent to your mobile banking number. It usually completes within 5–7 working days after the product is checked.</p>
                    </div>
                </div>

                {{-- Tracking --}}
                <h3 class="sp-section-title">Order Tracking</h3>
                <p class="sp-section-sub">Follow your order from checkout to your door.</p>
                <div class="fq-track mb-3">
                    @foreach($trackSteps as $t)
                        <div class="fq-track-item">
                            <i class="{{ $t[0] }}"></i>
                            <b>{{ $t[1] }}</b>
                            <span>{{ $t[2] }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="sp-section-sub mb-5">You can also see your order status anytime in the "My Orders" section of your account.</p>

                {{-- Support --}}
                <h3 class="sp-section-title">Customer Support</h3>
                <p class="sp-section-sub">We are available 24/7. Reach us the way you prefer.</p>
                <div class="row g-3 mb-5">
                    <div class="col-12 col-md-4">
                        <div class="sp-stat"><em>Phone</em><b>Instant</b><span>
                            @forelse($phones as $phone)
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" style="color:inherit;">{{ $phone }}</a><br>
                            @empty
                                Talk to us directly
                            @endforelse
                        </span></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="sp-stat"><em>Live Chat</em><b>5 Minutes</b><span>
                            @if($whatsapp !== '')
                                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" style="color:inherit;">Chat on WhatsApp</a>
                            @else
                                Reply within
                            @endif
                        </span></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="sp-stat"><em>Email</em><b>24 Hours</b><span>
                            @forelse($emails as $email)
                                <a href="mailto:{{ $email }}" style="color:inherit;">{{ $email }}</a><br>
                            @empty
                                Reply within
                            @endforelse
                        </span></div>
                    </div>
                </div>

                {{-- FAQ --}}
                <h3 class="sp-section-title">Frequently Asked Questions</h3>
                <p class="sp-section-sub">Quick answers to common questions. Click a question to open it.</p>
                <div class="fq-acc mb-5">
                    @foreach($faqGroups as $group => $items)
                        <div class="fq-group-title">{{ $group }}</div>
                        @foreach($items as $item)
                            <details>
                                <summary>{{ $item[0] }}</summary>
                                <div class="fq-ans">{{ $item[1] }}</div>
                            </details>
                        @endforeach
                    @endforeach
                </div>

                {{-- CTA --}}
                <div class="sp-cta">
                    <h4>Still have a question?</h4>
                    <p>Our 24/7 support team is always by your side.</p>
                    <a href="{{ route('contacts.index') }}" class="sp-btn">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.partials.static-area')
@endsection