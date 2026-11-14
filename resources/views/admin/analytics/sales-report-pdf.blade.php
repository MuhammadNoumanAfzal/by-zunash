<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }} ({{ $periodLabel }}) | By Zunash Atelier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --espresso-950: #120E0C;
            --espresso-900: #1F1815;
            --gold-600: #A87548;
            --gold-500: #C5A16B;
            --cream-50: #FAF8F5;
            --cream-100: #F4EFEA;
            --border: #E8E0D5;
            --emerald: #15803D;
            --muted: #7E7267;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #F7F5F0;
            color: var(--espresso-950);
            padding: 24px;
            line-height: 1.45;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(18, 14, 12, 0.05);
        }

        .no-print-bar {
            max-width: 960px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 14px 20px;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: #120E0C;
            color: #DAC694;
            border: 1px solid #C5A16B;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            text-transform: uppercase;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 9px 16px;
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .doc-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 24px;
            border-bottom: 2px solid var(--espresso-950);
        }

        .brand-title {
            font-family: 'Cinzel', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--espresso-950);
            letter-spacing: 1px;
        }

        .brand-sub {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold-600);
            font-weight: 700;
            margin-top: 3px;
        }

        .report-badge {
            display: inline-block;
            margin-top: 8px;
            padding: 3px 10px;
            border-radius: 6px;
            background: var(--cream-100);
            color: var(--espresso-900);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border: 1px solid var(--border);
        }

        .header-meta {
            text-align: right;
            font-size: 12px;
        }

        .closing-date-hero {
            font-family: 'Cinzel', serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--espresso-950);
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin: 28px 0;
        }

        .kpi-card {
            background: var(--cream-50);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px;
        }

        .kpi-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            font-weight: 700;
        }

        .kpi-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 20px;
            font-weight: 700;
            color: var(--espresso-950);
            margin-top: 6px;
        }

        .kpi-sub {
            font-size: 10px;
            color: var(--muted);
            margin-top: 4px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 11.5px;
        }

        .data-table th {
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--muted);
            padding: 10px 8px;
            border-bottom: 2px solid var(--espresso-950);
            background: var(--cream-50);
        }

        .data-table td {
            padding: 10px 8px;
            border-bottom: 1px solid var(--border);
        }

        .data-table tr:nth-child(even) {
            background-color: #FCFBF9;
        }

        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .text-right { text-align: right; }

        .pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .pill-emerald { background: #DCFCE7; color: #166534; }
        .pill-amber { background: #FEF3C7; color: #92400E; }

        .doc-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 10px;
            color: var(--muted);
            border-top: 1px solid var(--border);
            padding-top: 14px;
        }

        @media print {
            body { background: #ffffff; padding: 0; }
            .no-print { display: none !important; }
            .container { border: none; box-shadow: none; padding: 0; max-width: 100%; }
            @page { size: A4 portrait; margin: 12mm 10mm; }
        }
    </style>
</head>
<body>

    <div class="no-print-bar no-print">
        <a href="{{ route('admin.analytics.index') }}" class="btn-back">
            &larr; Back to Atelier Analytics
        </a>

        <button type="button" onclick="window.print()" class="btn-print">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            <span>Print / Save PDF</span>
        </button>
    </div>

    <div class="container">
        
        <div class="doc-header">
            <div style="display: flex; align-items: center; gap: 14px;">
                <img src="{{ asset('images/logo-dark-bg.png') }}" alt="By Zunash" style="height: 46px; width: auto; max-width: 160px; object-fit: contain;">
                <div>
                    <div class="brand-sub">Luxury Leather Atelier • Financial Audit</div>
                    <div class="report-badge">{{ $reportTitle }}</div>
                </div>
            </div>

            <div class="header-meta">
                <div class="closing-date-hero">{{ $periodLabel }}</div>
                <div style="font-size: 11px; color: var(--muted); margin-top: 4px;">Generated: {{ now()->format('d M Y • h:i A') }}</div>
                <div style="font-size: 11px; color: var(--muted);">Auditor: <strong>{{ auth()->user()->name ?? 'Atelier Super Admin' }}</strong></div>
            </div>
        </div>

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-label">Gross Sales Booked</div>
                <div class="kpi-value">Rs. {{ number_format($grossSales) }}</div>
                <div class="kpi-sub">{{ $ordersCount }} Total Orders</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">Product Cost (COGS)</div>
                <div class="kpi-value" style="color: #92400E;">Rs. {{ number_format($totalCogs) }}</div>
                <div class="kpi-sub">Direct inventory cost</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">Net Gross Profit</div>
                <div class="kpi-value" style="color: var(--emerald);">Rs. {{ number_format($totalNetProfit) }}</div>
                <div class="kpi-sub">Gross Margin: <strong>{{ $marginPercent }}%</strong></div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">Average Order (AOV)</div>
                <div class="kpi-value">Rs. {{ number_format($aov) }}</div>
                <div class="kpi-sub">Discounts: Rs. {{ number_format($totalDiscount) }}</div>
            </div>
        </div>

        <div style="margin-top: 24px;">
            <div style="font-family: 'Cinzel', serif; font-size: 13px; font-weight: 700; text-transform: uppercase; margin-bottom: 10px;">
                Orders Transaction Ledger
            </div>

            @if($ordersCount > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>City</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th class="text-right">Revenue</th>
                            <th class="text-right">Cost</th>
                            <th class="text-right">Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $ord)
                            <tr>
                                <td class="font-mono font-bold" style="color: var(--gold-600);">{{ $ord->order_number }}</td>
                                <td class="font-mono" style="font-size: 10px;">{{ $ord->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $ord->customer_name }}</strong>
                                    <div style="font-size: 9.5px; color: var(--muted);">{{ $ord->customer_phone }}</div>
                                </td>
                                <td>{{ $ord->city }}</td>
                                <td><span class="pill {{ $ord->payment_status === 'paid' ? 'pill-emerald' : 'pill-amber' }}">{{ strtoupper($ord->payment_method) }}</span></td>
                                <td>{{ ucfirst($ord->order_status) }}</td>
                                <td class="text-right font-mono font-bold">Rs. {{ number_format($ord->total) }}</td>
                                <td class="text-right font-mono" style="color: var(--muted);">Rs. {{ number_format($ord->total_cost) }}</td>
                                <td class="text-right font-mono" style="color: {{ $ord->net_profit >= 0 ? 'var(--emerald)' : '#991B1B' }}; font-weight: 700;">
                                    Rs. {{ number_format($ord->net_profit) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 24px; text-align: center; color: var(--muted); background: var(--cream-50); border: 1px dashed var(--border); border-radius: 12px; font-size: 12px;">
                    No orders recorded for this period.
                </div>
            @endif
        </div>

        <div class="doc-footer">
            CONFIDENTIAL FINANCIAL DOCUMENT • BY ZUNASH LUXURY LEATHER ATELIER
        </div>

    </div>

</body>
</html>

