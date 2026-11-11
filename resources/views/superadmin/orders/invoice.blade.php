<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $order->order_number ?? $order->id }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #222; margin: 0; background: #f3f3f3; }
        .toolbar { max-width: 820px; margin: 15px auto 0; display: flex; gap: 8px; justify-content: flex-end; padding: 0 10px; }
        .toolbar button, .toolbar a { background: #6c2bd9; color: #fff; border: 0; padding: 8px 18px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; }
        .toolbar a.back { background: #6c757d; }
        .sheet { max-width: 820px; margin: 15px auto; background: #fff; padding: 30px 35px; }
        .head { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #555; padding-bottom: 15px; }
        .head h2 { margin: 0 0 4px; font-size: 22px; }
        .head .logo img { max-height: 55px; max-width: 220px; display: block; }
        .head .right { text-align: right; line-height: 1.7; }
        .parties { display: flex; gap: 20px; margin: 20px 0; }
        .parties > div { flex: 1; line-height: 1.6; }
        .parties h4 { margin: 0 0 6px; font-size: 13px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.items th { text-align: left; border-bottom: 1px solid #aaa; padding: 8px 6px; font-size: 12px; }
        table.items td { border-bottom: 1px solid #ddd; padding: 10px 6px; vertical-align: top; }
        .r { text-align: right; }
        .c { text-align: center; }
        .totals { width: 320px; margin-left: auto; margin-top: 15px; }
        .totals td { padding: 5px 6px; }
        .totals tr.grand td { border-top: 2px solid #555; font-weight: bold; font-size: 15px; padding-top: 8px; }
        .green { color: #198754; font-weight: bold; }
        .red { color: #dc3545; font-weight: bold; }
        .notes { margin-top: 30px; font-size: 12px; line-height: 1.7; }
        .notes ul { padding-left: 18px; margin: 5px 0 0; }
        .badge { display: inline-block; border: 1px solid #999; padding: 1px 8px; border-radius: 10px; font-size: 11px; text-transform: uppercase; }
        @media print {
            body { background: #fff; }
            .toolbar { display: none; }
            .sheet { margin: 0; max-width: none; padding: 0; }
            @page { margin: 12mm; }
        }
    </style>
</head>
<body>

@php
    $paid = $order->payments->where('status', 'paid')->sum('amount');
    if ($paid == 0 && $order->payment_status === 'paid') {
        $paid = $order->total;
    }
    $due = max($order->total - $paid, 0);

    $addr = $order->shippingAddress;
    $addrLine = $addr
        ? collect([$addr->address_line1, $addr->address_line2, $addr->city, $addr->state, $addr->postal_code])->filter()->implode(', ')
        : '—';
    $custName  = $addr->recipient_name ?? $order->name ?? '—';
    $custPhone = $addr->phone ?? $order->phone ?? '—';
    $method    = optional($order->payments->first())->payment_method
        ?? optional($order->payments->first())->method
        ?? 'Cash On Delivery';

    // Invoice white background, tai normal logo age, na thakle logo_dark
    $logoPath = $site->logo ?: $site->logo_dark;
    $logoUrl  = $logoPath ? asset('storage/' . $logoPath) : null;
    $siteName = $site->site_name ?: config('app.name');
@endphp

<div class="toolbar">
    <a href="{{ route('superadmin.orders.show', $order->id) }}" class="back">Back</a>
    <button onclick="window.print()">Print / Save PDF</button>
</div>

<div class="sheet">
    <div class="head">
        <div class="logo">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $siteName }}">
            @else
                <h2>{{ $siteName }}</h2>
            @endif
        </div>
        <div class="right">
            <div>Invoice: <b>{{ $order->order_number ?? $order->id }}</b></div>
            <div>Date: {{ $order->created_at->format('d/m/Y h:i A') }}</div>
            <div>Payment Method: {{ \Illuminate\Support\Str::headline($method) }}</div>
            @if ($order->createdBy)
                <div>Care By: {{ $order->createdBy->name }}</div>
            @endif
            <div><span class="badge">{{ $order->payment_status }}</span></div>
        </div>
    </div>

    <div class="parties">
        <div>
            <h4>From</h4>
            {{ $siteName }}<br>
            {{ $site->address ?? '' }}<br>
            {{ $site->email ?? '' }}<br>
            {{ $site->phone ?? '' }}
        </div>
        <div>
            <h4>Bill to</h4>
            <b>{{ $custName }}</b><br>
            {{ $addrLine }}<br>
            Mobile: {{ $custPhone }}
        </div>
        <div>
            <h4>Ship to</h4>
            <b>{{ $custName }}</b><br>
            {{ $addrLine }}<br>
            Mobile: {{ $custPhone }}
        </div>
    </div>

    <table class="items">
        <thead>
        <tr>
            <th style="width:40px;">S.No</th>
            <th>Product</th>
            <th class="c" style="width:70px;">Qty</th>
            <th class="r" style="width:110px;">Unit price</th>
            <th class="r" style="width:120px;">Total price</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->orderItems as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product->name ?? 'Deleted product' }}</td>
                <td class="c">{{ $item->quantity }}</td>
                <td class="r">&#2547;{{ number_format($item->unit_price, 0) }}</td>
                <td class="r">&#2547;{{ number_format($item->total_price, 0) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr><td>Subtotal</td><td class="r">&#2547;{{ number_format($order->subtotal, 0) }}</td></tr>
        <tr><td>Shipping</td><td class="r">&#2547;{{ number_format($order->shipping_cost, 0) }}</td></tr>
        @if ($order->extra_charge > 0)
            <tr><td>Extra charge</td><td class="r">&#2547;{{ number_format($order->extra_charge, 0) }}</td></tr>
        @endif
        @if ($order->tax > 0)
            <tr><td>Tax</td><td class="r">&#2547;{{ number_format($order->tax, 0) }}</td></tr>
        @endif
        <tr><td>Discount</td><td class="r">- &#2547;{{ number_format($order->discount, 0) }}</td></tr>
        <tr class="grand"><td>Total</td><td class="r">&#2547;{{ number_format($order->total, 0) }}</td></tr>
        <tr><td class="green">Total Paid</td><td class="r green">&#2547;{{ number_format($paid, 0) }}</td></tr>
        <tr><td class="red">Total Due</td><td class="r red">&#2547;{{ number_format($due, 0) }}</td></tr>
    </table>

    <div class="notes">
        <b>Note:</b>
        <ul>
            <li>Make the payment first then receive the product.</li>
            <li>Check the physical condition in front of the rider. After proper verification, provide the OTP or Receiving Sign; otherwise, we will not accept any complaint regarding physical damage or missing items.</li>
            <li>Keep the product box and warranty card to claim the warranty.</li>
        </ul>
        @if ($order->notes)
            <p><b>Customer note:</b> {{ $order->notes }}</p>
        @endif
    </div>
</div>

</body>
</html>