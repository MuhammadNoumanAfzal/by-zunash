<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Orders Summary Manifest | By Zunash Atelier</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #120E0C; margin: 0; padding: 25px; background: #fff; font-size: 12px; }
        .report-box { max-width: 1000px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 16px; border-bottom: 2px solid #120E0C; margin-bottom: 20px; }
        .brand-title { font-family: 'Cinzel', serif; font-size: 24px; font-weight: 700; margin: 0; }
        .brand-sub { font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: #976239; font-weight: 700; margin-top: 2px; }
        .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
        .kpi-card { padding: 12px; border-radius: 8px; background: #FAF8F5; border: 1px solid #ECE4DA; text-align: center; }
        .kpi-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #7F7368; }
        .kpi-value { font-family: 'Cinzel', serif; font-size: 18px; font-weight: 700; color: #120E0C; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px; }
        th { text-align: left; font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #7F7368; padding: 10px 6px; border-bottom: 2px solid #120E0C; background: #FAF7F2; }
        td { padding: 9px 6px; border-bottom: 1px solid #ECE6DE; }
        .text-right { text-align: right; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 9px; font-weight: 700; text-transform: uppercase; }
        .badge-paid { background: #ECFDF5; color: #047857; }
        .badge-pending { background: #FFFBEB; color: #B45309; }
        .badge-completed { background: #F0FDF4; color: #15803D; font-weight: 700; }
        .no-print { text-align: right; max-width: 1000px; margin: 0 auto 16px auto; }
        .btn-print { padding: 8px 18px; background: #120E0C; color: #DAC694; border: 1px solid #C5A16B; border-radius: 8px; font-weight: 700; font-size: 11px; letter-spacing: 1px; cursor: pointer; text-transform: uppercase; }
        @media print {
            body { padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">
            Print Report / Save PDF
        </button>
    </div>

    <div class="report-box">
        
        <div class="header">
            <div>
                <h1 class="brand-title">BY ZUNASH</h1>
                <div class="brand-sub">Master Orders & Dispatch Manifest</div>
            </div>
            <div style="text-align: right; font-size: 11px; color: #7F7368;">
                <strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}<br>
                <strong>Storefront:</strong> byzunash.com • Pakistan
            </div>
        </div>

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-label">Total Orders</div>
                <div class="kpi-value">{{ $totalOrders }}</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Delivered & Closed</div>
                <div class="kpi-value" style="color: #047857;">{{ $completedOrders }}</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Pending Dispatch</div>
                <div class="kpi-value" style="color: #B45309;">{{ $pendingOrders }}</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Total Volume (PKR)</div>
                <div class="kpi-value" style="color: #976239;">Rs. {{ number_format($totalRevenue) }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 110px;">Order #</th>
                    <th style="width: 85px;">Date</th>
                    <th>Patron / Client</th>
                    <th style="width: 90px;">City</th>
                    <th>Articles Summary</th>
                    <th style="width: 80px;">Payment</th>
                    <th style="width: 75px;">Pay Status</th>
                    <th style="width: 80px;">Fulfillment</th>
                    <th class="text-right" style="width: 90px;">Total (PKR)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $ord)
                    <tr>
                        <td style="font-family: monospace; font-weight: 700; color: #976239;">
                            {{ $ord->order_number }}
                        </td>
                        <td>{{ $ord->created_at->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $ord->customer_name }}</strong><br>
                            <span style="font-size: 10px; color: #7F7368;">{{ $ord->customer_phone }}</span>
                        </td>
                        <td>{{ $ord->city ?: '—' }}</td>
                        <td>
                            @if(is_array($ord->items) && count($ord->items) > 0)
                                @foreach($ord->items as $i)
                                    <div>{{ $i['name'] ?? 'Item' }} <span style="color: #8F8379;">×{{ $i['qty'] ?? 1 }}</span></div>
                                @endforeach
                            @else
                                <span style="color: #8F8379;">—</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 10px; font-weight: 600;">{{ $ord->payment_method }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $ord->payment_status === 'paid' ? 'badge-paid' : 'badge-pending' }}">
                                {{ $ord->payment_status }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $ord->order_status === 'completed' ? 'badge-completed' : 'badge-pending' }}">
                                {{ $ord->order_status }}
                            </span>
                        </td>
                        <td class="text-right" style="font-family: monospace; font-weight: 700;">
                            Rs. {{ number_format($ord->total) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: #8F8379; padding: 24px;">
                            No order records match the criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 24px; text-align: center; font-size: 10px; color: #8F8379; border-top: 1px solid #ECE6DE; padding-top: 10px;">
            By Zunash Luxury Leather • Internal Operations Manifest • Confidential
        </div>

    </div>

</body>
</html>

