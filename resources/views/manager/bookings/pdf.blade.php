{{--
    resources/views/manager/bookings/pdf.blade.php

    $exportMode = true  → Export PDF button: auto-triggers window.print() immediately
    $exportMode = false → Print View button: shows clean page, manager clicks Print manually
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Bookings — {{ now()->format('d M Y') }}</title>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            background: #d6dce8;
        }

        /* ── Action bar ── */
        .action-bar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #0f1b2d;
            padding: 11px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.35);
        }
        .action-bar-left { display: flex; align-items: center; gap: 12px; }
        .action-bar-icon { font-size: 22px; }
        .action-bar-title { color: #fff; font-size: 14px; font-weight: 700; }
        .action-bar-sub  { color: rgba(255,255,255,.45); font-size: 11px; margin-top: 1px; }
        .action-bar-btns { display: flex; gap: 8px; align-items: center; }

        .btn-save-pdf {
            background: linear-gradient(135deg, #c9a84c, #e8c96a);
            color: #0f1b2d; border: none; padding: 9px 22px;
            border-radius: 8px; font-size: 13px; font-weight: 700;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            transition: opacity .2s;
        }
        .btn-save-pdf:hover { opacity: .88; }
        .btn-print-only {
            background: rgba(59,130,246,.15); color: #93c5fd;
            border: 1px solid rgba(59,130,246,.3); padding: 9px 18px;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-print-only:hover { background: rgba(59,130,246,.25); }
        .btn-back {
            background: rgba(255,255,255,.08); color: rgba(255,255,255,.7);
            border: 1px solid rgba(255,255,255,.15); padding: 9px 18px;
            border-radius: 8px; font-size: 13px; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
        }
        .btn-back:hover { background: rgba(255,255,255,.15); color: #fff; }

        /* ── Bill wrapper ── */
        .bill {
            max-width: 860px;
            margin: 28px auto 48px;
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 6px 32px rgba(0,0,0,.13);
            overflow: hidden;
        }

        /* ── Bill top band ── */
        .bill-top {
            background: #0f1b2d;
            height: 6px;
        }

        /* ── Bill header ── */
        .bill-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 28px 32px 20px;
            border-bottom: 2px dashed #dde3ef;
        }
        .bh-brand .brand-name {
            font-size: 22px;
            font-weight: 800;
            color: #0f1b2d;
            letter-spacing: -0.5px;
        }
        .bh-brand .brand-name span { color: #c9a84c; }
        .bh-brand .brand-tag {
            font-size: 11px;
            color: #6b7280;
            margin-top: 3px;
            letter-spacing: 0.5px;
        }
        .bh-brand .brand-contact {
            margin-top: 10px;
            font-size: 11px;
            color: #4b5563;
            line-height: 1.8;
        }

        .bh-meta { text-align: right; }
        .bill-title {
            font-size: 26px;
            font-weight: 900;
            color: #0f1b2d;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .bill-no {
            font-size: 12px;
            color: #6b7280;
            margin-top: 6px;
        }
        .bill-no span { font-weight: 700; color: #1e3052; }
        .bill-date {
            margin-top: 4px;
            font-size: 12px;
            color: #6b7280;
        }
        .bill-date span { font-weight: 700; color: #1e3052; }

        /* ── Info row ── */
        .bill-info-row {
            display: flex;
            gap: 0;
            background: #f8fafd;
            border-bottom: 1px solid #e4e9f2;
        }
        .info-box {
            flex: 1;
            padding: 14px 20px;
            border-right: 1px solid #e4e9f2;
        }
        .info-box:last-child { border-right: none; }
        .info-box .ib-label {
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #9ca3af;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .info-box .ib-val {
            font-size: 17px;
            font-weight: 800;
            color: #0f1b2d;
        }
        .info-box .ib-val.gold  { color: #b8860b; }
        .info-box .ib-val.green { color: #15803d; }
        .info-box .ib-val.red   { color: #dc2626; }
        .info-box .ib-val.navy  { color: #1e3052; }
        .info-box .ib-sub {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 2px;
        }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }

        thead tr { background: #1e3052; }
        thead th {
            padding: 10px 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: rgba(255,255,255,.85);
            text-align: left;
            white-space: nowrap;
        }
        thead th.right { text-align: right; }

        tbody tr:nth-child(even) { background: #f7f9fc; }
        tbody tr:nth-child(odd)  { background: #fff; }
        tbody tr { border-bottom: 1px solid #eaecf4; }
        tbody td {
            padding: 10px 12px;
            vertical-align: middle;
            font-size: 12px;
            color: #374151;
        }
        tbody td.right { text-align: right; }

        .cell-no { color: #c9a84c; font-weight: 800; font-size: 11px; width: 30px; }

        .route-wrap { display: flex; align-items: center; gap: 6px; white-space: nowrap; }
        .r-from { font-weight: 700; color: #0f1b2d; }
        .r-arrow { color: #c9a84c; font-size: 14px; }
        .r-to   { font-weight: 700; color: #1e3052; }

        .km-pill {
            display: inline-block;
            background: rgba(201,168,76,.12);
            color: #7a5c10;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }
        .bus-pill {
            display: inline-block;
            background: rgba(30,48,82,.09);
            color: #1e3052;
            padding: 2px 9px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .amt-total { font-weight: 700; color: #0f1b2d; }
        .amt-adv   { font-weight: 600; color: #15803d; }
        .amt-due   { font-weight: 700; color: #dc2626; }
        .amt-clear { font-weight: 700; color: #15803d; }
        .note-cell { color: #9ca3af; font-style: italic; max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .empty-cell { text-align: center; padding: 50px; color: #9ca3af; font-size: 14px; }

        /* ── Totals block ── */
        .bill-totals-wrap {
            display: flex;
            justify-content: flex-end;
            padding: 0 0 0;
            border-top: 2px solid #e4e9f2;
        }
        .bill-totals {
            width: 320px;
            border-left: 1px solid #e4e9f2;
        }
        .tot-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            border-bottom: 1px solid #f0f2f8;
            font-size: 12.5px;
        }
        .tot-row .tot-label { color: #6b7280; }
        .tot-row .tot-val   { font-weight: 700; color: #1e3052; }
        .tot-row .tot-val.green { color: #15803d; }
        .tot-row .tot-val.red   { color: #dc2626; }
        .tot-row-grand {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            background: #0f1b2d;
        }
        .tot-row-grand .tot-label { color: rgba(255,255,255,.65); font-size: 12px; font-weight: 600; }
        .tot-row-grand .tot-val   { font-size: 18px; font-weight: 900; color: #c9a84c; }

        /* ── Footer ── */
        .bill-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 32px;
            background: #f4f7fb;
            border-top: 2px dashed #dde3ef;
        }
        .bf-left { font-size: 11px; color: #9ca3af; }
        .bf-left strong { color: #6b7280; display: block; margin-bottom: 2px; }
        .bf-right { text-align: right; }
        .bf-right .stamp {
            display: inline-block;
            border: 2px solid #c9a84c;
            color: #c9a84c;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 4px;
            opacity: .75;
        }

        /* ── Bottom band ── */
        .bill-bottom { background: #c9a84c; height: 4px; }

        /* ── Print ── */
        @media print {
            body        { background: #fff; }
            .action-bar { display: none !important; }
            .bill       { margin: 0; box-shadow: none; border-radius: 0; max-width: 100%; }

            .bill-top, .bill-bottom,
            .bill-header, thead tr,
            .tot-row-grand,
            tbody tr:nth-child(even) {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            table { page-break-inside: auto; }
            tr    { page-break-inside: avoid; }
        }

        @page { size: A4 portrait; margin: 8mm 10mm; }
    </style>
</head>
<body>

{{-- ── Action bar ── --}}
<div class="action-bar">
    <div class="action-bar-left">
        <span class="action-bar-icon">🚌</span>
        <div>
            <div class="action-bar-title">
                @if($exportMode) Export as PDF @else Print Preview @endif
                — Bus Booking Bill
            </div>
            <div class="action-bar-sub">{{ now()->format('d M Y, h:i A') }}</div>
        </div>
    </div>
    <div class="action-bar-btns">
        @if($exportMode)
            <button class="btn-save-pdf" id="btnSavePdf" onclick="triggerPrint()">
                ⬇ Save as PDF
            </button>
        @else
            <button class="btn-print-only" onclick="window.print()">
                🖨 Print Bill
            </button>
        @endif
        <a href="{{ route('manager.dashboard') }}#mod-booking" class="btn-back">
            ✕ Close
        </a>
    </div>
</div>

{{-- ── Bill ── --}}
<div class="bill">

    <div class="bill-top"></div>

    {{-- Header --}}
    <div class="bill-header">
        <div class="bh-brand">
            <div class="brand-name">🚌 Venkatesh <span>Tours</span></div>
            <div class="brand-tag">Tours &amp; Travels — Bus Booking Management</div>
            <div class="brand-contact">
                📞 +91 7796208383<br>
                ✉ info@venkatesh-travels.com
            </div>
        </div>
        <div class="bh-meta">
            <div class="bill-title">Invoice</div>
            <div class="bill-no">Bill No. <span>#VTT-{{ now()->format('Ymd') }}</span></div>
            <div class="bill-date">Date: <span>{{ now()->format('d M Y') }}</span></div>
            <div class="bill-date" style="margin-top:2px">Time: <span>{{ now()->format('h:i A') }}</span></div>
        </div>
    </div>

    {{-- Summary boxes --}}
    @if($bookings->count() > 0)
    <div class="bill-info-row">
        <div class="info-box">
            <div class="ib-label">Total Bookings</div>
            <div class="ib-val gold">{{ $bookings->count() }}</div>
            <div class="ib-sub">entries in this bill</div>
        </div>
        <div class="info-box">
            <div class="ib-label">Total Amount</div>
            <div class="ib-val navy">₹{{ number_format($bookings->sum('booking_amount'), 2) }}</div>
            <div class="ib-sub">gross booking value</div>
        </div>
        <div class="info-box">
            <div class="ib-label">Advance Paid</div>
            <div class="ib-val green">₹{{ number_format($bookings->sum('advance_amount'), 2) }}</div>
            <div class="ib-sub">collected advance</div>
        </div>
        <div class="info-box">
            <div class="ib-label">Balance Due</div>
            <div class="ib-val red">₹{{ number_format($bookings->sum('remaining_amount'), 2) }}</div>
            <div class="ib-sub">pending recovery</div>
        </div>
    </div>
    @endif

    {{-- Booking table --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Booking Date</th>
                    <th>Route</th>
                    <th>KM</th>
                    <th>Bus No.</th>
                    <th>Pickup</th>
                    <th class="right">Total (₹)</th>
                    <th class="right">Advance (₹)</th>
                    <th class="right">Balance (₹)</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $i => $b)
                <tr>
                    <td class="cell-no">{{ $i + 1 }}</td>

                    <td>{{ \Carbon\Carbon::parse($b->booking_date)->format('d M Y') }}</td>

                    <td>
                        <div class="route-wrap">
                            <span class="r-from">{{ $b->route_from }}</span>
                            <span class="r-arrow">→</span>
                            <span class="r-to">{{ $b->route_to }}</span>
                        </div>
                    </td>

                    <td><span class="km-pill">{{ $b->kilometer }} km</span></td>

                    <td><span class="bus-pill">{{ $b->bus_number }}</span></td>

                    <td style="white-space:nowrap">
                        {{ \Carbon\Carbon::parse($b->pickup_time)->format('h:i A') }}
                    </td>

                    <td class="amt-total right">{{ number_format($b->booking_amount, 2) }}</td>

                    <td class="amt-adv right">{{ number_format($b->advance_amount, 2) }}</td>

                    <td class="{{ $b->remaining_amount > 0 ? 'amt-due' : 'amt-clear' }} right">
                        {{ number_format($b->remaining_amount, 2) }}
                    </td>

                    <td class="note-cell" title="{{ $b->note }}">{{ $b->note ?: '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="empty-cell">🚍 No booking records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Totals block --}}
    @if($bookings->count() > 0)
    <div class="bill-totals-wrap">
        <div class="bill-totals">
            <div class="tot-row">
                <span class="tot-label">Subtotal (Booking Amount)</span>
                <span class="tot-val">₹{{ number_format($bookings->sum('booking_amount'), 2) }}</span>
            </div>
            <div class="tot-row">
                <span class="tot-label">Advance Collected</span>
                <span class="tot-val green">− ₹{{ number_format($bookings->sum('advance_amount'), 2) }}</span>
            </div>
            <div class="tot-row-grand">
                <span class="tot-label">BALANCE DUE</span>
                <span class="tot-val">₹{{ number_format($bookings->sum('remaining_amount'), 2) }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Footer --}}
    <div class="bill-footer">
        <div class="bf-left">
            <strong>Venkatesh Tours &amp; Travels</strong>
            Authorised document — Generated by Bus Booking Management System<br>
            {{ now()->format('d M Y, h:i A') }}
        </div>
        <div class="bf-right">
            <div class="stamp">Official Bill</div>
        </div>
    </div>

    <div class="bill-bottom"></div>

</div>{{-- /bill --}}

<script>
    function triggerPrint() {
        const btn = document.getElementById('btnSavePdf');
        if (btn) { btn.textContent = '⏳ Opening print dialog…'; btn.disabled = true; }
        setTimeout(function () {
            window.print();
            setTimeout(function () {
                if (btn) { btn.innerHTML = '⬇ Save as PDF'; btn.disabled = false; }
            }, 2000);
        }, 150);
    }

    @if($exportMode)
    window.addEventListener('load', function () { setTimeout(triggerPrint, 600); });
    @endif
</script>
</body>
</html>