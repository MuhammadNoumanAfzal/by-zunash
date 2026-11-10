<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Payment Receipt #{{ $order->order_number }} | By Zunash Atelier</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #120E0C; margin: 0; padding: 40px; background: #fff; font-size: 13px; }
        .receipt-card { max-width: 780px; margin: auto; padding: 40px; border: 1px solid #E5DCD2; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); position: relative; background: #fff; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 24px; border-bottom: 2px solid #120E0C; }
        .brand-name { font-family: 'Cinzel', serif; font-size: 26px; font-weight: 700; letter-spacing: 2px; margin: 0; }
        .voucher-title { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #976239; font-weight: 700; margin-top: 4px; }
        
        /* Payment Stamp */
        .stamp {
            display: inline-block;
            padding: 8px 16px;
            font-family: 'Cinzel', serif;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 2px;
            border-radius: 8px;
            text-transform: uppercase;
        }
        .stamp-paid {
            color: #047857;
            background: #ECFDF5;
            border: 2px solid #10B981;
        }
        .stamp-pending {
            color: #B45309;
            background: #FFFBEB;
            border: 2px solid #F59E0B;
        }
        .stamp-failed {
            color: #B91C1C;
            background: #FEF2F2;
            border: 2px solid #EF4444;
        }

        .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin: 28px 0; }
        .meta-col { font-size: 13px; line-height: 1.6; }
        .meta-col strong { color: #976239; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #8F8379; padding: 12px 10px; border-bottom: 1.5px solid #120E0C; background: #FAF7F2; }
        td { padding: 12px 10px; font-size: 12px; border-bottom: 1px solid #F0EAE1; }
        .text-right { text-align: right; }
        
        .totals-box { margin-top: 20px; border-top: 2px solid #120E0C; padding-top: 14px; }
        .total-line { display: flex; justify-content: space-between; padding: 5px 0; font-size: 13px; }
        .grand-total { font-family: 'Cinzel', serif; font-size: 20px; font-weight: 800; color: #120E0C; border-top: 1px solid #ECE6DE; margin-top: 8px; padding-top: 10px; }
        
        .bank-details { margin-top: 24px; padding: 16px; border-radius: 10px; background: #FAF8F5; border: 1px solid #EAE3DA; font-size: 12px; line-height: 1.6; }
        .signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px; padding-top: 20px; }
        .sign-placeholder { border-top: 1.5px solid #120E0C; padding-top: 6px; font-size: 11px; text-transform: uppercase; font-weight: 600; text-align: center; color: #6E6359; margin-top: 40px; }
        
        .no-print { text-align: right; max-width: 780px; margin: 0 auto 20px auto; }
        .btn-print { padding: 10px 22px; background: #120E0C; color: #DAC694; border: 1px solid #C5A16B; border-radius: 10px; font-weight: 700; font-size: 12px; letter-spacing: 1px; cursor: pointer; text-transform: uppercase; }
        
        @media print {
            body { padding: 0; background: #fff; }
            .receipt-card { border: none; box-shadow: none; padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">
            Print Receipt / Save PDF
        </button>
    </div>

    <div class="receipt-card">
        
        <div class="header">
            <div>
                <h1 class="brand-name">BY ZUNASH</h1>
                <div class="voucher-title">Official Settlement Receipt & Payment Voucher</div>
            </div>
            <div style="text-align: right;">
                <div style="margin-bottom: 8px;">
                    @if($order->payment_status === 'paid')
                        <span class="stamp stamp-paid">✓ PAID & CLEARED</span>
                    @elseif($order->payment_status === 'pending')
                        <span class="stamp stamp-pending">⏳ PENDING SETTLEMENT</span>
                    @else
                        <span class="stamp stamp-failed">✕ FAILED</span>
                    @endif
                </div>
                <div style="font-family: monospace; font-size: 14px; font-weight: 700; color: #976239;">
                    VOUCHER: REC-{{ $order->order_number }}
                </div>
                <div style="font-size: 11px; color: #8F8379; margin-top: 2px;">
                    Receipt Date: {{ now()->format('d F Y') }}
                </div>
            </div>
        </div>

        <div class="meta-grid">
            <div class="meta-col">
                <strong>RECEIVED FROM (PATRON):</strong>
                <span style="font-size: 14px; font-weight: 700;">{{ $order->customer_name }}</span><br>
                {{ $order->customer_email }}<br>
                {{ $order->customer_phone }}<br>
                {{ $order->city }}, Pakistan
            </div>

            <div class="meta-col" style="text-align: right;">
                <strong>PAYMENT TRANSACTION METRICS:</strong>
                Order Reference: <span style="font-family: monospace; font-weight: 700;">#{{ $order->order_number }}</span><br>
                Payment Channel: <span style="font-weight: 700; color: #976239;">{{ $order->payment_method }}</span><br>
                Order Placed On: {{ $order->created_at->format('d M Y, h:i A') }}<br>
                Fulfillment: <strong>{{ strtoupper($order->order_status) }}</strong>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Amount (PKR)</th>
                </tr>
            </thead>
            <tbody>
                @if(is_array($order->items) && count($order->items) > 0)
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item['name'] ?? 'By Zunash Leather Article' }}</strong>
                                @if(isset($item['sku']))<br><span style="font-size: 10px; color: #8F8379;">SKU: {{ $item['sku'] }}</span>@endif
                            </td>
                            <td class="text-right">{{ $item['qty'] ?? 1 }}</td>
                            <td class="text-right font-mono">Rs. {{ number_format($item['price'] ?? 0) }}</td>
                            <td class="text-right font-mono" style="font-weight: 600;">Rs. {{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1)) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Totals & Settlement Calculation -->
        <div class="totals-box">
            <div class="total-line">
                <span style="color: #6E6359;">Order Items Subtotal:</span>
                <span style="font-family: monospace; font-weight: 600;">PKR {{ number_format($order->subtotal) }}</span>
            </div>
            <div class="total-line">
                <span style="color: #6E6359;">Nationwide Insured Courier (Pakistan):</span>
                <span style="font-family: monospace; font-weight: 600; color: #16A34A;">Complimentary (PKR 0)</span>
            </div>
            <div class="total-line grand-total">
                <span>Total Amount Settled:</span>
                <span style="color: #976239;">PKR {{ number_format($order->total) }}</span>
            </div>
        </div>

        @if($order->payment_method === 'BANK_TRANSFER')
            <div class="bank-details">
                <strong style="color: #976239; text-transform: uppercase; font-size: 11px;">Settlement Account Details (Official IBFT):</strong><br>
                Bank: <strong>Meezan Bank Limited</strong> • Account Title: <strong>By Zunash</strong> • IBAN: <strong>PK82MEZN0001234567890123</strong><br>
                Branch: DHA Phase 5, Lahore, Pakistan • WhatsApp Clearance: <strong>+92 321 4700545</strong>
            </div>
        @elseif($order->payment_method === 'COD')
            <div class="bank-details" style="background: #FFFBEB; border-color: #FDE68A;">
                <strong style="color: #92400E; text-transform: uppercase; font-size: 11px;">Cash on Delivery Settlement Voucher:</strong><br>
                Amount receivable via authorized courier partner (TCS / Leopards / Trax) upon doorstep delivery in {{ $order->city }}.
            </div>
        @endif

        <div class="signatures">
            <div>
                <div class="sign-placeholder">Authorized Accounts Officer</div>
            </div>
            <div>
                <div class="sign-placeholder">Patron / Consignee Signature</div>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #8F8379; border-top: 1px solid #ECE6DE; padding-top: 14px;">
            This document serves as an official electronic payment voucher for By Zunash Luxury Leather Goods.<br>
            NTN: 8291045-3 • General Inquiries: concierge@byzunash.com • Phone/WhatsApp: +92 321 4700545
        </div>

    </div>

    <script>
        if (new URLSearchParams(window.location.search).get('auto_print') === '1') {
            window.addEventListener('load', () => window.print());
        }
    </script>
</body>
</html>

