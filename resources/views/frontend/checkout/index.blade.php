@extends('layouts.frontend.app')

@section('title', 'Checkout')
@section('content')

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-checkout.css?v=7">

    <div class="ck-page">
        <div class="container">

            @if($cartItems->isEmpty())

                <div class="ck-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h3l2.4 11.2a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.5L21.5 7H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/></svg>
                    <h4>Your cart is empty</h4>
                    <p>Please add some products to your cart before checking out.</p>
                    <a href="{{ route('homes') }}">Continue Shopping</a>
                </div>

            @else

                @php
                    $selectedAddressId = old('shipping_address_id');
                    $hasSaved          = $savedAddresses->count() > 0;
                    $hasOldNew         = !$selectedAddressId && (old('address_line1') || old('city'));
                    $checkedId         = $hasOldNew ? null : ($selectedAddressId ?: optional($savedAddresses->first())->id);
                    $itemCount         = $cartItems->count();

                    // saved address delete route (routes/web.php e checkout.address.destroy ache)
                    $delRouteName = \Illuminate\Support\Facades\Route::has('checkout.address.destroy') ? 'checkout.address.destroy' : null;

                    // Step 2 : payment methods (value gulo PlaceOrderRequest / payment_methods table er sathe mil rakhben)
                    $paymentMethods = [
                        ['value' => 'cod',        'label' => 'Cash on Delivery', 'sub' => false,
                         'icon' => '<rect x="3" y="7" width="18" height="11" rx="2"/><circle cx="12" cy="12.5" r="2.5"/>'],
                        ['value' => 'sslcommerz', 'label' => 'Online payment (SSL Commerz)', 'sub' => false,
                         'icon' => '<path d="M12 3l8 3v5c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-3z"/><path d="M9 12l2 2 4-4"/>'],
                        ['value' => 'bank_deposit', 'label' => 'Bank deposit', 'sub' => true,
                         'icon' => '<path d="M3 9l9-6 9 6M5 10v8m5-8v8m4-8v8m5-8v8M3 21h18M2 18h20"/>'],
                    ];
                    $oldPm = old('payment_method', 'cod');

                    $emiSite = optional($site ?? null)->site_name ?: 'Buydor';
                @endphp

                @if(session('error'))
                    <div class="ck-alert">{{ session('error') }}</div>
                @endif

                <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm" enctype="multipart/form-data" novalidate>
                    @csrf
                    {{-- payment_method : Step 2 er radio theke ashe --}}

                    <div class="ck-grid">

                                {{-- ================= LEFT: delivery and payment ================= --}}
                        <div class="ck-left">

                            <div class="ck-title">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h3l2.4 11.2a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.5L21.5 7H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/><path d="M10 9.5l2 2 3.5-3.5"/></svg>
                                <h1>Checkout</h1>
                                <div class="ck-steps">
                                    <span class="on" id="stepAddrLbl"><b>1</b> Delivery details</span>
                                    <i></i>
                                    <span id="stepPayLbl"><b>2</b> Payment &amp; review</span>
                                </div>
                            </div>

                            {{-- ================= STEP 1 : ADDRESS ================= --}}
                            <div id="addrStep">

                            {{-- ===== 2 options : Favourite address / New address ===== --}}
                            <div class="ck-tabs">
                                <button type="button" class="ck-tab active" id="tabFav">
                                    <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg></span>
                                    <span class="txt">Select from<b>Favourite address</b></span>
                                    <span class="tick"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 6.5l2.5 2.5 4.5-5"/></svg></span>
                                </button>
                                <button type="button" class="ck-tab" id="tabNew">
                                    <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span>
                                    <span class="txt">Save a<b>New address</b></span>
                                    <span class="tick"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 6.5l2.5 2.5 4.5-5"/></svg></span>
                                </button>
                            </div>

                            {{-- new address => empty shipping_address_id submit hoy --}}
                            <input type="radio" name="shipping_address_id" value="" class="new-address-radio d-none-ck" id="newAddrRadio" {{ $hasOldNew || !$hasSaved ? 'checked' : '' }}>

                            {{-- ================= FAVOURITE ADDRESS VIEW ================= --}}
                            <div id="favPane">

                                <div class="ck-sec">
                                    <h3 class="ck-h">Shipping Information</h3>

                                    <div id="savedHolder">
                                        @foreach($savedAddresses as $addr)
                                            @php
                                                $line   = trim((string) $addr->address_line1);
                                                $cityTx = trim((string) $addr->city);
                                                $full   = ($cityTx !== '' && stripos($line, $cityTx) === false) ? $line . ', ' . $cityTx : $line;
                                            @endphp
                                            <div class="ck-addr" data-saved="1">
                                                <label class="ck-addr-main">
                                                    <input type="radio" name="shipping_address_id" value="{{ $addr->id }}"
                                                           class="saved-address-radio"
                                                           data-city="{{ $addr->city }}"
                                                           data-name="{{ $addr->recipient_name }}"
                                                           data-phone="{{ $addr->phone }}"
                                                           data-address="{{ $addr->address_line1 }}"
                                                           data-address2="{{ $addr->address_line2 ?? '' }}"
                                                           data-delete-url="{{ $delRouteName ? route($delRouteName, $addr->id) : '' }}"
                                                        {{ (string) $checkedId === (string) $addr->id ? 'checked' : '' }}>
                                                    <span class="ck-addr-body">
                                                        <span class="ck-dot"></span>
                                                        <span class="ck-addr-txt">
                                                            <strong>{{ $addr->recipient_name ?? 'N/A' }}</strong>
                                                            <span>{{ $full }}</span>
                                                            <span>{{ $addr->phone }}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                                <span class="ck-addr-act">
                                                    <button type="button" class="ck-act del js-del-saved" aria-label="Delete address" title="Delete">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 7V4h6v3"/></svg>
                                                    </button>
                                                    <button type="button" class="ck-act edit js-edit-saved" aria-label="Edit address" title="Edit">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h4L19 9a2.1 2.1 0 0 0-3-3L5 17v3z"/><path d="M14 7l3 3"/></svg>
                                                    </button>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Validation error er por ager deya new address ekhane card hisebe ashe --}}
                                    <div id="pendingHolder"></div>

                                    <p class="ck-empty-note {{ $hasSaved ? 'd-none-ck' : '' }}" id="noAddrNote">No saved address found. Please add a new address.</p>
                                </div>

                                <div class="ck-sec">
                                    <h3 class="ck-h">Delivery Method</h3>
                                    <div id="deliveryBox">
                                        <p class="ck-note">No delivery methods available.</p>
                                    </div>
                                </div>

                                <div class="ck-field">
                                    <label class="lb">Additional Instructions (Optional)</label>
                                    <textarea name="notes" placeholder="Enter any additional instructions for your order">{{ old('notes') }}</textarea>
                                </div>
                            </div>

                            {{-- ================= NEW ADDRESS VIEW ================= --}}
                            <div id="newPane" class="d-none-ck">
                                <div class="ck-row">
                                    <div class="ck-field">
                                        <label class="lb">Full Name</label>
                                        <input type="text" name="name" id="fName" value="{{ old('name', $prefill['name'] ?? '') }}" placeholder="Enter full name">
                                        @error('name')<span class="ck-err">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="ck-field">
                                        <label class="lb">Mobile Number</label>
                                        <input type="text" name="phone" id="fPhone" value="{{ old('phone', $prefill['phone'] ?? '') }}" placeholder="Enter your phone number">
                                        @error('phone')<span class="ck-err">{{ $message }}</span>@enderror
                                    </div>

                                    {{-- verify kora email (change kora jabe na) --}}
                                    <div class="ck-field" style="grid-column:1/-1">
                                        <label class="lb">Email (verified)</label>
                                        <input type="text" name="email" id="fEmail" value="{{ $prefill['email'] ?? '' }}" readonly style="background:var(--ck-tint)">
                                    </div>

                                    <div class="ck-field">
                                        <label class="lb">Street Address <span class="req">*</span></label>
                                        <input type="text" name="address_line1" id="fAddress" value="{{ old('address_line1') }}" placeholder="Enter your address">
                                        @error('address_line1')<span class="ck-err">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="ck-field">
                                        <label class="lb">Division <span class="req">*</span></label>
                                        <select id="divisionSelect">
                                            <option value="">Select division</option>
                                        </select>
                                    </div>

                                    <div class="ck-field">
                                        <label class="lb">City <span class="req">*</span></label>
                                        <select id="citySelect">
                                            <option value="">Select city</option>
                                        </select>
                                        {{-- server e jay : district nam (shipping cost ei diye) --}}
                                        <input type="hidden" name="city" id="cityHidden" value="{{ old('city') }}">
                                        @error('city')<span class="ck-err">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="ck-field">
                                        <label class="lb">Area <span class="req">*</span></label>
                                        <select id="areaSelect">
                                            <option value="">Select area</option>
                                        </select>
                                        <input type="text" id="areaText" class="d-none-ck" placeholder="Enter area">
                                        <input type="hidden" name="address_line2" id="areaHidden" value="{{ old('address_line2') }}">
                                    </div>
                                </div>

                                <input type="hidden" name="address_type" id="addrType" value="{{ old('address_type', 'home') }}">
                                <div class="ck-types">
                                    <button type="button" class="ck-type {{ old('address_type', 'home') === 'home' ? 'active' : '' }}" data-type="home">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3l9 8h-3v9h-5v-6h-2v6H6v-9H3l9-8z"/></svg> Home
                                    </button>
                                    <button type="button" class="ck-type {{ old('address_type') === 'office' ? 'active' : '' }}" data-type="office">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/></svg> Office
                                    </button>
                                </div>

                                <div class="ck-btns">
                                    <button type="button" class="ck-btn cancel" id="addrCancel">Cancel</button>
                                    <button type="button" class="ck-btn save" id="addrSave">Save Address</button>
                                </div>
                            </div>
                            </div>{{-- /addrStep --}}

                            {{-- ================= STEP 2 : PAYMENT METHOD ================= --}}
                            <div id="payStep" class="d-none-ck">
                                <h3 class="ck-h" style="margin-bottom:14px">Select Payment Method</h3>

                                @foreach($paymentMethods as $pm)
                                    <div class="ck-pm">
                                        <input type="radio" class="pm" name="payment_method" id="pm_{{ $pm['value'] }}" value="{{ $pm['value'] }}" {{ $oldPm === $pm['value'] ? 'checked' : '' }}>
                                        <label class="ck-pm-head" for="pm_{{ $pm['value'] }}">
                                            <span class="ck-pm-logo"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $pm['icon'] !!}</svg></span>
                                            <b>{{ $pm['label'] }}</b>
                                            <span class="ck-pm-dot"></span>
                                        </label>

                                        @if($pm['value'] === 'bank_deposit')
                                            <div class="ck-pm-sub">
                                                <div class="ck-deposit-note">Enter the deposit details and attach your receipt. We will verify the payment before confirming your order.</div>
                                                <div class="ck-deposit-grid">
                                                    <label class="ck-deposit-field">Deposit date <span>*</span><input type="date" name="deposit_date" max="{{ now()->toDateString() }}" value="{{ old('deposit_date') }}">@error('deposit_date')<small>{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field">Depositor bank <span>*</span><input type="text" name="depositor_bank" maxlength="150" value="{{ old('depositor_bank') }}" placeholder="Your bank name">@error('depositor_bank')<small>{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field">Branch <span>*</span><input type="text" name="depositor_branch" maxlength="150" value="{{ old('depositor_branch') }}" placeholder="Branch name">@error('depositor_branch')<small>{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field">Deposit type <span>*</span><select name="deposit_type"><option value="">Select type</option>@foreach(['cash' => 'Cash', 'cheque' => 'Cheque', 'bank_transfer' => 'Bank transfer'] as $value => $label)<option value="{{ $value }}" @selected(old('deposit_type') === $value)>{{ $label }}</option>@endforeach</select>@error('deposit_type')<small>{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field">Deposit amount (BDT) <span>*</span><input type="number" name="deposit_amount" min="1" max="999999999" step="0.01" inputmode="decimal" value="{{ old('deposit_amount') }}" placeholder="Enter amount">@error('deposit_amount')<small>{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field">Company receiving account <span>*</span><input type="text" name="deposit_company_account" maxlength="190" value="{{ old('deposit_company_account') }}" placeholder="Account name or number you paid to">@error('deposit_company_account')<small>{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field">Receiving bank name <span>*</span><input type="text" name="deposit_bank_name" maxlength="150" value="{{ old('deposit_bank_name') }}" placeholder="Company bank name">@error('deposit_bank_name')<small>{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field">Company name <span>*</span><input type="text" name="deposit_company_name" maxlength="150" value="{{ old('deposit_company_name') }}" placeholder="Depositing company name">@error('deposit_company_name')<small>{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field">Receipt ID <small>(optional)</small><input type="text" name="deposit_receipt_id" maxlength="190" value="{{ old('deposit_receipt_id') }}" placeholder="Transaction or receipt number">@error('deposit_receipt_id')<small>{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field ck-deposit-upload">Deposit receipt <span>*</span><input type="file" name="deposit_attachment" accept="image/jpeg,image/png,image/webp,application/pdf"> <small>JPG, PNG, WebP or PDF · up to 5 MB</small>@error('deposit_attachment')<small class="ck-deposit-error">{{ $message }}</small>@enderror</label>
                                                    <label class="ck-deposit-field ck-deposit-remark">Remark <small>(optional)</small><textarea name="deposit_remark" maxlength="1000" rows="3" placeholder="Add any deposit details">{{ old('deposit_remark') }}</textarea>@error('deposit_remark')<small>{{ $message }}</small>@enderror</label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                @error('payment_method')<span class="ck-err">{{ $message }}</span>@enderror

                                <button type="button" class="ck-back" id="backToAddr">&larr; Back to address</button>
                            </div>

                        </div>

                        {{-- ================= RIGHT : Order summary + EMI (scroll hoy) ================= --}}
                        <div class="ck-right">

                            <aside class="ck-side">
                                <h2>Order Summary</h2>

                                <div class="ck-cart-promo">Have a discount code? <a href="{{ route('cart.index') }}">Apply it in your cart</a> before checkout.</div>

                                <button type="button" class="ck-items-bar" id="itemsToggle">
                                    <b>{{ $itemCount }} item{{ $itemCount > 1 ? 's' : '' }} to checkout</b>
                                    <span>Details <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2l4 4-4 4"/></svg></span>
                                </button>
                                <ul class="ck-items" id="itemsList">
                                    @foreach($cartItems as $item)
                                        <li>
                                            <span>{{ $item->product->name }} <em>× {{ $item->quantity }}</em></span>
                                            <span>৳ {{ number_format($item->price * $item->quantity) }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="ck-line">
                                    <span>Subtotal:</span>
                                    <span id="summarySubtotal">৳ {{ number_format($cartTotal) }}</span>
                                </div>
                                <div class="ck-line">
                                    <span>Discount:</span>
                                    <span id="summaryDiscount">৳ {{ number_format($discount) }}</span>
                                </div>
                                <div class="ck-line">
                                    <span>Shipping:</span>
                                    <span id="summaryShipping">Select delivery city</span>
                                </div>
                                <div class="ck-line tot">
                                    <span>Estimated total:</span>
                                    <span id="summaryGrandTotal">৳ {{ number_format($grandTotal) }}</span>
                                </div>
                                <p class="ck-total-note">Delivery charge is added after you choose your delivery city.</p>

                                <button type="submit" class="ck-pay-btn" id="placeOrderBtn">Continue to payment</button>

                                <label class="ck-terms">
                                    <input type="checkbox" id="agreeTerms">
                                    <span>I have read and agree to the <a href="#">Terms and Conditions</a>, <a href="#">Privacy Policy</a> and <a href="{{ route('policy.returns') }}">Refund and Return Policy</a></span>
                                </label>
                            </aside>

                            {{-- ================= EMI Payments (FAQ accordion) ================= --}}
                            <section class="ck-emi">
                                <h2>EMI Payments</h2>

                                <div class="ck-emi-item">
                                    <button type="button" class="ck-emi-q" aria-expanded="false">
                                        <span>How to Avail EMI at {{ $emiSite }}?</span>
                                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l4 4 4-4"/></svg>
                                    </button>
                                    <div class="ck-emi-a">
                                        <p>You can easily avail <b>EMI (Equated Monthly Installment)</b> on your purchase through <b>SSLCommerz</b> by following these steps:</p>
                                        <ol>
                                            <li>On the payment step, <b>select SSL Commerz</b> or a card payment method.</li>
                                            <li><b>Enter your card details</b> at checkout.</li>
                                            <li>Click on the <b>'Avail EMI'</b> option.</li>
                                            <li>Select your preferred <b>EMI tenure</b> from the available options.</li>
                                            <li>Click on <b>'Pay'</b> to proceed.</li>
                                            <li>Enter the <b>OTP sent by your bank</b> to complete the transaction.</li>
                                        </ol>
                                        <p>Once verified, your EMI plan will be activated.</p>
                                    </div>
                                </div>

                                <div class="ck-emi-item">
                                    <button type="button" class="ck-emi-q" aria-expanded="false">
                                        <span>My payment has failed. What can I do?</span>
                                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l4 4 4-4"/></svg>
                                    </button>
                                    <div class="ck-emi-a">
                                        <p>A transaction may be rejected by the payment gateway for different reasons, such as incorrect payment details or exceeding your transaction limit.</p>
                                        <p>If you have been charged for a failed transaction, please wait <b>24-48 hours</b> for an automatic refund, or contact your issuer bank.</p>
                                    </div>
                                </div>

                                <div class="ck-emi-item">
                                    <button type="button" class="ck-emi-q" aria-expanded="false">
                                        <span>What is the EMI activation process?</span>
                                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l4 4 4-4"/></svg>
                                    </button>
                                    <div class="ck-emi-a">
                                        <ul>
                                            <li>The full amount of the order will be <b>held</b> on your credit card through online payment (or Card on Delivery, inside Dhaka only).</li>
                                            <li>We will send the EMI form with your product or via email.</li>
                                            <li>You must <b>sign and complete the EMI form</b> and submit it to {{ $emiSite }} within <b>3 working days</b>.</li>
                                            <li>Once we receive the signed form, we will submit it to the concerned bank to start the EMI process.</li>
                                            <li>The EMI processing is handled by the bank itself. After <b>10 working days</b>, your bank will convert the transaction into EMI.</li>
                                            <li>From your next billing cycle, you will be charged the EMI amount and your credit limit will be reduced by the outstanding amount.</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ck-emi-item">
                                    <button type="button" class="ck-emi-q" aria-expanded="false">
                                        <span>Is there any EMI submission timeline?</span>
                                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l4 4 4-4"/></svg>
                                    </button>
                                    <div class="ck-emi-a">
                                        <p>There is no strict deadline to submit the EMI form, but we ask customers to submit it within <b>15 working days</b> of the transaction date. If the bank charges a fee for late submission, {{ $emiSite }} will not be liable.</p>
                                    </div>
                                </div>
                            </section>

                        </div>{{-- /ck-right --}}

                    </div>
                </form>

                <script>
                    (function () {
                        var csrfToken    = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        var cartSubtotal = {{ (float) $cartTotal }};
                        var cartDiscount = {{ (float) $discount }};
                        var allDistricts = @json(collect($districts)->values());
                        var oldCity      = @json(old('city'));
                        var oldArea      = @json(old('address_line2'));
                        var hasOldNew    = {{ $hasOldNew ? 'true' : 'false' }};
                        var hasSaved     = {{ $hasSaved ? 'true' : 'false' }};
                        var prefill      = @json($prefill ?? ['name' => '', 'phone' => '', 'email' => '']);

                        var tabFav = document.getElementById('tabFav');
                        var tabNew = document.getElementById('tabNew');
                        var favPane = document.getElementById('favPane');
                        var newPane = document.getElementById('newPane');
                        var newRadio = document.getElementById('newAddrRadio');
                        var pendingHolder = document.getElementById('pendingHolder');
                        var noAddrNote = document.getElementById('noAddrNote');

                        var fName = document.getElementById('fName');
                        var fPhone = document.getElementById('fPhone');
                        var fAddress = document.getElementById('fAddress');
                        var divSelect = document.getElementById('divisionSelect');
                        var citySelect = document.getElementById('citySelect');
                        var cityHidden = document.getElementById('cityHidden');
                        var areaSelect = document.getElementById('areaSelect');
                        var areaText = document.getElementById('areaText');
                        var areaHidden = document.getElementById('areaHidden');
                        var addrType = document.getElementById('addrType');

                        var mode = 'fav';
                        var pendingData = null;
                        var pendingRadio = null;
                        var autoFilled = false;
                        var step = 'addr';        // 'addr' | 'pay'
                        var editingId = null;     // edit korar somoy saved address id
                        var addrSaving = false;   // double click rodh

                        function savedRadios() {
                            return Array.prototype.slice.call(document.querySelectorAll('.saved-address-radio'));
                        }
                        function toast(title, msg, type) {
                            if (typeof showToast === 'function') { showToast(title, msg, type || 'success'); } else { alert(msg); }
                        }
                        function money(n) {
                            return '৳ ' + parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
                        }
                        function esc(s) {
                            return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
                                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
                            });
                        }
                        function norm(s) { return String(s || '').toLowerCase().replace(/[^a-z]/g, ''); }

                        /* =========================================================
                           Division -> City -> Area
                           City label alada hote pare (jemon Dhaka Metro / Dhaka Suburb),
                           kintu server e DB er district nam jay (shipping cost er jonno).
                           [label, 'alias1|alias2'] (alias na dile label-i)
                           ========================================================= */
                        var divisionDefs = {
                            'Dhaka': [
                                ['Dhaka Metro', 'Dhaka Metro|Dhaka City|Dhaka'],
                                ['Dhaka Suburb', 'Dhaka Suburb|Dhaka'],
                                ['Faridpur'], ['Gazipur'], ['Gopalganj'], ['Kishoreganj'], ['Madaripur'], ['Manikganj'],
                                ['Munshiganj', 'Munshiganj|Munsiganj|Munsigonj'],
                                ['Narayanganj'],
                                ['Narsingdi', 'Narsingdi|Narshingdi'],
                                ['Rajbari'], ['Shariatpur'], ['Tangail']
                            ],
                            'Chattogram': [
                                ['Chattogram', 'Chattogram|Chittagong'],
                                ["Cox's Bazar", 'Coxs Bazar|Cox Bazar|Coxsbazar'],
                                ['Cumilla', 'Cumilla|Comilla'],
                                ['Feni'], ['Brahmanbaria'], ['Noakhali'],
                                ['Lakshmipur', 'Lakshmipur|Laxmipur'],
                                ['Chandpur'],
                                ['Khagrachhari', 'Khagrachhari|Khagrachari'],
                                ['Rangamati'], ['Bandarban']
                            ],
                            'Rajshahi': [
                                ['Rajshahi'], ['Bogura', 'Bogura|Bogra'], ['Pabna'], ['Sirajganj'], ['Natore'], ['Naogaon'],
                                ['Chapainawabganj', 'Chapainawabganj|Chapai Nawabganj'], ['Joypurhat']
                            ],
                            'Khulna': [
                                ['Khulna'], ['Jashore', 'Jashore|Jessore'], ['Satkhira'], ['Bagerhat'], ['Kushtia'], ['Chuadanga'],
                                ['Meherpur'], ['Magura'], ['Narail'], ['Jhenaidah']
                            ],
                            'Barishal': [
                                ['Barishal', 'Barishal|Barisal'], ['Bhola'], ['Patuakhali'], ['Pirojpur'],
                                ['Jhalokati', 'Jhalokati|Jhalakathi'], ['Barguna']
                            ],
                            'Sylhet': [
                                ['Sylhet'], ['Moulvibazar', 'Moulvibazar|Maulvibazar'], ['Habiganj'], ['Sunamganj']
                            ],
                            'Rangpur': [
                                ['Rangpur'], ['Dinajpur'], ['Kurigram'], ['Gaibandha'], ['Nilphamari'], ['Lalmonirhat'],
                                ['Thakurgaon'], ['Panchagarh']
                            ],
                            'Mymensingh': [
                                ['Mymensingh'], ['Jamalpur'], ['Netrokona'], ['Sherpur']
                            ]
                        };

                        /* Area list : jei city/label er jonno data ache shudhu tar jonno dropdown dekhabe,
                           baki city te text field. Notun city-r area boshate ekhane add korun. */
                        var areaMap = {
                            'Dhaka Metro': [
                                'Adabor', 'Agargaon', 'Badda', 'Banani', 'Bangshal', 'Baridhara', 'Bashundhara R/A', 'Biman Bandar Thana',
                                'Cantonment', 'Chawkbazar', 'Dakshin Khan', 'Demra', 'Dhanmondi', 'Dohar', 'Farmgate', 'Gabtoli',
                                'Gendaria', 'Gulshan', 'Hazaribagh', 'Jatrabari', 'Kadamtali', 'Kafrul', 'Kalabagan', 'Kamrangir Char',
                                'Khilgaon', 'Khilkhet', 'Kotwali', 'Lalbagh', 'Malibagh', 'Mirpur', 'Moghbazar', 'Mohakhali',
                                'Mohammadpur', 'Motijheel', 'Mugda', 'New Market', 'Pallabi', 'Paltan', 'Ramna', 'Rampura',
                                'Sabujbagh', 'Shahbagh', 'Shahjahanpur', 'Sher-e-Bangla Nagar', 'Shyampur', 'Shyamoli', 'Sutrapur',
                                'Tejgaon', 'Turag', 'Uttar Khan', 'Uttara', 'Vatara', 'Wari'
                            ],
                            'Dhaka Suburb': [
                                'Ashulia', 'Dhamrai', 'Hemayetpur', 'Keraniganj', 'Nawabganj', 'Savar', 'Zirabo'
                            ]
                        };

                        var divCities = {};     // division -> [city labels]
                        var cityIndex = {};     // city label -> DB district
                        var usedDistricts = {};

                        Object.keys(divisionDefs).forEach(function (div) {
                            divCities[div] = [];
                            divisionDefs[div].forEach(function (def) {
                                var label = def[0];
                                var aliases = (def[1] || label).split('|').map(norm);
                                var district = null;
                                for (var i = 0; i < allDistricts.length; i++) {
                                    if (aliases.indexOf(norm(allDistricts[i])) !== -1) { district = allDistricts[i]; break; }
                                }
                                if (district) {
                                    divCities[div].push(label);
                                    cityIndex[label] = district;
                                    usedDistricts[district] = true;
                                }
                            });
                        });

                        // kono division e na mila district gulo "Other" e (jate shipping miss na hoy)
                        var otherList = allDistricts.filter(function (d) { return !usedDistricts[d]; });
                        if (otherList.length) {
                            divCities['Other'] = otherList.slice();
                            otherList.forEach(function (d) { cityIndex[d] = d; });
                        }

                        Object.keys(divCities).forEach(function (div) {
                            if (!divCities[div].length) return;
                            var o = document.createElement('option');
                            o.value = div; o.textContent = div;
                            divSelect.appendChild(o);
                        });

                        function labelOfDistrict(district) {
                            var found = '';
                            Object.keys(divCities).some(function (div) {
                                return divCities[div].some(function (lb) {
                                    if (cityIndex[lb] === district) { found = lb; return true; }
                                    return false;
                                });
                            });
                            return found;
                        }
                        function divisionOfLabel(label) {
                            var found = '';
                            Object.keys(divCities).forEach(function (div) {
                                if (divCities[div].indexOf(label) !== -1 && !found) found = div;
                            });
                            return found;
                        }

                        function fillCities(div, selectedLabel) {
                            citySelect.innerHTML = '<option value="">Select city</option>';
                            (divCities[div] || []).forEach(function (lb) {
                                var o = document.createElement('option');
                                o.value = lb; o.textContent = lb;
                                if (selectedLabel && lb === selectedLabel) o.selected = true;
                                citySelect.appendChild(o);
                            });
                        }

                        function fillAreas(label, val) {
                            val = val || '';
                            var list = areaMap[label];
                            if (list) {
                                areaSelect.classList.remove('d-none-ck');
                                areaText.classList.add('d-none-ck');
                                areaSelect.innerHTML = '<option value="">Select area</option>';
                                var hasVal = false;
                                list.forEach(function (a) {
                                    var o = document.createElement('option');
                                    o.value = a; o.textContent = a;
                                    if (a === val) { o.selected = true; hasVal = true; }
                                    areaSelect.appendChild(o);
                                });
                                if (val && !hasVal) {
                                    var x = document.createElement('option');
                                    x.value = val; x.textContent = val; x.selected = true;
                                    areaSelect.appendChild(x);
                                }
                                areaHidden.value = areaSelect.value;
                            } else if (label) {
                                // ei city er area list nai => text field
                                areaSelect.classList.add('d-none-ck');
                                areaText.classList.remove('d-none-ck');
                                areaText.value = val;
                                areaHidden.value = val;
                            } else {
                                areaSelect.classList.remove('d-none-ck');
                                areaText.classList.add('d-none-ck');
                                areaSelect.innerHTML = '<option value="">Select area</option>';
                                areaHidden.value = '';
                            }
                        }

                        function setLocation(label, district, area) {
                            if (!label && district) label = labelOfDistrict(district);
                            if (!label) {
                                divSelect.value = '';
                                fillCities('', '');
                                cityHidden.value = district || '';
                                fillAreas('', area);
                                if (area) areaHidden.value = area;
                                return;
                            }
                            var div = divisionOfLabel(label);
                            divSelect.value = div;
                            fillCities(div, label);
                            cityHidden.value = cityIndex[label] || district || '';
                            fillAreas(label, area);
                        }

                        divSelect.addEventListener('change', function () {
                            fillCities(this.value, '');
                            cityHidden.value = '';
                            fillAreas('', '');
                            if (mode === 'new') fetchShippingCost('');
                        });
                        citySelect.addEventListener('change', function () {
                            cityHidden.value = cityIndex[this.value] || '';
                            fillAreas(this.value, '');
                            if (mode === 'new') fetchShippingCost(cityHidden.value);
                        });
                        areaSelect.addEventListener('change', function () { areaHidden.value = this.value; });
                        areaText.addEventListener('input', function () { areaHidden.value = this.value; });

                        // ---------- Shipping / delivery ----------
                        function setDelivery(cost, city) {
                            var box = document.getElementById('deliveryBox');
                            if (cost === null) {
                                box.innerHTML = '<p class="ck-note">No delivery methods available.</p>';
                                return;
                            }
                            box.innerHTML = '<div class="ck-ship"><span>Standard Delivery<small>' + esc(city) + '</small></span><b>' +
                                (cost === 0 ? 'Free' : money(cost)) + '</b></div>';
                        }
                        function updateGrandTotal(shippingCost) {
                            document.getElementById('summaryGrandTotal').textContent = money(cartSubtotal - cartDiscount + shippingCost);
                        }
                        function fetchShippingCost(city) {
                            var el = document.getElementById('summaryShipping');
                            if (!city) {
                                el.textContent = 'Select delivery city';
                                setDelivery(null);
                                updateGrandTotal(0);
                                return;
                            }
                            fetch("{{ route('checkout.shipping-cost') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ city: city })
                            })
                                .then(function (res) { return res.json(); })
                                .then(function (data) {
                                    if (data.success) {
                                        var cost = parseFloat(data.shipping_cost);
                                        if (cost === 0) { el.innerHTML = '<span class="free">Free</span>'; }
                                        else { el.textContent = money(cost); }
                                        setDelivery(cost, city);
                                        updateGrandTotal(cost);
                                    }
                                });
                        }

                        // ---------- Form <-> data ----------
                        function setType(t) {
                            addrType.value = t || 'home';
                            document.querySelectorAll('.ck-type').forEach(function (b) {
                                b.classList.toggle('active', b.getAttribute('data-type') === addrType.value);
                            });
                        }
                        function readForm() {
                            return {
                                name: fName.value.trim(),
                                phone: fPhone.value.trim(),
                                address: fAddress.value.trim(),
                                area: areaHidden.value.trim(),
                                city: cityHidden.value,
                                cityLabel: citySelect.value,
                                type: addrType.value || 'home'
                            };
                        }
                        function applyFields(d) {
                            if (!d) {
                                fName.value = prefill.name || ''; fPhone.value = prefill.phone || ''; fAddress.value = '';
                                setLocation('', '', '');
                                setType('home');
                                return;
                            }
                            fName.value = d.name || '';
                            fPhone.value = d.phone || '';
                            fAddress.value = d.address || '';
                            setLocation(d.cityLabel || '', d.city || '', d.area || '');
                            setType(d.type || 'home');
                        }

                        // ---------- Saved address cards ----------
                        function selectSaved(radio) {
                            if (!radio) return;
                            radio.checked = true;
                            if (pendingRadio) pendingRadio.checked = false;
                            fName.value = radio.getAttribute('data-name') || '';
                            fPhone.value = radio.getAttribute('data-phone') || '';
                            autoFilled = true;
                            fetchShippingCost(radio.getAttribute('data-city'));
                        }

                        function bindSaved() {
                            savedRadios().forEach(function (r) {
                                r.onchange = function () { if (this.checked) selectSaved(this); };
                            });
                        }
                        bindSaved();

                        // Notun saved card banano (DB te save howar por)
                        function addSavedCard(a) {
                            var cityTx = String(a.city || '').trim();
                            var line   = String(a.address_line1 || '').trim();
                            var full   = (cityTx !== '' && line.toLowerCase().indexOf(cityTx.toLowerCase()) === -1) ? line + ', ' + cityTx : line;
                            var tag    = a.address_type ? '<span class="tag">' + esc(a.address_type) + '</span>' : '';

                            // edit hole ager card soriye dao
                            savedRadios().forEach(function (r) {
                                if (String(r.value) === String(a.id)) { r.closest('.ck-addr').remove(); }
                            });

                            var wrap = document.createElement('div');
                            wrap.className = 'ck-addr';
                            wrap.setAttribute('data-saved', '1');
                            wrap.innerHTML =
                                '<label class="ck-addr-main">' +
                                '<input type="radio" name="shipping_address_id" value="' + esc(a.id) + '" class="saved-address-radio"' +
                                ' data-city="' + esc(a.city) + '" data-name="' + esc(a.recipient_name) + '" data-phone="' + esc(a.phone) + '"' +
                                ' data-address="' + esc(a.address_line1) + '" data-address2="' + esc(a.address_line2) + '"' +
                                ' data-delete-url="' + esc(a.delete_url) + '">' +
                                '<span class="ck-addr-body"><span class="ck-dot"></span><span class="ck-addr-txt">' +
                                '<strong>' + esc(a.recipient_name || 'N/A') + tag + '</strong>' +
                                '<span>' + esc(full) + '</span><span>' + esc(a.phone) + '</span>' +
                                '</span></span></label>' +
                                '<span class="ck-addr-act">' +
                                '<button type="button" class="ck-act del js-del-saved" aria-label="Delete address" title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 7V4h6v3"/></svg></button>' +
                                '<button type="button" class="ck-act edit js-edit-saved" aria-label="Edit address" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h4L19 9a2.1 2.1 0 0 0-3-3L5 17v3z"/><path d="M14 7l3 3"/></svg></button>' +
                                '</span>';

                            document.getElementById('savedHolder').appendChild(wrap);
                            noAddrNote.classList.add('d-none-ck');
                            bindSaved();

                            var radio = wrap.querySelector('.saved-address-radio');
                            radio.checked = true;
                            return radio;
                        }

                        // Edit (saved) : form e data boshiye New tab e niye jay
                        document.addEventListener('click', function (e) {
                            var editBtn = e.target.closest('.js-edit-saved');
                            if (editBtn) {
                                var r = editBtn.closest('.ck-addr').querySelector('.saved-address-radio');
                                autoFilled = false;
                                editingId = r.value;
                                applyFields({
                                    name: r.getAttribute('data-name'),
                                    phone: r.getAttribute('data-phone'),
                                    address: r.getAttribute('data-address'),
                                    area: r.getAttribute('data-address2'),
                                    city: r.getAttribute('data-city'),
                                    cityLabel: '',
                                    type: 'home'
                                });
                                setMode('new');
                                return;
                            }

                            var delBtn = e.target.closest('.js-del-saved');
                            if (delBtn) {
                                var card = delBtn.closest('.ck-addr');
                                var radio = card.querySelector('.saved-address-radio');
                                var url = radio.getAttribute('data-delete-url');
                                if (!url) {
                                    toast('Not available', 'Address delete is not available right now.', 'error');
                                    return;
                                }
                                if (!confirm('Delete this address?')) return;
                                fetch(url, {
                                    method: 'DELETE',
                                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                                }).then(function (res) {
                                    if (!res.ok) throw new Error('fail');
                                    var wasChecked = radio.checked;
                                    card.remove();
                                    var left = savedRadios();
                                    noAddrNote.classList.toggle('d-none-ck', left.length > 0 || !!pendingData);
                                    if (wasChecked) {
                                        if (left.length) { selectSaved(left[0]); }
                                        else if (pendingData && pendingRadio) { selectPending(); }
                                        else { newRadio.checked = true; fetchShippingCost(''); }
                                    }
                                    toast('Deleted', 'Address deleted.');
                                }).catch(function () {
                                    toast('Error', 'Could not delete address.', 'error');
                                });
                                return;
                            }

                            // pending card edit / delete
                            if (e.target.closest('.js-edit-pending')) {
                                autoFilled = false;
                                applyFields(pendingData);
                                setMode('new');
                                return;
                            }
                            if (e.target.closest('.js-del-pending')) {
                                pendingData = null;
                                renderPending();
                                applyFields(null);
                                var first = savedRadios().filter(function (x) { return x.checked; })[0] || savedRadios()[0];
                                if (first) { selectSaved(first); } else { newRadio.checked = true; fetchShippingCost(''); }
                                return;
                            }
                        });

                        // ---------- Pending card (validation error er por ager deya data) ----------
                        function renderPending() {
                            if (!pendingData) {
                                pendingHolder.innerHTML = '';
                                pendingRadio = null;
                                noAddrNote.classList.toggle('d-none-ck', savedRadios().length > 0);
                                return;
                            }
                            var typeLabel = pendingData.type === 'office' ? 'Office' : 'Home';
                            var place = [pendingData.address, pendingData.area, pendingData.cityLabel || pendingData.city].filter(Boolean).join(', ');
                            pendingHolder.innerHTML =
                                '<div class="ck-addr">' +
                                '<label class="ck-addr-main">' +
                                '<input type="radio" id="pendingRadio" name="pending_choice">' +
                                '<span class="ck-addr-body"><span class="ck-dot"></span><span class="ck-addr-txt">' +
                                '<strong>' + esc(pendingData.name || 'N/A') + '<span class="tag">' + typeLabel + '</span></strong>' +
                                '<span>' + esc(place) + '</span>' +
                                '<span>' + esc(pendingData.phone) + '</span>' +
                                '</span></span></label>' +
                                '<span class="ck-addr-act">' +
                                '<button type="button" class="ck-act del js-del-pending" aria-label="Remove" title="Remove"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 7V4h6v3"/></svg></button>' +
                                '<button type="button" class="ck-act edit js-edit-pending" aria-label="Edit" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h4L19 9a2.1 2.1 0 0 0-3-3L5 17v3z"/><path d="M14 7l3 3"/></svg></button>' +
                                '</span></div>';
                            pendingRadio = document.getElementById('pendingRadio');
                            pendingRadio.addEventListener('change', function () { if (this.checked) selectPending(); });
                            noAddrNote.classList.add('d-none-ck');
                        }

                        function selectPending() {
                            if (!pendingData || !pendingRadio) return;
                            applyFields(pendingData);
                            pendingRadio.checked = true;
                            newRadio.checked = true;      // shipping_address_id = '' (new address)
                            autoFilled = false;
                            fetchShippingCost(pendingData.city);
                        }

                        // ---------- Tabs ----------
                        function setMode(m) {
                            mode = m;
                            tabFav.classList.toggle('active', m === 'fav');
                            tabNew.classList.toggle('active', m === 'new');
                            favPane.classList.toggle('d-none-ck', m !== 'fav');
                            newPane.classList.toggle('d-none-ck', m !== 'new');

                            if (m === 'new') {
                                newRadio.checked = true;
                                if (autoFilled) { applyFields(pendingData); autoFilled = false; }
                                fetchShippingCost(cityHidden.value);
                            } else {
                                if (pendingRadio && pendingRadio.checked) {
                                    selectPending();
                                } else {
                                    var checked = document.querySelector('.saved-address-radio:checked');
                                    if (checked) {
                                        selectSaved(checked);
                                    } else if (pendingData && pendingRadio) {
                                        selectPending();
                                    } else if (savedRadios().length) {
                                        selectSaved(savedRadios()[0]);
                                    } else {
                                        fetchShippingCost('');
                                    }
                                }
                            }
                        }
                        tabFav.addEventListener('click', function () { setMode('fav'); });
                        tabNew.addEventListener('click', function () { editingId = null; setMode('new'); });

                        // ---------- Home / Office ----------
                        document.querySelectorAll('.ck-type').forEach(function (b) {
                            b.addEventListener('click', function () { setType(this.getAttribute('data-type')); });
                        });

                        // ---------- Validate / Save / Cancel ----------
                        function validateNew() {
                            if (!fPhone.value.trim()) { toast('Mobile Number', 'Please enter your mobile number.', 'error'); fPhone.focus(); return false; }
                            if (!fAddress.value.trim()) { toast('Street Address', 'Please enter your street address.', 'error'); fAddress.focus(); return false; }
                            if (!divSelect.value) { toast('Division', 'Please select your division.', 'error'); divSelect.focus(); return false; }
                            if (!cityHidden.value) { toast('City', 'Please select your city.', 'error'); citySelect.focus(); return false; }
                            if (!areaHidden.value.trim()) { toast('Area', 'Please select your area.', 'error'); (areaText.classList.contains('d-none-ck') ? areaSelect : areaText).focus(); return false; }
                            return true;
                        }

                        // Save Address => DB te save, tarpor saved card hisebe select
                        document.getElementById('addrSave').addEventListener('click', function () {
                            if (!validateNew() || addrSaving) return;

                            var d   = readForm();
                            var btn = this;
                            addrSaving = true;
                            btn.disabled = true;
                            btn.textContent = 'Saving...';

                            fetch("{{ route('checkout.address.store') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    address_id: editingId,
                                    name: d.name,
                                    phone: d.phone,
                                    address_line1: d.address,
                                    address_line2: d.area,
                                    city: d.city,
                                    address_type: d.type
                                })
                            })
                                .then(function (res) {
                                    return res.json().then(function (data) { return { status: res.status, ok: res.ok, data: data }; });
                                })
                                .then(function (r) {
                                    if (r.status === 401) { window.location.href = "{{ route('otp.login') }}"; return; }
                                    if (!r.ok || !r.data.success) {
                                        var msg = 'Could not save address.';
                                        if (r.data && r.data.errors) { msg = r.data.errors[Object.keys(r.data.errors)[0]][0]; }
                                        toast('Error', msg, 'error');
                                        return;
                                    }

                                    pendingData = null;
                                    renderPending();
                                    editingId = null;
                                    autoFilled = false;
                                    if (!prefill.phone) { prefill.phone = d.phone; }

                                    var radio = addSavedCard(r.data.address);
                                    setMode('fav');
                                    applyFields(null);
                                    selectSaved(radio);

                                    toast('Address saved', 'Address saved. Click "Proceed to Pay" to place your order.');
                                })
                                .catch(function () {
                                    toast('Error', 'Could not save address. Please try again.', 'error');
                                })
                                .then(function () {
                                    addrSaving = false;
                                    btn.disabled = false;
                                    btn.textContent = 'Save Address';
                                });
                        });

                        document.getElementById('addrCancel').addEventListener('click', function () {
                            editingId = null;
                            applyFields(pendingData);
                            setMode('fav');
                        });

                        // ---------- Summary items ----------
                        document.getElementById('itemsToggle').addEventListener('click', function () {
                            this.classList.toggle('open');
                            document.getElementById('itemsList').classList.toggle('open');
                        });
                        document.querySelectorAll('.js-soon').forEach(function (b) {
                            b.addEventListener('click', function () {
                                toast('Not available', 'This option is not available yet.', 'error');
                            });
                        });

                        // ---------- EMI accordion (ek shomoye ekta open) ----------
                        document.querySelectorAll('.ck-emi-q').forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                var item   = this.closest('.ck-emi-item');
                                var isOpen = item.classList.contains('open');

                                document.querySelectorAll('.ck-emi-item.open').forEach(function (i) {
                                    i.classList.remove('open');
                                    i.querySelector('.ck-emi-q').setAttribute('aria-expanded', 'false');
                                });

                                if (!isOpen) {
                                    item.classList.add('open');
                                    this.setAttribute('aria-expanded', 'true');
                                }
                            });
                        });

                        // ---------- Step 1 <-> Step 2 ----------
                        function setStep(st) {
                            step = st;
                            document.getElementById('addrStep').classList.toggle('d-none-ck', st !== 'addr');
                            document.getElementById('payStep').classList.toggle('d-none-ck', st !== 'pay');
                            document.getElementById('stepAddrLbl').classList.toggle('on', st === 'addr');
                            document.getElementById('stepPayLbl').classList.toggle('on', st === 'pay');
                            document.getElementById('placeOrderBtn').textContent = st === 'pay' ? 'Place Order' : 'Continue to payment';
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                        document.getElementById('backToAddr').addEventListener('click', function () { setStep('addr'); });

                        // ---------- Submit ----------
                        // Step 1 e button chaple => payment step e jabe ; Step 2 e => order place hobe
                        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
                            if (mode === 'new') {
                                if (!validateNew()) { e.preventDefault(); return; }
                                newRadio.checked = true;
                            } else if (pendingRadio && pendingRadio.checked) {
                                applyFields(pendingData);
                                newRadio.checked = true;
                            } else if (!document.querySelector('.saved-address-radio:checked')) {
                                e.preventDefault();
                                toast('Address', 'Please select an address or add a new one.', 'error');
                                return;
                            }

                            if (step === 'addr') {
                                e.preventDefault();
                                setStep('pay');
                                return;
                            }

                            var pm = document.querySelector('input[name="payment_method"]:checked');
                            if (!pm) {
                                e.preventDefault();
                                toast('Payment', 'Please select a payment method.', 'error');
                                return;
                            }
                            if (pm.value === 'bank_deposit') {
                                var depositFields=['deposit_date','depositor_bank','depositor_branch','deposit_type','deposit_amount','deposit_company_account','deposit_bank_name','deposit_company_name','deposit_attachment'];
                                var missingDepositField=depositFields.find(function(name){var field=document.querySelector('[name="'+name+'"]');return !field || !field.value;});
                                if(missingDepositField){e.preventDefault();var firstMissing=document.querySelector('[name="'+missingDepositField+'"]');firstMissing?.focus();toast('Deposit details','Please complete all required deposit fields and attach your receipt.','error');return;}
                            }
                            if (!document.getElementById('agreeTerms').checked) {
                                e.preventDefault();
                                toast('Terms', 'Please agree to the Terms and Conditions.', 'error');
                                return;
                            }
                            var btn = document.getElementById('placeOrderBtn');
                            btn.disabled = true;
                            btn.textContent = 'Processing...';
                        });

                        // Back button / bfcache theke ashle "Processing..." button reset
                        window.addEventListener('pageshow', function (ev) {
                            if (ev.persisted) {
                                var b = document.getElementById('placeOrderBtn');
                                b.disabled = false;
                                b.textContent = step === 'pay' ? 'Place Order' : 'Continue to payment';
                            }
                        });

                        // ---------- Initial state : Favourite tab always first ----------
                        if (oldCity) { setLocation('', oldCity, oldArea); }

                        if (hasOldNew) {
                            // validation error er por : ager deya new address abar card hisebe
                            pendingData = readForm();
                            renderPending();
                            setMode('fav');
                            if (pendingData.city) { selectPending(); }
                        } else if (!hasSaved) {
                            // kono saved address nai => sorasori New address form (name/phone/email already bosha)
                            setMode('new');
                        } else {
                            setMode('fav');
                        }
                    })();
                </script>

            @endif
        </div>
    </div>

@endsection
