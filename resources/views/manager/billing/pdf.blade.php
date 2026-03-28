{{-- resources/views/manager/billing/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Record #{{ $record->id }} — Venkatesh Tours</title>
    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',Arial,sans-serif; font-size:12px; color:#1a1a2e; background:#d6dce8; }

        /* ── Action bar ── */
        .action-bar {
            position:sticky; top:0; z-index:100;
            background:#0f1b2d; padding:11px 28px;
            display:flex; align-items:center; justify-content:space-between; gap:12px;
            box-shadow:0 2px 10px rgba(0,0,0,.35);
        }
        .action-bar-left { display:flex; align-items:center; gap:12px; }
        .action-bar-title { color:#fff; font-size:14px; font-weight:700; }
        .action-bar-sub   { color:rgba(255,255,255,.45); font-size:11px; margin-top:1px; }
        .action-bar-btns  { display:flex; gap:8px; align-items:center; }
        .btn-save { background:linear-gradient(135deg,#c9a84c,#e8c96a); color:#0f1b2d; border:none; padding:9px 22px; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
        .btn-print { background:rgba(59,130,246,.15); color:#93c5fd; border:1px solid rgba(59,130,246,.3); padding:9px 18px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:6px; }
        .btn-back  { background:rgba(255,255,255,.08); color:rgba(255,255,255,.7); border:1px solid rgba(255,255,255,.15); padding:9px 18px; border-radius:8px; font-size:13px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
        .btn-back:hover  { background:rgba(255,255,255,.15); color:#fff; }

        /* ── Bill wrapper ── */
        .bill { max-width:860px; margin:28px auto 48px; background:#fff; border-radius:4px; box-shadow:0 6px 32px rgba(0,0,0,.13); overflow:hidden; }
        .bill-top    { background:#0f1b2d; height:6px; }
        .bill-bottom { background:#c9a84c; height:4px; }

        /* ── Header ── */
        .bill-header { display:flex; justify-content:space-between; align-items:flex-start; padding:28px 32px 20px; border-bottom:2px dashed #dde3ef; }
        .bh-brand .brand-name { font-size:22px; font-weight:800; color:#0f1b2d; }
        .bh-brand .brand-name span { color:#c9a84c; }
        .bh-brand .brand-tag     { font-size:11px; color:#6b7280; margin-top:3px; letter-spacing:.5px; }
        .bh-brand .brand-contact { margin-top:10px; font-size:11px; color:#4b5563; line-height:1.8; }
        .bh-meta { text-align:right; }
        .bill-title { font-size:26px; font-weight:900; color:#0f1b2d; letter-spacing:3px; text-transform:uppercase; }
        .bill-no    { font-size:12px; color:#6b7280; margin-top:6px; }
        .bill-no span  { font-weight:700; color:#1e3052; }
        .bill-date     { font-size:12px; color:#6b7280; margin-top:4px; }
        .bill-date span { font-weight:700; color:#1e3052; }

        /* ── Trip info row ── */
        .trip-info { display:flex; background:#f8fafd; border-bottom:1px solid #e4e9f2; }
        .ti-box {
            flex:1; padding:14px 20px; border-right:1px solid #e4e9f2;
        }
        .ti-box:last-child { border-right:none; }
        .ti-label { font-size:9.5px; text-transform:uppercase; letter-spacing:1.2px; color:#9ca3af; font-weight:700; margin-bottom:5px; }
        .ti-val   { font-size:14px; font-weight:800; color:#0f1b2d; }
        .ti-val.gold  { color:#b8860b; }
        .ti-val.green { color:#15803d; }
        .ti-val.red   { color:#dc2626; }

        /* ── Section title ── */
        .sec-title {
            background:#1e3052; color:#fff;
            padding:8px 20px;
            font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px;
            display:flex; align-items:center; gap:8px;
        }

        /* ── Two column grid ── */
        .detail-grid {
            display:grid; grid-template-columns:1fr 1fr;
            gap:0;
            border-bottom:1px solid #e4e9f2;
        }
        .dg-row {
            display:flex; justify-content:space-between; align-items:center;
            padding:11px 20px; border-bottom:1px solid #f0f4f8; border-right:1px solid #e4e9f2;
            font-size:12.5px;
        }
        .dg-row:nth-child(2n) { border-right:none; }
        .dg-row:nth-last-child(-n+2) { border-bottom:none; }
        .dg-label { color:#6b7280; }
        .dg-val   { font-weight:700; color:#1e3052; }
        .dg-val.green { color:#15803d; }
        .dg-val.red   { color:#dc2626; }
        .dg-val.zero  { color:#9ca3af; font-weight:500; }

        /* ── Driver block ── */
        .driver-block { display:flex; gap:0; border-bottom:1px solid #e4e9f2; }
        .db-item { flex:1; padding:13px 20px; border-right:1px solid #e4e9f2; font-size:12.5px; }
        .db-item:last-child { border-right:none; }
        .db-label { font-size:9.5px; text-transform:uppercase; letter-spacing:1px; color:#9ca3af; font-weight:700; margin-bottom:4px; }
        .db-val   { font-weight:700; color:#1e3052; font-size:13px; }
        .db-val.muted { color:#9ca3af; font-weight:400; font-style:italic; }

        /* ── Description ── */
        .desc-block { padding:14px 20px; border-bottom:1px solid #e4e9f2; font-size:12.5px; color:#374151; line-height:1.7; }
        .desc-label { font-size:9.5px; text-transform:uppercase; letter-spacing:1px; color:#9ca3af; font-weight:700; margin-bottom:6px; }

        /* ── Totals ── */
        .bill-totals-wrap { display:flex; justify-content:flex-end; border-top:2px solid #e4e9f2; }
        .bill-totals { width:340px; border-left:1px solid #e4e9f2; }
        .tot-row {
            display:flex; justify-content:space-between; align-items:center;
            padding:10px 20px; border-bottom:1px solid #f0f2f8; font-size:12.5px;
        }
        .tot-row .t-label { color:#6b7280; }
        .tot-row .t-val   { font-weight:700; color:#1e3052; }
        .tot-row .t-val.green { color:#15803d; }
        .tot-row .t-val.red   { color:#dc2626; }
        .tot-row-grand {
            display:flex; justify-content:space-between; align-items:center;
            padding:14px 20px; background:#0f1b2d;
        }
        .tot-row-grand .t-label { color:rgba(255,255,255,.65); font-size:12px; font-weight:600; }
        .tot-row-grand .t-val   { font-size:18px; font-weight:900; }
        .tot-row-grand .t-val.green { color:#4ade80; }
        .tot-row-grand .t-val.red   { color:#f87171; }

        /* ── Footer ── */
        .bill-footer {
            display:flex; justify-content:space-between; align-items:center;
            padding:14px 32px; background:#f4f7fb; border-top:2px dashed #dde3ef;
        }
        .bf-left { font-size:11px; color:#9ca3af; }
        .bf-left strong { color:#6b7280; display:block; margin-bottom:2px; }
        .stamp {
            display:inline-block; border:2px solid #c9a84c; color:#c9a84c;
            font-size:10px; font-weight:800; letter-spacing:2px;
            text-transform:uppercase; padding:5px 14px; border-radius:4px; opacity:.75;
        }

        /* ── Print ── */
        @media print {
            body { background:#fff; }
            .action-bar { display:none !important; }
            .bill { margin:0; box-shadow:none; border-radius:0; max-width:100%; }
            .bill-top, .bill-bottom, .bill-header, .sec-title,
            .tot-row-grand { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
        }
        @page { size:A4 portrait; margin:8mm 10mm; }
    </style>
</head>
<body>

{{-- Action bar --}}
<div class="action-bar">
    <div class="action-bar-left">
        <span style="font-size:22px;">🧾</span>
        <div>
            <div class="action-bar-title">
                @if($exportMode) Export Bill as PDF @else Print Bill Preview @endif
                — Record #{{ $record->id }}
            </div>
            <div class="action-bar-sub">{{ now()->format('d M Y, h:i A') }}</div>
        </div>
    </div>
    <div class="action-bar-btns">
        @if($exportMode)
            <button class="btn-save" id="btnSave" onclick="triggerPrint()">⬇ Save as PDF</button>
        @else
            <button class="btn-print" onclick="window.print()">🖨 Print Bill</button>
        @endif
        <a href="{{ route('manager.dashboard') }}#mod-billing" class="btn-back">✕ Close</a>
    </div>
</div>

{{-- Bill --}}
<div class="bill">
    <div class="bill-top"></div>

    {{-- Header --}}
    <div class="bill-header">
        <div class="bh-brand">
            <div class="brand-name">🚌 Venkatesh <span>Tours</span></div>
            <div class="brand-tag">Tours & Travels — Bus Booking Management</div>
            <div class="brand-contact">📞 +91 00000 00000<br>✉ info@venkatesh-travels.com</div>
        </div>
        <div class="bh-meta">
            <div class="bill-title">Trip Bill</div>
            <div class="bill-no">Bill No. <span>#BL-{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}</span></div>
            <div class="bill-date">Booking Ref. <span>#BK-{{ str_pad($record->bus_booking_id, 4, '0', STR_PAD_LEFT) }}</span></div>
            <div class="bill-date">Generated: <span>{{ now()->format('d M Y, h:i A') }}</span></div>
        </div>
    </div>

    {{-- Trip summary boxes --}}
    @php $booking = $record->booking; @endphp
    <div class="trip-info">
        <div class="ti-box">
            <div class="ti-label">Route</div>
            <div class="ti-val">{{ $booking->route_from }} → {{ $booking->route_to }}</div>
        </div>
        <div class="ti-box">
            <div class="ti-label">Booking Date</div>
            <div class="ti-val">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
        </div>
        <div class="ti-box">
            <div class="ti-label">Bus No.</div>
            <div class="ti-val">{{ $booking->bus_number }}</div>
        </div>
        <div class="ti-box">
            <div class="ti-label">Distance</div>
            <div class="ti-val gold">{{ $booking->kilometer }} km</div>
        </div>
        <div class="ti-box">
            <div class="ti-label">Booking Amount</div>
            <div class="ti-val green">₹{{ number_format($booking->booking_amount, 2) }}</div>
        </div>
    </div>

    {{-- Expense breakdown --}}
    <div class="sec-title"><span>💸</span> Expense Breakdown</div>
    <div class="detail-grid">
        <div class="dg-row">
            <span class="dg-label">Rate per KM</span>
            <span class="dg-val {{ $record->rate_per_km ? '' : 'zero' }}">
                {{ $record->rate_per_km ? '₹'.number_format($record->rate_per_km,2).' /km' : '—' }}
            </span>
        </div>
        <div class="dg-row">
            <span class="dg-label">Diesel Amount</span>
            <span class="dg-val {{ $record->diesel_amount > 0 ? 'red' : 'zero' }}">
                {{ $record->diesel_amount > 0 ? '₹'.number_format($record->diesel_amount,2) : '—' }}
            </span>
        </div>
        <div class="dg-row">
            <span class="dg-label">Toll / Parking</span>
            <span class="dg-val {{ $record->toll_parking > 0 ? 'red' : 'zero' }}">
                {{ $record->toll_parking > 0 ? '₹'.number_format($record->toll_parking,2) : '—' }}
            </span>
        </div>
        <div class="dg-row">
            <span class="dg-label">Online Permit</span>
            <span class="dg-val {{ $record->online_permit > 0 ? 'red' : 'zero' }}">
                {{ $record->online_permit > 0 ? '₹'.number_format($record->online_permit,2) : '—' }}
            </span>
        </div>
        <div class="dg-row">
            <span class="dg-label">Driver Amount</span>
            <span class="dg-val {{ $record->driver_amount > 0 ? 'red' : 'zero' }}">
                {{ $record->driver_amount > 0 ? '₹'.number_format($record->driver_amount,2) : '—' }}
            </span>
        </div>
        <div class="dg-row">
            <span class="dg-label">Other Expenses</span>
            <span class="dg-val {{ $record->other_expenses > 0 ? 'red' : 'zero' }}">
                {{ $record->other_expenses > 0 ? '₹'.number_format($record->other_expenses,2) : '—' }}
            </span>
        </div>
    </div>

    {{-- Driver info --}}
    <div class="sec-title"><span>👤</span> Driver Information</div>
    <div class="driver-block">
        <div class="db-item">
            <div class="db-label">Driver Name</div>
            <div class="db-val {{ $record->driver_name ? '' : 'muted' }}">
                {{ $record->driver_name ?: 'Not specified' }}
            </div>
        </div>
        <div class="db-item">
            <div class="db-label">Driver Mobile</div>
            <div class="db-val {{ $record->driver_mobile ? '' : 'muted' }}">
                {{ $record->driver_mobile ?: 'Not specified' }}
            </div>
        </div>
        <div class="db-item">
            <div class="db-label">Pickup Time</div>
            <div class="db-val">{{ \Carbon\Carbon::parse($booking->pickup_time)->format('h:i A') }}</div>
        </div>
    </div>

    {{-- Description --}}
    @if($record->description)
    <div class="sec-title"><span>📝</span> Description / Notes</div>
    <div class="desc-block">{{ $record->description }}</div>
    @endif

    {{-- Totals --}}
    <div class="bill-totals-wrap">
        <div class="bill-totals">
            <div class="tot-row">
                <span class="t-label">Booking Amount</span>
                <span class="t-val">₹{{ number_format($booking->booking_amount,2) }}</span>
            </div>
            <div class="tot-row">
                <span class="t-label">Advance Paid</span>
                <span class="t-val green">₹{{ number_format($booking->advance_amount,2) }}</span>
            </div>
            <div class="tot-row">
                <span class="t-label">Balance Due</span>
                <span class="t-val red">₹{{ number_format($booking->remaining_amount,2) }}</span>
            </div>
            <div class="tot-row">
                <span class="t-label">Total Expenses</span>
                <span class="t-val red">− ₹{{ number_format($record->total_expenses,2) }}</span>
            </div>
            <div class="tot-row-grand">
                <span class="t-label">NET PROFIT</span>
                <span class="t-val {{ $record->net_profit >= 0 ? 'green' : 'red' }}">
                    ₹{{ number_format($record->net_profit,2) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="bill-footer">
        <div class="bf-left">
            <strong>Venkatesh Tours &amp; Travels</strong>
            Generated by Billing Module — {{ now()->format('d M Y, h:i A') }}
        </div>
        <div><div class="stamp">Official Bill</div></div>
    </div>

    <div class="bill-bottom"></div>
</div>

<script>
function triggerPrint() {
    const btn = document.getElementById('btnSave');
    if (btn) { btn.textContent = '⏳ Opening dialog…'; btn.disabled = true; }
    setTimeout(function() {
        window.print();
        setTimeout(function() {
            if (btn) { btn.innerHTML = '⬇ Save as PDF'; btn.disabled = false; }
        }, 2000);
    }, 150);
}
@if($exportMode)
window.addEventListener('load', function() { setTimeout(triggerPrint, 600); });
@endif
</script>
</body>
</html>