@extends('layouts.frontend.app')

@section('title', 'About Us')

@section('content')
    @php
        $values = [
            ['ion-checkmark-circled', 'orange', 'Authentic Brands', 'A wide selection of genuine domestic and international electronics brands.'],
            ['ion-ribbon-b', 'navy', 'Quality & Innovation', 'Driven by a passion for quality products and modern technology.'],
            ['ion-happy', 'orange', 'Customer Satisfaction', 'Absolute satisfaction for every customer, at every step.'],
            ['ion-heart', 'navy', 'Reliable Service', 'Lasting relationships built on reliability, excellence and exceptional service.'],
        ];
    @endphp

    <style>
        /* ===== About page (ab) — only #fd6801, #2a3582, #ffffff ===== */
        .ab-page{--ab-o:#fd6801;--ab-n:#2a3582;--ab-w:#ffffff}

        .ab-hero{position:relative;overflow:hidden;text-align:center;padding:56px 0 70px;background:var(--ab-n);border-bottom:5px solid var(--ab-o)}
        .ab-hero:before,.ab-hero:after{content:"";position:absolute;border-radius:50%;background:var(--ab-w);opacity:.07}
        .ab-hero:before{width:260px;height:260px;top:-100px;left:-70px}
        .ab-hero:after{width:200px;height:200px;bottom:-90px;right:-50px}
        .ab-hero .container{position:relative;z-index:1}
        .ab-hero h1{color:var(--ab-w)!important;font-size:2.3rem;font-weight:800;line-height:1.3;margin:0}
        .ab-crumb{display:flex;justify-content:center;gap:8px;margin-bottom:14px;font-size:13px;color:var(--ab-w)}
        .ab-crumb a{color:var(--ab-w)}
        .ab-crumb a:hover{color:var(--ab-o)}

        .ab-image{position:relative}
        .ab-image img{width:100%;border-radius:20px;box-shadow:0 18px 40px rgba(42,53,130,.25);display:block}
        .ab-image:after{content:"";position:absolute;right:-14px;bottom:-14px;width:60%;height:60%;border-right:5px solid var(--ab-o);border-bottom:5px solid var(--ab-o);border-radius:0 0 20px 0;z-index:-1}

        .ab-tag{display:inline-block;background:rgba(253,104,1,.12);color:var(--ab-o);font-weight:700;font-size:13px;letter-spacing:1px;text-transform:uppercase;border-radius:50px;padding:6px 16px;margin-bottom:14px}
        .ab-title{font-size:30px;font-weight:800;color:var(--ab-n);margin-bottom:16px;line-height:1.3}
        .ab-text{color:var(--ab-n);opacity:.85;font-size:16px;line-height:1.9;margin:0}

        .ab-card{height:100%;text-align:center;background:var(--ab-w);border:1px solid rgba(42,53,130,.12);border-radius:18px;padding:28px 22px;box-shadow:0 10px 30px rgba(42,53,130,.10);transition:all .3s ease}
        .ab-card:hover{transform:translateY(-8px);border-color:var(--ab-o);box-shadow:0 20px 44px rgba(42,53,130,.20)}
        .ab-ico{width:64px;height:64px;border-radius:18px;display:inline-flex;align-items:center;justify-content:center;font-size:30px;color:var(--ab-w);margin-bottom:16px;transition:transform .3s ease}
        .ab-card:hover .ab-ico{transform:rotate(-8deg) scale(1.08)}
        .ab-ico.orange{background:var(--ab-o);box-shadow:0 8px 20px rgba(253,104,1,.40)}
        .ab-ico.navy{background:var(--ab-n);box-shadow:0 8px 20px rgba(42,53,130,.40)}
        .ab-card h5{font-size:18px;font-weight:700;color:var(--ab-n);margin-bottom:8px}
        .ab-card p{color:var(--ab-n);opacity:.75;margin:0;line-height:1.6}

        .ab-cta{border-radius:20px;padding:36px 28px;text-align:center;background:var(--ab-n);border-bottom:5px solid var(--ab-o);box-shadow:0 18px 40px rgba(42,53,130,.30)}
        .ab-cta h4{color:var(--ab-w)!important;font-weight:800;margin-bottom:8px}
        .ab-cta p{color:var(--ab-w);opacity:.9;margin-bottom:20px}
        .ab-cta a{display:inline-block;background:var(--ab-o);color:var(--ab-w)!important;font-weight:700;padding:13px 34px;border-radius:50px;transition:all .3s ease}
        .ab-cta a:hover{background:var(--ab-w);color:var(--ab-n)!important;transform:translateY(-3px)}

        @media(max-width:767px){.ab-hero{padding:44px 0 56px}.ab-hero h1{font-size:1.7rem}.ab-title{font-size:24px}}
    </style>

    <div class="ab-page">

        <!-- Hero -->
        <section class="ab-hero">
            <div class="container">
                <div class="ab-crumb">
                    <a href="{{ route('homes') }}">Home</a><span>/</span><span>About Us</span>
                </div>
                <h1>About Us</h1>
            </div>
        </section>

        <!-- About -->
        <section class="container py-5 my-lg-3">
            <div class="row g-4 g-lg-5 align-items-center">
                <div class="col-lg-6">
                    <div class="ab-image">
                        <img src="{{ asset('/') }}frontend/assets/images/slider-image/sample-3.jpg" alt="About Us">
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="ab-tag">Who We Are</span>
                    <h2 class="ab-title">Your trusted destination for top-tier electronics</h2>
                    <p class="ab-text">
                        Welcome to Buydor, your trusted destination for top-tier electronics. We are committed to redefining your shopping experience by offering an unmatched selection of authentic domestic and international brands. Driven by a passion for quality and innovation, our core mission is to ensure absolute customer satisfaction at every step. At Buydor, we don't just sell electronics—we build lasting relationships through reliability, excellence, and exceptional service.
                    </p>
                </div>
            </div>

            <!-- Values -->
            <div class="row g-4 mt-4">
                @foreach($values as $v)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="ab-card">
                            <div class="ab-ico {{ $v[1] }}"><i class="{{ $v[0] }}"></i></div>
                            <h5>{{ $v[2] }}</h5>
                            <p>{{ $v[3] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- CTA -->
            <div class="ab-cta mt-5">
                <h4>Have a question for us?</h4>
                <p>Our team is always happy to help.</p>
                <a href="{{ route('contacts.index') }}">Contact Us</a>
            </div>
        </section>

    </div>

    @include('frontend.partials.static-area')
@endsection

