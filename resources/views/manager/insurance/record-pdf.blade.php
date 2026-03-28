<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insurance Certificate — {{ $insurance->bus_number }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; font-size:12px; color:#1a1a2e; background:#fff; padding:40px 48px; max-width:760px; margin:0 auto; }

        /* ── Letterhead ── */
        .letterhead { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; }
        .lh-left h1  { font-size:24px; font-weight:800; color:#3730a3; letter-spacing:-0.5px; }
        .lh-left p   { font-size:11px; color:#64748b; margin-top:3px; }
        .lh-right    { text-align:right; }
        .doc-type    { font-size:20px; font-weight:800; color:#4f46e5; text-transform:uppercase; letter-spacing:1px; }
        .doc-id      { font-size:11px; color:#94a3b8; margin-top:4px; }
        .doc-date    { font-size:11px; color:#64748b; margin-top:2px; }

        /* ── Divider ── */
        .divider { height:3px; background:linear-gradient(90deg, #3730a3, #4f46e5, #818cf8); border-radius:2px; margin-bottom:24px; }

        /* ── Header card ── */
        .header-card {
            background:linear-gradient(135deg, #1e1b4b, #3730a3);
            border-radius:12px; padding:22px 26px; margin-bottom:22px;
            display:flex; justify-content:space-between; align-items:center;
            color:#fff;
        }
        .hc-left .label  { font-size:10px; opacity:0.65; text-transform:uppercase; letter-spacing:0.7px; }
        .hc-left .bus    { font-size:26px; font-weight:800; letter-spacing:1px; margin-top:3px; }
        .hc-left .sub    { font-size:11px; opacity:0.75; margin-top:4px; }
        .hc-right        { text-align:right; }
        .hc-right .label { font-size:10px; opacity:0.65; text-transform:uppercase; letter-spacing:0.7px; }
        .hc-right .amount { font-size:28px; font-weight:800; color:#a5b4fc; margin-top:3px; }
        .hc-right .sub   { font-size:11px; opacity:0.75; margin-top:4px; }

        /* ── Section title ── */
        .section-title { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.7px; color:#64748b; margin-bottom:10px; padding-bottom:6px; border-bottom:1px solid #e2e8f0; }

        /* ── Info Grid ── */
        .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:0; border:1px solid #e2e8f0; border-radius:9px; overflow:hidden; margin-bottom:20px; }
        .info-row  { display:contents; }
        .info-row .lbl, .info-row .val { padding:11px 16px; border-bottom:1px solid #f0f0ff; }
        .info-row:last-child .lbl,
        .info-row:last-child .val { border-bottom:none; }
        .info-row .lbl { background:#f5f3ff; font-size:10.5px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.4px; }
        .info-row .val { background:#fff; font-size:12.5px; font-weight:600; color:#1a1a2e; }
        .info-row .val.amount { font-size:20px; font-weight:800; color:#dc2626; }
        .info-row .val .bus-pill { display:inline-block; background:rgba(79,70,229,.12); color:#3730a3; padding:3px 12px; border-radius:6px; font-size:13px; font-weight:700; }

        /* ── Notes ── */
        .notes-box { background:#fffbeb; border:1px solid #fde68a; border-radius:9px; padding:14px 18px; margin-bottom:22px; }
        .notes-box p { font-size:12px; color:#78350f; line-height:1.6; }

        /* ── History placeholder ── */
        .info-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:9px; padding:14px 18px; margin-bottom:22px; }
        .info-box p { font-size:11.5px; color:#64748b; line-height:1.7; }

        /* ── Signature ── */
        .sig-row { display:flex; justify-content:space-between; margin-top:8px; padding-top:18px; border-top:1px dashed #e2e8f0; }
        .sig-block { text-align:center; width:180px; }
        .sig-block .sig-line { border-bottom:1.5px solid #1a1a2e; margin-bottom:5px; height:38px; }
        .sig-block p { font-size:10px; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; }

        /* ── Footer ── */
        .pg-foot { margin-top:20px; border-top:1px solid #e2e8f0; padding-top:10px; display:flex; justify-content:space-between; font-size:9.5px; color:#94a3b8; }

        /* ── Print bar ── */
        .pbar { margin-bottom:20px; display:flex; gap:8px; justify-content:flex-end; }
        .pbar button { padding:8px 18px; border-radius:6px; font-size:13px; font-weight:600; cursor:pointer; border:none; display:inline-flex; align-items:center; gap:6px; }
        .bp { background:#4f46e5; color:#fff; }
        .bb { background:#f1f5f9; color:#475569; }
        @media print { .pbar { display:none; } body { padding:22px 30px; } }
    </style>
</head>
<body>

@if(!$exportMode)
<div class="pbar">
    <button class="bb" onclick="window.history.back()">&#8592; Back</button>
    <button class="bp" onclick="window.print()">&#128438; Print Certificate</button>
</div>
@endif

{{-- ── Letterhead ── --}}
<div class="letterhead">
    <div class="lh-left">
        <h1>&#128640; Travel Management</h1>
        <p>Vehicle Insurance Payment Certificate</p>
    </div>
    <div class="lh-right">
        <div class="doc-type">Insurance Receipt</div>
        <div class="doc-id">Record #{{ str_pad($insurance->id, 5, '0', STR_PAD_LEFT) }}</div>
        <div class="doc-date">Issued: {{ now()->format('d M Y') }}</div>
    </div>
</div>
<div class="divider"></div>

{{-- ── Header Card ── --}}
<div class="header-card">
    <div class="hc-left">
        <div class="label">Vehicle Registration</div>
        <div class="bus">{{ $insurance->bus_number }}</div>
        <div class="sub">&#128197; Payment Date: {{ $insurance->insurance_date->format('d M Y') }}</div>
    </div>
    <div class="hc-right">
        <div class="label">Premium Paid</div>
        <div class="amount">&#8377;{{ number_format($insurance->amount, 2) }}</div>
        <div class="sub">Insurance Record #{{ str_pad($insurance->id, 5, '0', STR_PAD_LEFT) }}</div>
    </div>
</div>

{{-- ── Payment Details ── --}}
<div class="section-title">&#128203; Payment Details</div>
<div class="info-grid">
    <div class="info-row">
        <div class="lbl">Bus / Vehicle No.</div>
        <div class="val"><span class="bus-pill">{{ $insurance->bus_number }}</span></div>
    </div>
    <div class="info-row">
        <div class="lbl">Payment Date</div>
        <div class="val">{{ $insurance->insurance_date->format('d M Y') }}</div>
    </div>
    <div class="info-row">
        <div class="lbl">Day of Week</div>
        <div class="val">{{ $insurance->insurance_date->format('l') }}</div>
    </div>
    <div class="info-row">
        <div class="lbl">Financial Year</div>
        @php
            $fy = $insurance->insurance_date->month >= 4
                ? $insurance->insurance_date->year . '-' . ($insurance->insurance_date->year + 1)
                : ($insurance->insurance_date->year - 1) . '-' . $insurance->insurance_date->year;
        @endphp
        <div class="val">FY {{ $fy }}</div>
    </div>
    <div class="info-row">
        <div class="lbl">Record Created</div>
        <div class="val">{{ $insurance->created_at->format('d M Y') }}</div>
    </div>
    <div class="info-row">
        <div class="lbl">Premium Amount</div>
        <div class="val amount">&#8377;{{ number_format($insurance->amount, 2) }}</div>
    </div>
</div>

{{-- ── Notes / Policy Info ── --}}
@if($insurance->notes)
<div class="notes-box">
    <div class="section-title" style="border-color:#fde68a; color:#92400e; margin-bottom:8px;">&#128221; Policy Notes</div>
    <p>{{ $insurance->notes }}</p>
</div>
@else
<div class="info-box">
    <div class="section-title" style="margin-bottom:8px;">&#128221; Policy Notes</div>
    <p>No additional notes recorded for this insurance payment. You may add policy number, insurer name, or coverage details when editing this record.</p>
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
    <span>Insurance Record #{{ str_pad($insurance->id, 5, '0', STR_PAD_LEFT) }}</span>
    <span>{{ now()->format('d M Y, h:i A') }}</span>
</div>

</body>
</html>