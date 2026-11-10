<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }} | By Zunash Atelier</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #120E0C; margin: 0; padding: 40px; background: #fff; }
        .invoice-box { max-width: 800px; margin: auto; padding: 36px; border: 1px solid #ECE6DE; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .header { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 24px; border-bottom: 2px solid #120E0C; }
        .title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; color: #120E0C; letter-spacing: -0.5px; margin: 0; }
        .sub { font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: #976239; font-weight: 600; margin-top: 4px; }
        .details-grid { display: flex; justify-content: space-between; margin: 30px 0; }
        .col { font-size: 13px; line-height: 1.6; }
        .col strong { color: #976239; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #8F8379; padding: 12px 0; border-bottom: 1px solid #ECE6DE; }
        td { padding: 14px 0; font-size: 13px; border-bottom: 1px solid #FAF5F0; }
        .text-right { text-align: right; }
        .total-row { font-size: 20px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; color: #120E0C; }
        .footer { margin-top: 40px; text-align: center; font-size: 11px; color: #8F8379; border-top: 1px solid #ECE6DE; padding-top: 24px; line-height: 1.8; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; background: #FAF6F2; color: #976239; border: 1px solid #EED9C5; }
        @media print {
            body { padding: 0; }
            .invoice-box { border: none; box-shadow: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: right; max-width: 800px; margin: 0 auto 20px auto;">
        <button onclick="window.print()" style="padding: 10px 22px; background: #120E0C; color: #DAC694; border: 1px solid #C5A16B; border-radius: 10px; font-weight: 600; font-size: 12px; letter-spacing: 1px; cursor: pointer; text-transform: uppercase;">
            Print / Save PDF
        </button>
    </div>

    <div class="invoice-box">
        <div class="header">
            <div>
                <h1 class="title">BY ZUNASH</h1>
                <div class="sub">Artisanal Leathercraft • Handcrafted in Pakistan</div>
            </div>
            <div style="text-align: right;">
                <div style="font-family: monospace; font-size: 16px; font-weight: bold; color: #976239;">
                    {{ $order->order_number }}
                </div>
                <div style="font-size: 12px; color: #8F8379; margin-top: 4px;">
                    Date: {{ $order->created_at->format('d F Y') }}
                </div>
            </div>
        </div>

        <div class="details-grid">
            <div class="col">
                <strong>DELIVER TO:</strong><br>
                <span style="font-weight: 600; font-size: 14px;">{{ $order->customer_name }}</span><br>
                {{ $order->shipping_address }}<br>
                {{ $order->city }} {{ $order->postal_code }}<br>
                {{ $order->customer_email }}<br>
                {{ $order->customer_phone }}
            </div>
            <div class="col" style="text-align: right;">
                <strong>PAYMENT DETAILS:</strong><br>
                Method: <span class="badge">{{ $order->payment_method }}</span><br>
                Payment: <span style="font-weight: 600; color: {{ $order->payment_status === 'paid' ? '#16A34A' : '#D97706' }};">{{ strtoupper($order->payment_status) }}</span><br>
                Fulfillment: <span style="font-weight: 600;">{{ strtoupper($order->order_status) }}</span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Article Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @if(is_array($order->items) && count($order->items) > 0)
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item['name'] ?? 'By Zunash Leather Item' }}</strong>
                                @if(isset($item['sku']))<br><span style="font-size: 10px; color: #8F8379;">SKU: {{ $item['sku'] }}</span>@endif
                                @if(isset($item['color']))<span style="font-size: 10px; color: #8F8379;"> • Color: {{ $item['color'] }}</span>@endif
                            </td>
                            <td class="text-right">{{ $item['qty'] ?? 1 }}</td>
                            <td class="text-right font-mono">Rs. {{ number_format($item['price'] ?? 0) }}</td>
                            <td class="text-right font-mono" style="font-weight: 600;">Rs. {{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1)) }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td colspan="3" class="text-right" style="padding-top: 20px;">Subtotal:</td>
                    <td class="text-right font-mono" style="padding-top: 20px; font-weight: bold;">Rs. {{ number_format($order->subtotal) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">Nationwide Delivery:</td>
                    <td class="text-right" style="font-weight: bold; color: #16A34A;">Complimentary</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="text-right" style="padding-top: 15px; border-top: 2px solid #120E0C;">Total Payable:</td>
                    <td class="text-right font-mono" style="padding-top: 15px; border-top: 2px solid #120E0C; color: #976239;">Rs. {{ number_format($order->total) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            Thank you for commissioning your fine leathercraft with <strong>By Zunash</strong>.<br>
            Each piece is masterfully handcrafted using genuine full-grain leather hides in Pakistan.<br>
            For assistance, contact our concierge at <strong>concierge@byzunash.com</strong> or WhatsApp <strong>+92 321 4700545</strong>.
        </div>
    </div>

</body>
</html>
