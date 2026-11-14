<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Closing Summary ({{ $closingDate->format('d M Y') }}) | By Zunash Atelier</title>
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

        /* Top Bar Action (No-Print) */
        .no-print-bar {
            max-width: 960px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            background: #ffffff;
            padding: 14px 20px;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .date-picker-form {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .date-picker-form input[type="date"] {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-family: inherit;
            font-size: 12px;
            color: var(--espresso-950);
            background: var(--cream-50);
            outline: none;
        }

        .btn-filter {
            padding: 8px 16px;
            background: var(--espresso-900);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-filter:hover { opacity: 0.9; }

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
            letter-spacing: 0.5px;
            cursor: pointer;
            text-transform: uppercase;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .btn-csv {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: #15803D;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
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

        /* Document Header */
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

        .closing-meta-sub {
            font-size: 11px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* 4 Key Financial Metrics */
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

        /* Reconciliation Grid */
        .section-title {
            font-family: 'Cinzel', serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--espresso-950);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .reconciliation-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        .recon-box {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px;
            background: #ffffff;
        }

        .recon-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .recon-table td {
            padding: 8px 0;
            border-bottom: 1px dashed var(--border);
        }

        .recon-table tr:last-child td {
            border-bottom: none;
            padding-top: 12px;
            font-weight: 800;
            font-size: 13px;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        .text-right {
            text-align: right;
        }

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
        .pill-blue { background: #DBEAFE; color: #1E40AF; }

        /* Tables for Itemized and Orders Ledger */
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

        .total-bar {
            margin-top: 10px;
            padding: 12px 16px;
            background: var(--cream-100);
            border: 1px solid var(--border);
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 700;
        }

        /* Sign-off section */
        .signoff-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-top: 40px;
            padding-top: 24px;
            border-top: 2px solid var(--border);
        }

        .signoff-box {
            font-size: 11px;
            color: var(--muted);
        }

        .sign-line {
            height: 40px;
            border-bottom: 1px solid var(--espresso-950);
            margin-bottom: 8px;
        }

        .sign-title {
            font-weight: 700;
            color: var(--espresso-950);
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }

        .doc-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 10px;
            color: var(--muted);
            border-top: 1px solid var(--border);
            padding-top: 14px;
            letter-spacing: 0.5px;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .container {
                border: none;
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }

            .kpi-card, .recon-box {
                border: 1px solid #ccc;
            }

            .signoff-grid {
                page-break-inside: avoid;
            }

            @page {
                size: A4 portrait;
                margin: 12mm 10mm;
            }
        }
    </style>
</head>
<body>

    <!-- Action Bar (Hidden on Print / PDF export) -->
    <div class="no-print-bar no-print">
        <div class="date-picker-form">
            <a href="{{ route('admin.analytics.index') }}" class="btn-back">
                &larr; Back to Atelier Analytics
            </a>

            <form method="GET" action="{{ route('admin.analytics.daily-closing') }}" style="display: flex; align-items: center; gap: 8px; margin-left: 10px;">
                <label for="date_picker" style="color: var(--muted);">Closing Date:</label>
                <input type="date" id="date_picker" name="date" value="{{ $closingDate->format('Y-m-d') }}">
                <button type="submit" class="btn-filter">Load Day</button>
            </form>
        </div>

        <div style="display: flex; items-center; gap: 10px;">
            <a href="{{ route('admin.analytics.daily-closing.csv', ['date' => $closingDate->format('Y-m-d')]) }}" class="btn-csv" title="Download daily closing CSV sheet">
                <span>Export CSV</span>
            </a>

            <button type="button" onclick="window.print()" class="btn-print" title="Print physical copy or Save as PDF">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>Print / Save PDF</span>
            </button>
        </div>
    </div>

    <!-- Main Printable Sheet -->
    <div class="container">
        
        <!-- Document Header -->
        <div class="doc-header">
            <div>
                <h1 class="brand-title">BY ZUNASH</h1>
                <div class="brand-sub">Luxury Leather Atelier • Lahore, Pakistan</div>
                <div class="report-badge">Daily Sales & Cashier Closing Report (Z-Report)</div>
            </div>

            <div class="header-meta">
                <div class="closing-date-hero">{{ $closingDate->format('l, d F Y') }}</div>
                <div class="closing-meta-sub">Audit Period: 00:00:00 – 23:59:59 PKT</div>
                <div class="closing-meta-sub">Generated: {{ now()->format('d M Y • h:i A') }}</div>
                <div class="closing-meta-sub">Operator: <strong>{{ auth()->user()->name ?? 'Atelier Super Admin' }}</strong></div>
            </div>
        </div>

        <!-- 4 Key Executive Totals -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-label">Gross Revenue Booked</div>
                <div class="kpi-value">Rs. {{ number_format($grossSales) }}</div>
                <div class="kpi-sub">Total of all orders received</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">Product Cost (COGS)</div>
                <div class="kpi-value" style="color: #92400E;">Rs. {{ number_format($totalCogs) }}</div>
                <div class="kpi-sub">Direct leather crafting costs</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">Net Gross Profit</div>
                <div class="kpi-value" style="color: var(--emerald);">Rs. {{ number_format($totalNetProfit) }}</div>
                <div class="kpi-sub">Margin: <strong>{{ $grossMarginPercent }}%</strong> of sales</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-label">Orders Booked</div>
                <div class="kpi-value">{{ $ordersCount }}</div>
                <div class="kpi-sub">AOV: <strong>Rs. {{ number_format($aov) }}</strong></div>
            </div>
        </div>

        <!-- Reconciliation Section (Two Columns) -->
        <div class="reconciliation-grid">
            
            <!-- Left: Payment Method Cashier Reconciliation -->
            <div class="recon-box">
                <div class="section-title">
                    <span>1. Payment Channel Reconciliation</span>
                    <span style="font-size: 11px; color: var(--gold-600);">Cashier Balance</span>
                </div>

                <table class="recon-table">
                    <tbody>
                        @foreach($paymentMethods as $key => $p)
                            <tr>
                                <td>
                                    <strong>{{ $p['label'] }}</strong>
                                    <div style="font-size: 10px; color: var(--muted);">{{ $p['count'] }} Order{{ $p['count'] == 1 ? '' : 's' }}</div>
                                </td>
                                <td class="text-right font-mono" style="font-weight: 600;">
                                    Rs. {{ number_format($p['amount']) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr style="border-top: 1px solid var(--border); padding-top: 6px;">
                            <td>
                                <span style="font-size: 11px; color: var(--muted);">Direct Bank / Mobile Confirmed Paid:</span>
                            </td>
                            <td class="text-right font-mono" style="color: var(--emerald); font-weight: 700;">
                                Rs. {{ number_format($paymentStatusSummary['paid']['amount']) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 11px; color: var(--muted);">Pending Courier Clearance (COD):</span>
                            </td>
                            <td class="text-right font-mono" style="color: #B45309; font-weight: 700;">
                                Rs. {{ number_format($paymentStatusSummary['pending']['amount']) }}
                            </td>
                        </tr>
                        <tr style="border-top: 2px solid var(--espresso-950);">
                            <td>TOTAL REVENUE RECONCILED:</td>
                            <td class="text-right font-mono" style="color: var(--espresso-950);">
                                Rs. {{ number_format($grossSales) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Right: Operational Fulfillment Status -->
            <div class="recon-box">
                <div class="section-title">
                    <span>2. Dispatch & Fulfillment</span>
                    <span style="font-size: 11px; color: var(--muted);">Courier Audit</span>
                </div>

                <table class="recon-table">
                    <tbody>
                        <tr>
                            <td>
                                <span class="pill pill-blue">Dispatched Today</span>
                            </td>
                            <td class="text-right font-mono font-bold">{{ $fulfillmentSummary['dispatched'] }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pill pill-amber">Pending / In Production</span>
                            </td>
                            <td class="text-right font-mono font-bold">{{ $fulfillmentSummary['pending'] }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pill pill-emerald">Delivered & Closed</span>
                            </td>
                            <td class="text-right font-mono font-bold">{{ $fulfillmentSummary['completed'] }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pill" style="background: #FEE2E2; color: #991B1B;">Returned / Courier Loss</span>
                            </td>
                            <td class="text-right font-mono font-bold">{{ $fulfillmentSummary['returned'] }}</td>
                        </tr>
                        @if($totalReturnLoss > 0)
                        <tr>
                            <td style="font-size: 11px; color: #991B1B;">Return Courier Fees Loss:</td>
                            <td class="text-right font-mono" style="color: #991B1B; font-weight: 700;">-Rs. {{ number_format($totalReturnLoss) }}</td>
                        </tr>
                        @endif
                        <tr style="border-top: 2px solid var(--espresso-950);">
                            <td>TOTAL ARTICLES SOLD TODAY:</td>
                            <td class="text-right font-mono">{{ $totalUnitsSold }} Units</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Section 3: Itemized Creations Sold Today -->
        <div style="margin-bottom: 28px;">
            <div class="section-title">
                <span>3. Itemized Articles Sold Today (Inventory Depletion)</span>
                <span style="font-size: 11px; color: var(--muted);">{{ count($itemsSold) }} Unique Products</span>
            </div>

            @if(count($itemsSold) > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Creation / Article Description</th>
                            <th>Tone / Variant</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">Selling Price</th>
                            <th class="text-right">Unit Cost</th>
                            <th class="text-right">Total Revenue</th>
                            <th class="text-right">Gross Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemsSold as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item['name'] }}</strong>
                                    @if($item['sku'] !== 'N/A')
                                        <div style="font-size: 9.5px; color: var(--muted); font-family: monospace;">SKU: {{ $item['sku'] }}</div>
                                    @endif
                                </td>
                                <td>{{ $item['variant'] }}</td>
                                <td class="text-right font-mono font-bold">{{ $item['quantity'] }}</td>
                                <td class="text-right font-mono">Rs. {{ number_format($item['unit_price']) }}</td>
                                <td class="text-right font-mono" style="color: var(--muted);">Rs. {{ number_format($item['unit_cost']) }}</td>
                                <td class="text-right font-mono font-bold">Rs. {{ number_format($item['total_sales']) }}</td>
                                <td class="text-right font-mono" style="color: var(--emerald); font-weight: 700;">Rs. {{ number_format($item['total_profit']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="total-bar">
                    <span>Total Inventory Depleted: <strong>{{ $totalUnitsSold }} Pieces</strong></span>
                    <span>Itemized Gross Profit: <strong style="color: var(--emerald);">Rs. {{ number_format($totalNetProfit) }}</strong></span>
                </div>
            @else
                <div style="padding: 24px; text-align: center; color: var(--muted); background: var(--cream-50); border: 1px dashed var(--border); border-radius: 12px; font-size: 12px;">
                    No product transactions recorded on {{ $closingDate->format('d F Y') }}.
                </div>
            @endif
        </div>

        <!-- Section 4: Daily Orders Ledger -->
        <div>
            <div class="section-title">
                <span>4. Daily Orders Transaction Ledger</span>
                <span style="font-size: 11px; color: var(--muted);">{{ $ordersCount }} Transaction{{ $ordersCount == 1 ? '' : 's' }}</span>
            </div>

            @if($ordersCount > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Time</th>
                            <th>Patron Name</th>
                            <th>City</th>
                            <th>Payment</th>
                            <th>Courier & Tracking</th>
                            <th class="text-right">Cost</th>
                            <th class="text-right">Order Total</th>
                            <th class="text-right">Net Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $ord)
                            <tr>
                                <td class="font-mono font-bold" style="color: var(--gold-600);">
                                    {{ $ord->order_number }}
                                </td>
                                <td class="font-mono" style="font-size: 10px;">{{ $ord->created_at->format('h:i A') }}</td>
                                <td>
                                    <strong>{{ $ord->customer_name }}</strong>
                                    <div style="font-size: 9.5px; color: var(--muted);">{{ $ord->customer_phone }}</div>
                                </td>
                                <td>{{ $ord->city }}</td>
                                <td>
                                    <span class="pill {{ $ord->payment_status === 'paid' ? 'pill-emerald' : 'pill-amber' }}">
                                        {{ strtoupper($ord->payment_method) }}
                                    </span>
                                </td>
                                <td>
                                    @if($ord->tracking_number)
                                        <span class="font-mono" style="font-size: 10px;">{{ $ord->courier_name }}: {{ $ord->tracking_number }}</span>
                                    @else
                                        <span style="font-size: 10px; color: var(--muted);">Unassigned</span>
                                    @endif
                                </td>
                                <td class="text-right font-mono" style="color: var(--muted);">Rs. {{ number_format($ord->total_cost) }}</td>
                                <td class="text-right font-mono font-bold">Rs. {{ number_format($ord->total) }}</td>
                                <td class="text-right font-mono" style="color: {{ $ord->net_profit >= 0 ? 'var(--emerald)' : '#991B1B' }}; font-weight: 700;">
                                    Rs. {{ number_format($ord->net_profit) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 24px; text-align: center; color: var(--muted); background: var(--cream-50); border: 1px dashed var(--border); border-radius: 12px; font-size: 12px;">
                    No orders were recorded on this day.
                </div>
            @endif
        </div>

        <!-- Section 5: Official Sign-off & Audit Closure -->
        <div class="signoff-grid">
            <div class="signoff-box">
                <div class="sign-line"></div>
                <div class="sign-title">Prepared By (Cashier / Dispatch Lead)</div>
                <div style="margin-top: 2px;">Name: ______________________ &nbsp;&nbsp;&nbsp; Date: {{ $closingDate->format('d/m/Y') }}</div>
            </div>

            <div class="signoff-box">
                <div class="sign-line"></div>
                <div class="sign-title">Verified & Authorized By (Store Manager / Owner)</div>
                <div style="margin-top: 2px;">Name: ______________________ &nbsp;&nbsp;&nbsp; Date: {{ $closingDate->format('d/m/Y') }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="doc-footer">
            CONFIDENTIAL FINANCIAL DOCUMENT • FOR INTERNAL ATELIER AUDIT & TAX RECONCILIATION ONLY • BY ZUNASH LUXURY LEATHER
        </div>

    </div>

</body>
</html>

