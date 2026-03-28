<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Maintenance Report — Venkatesh Tours & Travels</title>
    <style>
        /* ── RESET & BASE ─────────────────────────────── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1a202c;
            background: #f0f4f8;
            padding: 28px 20px 40px;
        }

        /* ── PRINT BUTTON (hidden when printing) ──────── */
        .no-print {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 22px;
        }
        .btn-print {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 22px;
            background: #0f1b2d;
            color: #fff;
            border: none; border-radius: 7px;
            font-size: 13px; font-weight: 600;
            cursor: pointer;
            letter-spacing: .3px;
            transition: background .2s;
        }
        .btn-print:hover { background: #1e3a5f; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px;
            background: transparent;
            color: #4a5568;
            border: 1.5px solid #d1d5db;
            border-radius: 7px;
            font-size: 13px; font-weight: 500;
            cursor: pointer; text-decoration: none;
            transition: background .2s;
        }
        .btn-back:hover { background: #e2e8f0; }

        /* ── DOCUMENT WRAPPER ─────────────────────────── */
        .document {
            max-width: 960px;
            margin: 0 auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 32px rgba(0,0,0,.10);
            overflow: hidden;
        }

        /* ── HEADER BANNER ────────────────────────────── */
        .doc-header {
            background: linear-gradient(135deg, #0f1b2d 0%, #1e3a5f 55%, #1a56a0 100%);
            padding: 32px 40px 28px;
            position: relative;
            overflow: hidden;
        }
        .doc-header::before {
            content: '';
            position: absolute; top: -40px; right: -40px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }
        .doc-header::after {
            content: '';
            position: absolute; bottom: -60px; right: 80px;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(201,168,76,.08);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }
        .company-block {}
        .company-name {
            font-size: 22px; font-weight: 800;
            color: #fff;
            letter-spacing: -.3px;
            line-height: 1.2;
        }
        .company-sub {
            font-size: 11px; color: rgba(255,255,255,.55);
            font-weight: 500; letter-spacing: 1.8px;
            text-transform: uppercase; margin-top: 4px;
        }

        .report-badge {
            text-align: right;
        }
        .report-badge .badge-label {
            display: inline-block;
            background: rgba(201,168,76,.2);
            border: 1px solid rgba(201,168,76,.4);
            color: #e8c96a;
            font-size: 10px; font-weight: 700;
            letter-spacing: 2px; text-transform: uppercase;
            padding: 4px 12px; border-radius: 20px;
            margin-bottom: 6px;
        }
        .report-badge .report-num {
            display: block;
            font-size: 13px; color: rgba(255,255,255,.6);
            font-weight: 500;
        }

        .header-divider {
            height: 1px;
            background: rgba(255,255,255,.12);
            margin-bottom: 20px;
        }

        .header-meta {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
        }
        .meta-item {
            padding: 0 20px 0 0;
            border-right: 1px solid rgba(255,255,255,.1);
        }
        .meta-item:first-child { padding-left: 0; }
        .meta-item:last-child  { border-right: none; padding-right: 0; }
        .meta-label {
            font-size: 9.5px; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: rgba(255,255,255,.45); margin-bottom: 5px;
        }
        .meta-value {
            font-size: 15px; font-weight: 700;
            color: #fff; line-height: 1.2;
        }
        .meta-value.highlight { color: #e8c96a; }

        /* ── REPORT TITLE STRIP ───────────────────────── */
        .title-strip {
            background: #f7fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 14px 40px;
            display: flex; align-items: center; gap: 10px;
        }
        .title-strip .icon-wrap {
            width: 34px; height: 34px;
            background: rgba(30,58,95,.1);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }
        .title-strip h1 {
            font-size: 16px; font-weight: 800;
            color: #0f1b2d; letter-spacing: -.2px;
        }
        .title-strip p {
            font-size: 11.5px; color: #718096; margin-top: 1px;
        }

        /* ── TABLE SECTION ────────────────────────────── */
        .table-section { padding: 0 0 0; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: #1e3a5f;
        }
        thead th {
            padding: 11px 14px;
            font-size: 10px; font-weight: 700;
            letter-spacing: 1px; text-transform: uppercase;
            color: rgba(255,255,255,.85);
            text-align: left;
            white-space: nowrap;
        }
        thead th:last-child { text-align: right; }

        tbody tr { transition: background .15s; }
        tbody tr:nth-child(odd)  td { background: #fff; }
        tbody tr:nth-child(even) td { background: #f7fafc; }

        tbody td {
            padding: 11px 14px;
            font-size: 12px; color: #2d3748;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
        }

        .cell-num {
            font-size: 11px; font-weight: 700;
            color: #a0aec0; text-align: center; width: 36px;
        }

        .cell-date {
            white-space: nowrap; font-size: 11.5px;
            color: #4a5568;
        }

        .bus-badge {
            display: inline-block;
            background: rgba(30,58,95,.08);
            color: #1e3a5f;
            font-size: 11px; font-weight: 700;
            padding: 3px 9px; border-radius: 5px;
            letter-spacing: .5px;
        }

        .type-badge {
            display: inline-block;
            background: rgba(245,158,11,.1);
            color: #92400e;
            font-size: 11px; font-weight: 600;
            padding: 3px 9px; border-radius: 5px;
        }

        .cell-vendor { color: #4a5568; font-size: 11.5px; }

        .cell-desc {
            color: #718096; font-size: 11px;
            max-width: 190px;
        }

        .cell-amount {
            text-align: right;
            font-weight: 700; color: #c53030;
            font-size: 12.5px; white-space: nowrap;
        }

        /* ── TOTAL ROW ────────────────────────────────── */
        .total-row td {
            background: #ebf4ff !important;
            border-top: 2px solid #1e3a5f;
            border-bottom: none;
            padding: 13px 14px;
            font-weight: 700;
        }
        .total-label {
            text-align: right;
            font-size: 12px; color: #2d3748;
            font-weight: 600; letter-spacing: .3px;
        }
        .total-value {
            text-align: right;
            font-size: 15px; color: #c53030;
            font-weight: 800;
        }

        /* ── EMPTY STATE ──────────────────────────────── */
        .empty-row td {
            text-align: center; padding: 48px;
            color: #a0aec0; font-size: 13px;
        }

        /* ── FOOTER ───────────────────────────────────── */
        .doc-footer {
            background: #f7fafc;
            border-top: 1px solid #e2e8f0;
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-left { font-size: 10.5px; color: #a0aec0; line-height: 1.6; }
        .footer-left strong { color: #718096; }
        .footer-right { font-size: 10px; color: #cbd5e0; text-align: right; }
        .footer-right span { display: block; margin-top: 2px; }

        .confidential-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(229,62,62,.08);
            border: 1px solid rgba(229,62,62,.2);
            color: #c53030;
            font-size: 9.5px; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase;
            padding: 3px 10px; border-radius: 20px;
        }

        /* ── PRINT STYLES ─────────────────────────────── */
        @media print {
            body {
                background: #fff;
                padding: 0;
                font-size: 11px;
            }
            .no-print { display: none !important; }
            .document {
                border-radius: 0;
                box-shadow: none;
                max-width: 100%;
            }
            .doc-header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            thead { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            tbody tr:nth-child(even) td { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .total-row td { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
        }
    </style>
</head>
<body>

@php
    $totalAmount = $records->sum('amount_paid');
    $totalCount  = $records->count();
    $reportId    = 'MNT-' . now()->format('Ymd') . '-' . str_pad(rand(1,999), 3, '0', STR_PAD_LEFT);
@endphp

{{-- ── PRINT / BACK BUTTONS (hidden when printing) ── --}}
@if(!$exportMode)
<div class="no-print">
    <a href="javascript:history.back()" class="btn-back">&#8592; Back</a>
    <button class="btn-print" onclick="window.print()">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/>
        </svg>
        Print / Save PDF
    </button>
</div>
@endif

<div class="document">

    {{-- ── HEADER BANNER ── --}}
    <div class="doc-header">
        <div class="header-top">
            <div class="company-block">
                <div class="company-name">Venkatesh Tours &amp; Travels</div>
                <div class="company-sub">Fleet Maintenance Division</div>
            </div>
            <div class="report-badge">
                <div class="badge-label">&#128295; Maintenance Report</div>
                <span class="report-num">Ref: {{ $reportId }}</span>
            </div>
        </div>

        <div class="header-divider"></div>

        <div class="header-meta">
            <div class="meta-item">
                <div class="meta-label">Generated On</div>
                <div class="meta-value">{{ now()->format('d M Y') }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Time</div>
                <div class="meta-value">{{ now()->format('h:i A') }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Total Records</div>
                <div class="meta-value">{{ $totalCount }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Total Expenditure</div>
                <div class="meta-value highlight">&#8377;{{ number_format($totalAmount, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- ── TITLE STRIP ── --}}
    <div class="title-strip">
        <div class="icon-wrap">&#128295;</div>
        <div>
            <h1>Bus Maintenance Records</h1>
            <p>Complete service &amp; repair log — all vehicles</p>
        </div>
    </div>

    {{-- ── TABLE ── --}}
    <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th style="text-align:center; width:36px;">#</th>
                    <th>Date</th>
                    <th>Bus No.</th>
                    <th>Type of Maintenance</th>
                    <th>Vendor / Garage</th>
                    <th>Description</th>
                    <th style="text-align:right;">Amount Paid (&#8377;)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $i => $rec)
                @php $displayType = ($rec->maintenance_type === 'Other' && !empty($rec->custom_type)) ? $rec->custom_type : $rec->maintenance_type; @endphp
                <tr>
                    <td class="cell-num">{{ $i + 1 }}</td>
                    <td class="cell-date">
                        {{ $rec->maintenance_date->format('d M Y') }}
                    </td>
                    <td>
                        <span class="bus-badge">{{ $rec->bus_number }}</span>
                    </td>
                    <td>
                        <span class="type-badge">{{ $displayType }}</span>
                    </td>
                    <td class="cell-vendor">{{ $rec->vendor_name ?? '—' }}</td>
                    <td class="cell-desc">{{ $rec->description ? \Str::limit($rec->description, 55) : '—' }}</td>
                    <td class="cell-amount">&#8377;{{ number_format($rec->amount_paid, 2) }}</td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="7">
                        <div style="font-size:32px; margin-bottom:10px; opacity:.25;">&#128295;</div>
                        No maintenance records found.
                    </td>
                </tr>
                @endforelse

                @if($totalCount > 0)
                <tr class="total-row">
                    <td colspan="6" class="total-label">
                        Grand Total — {{ $totalCount }} Record{{ $totalCount !== 1 ? 's' : '' }}
                    </td>
                    <td class="total-value">&#8377;{{ number_format($totalAmount, 2) }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- ── FOOTER ── --}}
    <div class="doc-footer">
        <div class="footer-left">
            <strong>Venkatesh Tours &amp; Travels</strong><br>
            This document is system-generated and requires no signature.<br>
            For queries contact the Fleet Manager.
        </div>
        <div class="footer-right">
            <span class="confidential-badge">&#128274; Confidential</span>
            <span style="margin-top:6px;">Printed: {{ now()->format('d M Y, h:i A') }}</span>
            <span>Report ID: {{ $reportId }}</span>
        </div>
    </div>

</div>{{-- /document --}}

</body>
</html>