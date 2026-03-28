<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tax Records Report</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; font-size:12px; color:#1a1a2e; background:#fff; padding:36px 40px; }

        /* ── Header ── */
        .page-header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:3px solid #0891b2; padding-bottom:18px; margin-bottom:22px; }
        .company h1  { font-size:22px; font-weight:800; color:#0e7490; letter-spacing:-0.5px; }
        .company p   { font-size:11px; color:#64748b; margin-top:3px; }
        .report-info { text-align:right; }
        .report-info .title  { font-size:16px; font-weight:700; color:#0891b2; }
        .report-info .sub    { font-size:10.5px; color:#64748b; margin-top:4px; }
        .report-info .stamp  { display:inline-block; margin-top:6px; background:#ecfeff; border:1px solid #a5f3fc; color:#0e7490; padding:3px 10px; border-radius:5px; font-size:10px; font-weight:600; }

        /* ── Summary cards ── */
        .summary { display:flex; gap:10px; margin-bottom:20px; }
        .s-card  { flex:1; border-radius:8px; padding:11px 14px; border:1px solid #e2e8f0; }
        .s-card label { font-size:9.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; color:#64748b; display:block; margin-bottom:4px; }
        .s-card .val  { font-size:17px; font-weight:800; }
        .s-teal  { background:#ecfeff; border-color:#a5f3fc; } .s-teal  .val { color:#0e7490; }
        .s-green { background:#f0fdf4; border-color:#bbf7d0; } .s-green .val { color:#16a34a; }
        .s-red   { background:#fef2f2; border-color:#fecaca; } .s-red   .val { color:#dc2626; }

        /* ── Table ── */
        table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        thead tr { background:#0891b2; }
        thead th { color:#fff; padding:9px 10px; text-align:left; font-size:10.5px; font-weight:700; letter-spacing:0.4px; text-transform:uppercase; }
        thead th.r { text-align:right; }
        tbody tr:nth-child(even) td { background:#f0fdff; }
        tbody td { padding:8px 10px; border-bottom:1px solid #e2f6fa; font-size:11.5px; vertical-align:middle; }
        .nc   { text-align:center; color:#94a3b8; font-weight:600; width:34px; }
        .ac   { text-align:right; font-weight:700; color:#dc2626; }
        .bus  { display:inline-block; background:rgba(8,145,178,.12); color:#0e7490; padding:2px 8px; border-radius:5px; font-weight:700; font-size:10.5px; }
        .ok   { color:#16a34a; font-weight:700; }
        .exp  { color:#dc2626; font-weight:700; }
        .rl   { color:#0891b2; text-decoration:none; font-weight:600; }
        .nn   { color:#94a3b8; }
        .total-row td { background:#0e7490 !important; color:#fff; font-weight:800; padding:10px; font-size:12px; border:none; }

        /* ── Footer ── */
        .pg-foot { border-top:2px solid #e2e8f0; padding-top:12px; display:flex; justify-content:space-between; font-size:10px; color:#94a3b8; }

        /* ── Print bar ── */
        .pbar { margin-bottom:20px; display:flex; gap:8px; justify-content:flex-end; }
        .pbar button { padding:8px 18px; border-radius:6px; font-size:13px; font-weight:600; cursor:pointer; border:none; display:inline-flex; align-items:center; gap:6px; }
        .bp { background:#0891b2; color:#fff; }
        .bb { background:#f1f5f9; color:#475569; }
        @media print { .pbar { display:none; } body { padding:20px; } }
    </style>
</head>
<body>

@if(!$exportMode)
<div class="pbar">
    <button class="bb" onclick="window.history.back()">&#8592; Back</button>
    <button class="bp" onclick="window.print()">&#128438; Print Report</button>
</div>
@endif

<div class="page-header">
    <div class="company">
        <h1>&#128640; Travel Management</h1>
        <p>Tax Records Report &nbsp;&bull;&nbsp; All Vehicles</p>
    </div>
    <div class="report-info">
        <div class="title">&#128196; Tax Records Report</div>
        <div class="sub">Complete road tax payment history</div>
        <div class="stamp">Generated: {{ now()->format('d M Y, h:i A') }}</div>
    </div>
</div>

@php
    $total        = $records->sum('amount');
    $activeCount  = $records->filter(fn($r) => !$r->tax_to->isPast())->count();
    $expiredCount = $records->filter(fn($r) => $r->tax_to->isPast())->count();
@endphp

<div class="summary">
    <div class="s-card s-teal"><label>Total Records</label><div class="val">{{ $records->count() }}</div></div>
    <div class="s-card s-teal"><label>Total Paid</label><div class="val">&#8377;{{ number_format($total, 2) }}</div></div>
    <div class="s-card s-green"><label>Active / Valid</label><div class="val">{{ $activeCount }}</div></div>
    <div class="s-card s-red"><label>Expired</label><div class="val">{{ $expiredCount }}</div></div>
</div>

<table>
    <thead>
        <tr>
            <th class="nc">#</th>
            <th>Payment Date</th>
            <th>Bus No.</th>
            <th>Valid From</th>
            <th>Valid To</th>
            <th>Status</th>
            <th>Receipt</th>
            <th>Notes</th>
            <th class="r">Amount (&#8377;)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $i => $tax)
        @php $expired = $tax->tax_to->isPast(); @endphp
        <tr>
            <td class="nc">{{ $i + 1 }}</td>
            <td>{{ $tax->tax_date->format('d M Y') }}</td>
            <td><span class="bus">{{ $tax->bus_number }}</span></td>
            <td>{{ $tax->tax_from->format('d M Y') }}</td>
            <td>{{ $tax->tax_to->format('d M Y') }}</td>
            <td>
                @if($expired)
                    <span class="exp">&#10007; Expired</span>
                @else
                    <span class="ok">&#10003; Active</span>
                @endif
            </td>
            <td>
                @if($tax->tax_image)
                    <a class="rl" href="{{ Storage::url($tax->tax_image) }}" target="_blank">View</a>
                @else
                    <span class="nn">&#8212;</span>
                @endif
            </td>
            <td style="color:#64748b; font-size:11px; max-width:150px;">{{ $tax->notes ?? '—' }}</td>
            <td class="ac">&#8377;{{ number_format($tax->amount, 2) }}</td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center; padding:28px; color:#94a3b8;">No tax records found.</td></tr>
        @endforelse

        @if($records->count() > 0)
        <tr class="total-row">
            <td colspan="8" style="text-align:right; letter-spacing:0.5px;">TOTAL AMOUNT PAID</td>
            <td style="text-align:right; font-weight:800;">&#8377;{{ number_format($total, 2) }}</td>
        </tr>
        @endif
    </tbody>
</table>

<div class="pg-foot">
    <span>Travel Management System &nbsp;|&nbsp; Tax Records</span>
    <span>{{ now()->format('d M Y') }}</span>
    <span>Total: {{ $records->count() }} record(s)</span>
</div>

</body>
</html>