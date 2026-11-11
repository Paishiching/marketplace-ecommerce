@extends('layouts.frontend.app')

@section('title', 'Customer Complaint')

@section('content')
    @php
        // WhatsApp number : 01XXXXXXXXX hole 88 jure dei
        $wa = preg_replace('/[^0-9]/', '', (string) $site->whatsapp_number);
        if (str_starts_with($wa, '01')) { $wa = '88' . $wa; }

        // Je problem gulo amra solve kori
        $topics = [
            ['ion-android-car',     'Delivery Problems',   'Late, missing or wrongly delivered orders and delivery agent behaviour.'],
            ['ion-cube',            'Wrong or Damaged Item', 'Received a different, defective or damaged product.'],
            ['ion-refresh',         'Return & Refund',     'Return request not accepted or refund taking too long.'],
            ['ion-card',            'Payment Issues',      'Double charge, failed payment or money deducted without order.'],
            ['ion-person',          'Seller / Vendor Issues', 'Misleading product information or unprofessional seller response.'],
            ['ion-help-buoy',       'Service & Support',   'Unanswered support request or poor customer service experience.'],
        ];

        // Complaint dewar age ja ja lagbe
        $conditions = [
            'Your order / invoice number, if the complaint is about an order.',
            'A clear description of the problem and when it happened.',
            'Photos or video of the product for damaged or wrong item complaints (send on WhatsApp after the message opens).',
            'The mobile number used for the order, so we can find it quickly.',
            'Please submit one complaint per issue so each one is tracked properly.',
        ];

        // Ja ja ei form diye hobe na
        $notCovered = [
            'Order cancellation or tracking requests: please use "My Orders" in your account.',
            'Complaints about products bought outside this website.',
        ];

        $steps = [
            ['1', 'Submit',      'Fill in the short form and send it through WhatsApp.'],
            ['2', 'Review',      'Our support team reviews your complaint and checks the order.'],
            ['3', 'Escalation',  'Serious cases are forwarded to our Managing Director.'],
            ['4', 'Resolution',  'We contact you with a solution: replacement, refund or correction.'],
        ];
    @endphp

    <style>
        /* ===== Complaint page (cp) : only #fd6801, #2a3582, #ffffff ===== */
        .cp-page{--cp-o:#fd6801;--cp-n:#2a3582;--cp-w:#ffffff;font-family:'Poppins','Open Sans',sans-serif;color:var(--cp-n);background:rgba(42,53,130,.04);padding-bottom:50px}
        .cp-page *{box-sizing:border-box}
        .cp-page h1,.cp-page h2,.cp-page h3,.cp-page h4,.cp-page h5{color:var(--cp-n);margin:0}
        .cp-muted{color:var(--cp-n);opacity:.78}

        /* Hero */
        .cp-hero{position:relative;overflow:hidden;background:var(--cp-n);padding:54px 0 90px;text-align:center;border-bottom:5px solid var(--cp-o)}
        .cp-hero .cp-bubble{position:absolute;border-radius:50%;background:var(--cp-w);opacity:.07}
        .cp-crumb{display:flex;justify-content:center;align-items:center;gap:8px;margin-bottom:14px;font-size:13px;color:var(--cp-w)}
        .cp-crumb a{color:var(--cp-w);text-decoration:none}
        .cp-crumb a:hover{color:var(--cp-o)}
        .cp-badge{display:inline-block;padding:5px 16px;margin-bottom:14px;border-radius:50px;background:var(--cp-o);color:var(--cp-w);font-size:12px;font-weight:700;letter-spacing:.4px}
        .cp-hero h1{color:var(--cp-w)!important;font-size:34px;font-weight:800;line-height:1.3;margin-bottom:12px}
        .cp-hero p{max-width:640px;margin:0 auto;color:var(--cp-w);opacity:.9;font-size:15px;line-height:1.8}

        /* Top strip cards */
        .cp-pull{margin-top:-48px;position:relative;z-index:2}
        .cp-mini{display:flex;align-items:center;gap:14px;height:100%;background:var(--cp-w);border:1px solid rgba(42,53,130,.12);border-radius:16px;padding:16px 18px;box-shadow:0 8px 22px rgba(42,53,130,.10)}
        .cp-mini .ic{flex:0 0 46px;width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px}
        .cp-mini .ic.o{background:rgba(253,104,1,.12);color:var(--cp-o)}
        .cp-mini .ic.n{background:rgba(42,53,130,.10);color:var(--cp-n)}
        .cp-mini b{display:block;font-size:15px;color:var(--cp-n)}
        .cp-mini span{font-size:12.5px;color:var(--cp-n);opacity:.75}

        /* Section titles */
        .cp-title{font-size:20px;font-weight:800;margin-bottom:4px;position:relative;padding-left:14px}
        .cp-title:before{content:"";position:absolute;left:0;top:4px;bottom:4px;width:4px;border-radius:4px;background:var(--cp-o)}
        .cp-sub{font-size:13.5px;margin:0 0 16px 14px}

        /* Topic cards */
        .cp-topic{display:flex;gap:12px;height:100%;background:var(--cp-w);border:1px solid rgba(42,53,130,.12);border-radius:14px;padding:14px 16px;transition:all .25s ease}
        .cp-topic:hover{border-color:var(--cp-o);box-shadow:0 8px 20px rgba(253,104,1,.14);transform:translateY(-2px)}
        .cp-topic i{flex:0 0 38px;width:38px;height:38px;border-radius:10px;background:rgba(253,104,1,.12);color:var(--cp-o);display:flex;align-items:center;justify-content:center;font-size:19px}
        .cp-topic h5{font-size:14px;font-weight:700;margin-bottom:3px}
        .cp-topic p{margin:0;font-size:12.5px;line-height:1.6;color:var(--cp-n);opacity:.75}

        /* Panels */
        .cp-panel{background:var(--cp-w);border:1px solid rgba(42,53,130,.12);border-radius:16px;padding:20px 22px;box-shadow:0 6px 18px rgba(42,53,130,.07)}
        .cp-list{list-style:none;margin:0;padding:0}
        .cp-list li{display:flex;gap:10px;align-items:flex-start;font-size:13.5px;line-height:1.7;margin-bottom:9px;color:var(--cp-n)}
        .cp-list li:last-child{margin-bottom:0}
        .cp-list li i{flex:0 0 auto;margin-top:2px;font-size:16px;color:var(--cp-o)}
        .cp-list.no li i{color:var(--cp-n);opacity:.6}

        /* Steps */
        .cp-step{position:relative;height:100%;background:var(--cp-w);border:1px solid rgba(42,53,130,.12);border-radius:14px;padding:16px 14px 14px;text-align:center}
        .cp-step .n{width:34px;height:34px;margin:0 auto 8px;border-radius:50%;background:var(--cp-n);color:var(--cp-w);font-weight:800;font-size:14px;display:flex;align-items:center;justify-content:center}
        .cp-step h5{font-size:14px;font-weight:700;margin-bottom:4px}
        .cp-step p{margin:0;font-size:12px;line-height:1.6;color:var(--cp-n);opacity:.75}

        /* Form card (compact) */
        .cp-formwrap{position:sticky;top:90px}
        .cp-card{background:var(--cp-w);border:1px solid rgba(42,53,130,.12);border-top:5px solid var(--cp-o);border-radius:18px;padding:22px 22px 20px;box-shadow:0 12px 30px rgba(42,53,130,.12)}
        .cp-card h3{font-size:19px;font-weight:800;margin-bottom:2px}
        .cp-card .lead{font-size:12.5px;line-height:1.7;margin:0 0 14px;color:var(--cp-n);opacity:.75}

        .cp-field{margin-bottom:10px}
        .cp-field label{display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:var(--cp-n)}
        .cp-field .req{color:var(--cp-o)}
        .cp-field input,.cp-field select,.cp-field textarea{display:block;width:100%;height:40px;padding:0 12px;border:1px solid rgba(42,53,130,.25);border-radius:8px;background:var(--cp-w);font-size:13.5px;color:var(--cp-n);outline:none;transition:border-color .2s,box-shadow .2s}
        .cp-field select{appearance:auto;padding-right:8px}
        .cp-field textarea{height:92px;padding:9px 12px;resize:vertical}
        .cp-field input:focus,.cp-field select:focus,.cp-field textarea:focus{border-color:var(--cp-o);box-shadow:0 0 0 3px rgba(253,104,1,.18)}
        .cp-field.bad input,.cp-field.bad select,.cp-field.bad textarea{border-color:var(--cp-o)}
        .cp-err{display:none;margin-top:3px;font-size:11.5px;font-weight:600;color:var(--cp-o)}
        .cp-field.bad .cp-err{display:block}

        .cp-btn{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;height:46px;margin-top:4px;border:0;border-radius:50px;background:var(--cp-n);color:var(--cp-w);font-size:15px;font-weight:700;cursor:pointer;transition:background .2s}
        .cp-btn:hover{background:var(--cp-o)}
        .cp-btn:disabled{opacity:.6;cursor:not-allowed}
        .cp-btn svg{width:20px;height:20px}
        .cp-note{margin:10px 0 0;text-align:center;font-size:11.5px;line-height:1.6;color:var(--cp-n);opacity:.7}
        .cp-warn{background:rgba(253,104,1,.1);border:1px solid var(--cp-o);border-radius:8px;padding:10px 12px;margin-bottom:12px;font-size:12.5px;font-weight:600;color:var(--cp-n)}

        @media(max-width:991px){.cp-formwrap{position:static}}
        @media(max-width:575px){.cp-hero{padding:42px 0 80px}.cp-hero h1{font-size:25px}.cp-card{padding:18px 16px}}
    </style>

    <div class="cp-page">

        {{-- Hero --}}
        <section class="cp-hero">
            <div class="container position-relative" style="z-index:1;">
                <div class="cp-crumb">
                    <a href="{{ route('homes') }}">Home</a><span>/</span><span style="font-weight:600;">Customer Complaint</span>
                </div>
                <span class="cp-badge">We Take Every Complaint Seriously</span>
                <h1>Customer Complaint</h1>
                <p>We are sorry for any disappointment with our service. Tell us what went wrong and we will review it and work towards a fair solution.</p>
            </div>
            <div class="cp-bubble" style="width:240px;height:240px;top:-90px;left:-70px;"></div>
            <div class="cp-bubble" style="width:190px;height:190px;bottom:-80px;right:-50px;"></div>
        </section>

        {{-- Quick info strip --}}
        <section class="container cp-pull">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="cp-mini">
                        <div class="ic o"><i class="ion-android-time"></i></div>
                        <div><b>Reply within 24 hours</b><span>Fast acknowledgement of every complaint</span></div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="cp-mini">
                        <div class="ic n"><i class="ion-ribbon-b"></i></div>
                        <div><b>Forwarded to Management</b><span>Serious cases reach our Managing Director</span></div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="cp-mini">
                        <div class="ic o"><i class="ion-social-whatsapp"></i></div>
                        <div><b>Direct WhatsApp Support</b><span>Share photos and details easily</span></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Main --}}
        <section class="container pt-5">
            <div class="row g-4 g-xl-5">

                {{-- Form (mobile e age, desktop e dan e) --}}
                <div class="col-lg-5 order-1 order-lg-2">
                    <div class="cp-formwrap">
                        <div class="cp-card">
                            <h3>Submit a Complaint</h3>
                            <p class="lead">Takes less than a minute. Fields marked <span style="color:#fd6801;">*</span> are required.</p>

                            @if($wa === '')
                                <div class="cp-warn">WhatsApp number set kora nei. Admin &gt; Settings theke WhatsApp number din.</div>
                            @endif

                            <form id="complaintForm" novalidate>
                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <div class="cp-field">
                                            <label for="cpName">Your Name <span class="req">*</span></label>
                                            <input type="text" id="cpName" autocomplete="name" placeholder="Full name">
                                            <span class="cp-err">Please enter your name.</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cp-field">
                                            <label for="cpPhone">Phone Number <span class="req">*</span></label>
                                            <input type="text" id="cpPhone" inputmode="tel" autocomplete="tel" placeholder="01XXXXXXXXX">
                                            <span class="cp-err">Enter a valid mobile number.</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cp-field">
                                            <label for="cpEmail">Email (optional)</label>
                                            <input type="email" id="cpEmail" autocomplete="email" placeholder="you@example.com">
                                            <span class="cp-err">Enter a valid email address.</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cp-field">
                                            <label for="cpInvoice">Invoice / Order No.</label>
                                            <input type="text" id="cpInvoice" placeholder="Optional">
                                        </div>
                                    </div>
                                </div>

                                <div class="cp-field">
                                    <label for="cpType">Complaint Type <span class="req">*</span></label>
                                    <select id="cpType">
                                        <option value="">Select a type</option>
                                        @foreach($topics as $t)
                                            <option value="{{ $t[1] }}">{{ $t[1] }}</option>
                                        @endforeach
                                        <option value="Other">Other</option>
                                    </select>
                                    <span class="cp-err">Please select a complaint type.</span>
                                </div>

                                <div class="cp-field">
                                    <label for="cpSubject">Subject <span class="req">*</span></label>
                                    <input type="text" id="cpSubject" placeholder="Short summary of the problem">
                                    <span class="cp-err">Please enter a subject.</span>
                                </div>

                                <div class="cp-field">
                                    <label for="cpMessage">Your Message <span class="req">*</span></label>
                                    <textarea id="cpMessage" placeholder="Describe what happened, when, and what solution you expect."></textarea>
                                    <span class="cp-err">Please write your message.</span>
                                </div>

                                <button type="submit" class="cp-btn" {{ $wa === '' ? 'disabled' : '' }}>
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11.8 11.8 0 0 0 12 0C5.4 0 .1 5.3.1 11.9c0 2.1.5 4.1 1.6 5.9L0 24l6.4-1.7a11.9 11.9 0 0 0 5.6 1.4c6.6 0 11.9-5.3 11.9-11.9 0-3.2-1.2-6.2-3.4-8.3zM12 21.7c-1.8 0-3.5-.5-5-1.4l-.4-.2-3.8 1 1-3.7-.2-.4a9.8 9.8 0 0 1-1.5-5.1C2.1 6.5 6.5 2.1 12 2.1c2.6 0 5.1 1 6.9 2.9a9.7 9.7 0 0 1 2.9 6.9c0 5.4-4.4 9.8-9.8 9.8zm5.4-7.3c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.1-.2.3-.8.9-.9 1.1-.2.2-.3.2-.6.1-.3-.1-1.2-.4-2.3-1.4-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6l.4-.5c.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5-.1-.1-.7-1.6-.9-2.2-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.7-.7 2-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.6-.3z"/></svg>
                                    Send via WhatsApp
                                </button>
                                <p class="cp-note">WhatsApp khulbe ar message ready thakbe. Shudhu Send chapun, tarpor photo thakle attach korun.</p>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="col-lg-7 order-2 order-lg-1">

                    <h2 class="cp-title">Problems We Can Help Solve</h2>
                    <p class="cp-sub cp-muted">Choose the closest type when you submit, so it reaches the right team faster.</p>
                    <div class="row g-3 mb-5">
                        @foreach($topics as $t)
                            <div class="col-12 col-sm-6">
                                <div class="cp-topic">
                                    <i class="{{ $t[0] }}"></i>
                                    <div>
                                        <h5>{{ $t[1] }}</h5>
                                        <p>{{ $t[2] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <h2 class="cp-title">How Your Complaint Is Handled</h2>
                    <p class="cp-sub cp-muted">A simple 4-step process from submission to solution.</p>
                    <div class="row g-3 mb-5">
                        @foreach($steps as $s)
                            <div class="col-6 col-md-3">
                                <div class="cp-step">
                                    <div class="n">{{ $s[0] }}</div>
                                    <h5>{{ $s[1] }}</h5>
                                    <p>{{ $s[2] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-7">
                            <div class="cp-panel h-100">
                                <h5 class="mb-3" style="font-size:16px;font-weight:800;">Before You Submit</h5>
                                <ul class="cp-list">
                                    @foreach($conditions as $c)
                                        <li><i class="ion-checkmark-circled"></i><span>{{ $c }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="cp-panel h-100">
                                <h5 class="mb-3" style="font-size:16px;font-weight:800;">Not Covered Here</h5>
                                <ul class="cp-list no">
                                    @foreach($notCovered as $c)
                                        <li><i class="ion-information-circled"></i><span>{{ $c }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    @include('frontend.partials.static-area')

    <script>
        (function () {
            var waNumber = @json($wa);
            var form = document.getElementById('complaintForm');
            if (!form) return;

            function val(id) { return document.getElementById(id).value.trim(); }
            function mark(id, ok) {
                document.getElementById(id).closest('.cp-field').classList.toggle('bad', !ok);
                return ok;
            }

            // Live: error thakle lekhar shathe shathe clear hobe
            form.querySelectorAll('input, select, textarea').forEach(function (el) {
                el.addEventListener('input', function () {
                    var f = el.closest('.cp-field');
                    if (f) f.classList.remove('bad');
                });
            });

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (!waNumber) return;

                var name = val('cpName'), email = val('cpEmail'), phone = val('cpPhone'),
                    type = val('cpType'), subject = val('cpSubject'),
                    invoice = val('cpInvoice'), message = val('cpMessage');

                var ph = phone.replace(/[\s\-]/g, '');
                var ok = true;
                ok = mark('cpName', name !== '') && ok;
                ok = mark('cpPhone', /^(\+?88)?01[3-9]\d{8}$/.test(ph)) && ok;
                ok = mark('cpEmail', email === '' || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) && ok;
                ok = mark('cpType', type !== '') && ok;
                ok = mark('cpSubject', subject !== '') && ok;
                ok = mark('cpMessage', message !== '') && ok;

                if (!ok) {
                    var bad = form.querySelector('.bad input, .bad select, .bad textarea');
                    if (bad) bad.focus();
                    return;
                }

                var text =
                    '*Customer Complaint*\n\n' +
                    '*Type:* ' + type + '\n' +
                    '*Name:* ' + name + '\n' +
                    '*Phone:* ' + phone + '\n' +
                    (email ? '*Email:* ' + email + '\n' : '') +
                    (invoice ? '*Invoice No:* ' + invoice + '\n' : '') +
                    '*Subject:* ' + subject + '\n' +
                    '\n*Message:*\n' + message;

                // location.href mobile e popup block hoy na
                window.location.href = 'https://wa.me/' + waNumber + '?text=' + encodeURIComponent(text);
            });
        })();
    </script>
@endsection