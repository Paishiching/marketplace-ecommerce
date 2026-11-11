@extends('layouts.frontend.app')

@section('title', 'Contact')

@section('content')
    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Facades\Cache;
        use Illuminate\Support\Facades\Http;

        $phones = array_values(array_unique(array_filter([
            $site->phone_1, $site->phone_2, $site->phone_3, $site->phone_4,
        ])));
        $emails = array_values(array_unique(array_filter([
            $site->email_1, $site->email_2, $site->email_3,
        ])));
        $addressLines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string) $site->address)));
        $whatsapp = preg_replace('/[^0-9]/', '', (string) $site->whatsapp_number);

        $socials = [
            ['icon' => 'ion-social-facebook',  'url' => $site->facebook_url,  'label' => 'Facebook'],
            ['icon' => 'ion-social-instagram', 'url' => $site->instagram_url, 'label' => 'Instagram'],
            ['icon' => 'ion-social-twitter',   'url' => $site->twitter_url,   'label' => 'Twitter'],
            ['icon' => 'ion-social-youtube',   'url' => $site->youtube_url,   'label' => 'YouTube'],
            ['icon' => 'ion-social-linkedin',  'url' => $site->linkedin_url,  'label' => 'LinkedIn'],
        ];
        $socials = array_filter($socials, fn ($s) => !empty($s['url']));

        // ---------- Map resolve ----------
        $map1 = trim((string) $site->google_map_1);
        $map2 = trim((string) $site->google_map_2);
        $mapIframeHtml = null;
        $mapEmbedSrc   = null;
        $mapLink       = null;

        $resolveToEmbed = function (string $url) {
            return Cache::remember('map.embed.' . md5($url), now()->addDays(30), function () use ($url) {
                try {
                    $current = $url;
                    for ($i = 0; $i < 6; $i++) {
                        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $current, $m)) {
                            return 'https://maps.google.com/maps?q=' . $m[1] . ',' . $m[2] . '&z=16&output=embed';
                        }
                        if (preg_match('/[?&]q=([^&]+)/', $current, $m)) {
                            return 'https://maps.google.com/maps?q=' . $m[1] . '&z=16&output=embed';
                        }
                        if (preg_match('#/maps/place/([^/@?]+)#', $current, $m)) {
                            return 'https://maps.google.com/maps?q=' . $m[1] . '&z=16&output=embed';
                        }
                        $res = Http::withoutRedirecting()->timeout(6)
                            ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                            ->get($current);
                        $loc = $res->header('Location');
                        if (!$loc) break;
                        $current = Str::startsWith($loc, ['http://', 'https://']) ? $loc : 'https://www.google.com' . $loc;
                    }
                } catch (\Throwable $e) {
                    // fallback below
                }
                return null;
            });
        };

        foreach ([$map1, $map2] as $candidate) {
            if ($candidate === '') continue;

            if (Str::contains($candidate, '<iframe')) {
                $mapIframeHtml = $candidate;
                break;
            }
            if (Str::contains($candidate, ['google.com/maps/embed', 'output=embed'])) {
                $mapEmbedSrc = $candidate;
                break;
            }
            if (Str::startsWith($candidate, ['http://', 'https://'])) {
                $mapLink = $mapLink ?: $candidate;
                $resolved = $resolveToEmbed($candidate);
                if ($resolved) {
                    $mapEmbedSrc = $resolved;
                    break;
                }
            }
        }
    @endphp

    <style>
        /* ===== Contact page (ct) — only #fd6801, #2a3582, #ffffff ===== */
        .ct-page{--ct-o:#fd6801;--ct-n:#2a3582;--ct-w:#ffffff;color:var(--ct-n)}
        .ct-page h1,.ct-page h3,.ct-page h4,.ct-page h5,.ct-page h6{color:var(--ct-n)}
        .ct-page .ct-muted{color:var(--ct-n);opacity:.75}
        .ct-page a.ct-muted:hover{color:var(--ct-o);opacity:1}

        /* Hero */
        .ct-hero{background:var(--ct-n);padding:64px 0 96px;border-bottom:5px solid var(--ct-o)}
        .ct-hero h1{color:var(--ct-w)!important;font-size:2.4rem;line-height:1.3}
        .ct-hero p{color:var(--ct-w)!important;opacity:.9;max-width:620px;font-size:1.05rem}
        .ct-hero .ct-crumb,.ct-hero .ct-crumb a{color:var(--ct-w);text-decoration:none}
        .ct-hero .ct-crumb a:hover{color:var(--ct-o)}
        .ct-hero .ct-bubble{position:absolute;border-radius:50%;background:var(--ct-w);opacity:.07}

        /* Cards */
        .ct-card{background:var(--ct-w);border:1px solid rgba(42,53,130,.12)!important;border-radius:18px!important;box-shadow:0 8px 24px rgba(42,53,130,.10)!important}
        .ct-card-navy{background:var(--ct-n)!important;border:0!important;border-radius:18px!important;color:var(--ct-w)}
        .ct-card-navy h4{color:var(--ct-w)!important}
        .ct-card-navy i{color:var(--ct-o)}

        /* Icon circles */
        .ct-ico{width:64px;height:64px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem}
        .ct-ico.o{background:rgba(253,104,1,.12);color:var(--ct-o)}
        .ct-ico.n{background:rgba(42,53,130,.10);color:var(--ct-n)}

        /* Buttons */
        .ct-btn{background:var(--ct-o);color:var(--ct-w);border:2px solid var(--ct-o);font-weight:700;transition:all .25s ease}
        .ct-btn:hover,.ct-btn:focus{background:var(--ct-n);border-color:var(--ct-n);color:var(--ct-w)}
        .ct-btn:disabled{background:var(--ct-o);border-color:var(--ct-o);color:var(--ct-w);opacity:.7}
        .ct-btn-navy{background:var(--ct-n);color:var(--ct-w);border:2px solid var(--ct-n);font-weight:700;transition:all .25s ease}
        .ct-btn-navy:hover,.ct-btn-navy:focus{background:var(--ct-o);border-color:var(--ct-o);color:var(--ct-w)}
        .ct-social{width:46px;height:46px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:var(--ct-n);color:var(--ct-w);text-decoration:none;transition:all .25s ease}
        .ct-social:hover{background:var(--ct-o);color:var(--ct-w);transform:translateY(-3px)}

        /* Form */
        .ct-page .form-control{border:1px solid rgba(42,53,130,.25);color:var(--ct-n);background-color:var(--ct-w)}
        .ct-page .form-control:focus{border-color:var(--ct-n);box-shadow:0 0 0 .2rem rgba(42,53,130,.15);background-color:var(--ct-w)}
        .ct-page .form-floating>label{color:var(--ct-n);opacity:.7}
        .ct-page .form-control.is-valid{border-color:var(--ct-n);background-image:none;padding-right:.75rem}
        .ct-page .form-control.is-invalid{border-color:var(--ct-o);background-image:none;padding-right:.75rem}
        .ct-page .form-control.is-valid:focus{box-shadow:0 0 0 .2rem rgba(42,53,130,.15)}
        .ct-page .form-control.is-invalid:focus{box-shadow:0 0 0 .2rem rgba(253,104,1,.2)}
        .ct-page .invalid-feedback{color:var(--ct-o)}
        .ct-page .spinner-border{color:var(--ct-w)}

        /* Alerts (all variants use only the 3 colors) */
        .ct-page .alert{background:var(--ct-w);color:var(--ct-n);border:1px solid var(--ct-n);border-left:5px solid var(--ct-n);border-radius:12px}
        .ct-page .alert-danger,.ct-page .alert-warning{border-color:var(--ct-o);border-left-color:var(--ct-o)}

        /* Accordion */
        .ct-page .accordion-item{background:transparent;border-color:rgba(42,53,130,.12)}
        .ct-page .accordion-button{background:transparent;color:var(--ct-n);font-weight:700;box-shadow:none}
        .ct-page .accordion-button:not(.collapsed){background:rgba(42,53,130,.06);color:var(--ct-n);box-shadow:none}
        .ct-page .accordion-button:focus{border-color:var(--ct-n);box-shadow:0 0 0 .15rem rgba(42,53,130,.15)}
        .ct-page .accordion-button::after{background-image:none!important;content:"+";transform:none!important;width:auto;height:auto;font-size:1.3rem;font-weight:700;line-height:1;color:var(--ct-o)}
        .ct-page .accordion-button:not(.collapsed)::after{content:"\2212"}
        .ct-page .accordion-body{color:var(--ct-n);opacity:.8}

        @media(max-width:575px){.ct-hero{padding:48px 0 80px}.ct-hero h1{font-size:1.8rem}}
    </style>

    <div class="ct-page">

        <!-- Hero -->
        <section class="ct-hero text-center position-relative overflow-hidden">
            <div class="container position-relative" style="z-index:1;">
                <div class="ct-crumb d-flex justify-content-center align-items-center gap-2 mb-3 small">
                    <a href="{{ route('homes') }}">Home</a>
                    <span>/</span>
                    <span style="font-weight:600;">Contact</span>
                </div>
                <h1 class="fw-bold mb-3">Get in Touch With Us</h1>
                <p class="mx-auto mb-0">
                    We are always ready to help with any question, order or support request. Send us a message and we will reply quickly.
                </p>
            </div>
            <div class="ct-bubble" style="width:260px;height:260px;top:-90px;left:-70px;"></div>
            <div class="ct-bubble" style="width:200px;height:200px;bottom:-80px;right:-50px;"></div>
        </section>

        <!-- Info cards -->
        <section class="container" style="margin-top: -56px; position: relative; z-index: 2;">
            <div class="row g-4">
                @if(count($phones))
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card ct-card h-100 text-center">
                            <div class="card-body p-4">
                                <div class="ct-ico o"><i class="ion-android-call fs-2"></i></div>
                                <h5 class="fw-bold">Phone</h5>
                                @foreach($phones as $phone)
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="d-block text-decoration-none ct-muted">{{ $phone }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(count($emails))
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card ct-card h-100 text-center">
                            <div class="card-body p-4">
                                <div class="ct-ico n"><i class="ion-android-mail fs-2"></i></div>
                                <h5 class="fw-bold">Email</h5>
                                @foreach($emails as $email)
                                    <a href="mailto:{{ $email }}" class="d-block text-decoration-none ct-muted text-break">{{ $email }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(count($addressLines))
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card ct-card h-100 text-center">
                            <div class="card-body p-4">
                                <div class="ct-ico o"><i class="ion-android-pin fs-2"></i></div>
                                <h5 class="fw-bold">Address</h5>
                                @foreach($addressLines as $line)
                                    <div class="ct-muted">{{ $line }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if($whatsapp !== '')
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card ct-card h-100 text-center">
                            <div class="card-body p-4">
                                <div class="ct-ico n"><i class="ion-social-whatsapp fs-2"></i></div>
                                <h5 class="fw-bold">WhatsApp</h5>
                                <p class="ct-muted mb-3">Chat with us directly</p>
                                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="btn ct-btn rounded-pill px-4">Start Chat</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Form + side info -->
        <section class="container py-5 my-lg-4">
            <div class="row g-4 g-lg-5 align-items-stretch">
                <div class="col-lg-7">
                    <div class="card ct-card h-100">
                        <div class="card-body p-4 p-lg-5">
                            <h3 class="fw-bold mb-1">Send a Message</h3>
                            <p class="ct-muted mb-4">Please fill out the form below. Fields marked with * are required.</p>

                            <div id="contactAlert" class="d-none" role="alert"></div>

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form id="site-contact-form" action="{{ route('contacts.store') }}" method="post" novalidate>
                                @csrf

                                {{-- Honeypot (hidden from humans) --}}
                                <div class="position-absolute" style="left:-9999px;" aria-hidden="true">
                                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="cName" name="name" placeholder="Your name" maxlength="255" required>
                                            <label for="cName">Your Name *</label>
                                            <div class="invalid-feedback">Please enter your name.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="cEmail" name="email" placeholder="Email" maxlength="255" required>
                                            <label for="cEmail">Email *</label>
                                            <div class="invalid-feedback">Please enter a valid email address.</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="cSubject" name="subject" placeholder="Subject" maxlength="255">
                                            <label for="cSubject">Subject</label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="cMessage" name="message" placeholder="Your message" style="height: 180px" maxlength="5000" required></textarea>
                                            <label for="cMessage">Your Message *</label>
                                            <div class="invalid-feedback">Please write your message.</div>
                                        </div>
                                        <div class="text-end small ct-muted mt-1"><span id="msgCount">0</span> / 5000</div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" id="contactSubmit" class="btn ct-btn btn-lg w-100 rounded-pill">
                                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                            <span class="btn-text">Send Message</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="d-flex flex-column gap-4 h-100">
                        <div class="card ct-card-navy">
                            <div class="card-body p-4 p-lg-5">
                                <h4 class="fw-bold mb-3">Why Contact Us?</h4>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex mb-3"><i class="ion-checkmark-circled me-3 fs-5"></i><span>Help with orders and delivery</span></li>
                                    <li class="d-flex mb-3"><i class="ion-checkmark-circled me-3 fs-5"></i><span>Solutions for returns, refunds and payment issues</span></li>
                                    <li class="d-flex mb-3"><i class="ion-checkmark-circled me-3 fs-5"></i><span>Vendor, supplier and partnership enquiries</span></li>
                                    <li class="d-flex"><i class="ion-checkmark-circled me-3 fs-5"></i><span>We promise a reply within 24 hours</span></li>
                                </ul>
                            </div>
                        </div>

                        @if(count($socials))
                            <div class="card ct-card">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-3">Follow Us</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($socials as $s)
                                            <a href="{{ $s['url'] }}" target="_blank" rel="noopener" title="{{ $s['label'] }}" class="ct-social">
                                                <i class="{{ $s['icon'] }} fs-5"></i>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card ct-card flex-grow-1">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">Frequently Asked Questions</h5>
                                <div class="accordion accordion-flush" id="contactFaq">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                                How soon will I get a reply?
                                            </button>
                                        </h2>
                                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
                                            <div class="accordion-body px-0">We usually reply to your email within 24 hours.</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                                What if I have an urgent problem with my order?
                                            </button>
                                        </h2>
                                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
                                            <div class="accordion-body px-0">Contact us directly by phone or WhatsApp for a quick response.</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                                Where can I find my order number?
                                            </button>
                                        </h2>
                                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
                                            <div class="accordion-body px-0">You can find it in your order confirmation email and in the "My Orders" section of your account.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map -->
        @if($mapIframeHtml || $mapEmbedSrc || $mapLink)
            <section class="container pb-5">
                <div class="mx-auto" style="max-width: 900px;">
                    <div class="card ct-card overflow-hidden">
                        @if($mapIframeHtml || $mapEmbedSrc)
                            <div id="contactMap" style="height: 280px;">
                                @if($mapIframeHtml)
                                    {!! $mapIframeHtml !!}
                                @else
                                    <iframe src="{{ $mapEmbedSrc }}" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                @endif
                            </div>
                        @else
                            <div class="card-body text-center p-4">
                                <i class="ion-android-pin fs-2" style="color:#fd6801;"></i>
                                <h6 class="fw-bold mt-2">Our Location</h6>
                                <a href="{{ $mapLink }}" target="_blank" rel="noopener" class="btn ct-btn-navy btn-sm rounded-pill px-4">View on Google Maps</a>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

    </div>

    @include('frontend.partials.static-area')

    <script>
        (function () {
            var form = document.getElementById('site-contact-form');
            if (!form) return;

            var btn     = document.getElementById('contactSubmit');
            var spinner = btn.querySelector('.spinner-border');
            var btnText = btn.querySelector('.btn-text');
            var alertBx = document.getElementById('contactAlert');
            var message = document.getElementById('cMessage');
            var counter = document.getElementById('msgCount');

            // Fit map iframe to its container
            var mapFrame = document.querySelector('#contactMap iframe');
            if (mapFrame) {
                mapFrame.removeAttribute('width');
                mapFrame.removeAttribute('height');
                mapFrame.style.width = '100%';
                mapFrame.style.height = '100%';
                mapFrame.style.border = '0';
                mapFrame.style.display = 'block';
            }

            // Character counter
            message.addEventListener('input', function () {
                counter.textContent = message.value.length;
            });

            // Live validation
            form.querySelectorAll('input.form-control, textarea.form-control').forEach(function (el) {
                el.addEventListener('blur', function () { validateField(el); });
                el.addEventListener('input', function () {
                    if (el.classList.contains('is-invalid')) validateField(el);
                });
            });

            function validateField(el) {
                if (el.name === 'website') return true;
                var ok = el.checkValidity();
                el.classList.toggle('is-invalid', !ok);
                el.classList.toggle('is-valid', ok && el.value.trim() !== '');
                return ok;
            }

            function showAlert(type, text) {
                alertBx.className = 'alert alert-' + type + ' mb-4';
                alertBx.textContent = text;
                alertBx.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            function setLoading(on) {
                btn.disabled = on;
                spinner.classList.toggle('d-none', !on);
                btnText.textContent = on ? 'Sending...' : 'Send Message';
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                alertBx.className = 'd-none';

                var valid = true;
                form.querySelectorAll('input.form-control, textarea.form-control').forEach(function (el) {
                    if (!validateField(el)) valid = false;
                });
                if (!valid) {
                    var firstBad = form.querySelector('.is-invalid');
                    if (firstBad) firstBad.focus();
                    return;
                }

                setLoading(true);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(form)
                })
                    .then(function (res) {
                        return res.json().catch(function () { return {}; }).then(function (data) {
                            return { status: res.status, ok: res.ok, data: data };
                        });
                    })
                    .then(function (r) {
                        if (r.ok) {
                            var msg = r.data.message || 'Your message has been sent successfully.';
                            form.reset();
                            counter.textContent = '0';
                            form.querySelectorAll('.is-valid, .is-invalid').forEach(function (el) {
                                el.classList.remove('is-valid', 'is-invalid');
                            });
                            showAlert('success', msg);
                            if (typeof showToast === 'function') showToast('Success', msg);
                        } else if (r.status === 422 && r.data.errors) {
                            Object.keys(r.data.errors).forEach(function (field) {
                                var input = form.querySelector('[name="' + field + '"]');
                                if (!input) return;
                                input.classList.add('is-invalid');
                                var fb = input.parentElement.querySelector('.invalid-feedback');
                                if (fb) fb.textContent = r.data.errors[field][0];
                            });
                            showAlert('danger', 'Please correct the highlighted fields.');
                        } else if (r.status === 419) {
                            showAlert('warning', 'Your page session has expired. Please refresh the page and try again.');
                        } else {
                            showAlert('danger', 'Sorry, something went wrong. Please try again in a moment.');
                        }
                    })
                    .catch(function () {
                        showAlert('danger', 'Network problem. Please check your connection and try again.');
                    })
                    .finally(function () {
                        setLoading(false);
                    });
            });
        })();
    </script>
@endsection