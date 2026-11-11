@extends('layouts.frontend.app')

@section('title', '24/7 Support')

@section('content')
    @php
        $phones = array_values(array_unique(array_filter([
            $site->phone_1, $site->phone_2, $site->phone_3, $site->phone_4,
        ])));
        $emails = array_values(array_unique(array_filter([
            $site->email_1, $site->email_2, $site->email_3,
        ])));
        $whatsapp = preg_replace('/[^0-9]/', '', (string) $site->whatsapp_number);
        $hasChat = $whatsapp !== '' || $site->messenger_link;

        $topics = [
            ['ion-bag', 'Placing, changing or cancelling an order'],
            ['ion-android-car', 'Order tracking and delivery information'],
            ['ion-card', 'Failed payments or money deducted by mistake'],
            ['ion-refresh', 'Returns, refunds and replacements'],
            ['ion-person', 'Account, password and profile help'],
            ['ion-help-buoy', 'General questions about products'],
        ];
    @endphp

    <!-- Hero -->
    <section class="sp-hero">
        <div class="container">
            <div class="sp-crumb">
                <a href="{{ route('homes') }}">Home</a><span>/</span><span>24/7 Support</span>
            </div>
            <span class="sp-badge">We Are Online Now</span>
            <h1>24/7 Customer Support</h1>
            <p>Day or night, we are by your side for any problem with orders, payments, delivery or products.</p>
        </div>
    </section>

    <!-- Contact channels -->
    @if(count($phones) || count($emails) || $hasChat)
        <section class="container sp-pull">
            <div class="row g-4 justify-content-center">
                @if(count($phones))
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="sp-card">
                            <div class="sp-icon sp-ic-blue"><i class="ion-android-call"></i></div>
                            <h5>Phone</h5>
                            @foreach($phones as $phone)
                                <a class="sp-link" href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">{{ $phone }}</a>
                            @endforeach
                            <small>24 hours, every day</small>
                        </div>
                    </div>
                @endif

                @if(count($emails))
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="sp-card">
                            <div class="sp-icon sp-ic-orange"><i class="ion-android-mail"></i></div>
                            <h5>Email</h5>
                            @foreach($emails as $email)
                                <a class="sp-link" href="mailto:{{ $email }}">{{ $email }}</a>
                            @endforeach
                            <small>Reply within 24 hours</small>
                        </div>
                    </div>
                @endif

                @if($hasChat)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="sp-card">
                            <div class="sp-icon sp-ic-blue"><i class="ion-social-whatsapp"></i></div>
                            <h5>Live Chat</h5>
                            @if($whatsapp !== '')
                                <a class="sp-link" href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener">Chat on WhatsApp</a>
                            @endif
                            @if($site->messenger_link)
                                <a class="sp-link" href="{{ $site->messenger_link }}" target="_blank" rel="noopener">Chat on Messenger</a>
                            @endif
                            <small>Instant response</small>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Body -->
    <section class="container py-5 my-lg-3">
        <div class="row g-4 g-lg-5">
            <div class="col-lg-3">
                @include('frontend.policies._sidebar')
            </div>

            <div class="col-lg-9">
                {{-- Topics --}}
                <h3 class="sp-section-title">What We Can Help With</h3>
                <p class="sp-section-sub">Feel free to contact us about any of the topics below.</p>
                <div class="row g-3 mb-5">
                    @foreach($topics as $t)
                        <div class="col-12 col-md-6">
                            <div class="sp-topic">
                                <i class="{{ $t[0] }}"></i>
                                <span>{{ $t[1] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Response time --}}
                <h3 class="sp-section-title">Response Time</h3>
                <p class="sp-section-sub">We reply as quickly as possible, depending on the channel.</p>
                <div class="row g-3 mb-5">
                    <div class="col-12 col-md-4">
                        <div class="sp-stat"><em>Phone</em><b>Instant</b><span>Talk to us directly</span></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="sp-stat"><em>Live Chat</em><b>5 Minutes</b><span>Reply within</span></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="sp-stat"><em>Email / Form</em><b>24 Hours</b><span>Reply within</span></div>
                    </div>
                </div>

                {{-- Address --}}
                @if($site->address)
                    <div class="sp-address mb-5">
                        <i class="ion-android-pin"></i>
                        <div>
                            <h6>Our Address</h6>
                            <p>{!! nl2br(e($site->address)) !!}</p>
                        </div>
                    </div>
                @endif

                {{-- CTA --}}
                <div class="sp-cta">
                    <h4>Want to Send a Message Directly?</h4>
                    <p>Fill out the form and we will get back to you quickly.</p>
                    <a href="{{ route('contacts.index') }}" class="sp-btn">Go to Contact Form</a>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.partials.static-area')
@endsection