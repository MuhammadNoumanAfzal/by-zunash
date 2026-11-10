<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Packing Slip #{{ $order->order_number }} | By Zunash Luxury Leather</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #120E0C; margin: 0; padding: 30px; background: #fff; font-size: 13px; }
        .slip-box { max-width: 820px; margin: auto; padding: 36px; border: 2px dashed #D5CBC0; border-radius: 16px; background: #fff; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 20px; border-bottom: 2px solid #120E0C; }
        .brand-title { font-family: 'Cinzel', serif; font-size: 26px; font-weight: 700; color: #120E0C; letter-spacing: 2px; margin: 0; }
        .brand-sub { font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #976239; font-weight: 700; margin-top: 3px; }
        .slip-badge { display: inline-block; padding: 4px 12px; background: #120E0C; color: #E7D5BA; font-family: 'Cinzel', serif; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; border-radius: 6px; margin-top: 6px; text-transform: uppercase; }
        .grid-2 { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 24px; margin: 24px 0; }
        .panel { padding: 16px; border-radius: 10px; background: #FAF7F2; border: 1px solid #ECE4DA; }
        .panel-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #976239; margin-bottom: 8px; display: flex; items-center; justify-content: space-between; }
        .fragile-box { padding: 10px 14px; background: #FFF5F5; border: 1.5px solid #F87171; border-radius: 8px; color: #991B1B; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; text-align: center; margin-bottom: 16px; }
        .cod-banner { padding: 14px; border-radius: 10px; background: #FFFBEB; border: 2px solid #F59E0B; text-align: center; }
        .cod-amount { font-family: 'Cinzel', serif; font-size: 24px; font-weight: 800; color: #92400E; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #7F7368; padding: 10px 8px; border-bottom: 2px solid #120E0C; background: #FAF8F5; }
        td { padding: 12px 8px; border-bottom: 1px solid #F0EAE1; font-size: 12px; }
        .check-box { width: 18px; height: 18px; border: 2px solid #8F8379; border-radius: 4px; display: inline-block; vertical-align: middle; }
        .sign-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-top: 36px; padding-top: 24px; border-top: 1px solid #ECE6DE; }
        .sign-line { border-top: 1.5px solid #120E0C; margin-top: 40px; padding-top: 6px; font-size: 11px; text-transform: uppercase; font-weight: 600; color: #6E6359; text-align: center; }
        .no-print { text-align: right; max-width: 820px; margin: 0 auto 20px auto; }
        .btn-print { padding: 10px 22px; background: #120E0C; color: #DAC694; border: 1px solid #C5A16B; border-radius: 10px; font-weight: 700; font-size: 12px; letter-spacing: 1px; cursor: pointer; text-transform: uppercase; }
        @media print {
            body { padding: 0; background: #fff; }
            .slip-box { border: 1px solid #000; box-shadow: none; border-radius: 0; padding: 20px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">
            Print Packaging Slip / Save PDF
        </button>
    </div>

    <div class="slip-box">
        
        <div class="header">
            <div>
                <h1 class="brand-title">BY ZUNASH</h1>
                <div class="brand-sub">Artisanal Leathercraft Atelier • Pakistan</div>
                <div class="slip-badge">Packaging & Courier Dispatch Slip</div>
            </div>
            <div style="text-align: right;">
                <div style="font-family: monospace; font-size: 18px; font-weight: 800; color: #976239;">
                    {{ $order->order_number }}
                </div>
                <div style="font-size: 11px; color: #7F7368; margin-top: 4px;">
                    Order Date: {{ $order->created_at->format('d M Y, h:i A') }}
                </div>
                <div style="font-size: 11px; color: #7F7368;">
                    Print Date: {{ now()->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>

        <div class="fragile-box" style="margin-top: 20px;">
            ⚠️ Luxury Genuine Leather — Handle with Care — Waterproof Outer Pouch Required
        </div>

        <div class="grid-2">
            <!-- Consignee Details -->
            <div class="panel">
                <div class="panel-title">
                    <span>Consignee / Delivery Address</span>
                    <span>PK Dispatch</span>
                </div>
                <div style="font-size: 15px; font-weight: 700; color: #120E0C; margin-bottom: 4px;">
                    {{ $order->customer_name }}
                </div>
                <div style="line-height: 1.5; color: #2B2420;">
                    {{ $order->shipping_address }}<br>
                    <strong>City:</strong> {{ $order->city }} @if($order->postal_code) (Postal: {{ $order->postal_code }}) @endif<br>
                    <strong>Phone / Mobile:</strong> <span style="font-family: monospace; font-size: 13px; font-weight: 700;">{{ $order->customer_phone }}</span><br>
                    <strong>Email:</strong> {{ $order->customer_email }}
                </div>
                @if($order->notes)
                    <div style="margin-top: 10px; padding-top: 8px; border-top: 1px dashed #D5CBC0; font-size: 11px; color: #92400E;">
                        <strong>Client Delivery Note:</strong> {{ $order->notes }}
                    </div>
                @endif
            </div>

            <!-- Courier Payment & Collection Box -->
            <div class="panel" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="panel-title">
                        <span>Courier Instructions</span>
                        <span>{{ $order->payment_method }}</span>
                    </div>
                    @if($order->payment_method === 'COD')
                        <div class="cod-banner">
                            <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #92400E;">
                                Cash on Delivery (COD) Amount to Collect:
                            </div>
                            <div class="cod-amount">
                                PKR {{ number_format($order->total) }}
                            </div>
                            <div style="font-size: 10px; color: #B45309; margin-top: 4px;">
                                Collect exact cash prior to handover.
                            </div>
                        </div>
                    @else
                        <div style="padding: 14px; border-radius: 10px; background: #ECFDF5; border: 2px solid #10B981; text-align: center;">
                            <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #065F46;">
                                Direct Bank Transfer (IBFT) — Paid in Full
                            </div>
                            <div style="font-family: 'Cinzel', serif; font-size: 20px; font-weight: 800; color: #047857; margin-top: 4px;">
                                DO NOT COLLECT CASH
                            </div>
                            <div style="font-size: 10px; color: #047857; margin-top: 4px;">
                                Pre-paid order. Hand over parcel to client.
                            </div>
                        </div>
                    @endif
                </div>

                <div style="font-size: 11px; color: #7F7368; margin-top: 10px;">
                    <strong>Fulfillment Status:</strong> {{ strtoupper($order->order_status) }}<br>
                    <strong>Sender:</strong> By Zunash Atelier, Lahore, Pakistan (+92-321-4700545)
                </div>
            </div>
        </div>

        <!-- Packing Checklist Table -->
        <div style="margin-top: 20px;">
            <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #120E0C; margin-bottom: 6px;">
                Articles to Pack (Fulfillment Checklist)
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">Packed</th>
                        <th>Article Name & Specification</th>
                        <th style="width: 120px;">SKU / Code</th>
                        <th style="width: 100px;">Color</th>
                        <th style="width: 70px; text-align: center;">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @if(is_array($order->items) && count($order->items) > 0)
                        @foreach($order->items as $item)
                            <tr>
                                <td style="text-align: center;">
                                    <span class="check-box"></span>
                                </td>
                                <td>
                                    <strong style="color: #120E0C;">{{ $item['name'] ?? 'By Zunash Leather Article' }}</strong>
                                    <div style="font-size: 10px; color: #7F7368;">Includes dust bag & authenticity care card</div>
                                </td>
                                <td style="font-family: monospace; font-size: 11px; color: #6E6359;">
                                    {{ $item['sku'] ?? 'BZ-' . substr(md5($item['name'] ?? ''), 0, 6) }}
                                </td>
                                <td>
                                    <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; background: #FAF7F2; border: 1px solid #E8DFD5; font-size: 10px; font-weight: 600;">
                                        {{ $item['color'] ?? 'Standard Tan' }}
                                    </span>
                                </td>
                                <td style="text-align: center; font-weight: 700; font-size: 14px;">
                                    {{ $item['qty'] ?? 1 }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align: center; color: #8F8379; padding: 20px;">
                                No item records attached to order.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Verification Sign-off -->
        <div class="sign-grid">
            <div>
                <div class="sign-line">Quality Control Inspector</div>
            </div>
            <div>
                <div class="sign-line">Packed & Sealed By</div>
            </div>
            <div>
                <div class="sign-line">Courier Rider Signature</div>
            </div>
        </div>

        <!-- Footer -->
        <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #8F8379; border-top: 1px solid #ECE6DE; padding-top: 14px;">
            By Zunash Atelier • Genuine Full-Grain Leather Handcrafted in Pakistan • WhatsApp Concierge: +92 321 4700545
        </div>

    </div>

    <script>
        // Auto print if ?auto_print=1 is present
        if (new URLSearchParams(window.location.search).get('auto_print') === '1') {
            window.addEventListener('load', () => window.print());
        }
    </script>
</body>
</html>

