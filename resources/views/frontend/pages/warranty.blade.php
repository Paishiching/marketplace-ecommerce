@extends('layouts.frontend.app')

@section('title', 'Warranty Period Enquiry')

@section('content')

    @php
        $hotline  = optional($site ?? null)->phone_1;
        $waNumber = preg_replace('/[^0-9]/', '', (string) optional($site ?? null)->whatsapp_number);
        $chatUrl  = $waNumber !== ''
            ? 'https://wa.me/' . $waNumber
            : (optional($site ?? null)->messenger_link ?: route('contacts.index'));
    @endphp

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-warranty.css?v=3">

    <div class="wr-page">

        {{-- ================= HERO ================= --}}
        <section class="wr-hero">
            <div class="container">
                <div class="wr-crumb">
                    <a href="{{ route('homes') }}">Home</a>
                    <span>/</span>
                    <b>Warranty Period Enquiry</b>
                </div>

                <span class="wr-pill"><i></i> Genuine Product Warranty</span>

                <h1>Warranty Period Enquiry</h1>
                <p>Enter your product serial number and registered mobile number to instantly check your purchase date and warranty expiry.</p>
            </div>
        </section>

        <div class="container">

            {{-- ================= Enquiry form ================= --}}
            <section class="wr-box">
                <h2 class="wr-box-title">Check your warranty</h2>

                <form action="{{ route('warranty.check') }}" method="POST" class="wr-form" novalidate>
                    @csrf

                    <div class="wr-field">
                        <label for="wrSerial">Please enter your product S/N code :</label>
                        <input type="text" id="wrSerial" name="serial" value="{{ old('serial') }}" maxlength="60" autocomplete="off"
                               class="{{ $errors->has('serial') ? 'bad' : '' }}">
                        @error('serial')<span class="wr-err">{{ $message }}</span>@enderror
                    </div>

                    <div class="wr-field">
                        <label for="wrMobile">Mobile :</label>
                        <input type="text" id="wrMobile" name="mobile" value="{{ old('mobile') }}" maxlength="20" autocomplete="off"
                               class="{{ $errors->has('mobile') ? 'bad' : '' }}">
                        @error('mobile')<span class="wr-err">{{ $message }}</span>@enderror
                    </div>

                    <div class="wr-action">
                        <button type="submit">Confirm</button>
                    </div>
                </form>

                {{-- ===== Result ===== --}}
                @if($searched)
                    <div class="wr-result">
                        @if($warranty)
                            <h3>The query results are as follows :</h3>
                            <div class="wr-status {{ $warranty->is_active ? 'ok' : 'exp' }}">
                                {{ $warranty->is_active ? 'Under Warranty' : 'Warranty Expired' }}
                            </div>
                            <ul class="wr-rows">
                                @if($warranty->product_name)
                                    <li><span>Product :</span><b>{{ $warranty->product_name }}</b></li>
                                @endif
                                <li><span>Date of purchase :</span><b>{{ $warranty->purchase_date->format('d M Y') }}</b></li>
                                <li><span>Your product warranty period expires at :</span><b class="hl">{{ $warranty->expires_at->format('d M Y') }}</b></li>
                            </ul>
                        @else
                            <p class="wr-nf">No registration information was found for the provided serial number and mobile.<br>
                                Please check the details again or contact our support team.</p>
                        @endif
                    </div>
                @endif
            </section>

            {{-- ================= How it works ================= --}}
            <section class="wr-steps">
                <div class="wr-step">
                    <span class="n">1</span>
                    <b>Find your S/N</b>
                    <p>Product er label e thaka Serial Number ta khuje ber korun.</p>
                </div>
                <div class="wr-step">
                    <span class="n">2</span>
                    <b>Enter details</b>
                    <p>S/N ar purchase er somoy deya mobile number ta likhun.</p>
                </div>
                <div class="wr-step">
                    <span class="n">3</span>
                    <b>Get your result</b>
                    <p>Purchase date ar warranty expiry date sathe sathe dekhun.</p>
                </div>
            </section>

            {{-- ================= How to find S/N ================= --}}
            <section class="wr-find">
                <h2>How to find your product S/N code</h2>
                <p>You can find the 20 digit barcode in the reference illustration label on the front, side, and other positions of the home appliance body.</p>

                <div class="wr-samples">

                    {{-- Sample 1 : blue label --}}
                    <div class="wr-sample">
                        <span class="wr-sl">Sample 1</span>
                        <div class="wr-frame">
                            <div class="wr-lbl1">
                                <div class="top"></div>
                                <div class="qr">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h8v8H3zM5 5v4h4V5zM13 3h8v8h-8zM15 5v4h4V5zM3 13h8v8H3zM5 15v4h4v-4zM13 13h3v3h-3zM17 13h4v2h-4zM13 17h2v4h-2zM16 17h5v4h-5z"/></svg>
                                </div>
                                <div class="wr-bar sm"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Sample 2 : QR label --}}
                    <div class="wr-sample">
                        <span class="wr-sl">Sample 2</span>
                        <div class="wr-frame">
                            <div class="wr-lbl2">
                                <small>Globally Harmonized System of Marking</small>
                                <div class="row">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h8v8H3zM5 5v4h4V5zM13 3h8v8h-8zM15 5v4h4V5zM3 13h8v8H3zM5 15v4h4v-4zM13 13h3v3h-3zM17 13h4v2h-4zM13 17h2v4h-2zM16 17h5v4h-5z"/></svg>
                                    <div>
                                        <b>Scanning QR Code</b>
                                        <span>Enjoy personalized service</span>
                                        <div class="wr-bar xs"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sample 3 : Serial number text + barcode --}}
                    <div class="wr-sample">
                        <span class="wr-sl">Sample 3</span>
                        <div class="wr-frame">
                            <div class="wr-lbl3">
                                <div>BBB-AAAAAAAA</div>
                                <div>Serial Number: &nbsp;88888 88888 88888 88888</div>
                                <div class="wr-bar"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Sample 4 : Rating plate + barcode --}}
                    <div class="wr-sample">
                        <span class="wr-sl">Sample 4</span>
                        <div class="wr-frame">
                            <div class="wr-lbl4">
                                <div class="plate"><i></i><i></i><i></i><i></i></div>
                                <div class="code">
                                    <small>GA0G9600000GHABF0159</small>
                                    <div class="wr-bar"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- ================= Need further support ================= --}}
            <section class="wr-support">
                <h2>Need Further Support?</h2>
                <div class="wr-tiles">

                    <a href="{{ route('complaint.index') }}" class="wr-tile">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a4 4 0 0 0-5.4 5l-6 6a1.8 1.8 0 0 0 2.5 2.5l6-6a4 4 0 0 0 5-5.4l-2.4 2.4-2.1-.5-.5-2.1 2.4-2.4z"/><path d="M14 14l5 5M20 4l-6 6M17 3l4 4"/></svg>
                        <span>Service Request<br>Registration</span>
                    </a>

                    <a href="{{ $hotline ? 'tel:' . preg_replace('/[^0-9+]/', '', $hotline) : route('contacts.index') }}" class="wr-tile">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25c1.1.37 2.3.57 3.6.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.6 21 3 13.4 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1z"/><path d="M15 3.5a6 6 0 0 1 5.5 5.5M15 7a3 3 0 0 1 2.5 2.5"/></svg>
                        <span>Toll Free Hotline<br>Number</span>
                    </a>

                    <a href="{{ $chatUrl }}" target="_blank" rel="noopener" class="wr-tile">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14v-2a8 8 0 0 1 16 0v2"/><rect x="3" y="13" width="4" height="6" rx="1.5"/><rect x="17" y="13" width="4" height="6" rx="1.5"/><path d="M19 19c0 1.5-2 2.5-5 2.5"/></svg>
                        <span>Live Chat</span>
                    </a>

                </div>
            </section>

        </div>
    </div>

@endsection