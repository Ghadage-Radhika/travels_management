<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tax Receipt — {{ $tax->bus_number }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; font-size:12px; color:#1a1a2e; background:#fff; padding:40px 48px; max-width:760px; margin:0 auto; }

        /* ── Letterhead ── */
        .letterhead { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; }
        .lh-left h1  { font-size:24px; font-weight:800; color:#0e7490; letter-spacing:-0.5px; }
        .lh-left p   { font-size:11px; color:#64748b; margin-top:3px; }
        .lh-right    { text-align:right; }
        .doc-type    { font-size:20px; font-weight:800; color:#0891b2; text-transform:uppercase; letter-spacing:1px; }
        .doc-id      { font-size:11px; color:#94a3b8; margin-top:4px; }
        .doc-date    { font-size:11px; color:#64748b; margin-top:2px; }

        /* ── Divider ── */
        .divider     { height:3px; background:linear-gradient(90deg, #0891b2, #06b6d4, #67e8f9); border-radius:2px; margin-bottom:24px; }

        /* ── Status Banner ── */
        .status-banner {
            border-radius:10px; padding:13px 20px; margin-bottom:22px;
            display:flex; align-items:center; justify-content:space-between;
        }
        .status-banner.active  { background:#f0fdf4; border:1.5px solid #86efac; }
        .status-banner.expired { background:#fef2f2; border:1.5px solid #fca5a5; }
        .status-banner .s-label { font-size:13px; font-weight:700; }
        .status-banner.active  .s-label { color:#16a34a; }
        .status-banner.expired .s-label { color:#dc2626; }
        .status-banner .s-sub  { font-size:11px; color:#64748b; margin-top:2px; }
        .status-banner .days   { font-size:12px; font-weight:600; padding:5px 14px; border-radius:6px; }
        .status-banner.active  .days { background:rgba(22,163,74,.12); color:#16a34a; }
        .status-banner.expired .days { background:rgba(220,38,38,.1); color:#dc2626; }

        /* ── Info Grid ── */
        .section-title { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.7px; color:#64748b; margin-bottom:10px; padding-bottom:6px; border-bottom:1px solid #e2e8f0; }

        .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:0; border:1px solid #e2e8f0; border-radius:9px; overflow:hidden; margin-bottom:20px; }
        .info-row  { display:contents; }
        .info-row .lbl, .info-row .val { padding:11px 16px; border-bottom:1px solid #f0f4f8; }
        .info-row:last-child .lbl,
        .info-row:last-child .val { border-bottom:none; }
        .info-row .lbl { background:#f8fafc; font-size:10.5px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.4px; }
        .info-row .val { background:#fff; font-size:12.5px; font-weight:600; color:#1a1a2e; }
        .info-row .val.amount { font-size:18px; font-weight:800; color:#dc2626; }
        .info-row .val .bus-pill { display:inline-block; background:rgba(8,145,178,.12); color:#0e7490; padding:3px 12px; border-radius:6px; font-size:13px; font-weight:700; }

        /* ── Validity Visual ── */
        .validity-bar-wrap { background:#f8fafc; border:1px solid #e2e8f0; border-radius:9px; padding:16px 18px; margin-bottom:20px; }
        .vb-row  { display:flex; justify-content:space-between; font-size:11px; color:#64748b; margin-bottom:8px; }
        .vb-row strong { color:#1a1a2e; }
        .vb-track { height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden; }
        .vb-fill  { height:100%; border-radius:4px; }
        .vb-fill.active  { background:linear-gradient(90deg, #16a34a, #22c55e); }
        .vb-fill.expired { background:linear-gradient(90deg, #dc2626, #f87171); }

        /* ── Receipt image ── */
        .receipt-section { background:#f8fafc; border:1px solid #e2e8f0; border-radius:9px; padding:16px 18px; margin-bottom:20px; }
        .receipt-link { color:#0891b2; font-weight:700; font-size:12px; text-decoration:none; }

        /* ── Notes ── */
        .notes-box { background:#fffbeb; border:1px solid #fde68a; border-radius:9px; padding:14px 18px; margin-bottom:24px; }
        .notes-box p { font-size:12px; color:#78350f; line-height:1.6; }

        /* ── Signature area ── */
        .sig-row { display:flex; justify-content:space-between; margin-top:8px; padding-top:18px; border-top:1px dashed #e2e8f0; }
        .sig-block { text-align:center; width:180px; }
        .sig-block .sig-line { border-bottom:1.5px solid #1a1a2e; margin-bottom:5px; height:38px; }
        .sig-block p { font-size:10px; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; }

        /* ── Footer ── */
        .pg-foot { margin-top:20px; border-top:1px solid #e2e8f0; padding-top:10px; display:flex; justify-content:space-between; font-size:9.5px; color:#94a3b8; }

        /* ── Print bar ── */
        .pbar { margin-bottom:20px; display:flex; gap:8px; justify-content:flex-end; }
        .pbar button { padding:8px 18px; border-radius:6px; font-size:13px; font-weight:600; cursor:pointer; border:none; display:inline-flex; align-items:center; gap:6px; }
        .bp { background:#0891b2; color:#fff; }
        .bb { background:#f1f5f9; color:#475569; }
        @media print { .pbar { display:none; } body { padding:20px 28px; } }
    </style>
</head>
<body>

@if(!$exportMode)
<div class="pbar">
    <button class="bb" onclick="window.history.back()">&#8592; Back</button>
    <button class="bp" onclick="window.print()">&#128438; Print Receipt</button>
</div>
@endif

@php
    $expired   = $tax->tax_to->isPast();
    $today     = \Carbon\Carbon::today();
    $totalDays = $tax->tax_from->diffInDays($tax->tax_to) ?: 1;
    $usedDays  = $expired ? $totalDays : $tax->tax_from->diffInDays($today);
    $pct       = min(100, round(($usedDays / $totalDays) * 100));
    $remaining = $expired ? 0 : $today->diffInDays($tax->tax_to);
@endphp

{{-- ── Letterhead ── --}}
<div class="letterhead">
    <div class="lh-left">
        <h1>&#128640; Travel Management</h1>
        <p>Road Tax Payment Receipt</p>
    </div>
    <div class="lh-right">
        <div class="doc-type">Tax Receipt</div>
        <div class="doc-id">Record #{{ str_pad($tax->id, 5, '0', STR_PAD_LEFT) }}</div>
        <div class="doc-date">Issued: {{ now()->format('d M Y') }}</div>
    </div>
</div>
<div class="divider"></div>

{{-- ── Status Banner ── --}}
<div class="status-banner {{ $expired ? 'expired' : 'active' }}">
    <div>
        <div class="s-label">
            {{ $expired ? '&#10007; Tax Validity Expired' : '&#10003; Tax Validity Active' }}
        </div>
        <div class="s-sub">
            {{ $tax->bus_number }} &bull; {{ $tax->tax_from->format('d M Y') }} to {{ $tax->tax_to->format('d M Y') }}
        </div>
    </div>
    <div class="days">
        @if($expired)
            Expired {{ $today->diffInDays($tax->tax_to) }} day(s) ago
        @else
            {{ $remaining }} day(s) remaining
        @endif
    </div>
</div>

{{-- ── Vehicle & Payment Details ── --}}
<div class="section-title">&#128203; Vehicle &amp; Tax Details</div>
<div class="info-grid">
    <div class="info-row">
        <div class="lbl">Bus / Vehicle No.</div>
        <div class="val"><span class="bus-pill">{{ $tax->bus_number }}</span></div>
    </div>
    <div class="info-row">
        <div class="lbl">Payment Date</div>
        <div class="val">{{ $tax->tax_date->format('d M Y') }}</div>
    </div>
    <div class="info-row">
        <div class="lbl">Tax Valid From</div>
        <div class="val">{{ $tax->tax_from->format('d M Y') }}</div>
    </div>
    <div class="info-row">
        <div class="lbl">Tax Valid To</div>
        <div class="val {{ $expired ? '' : '' }}">{{ $tax->tax_to->format('d M Y') }}</div>
    </div>
    <div class="info-row">
        <div class="lbl">Validity Period</div>
        <div class="val">{{ $totalDays }} day(s)</div>
    </div>
    <div class="info-row">
        <div class="lbl">Amount Paid</div>
        <div class="val amount">&#8377;{{ number_format($tax->amount, 2) }}</div>
    </div>
</div>

{{-- ── Validity Progress Bar ── --}}
<div class="validity-bar-wrap">
    <div class="vb-row">
        <span>From: <strong>{{ $tax->tax_from->format('d M Y') }}</strong></span>
        <span>
            @if($expired)
                <strong style="color:#dc2626;">EXPIRED</strong>
            @else
                <strong style="color:#16a34a;">{{ $remaining }} days left</strong>
            @endif
        </span>
        <span>To: <strong>{{ $tax->tax_to->format('d M Y') }}</strong></span>
    </div>
    <div class="vb-track">
        <div class="vb-fill {{ $expired ? 'expired' : 'active' }}" style="width:{{ $pct }}%;"></div>
    </div>
</div>

{{-- ── Receipt Image ── --}}
<div class="receipt-section">
    <div class="section-title" style="border:none; margin-bottom:8px;">&#128247; Receipt / Document</div>
    @if($tax->tax_image)
        <a href="{{ Storage::url($tax->tax_image) }}" class="receipt-link" target="_blank">
            &#128196; View Attached Receipt
        </a>
    @else
        <span style="color:#94a3b8; font-size:12px;">No receipt image uploaded.</span>
    @endif
</div>

{{-- ── Notes ── --}}
@if($tax->notes)
<div class="notes-box">
    <div class="section-title" style="border-color:#fde68a; color:#92400e; margin-bottom:8px;">&#128221; Notes</div>
    <p>{{ $tax->notes }}</p>
</div>
@endif

{{-- ── Signature ── --}}
<div class="sig-row">
    <div class="sig-block">
        <div class="sig-line"></div>
        <p>Prepared By</p>
    </div>
    <div class="sig-block">
        <div class="sig-line"></div>
        <p>Authorised Signatory</p>
    </div>
    <div class="sig-block">
        <div class="sig-line"></div>
        <p>Manager / Admin</p>
    </div>
</div>

{{-- ── Footer ── --}}
<div class="pg-foot">
    <span>Travel Management System</span>
    <span>Tax Record #{{ str_pad($tax->id, 5, '0', STR_PAD_LEFT) }}</span>
    <span>{{ now()->format('d M Y, h:i A') }}</span>
</div>

</body>
</html>