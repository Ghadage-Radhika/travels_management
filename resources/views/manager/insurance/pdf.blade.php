<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insurance Records Report</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; font-size:12px; color:#1a1a2e; background:#fff; padding:36px 40px; }

        /* ── Header ── */
        .page-header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:3px solid #4f46e5; padding-bottom:18px; margin-bottom:22px; }
        .company h1  { font-size:22px; font-weight:800; color:#3730a3; letter-spacing:-0.5px; }
        .company p   { font-size:11px; color:#64748b; margin-top:3px; }
        .report-info { text-align:right; }
        .report-info .title  { font-size:16px; font-weight:700; color:#4f46e5; }
        .report-info .sub    { font-size:10.5px; color:#64748b; margin-top:4px; }
        .report-info .stamp  { display:inline-block; margin-top:6px; background:#eef2ff; border:1px solid #c7d2fe; color:#3730a3; padding:3px 10px; border-radius:5px; font-size:10px; font-weight:600; }

        /* ── Summary cards ── */
        .summary { display:flex; gap:10px; margin-bottom:20px; }
        .s-card  { flex:1; border-radius:8px; padding:11px 14px; border:1px solid #e2e8f0; }
        .s-card label { font-size:9.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; color:#64748b; display:block; margin-bottom:4px; }
        .s-card .val  { font-size:17px; font-weight:800; }
        .s-ind { background:#eef2ff; border-color:#c7d2fe; } .s-ind .val { color:#3730a3; }
        .s-red { background:#fef2f2; border-color:#fecaca; } .s-red .val { color:#dc2626; }

        /* ── Table ── */
        table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        thead tr { background:#4f46e5; }
        thead th { color:#fff; padding:9px 10px; text-align:left; font-size:10.5px; font-weight:700; letter-spacing:0.4px; text-transform:uppercase; }
        thead th.r { text-align:right; }
        tbody tr:nth-child(even) td { background:#f5f3ff; }
        tbody td { padding:8px 10px; border-bottom:1px solid #ede9fe; font-size:11.5px; vertical-align:middle; }
        .nc  { text-align:center; color:#94a3b8; font-weight:600; width:34px; }
        .ac  { text-align:right; font-weight:700; color:#dc2626; }
        .bus { display:inline-block; background:rgba(79,70,229,.12); color:#3730a3; padding:2px 8px; border-radius:5px; font-weight:700; font-size:10.5px; }
        .nn  { color:#94a3b8; }
        .total-row td { background:#3730a3 !important; color:#fff; font-weight:800; padding:10px; font-size:12px; border:none; }

        /* ── Footer ── */
        .pg-foot { border-top:2px solid #e2e8f0; padding-top:12px; display:flex; justify-content:space-between; font-size:10px; color:#94a3b8; }

        /* ── Print bar ── */
        .pbar { margin-bottom:20px; display:flex; gap:8px; justify-content:flex-end; }
        .pbar button { padding:8px 18px; border-radius:6px; font-size:13px; font-weight:600; cursor:pointer; border:none; display:inline-flex; align-items:center; gap:6px; }
        .bp { background:#4f46e5; color:#fff; }
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
        <p>Insurance Records Report &nbsp;&bull;&nbsp; All Vehicles</p>
    </div>
    <div class="report-info">
        <div class="title">&#128737; Insurance Report</div>
        <div class="sub">Complete vehicle insurance payment history</div>
        <div class="stamp">Generated: {{ now()->format('d M Y, h:i A') }}</div>
    </div>
</div>

@php
    $total   = $records->sum('amount');
    $thisYear = $records->filter(fn($r) => $r->insurance_date->year === now()->year)->sum('amount');
@endphp

<div class="summary">
    <div class="s-card s-ind"><label>Total Records</label><div class="val">{{ $records->count() }}</div></div>
    <div class="s-card s-red"><label>Total Paid</label><div class="val">&#8377;{{ number_format($total, 2) }}</div></div>
    <div class="s-card s-ind"><label>This Year ({{ now()->year }})</label><div class="val">&#8377;{{ number_format($thisYear, 2) }}</div></div>
    <div class="s-card s-ind"><label>Avg. Per Record</label><div class="val">&#8377;{{ $records->count() ? number_format($total / $records->count(), 2) : '0.00' }}</div></div>
</div>

<table>
    <thead>
        <tr>
            <th class="nc">#</th>
            <th>Date</th>
            <th>Bus No.</th>
            <th>Notes</th>
            <th class="r">Amount (&#8377;)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $i => $ins)
        <tr>
            <td class="nc">{{ $i + 1 }}</td>
            <td>{{ $ins->insurance_date->format('d M Y') }}</td>
            <td><span class="bus">{{ $ins->bus_number }}</span></td>
            <td style="color:#64748b; font-size:11px; max-width:260px;">{{ $ins->notes ?? '—' }}</td>
            <td class="ac">&#8377;{{ number_format($ins->amount, 2) }}</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center; padding:28px; color:#94a3b8;">No insurance records found.</td></tr>
        @endforelse

        @if($records->count() > 0)
        <tr class="total-row">
            <td colspan="4" style="text-align:right; letter-spacing:0.5px;">TOTAL AMOUNT PAID</td>
            <td style="text-align:right; font-weight:800;">&#8377;{{ number_format($total, 2) }}</td>
        </tr>
        @endif
    </tbody>
</table>

<div class="pg-foot">
    <span>Travel Management System &nbsp;|&nbsp; Insurance Records</span>
    <span>{{ now()->format('d M Y') }}</span>
    <span>Total: {{ $records->count() }} record(s)</span>
</div>

</body>
</html>