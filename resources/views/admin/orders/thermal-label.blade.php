<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Label #{{ $order->order_number }} - By Zunash</title>
    <style>
        @page {
            size: 4in 6in;
            margin: 0;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: #ffffff;
            color: #000000;
            width: 4in;
            min-height: 6in;
            margin: 0 auto;
            padding: 0.18in;
            font-size: 11px;
            line-height: 1.25;
        }
        .label-container {
            border: 2px solid #000000;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .header {
            border-bottom: 2px solid #000000;
            padding: 6px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-title {
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .brand-sub {
            font-size: 8px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .barcode-section {
            border-bottom: 2px solid #000000;
            padding: 8px;
            text-align: center;
        }
        .barcode-svg {
            max-height: 48px;
            margin: 0 auto;
        }
        .barcode-text {
            font-family: monospace;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-top: 3px;
        }
        .grid-2 {
            display: flex;
            border-bottom: 2px solid #000000;
        }
        .sender-box {
            width: 45%;
            border-right: 1.5px solid #000000;
            padding: 6px 8px;
            font-size: 9.5px;
        }
        .courier-box {
            width: 55%;
            padding: 6px 8px;
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .consignee-section {
            border-bottom: 2px solid #000000;
            padding: 10px 8px;
            background: #ffffff;
        }
        .dest-city {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 4px;
        }
        .dest-name {
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 3px;
        }
        .dest-phone {
            font-size: 13px;
            font-weight: 900;
            font-family: monospace;
            margin-bottom: 4px;
        }
        .dest-address {
            font-size: 11px;
            line-height: 1.3;
            font-weight: 600;
        }
        .payment-banner {
            border-bottom: 2px solid #000000;
            padding: 8px;
            text-align: center;
        }
        .payment-banner.cod {
            background: #000000;
            color: #ffffff;
        }
        .payment-banner.prepaid {
            background: #ffffff;
            color: #000000;
            border-bottom: 2px dashed #000000;
        }
        .payment-title {
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .payment-amount {
            font-size: 26px;
            font-weight: 900;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            letter-spacing: 1px;
            line-height: 1.1;
            margin-top: 2px;
        }
        .payment-sub {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }
        .items-section {
            padding: 6px 8px;
            flex-grow: 1;
            font-size: 9.5px;
            border-bottom: 1.5px solid #000000;
        }
        .items-title {
            font-size: 8.5px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 4px;
            border-bottom: 1px solid #cccccc;
            padding-bottom: 2px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            line-height: 1.2;
        }
        .instructions-section {
            padding: 5px 8px;
            font-size: 8.5px;
            background: #f7f7f7;
            border-bottom: 1px solid #000000;
        }
        .footer {
            padding: 5px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 8px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .no-print {
            text-align: center;
            margin-bottom: 12px;
        }
        .print-btn {
            background: #1a1a1a;
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 8px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="print-btn" onclick="window.print()">🖨️ Print 4x6 Label</button>
        <button class="print-btn" style="background:#555;" onclick="window.close()">Close</button>
    </div>

    <div class="label-container">
        <!-- Header -->
        <div class="header">
            <div>
                <div class="brand-title">BY ZUNASH</div>
                <div class="brand-sub">Luxury Leathercraft Pakistan</div>
            </div>
            <div style="text-align: right; font-size: 9px; font-weight: 700;">
                <div>DATE: {{ $order->created_at ? $order->created_at->format('d/m/Y') : date('d/m/Y') }}</div>
                <div>ORDER: #{{ $order->order_number }}</div>
            </div>
        </div>

        <!-- Barcode Section -->
        <div class="barcode-section">
            <div class="barcode-svg">
                {!! \App\Support\BarcodeGenerator::svg($order->tracking_number ?: $order->order_number, 45, 2, 4) !!}
            </div>
            <div class="barcode-text">
                {{ $order->tracking_number ? ($order->courier_name . ': ' . $order->tracking_number) : $order->order_number }}
            </div>
        </div>

        <!-- Sender / Courier Row -->
        <div class="grid-2">
            <div class="sender-box">
                <div style="font-size: 8px; font-weight: 800; text-transform: uppercase; color: #555;">SHIP FROM:</div>
                <div style="font-weight: 800;">By Zunash Atelier</div>
                <div>Executive Leathercraft Studio</div>
                <div>Rawalpindi / Islamabad, Pakistan</div>
                <div style="font-family: monospace; font-weight: 700;">Helpline: +92 300 0000000</div>
            </div>
            <div class="courier-box">
                <div style="font-size: 8px; font-weight: 800; text-transform: uppercase; color: #555;">DESIGNATED COURIER:</div>
                <div style="font-size: 13px; font-weight: 900; text-transform: uppercase;">
                    {{ $order->courier_name ?: 'TCS Express' }}
                </div>
                <div style="font-size: 8.5px; font-weight: 700; margin-top: 2px;">
                    SERVICE: OVERNIGHT / AIR CARGO
                </div>
            </div>
        </div>

        <!-- Consignee / Destination Section -->
        <div class="consignee-section">
            <div style="font-size: 8px; font-weight: 800; text-transform: uppercase; color: #555;">DELIVER TO (CONSIGNEE):</div>
            <div class="dest-city">{{ strtoupper($order->city) }}</div>
            <div class="dest-name">{{ $order->customer_name }}</div>
            <div class="dest-phone">📞 {{ $order->customer_phone }}</div>
            <div class="dest-address">
                📍 {{ $order->shipping_address }}
                @if($order->postal_code)
                    — <strong>{{ $order->postal_code }}</strong>
                @endif
            </div>
        </div>

        <!-- Payment Banner -->
        @if($order->payment_method === 'COD')
            <div class="payment-banner cod">
                <div class="payment-title">CASH ON DELIVERY (COD)</div>
                <div class="payment-amount">RS. {{ number_format($order->total) }}</div>
                <div class="payment-sub">PLEASE COLLECT EXACT CASH BEFORE HANDOVER</div>
            </div>
        @else
            <div class="payment-banner prepaid">
                <div class="payment-title" style="color: #000;">PREPAID — {{ $order->payment_method }}</div>
                <div class="payment-amount" style="color: #000;">DO NOT COLLECT CASH</div>
                <div class="payment-sub">ORDER FULLY SETTLED VIA ONLINE IBFT / CARD</div>
            </div>
        @endif

        <!-- Items Packing Checklist -->
        <div class="items-section">
            <div class="items-title">PACKING VERIFICATION CHECKLIST ({{ count($order->items ?? []) }} ITEM{{ count($order->items ?? []) > 1 ? 'S' : '' }})</div>
            @if(is_array($order->items))
                @foreach($order->items as $item)
                    <div class="item-row">
                        <div>
                            <span>[ &nbsp; ]</span>
                            <strong>{{ $item['quantity'] ?? 1 }}x</strong>
                            <span>{{ $item['name'] ?? 'Product' }}</span>
                            @if(!empty($item['size']))
                                <span>(Size: {{ $item['size'] }})</span>
                            @endif
                            @if(!empty($item['color']))
                                <span>(Color: {{ $item['color'] }})</span>
                            @endif
                        </div>
                        <div style="font-family: monospace; font-weight: 700;">
                            Rs. {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Client Instructions / Handling -->
        @if($order->order_notes)
            <div class="instructions-section">
                <strong>NOTE:</strong> {{ $order->order_notes }}
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <span>✨ Authentic Pakistani Leathercraft</span>
            <span>Doorstep Inspection Allowed</span>
            <span>byzunash.com</span>
        </div>
    </div>

    <script>
        // Auto trigger print when loaded
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 300);
        });
    </script>
</body>
</html>

