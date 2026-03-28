{{-- resources/views/manager/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manager Dashboard — TravelEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --navy:        #0f1b2d;
            --navy-light:  #162235;
            --navy-mid:    #1e3052;
            --gold:        #c9a84c;
            --gold-light:  #e8c96a;
            --cream:       #f5f0e8;
            --white:       #ffffff;
            --bg:          #eef2f7;
            --text-muted:  #8a9ab5;
            --danger:      #e05555;
            --warning:     #f59e0b;
            --success:     #3db87a;
            --info:        #3b82f6;
            --sidebar-w:   270px;
            --topbar-h:    68px;
        }
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--navy);
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; top:0; left:0;
            width: var(--sidebar-w); height:100vh;
            background: var(--navy);
            display: flex; flex-direction: column;
            z-index: 200; overflow-y: auto;
        }
        .sidebar::-webkit-scrollbar { width:4px; }
        .sidebar::-webkit-scrollbar-thumb { background:rgba(201,168,76,.2); border-radius:4px; }

        .sidebar-logo {
            padding: 26px 22px 18px;
            border-bottom: 1px solid rgba(201,168,76,.18);
            display: flex; align-items: center; gap:12px;
            flex-shrink: 0;
        }
        .logo-icon {
            width:40px; height:40px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            font-size:18px; color:var(--navy); flex-shrink:0;
        }
        .logo-text { font-family:'Playfair Display',serif; font-size:17px; color:var(--white); }
        .logo-text em {
            display:block; font-style:normal;
            font-family:'DM Sans',sans-serif; font-size:9px;
            color:var(--gold); letter-spacing:2.5px; text-transform:uppercase; margin-top:2px;
        }

        .role-badge {
            margin: 14px 14px 0;
            background: linear-gradient(135deg,rgba(201,168,76,.12),rgba(201,168,76,.04));
            border: 1px solid rgba(201,168,76,.22);
            border-radius: 10px;
            padding: 10px 14px;
            display: flex; align-items: center; gap:10px;
        }
        .role-badge-icon {
            width:32px; height:32px;
            background: linear-gradient(135deg,var(--gold),var(--gold-light));
            border-radius:8px;
            display:flex; align-items:center; justify-content:center;
            font-size:13px; color:var(--navy); flex-shrink:0;
        }
        .role-badge-text { font-size:11px; color:var(--text-muted); line-height:1.5; }
        .role-badge-text strong { display:block; color:var(--gold-light); font-size:12px; }

        .sidebar-section-label {
            padding: 18px 22px 7px;
            font-size:9.5px; letter-spacing:2px;
            text-transform:uppercase; color:var(--text-muted); font-weight:700;
        }
        .sidebar-nav { padding:0 10px; flex:1; }
        .nav-item {
            display:flex; align-items:center; gap:12px;
            padding:11px 14px;
            border-radius:10px; cursor:pointer;
            transition:all .2s;
            margin-bottom:3px;
            color:#a0b0c8;
            font-size:13.5px; font-weight:500;
            text-decoration:none;
            position:relative;
        }
        .nav-item:hover { background:var(--navy-mid); color:var(--white); }
        .nav-item.active {
            background: linear-gradient(135deg,rgba(201,168,76,.15),rgba(201,168,76,.04));
            color:var(--gold-light);
            border:1px solid rgba(201,168,76,.2);
        }
        .nav-icon {
            width:30px; height:30px;
            display:flex; align-items:center; justify-content:center;
            border-radius:8px; font-size:13px;
            background:rgba(255,255,255,.05); flex-shrink:0;
        }
        .nav-item.active .nav-icon {
            background: linear-gradient(135deg,var(--gold),var(--gold-light));
            color:var(--navy);
        }
        .nav-badge {
            margin-left:auto;
            background:var(--danger); color:#fff;
            font-size:10px; font-weight:700;
            padding:2px 7px; border-radius:10px;
        }
        .nav-badge.info { background:var(--info); }
        .sidebar-bottom {
            padding:12px 10px 22px;
            border-top:1px solid rgba(255,255,255,.05);
            flex-shrink:0;
        }

        /* ── TOPBAR ── */
        .topbar {
            position:fixed; top:0;
            left:var(--sidebar-w); right:0;
            height:var(--topbar-h);
            background:var(--white);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 30px;
            box-shadow:0 1px 0 rgba(0,0,0,.07);
            z-index:100;
        }
        .topbar-left h1 {
            font-family:'Playfair Display',serif;
            font-size:19px; font-weight:600; color:var(--navy);
        }
        .topbar-left p { font-size:11.5px; color:var(--text-muted); margin-top:1px; }
        .topbar-right { display:flex; align-items:center; gap:16px; }

        .notif-btn {
            position:relative;
            width:38px; height:38px;
            background:var(--bg); border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; color:var(--text-muted);
            font-size:16px; border:none;
            transition:background .2s;
        }
        .notif-btn:hover { background:#e2e8f0; color:var(--navy); }
        .notif-dot {
            position:absolute; top:8px; right:9px;
            width:7px; height:7px;
            background:var(--danger); border-radius:50%;
            border:1.5px solid var(--white);
        }

        .user-badge {
            display:flex; align-items:center; gap:9px;
            background:var(--bg); padding:5px 14px 5px 7px;
            border-radius:30px;
        }
        .user-avatar {
            width:32px; height:32px;
            background: linear-gradient(135deg,var(--gold),var(--gold-light));
            border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            color:var(--navy); font-size:13px; font-weight:800;
        }
        .user-info { line-height:1.3; }
        .user-info .u-name { font-size:12.5px; font-weight:700; color:var(--navy); }
        .user-info .u-role {
            font-size:10px; color:var(--gold);
            font-weight:600; text-transform:uppercase; letter-spacing:1px;
        }
        .logout-btn {
            display:flex; align-items:center; gap:7px;
            background:var(--navy); color:var(--white);
            border:none; cursor:pointer;
            padding:9px 16px; border-radius:8px;
            font-family:'DM Sans',sans-serif;
            font-size:13px; font-weight:500;
            transition:background .2s; text-decoration:none;
        }
        .logout-btn:hover { background:var(--danger); }

        /* ── MAIN ── */
        .main { margin-left:var(--sidebar-w); padding-top:var(--topbar-h); }
        .main-content { padding:28px 30px; }

        /* ── STATS ── */
        .stats-grid {
            display:grid; grid-template-columns:repeat(5,1fr);
            gap:16px; margin-bottom:26px;
        }
        .stat-card {
            background:var(--white);
            border-radius:14px;
            padding:18px 20px;
            box-shadow:0 1px 3px rgba(0,0,0,.04);
            border:1px solid rgba(0,0,0,.05);
            display:flex; align-items:center; gap:13px;
            transition:transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(0,0,0,.07); }
        .stat-icon {
            width:46px; height:46px; border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:19px; flex-shrink:0;
        }
        .si-gold    { background:rgba(201,168,76,.12);  color:var(--gold); }
        .si-navy    { background:rgba(30,48,82,.1);     color:var(--navy-mid); }
        .si-green   { background:rgba(61,184,122,.1);   color:var(--success); }
        .si-red     { background:rgba(224,85,85,.1);    color:var(--danger); }
        .si-blue    { background:rgba(59,130,246,.1);   color:var(--info); }
        .si-orange  { background:rgba(245,158,11,.1);   color:var(--warning); }
        .stat-label { font-size:11px; color:var(--text-muted); margin-bottom:3px; }
        .stat-value { font-size:22px; font-weight:700; color:var(--navy); line-height:1; }
        .stat-delta { font-size:11px; color:var(--success); margin-top:3px; }

        /* ── TWO-COLUMN LAYOUT ── */
        .two-col { display:grid; grid-template-columns:1.6fr 1fr; gap:22px; margin-bottom:26px; }
        .three-col { display:grid; grid-template-columns:repeat(3,1fr); gap:22px; margin-bottom:26px; }

        /* ── PANEL ── */
        .panel {
            background:var(--white); border-radius:16px;
            box-shadow:0 1px 4px rgba(0,0,0,.05);
            border:1px solid rgba(0,0,0,.05);
            overflow:hidden;
        }
        .panel-header {
            padding:18px 24px;
            border-bottom:1px solid #f0f3f8;
            display:flex; align-items:center; justify-content:space-between;
        }
        .panel-header h2 {
            font-family:'Playfair Display',serif;
            font-size:16px; font-weight:600; color:var(--navy);
        }
        .panel-header p { font-size:11.5px; color:var(--text-muted); margin-top:2px; }
        .panel-body { padding:22px; }
        .panel-footer {
            padding:12px 22px;
            border-top:1px solid #f0f3f8;
            display:flex; justify-content:flex-end; gap:8px;
        }

        /* ── TABS ── */
        .tab-bar {
            display:flex; gap:4px;
            background:#f4f7fb; border-radius:10px;
            padding:4px;
        }
        .tab-btn {
            padding:7px 16px; border-radius:8px;
            font-family:'DM Sans',sans-serif;
            font-size:12.5px; font-weight:600;
            border:none; cursor:pointer;
            color:var(--text-muted); background:transparent;
            transition:all .2s;
        }
        .tab-btn.active { background:var(--white); color:var(--navy); box-shadow:0 1px 4px rgba(0,0,0,.08); }
        .tab-pane { display:none; }
        .tab-pane.active { display:block; }

        /* ── TABLE ── */
        .data-table { width:100%; border-collapse:collapse; }
        .data-table thead tr { background:#f6f8fb; }
        .data-table th {
            padding:10px 14px;
            font-size:10.5px; font-weight:700;
            letter-spacing:1px; text-transform:uppercase;
            color:var(--text-muted); text-align:left; white-space:nowrap;
        }
        .data-table td {
            padding:13px 14px;
            font-size:13px; color:#374151;
            border-top:1px solid #f0f4f8;
            vertical-align:middle;
        }
        .data-table tbody tr:hover { background:#fafcff; }
        .data-table tbody tr { animation: fadeRow .3s ease both; }

        @keyframes fadeRow { from{opacity:0;transform:translateY(4px)} to{opacity:1;transform:translateY(0)} }

        /* ── BADGES ── */
        .badge {
            display:inline-flex; align-items:center;
            padding:3px 10px; border-radius:20px;
            font-size:11px; font-weight:600; white-space:nowrap;
        }
        .b-bus      { background:rgba(30,48,82,.1);    color:var(--navy-mid); }
        .b-sleeper  { background:rgba(201,168,76,.15); color:#8a6a15; }
        .b-package  { background:rgba(61,184,122,.12); color:#1e7a4e; }
        .b-rental   { background:rgba(224,85,85,.1);   color:var(--danger); }
        .b-pending  { background:rgba(245,158,11,.12); color:#92400e; }
        .b-approved { background:rgba(61,184,122,.12); color:#166534; }
        .b-blue     { background:rgba(59,130,246,.1);  color:#1d4ed8; }

        /* ── STATUS TOGGLE BTNS ── */
        .action-btn {
            padding:5px 11px; border-radius:7px; border:none; cursor:pointer;
            font-family:'DM Sans',sans-serif; font-size:12px; font-weight:600;
            transition:all .15s;
        }
        .btn-resolve { background:rgba(61,184,122,.12); color:var(--success); }
        .btn-resolve:hover { background:var(--success); color:#fff; }
        .btn-view    { background:rgba(59,130,246,.1);  color:var(--info); }
        .btn-view:hover { background:var(--info); color:#fff; }
        .btn-delete  { background:rgba(224,85,85,.1);  color:var(--danger); }
        .btn-delete:hover { background:var(--danger); color:#fff; }
        .btn-primary {
            background:var(--navy); color:#fff;
            padding:9px 20px; border-radius:9px; border:none; cursor:pointer;
            font-family:'DM Sans',sans-serif; font-size:13px; font-weight:600;
            display:inline-flex; align-items:center; gap:7px;
            transition:transform .15s, box-shadow .15s;
        }
        .btn-primary:hover { transform:translateY(-1px); box-shadow:0 4px 14px rgba(15,27,45,.2); }
        .btn-outline {
            background:transparent; color:var(--navy);
            padding:8px 18px; border-radius:9px;
            border:1.5px solid #dde3ed; cursor:pointer;
            font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500;
            display:inline-flex; align-items:center; gap:7px;
            transition:background .15s;
        }
        .btn-outline:hover { background:#f4f7fb; }

        /* ── SEARCH BAR ── */
        .search-bar {
            position:relative; flex:1;
        }
        .search-bar input {
            width:100%; padding:9px 14px 9px 36px;
            border:1.5px solid #e5e9ef; border-radius:9px;
            font-family:'DM Sans',sans-serif; font-size:13px;
            background:#fafbfc; outline:none;
            transition:border-color .2s;
        }
        .search-bar input:focus { border-color:var(--gold); background:#fff; }
        .search-bar i {
            position:absolute; left:12px; top:50%; transform:translateY(-50%);
            color:var(--text-muted); font-size:13px; pointer-events:none;
        }
        .filter-row { display:flex; align-items:center; gap:10px; margin-bottom:16px; }

        /* ── RECENT ACTIVITY ── */
        .activity-list { display:flex; flex-direction:column; gap:0; }
        .activity-item {
            display:flex; align-items:flex-start; gap:12px;
            padding:12px 0;
            border-bottom:1px solid #f0f4f8;
        }
        .activity-item:last-child { border-bottom:none; padding-bottom:0; }
        .act-dot {
            width:32px; height:32px; border-radius:9px; flex-shrink:0;
            display:flex; align-items:center; justify-content:center; font-size:13px;
            margin-top:1px;
        }
        .activity-item .act-text { font-size:13px; color:#374151; line-height:1.5; }
        .activity-item .act-text strong { color:var(--navy); font-weight:600; }
        .activity-item .act-time { font-size:11px; color:var(--text-muted); margin-top:2px; }

        /* ── QUICK STATS MINI ── */
        .mini-stat {
            display:flex; align-items:center; justify-content:space-between;
            padding:12px 0;
            border-bottom:1px solid #f0f4f8;
        }
        .mini-stat:last-child { border-bottom:none; padding-bottom:0; }
        .mini-stat-label { font-size:13px; color:#374151; display:flex; align-items:center; gap:8px; }
        .mini-stat-label .dot { width:8px; height:8px; border-radius:50%; }
        .mini-stat-val { font-size:14px; font-weight:700; color:var(--navy); }

        /* ── PROGRESS BAR ── */
        .progress-wrap { margin-top:5px; }
        .progress-bar {
            height:5px; background:#eef2f7; border-radius:10px; overflow:hidden;
        }
        .progress-fill {
            height:100%; border-radius:10px;
            background:linear-gradient(90deg,var(--gold),var(--gold-light));
            transition:width 1s ease;
        }

        /* ── MODAL ── */
        .modal-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(15,27,45,.6); backdrop-filter:blur(3px);
            z-index:500; align-items:center; justify-content:center;
        }
        .modal-overlay.open { display:flex; }
        .modal {
            background:var(--white); border-radius:18px;
            width:90%; max-width:540px;
            box-shadow:0 24px 64px rgba(0,0,0,.18);
            animation:modalIn .3s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes modalIn { from{opacity:0;transform:scale(.92)} to{opacity:1;transform:scale(1)} }
        .modal-header {
            padding:22px 26px 18px;
            border-bottom:1px solid #f0f3f8;
            display:flex; align-items:center; justify-content:space-between;
        }
        .modal-header h3 {
            font-family:'Playfair Display',serif;
            font-size:18px; color:var(--navy);
        }
        .modal-close {
            width:32px; height:32px; border-radius:8px;
            background:#f4f7fb; border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            color:var(--text-muted); font-size:14px;
            transition:background .15s;
        }
        .modal-close:hover { background:#e2e8f0; color:var(--navy); }
        .modal-body { padding:22px 26px; }
        .modal-footer {
            padding:16px 26px;
            border-top:1px solid #f0f3f8;
            display:flex; justify-content:flex-end; gap:10px;
        }

        /* Enquiry detail rows in modal */
        .detail-row {
            display:flex; gap:12px;
            padding:10px 0;
            border-bottom:1px solid #f6f8fb;
            font-size:13.5px;
        }
        .detail-row:last-child { border-bottom:none; }
        .detail-label { width:140px; color:var(--text-muted); font-weight:600; flex-shrink:0; }
        .detail-value { color:var(--navy); }

        /* ── FORM ── */
        .form-group { display:flex; flex-direction:column; gap:5px; margin-bottom:14px; }
        .form-group label { font-size:11.5px; font-weight:700; color:var(--navy); letter-spacing:.5px; text-transform:uppercase; }
        .form-control {
            padding:10px 13px;
            border:1.5px solid #e5e9ef; border-radius:9px;
            font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--navy);
            background:#fafbfc; outline:none;
            transition:border-color .2s, box-shadow .2s;
        }
        .form-control:focus { border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,.12); background:#fff; }
        select.form-control { cursor:pointer; }

        /* ── TOAST ── */
        .toast {
            position:fixed; bottom:26px; right:26px;
            background:var(--navy); color:#fff;
            padding:13px 20px; border-radius:10px;
            font-size:13px; font-weight:500;
            display:flex; align-items:center; gap:10px;
            box-shadow:0 8px 24px rgba(0,0,0,.2);
            transform:translateY(80px); opacity:0;
            transition:all .35s cubic-bezier(.34,1.56,.64,1);
            z-index:999;
        }
        .toast.show { transform:translateY(0); opacity:1; }
        .toast i { color:var(--gold); font-size:15px; }

        /* ── EMPTY STATE ── */
        .empty-state { text-align:center; padding:44px; color:var(--text-muted); }
        .empty-state i { font-size:34px; margin-bottom:10px; opacity:.35; display:block; }
        .empty-state p { font-size:13.5px; }

        /* ── SECTION HEADING ── */
        .section-heading {
            font-family:'Playfair Display',serif;
            font-size:15px; color:var(--navy); font-weight:600;
            margin-bottom:14px;
            display:flex; align-items:center; gap:8px;
        }
        .section-heading::after {
            content:''; flex:1; height:1px; background:#eef2f7;
        }

        /* ── MODULE CARDS ── */
        .modules-grid {
            display:grid; grid-template-columns:repeat(5,1fr);
            gap:18px; margin-bottom:28px;
        }
        .module-card {
            background:var(--white);
            border-radius:16px;
            padding:22px 20px;
            box-shadow:0 1px 4px rgba(0,0,0,.05);
            border:1px solid rgba(0,0,0,.05);
            cursor:pointer;
            transition:transform .2s, box-shadow .2s, border-color .2s;
            text-decoration:none;
            display:flex; flex-direction:column; align-items:flex-start; gap:14px;
            position:relative; overflow:hidden;
        }
        .module-card::before {
            content:''; position:absolute; top:0; left:0; right:0; height:3px;
            background:var(--card-accent, var(--gold));
        }
        .module-card:hover {
            transform:translateY(-3px);
            box-shadow:0 10px 28px rgba(0,0,0,.1);
            border-color:rgba(0,0,0,.1);
        }
        .module-card-icon {
            width:48px; height:48px; border-radius:13px;
            display:flex; align-items:center; justify-content:center;
            font-size:20px; flex-shrink:0;
        }
        .module-card-body { width:100%; }
        .module-card-title {
            font-family:'Playfair Display',serif;
            font-size:14px; font-weight:600; color:var(--navy); margin-bottom:3px;
        }
        .module-card-desc { font-size:11.5px; color:var(--text-muted); line-height:1.5; }
        .module-card-footer {
            width:100%; display:flex; align-items:center; justify-content:space-between;
            margin-top:4px; padding-top:12px;
            border-top:1px solid #f0f3f8;
        }
        .module-card-count { font-size:22px; font-weight:800; color:var(--navy); font-family:'Playfair Display',serif; }
        .module-card-arrow {
            width:28px; height:28px; border-radius:8px;
            background:#f4f7fb; display:flex; align-items:center; justify-content:center;
            color:var(--text-muted); font-size:12px;
            transition:background .2s, color .2s;
        }
        .module-card:hover .module-card-arrow { background:var(--navy); color:#fff; }

        .module-placeholder {
            background:var(--white); border-radius:16px;
            border:2px dashed #dde3ed;
            padding:60px 30px; text-align:center;
            color:var(--text-muted);
        }
        .module-placeholder i { font-size:40px; opacity:.3; margin-bottom:14px; display:block; }
        .module-placeholder h3 {
            font-family:'Playfair Display',serif;
            font-size:18px; color:var(--navy); margin-bottom:8px;
        }
        .module-placeholder p { font-size:13px; max-width:360px; margin:0 auto; }
        .module-placeholder .coming-soon {
            display:inline-flex; align-items:center; gap:6px;
            margin-top:18px; padding:7px 16px;
            background:rgba(201,168,76,.1); color:var(--gold);
            border-radius:20px; font-size:12px; font-weight:600;
        }

        @media(max-width:1280px) { .modules-grid { grid-template-columns:repeat(3,1fr); } }
        @media(max-width:768px)  { .modules-grid { grid-template-columns:repeat(2,1fr); } }

        /* ── BUS BOOKING MODAL ── */
        .booking-modal-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(15,27,45,.65); backdrop-filter:blur(4px);
            z-index:600; align-items:center; justify-content:center;
            padding:20px;
        }
        .booking-modal-overlay.open { display:flex; }
        .booking-modal {
            background:var(--white); border-radius:20px;
            width:100%; max-width:620px;
            box-shadow:0 28px 70px rgba(0,0,0,.2);
            animation:modalIn .3s cubic-bezier(.34,1.56,.64,1);
            max-height:90vh; overflow-y:auto;
        }
        .booking-modal::-webkit-scrollbar { width:4px; }
        .booking-modal::-webkit-scrollbar-thumb { background:rgba(201,168,76,.3); border-radius:4px; }
        .booking-modal-header {
            padding:24px 28px 20px;
            background:linear-gradient(135deg, var(--navy), var(--navy-mid));
            border-radius:20px 20px 0 0;
            display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:1;
        }
        .booking-modal-header h3 {
            font-family:'Playfair Display',serif;
            font-size:19px; color:var(--white); font-weight:600;
        }
        .booking-modal-header p { font-size:12px; color:rgba(255,255,255,.55); margin-top:3px; }
        .booking-modal-close {
            width:34px; height:34px; border-radius:9px;
            background:rgba(255,255,255,.1); border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            color:rgba(255,255,255,.7); font-size:15px;
            transition:background .15s;
        }
        .booking-modal-close:hover { background:rgba(255,255,255,.2); color:#fff; }
        .booking-modal-body { padding:26px 28px; }
        .booking-modal-footer {
            padding:18px 28px 24px;
            display:flex; align-items:center; justify-content:flex-end; gap:10px;
            border-top:1px solid #f0f3f8;
        }

        /* Form layout */
        .bform-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .bform-group { display:flex; flex-direction:column; gap:6px; }
        .bform-group.full { grid-column:1 / -1; }
        .bform-label {
            font-size:11px; font-weight:700; color:var(--navy);
            letter-spacing:.6px; text-transform:uppercase;
            display:flex; align-items:center; gap:5px;
        }
        .bform-label .req { color:var(--danger); font-size:13px; line-height:1; }
        .bform-input {
            padding:11px 14px;
            border:1.5px solid #e2e8f0; border-radius:10px;
            font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--navy);
            background:#f8fafc; outline:none;
            transition:border-color .2s, box-shadow .2s, background .2s;
        }
        .bform-input:focus {
            border-color:var(--gold);
            box-shadow:0 0 0 3px rgba(201,168,76,.13);
            background:#fff;
        }
        .bform-input.error { border-color:var(--danger); box-shadow:0 0 0 3px rgba(224,85,85,.1); }
        .bform-error {
            font-size:11.5px; color:var(--danger);
            display:none; align-items:center; gap:4px; margin-top:1px;
        }
        .bform-error.show { display:flex; }

        .route-row {
            display:grid; grid-template-columns:1fr auto 1fr; gap:10px; align-items:end;
        }
        .route-arrow {
            width:34px; height:34px; border-radius:50%;
            background:linear-gradient(135deg,var(--gold),var(--gold-light));
            display:flex; align-items:center; justify-content:center;
            color:var(--navy); font-size:14px; font-weight:700;
            flex-shrink:0; margin-bottom:2px;
        }

        .amount-wrap { position:relative; }
        .amount-prefix {
            position:absolute; left:13px; top:50%; transform:translateY(-50%);
            font-size:13px; font-weight:700; color:var(--text-muted);
            pointer-events:none;
        }
        .amount-wrap .bform-input { padding-left:28px; }

        .form-divider {
            grid-column:1/-1;
            display:flex; align-items:center; gap:10px;
            margin:6px 0 2px;
        }
        .form-divider span {
            font-size:10px; font-weight:700; letter-spacing:1.5px;
            text-transform:uppercase; color:var(--text-muted); white-space:nowrap;
        }
        .form-divider::before, .form-divider::after {
            content:''; flex:1; height:1px; background:#eef2f7;
        }

        .booking-summary {
            background:linear-gradient(135deg,rgba(201,168,76,.08),rgba(201,168,76,.03));
            border:1px solid rgba(201,168,76,.2);
            border-radius:12px; padding:14px 18px;
            display:flex; align-items:center; justify-content:space-between;
            margin-top:6px;
        }
        .booking-summary-label { font-size:12px; color:var(--text-muted); }
        .booking-summary-value { font-size:18px; font-weight:800; color:var(--navy); font-family:'Playfair Display',serif; }
        .booking-summary-due   { font-size:18px; font-weight:800; font-family:'Playfair Display',serif; color:var(--danger); }

        /* ── SECTION VISIBILITY ── */
        .section-content { display:none; }
        #section-overview { display:block; }

        /* ── EDIT BUTTON ── */
        .btn-edit { background:rgba(201,168,76,.1); color:var(--gold); }
        .btn-edit:hover { background:var(--gold); color:var(--navy); }

        /* ── MAINTENANCE MODAL ── */
        .maint-modal-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(15,27,45,.65); backdrop-filter:blur(4px);
            z-index:600; align-items:flex-start; justify-content:center;
            padding:20px; overflow-y:auto;
        }
        .maint-modal-overlay.open { display:flex; }
        .maint-modal {
            background:var(--white); border-radius:20px;
            width:100%; max-width:580px;
            box-shadow:0 28px 70px rgba(0,0,0,.22);
            animation:modalIn .3s cubic-bezier(.34,1.56,.64,1);
            margin:auto;
        }
        .maint-modal-header {
            padding:22px 28px 18px;
            background:linear-gradient(135deg,#b45309,#d97706);
            border-radius:20px 20px 0 0;
            display:flex; align-items:center; justify-content:space-between;
        }
        .maint-modal-header h3 { font-family:'Playfair Display',serif; font-size:19px; color:#fff; font-weight:600; }
        .maint-modal-header p  { font-size:12px; color:rgba(255,255,255,.6); margin-top:3px; }
        .maint-modal-close {
            width:34px; height:34px; border-radius:9px;
            background:rgba(255,255,255,.15); border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            color:rgba(255,255,255,.8); font-size:15px; transition:background .15s;
        }
        .maint-modal-close:hover { background:rgba(255,255,255,.28); }
        .maint-modal-body   { padding:24px 28px; }
        .maint-modal-footer {
            padding:14px 28px; border-top:1px solid #f0f3f8;
            display:flex; justify-content:flex-end; gap:10px;
        }
        .mmod-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .mmod-full { grid-column:1/-1; }
        .mmod-group { display:flex; flex-direction:column; gap:5px; }
        .mmod-label {
            font-size:11px; font-weight:700; color:var(--navy);
            text-transform:uppercase; letter-spacing:.5px;
        }
        .mmod-label .req { color:var(--danger); }
        .mmod-input {
            padding:10px 13px; border:1.5px solid #e5e9ef; border-radius:9px;
            font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--navy);
            background:#fafbfc; outline:none; width:100%;
            transition:border-color .2s, box-shadow .2s;
        }
        .mmod-input:focus { border-color:var(--warning); box-shadow:0 0 0 3px rgba(245,158,11,.13); background:#fff; }
        .mmod-input.error { border-color:var(--danger); }
        .mmod-error { display:none; font-size:11px; color:var(--danger); margin-top:2px; }
        .mmod-error.show { display:block; }
        .mmod-prefix-wrap { position:relative; }
        .mmod-prefix { position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:13px; color:var(--text-muted); pointer-events:none; }
        .mmod-prefix-wrap .mmod-input { padding-left:26px; }

        /* ── RESPONSIVE ── */
        @media(max-width:1280px) { .stats-grid { grid-template-columns:repeat(3,1fr); } }
        @media(max-width:1100px) {
            .two-col   { grid-template-columns:1fr; }
            .three-col { grid-template-columns:1fr 1fr; }
        }
        @media(max-width:768px) {
            .sidebar { transform:translateX(-100%); }
            .main, .topbar { left:0; margin-left:0; }
            .stats-grid { grid-template-columns:repeat(2,1fr); }
            .three-col  { grid-template-columns:1fr; }
        }

        /* ── BILLING MODAL ── */
        .billing-modal-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(15,27,45,.65); backdrop-filter:blur(4px);
            z-index:600; align-items:flex-start; justify-content:center;
            padding:20px; overflow-y:auto;
        }
        .billing-modal-overlay.open { display:flex; }
        .billing-modal {
            background:var(--white); border-radius:20px;
            width:100%; max-width:700px;
            box-shadow:0 28px 70px rgba(0,0,0,.22);
            animation:modalIn .3s cubic-bezier(.34,1.56,.64,1);
            margin:auto;
        }
        .billing-modal-header {
            padding:22px 28px 18px;
            background:linear-gradient(135deg,#15803d,#166534);
            border-radius:20px 20px 0 0;
            display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:1;
        }
        .billing-modal-header h3 { font-family:'Playfair Display',serif; font-size:19px; color:var(--white); font-weight:600; }
        .billing-modal-header p  { font-size:12px; color:rgba(255,255,255,.55); margin-top:3px; }
        .billing-modal-close {
            width:34px; height:34px; border-radius:9px;
            background:rgba(255,255,255,.12); border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            color:rgba(255,255,255,.7); font-size:15px; transition:background .15s;
        }
        .billing-modal-close:hover { background:rgba(255,255,255,.25); }
        .billing-modal-body   { padding:22px 28px; }
        .billing-modal-footer {
            padding:14px 28px; border-top:1px solid #f0f3f8;
            display:flex; justify-content:flex-end; gap:10px;
            position:sticky; bottom:0; background:var(--white);
            border-radius:0 0 20px 20px;
        }
        .bmod-section-label {
            font-size:10px; font-weight:700; text-transform:uppercase;
            letter-spacing:1.5px; color:var(--text-muted);
            margin:18px 0 10px; display:flex; align-items:center; gap:8px;
        }
        .bmod-section-label::after { content:''; flex:1; height:1px; background:#eef2f7; }
        .bmod-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .bmod-grid.three { grid-template-columns:1fr 1fr 1fr; }
        .bmod-full { grid-column:1/-1; }
        .bmod-group { display:flex; flex-direction:column; gap:4px; }
        .bmod-label { font-size:11px; font-weight:700; color:var(--navy); text-transform:uppercase; letter-spacing:.4px; }
        .bmod-label .req { color:var(--danger); }
        .bmod-input {
            padding:9px 12px; border:1.5px solid #e5e9ef; border-radius:9px;
            font-family:'DM Sans',sans-serif; font-size:13px; color:var(--navy);
            background:#fafbfc; outline:none; transition:border-color .2s, box-shadow .2s;
            width:100%;
        }
        .bmod-input:focus { border-color:var(--success); box-shadow:0 0 0 3px rgba(61,184,122,.12); background:#fff; }
        .bmod-input.error  { border-color:var(--danger); }
        .bmod-prefix-wrap  { position:relative; }
        .bmod-prefix       { position:absolute; left:11px; top:50%; transform:translateY(-50%); font-size:13px; color:var(--text-muted); pointer-events:none; }
        .bmod-prefix-wrap .bmod-input { padding-left:24px; }
        .bmod-error { display:none; font-size:11px; color:var(--danger); margin-top:2px; }
        .bmod-error.show { display:block; }
        .billing-profit-summary {
            display:grid; grid-template-columns:repeat(3,1fr); gap:12px;
            background:#f6f8fb; border-radius:12px; padding:16px; margin-top:6px;
        }
        .bps-item { text-align:center; }
        .bps-label { font-size:10px; color:var(--text-muted); text-transform:uppercase; letter-spacing:.8px; margin-bottom:4px; }
        .bps-value { font-size:18px; font-weight:800; font-family:'Playfair Display',serif; }

        /* ══════════════════════════════
           INSURANCE MODULE MODALS
        ══════════════════════════════ */
        .ins-modal-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(15,27,45,.65); backdrop-filter:blur(4px);
            z-index:600; align-items:flex-start; justify-content:center;
            padding:20px; overflow-y:auto;
        }
        .ins-modal-overlay.open { display:flex; }
        .ins-modal {
            background:var(--white); border-radius:20px;
            width:100%; max-width:600px;
            box-shadow:0 28px 70px rgba(0,0,0,.22);
            animation:modalIn .3s cubic-bezier(.34,1.56,.64,1);
            margin:auto;
        }
        .ins-modal-header {
            padding:22px 28px 18px;
            border-radius:20px 20px 0 0;
            display:flex; align-items:center; justify-content:space-between;
        }
        /* Tax = teal, Insurance = indigo */
        .ins-modal-header.tax-hdr { background:linear-gradient(135deg,#0e7490,#0891b2); }
        .ins-modal-header.ins-hdr { background:linear-gradient(135deg,#3730a3,#4f46e5); }
        .ins-modal-header h3 { font-family:'Playfair Display',serif; font-size:19px; color:#fff; font-weight:600; }
        .ins-modal-header p  { font-size:12px; color:rgba(255,255,255,.6); margin-top:3px; }
        .ins-modal-close {
            width:34px; height:34px; border-radius:9px;
            background:rgba(255,255,255,.15); border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            color:rgba(255,255,255,.8); font-size:15px; transition:background .15s;
        }
        .ins-modal-close:hover { background:rgba(255,255,255,.28); }
        .ins-modal-body   { padding:24px 28px; }
        .ins-modal-footer {
            padding:14px 28px 20px; border-top:1px solid #f0f3f8;
            display:flex; justify-content:flex-end; gap:10px;
        }
        /* Form grid — mirrors mmod-* pattern */
        .imod-grid  { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .imod-full  { grid-column:1/-1; }
        .imod-group { display:flex; flex-direction:column; gap:5px; }
        .imod-label { font-size:11px; font-weight:700; color:var(--navy); text-transform:uppercase; letter-spacing:.5px; }
        .imod-label .req { color:var(--danger); }
        .imod-input {
            padding:10px 13px; border:1.5px solid #e5e9ef; border-radius:9px;
            font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--navy);
            background:#fafbfc; outline:none; width:100%;
            transition:border-color .2s, box-shadow .2s;
        }
        /* Teal focus for tax fields, indigo for insurance fields */
        .imod-input.tax-input:focus { border-color:#0891b2; box-shadow:0 0 0 3px rgba(8,145,178,.13); background:#fff; }
        .imod-input.ins-input:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.13); background:#fff; }
        .imod-input.error { border-color:var(--danger); }
        .imod-prefix-wrap { position:relative; }
        .imod-prefix { position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:13px; color:var(--text-muted); pointer-events:none; }
        .imod-prefix-wrap .imod-input { padding-left:26px; }
        .imod-hint { font-size:11px; color:var(--text-muted); margin-top:2px; display:flex; align-items:center; gap:4px; }
    </style>
</head>
<body>

{{-- ══════════════ SIDEBAR ══════════════ --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="fas fa-route"></i></div>
        <span class="logo-text">Venkatesh Tours & Travels<em>Manager Portal</em></span>
    </div>

    <div class="role-badge">
        <div class="role-badge-icon"><i class="fas fa-user-tie"></i></div>
        <div class="role-badge-text">
            <strong>{{ auth()->user()->name }}</strong>
            Manager Access
        </div>
    </div>

    <div class="sidebar-section-label">Overview</div>
    <nav class="sidebar-nav">
        <a href="#" class="nav-item active" data-section="overview" onclick="showSection('overview',this)">
            <div class="nav-icon"><i class="fas fa-gauge-high"></i></div>
            Dashboard
        </a>

        <div class="sidebar-section-label" style="padding-left:4px;">Enquiry Management</div>

        <a href="#" class="nav-item" data-section="all-enquiries" onclick="showSection('all-enquiries',this)">
            <div class="nav-icon"><i class="fas fa-file-lines"></i></div>
            All Enquiries
            <span class="nav-badge">{{ $totalEnquiries }}</span>
        </a>
        <a href="#" class="nav-item" data-section="pending" onclick="showSection('pending',this)">
            <div class="nav-icon"><i class="fas fa-clock"></i></div>
            Pending
            <span class="nav-badge">{{ $pendingCount }}</span>
        </a>
        <a href="#" class="nav-item" data-section="resolved" onclick="showSection('resolved',this)">
            <div class="nav-icon"><i class="fas fa-circle-check"></i></div>
            Approved
            <span class="nav-badge info">{{ $resolvedCount }}</span>
        </a>

        <div class="sidebar-section-label" style="padding-left:4px;">Modules</div>

        <a href="#" class="nav-item" data-section="mod-booking" onclick="showSection('mod-booking',this)">
            <div class="nav-icon"><i class="fas fa-calendar-check"></i></div>
            Booking Module
        </a>
        <a href="#" class="nav-item" data-section="mod-maintenance" onclick="showSection('mod-maintenance',this)">
            <div class="nav-icon"><i class="fas fa-screwdriver-wrench"></i></div>
            Maintenance Module
        </a>
        <a href="#" class="nav-item" data-section="mod-billing" onclick="showSection('mod-billing',this)">
            <div class="nav-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            Billing Module
        </a>
        <a href="#" class="nav-item" data-section="mod-insurance" onclick="showSection('mod-insurance',this)">
            <div class="nav-icon"><i class="fas fa-shield-halved"></i></div>
            Insurance Module
        </a>
        <a href="#" class="nav-item" data-section="mod-reports" onclick="showSection('mod-reports',this)">
            <div class="nav-icon"><i class="fas fa-chart-bar"></i></div>
            Reports
        </a>
    </nav>

    <div class="sidebar-bottom">
        <a href="#" class="nav-item" style="color:#a0b0c8; font-size:13px;">
            <div class="nav-icon"><i class="fas fa-circle-question"></i></div>
            Help & Support
        </a>
    </div>
</aside>

{{-- ══════════════ TOPBAR ══════════════ --}}
<header class="topbar">
    <div class="topbar-left">
        <h1 id="page-title">Manager Dashboard</h1>
        <p>{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
    </div>
    <div class="topbar-right">
        <button class="notif-btn" title="Notifications">
            <i class="fas fa-bell"></i>
            @if($pendingCount > 0)<span class="notif-dot"></span>@endif
        </button>
        <div class="user-badge">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div class="user-info">
                <div class="u-name">{{ auth()->user()->name }}</div>
                <div class="u-role">Manager</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin:0">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</header>

{{-- ══════════════ MAIN CONTENT ══════════════ --}}
<main class="main">
<div class="main-content">

{{-- ─────────────────────────────────────────
     SECTION: OVERVIEW / DASHBOARD HOME
────────────────────────────────────────── --}}
<div id="section-overview" class="section-content">

    {{-- Stats Row --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon si-gold"><i class="fas fa-file-lines"></i></div>
            <div>
                <div class="stat-label">Total Enquiries</div>
                <div class="stat-value">{{ $totalEnquiries }}</div>
                <div class="stat-delta"><i class="fas fa-arrow-trend-up"></i> All time</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-red"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="stat-label">Pending</div>
                <div class="stat-value">{{ $pendingCount }}</div>
                <div class="stat-delta" style="color:var(--warning);">Needs attention</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-green"><i class="fas fa-circle-check"></i></div>
            <div>
                <div class="stat-label">Approved</div>
                <div class="stat-value">{{ $resolvedCount }}</div>
                <div class="stat-delta">Completed</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-navy"><i class="fas fa-bus"></i></div>
            <div>
                <div class="stat-label">Bus Bookings</div>
                <div class="stat-value">{{ $bookingCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-blue"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ $totalUsers }}</div>
            </div>
        </div>
    </div>

    {{-- Module Cards --}}
    <p class="section-heading" style="font-family:'DM Sans',sans-serif; font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--text-muted); margin-bottom:14px;">
        <span>System Modules</span>
    </p>
    <div class="modules-grid" style="margin-bottom:28px;">

        <a href="#" class="module-card" style="--card-accent:#1e3052;" onclick="showSection('mod-booking', document.querySelector('[data-section=mod-booking]')); return false;">
            <div class="module-card-icon" style="background:rgba(30,48,82,.1); color:#1e3052;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="module-card-body">
                <div class="module-card-title">Booking Module</div>
                <div class="module-card-desc">Manage all bus & coach reservations</div>
            </div>
            <div class="module-card-footer">
                <span class="module-card-count">{{ $bookingCount }}</span>
                <span class="module-card-arrow"><i class="fas fa-arrow-right"></i></span>
            </div>
        </a>

        <a href="#" class="module-card" style="--card-accent:#f59e0b;" onclick="showSection('mod-maintenance', document.querySelector('[data-section=mod-maintenance]')); return false;">
            <div class="module-card-icon" style="background:rgba(245,158,11,.1); color:#f59e0b;">
                <i class="fas fa-screwdriver-wrench"></i>
            </div>
            <div class="module-card-body">
                <div class="module-card-title">Maintenance Module</div>
                <div class="module-card-desc">Fleet upkeep, service logs & costs</div>
            </div>
            <div class="module-card-footer">
                <span class="module-card-count" style="color:#f59e0b;">{{ $maintCount }}</span>
                <span class="module-card-arrow"><i class="fas fa-arrow-right"></i></span>
            </div>
        </a>

        <a href="#" class="module-card" style="--card-accent:#3db87a;" onclick="showSection('mod-billing', document.querySelector('[data-section=mod-billing]')); return false;">
            <div class="module-card-icon" style="background:rgba(61,184,122,.1); color:#3db87a;">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div class="module-card-body">
                <div class="module-card-title">Billing Module</div>
                <div class="module-card-desc">Invoices, payments & financial records</div>
            </div>
            <div class="module-card-footer">
                <span class="module-card-count" style="color:#3db87a;">{{ $billingCount }}</span>
                <span class="module-card-arrow"><i class="fas fa-arrow-right"></i></span>
            </div>
        </a>

        <a href="#" class="module-card" style="--card-accent:#3b82f6;" onclick="showSection('mod-insurance', document.querySelector('[data-section=mod-insurance]')); return false;">
            <div class="module-card-icon" style="background:rgba(59,130,246,.1); color:#3b82f6;">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div class="module-card-body">
                <div class="module-card-title">Insurance Module</div>
                <div class="module-card-desc">Policy tracking & coverage records</div>
            </div>
            <div class="module-card-footer">
                <span class="module-card-count" style="color:#3b82f6;">{{ $taxCount+$insuranceCount }}</span>
                <span class="module-card-arrow"><i class="fas fa-arrow-right"></i></span>
            </div>
        </a>

        <a href="#" class="module-card" style="--card-accent:#c9a84c;" onclick="showSection('mod-reports', document.querySelector('[data-section=mod-reports]')); return false;">
            <div class="module-card-icon" style="background:rgba(201,168,76,.12); color:#c9a84c;">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="module-card-body">
                <div class="module-card-title">Reports</div>
                <div class="module-card-desc">Analytics, exports & data insights</div>
            </div>
            <div class="module-card-footer">
                <span class="module-card-count" style="color:#c9a84c;">{{ $totalEnquiries }}</span>
                <span class="module-card-arrow"><i class="fas fa-arrow-right"></i></span>
            </div>
        </a>

    </div>

    {{-- Two-col: Recent Enquiries + Activity --}}
    <div class="two-col">

        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2>Recent Enquiries</h2>
                    <p>Latest 8 submissions across all users</p>
                </div>
                <button class="btn-outline" onclick="showSection('all-enquiries', document.querySelector('[data-section=all-enquiries]'))">
                    View All <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                </button>
            </div>
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Type</th>
                            <th>Date Req.</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentEnquiries as $enq)
                        <tr>
                            <td>
                                <div style="font-weight:600; font-size:13px;">{{ $enq->name }}</div>
                                <div style="font-size:11px; color:var(--text-muted);">{{ $enq->mobile }}</div>
                            </td>
                            <td>
                                @php
                                    $bc=['Bus Booking'=>'b-bus','Sleeper Coach Booking'=>'b-sleeper','Package Tours'=>'b-package','Bus Rental'=>'b-rental'];
                                    $cls=$bc[$enq->type_of_enquiry]??'b-bus';
                                @endphp
                                <span class="badge {{ $cls }}">{{ $enq->type_of_enquiry }}</span>
                            </td>
                            <td style="font-size:12px; color:var(--text-muted);">
                                {{ $enq->date_of_requirement ? \Carbon\Carbon::parse($enq->date_of_requirement)->format('d M Y') : '—' }}
                            </td>
                            <td>
                                <span class="badge {{ $enq->status=='approved' ? 'b-approved' : 'b-pending' }}">
                                    {{ ucfirst($enq->status ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                <button class="action-btn btn-view" onclick="openEnquiryModal({{ $enq->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" style="text-align:center; color:var(--text-muted); padding:24px;">No enquiries yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:20px;">

            <div class="panel">
                <div class="panel-header">
                    <div><h2>Enquiry Breakdown</h2><p>By service type</p></div>
                </div>
                <div class="panel-body">
                    @php
                        $breakdown = [
                            ['label'=>'Bus Booking',          'count'=>$busCount,     'color'=>'#1e3052', 'pct'=> $totalEnquiries ? round($busCount/$totalEnquiries*100) : 0 ],
                            ['label'=>'Sleeper Coach',         'count'=>$sleeperCount, 'color'=>'#c9a84c', 'pct'=> $totalEnquiries ? round($sleeperCount/$totalEnquiries*100) : 0 ],
                            ['label'=>'Package Tours',         'count'=>$packageCount, 'color'=>'#3db87a', 'pct'=> $totalEnquiries ? round($packageCount/$totalEnquiries*100) : 0 ],
                            ['label'=>'Bus Rental',            'count'=>$rentalCount,  'color'=>'#e05555', 'pct'=> $totalEnquiries ? round($rentalCount/$totalEnquiries*100) : 0 ],
                        ];
                        $dotColors=['#1e3052','#c9a84c','#3db87a','#e05555'];
                    @endphp
                    @foreach($breakdown as $i => $item)
                    <div class="mini-stat">
                        <div class="mini-stat-label">
                            <span class="dot" style="background:{{ $dotColors[$i] }}"></span>
                            {{ $item['label'] }}
                        </div>
                        <div class="mini-stat-val">{{ $item['count'] }}</div>
                    </div>
                    <div class="progress-wrap" style="margin-bottom:10px;">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width:{{ $item['pct'] }}%; background:linear-gradient(90deg,{{ $dotColors[$i] }},{{ $dotColors[$i] }}aa);"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div><h2>Recent Activity</h2><p>System events</p></div>
                </div>
                <div class="panel-body" style="padding-top:10px;">
                    <div class="activity-list">
                        @foreach($recentEnquiries->take(5) as $enq)
                        <div class="activity-item">
                            <div class="act-dot si-gold" style="background:rgba(201,168,76,.12);">
                                <i class="fas fa-file-pen" style="color:var(--gold); font-size:12px;"></i>
                            </div>
                            <div>
                                <div class="act-text">
                                    <strong>{{ $enq->name }}</strong> submitted a
                                    <strong>{{ $enq->type_of_enquiry }}</strong> enquiry
                                </div>
                                <div class="act-time">{{ $enq->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="three-col">
        <div class="panel">
            <div class="panel-header"><div><h2>Today's Enquiries</h2><p>Submitted today</p></div></div>
            <div class="panel-body" style="text-align:center; padding:28px;">
                <div style="font-size:42px; font-weight:800; color:var(--navy); font-family:'Playfair Display',serif;">{{ $todayCount }}</div>
                <div style="font-size:12px; color:var(--text-muted); margin-top:6px;">New enquiries received</div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-header"><div><h2>Approval Rate</h2><p>Percentage approved</p></div></div>
            <div class="panel-body" style="text-align:center; padding:28px;">
                <div style="font-size:42px; font-weight:800; color:var(--success); font-family:'Playfair Display',serif;">
                    {{ $totalEnquiries ? round($resolvedCount/$totalEnquiries*100) : 0 }}%
                </div>
                <div style="font-size:12px; color:var(--text-muted); margin-top:6px;">Of all enquiries approved</div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-header"><div><h2>Maintenance Cost</h2><p>Total spent on fleet</p></div></div>
            <div class="panel-body" style="text-align:center; padding:28px;">
                <div style="font-size:32px; font-weight:800; color:var(--warning); font-family:'Playfair Display',serif;">
                    ₹{{ number_format($totalMaintenanceCost, 0) }}
                </div>
                <div style="font-size:12px; color:var(--text-muted); margin-top:6px;">Across {{ $maintCount }} service records</div>
            </div>
        </div>
    </div>

</div>{{-- /section-overview --}}


{{-- ─────────────────────────────────────────
     SECTION: ALL ENQUIRIES
────────────────────────────────────────── --}}
<div id="section-all-enquiries" class="section-content" style="display:none;">
    <div class="panel">
        <div class="panel-header">
            <div><h2>All Enquiries</h2><p>Manage and respond to all user enquiries</p></div>
            <a href="{{ route('travels.export') }}" class="btn-outline">
                <i class="fas fa-file-export"></i> Export
            </a>
        </div>
        <div class="panel-body" style="padding-bottom:0;">
            <div class="filter-row">
                <div class="search-bar">
                    <i class="fas fa-magnifying-glass"></i>
                    <input type="text" id="searchAll" placeholder="Search by name, mobile, type…" oninput="filterTable('tblAll', this.value)">
                </div>
                <select class="form-control" style="width:180px;" onchange="filterByType('tblAll', this.value)">
                    <option value="">All Types</option>
                    <option>Bus Booking</option>
                    <option>Sleeper Coach Booking</option>
                    <option>Package Tours</option>
                    <option>Bus Rental</option>
                </select>
                <select class="form-control" style="width:150px;" onchange="filterByStatus('tblAll', this.value)">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                </select>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table" id="tblAll">
                <thead>
                    <tr>
                        <th>#</th><th>Name</th><th>Mobile</th><th>Address</th>
                        <th>Type</th><th>Date Req.</th><th>Submitted</th><th>Status</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allEnquiries as $i => $enq)
                    <tr data-type="{{ $enq->type_of_enquiry }}" data-status="{{ $enq->status ?? 'pending' }}">
                        <td style="color:var(--text-muted); font-weight:600;">{{ $i+1 }}</td>
                        <td>
                            <div style="font-weight:600;">{{ $enq->name }}</div>
                            <div style="font-size:11px; color:var(--text-muted);">{{ $enq->user->email ?? '—' }}</div>
                        </td>
                        <td>{{ $enq->mobile }}</td>
                        <td style="max-width:140px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $enq->address }}">{{ $enq->address }}</td>
                        <td><span class="badge {{ ['Bus Booking'=>'b-bus','Sleeper Coach Booking'=>'b-sleeper','Package Tours'=>'b-package','Bus Rental'=>'b-rental'][$enq->type_of_enquiry]??'b-bus' }}">{{ $enq->type_of_enquiry }}</span></td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $enq->date_of_requirement ? \Carbon\Carbon::parse($enq->date_of_requirement)->format('d M Y') : '—' }}</td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $enq->created_at->format('d M Y') }}</td>
                        <td><span class="badge {{ $enq->status=='approved'?'b-approved':'b-pending' }}">{{ ($enq->status=='approved' ? 'Approved' : ucfirst($enq->status??'pending')) }}</span></td>
                        <td>
                            <div style="display:flex; gap:5px; flex-wrap:nowrap;">
                                <button class="action-btn btn-view" onclick="openEnquiryModal({{ $enq->id }})" title="View"><i class="fas fa-eye"></i></button>
                                @if(($enq->status ?? 'pending') === 'pending')
                                <form action="{{ route('manager.enquiry.resolve', $enq->id) }}" method="POST" style="margin:0;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="action-btn btn-resolve" title="Approve"><i class="fas fa-check"></i></button>
                                </form>
                                @endif
                                <form action="{{ route('manager.enquiry.destroy', $enq->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Delete this enquiry?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9"><div class="empty-state"><i class="fas fa-inbox"></i><p>No enquiries found.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-footer">{{ $allEnquiries->links() }}</div>
    </div>
</div>

{{-- ─────────────────────────────────────────
     SECTION: PENDING
────────────────────────────────────────── --}}
<div id="section-pending" class="section-content" style="display:none;">
    <div class="panel">
        <div class="panel-header"><div><h2>Pending Enquiries</h2><p>{{ $pendingCount }} awaiting response</p></div></div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead><tr><th>#</th><th>Name</th><th>Mobile</th><th>Type</th><th>Date Req.</th><th>Submitted</th><th>Action</th></tr></thead>
                <tbody>
                    @forelse($allEnquiries->getCollection()->where('status','pending') as $i => $enq)
                    <tr>
                        <td style="color:var(--text-muted); font-weight:600;">{{ $i+1 }}</td>
                        <td><div style="font-weight:600;">{{ $enq->name }}</div></td>
                        <td>{{ $enq->mobile }}</td>
                        <td><span class="badge {{ ['Bus Booking'=>'b-bus','Sleeper Coach Booking'=>'b-sleeper','Package Tours'=>'b-package','Bus Rental'=>'b-rental'][$enq->type_of_enquiry]??'b-bus' }}">{{ $enq->type_of_enquiry }}</span></td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $enq->date_of_requirement ? \Carbon\Carbon::parse($enq->date_of_requirement)->format('d M Y') : '—' }}</td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $enq->created_at->format('d M Y') }}</td>
                        <td>
                            <div style="display:flex; gap:5px;">
                                <button class="action-btn btn-view" onclick="openEnquiryModal({{ $enq->id }})"><i class="fas fa-eye"></i></button>
                                <form action="{{ route('manager.enquiry.resolve', $enq->id) }}" method="POST" style="margin:0;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="action-btn btn-resolve"><i class="fas fa-check"></i> Approve</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="fas fa-circle-check"></i><p>All enquiries are approved!</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ─────────────────────────────────────────
     SECTION: RESOLVED
────────────────────────────────────────── --}}
<div id="section-resolved" class="section-content" style="display:none;">
    <div class="panel">
        <div class="panel-header"><div><h2>Approved Enquiries</h2><p>{{ $resolvedCount }} approved</p></div></div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead><tr><th>#</th><th>Name</th><th>Mobile</th><th>Type</th><th>Date Req.</th><th>Submitted</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($allEnquiries->getCollection()->where('status','approved') as $i => $enq)
                    <tr>
                        <td style="color:var(--text-muted); font-weight:600;">{{ $i+1 }}</td>
                        <td><div style="font-weight:600;">{{ $enq->name }}</div></td>
                        <td>{{ $enq->mobile }}</td>
                        <td><span class="badge {{ ['Bus Booking'=>'b-bus','Sleeper Coach Booking'=>'b-sleeper','Package Tours'=>'b-package','Bus Rental'=>'b-rental'][$enq->type_of_enquiry]??'b-bus' }}">{{ $enq->type_of_enquiry }}</span></td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $enq->date_of_requirement ? \Carbon\Carbon::parse($enq->date_of_requirement)->format('d M Y') : '—' }}</td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $enq->created_at->format('d M Y') }}</td>
                        <td><span class="badge b-approved">Approved</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="fas fa-inbox"></i><p>No approved enquiries yet.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SERVICE SECTIONS --}}
@foreach([
    ['bus-booking',  'Bus Booking',          'fa-bus',             'b-bus'],
    ['sleeper',      'Sleeper Coach Booking', 'fa-moon',            'b-sleeper'],
    ['package',      'Package Tours',         'fa-umbrella-beach',  'b-package'],
    ['rental',       'Bus Rental',            'fa-truck-ramp-box',  'b-rental'],
] as [$sid, $type, $icon, $badgeCls])
<div id="section-{{ $sid }}" class="section-content" style="display:none;">
    <div class="panel">
        <div class="panel-header">
            <div>
                <h2><i class="fas {{ $icon }}" style="color:var(--gold);margin-right:8px;"></i>{{ $type }}</h2>
                <p>All enquiries for this service</p>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead><tr><th>#</th><th>Name</th><th>Mobile</th><th>Address</th><th>Date Req.</th><th>Submitted</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                    @php $filtered = $allEnquiries->getCollection()->where('type_of_enquiry', $type); $idx=1; @endphp
                    @forelse($filtered as $enq)
                    <tr>
                        <td style="color:var(--text-muted); font-weight:600;">{{ $idx++ }}</td>
                        <td><div style="font-weight:600;">{{ $enq->name }}</div></td>
                        <td>{{ $enq->mobile }}</td>
                        <td style="max-width:130px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $enq->address }}</td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $enq->date_of_requirement ? \Carbon\Carbon::parse($enq->date_of_requirement)->format('d M Y') : '—' }}</td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $enq->created_at->format('d M Y') }}</td>
                        <td><span class="badge {{ $enq->status=='approved'?'b-approved':'b-pending' }}">{{ ($enq->status=='approved' ? 'Approved' : ucfirst($enq->status??'pending')) }}</span></td>
                        <td>
                            <div style="display:flex; gap:5px;">
                                <button class="action-btn btn-view" onclick="openEnquiryModal({{ $enq->id }})"><i class="fas fa-eye"></i></button>
                                @if(($enq->status??'pending')==='pending')
                                <form action="{{ route('manager.enquiry.resolve', $enq->id) }}" method="POST" style="margin:0;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="action-btn btn-resolve"><i class="fas fa-check"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8"><div class="empty-state"><i class="fas fa-inbox"></i><p>No {{ $type }} enquiries found.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endforeach

{{-- ══════════════════════════════════════════════
     MODULE: BOOKING
══════════════════════════════════════════════ --}}
<div id="section-mod-booking" class="section-content" style="display:none;">
    <div class="panel" style="margin-bottom:22px;">
        <div class="panel-header">
            <div>
                <h2><i class="fas fa-calendar-check" style="color:#1e3052;margin-right:8px;"></i>Booking Module</h2>
                <p>All Bus Booking & Sleeper Coach Booking enquiries</p>
            </div>
            <div style="display:flex; gap:8px; align-items:center;">
                <span class="badge b-bus">Bus: {{ $busCount }}</span>
                <span class="badge b-sleeper">Sleeper: {{ $sleeperCount }}</span>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead><tr><th>#</th><th>Name</th><th>Mobile</th><th>Address</th><th>Type</th><th>Date Req.</th><th>Submitted</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                    @php
                        $bookingEnquiries = $allEnquiries->getCollection()->whereIn('type_of_enquiry',['Bus Booking','Sleeper Coach Booking']);
                        $bidx = 1;
                    @endphp
                    @forelse($bookingEnquiries as $enq)
                    <tr>
                        <td style="color:var(--text-muted); font-weight:600;">{{ $bidx++ }}</td>
                        <td><div style="font-weight:600;">{{ $enq->name }}</div><div style="font-size:11px;color:var(--text-muted);">{{ $enq->mobile }}</div></td>
                        <td>{{ $enq->mobile }}</td>
                        <td style="max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $enq->address }}</td>
                        <td><span class="badge {{ $enq->type_of_enquiry=='Bus Booking'?'b-bus':'b-sleeper' }}">{{ $enq->type_of_enquiry }}</span></td>
                        <td style="font-size:12px;color:var(--text-muted);">{{ $enq->date_of_requirement ? \Carbon\Carbon::parse($enq->date_of_requirement)->format('d M Y') : '—' }}</td>
                        <td style="font-size:12px;color:var(--text-muted);">{{ $enq->created_at->format('d M Y') }}</td>
                        <td><span class="badge {{ $enq->status=='approved'?'b-approved':'b-pending' }}">{{ $enq->status=='approved'?'Approved':ucfirst($enq->status??'pending') }}</span></td>
                        <td>
                            <div style="display:flex;gap:5px;">
                                <button class="action-btn btn-view" onclick="openEnquiryModal({{ $enq->id }})"><i class="fas fa-eye"></i></button>
                                @if(($enq->status??'pending')!=='approved')
                                <form action="{{ route('manager.enquiry.resolve', $enq->id) }}" method="POST" style="margin:0;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="action-btn btn-resolve"><i class="fas fa-check"></i> Approve</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9"><div class="empty-state"><i class="fas fa-inbox"></i><p>No booking enquiries found.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bus Booking Records --}}
    <div class="panel">
        <div class="panel-header">
            <div>
                <h2><i class="fas fa-bus" style="color:var(--gold);margin-right:8px;"></i>Bus Booking Records</h2>
                <p>All confirmed bus bookings created by the manager</p>
            </div>
            <div style="display:flex; gap:8px; align-items:center;">
                <a href="{{ route('manager.booking.export.pdf') }}" target="_blank"
                   style="background:rgba(224,85,85,.1); color:var(--danger); padding:8px 16px; border-radius:9px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('manager.booking.print') }}" target="_blank"
                   style="background:rgba(59,130,246,.1); color:var(--info); padding:8px 16px; border-radius:9px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-print"></i> Print
                </a>
                <button class="btn-primary" onclick="openBookingModal()">
                    <i class="fas fa-plus"></i> New Booking
                </button>
            </div>
        </div>

        @if(session('booking_success'))
        <div style="margin:16px 22px 0; background:rgba(61,184,122,.1); border:1px solid rgba(61,184,122,.3); color:#166534; padding:12px 16px; border-radius:9px; font-size:13px; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-circle-check"></i> {{ session('booking_success') }}
        </div>
        @endif

        @if($errors->hasBag('booking'))
        <div style="margin:16px 22px 0; background:rgba(224,85,85,.08); border:1px solid rgba(224,85,85,.25); color:var(--danger); padding:12px 16px; border-radius:9px; font-size:13px;">
            <div style="font-weight:700; margin-bottom:4px;"><i class="fas fa-triangle-exclamation"></i> Please fix the following errors:</div>
            @foreach($errors->getBag('booking')->all() as $err)
            <div style="font-size:12px;">• {{ $err }}</div>
            @endforeach
        </div>
        @endif

        {{-- ── BOOKING: Search & Sort Bar (client-side, no page reload) ── --}}
        <div style="padding:16px 22px; border-bottom:1px solid #f0f4f8;">
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <div class="search-bar" style="flex:2; min-width:200px;">
                    <i class="fas fa-magnifying-glass"></i>
                    <input type="text" id="bkSearchInput"
                           placeholder="Search by route, bus no., note…"
                           autocomplete="off" oninput="bkApply()">
                </div>
                <select id="bkSortField" class="form-control" style="width:178px;" onchange="bkApply()">
                    <option value="date">Sort by Date</option>
                    <option value="bus">Sort by Bus No.</option>
                    <option value="route">Sort by Route</option>
                    <option value="km">Sort by KM</option>
                    <option value="amount">Sort by Booking Amt.</option>
                    <option value="advance">Sort by Advance</option>
                    <option value="balance">Sort by Balance</option>
                    <option value="pickup">Sort by Pickup Time</option>
                </select>
                <select id="bkSortDir" class="form-control" style="width:140px;" onchange="bkApply()">
                    <option value="desc">↓ Newest First</option>
                    <option value="asc">↑ Oldest First</option>
                </select>
                <button type="button" onclick="bkClear()"
                        style="padding:9px 14px; border-radius:9px; border:1.5px solid #dde3ed; background:#f8fafc; color:var(--text-muted); font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-xmark"></i> Clear
                </button>
            </div>
            <div id="bkResultInfo" style="margin-top:10px; font-size:12px; color:var(--text-muted); display:none; align-items:center; gap:6px;">
                <i class="fas fa-circle-info" style="color:var(--gold);"></i>
                <span id="bkResultText"></span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="data-table" id="tblBookings">
                <thead>
                    <tr>
                        <th style="width:36px;">#</th>
                        <th onclick="bkSortCol('date')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Booking Date <i id="bki-date" class="fas fa-sort-down" style="font-size:10px;color:var(--gold);"></i>
                        </th>
                        <th onclick="bkSortCol('route')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Route <i id="bki-route" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="bkSortCol('km')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            KM <i id="bki-km" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="bkSortCol('bus')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Bus No. <i id="bki-bus" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="bkSortCol('amount')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Booking Amt. <i id="bki-amount" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="bkSortCol('advance')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Advance <i id="bki-advance" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="bkSortCol('balance')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Balance <i id="bki-balance" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="bkSortCol('pickup')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Pickup <i id="bki-pickup" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="bkTbody">
                    @forelse($busBookings ?? [] as $i => $booking)
                    @php
                        $bkDate   = \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d');
                        $bkPickup = \Carbon\Carbon::parse($booking->pickup_time)->format('H:i');
                    @endphp
                    <tr class="bk-row"
                        data-date="{{ $bkDate }}"
                        data-bus="{{ strtolower($booking->bus_number) }}"
                        data-route="{{ strtolower($booking->route_from . ' ' . $booking->route_to) }}"
                        data-km="{{ $booking->kilometer }}"
                        data-amount="{{ $booking->booking_amount }}"
                        data-advance="{{ $booking->advance_amount }}"
                        data-balance="{{ $booking->remaining_amount }}"
                        data-pickup="{{ $bkPickup }}"
                        data-note="{{ strtolower($booking->note ?? '') }}">
                        <td class="bk-num" style="color:var(--text-muted); font-weight:600;">{{ $i + 1 }}</td>
                        <td style="font-size:13px; white-space:nowrap;">
                            <i class="fas fa-calendar-day" style="color:var(--gold); font-size:11px; margin-right:4px;"></i>
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:6px; font-size:13px;">
                                <span style="font-weight:600; color:var(--navy);">{{ $booking->route_from }}</span>
                                <i class="fas fa-arrow-right" style="color:var(--gold); font-size:10px;"></i>
                                <span style="font-weight:600; color:var(--navy);">{{ $booking->route_to }}</span>
                            </div>
                        </td>
                        <td><span style="background:rgba(201,168,76,.1); color:#8a6a15; padding:3px 10px; border-radius:6px; font-size:12px; font-weight:700;">{{ $booking->kilometer }} km</span></td>
                        <td><span style="background:rgba(30,48,82,.08); color:var(--navy-mid); padding:3px 10px; border-radius:6px; font-size:12px; font-weight:700;">{{ $booking->bus_number }}</span></td>
                        <td style="font-weight:700; color:var(--navy);">₹{{ number_format($booking->booking_amount, 2) }}</td>
                        <td style="font-weight:600; color:var(--success);">₹{{ number_format($booking->advance_amount, 2) }}</td>
                        <td style="font-weight:700; color:{{ $booking->remaining_amount > 0 ? 'var(--danger)' : 'var(--success)' }};">₹{{ number_format($booking->remaining_amount, 2) }}</td>
                        <td style="font-size:13px; white-space:nowrap;">
                            <i class="fas fa-clock" style="color:var(--gold); font-size:11px; margin-right:3px;"></i>
                            {{ \Carbon\Carbon::parse($booking->pickup_time)->format('h:i A') }}
                        </td>
                        <td style="font-size:12px; color:var(--text-muted); max-width:120px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $booking->note }}">{{ $booking->note ?? '—' }}</td>
                        <td>
                            <div style="display:flex; gap:5px;">
                                <button type="button" class="action-btn btn-edit" title="Edit"
                                    onclick="openEditBookingModal(
                                        {{ $booking->id }},
                                        '{{ $booking->booking_date instanceof \Carbon\Carbon ? $booking->booking_date->format('Y-m-d') : \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}',
                                        {{ json_encode($booking->route_from) }},
                                        {{ json_encode($booking->route_to) }},
                                        {{ $booking->kilometer }},
                                        {{ json_encode($booking->bus_number) }},
                                        '{{ \Carbon\Carbon::parse($booking->pickup_time)->format('H:i') }}',
                                        {{ $booking->booking_amount }},
                                        {{ $booking->advance_amount }},
                                        {{ json_encode($booking->note ?? '') }}
                                    )">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('manager.booking.destroy', $booking->id) }}" method="POST" style="margin:0;"
                                    onsubmit="return confirm('Delete booking #{{ $booking->id }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="11"><div class="empty-state"><i class="fas fa-bus"></i><p>No bookings yet. Click <strong>New Booking</strong> to create one.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
            <div id="bkNoResults" style="display:none; text-align:center; padding:44px; color:var(--text-muted);">
                <i class="fas fa-magnifying-glass" style="font-size:30px; margin-bottom:10px; opacity:.3; display:block;"></i>
                <p style="font-size:13.5px;">No bookings match your search. Try different keywords.</p>
            </div>
        </div>
        @if(!empty($busBookings) && $busBookings instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="panel-footer">{{ $busBookings->links() }}</div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════
     MODULE: MAINTENANCE  ← FULLY IMPLEMENTED
══════════════════════════════════════════════ --}}
<div id="section-mod-maintenance" class="section-content" style="display:none;">

    {{-- Success alert --}}
    @if(session('maintenance_success'))
    <div style="margin-bottom:16px; background:rgba(245,158,11,.1); border:1px solid rgba(245,158,11,.3); color:#92400e; padding:12px 18px; border-radius:10px; font-size:13px; display:flex; align-items:center; gap:8px;">
        <i class="fas fa-circle-check" style="color:var(--warning);"></i> {{ session('maintenance_success') }}
    </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2><i class="fas fa-screwdriver-wrench" style="color:var(--warning); margin-right:8px;"></i>Maintenance Module</h2>
                <p>Track all vehicle service, repairs and maintenance costs</p>
            </div>
            <div style="display:flex; gap:8px; align-items:center;">
                {{-- Total cost badge --}}
                <span style="background:rgba(245,158,11,.1); color:#92400e; padding:7px 14px; border-radius:9px; font-size:13px; font-weight:700;">
                    <i class="fas fa-indian-rupee-sign" style="font-size:11px;"></i> {{ number_format($totalMaintenanceCost, 2) }} total
                </span>
                <a href="{{ route('manager.maintenance.export.pdf') }}" target="_blank"
                   style="background:rgba(224,85,85,.1); color:var(--danger); padding:8px 16px; border-radius:9px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <button class="btn-primary" style="background:linear-gradient(135deg,#b45309,#d97706);" onclick="openMaintenanceModal()">
                    <i class="fas fa-plus"></i> Add Record
                </button>
            </div>
        </div>

        @if($errors->hasBag('maintenance') && $errors->getBag('maintenance')->any())
        <div style="margin:16px 22px 0; background:rgba(224,85,85,.08); border:1px solid rgba(224,85,85,.25); color:var(--danger); padding:12px 16px; border-radius:9px; font-size:13px;">
            <div style="font-weight:700; margin-bottom:4px;"><i class="fas fa-triangle-exclamation"></i> Please fix:</div>
            @foreach($errors->getBag('maintenance')->all() as $err)
            <div style="font-size:12px;">• {{ $err }}</div>
            @endforeach
        </div>
        @endif

        {{-- ── CLIENT-SIDE SEARCH & SORT BAR (no page reload) ── --}}
        <div style="padding:16px 22px; border-bottom:1px solid #f0f4f8;">
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">

                {{-- Live search --}}
                <div class="search-bar" style="flex:2; min-width:200px;">
                    <i class="fas fa-magnifying-glass"></i>
                    <input type="text" id="maintSearchInput"
                           placeholder="Search by bus no., type, vendor, description…"
                           autocomplete="off"
                           oninput="maintApplyFilters()">
                </div>

                {{-- Sort field --}}
                <select id="maintSortField" class="form-control" style="width:170px;" onchange="maintApplyFilters()">
                    <option value="date">Sort by Date</option>
                    <option value="bus">Sort by Bus No.</option>
                    <option value="type">Sort by Type</option>
                    <option value="amount">Sort by Amount</option>
                    <option value="vendor">Sort by Vendor</option>
                </select>

                {{-- Sort direction --}}
                <select id="maintSortDir" class="form-control" style="width:140px;" onchange="maintApplyFilters()">
                    <option value="desc">↓ Newest First</option>
                    <option value="asc">↑ Oldest First</option>
                </select>

                {{-- Clear --}}
                <button type="button" onclick="maintClearFilters()"
                        style="padding:9px 14px; border-radius:9px; border:1.5px solid #dde3ed; background:#f8fafc; color:var(--text-muted); font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-xmark"></i> Clear
                </button>
            </div>

            {{-- Result count --}}
            <div id="maintResultInfo" style="margin-top:10px; font-size:12px; color:var(--text-muted); display:none; align-items:center; gap:6px;">
                <i class="fas fa-circle-info" style="color:var(--warning);"></i>
                <span id="maintResultText"></span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="data-table" id="tblMaintenance">
                <thead>
                    <tr>
                        <th>#</th>
                        <th onclick="maintSortByCol('date')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Date <i id="msi-date" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th onclick="maintSortByCol('bus')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Bus No. <i id="msi-bus" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th onclick="maintSortByCol('type')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Type <i id="msi-type" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th onclick="maintSortByCol('vendor')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Vendor <i id="msi-vendor" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th>Description</th>
                        <th style="text-align:center;">Images</th>
                        <th onclick="maintSortByCol('amount')" style="cursor:pointer; user-select:none; white-space:nowrap; text-align:right;">
                            Amount <i id="msi-amount" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="maintTbody">
                    @forelse($maintenanceRecords as $i => $rec)
                    <tr class="maint-row"
                        data-date="{{ $rec->maintenance_date->format('Y-m-d') }}"
                        data-bus="{{ strtolower($rec->bus_number) }}"
                        data-type="{{ strtolower($rec->display_type) }}"
                        data-vendor="{{ strtolower($rec->vendor_name ?? '') }}"
                        data-desc="{{ strtolower($rec->description ?? '') }}"
                        data-amount="{{ $rec->amount_paid }}">
                        <td class="maint-row-num" style="color:var(--text-muted); font-weight:600;">{{ $i + 1 }}</td>
                        <td style="font-size:13px; white-space:nowrap;">
                            <i class="fas fa-calendar-day" style="color:var(--warning); font-size:11px; margin-right:4px;"></i>
                            {{ $rec->maintenance_date->format('d M Y') }}
                        </td>
                        <td>
                            <span style="background:rgba(30,48,82,.08); color:var(--navy-mid); padding:3px 10px; border-radius:6px; font-size:12px; font-weight:700;">
                                {{ $rec->bus_number }}
                            </span>
                        </td>
                        <td>
                            <span style="background:rgba(245,158,11,.1); color:#92400e; padding:3px 10px; border-radius:6px; font-size:12px; font-weight:600;">
                                {{ $rec->display_type }}
                            </span>
                        </td>
                        <td style="font-size:13px;">{{ $rec->vendor_name ?? '—' }}</td>
                        <td style="font-size:12px; color:var(--text-muted); max-width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $rec->description }}">
                            {{ $rec->description ?? '—' }}
                        </td>

                        {{-- Image thumbnails --}}
                        <td style="text-align:center; white-space:nowrap;">
                            @if($rec->tier_image)
                                <a href="{{ Storage::url($rec->tier_image) }}" target="_blank" title="View Tier Image"
                                   style="display:inline-flex; align-items:center; gap:3px; background:rgba(59,130,246,.08); color:var(--info); padding:3px 8px; border-radius:6px; font-size:11px; font-weight:600; text-decoration:none; margin-right:3px;">
                                    <i class="fas fa-tire"></i> Tier
                                </a>
                            @endif
                            @if($rec->bill_image)
                                <a href="{{ Storage::url($rec->bill_image) }}" target="_blank" title="View Bill Image"
                                   style="display:inline-flex; align-items:center; gap:3px; background:rgba(61,184,122,.08); color:var(--success); padding:3px 8px; border-radius:6px; font-size:11px; font-weight:600; text-decoration:none;">
                                    <i class="fas fa-file-invoice"></i> Bill
                                </a>
                            @endif
                            @if(!$rec->tier_image && !$rec->bill_image)
                                <span style="color:var(--text-muted); font-size:12px;">—</span>
                            @endif
                        </td>

                        <td style="font-weight:700; color:var(--danger); text-align:right;">
                            ₹{{ number_format($rec->amount_paid, 2) }}
                        </td>
                        <td>
                            <div style="display:flex; gap:5px;">
                                <button type="button" class="action-btn btn-edit" title="Edit"
                                    onclick="openEditMaintenanceModal(
                                        {{ $rec->id }},
                                        '{{ $rec->maintenance_date->format('Y-m-d') }}',
                                        {{ json_encode($rec->bus_number) }},
                                        {{ json_encode($rec->maintenance_type) }},
                                        {{ json_encode($rec->custom_type ?? '') }},
                                        {{ json_encode($rec->vendor_name ?? '') }},
                                        {{ json_encode($rec->description ?? '') }},
                                        {{ $rec->amount_paid }},
                                        {{ json_encode($rec->tier_image ? Storage::url($rec->tier_image) : '') }},
                                        {{ json_encode($rec->bill_image ? Storage::url($rec->bill_image) : '') }}
                                    )">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('manager.maintenance.destroy', $rec->id) }}" method="POST" style="margin:0;"
                                    onsubmit="return confirm('Delete maintenance record #{{ $rec->id }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="maintEmptyRow">
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="fas fa-screwdriver-wrench"></i>
                                <p>No maintenance records yet. Click <strong>Add Record</strong> to create one.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- No-results row (shown by JS when search yields nothing) --}}
            <div id="maintNoResults" style="display:none; text-align:center; padding:44px; color:var(--text-muted);">
                <i class="fas fa-magnifying-glass" style="font-size:30px; margin-bottom:10px; opacity:.3; display:block;"></i>
                <p style="font-size:13.5px;">No records match your search. Try different keywords.</p>
            </div>
        </div>

        @if($maintenanceRecords instanceof \Illuminate\Pagination\LengthAwarePaginator && $maintenanceRecords->hasPages())
        <div class="panel-footer">{{ $maintenanceRecords->links() }}</div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════
     MODULE: BILLING
══════════════════════════════════════════════ --}}
<div id="section-mod-billing" class="section-content" style="display:none;">

    @if(session('billing_success'))
    <div style="margin-bottom:16px; background:rgba(61,184,122,.1); border:1px solid rgba(61,184,122,.3); color:#166534; padding:12px 18px; border-radius:10px; font-size:13px; display:flex; align-items:center; gap:8px;">
        <i class="fas fa-circle-check"></i> {{ session('billing_success') }}
    </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2><i class="fas fa-file-invoice-dollar" style="color:#15803d; margin-right:8px;"></i>Billing Module</h2>
                <p>Trip expense records, driver info & profit summary</p>
            </div>
            <button class="btn-primary" style="background:linear-gradient(135deg,#15803d,#166534);" onclick="openBillingModal()">
                <i class="fas fa-plus"></i> New Billing Record
            </button>
        </div>

        @if($errors->hasBag('billing') && $errors->getBag('billing')->any())
        <div style="margin:16px 22px 0; background:rgba(224,85,85,.08); border:1px solid rgba(224,85,85,.25); color:var(--danger); padding:12px 16px; border-radius:9px; font-size:13px;">
            <div style="font-weight:700; margin-bottom:4px;"><i class="fas fa-triangle-exclamation"></i> Please fix:</div>
            @foreach($errors->getBag('billing')->all() as $err)
            <div style="font-size:12px;">• {{ $err }}</div>
            @endforeach
        </div>
        @endif

        {{-- ── BILLING: Search & Sort Bar (client-side, no page reload) ── --}}
        <div style="padding:16px 22px; border-bottom:1px solid #f0f4f8;">
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <div class="search-bar" style="flex:2; min-width:200px;">
                    <i class="fas fa-magnifying-glass"></i>
                    <input type="text" id="blSearchInput"
                           placeholder="Search by route, bus no., driver, ref…"
                           autocomplete="off" oninput="blApply()">
                </div>
                <select id="blSortField" class="form-control" style="width:185px;" onchange="blApply()">
                    <option value="date">Sort by Date</option>
                    <option value="ref">Sort by Booking Ref</option>
                    <option value="bus">Sort by Bus No.</option>
                    <option value="route">Sort by Route</option>
                    <option value="driver">Sort by Driver</option>
                    <option value="bookingamt">Sort by Booking Amt.</option>
                    <option value="expenses">Sort by Expenses</option>
                    <option value="profit">Sort by Net Profit</option>
                </select>
                <select id="blSortDir" class="form-control" style="width:140px;" onchange="blApply()">
                    <option value="desc">↓ Newest First</option>
                    <option value="asc">↑ Oldest First</option>
                </select>
                <button type="button" onclick="blClear()"
                        style="padding:9px 14px; border-radius:9px; border:1.5px solid #dde3ed; background:#f8fafc; color:var(--text-muted); font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-xmark"></i> Clear
                </button>
            </div>
            <div id="blResultInfo" style="margin-top:10px; font-size:12px; color:var(--text-muted); display:none; align-items:center; gap:6px;">
                <i class="fas fa-circle-info" style="color:#15803d;"></i>
                <span id="blResultText"></span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="data-table" id="tblBilling">
                <thead>
                    <tr>
                        <th style="width:36px;">#</th>
                        <th onclick="blSortCol('ref')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Booking Ref <i id="bli-ref" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="blSortCol('route')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Route <i id="bli-route" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="blSortCol('bus')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Bus No. <i id="bli-bus" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="blSortCol('date')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Date <i id="bli-date" class="fas fa-sort-down" style="font-size:10px;color:#15803d;"></i>
                        </th>
                        <th onclick="blSortCol('driver')" style="cursor:pointer;user-select:none;white-space:nowrap;">
                            Driver <i id="bli-driver" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="blSortCol('bookingamt')" style="cursor:pointer;user-select:none;white-space:nowrap;text-align:right;">
                            Booking Amt <i id="bli-bookingamt" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="blSortCol('expenses')" style="cursor:pointer;user-select:none;white-space:nowrap;text-align:right;">
                            Expenses <i id="bli-expenses" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th onclick="blSortCol('profit')" style="cursor:pointer;user-select:none;white-space:nowrap;text-align:right;">
                            Net Profit <i id="bli-profit" class="fas fa-sort" style="opacity:.3;font-size:10px;"></i>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="blTbody">
                    @forelse($billingRecords as $i => $bill)
                    @php
                        $blDate = $bill->booking ? \Carbon\Carbon::parse($bill->booking->booking_date)->format('Y-m-d') : '0000-00-00';
                    @endphp
                    <tr class="bl-row"
                        data-ref="{{ $bill->bus_booking_id }}"
                        data-date="{{ $blDate }}"
                        data-bus="{{ strtolower($bill->booking->bus_number ?? '') }}"
                        data-route="{{ strtolower(($bill->booking->route_from ?? '') . ' ' . ($bill->booking->route_to ?? '')) }}"
                        data-driver="{{ strtolower($bill->driver_name ?? '') }}"
                        data-bookingamt="{{ $bill->booking->booking_amount ?? 0 }}"
                        data-expenses="{{ $bill->total_expenses }}"
                        data-profit="{{ $bill->net_profit ?? 0 }}">
                        <td class="bl-num" style="color:var(--text-muted); font-weight:700;">{{ $i + 1 }}</td>
                        <td>
                            <span style="background:rgba(30,48,82,.08); color:var(--navy-mid); padding:3px 10px; border-radius:6px; font-size:12px; font-weight:700;">
                                #BK-{{ str_pad($bill->bus_booking_id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:5px; font-size:13px;">
                                <span style="font-weight:600; color:var(--navy);">{{ $bill->booking->route_from ?? '—' }}</span>
                                <i class="fas fa-arrow-right" style="color:var(--gold); font-size:10px;"></i>
                                <span style="font-weight:600; color:var(--navy);">{{ $bill->booking->route_to ?? '—' }}</span>
                            </div>
                        </td>
                        <td><span style="background:rgba(30,48,82,.08); color:var(--navy-mid); padding:3px 9px; border-radius:6px; font-size:12px; font-weight:700;">{{ $bill->booking->bus_number ?? '—' }}</span></td>
                        <td style="font-size:12px; color:var(--text-muted); white-space:nowrap;">
                            @if($bill->booking) {{ \Carbon\Carbon::parse($bill->booking->booking_date)->format('d M Y') }} @else — @endif
                        </td>
                        <td style="font-size:12.5px;">
                            @if($bill->driver_name)
                                <div style="font-weight:600;">{{ $bill->driver_name }}</div>
                                @if($bill->driver_mobile)<div style="font-size:11px; color:var(--text-muted);">{{ $bill->driver_mobile }}</div>@endif
                            @else
                                <span style="color:var(--text-muted); font-style:italic;">Not set</span>
                            @endif
                        </td>
                        <td style="font-weight:700; color:var(--navy); text-align:right;">₹{{ number_format($bill->booking->booking_amount ?? 0, 2) }}</td>
                        <td style="font-weight:700; color:var(--danger); text-align:right;">₹{{ number_format($bill->total_expenses, 2) }}</td>
                        <td style="font-weight:800; text-align:right; color:{{ ($bill->net_profit ?? 0) >= 0 ? 'var(--success)' : 'var(--danger)' }};">₹{{ number_format($bill->net_profit ?? 0, 2) }}</td>
                        <td>
                            <div style="display:flex; gap:5px; flex-wrap:nowrap;">
                                <a href="{{ route('manager.billing.pdf', $bill->id) }}" target="_blank"
                                   class="action-btn"
                                   style="background:rgba(224,85,85,.1); color:var(--danger); padding:5px 10px; border-radius:7px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px;"
                                   title="PDF"><i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('manager.billing.print', $bill->id) }}" target="_blank"
                                   class="action-btn"
                                   style="background:rgba(59,130,246,.1); color:var(--info); padding:5px 10px; border-radius:7px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px;"
                                   title="Print"><i class="fas fa-print"></i>
                                </a>
                                <button class="action-btn btn-edit" title="Edit"
                                    onclick="openEditBillingModal(
                                        {{ $bill->id }},
                                        {{ $bill->bus_booking_id }},
                                        '{{ $bill->rate_per_km ?? '' }}',
                                        '{{ $bill->diesel_amount ?? '' }}',
                                        '{{ $bill->toll_parking ?? '' }}',
                                        '{{ $bill->online_permit ?? '' }}',
                                        '{{ $bill->driver_amount ?? '' }}',
                                        '{{ $bill->other_expenses ?? '' }}',
                                        {{ json_encode($bill->driver_name ?? '') }},
                                        {{ json_encode($bill->driver_mobile ?? '') }},
                                        {{ json_encode($bill->description ?? '') }}
                                    )">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('manager.billing.destroy', $bill->id) }}" method="POST" style="margin:0;"
                                    onsubmit="return confirm('Delete billing record #{{ $bill->id }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10"><div class="empty-state"><i class="fas fa-file-invoice-dollar"></i><p>No billing records yet. Click <strong>New Billing Record</strong>.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
            <div id="blNoResults" style="display:none; text-align:center; padding:44px; color:var(--text-muted);">
                <i class="fas fa-magnifying-glass" style="font-size:30px; margin-bottom:10px; opacity:.3; display:block;"></i>
                <p style="font-size:13.5px;">No billing records match your search. Try different keywords.</p>
            </div>
        </div>
        @if($billingRecords instanceof \Illuminate\Pagination\LengthAwarePaginator && $billingRecords->hasPages())
        <div class="panel-footer">{{ $billingRecords->links() }}</div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════
     MODULE: INSURANCE — TAX & INSURANCE RECORDS
══════════════════════════════════════════════ --}}
<div id="section-mod-insurance" class="section-content" style="display:none;">

    {{-- Success alerts --}}
    @if(session('tax_success'))
    <div style="margin-bottom:14px; background:rgba(8,145,178,.1); border:1px solid rgba(8,145,178,.3); color:#0e7490; padding:12px 18px; border-radius:10px; font-size:13px; display:flex; align-items:center; gap:8px;">
        <i class="fas fa-circle-check"></i> {{ session('tax_success') }}
    </div>
    @endif
    @if(session('insurance_success'))
    <div style="margin-bottom:14px; background:rgba(79,70,229,.1); border:1px solid rgba(79,70,229,.3); color:#3730a3; padding:12px 18px; border-radius:10px; font-size:13px; display:flex; align-items:center; gap:8px;">
        <i class="fas fa-circle-check"></i> {{ session('insurance_success') }}
    </div>
    @endif

    {{-- ═══════════════════════════════════════
         PANEL 1 — TAX RECORDS
    ═══════════════════════════════════════ --}}
    <div class="panel" style="margin-bottom:22px;">
        <div class="panel-header">
            <div>
                <h2><i class="fas fa-receipt" style="color:#0891b2; margin-right:8px;"></i>Tax Records</h2>
                <p>Vehicle road tax payments and validity periods</p>
            </div>
            <div style="display:flex; gap:8px; align-items:center;">
                <span style="background:rgba(8,145,178,.1); color:#0e7490; padding:7px 14px; border-radius:9px; font-size:13px; font-weight:700;">
                    <i class="fas fa-indian-rupee-sign" style="font-size:11px;"></i> {{ number_format($totalTaxCost ?? 0, 2) }} total
                </span>
                <a href="{{ route('manager.tax.export.pdf') }}" target="_blank"
                   style="background:rgba(224,85,85,.1); color:var(--danger); padding:8px 16px; border-radius:9px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-file-pdf"></i> Export All PDF
                </a>
                <button class="btn-primary" style="background:linear-gradient(135deg,#0e7490,#0891b2);"
                        onclick="openTaxModal()">
                    <i class="fas fa-plus"></i> Add Tax Record
                </button>
            </div>
        </div>

        @if($errors->hasBag('tax') && $errors->getBag('tax')->any())
        <div style="margin:14px 22px 0; background:rgba(224,85,85,.08); border:1px solid rgba(224,85,85,.25); color:var(--danger); padding:12px 16px; border-radius:9px; font-size:13px;">
            <div style="font-weight:700; margin-bottom:4px;"><i class="fas fa-triangle-exclamation"></i> Please fix:</div>
            @foreach($errors->getBag('tax')->all() as $err)
            <div style="font-size:12px;">• {{ $err }}</div>
            @endforeach
        </div>
        @endif

        {{-- Tax search / sort bar --}}
        <div style="padding:16px 22px; border-bottom:1px solid #f0f4f8;">
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <div class="search-bar" style="flex:2; min-width:200px;">
                    <i class="fas fa-magnifying-glass"></i>
                    <input type="text" id="taxSearchInput"
                           placeholder="Search bus no., notes…"
                           autocomplete="off" oninput="taxApplyFilters()">
                </div>
                <select id="taxSortField" class="form-control" style="width:178px;" onchange="taxApplyFilters()">
                    <option value="taxdate">Sort by Date</option>
                    <option value="bus">Sort by Bus No.</option>
                    <option value="taxfrom">Sort by Valid From</option>
                    <option value="taxto">Sort by Valid To</option>
                    <option value="amount">Sort by Amount</option>
                </select>
                <select id="taxSortDir" class="form-control" style="width:140px;" onchange="taxApplyFilters()">
                    <option value="desc">↓ Newest First</option>
                    <option value="asc">↑ Oldest First</option>
                </select>
                <button type="button" onclick="taxClearFilters()"
                        style="padding:9px 14px; border-radius:9px; border:1.5px solid #dde3ed; background:#f8fafc; color:var(--text-muted); font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-xmark"></i> Clear
                </button>
            </div>
            <div id="taxResultInfo" style="margin-top:10px; font-size:12px; color:var(--text-muted); display:none; align-items:center; gap:6px;">
                <i class="fas fa-circle-info" style="color:#0891b2;"></i>
                <span id="taxResultText"></span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="data-table" id="tblTax">
                <thead>
                    <tr>
                        <th style="width:36px;">#</th>
                        <th onclick="taxSortByCol('taxdate')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Payment Date <i id="txi-taxdate" class="fas fa-sort-down" style="font-size:10px; color:#0891b2;"></i>
                        </th>
                        <th onclick="taxSortByCol('bus')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Bus No. <i id="txi-bus" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th onclick="taxSortByCol('taxfrom')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Valid From <i id="txi-taxfrom" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th onclick="taxSortByCol('taxto')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Valid To <i id="txi-taxto" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th style="text-align:center;">Receipt</th>
                        <th onclick="taxSortByCol('amount')" style="cursor:pointer; user-select:none; white-space:nowrap; text-align:right;">
                            Amount <i id="txi-amount" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="taxTbody">
                    @forelse($taxRecords ?? [] as $i => $tax)
                    @php $expired = $tax->tax_to->isPast(); @endphp
                    <tr class="tax-row"
                        data-taxdate="{{ $tax->tax_date->format('Y-m-d') }}"
                        data-bus="{{ strtolower($tax->bus_number) }}"
                        data-taxfrom="{{ $tax->tax_from->format('Y-m-d') }}"
                        data-taxto="{{ $tax->tax_to->format('Y-m-d') }}"
                        data-amount="{{ $tax->amount }}"
                        data-notes="{{ strtolower($tax->notes ?? '') }}">
                        <td class="tax-row-num" style="color:var(--text-muted); font-weight:600;">{{ $i + 1 }}</td>
                        <td style="font-size:13px; white-space:nowrap;">
                            <i class="fas fa-calendar-day" style="color:#0891b2; font-size:11px; margin-right:4px;"></i>
                            {{ $tax->tax_date->format('d M Y') }}
                        </td>
                        <td>
                            <span style="background:rgba(30,48,82,.08); color:var(--navy-mid); padding:3px 10px; border-radius:6px; font-size:12px; font-weight:700;">
                                {{ $tax->bus_number }}
                            </span>
                        </td>
                        <td style="font-size:12.5px; white-space:nowrap;">
                            <i class="fas fa-calendar-check" style="color:#0891b2; font-size:10px; margin-right:3px;"></i>
                            {{ $tax->tax_from->format('d M Y') }}
                        </td>
                        <td style="white-space:nowrap;">
                            <span style="font-size:12.5px; font-weight:600; color:{{ $expired ? 'var(--danger)' : 'var(--success)' }};">
                                <i class="fas fa-{{ $expired ? 'circle-xmark' : 'circle-check' }}" style="font-size:10px; margin-right:3px;"></i>
                                {{ $tax->tax_to->format('d M Y') }}
                            </span>
                            @if($expired)
                            <span style="display:block; font-size:10px; color:var(--danger); font-weight:700; letter-spacing:.5px; text-transform:uppercase;">Expired</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($tax->tax_image)
                                <a href="{{ Storage::url($tax->tax_image) }}" target="_blank"
                                   style="display:inline-flex; align-items:center; gap:4px; background:rgba(8,145,178,.09); color:#0891b2; padding:4px 10px; border-radius:7px; font-size:11.5px; font-weight:600; text-decoration:none;">
                                    <i class="fas fa-file-image"></i> View
                                </a>
                            @else
                                <span style="color:var(--text-muted); font-size:12px;">—</span>
                            @endif
                        </td>
                        <td style="font-weight:700; color:var(--danger); text-align:right;">
                            ₹{{ number_format($tax->amount, 2) }}
                        </td>
                        <td style="font-size:12px; color:var(--text-muted); max-width:140px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"
                            title="{{ $tax->notes }}">
                            {{ $tax->notes ?? '—' }}
                        </td>
                        <td>
                            <div style="display:flex; gap:5px;">
                                <a href="{{ route('manager.tax.pdf', $tax->id) }}" target="_blank"
                                   class="action-btn"
                                   style="background:rgba(224,85,85,.1); color:var(--danger); padding:5px 10px; border-radius:7px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px;"
                                   title="Export PDF"><i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('manager.tax.print', $tax->id) }}" target="_blank"
                                   class="action-btn"
                                   style="background:rgba(59,130,246,.1); color:var(--info); padding:5px 10px; border-radius:7px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px;"
                                   title="Print"><i class="fas fa-print"></i>
                                </a>
                                <button type="button" class="action-btn btn-edit" title="Edit"
                                    onclick="openEditTaxModal(
                                        {{ $tax->id }},
                                        '{{ $tax->tax_date->format('Y-m-d') }}',
                                        {{ json_encode($tax->bus_number) }},
                                        '{{ $tax->tax_from->format('Y-m-d') }}',
                                        '{{ $tax->tax_to->format('Y-m-d') }}',
                                        {{ $tax->amount }},
                                        {{ json_encode($tax->notes ?? '') }},
                                        '{{ $tax->tax_image ? Storage::url($tax->tax_image) : '' }}'
                                    )">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('manager.tax.destroy', $tax->id) }}" method="POST" style="margin:0;"
                                      onsubmit="return confirm('Delete tax record for {{ $tax->bus_number }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="fas fa-receipt"></i>
                                <p>No tax records yet. Click <strong>Add Tax Record</strong>.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div id="taxNoResults" style="display:none; text-align:center; padding:44px; color:var(--text-muted);">
                <i class="fas fa-magnifying-glass" style="font-size:30px; margin-bottom:10px; opacity:.3; display:block;"></i>
                <p style="font-size:13.5px;">No tax records match your search.</p>
            </div>
        </div>
    </div>{{-- /tax panel --}}

    {{-- ═══════════════════════════════════════
         PANEL 2 — INSURANCE RECORDS
    ═══════════════════════════════════════ --}}
    <div class="panel">
        <div class="panel-header">
            <div>
                <h2><i class="fas fa-shield-halved" style="color:#4f46e5; margin-right:8px;"></i>Insurance Records</h2>
                <p>Vehicle insurance policy payments</p>
            </div>
            <div style="display:flex; gap:8px; align-items:center;">
                <span style="background:rgba(79,70,229,.1); color:#3730a3; padding:7px 14px; border-radius:9px; font-size:13px; font-weight:700;">
                    <i class="fas fa-indian-rupee-sign" style="font-size:11px;"></i> {{ number_format($totalInsuranceCost ?? 0, 2) }} total
                </span>
                <a href="{{ route('manager.insurance.export.pdf') }}" target="_blank"
                   style="background:rgba(224,85,85,.1); color:var(--danger); padding:8px 16px; border-radius:9px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-file-pdf"></i> Export All PDF
                </a>
                <button class="btn-primary" style="background:linear-gradient(135deg,#3730a3,#4f46e5);"
                        onclick="openInsuranceModal()">
                    <i class="fas fa-plus"></i> Add Insurance Record
                </button>
            </div>
        </div>

        @if($errors->hasBag('insurance') && $errors->getBag('insurance')->any())
        <div style="margin:14px 22px 0; background:rgba(224,85,85,.08); border:1px solid rgba(224,85,85,.25); color:var(--danger); padding:12px 16px; border-radius:9px; font-size:13px;">
            <div style="font-weight:700; margin-bottom:4px;"><i class="fas fa-triangle-exclamation"></i> Please fix:</div>
            @foreach($errors->getBag('insurance')->all() as $err)
            <div style="font-size:12px;">• {{ $err }}</div>
            @endforeach
        </div>
        @endif

        {{-- Insurance search / sort bar --}}
        <div style="padding:16px 22px; border-bottom:1px solid #f0f4f8;">
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <div class="search-bar" style="flex:2; min-width:200px;">
                    <i class="fas fa-magnifying-glass"></i>
                    <input type="text" id="insSearchInput"
                           placeholder="Search bus no., notes…"
                           autocomplete="off" oninput="insApplyFilters()">
                </div>
                <select id="insSortField" class="form-control" style="width:178px;" onchange="insApplyFilters()">
                    <option value="insdate">Sort by Date</option>
                    <option value="bus">Sort by Bus No.</option>
                    <option value="amount">Sort by Amount</option>
                </select>
                <select id="insSortDir" class="form-control" style="width:140px;" onchange="insApplyFilters()">
                    <option value="desc">↓ Newest First</option>
                    <option value="asc">↑ Oldest First</option>
                </select>
                <button type="button" onclick="insClearFilters()"
                        style="padding:9px 14px; border-radius:9px; border:1.5px solid #dde3ed; background:#f8fafc; color:var(--text-muted); font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-xmark"></i> Clear
                </button>
            </div>
            <div id="insResultInfo" style="margin-top:10px; font-size:12px; color:var(--text-muted); display:none; align-items:center; gap:6px;">
                <i class="fas fa-circle-info" style="color:#4f46e5;"></i>
                <span id="insResultText"></span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="data-table" id="tblInsurance">
                <thead>
                    <tr>
                        <th style="width:36px;">#</th>
                        <th onclick="insSortByCol('insdate')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Date <i id="ini-insdate" class="fas fa-sort-down" style="font-size:10px; color:#4f46e5;"></i>
                        </th>
                        <th onclick="insSortByCol('bus')" style="cursor:pointer; user-select:none; white-space:nowrap;">
                            Bus No. <i id="ini-bus" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th onclick="insSortByCol('amount')" style="cursor:pointer; user-select:none; white-space:nowrap; text-align:right;">
                            Amount <i id="ini-amount" class="fas fa-sort" style="opacity:.3; font-size:10px;"></i>
                        </th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="insTbody">
                    @forelse($insuranceRecords ?? [] as $i => $ins)
                    <tr class="ins-row"
                        data-insdate="{{ $ins->insurance_date->format('Y-m-d') }}"
                        data-bus="{{ strtolower($ins->bus_number) }}"
                        data-amount="{{ $ins->amount }}"
                        data-notes="{{ strtolower($ins->notes ?? '') }}">
                        <td class="ins-row-num" style="color:var(--text-muted); font-weight:600;">{{ $i + 1 }}</td>
                        <td style="font-size:13px; white-space:nowrap;">
                            <i class="fas fa-calendar-day" style="color:#4f46e5; font-size:11px; margin-right:4px;"></i>
                            {{ $ins->insurance_date->format('d M Y') }}
                        </td>
                        <td>
                            <span style="background:rgba(30,48,82,.08); color:var(--navy-mid); padding:3px 10px; border-radius:6px; font-size:12px; font-weight:700;">
                                {{ $ins->bus_number }}
                            </span>
                        </td>
                        <td style="font-weight:700; color:var(--danger); text-align:right;">
                            ₹{{ number_format($ins->amount, 2) }}
                        </td>
                        <td style="font-size:12px; color:var(--text-muted); max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"
                            title="{{ $ins->notes }}">
                            {{ $ins->notes ?? '—' }}
                        </td>
                        <td>
                            <div style="display:flex; gap:5px;">
                                <a href="{{ route('manager.insurance.pdf', $ins->id) }}" target="_blank"
                                   class="action-btn"
                                   style="background:rgba(224,85,85,.1); color:var(--danger); padding:5px 10px; border-radius:7px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px;"
                                   title="Export PDF"><i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('manager.insurance.print', $ins->id) }}" target="_blank"
                                   class="action-btn"
                                   style="background:rgba(59,130,246,.1); color:var(--info); padding:5px 10px; border-radius:7px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px;"
                                   title="Print"><i class="fas fa-print"></i>
                                </a>
                                <button type="button" class="action-btn btn-edit" title="Edit"
                                    onclick="openEditInsuranceModal(
                                        {{ $ins->id }},
                                        '{{ $ins->insurance_date->format('Y-m-d') }}',
                                        {{ json_encode($ins->bus_number) }},
                                        {{ $ins->amount }},
                                        {{ json_encode($ins->notes ?? '') }}
                                    )">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('manager.insurance.destroy', $ins->id) }}" method="POST" style="margin:0;"
                                      onsubmit="return confirm('Delete insurance record for {{ $ins->bus_number }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-shield-halved"></i>
                                <p>No insurance records yet. Click <strong>Add Insurance Record</strong>.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div id="insNoResults" style="display:none; text-align:center; padding:44px; color:var(--text-muted);">
                <i class="fas fa-magnifying-glass" style="font-size:30px; margin-bottom:10px; opacity:.3; display:block;"></i>
                <p style="font-size:13.5px;">No insurance records match your search.</p>
            </div>
        </div>
    </div>{{-- /insurance panel --}}

</div>{{-- /section-mod-insurance --}}

{{-- MODULE: REPORTS --}}
<div id="section-mod-reports" class="section-content" style="display:none;">
    <div class="panel" style="margin-bottom:22px;">
        <div class="panel-header">
            <div><h2><i class="fas fa-chart-bar" style="color:var(--gold);margin-right:8px;"></i>Reports</h2>
                <p>Summary analytics across all enquiries and services</p>
            </div>
            <a href="{{ route('travels.export') }}" class="btn-primary">
                <i class="fas fa-file-export"></i> Export Report
            </a>
        </div>
        <div class="panel-body">
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">
                <div style="background:#f6f8fb; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:var(--navy); font-family:'Playfair Display',serif;">{{ $totalEnquiries }}</div>
                    <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Total Enquiries</div>
                </div>
                <div style="background:#f6f8fb; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:var(--warning); font-family:'Playfair Display',serif;">{{ $pendingCount }}</div>
                    <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Pending</div>
                </div>
                <div style="background:#f6f8fb; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:var(--success); font-family:'Playfair Display',serif;">{{ $resolvedCount }}</div>
                    <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Approved</div>
                </div>
                <div style="background:#f6f8fb; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:var(--gold); font-family:'Playfair Display',serif;">{{ $todayCount }}</div>
                    <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Today</div>
                </div>
            </div>
            <p style="font-family:'Playfair Display',serif; font-size:14px; color:var(--navy); margin-bottom:14px; font-weight:600;">Enquiry Breakdown by Service</p>
            @php
                $rptData = [
                    ['Bus Booking',          $busCount,     '#1e3052'],
                    ['Sleeper Coach Booking', $sleeperCount, '#c9a84c'],
                    ['Package Tours',         $packageCount, '#3db87a'],
                    ['Bus Rental',            $rentalCount,  '#e05555'],
                ];
            @endphp
            @foreach($rptData as [$label, $count, $color])
            @php $pct = $totalEnquiries ? round($count/$totalEnquiries*100) : 0; @endphp
            <div style="margin-bottom:14px;">
                <div style="display:flex; justify-content:space-between; font-size:13px; font-weight:500; color:#374151; margin-bottom:5px;">
                    <span>{{ $label }}</span>
                    <span style="color:var(--text-muted);">{{ $count }} ({{ $pct }}%)</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $pct }}%; background:linear-gradient(90deg,{{ $color }},{{ $color }}bb);"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

</div>{{-- /main-content --}}
</main>

{{-- ══════════════ ENQUIRY DETAIL MODAL ══════════════ --}}
<div class="modal-overlay" id="enquiryModal">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fas fa-file-lines" style="color:var(--gold);margin-right:8px;font-size:16px;"></i>Enquiry Details</h3>
            <button class="modal-close" onclick="closeModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <div class="modal-body" id="modalBody">
            <div style="text-align:center; padding:30px; color:var(--text-muted);">
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
                <p style="margin-top:10px; font-size:13px;">Loading details…</p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-outline" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>

{{-- Toast --}}
<div class="toast" id="toast">
    <i class="fas fa-circle-check"></i>
    <span id="toastMsg">Action completed!</span>
</div>

{{-- ══════════════ NEW BUS BOOKING MODAL ══════════════ --}}
<div class="booking-modal-overlay" id="busBookingModal">
    <div class="booking-modal">
        <div class="booking-modal-header">
            <div>
                <h3><i class="fas fa-bus" style="margin-right:9px; color:var(--gold);"></i>New Bus Booking</h3>
                <p>Fill all details carefully — all fields are required</p>
            </div>
            <button class="booking-modal-close" onclick="closeBookingModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form action="{{ route('manager.booking.store') }}" method="POST" id="busBookingForm" novalidate>
            @csrf
            <div class="booking-modal-body">
                <div class="bform-grid">
                    <div class="form-divider"><span><i class="fas fa-route" style="margin-right:5px;"></i>Trip Details</span></div>
                    <div class="bform-group full">
                        <label class="bform-label"><i class="fas fa-calendar-day" style="color:var(--gold);"></i> Date of Booking <span class="req">*</span></label>
                        <input type="date" name="booking_date" id="bookingDate" class="bform-input"
                               min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                               value="{{ old('booking_date') }}" onchange="validateBookingDate()">
                        <span class="bform-error" id="err-booking_date"><i class="fas fa-circle-exclamation"></i><span id="err-booking_date-msg">Booking date must be a future date.</span></span>
                    </div>
                    <div class="bform-group full">
                        <label class="bform-label"><i class="fas fa-map-signs" style="color:var(--gold);"></i> Route <span class="req">*</span></label>
                        <div class="route-row">
                            <div>
                                <input type="text" name="route_from" id="routeFrom" class="bform-input" placeholder="Starting point" value="{{ old('route_from') }}" oninput="validateField('routeFrom','err-route_from','Starting point is required.')">
                                <span class="bform-error" id="err-route_from"><i class="fas fa-circle-exclamation"></i><span>Starting point is required.</span></span>
                            </div>
                            <div class="route-arrow"><i class="fas fa-arrow-right"></i></div>
                            <div>
                                <input type="text" name="route_to" id="routeTo" class="bform-input" placeholder="Destination" value="{{ old('route_to') }}" oninput="validateField('routeTo','err-route_to','Destination is required.')">
                                <span class="bform-error" id="err-route_to"><i class="fas fa-circle-exclamation"></i><span>Destination is required.</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="bform-group full">
                        <label class="bform-label"><i class="fas fa-bus" style="color:var(--gold);"></i> Bus Number <span class="req">*</span></label>
                        <input type="text" name="bus_no" id="busNo" class="bform-input" placeholder="e.g. MH12 AB 1234" value="{{ old('bus_no') }}" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase(); validateField('busNo','err-bus_no','Bus number is required.')">
                        <span class="bform-error" id="err-bus_no"><i class="fas fa-circle-exclamation"></i><span>Bus number is required.</span></span>
                    </div>
                    <div class="bform-group">
                        <label class="bform-label"><i class="fas fa-road" style="color:var(--gold);"></i> Kilometer <span class="req">*</span></label>
                        <div style="position:relative;">
                            <input type="number" name="kilometer" id="kilometer" class="bform-input" placeholder="Distance in km" min="1" step="0.01" value="{{ old('kilometer') }}" oninput="validateField('kilometer','err-kilometer','Min 1 km.')">
                            <span id="kmAutoTag" style="display:none; position:absolute; right:10px; top:50%; transform:translateY(-50%); font-size:10px; font-weight:700; color:var(--success); background:rgba(61,184,122,.1); padding:2px 8px; border-radius:20px;">Auto</span>
                        </div>
                        <span class="bform-error" id="err-kilometer"><i class="fas fa-circle-exclamation"></i><span>Kilometer must be at least 1.</span></span>
                    </div>
                    <div class="bform-group">
                        <label class="bform-label"><i class="fas fa-clock" style="color:var(--gold);"></i> Pickup Time <span class="req">*</span></label>
                        <input type="time" name="pickup_time" id="pickupTime" class="bform-input" value="{{ old('pickup_time') }}" onchange="validatePickupTime()">
                        <span class="bform-error" id="err-pickup_time"><i class="fas fa-circle-exclamation"></i><span id="err-pickup_time-msg">Pickup time is required.</span></span>
                    </div>
                    <div class="form-divider"><span><i class="fas fa-indian-rupee-sign" style="margin-right:5px;"></i>Payment Details</span></div>
                    <div class="bform-group">
                        <label class="bform-label"><i class="fas fa-file-invoice-dollar" style="color:var(--gold);"></i> Booking Amount <span class="req">*</span></label>
                        <div class="amount-wrap"><span class="amount-prefix">₹</span><input type="number" name="booking_amount" id="bookingAmount" class="bform-input" placeholder="0.00" min="1" step="0.01" value="{{ old('booking_amount') }}" oninput="validateAmounts()"></div>
                        <span class="bform-error" id="err-booking_amount"><i class="fas fa-circle-exclamation"></i><span id="err-booking_amount-msg">Amount must be greater than 0.</span></span>
                    </div>
                    <div class="bform-group">
                        <label class="bform-label"><i class="fas fa-hand-holding-dollar" style="color:var(--gold);"></i> Advance Amount <span class="req">*</span></label>
                        <div class="amount-wrap"><span class="amount-prefix">₹</span><input type="number" name="advance_amount" id="advanceAmount" class="bform-input" placeholder="0.00" min="0" step="0.01" value="{{ old('advance_amount') }}" oninput="validateAmounts()"></div>
                        <span class="bform-error" id="err-advance_amount"><i class="fas fa-circle-exclamation"></i><span id="err-advance_amount-msg">Advance cannot exceed booking amount.</span></span>
                    </div>
                    <div class="bform-group full">
                        <div class="booking-summary">
                            <div><div class="booking-summary-label">Total Booking</div><div class="booking-summary-value" id="summaryTotal">₹ —</div></div>
                            <div style="text-align:center;"><div class="booking-summary-label">Advance Paid</div><div class="booking-summary-value" id="summaryAdvance" style="color:var(--success);">₹ —</div></div>
                            <div style="text-align:right;"><div class="booking-summary-label">Balance Due</div><div class="booking-summary-due" id="summaryBalance">₹ —</div></div>
                        </div>
                    </div>
                    <div class="bform-group full">
                        <label class="bform-label"><i class="fas fa-note-sticky" style="color:var(--gold);"></i> Notes <span style="color:var(--text-muted); font-weight:400; text-transform:none; font-size:11px;">(Optional)</span></label>
                        <textarea name="note" class="bform-input" rows="2" placeholder="Additional notes…" style="resize:vertical; min-height:60px;">{{ old('note') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="booking-modal-footer">
                <button type="button" class="btn-outline" onclick="closeBookingModal()"><i class="fas fa-xmark"></i> Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-calendar-check"></i> Confirm Booking</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ EDIT BOOKING MODAL ══════════════ --}}
<div class="booking-modal-overlay" id="editBookingModal">
    <div class="booking-modal">
        <div class="booking-modal-header" style="background:linear-gradient(135deg,#1a3a5c,#2a5080);">
            <div>
                <h3><i class="fas fa-pen-to-square" style="margin-right:9px; color:var(--gold);"></i>Edit Booking</h3>
                <p id="editModalSubtitle">Update the booking details below</p>
            </div>
            <button class="booking-modal-close" onclick="closeEditBookingModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form id="editBookingForm" method="POST" novalidate>
            @csrf @method('PUT')
            <div class="booking-modal-body">
                <div class="bform-grid">
                    <div class="form-divider"><span><i class="fas fa-route" style="margin-right:5px;"></i>Trip Details</span></div>
                    <div class="bform-group full">
                        <label class="bform-label"><i class="fas fa-calendar-day" style="color:var(--gold);"></i> Date <span class="req">*</span></label>
                        <input type="date" name="booking_date" id="editBookingDate" class="bform-input" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" onchange="validateEditDate()">
                        <span class="bform-error" id="eerr-booking_date"><i class="fas fa-circle-exclamation"></i><span id="eerr-booking_date-msg">Date must be after today.</span></span>
                    </div>
                    <div class="bform-group full">
                        <label class="bform-label"><i class="fas fa-map-signs" style="color:var(--gold);"></i> Route <span class="req">*</span></label>
                        <div class="route-row">
                            <div>
                                <input type="text" name="route_from" id="editRouteFrom" class="bform-input" placeholder="Starting point" oninput="editAutoCalcKm(); editClearErr('editRouteFrom','eerr-route_from')">
                                <span class="bform-error" id="eerr-route_from"><i class="fas fa-circle-exclamation"></i><span>Required.</span></span>
                            </div>
                            <div class="route-arrow"><i class="fas fa-arrow-right"></i></div>
                            <div>
                                <input type="text" name="route_to" id="editRouteTo" class="bform-input" placeholder="Destination" oninput="editAutoCalcKm(); editClearErr('editRouteTo','eerr-route_to')">
                                <span class="bform-error" id="eerr-route_to"><i class="fas fa-circle-exclamation"></i><span>Required.</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="bform-group full">
                        <label class="bform-label"><i class="fas fa-bus" style="color:var(--gold);"></i> Bus Number <span class="req">*</span></label>
                        <input type="text" name="bus_no" id="editBusNo" class="bform-input" placeholder="e.g. MH12 AB 1234" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase(); editClearErr('editBusNo','eerr-bus_no')">
                        <span class="bform-error" id="eerr-bus_no"><i class="fas fa-circle-exclamation"></i><span>Required.</span></span>
                    </div>
                    <div class="bform-group">
                        <label class="bform-label"><i class="fas fa-road" style="color:var(--gold);"></i> Kilometer <span class="req">*</span></label>
                        <div style="position:relative;">
                            <input type="number" name="kilometer" id="editKilometer" class="bform-input" placeholder="Distance" min="1" step="0.01" oninput="editClearErr('editKilometer','eerr-kilometer')">
                            <span id="editKmAutoTag" style="display:none; position:absolute; right:10px; top:50%; transform:translateY(-50%); font-size:10px; font-weight:700; color:var(--success); background:rgba(61,184,122,.1); padding:2px 8px; border-radius:20px;">Auto</span>
                        </div>
                        <span class="bform-error" id="eerr-kilometer"><i class="fas fa-circle-exclamation"></i><span>Min 1 km.</span></span>
                    </div>
                    <div class="bform-group">
                        <label class="bform-label"><i class="fas fa-clock" style="color:var(--gold);"></i> Pickup Time <span class="req">*</span></label>
                        <input type="time" name="pickup_time" id="editPickupTime" class="bform-input" onchange="validateEditPickupTime()">
                        <span class="bform-error" id="eerr-pickup_time"><i class="fas fa-circle-exclamation"></i><span id="eerr-pickup_time-msg">Required.</span></span>
                    </div>
                    <div class="form-divider"><span><i class="fas fa-indian-rupee-sign" style="margin-right:5px;"></i>Payment Details</span></div>
                    <div class="bform-group">
                        <label class="bform-label"><i class="fas fa-file-invoice-dollar" style="color:var(--gold);"></i> Booking Amount <span class="req">*</span></label>
                        <div class="amount-wrap"><span class="amount-prefix">₹</span><input type="number" name="booking_amount" id="editBookingAmount" class="bform-input" placeholder="0.00" min="1" step="0.01" oninput="updateEditSummary()"></div>
                        <span class="bform-error" id="eerr-booking_amount"><i class="fas fa-circle-exclamation"></i><span id="eerr-booking_amount-msg">Must be &gt; 0.</span></span>
                    </div>
                    <div class="bform-group">
                        <label class="bform-label"><i class="fas fa-hand-holding-dollar" style="color:var(--gold);"></i> Advance Amount <span class="req">*</span></label>
                        <div class="amount-wrap"><span class="amount-prefix">₹</span><input type="number" name="advance_amount" id="editAdvanceAmount" class="bform-input" placeholder="0.00" min="0" step="0.01" oninput="updateEditSummary()"></div>
                        <span class="bform-error" id="eerr-advance_amount"><i class="fas fa-circle-exclamation"></i><span id="eerr-advance_amount-msg">Cannot exceed booking amount.</span></span>
                    </div>
                    <div class="bform-group full">
                        <div class="booking-summary">
                            <div><div class="booking-summary-label">Total Booking</div><div class="booking-summary-value" id="editSummaryTotal">₹ —</div></div>
                            <div style="text-align:center;"><div class="booking-summary-label">Advance Paid</div><div class="booking-summary-value" id="editSummaryAdvance" style="color:var(--success);">₹ —</div></div>
                            <div style="text-align:right;"><div class="booking-summary-label">Balance Due</div><div class="booking-summary-due" id="editSummaryBalance">₹ —</div></div>
                        </div>
                    </div>
                    <div class="bform-group full">
                        <label class="bform-label"><i class="fas fa-note-sticky" style="color:var(--gold);"></i> Note <span style="color:var(--text-muted); font-weight:400; text-transform:none; font-size:11px;">(Optional)</span></label>
                        <textarea name="note" id="editNote" class="bform-input" rows="2" placeholder="Additional notes…" style="resize:vertical; min-height:60px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="booking-modal-footer">
                <button type="button" class="btn-outline" onclick="closeEditBookingModal()"><i class="fas fa-xmark"></i> Cancel</button>
                <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,#c9a84c,#e8c96a); color:var(--navy);"><i class="fas fa-floppy-disk"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ NEW MAINTENANCE MODAL ══════════════ --}}
<div class="maint-modal-overlay" id="maintModal">
    <div class="maint-modal">
        <div class="maint-modal-header">
            <div>
                <h3><i class="fas fa-screwdriver-wrench" style="margin-right:8px; color:rgba(255,255,255,.85);"></i>New Maintenance Record</h3>
                <p>Log a vehicle service or repair entry</p>
            </div>
            <button class="maint-modal-close" onclick="closeMaintenanceModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form action="{{ route('manager.maintenance.store') }}" method="POST" id="maintForm"
              enctype="multipart/form-data" novalidate>
            @csrf
            <div class="maint-modal-body">
                <div class="mmod-grid">

                    {{-- Date --}}
                    <div class="mmod-group">
                        <label class="mmod-label">Date <span class="req">*</span></label>
                        <input type="date" name="maintenance_date" id="maintDate" class="mmod-input"
                               value="{{ old('maintenance_date') }}" required>
                        <span class="mmod-error" id="merr-date">Date is required.</span>
                    </div>

                    {{-- Bus No --}}
                    <div class="mmod-group">
                        <label class="mmod-label">Bus Number <span class="req">*</span></label>
                        <input type="text" name="bus_number" id="maintBusNo" class="mmod-input"
                               placeholder="e.g. MH12AB1234"
                               style="text-transform:uppercase;"
                               value="{{ old('bus_number') }}"
                               oninput="this.value=this.value.toUpperCase();" required>
                        <span class="mmod-error" id="merr-bus">Bus number is required.</span>
                    </div>

                    {{-- Maintenance Type (select) --}}
                    <div class="mmod-group mmod-full">
                        <label class="mmod-label">Type of Maintenance <span class="req">*</span></label>
                        <select name="maintenance_type" id="maintType" class="mmod-input"
                                onchange="toggleMaintCustomType('maintCustomTypeWrap', this.value)" required>
                            <option value="">— Select Type —</option>
                            <option value="Oil Change"          {{ old('maintenance_type')==='Oil Change'          ? 'selected':'' }}>Oil Change</option>
                            <option value="Tyre Replacement"    {{ old('maintenance_type')==='Tyre Replacement'    ? 'selected':'' }}>Tyre Replacement</option>
                            <option value="Engine Repair"       {{ old('maintenance_type')==='Engine Repair'       ? 'selected':'' }}>Engine Repair</option>
                            <option value="Brake Service"       {{ old('maintenance_type')==='Brake Service'       ? 'selected':'' }}>Brake Service</option>
                            <option value="Battery Replacement" {{ old('maintenance_type')==='Battery Replacement' ? 'selected':'' }}>Battery Replacement</option>
                            <option value="AC Service"          {{ old('maintenance_type')==='AC Service'          ? 'selected':'' }}>AC Service</option>
                            <option value="General Service"     {{ old('maintenance_type')==='General Service'     ? 'selected':'' }}>General Service</option>
                            <option value="Body Work"           {{ old('maintenance_type')==='Body Work'           ? 'selected':'' }}>Body Work</option>
                            <option value="Electrical Repair"   {{ old('maintenance_type')==='Electrical Repair'   ? 'selected':'' }}>Electrical Repair</option>
                            <option value="Wheel Alignment"     {{ old('maintenance_type')==='Wheel Alignment'     ? 'selected':'' }}>Wheel Alignment</option>
                            <option value="Other"               {{ old('maintenance_type')==='Other'               ? 'selected':'' }}>Other (specify below)</option>
                        </select>
                        <span class="mmod-error" id="merr-type">Maintenance type is required.</span>
                    </div>

                    {{-- Custom Type — shown only when "Other" is selected --}}
                    <div class="mmod-group mmod-full" id="maintCustomTypeWrap"
                         style="display:{{ old('maintenance_type')==='Other' ? 'flex' : 'none' }}; flex-direction:column; gap:5px;">
                        <label class="mmod-label" style="color:#b45309;">
                            <i class="fas fa-pen" style="font-size:10px;"></i>
                            Specify Maintenance Type <span class="req">*</span>
                        </label>
                        <input type="text" name="custom_type" id="maintCustomType" class="mmod-input"
                               style="border-color:#f59e0b; background:#fffbeb;"
                               placeholder="e.g. GPS Calibration, Seat Repair, Windshield Replacement…"
                               value="{{ old('custom_type') }}">
                        <span style="font-size:11px; color:#92400e; margin-top:2px;">
                            <i class="fas fa-circle-info"></i> Enter any maintenance type not listed above
                        </span>
                        <span class="mmod-error" id="merr-custom-type">Please specify the maintenance type.</span>
                    </div>

                    {{-- Amount Paid --}}
                    <div class="mmod-group">
                        <label class="mmod-label">Amount Paid (₹) <span class="req">*</span></label>
                        <div class="mmod-prefix-wrap">
                            <span class="mmod-prefix">₹</span>
                            <input type="number" name="amount_paid" id="maintAmount" class="mmod-input"
                                   placeholder="0.00" min="0" step="0.01"
                                   value="{{ old('amount_paid') }}" required>
                        </div>
                        <span class="mmod-error" id="merr-amount">Amount is required.</span>
                    </div>

                    {{-- Vendor Name --}}
                    <div class="mmod-group">
                        <label class="mmod-label">Vendor / Garage Name</label>
                        <input type="text" name="vendor_name" class="mmod-input"
                               placeholder="Optional"
                               value="{{ old('vendor_name') }}">
                    </div>

                    {{-- Description --}}
                    <div class="mmod-group mmod-full">
                        <label class="mmod-label">Description / Notes</label>
                        <textarea name="description" class="mmod-input" rows="3"
                                  style="resize:vertical; min-height:70px;"
                                  placeholder="Any additional details about the maintenance…">{{ old('description') }}</textarea>
                    </div>

                    {{-- IMAGE UPLOAD SECTION --}}
                    <div class="mmod-full" style="border-top:1px solid #f0f4f8; padding-top:14px; margin-top:4px;">
                        <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted); margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                            <i class="fas fa-images" style="color:var(--warning);"></i> Attachments
                            <span style="flex:1; height:1px; background:#eef2f7;"></span>
                            <span style="font-weight:400; text-transform:none; letter-spacing:0; font-size:11px;">JPG / PNG / PDF — max 5 MB each</span>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">

                            {{-- Tier Image --}}
                            <div class="mmod-group">
                                <label class="mmod-label" style="display:flex; align-items:center; gap:6px;">
                                    <span style="width:22px; height:22px; background:rgba(59,130,246,.1); border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:11px; color:var(--info);">
                                        <i class="fas fa-tire"></i>
                                    </span>
                                    Tier / Tyre Image
                                </label>
                                <label id="tierImageLabel" style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
                                       border:2px dashed #d1d5db; border-radius:10px; padding:16px 10px;
                                       background:#f8fafc; cursor:pointer; transition:border-color .2s, background .2s;
                                       min-height:90px;"
                                       onmouseover="this.style.borderColor='var(--info)'; this.style.background='#eff6ff';"
                                       onmouseout="this.style.borderColor='#d1d5db'; this.style.background='#f8fafc';">
                                    <i class="fas fa-cloud-arrow-up" style="font-size:20px; color:var(--info);"></i>
                                    <span style="font-size:12px; color:var(--text-muted); text-align:center;">
                                        Click to upload tier image
                                    </span>
                                    <span id="tierImageName" style="font-size:11px; color:var(--navy); font-weight:600; display:none;"></span>
                                    <input type="file" name="tier_image" id="tierImageInput" accept="image/*,.pdf" style="display:none;"
                                           onchange="previewMaintFile(this, 'tierImagePreview', 'tierImageName', 'tierImageLabel')">
                                </label>
                                <div id="tierImagePreview" style="display:none; margin-top:6px; text-align:center;">
                                    <img id="tierImgThumb" src="" alt="Tier Preview"
                                         style="max-width:100%; max-height:80px; border-radius:8px; border:1.5px solid #e2e8f0; object-fit:cover;">
                                    <button type="button" onclick="clearMaintFile('tierImageInput','tierImagePreview','tierImageName','tierImageLabel')"
                                            style="display:block; margin:5px auto 0; background:rgba(224,85,85,.1); color:var(--danger); border:none; border-radius:6px; padding:3px 10px; font-size:11px; cursor:pointer;">
                                        <i class="fas fa-xmark"></i> Remove
                                    </button>
                                </div>
                            </div>

                            {{-- Bill Image --}}
                            <div class="mmod-group">
                                <label class="mmod-label" style="display:flex; align-items:center; gap:6px;">
                                    <span style="width:22px; height:22px; background:rgba(61,184,122,.1); border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:11px; color:var(--success);">
                                        <i class="fas fa-file-invoice"></i>
                                    </span>
                                    Bill / Receipt Image
                                </label>
                                <label id="billImageLabel" style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
                                       border:2px dashed #d1d5db; border-radius:10px; padding:16px 10px;
                                       background:#f8fafc; cursor:pointer; transition:border-color .2s, background .2s;
                                       min-height:90px;"
                                       onmouseover="this.style.borderColor='var(--success)'; this.style.background='#f0fdf4';"
                                       onmouseout="this.style.borderColor='#d1d5db'; this.style.background='#f8fafc';">
                                    <i class="fas fa-cloud-arrow-up" style="font-size:20px; color:var(--success);"></i>
                                    <span style="font-size:12px; color:var(--text-muted); text-align:center;">
                                        Click to upload bill image
                                    </span>
                                    <span id="billImageName" style="font-size:11px; color:var(--navy); font-weight:600; display:none;"></span>
                                    <input type="file" name="bill_image" id="billImageInput" accept="image/*,.pdf" style="display:none;"
                                           onchange="previewMaintFile(this, 'billImagePreview', 'billImageName', 'billImageLabel')">
                                </label>
                                <div id="billImagePreview" style="display:none; margin-top:6px; text-align:center;">
                                    <img id="billImgThumb" src="" alt="Bill Preview"
                                         style="max-width:100%; max-height:80px; border-radius:8px; border:1.5px solid #e2e8f0; object-fit:cover;">
                                    <button type="button" onclick="clearMaintFile('billImageInput','billImagePreview','billImageName','billImageLabel')"
                                            style="display:block; margin:5px auto 0; background:rgba(224,85,85,.1); color:var(--danger); border:none; border-radius:6px; padding:3px 10px; font-size:11px; cursor:pointer;">
                                        <i class="fas fa-xmark"></i> Remove
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- /IMAGE UPLOAD SECTION --}}

                </div>
            </div>
            <div class="maint-modal-footer">
                <button type="button" class="btn-outline" onclick="closeMaintenanceModal()"><i class="fas fa-xmark"></i> Cancel</button>
                <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,#b45309,#d97706);">
                    <i class="fas fa-floppy-disk"></i> Save Record
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ EDIT MAINTENANCE MODAL ══════════════ --}}
<div class="maint-modal-overlay" id="editMaintModal">
    <div class="maint-modal">
        <div class="maint-modal-header" style="background:linear-gradient(135deg,#92400e,#b45309);">
            <div>
                <h3><i class="fas fa-pen-to-square" style="margin-right:8px; color:rgba(255,255,255,.85);"></i>Edit Maintenance Record</h3>
                <p id="editMaintSubtitle">Update the maintenance details</p>
            </div>
            <button class="maint-modal-close" onclick="closeEditMaintenanceModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form id="editMaintForm" method="POST" enctype="multipart/form-data" novalidate>
            @csrf @method('PUT')
            <div class="maint-modal-body">
                <div class="mmod-grid">
                    <div class="mmod-group">
                        <label class="mmod-label">Date <span class="req">*</span></label>
                        <input type="date" name="maintenance_date" id="editMaintDate" class="mmod-input" required>
                    </div>
                    <div class="mmod-group">
                        <label class="mmod-label">Bus Number <span class="req">*</span></label>
                        <input type="text" name="bus_number" id="editMaintBusNo" class="mmod-input"
                               placeholder="e.g. MH12AB1234" style="text-transform:uppercase;"
                               oninput="this.value=this.value.toUpperCase();" required>
                    </div>

                    {{-- Maintenance Type (select) --}}
                    <div class="mmod-group mmod-full">
                        <label class="mmod-label">Type of Maintenance <span class="req">*</span></label>
                        <select name="maintenance_type" id="editMaintType" class="mmod-input"
                                onchange="toggleMaintCustomType('editMaintCustomTypeWrap', this.value)" required>
                            <option value="">— Select Type —</option>
                            <option value="Oil Change">Oil Change</option>
                            <option value="Tyre Replacement">Tyre Replacement</option>
                            <option value="Engine Repair">Engine Repair</option>
                            <option value="Brake Service">Brake Service</option>
                            <option value="Battery Replacement">Battery Replacement</option>
                            <option value="AC Service">AC Service</option>
                            <option value="General Service">General Service</option>
                            <option value="Body Work">Body Work</option>
                            <option value="Electrical Repair">Electrical Repair</option>
                            <option value="Wheel Alignment">Wheel Alignment</option>
                            <option value="Other">Other (specify below)</option>
                        </select>
                    </div>

                    {{-- Custom Type (edit) --}}
                    <div class="mmod-group mmod-full" id="editMaintCustomTypeWrap"
                         style="display:none; flex-direction:column; gap:5px;">
                        <label class="mmod-label" style="color:#b45309;">
                            <i class="fas fa-pen" style="font-size:10px;"></i>
                            Specify Maintenance Type <span class="req">*</span>
                        </label>
                        <input type="text" name="custom_type" id="editMaintCustomType" class="mmod-input"
                               style="border-color:#f59e0b; background:#fffbeb;"
                               placeholder="e.g. GPS Calibration, Seat Repair, Windshield Replacement…">
                        <span style="font-size:11px; color:#92400e; margin-top:2px;">
                            <i class="fas fa-circle-info"></i> Enter any maintenance type not listed above
                        </span>
                    </div>

                    <div class="mmod-group">
                        <label class="mmod-label">Amount Paid (₹) <span class="req">*</span></label>
                        <div class="mmod-prefix-wrap">
                            <span class="mmod-prefix">₹</span>
                            <input type="number" name="amount_paid" id="editMaintAmount" class="mmod-input"
                                   placeholder="0.00" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="mmod-group">
                        <label class="mmod-label">Vendor / Garage Name</label>
                        <input type="text" name="vendor_name" id="editMaintVendor" class="mmod-input" placeholder="Optional">
                    </div>
                    <div class="mmod-group mmod-full">
                        <label class="mmod-label">Description / Notes</label>
                        <textarea name="description" id="editMaintDesc" class="mmod-input" rows="3"
                                  style="resize:vertical; min-height:70px;" placeholder="Additional details…"></textarea>
                    </div>

                    {{-- EDIT IMAGE UPLOAD SECTION --}}
                    <div class="mmod-full" style="border-top:1px solid #f0f4f8; padding-top:14px; margin-top:4px;">
                        <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:var(--text-muted); margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                            <i class="fas fa-images" style="color:var(--warning);"></i> Attachments
                            <span style="flex:1; height:1px; background:#eef2f7;"></span>
                            <span style="font-weight:400; text-transform:none; letter-spacing:0; font-size:11px;">Upload new to replace existing</span>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">

                            {{-- Edit Tier Image --}}
                            <div class="mmod-group">
                                <label class="mmod-label" style="display:flex; align-items:center; gap:6px;">
                                    <span style="width:22px; height:22px; background:rgba(59,130,246,.1); border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:11px; color:var(--info);">
                                        <i class="fas fa-tire"></i>
                                    </span>
                                    Tier / Tyre Image
                                </label>
                                {{-- Existing image --}}
                                <div id="editExistingTierWrap" style="display:none; margin-bottom:6px; text-align:center;">
                                    <a id="editExistingTierLink" href="#" target="_blank">
                                        <img id="editExistingTierThumb" src="" alt="Current Tier"
                                             style="max-width:100%; max-height:70px; border-radius:8px; border:1.5px solid #dde3ed; object-fit:cover;">
                                    </a>
                                    <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Current — upload new to replace</div>
                                </div>
                                <label id="editTierImageLabel" style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
                                       border:2px dashed #d1d5db; border-radius:10px; padding:14px 10px;
                                       background:#f8fafc; cursor:pointer; transition:border-color .2s, background .2s; min-height:80px;"
                                       onmouseover="this.style.borderColor='var(--info)'; this.style.background='#eff6ff';"
                                       onmouseout="this.style.borderColor='#d1d5db'; this.style.background='#f8fafc';">
                                    <i class="fas fa-cloud-arrow-up" style="font-size:18px; color:var(--info);"></i>
                                    <span style="font-size:11px; color:var(--text-muted); text-align:center;">Click to upload new tier image</span>
                                    <span id="editTierImageName" style="font-size:11px; color:var(--navy); font-weight:600; display:none;"></span>
                                    <input type="file" name="tier_image" id="editTierImageInput" accept="image/*,.pdf" style="display:none;"
                                           onchange="previewMaintFile(this, 'editTierImagePreview', 'editTierImageName', 'editTierImageLabel')">
                                </label>
                                <div id="editTierImagePreview" style="display:none; margin-top:6px; text-align:center;">
                                    <img id="editTierImgThumb" src="" alt="New Tier"
                                         style="max-width:100%; max-height:70px; border-radius:8px; border:1.5px solid #e2e8f0; object-fit:cover;">
                                    <button type="button" onclick="clearMaintFile('editTierImageInput','editTierImagePreview','editTierImageName','editTierImageLabel')"
                                            style="display:block; margin:5px auto 0; background:rgba(224,85,85,.1); color:var(--danger); border:none; border-radius:6px; padding:3px 10px; font-size:11px; cursor:pointer;">
                                        <i class="fas fa-xmark"></i> Remove new
                                    </button>
                                </div>
                            </div>

                            {{-- Edit Bill Image --}}
                            <div class="mmod-group">
                                <label class="mmod-label" style="display:flex; align-items:center; gap:6px;">
                                    <span style="width:22px; height:22px; background:rgba(61,184,122,.1); border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:11px; color:var(--success);">
                                        <i class="fas fa-file-invoice"></i>
                                    </span>
                                    Bill / Receipt Image
                                </label>
                                {{-- Existing image --}}
                                <div id="editExistingBillWrap" style="display:none; margin-bottom:6px; text-align:center;">
                                    <a id="editExistingBillLink" href="#" target="_blank">
                                        <img id="editExistingBillThumb" src="" alt="Current Bill"
                                             style="max-width:100%; max-height:70px; border-radius:8px; border:1.5px solid #dde3ed; object-fit:cover;">
                                    </a>
                                    <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Current — upload new to replace</div>
                                </div>
                                <label id="editBillImageLabel" style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
                                       border:2px dashed #d1d5db; border-radius:10px; padding:14px 10px;
                                       background:#f8fafc; cursor:pointer; transition:border-color .2s, background .2s; min-height:80px;"
                                       onmouseover="this.style.borderColor='var(--success)'; this.style.background='#f0fdf4';"
                                       onmouseout="this.style.borderColor='#d1d5db'; this.style.background='#f8fafc';">
                                    <i class="fas fa-cloud-arrow-up" style="font-size:18px; color:var(--success);"></i>
                                    <span style="font-size:11px; color:var(--text-muted); text-align:center;">Click to upload new bill image</span>
                                    <span id="editBillImageName" style="font-size:11px; color:var(--navy); font-weight:600; display:none;"></span>
                                    <input type="file" name="bill_image" id="editBillImageInput" accept="image/*,.pdf" style="display:none;"
                                           onchange="previewMaintFile(this, 'editBillImagePreview', 'editBillImageName', 'editBillImageLabel')">
                                </label>
                                <div id="editBillImagePreview" style="display:none; margin-top:6px; text-align:center;">
                                    <img id="editBillImgThumb" src="" alt="New Bill"
                                         style="max-width:100%; max-height:70px; border-radius:8px; border:1.5px solid #e2e8f0; object-fit:cover;">
                                    <button type="button" onclick="clearMaintFile('editBillImageInput','editBillImagePreview','editBillImageName','editBillImageLabel')"
                                            style="display:block; margin:5px auto 0; background:rgba(224,85,85,.1); color:var(--danger); border:none; border-radius:6px; padding:3px 10px; font-size:11px; cursor:pointer;">
                                        <i class="fas fa-xmark"></i> Remove new
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- /EDIT IMAGE SECTION --}}

                </div>
            </div>
            <div class="maint-modal-footer">
                <button type="button" class="btn-outline" onclick="closeEditMaintenanceModal()"><i class="fas fa-xmark"></i> Cancel</button>
                <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,#92400e,#b45309);">
                    <i class="fas fa-floppy-disk"></i> Update Record
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ NEW BILLING MODAL ══════════════ --}}
<div class="billing-modal-overlay" id="billingModal">
    <div class="billing-modal">
        <div class="billing-modal-header">
            <div>
                <h3><i class="fas fa-file-invoice-dollar" style="margin-right:8px; color:rgba(255,255,255,.8);"></i>New Billing Record</h3>
                <p>Add trip expenses and driver information</p>
            </div>
            <button class="billing-modal-close" onclick="closeBillingModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form action="{{ route('manager.billing.store') }}" method="POST" id="billingForm" novalidate>
            @csrf
            <div class="billing-modal-body">
                <div class="bmod-section-label"><span><i class="fas fa-calendar-check"></i></span> Link to Booking</div>
                <div class="bmod-group" style="margin-bottom:4px;">
                    <label class="bmod-label">Select Booking <span class="req">*</span></label>
                    <select name="bus_booking_id" id="billingBookingId" class="bmod-input" onchange="updateBillingBookingInfo(this)">
                        <option value="">— Choose a booking —</option>
                        @foreach($busBookings as $bk)
                        <option value="{{ $bk->id }}"
                            data-amount="{{ $bk->booking_amount }}"
                            data-route="{{ $bk->route_from }} → {{ $bk->route_to }}"
                            data-km="{{ $bk->kilometer }}">
                            #BK-{{ str_pad($bk->id,4,'0',STR_PAD_LEFT) }} — {{ $bk->route_from }} → {{ $bk->route_to }}
                            ({{ \Carbon\Carbon::parse($bk->booking_date)->format('d M Y') }})
                        </option>
                        @endforeach
                    </select>
                    <span class="bmod-error" id="berr-bus_booking_id">Booking selection is required.</span>
                </div>
                <div id="billingBookingInfo" style="display:none; background:#f0fdf4; border:1px solid rgba(21,128,61,.2); border-radius:9px; padding:10px 14px; margin-top:6px; font-size:12.5px; color:#166534; margin-bottom:4px;">
                    <i class="fas fa-route" style="margin-right:5px;"></i><span id="billingInfoText"></span>
                </div>
                <div class="bmod-section-label"><span><i class="fas fa-indian-rupee-sign"></i></span> Expense Breakdown</div>
                <div class="bmod-grid three">
                    <div class="bmod-group"><label class="bmod-label">Rate per KM</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="rate_per_km" id="billingRateKm" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Diesel Amount</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="diesel_amount" id="billingDiesel" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Toll / Parking</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="toll_parking" id="billingToll" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Online Permit</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="online_permit" id="billingPermit" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Driver Amount</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="driver_amount" id="billingDriverAmt" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Other Expenses</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="other_expenses" id="billingOther" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateBillingProfit()"></div></div>
                </div>
                <div class="billing-profit-summary" style="margin-top:12px;">
                    <div class="bps-item"><div class="bps-label">Booking Amount</div><div class="bps-value" id="bpBookingAmt" style="color:var(--navy);">₹ —</div></div>
                    <div class="bps-item"><div class="bps-label">Total Expenses</div><div class="bps-value" id="bpTotalExp" style="color:var(--danger);">₹ —</div></div>
                    <div class="bps-item"><div class="bps-label">Net Profit</div><div class="bps-value" id="bpNetProfit" style="color:var(--success);">₹ —</div></div>
                </div>
                <div class="bmod-section-label"><span><i class="fas fa-id-card"></i></span> Driver Information</div>
                <div class="bmod-grid">
                    <div class="bmod-group"><label class="bmod-label">Driver Name</label><input type="text" name="driver_name" id="billingDriverName" class="bmod-input" placeholder="Full name"></div>
                    <div class="bmod-group"><label class="bmod-label">Driver Mobile</label><input type="text" name="driver_mobile" id="billingDriverMobile" class="bmod-input" placeholder="+91 00000 00000"></div>
                </div>
                <div class="bmod-section-label"><span><i class="fas fa-note-sticky"></i></span> Additional Notes</div>
                <div class="bmod-group">
                    <textarea name="description" id="billingDesc" class="bmod-input" rows="3" placeholder="Any additional remarks…" style="resize:vertical; min-height:70px;"></textarea>
                </div>
            </div>
            <div class="billing-modal-footer">
                <button type="button" class="btn-outline" onclick="closeBillingModal()"><i class="fas fa-xmark"></i> Cancel</button>
                <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,#15803d,#166534);"><i class="fas fa-floppy-disk"></i> Save Billing Record</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ EDIT BILLING MODAL ══════════════ --}}
<div class="billing-modal-overlay" id="editBillingModal">
    <div class="billing-modal">
        <div class="billing-modal-header" style="background:linear-gradient(135deg,#1a5c3a,#2a7a50);">
            <div>
                <h3><i class="fas fa-pen-to-square" style="margin-right:8px; color:rgba(255,255,255,.8);"></i>Edit Billing Record</h3>
                <p id="editBillingSubtitle">Update expense and driver information</p>
            </div>
            <button class="billing-modal-close" onclick="closeEditBillingModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form id="editBillingForm" method="POST" novalidate>
            @csrf @method('PUT')
            <div class="billing-modal-body">
                <input type="hidden" name="bus_booking_id" id="editBillingBookingId">
                <div id="editBillingBookingInfo" style="background:#f0fdf4; border:1px solid rgba(21,128,61,.2); border-radius:9px; padding:12px 16px; margin-bottom:4px; font-size:12.5px; color:#166534;">
                    <i class="fas fa-calendar-check" style="margin-right:6px;"></i><span id="editBillingInfoText">—</span>
                </div>
                <div class="bmod-section-label"><span><i class="fas fa-indian-rupee-sign"></i></span> Expense Breakdown</div>
                <div class="bmod-grid three">
                    <div class="bmod-group"><label class="bmod-label">Rate per KM</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="rate_per_km" id="editBillingRateKm" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateEditBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Diesel Amount</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="diesel_amount" id="editBillingDiesel" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateEditBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Toll / Parking</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="toll_parking" id="editBillingToll" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateEditBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Online Permit</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="online_permit" id="editBillingPermit" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateEditBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Driver Amount</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="driver_amount" id="editBillingDriverAmt" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateEditBillingProfit()"></div></div>
                    <div class="bmod-group"><label class="bmod-label">Other Expenses</label><div class="bmod-prefix-wrap"><span class="bmod-prefix">₹</span><input type="number" name="other_expenses" id="editBillingOther" class="bmod-input" placeholder="0.00" min="0" step="0.01" oninput="updateEditBillingProfit()"></div></div>
                </div>
                <div class="billing-profit-summary" style="margin-top:12px;">
                    <div class="bps-item"><div class="bps-label">Booking Amount</div><div class="bps-value" id="ebpBookingAmt" style="color:var(--navy);">₹ —</div></div>
                    <div class="bps-item"><div class="bps-label">Total Expenses</div><div class="bps-value" id="ebpTotalExp" style="color:var(--danger);">₹ —</div></div>
                    <div class="bps-item"><div class="bps-label">Net Profit</div><div class="bps-value" id="ebpNetProfit" style="color:var(--success);">₹ —</div></div>
                </div>
                <div class="bmod-section-label"><span><i class="fas fa-id-card"></i></span> Driver Information</div>
                <div class="bmod-grid">
                    <div class="bmod-group"><label class="bmod-label">Driver Name</label><input type="text" name="driver_name" id="editBillingDriverName" class="bmod-input" placeholder="Full name"></div>
                    <div class="bmod-group"><label class="bmod-label">Driver Mobile</label><input type="text" name="driver_mobile" id="editBillingDriverMobile" class="bmod-input" placeholder="+91 00000 00000"></div>
                </div>
                <div class="bmod-section-label"><span><i class="fas fa-note-sticky"></i></span> Notes</div>
                <div class="bmod-group"><textarea name="description" id="editBillingDesc" class="bmod-input" rows="3" placeholder="Additional remarks…" style="resize:vertical; min-height:70px;"></textarea></div>
            </div>
            <div class="billing-modal-footer">
                <button type="button" class="btn-outline" onclick="closeEditBillingModal()"><i class="fas fa-xmark"></i> Cancel</button>
                <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,#15803d,#166534);"><i class="fas fa-floppy-disk"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ JAVASCRIPT ══════════════ --}}
<script>
const enquiriesData = @json($allEnquiries->getCollection()->keyBy('id'));

const sectionTitles = {
    'overview':         'Manager Dashboard',
    'all-enquiries':    'All Enquiries',
    'pending':          'Pending Enquiries',
    'resolved':         'Approved Enquiries',
    'bus-booking':      'Bus Booking Enquiries',
    'sleeper':          'Sleeper Coach Enquiries',
    'package':          'Package Tour Enquiries',
    'rental':           'Bus Rental Enquiries',
    'mod-booking':      'Booking Module',
    'mod-maintenance':  'Maintenance Module',
    'mod-billing':      'Billing Module',
    'mod-insurance':    'Insurance Module',
    'mod-reports':      'Reports',
};

function showSection(id, el) {
    document.querySelectorAll('.section-content').forEach(s => s.style.display = 'none');
    const sec = document.getElementById('section-' + id);
    if (sec) sec.style.display = 'block';
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    if (el) el.classList.add('active');
    document.getElementById('page-title').textContent = sectionTitles[id] || id;
}

// ── ENQUIRY MODAL ──
function openEnquiryModal(id) {
    const enq = enquiriesData[id];
    if (!enq) return;
    const typeColors = {
        'Bus Booking':'#1e3052','Sleeper Coach Booking':'#c9a84c',
        'Package Tours':'#3db87a','Bus Rental':'#e05555'
    };
    const color = typeColors[enq.type_of_enquiry] || '#1e3052';
    document.getElementById('modalBody').innerHTML = `
        <div class="detail-row"><div class="detail-label">Full Name</div><div class="detail-value" style="font-weight:600;">${enq.name}</div></div>
        <div class="detail-row"><div class="detail-label">Mobile</div><div class="detail-value">${enq.mobile}</div></div>
        <div class="detail-row"><div class="detail-label">Address</div><div class="detail-value">${enq.address}</div></div>
        <div class="detail-row"><div class="detail-label">Type of Enquiry</div>
            <div class="detail-value"><span style="background:${color}20;color:${color};padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">${enq.type_of_enquiry}</span></div>
        </div>
        <div class="detail-row"><div class="detail-label">Date of Requirement</div>
            <div class="detail-value">${enq.date_of_requirement ? new Date(enq.date_of_requirement).toLocaleDateString('en-IN',{day:'2-digit',month:'short',year:'numeric'}) : '—'}</div>
        </div>
        <div class="detail-row"><div class="detail-label">Message</div><div class="detail-value">${enq.message || '<span style="color:var(--text-muted)">No message</span>'}</div></div>
        <div class="detail-row"><div class="detail-label">Submitted On</div><div class="detail-value">${new Date(enq.created_at).toLocaleDateString('en-IN',{day:'2-digit',month:'short',year:'numeric'})}</div></div>
        <div class="detail-row"><div class="detail-label">Status</div>
            <div class="detail-value"><span style="background:${enq.status==='approved'?'rgba(61,184,122,.12)':'rgba(245,158,11,.12)'};color:${enq.status==='approved'?'#166534':'#92400e'};padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">${enq.status ? enq.status.charAt(0).toUpperCase()+enq.status.slice(1) : 'Pending'}</span></div>
        </div>
    `;
    document.getElementById('enquiryModal').classList.add('open');
}
function closeModal() { document.getElementById('enquiryModal').classList.remove('open'); }
document.getElementById('enquiryModal').addEventListener('click', function(e) { if (e.target === this) closeModal(); });

// ── TABLE FILTERS ──
function filterTable(tableId, query) {
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    const q = query.toLowerCase();
    rows.forEach(row => { row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none'; });
}
function filterByType(tableId, type) {
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    rows.forEach(row => { row.style.display = (!type || row.dataset.type === type) ? '' : 'none'; });
}
function filterByStatus(tableId, status) {
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    rows.forEach(row => { row.style.display = (!status || row.dataset.status === status) ? '' : 'none'; });
}

// ── TOAST ──
@if(session('manager_success'))
window.addEventListener('load', () => {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = @json(session('manager_success'));
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 4500);
});
@endif

// ══════════════════════════════════════════════
// BUS BOOKING MODAL
// ══════════════════════════════════════════════
function openBookingModal() {
    document.getElementById('busBookingModal').classList.add('open');
    document.body.style.overflow = 'hidden';
    @if($errors->hasBag('booking'))
        setTimeout(() => {
            @foreach(['booking_date','route_from','route_to','bus_no','kilometer','pickup_time','booking_amount','advance_amount'] as $field)
            @if($errors->getBag('booking')->has($field))
            showFieldError('{{ $field }}', '{{ $errors->getBag("booking")->first($field) }}');
            @endif
            @endforeach
            updateSummary();
        }, 100);
    @endif
}
function closeBookingModal() {
    document.getElementById('busBookingModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('busBookingModal').addEventListener('click', function(e) { if (e.target === this) closeBookingModal(); });

@if($errors->hasBag('booking') && $errors->getBag('booking')->any())
window.addEventListener('load', () => {
    showSection('mod-booking', document.querySelector('[data-section=mod-booking]'));
    openBookingModal();
});
@endif

function showFieldError(fieldId, message) {
    const input = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
    const errEl = document.getElementById('err-' + fieldId);
    if (input) input.classList.add('error');
    if (errEl) {
        const msgSpan = errEl.querySelector('span') || errEl;
        if (message) msgSpan.textContent = message;
        errEl.classList.add('show');
    }
}
function clearFieldError(inputEl, errId) {
    if (inputEl) inputEl.classList.remove('error');
    const errEl = document.getElementById(errId);
    if (errEl) errEl.classList.remove('show');
}
function validateField(inputId, errId, msg) {
    const input = document.getElementById(inputId);
    if (!input) return true;
    if (!input.value.trim()) {
        input.classList.add('error');
        const errEl = document.getElementById(errId);
        if (errEl) errEl.classList.add('show');
        return false;
    }
    clearFieldError(input, errId);
    return true;
}
function validatePickupTime() {
    const input = document.getElementById('pickupTime');
    const errEl = document.getElementById('err-pickup_time');
    const msgEl = document.getElementById('err-pickup_time-msg');
    const dateInput = document.getElementById('bookingDate');
    if (!input.value) {
        input.classList.add('error'); msgEl.textContent = 'Pickup time is required.'; errEl.classList.add('show'); return false;
    }
    if (dateInput && dateInput.value) {
        const todayStr = new Date().toISOString().split('T')[0];
        if (dateInput.value === todayStr) {
            const now = new Date();
            const nowStr = now.getHours().toString().padStart(2,'0')+':'+now.getMinutes().toString().padStart(2,'0');
            if (input.value <= nowStr) {
                input.classList.add('error'); msgEl.textContent = 'Pickup time must be after current time ('+nowStr+').'; errEl.classList.add('show'); return false;
            }
        }
    }
    clearFieldError(input, 'err-pickup_time'); return true;
}

const routeDistances = {
    'Mumbai-Pune':148,'Pune-Mumbai':148,'Mumbai-Nashik':167,'Nashik-Mumbai':167,
    'Mumbai-Nagpur':835,'Nagpur-Mumbai':835,'Pune-Nashik':211,'Nashik-Pune':211,
    'Pune-Nagpur':720,'Nagpur-Pune':720,'Pune-Aurangabad':235,'Aurangabad-Pune':235,
    'Nashik-Nagpur':690,'Nagpur-Nashik':690,'Aurangabad-Nagpur':490,'Nagpur-Aurangabad':490,
    'Mumbai-Aurangabad':335,'Aurangabad-Mumbai':335,
};

function autoCalcKm() {
    const from = document.getElementById('routeFrom').value.trim();
    const to   = document.getElementById('routeTo').value.trim();
    const kmInput = document.getElementById('kilometer');
    const tag = document.getElementById('kmAutoTag');
    if (from && to) {
        const dist = routeDistances[from+'-'+to] || routeDistances[to+'-'+from];
        if (dist) { kmInput.value = dist; if (tag) tag.style.display = 'block'; clearFieldError(kmInput, 'err-kilometer'); return; }
    }
    if (tag) tag.style.display = 'none';
}
document.getElementById('routeFrom').addEventListener('input', autoCalcKm);
document.getElementById('routeTo').addEventListener('input', autoCalcKm);

function validateBookingDate() {
    const input = document.getElementById('bookingDate');
    const errEl = document.getElementById('err-booking_date');
    const msgEl = document.getElementById('err-booking_date-msg');
    if (!input.value) { input.classList.add('error'); msgEl.textContent = 'Booking date is required.'; errEl.classList.add('show'); return false; }
    const sel = new Date(input.value), today = new Date(); today.setHours(0,0,0,0);
    if (sel <= today) { input.classList.add('error'); msgEl.textContent = 'Booking date must be after today.'; errEl.classList.add('show'); return false; }
    clearFieldError(input, 'err-booking_date'); return true;
}

function validateAmounts() {
    const bi = document.getElementById('bookingAmount');
    const ai = document.getElementById('advanceAmount');
    const bv = parseFloat(bi.value) || 0;
    const av = parseFloat(ai.value) || 0;
    let valid = true;
    if (!bi.value || bv <= 0) { bi.classList.add('error'); document.getElementById('err-booking_amount-msg').textContent = 'Amount must be > 0.'; document.getElementById('err-booking_amount').classList.add('show'); valid = false; }
    else clearFieldError(bi, 'err-booking_amount');
    if (!ai.value || av < 0) { ai.classList.add('error'); document.getElementById('err-advance_amount-msg').textContent = 'Must be 0 or more.'; document.getElementById('err-advance_amount').classList.add('show'); valid = false; }
    else if (av > bv) { ai.classList.add('error'); document.getElementById('err-advance_amount-msg').textContent = 'Cannot exceed ₹'+bv.toLocaleString('en-IN')+'.'; document.getElementById('err-advance_amount').classList.add('show'); valid = false; }
    else clearFieldError(ai, 'err-advance_amount');
    updateSummary(); return valid;
}

function updateSummary() {
    const b = parseFloat(document.getElementById('bookingAmount').value) || 0;
    const a = parseFloat(document.getElementById('advanceAmount').value) || 0;
    const bal = b - a;
    const fmt = v => '₹ ' + v.toLocaleString('en-IN',{minimumFractionDigits:2,maximumFractionDigits:2});
    document.getElementById('summaryTotal').textContent   = b > 0 ? fmt(b) : '₹ —';
    document.getElementById('summaryAdvance').textContent = a >= 0 && b > 0 ? fmt(a) : '₹ —';
    const balEl = document.getElementById('summaryBalance');
    if (b > 0) { balEl.textContent = fmt(bal < 0 ? 0 : bal); balEl.style.color = bal > 0 ? 'var(--danger)' : 'var(--success)'; }
    else { balEl.textContent = '₹ —'; balEl.style.color = 'var(--danger)'; }
}

document.getElementById('busBookingForm').addEventListener('submit', function(e) {
    const v1=validateBookingDate(), v2=validateField('routeFrom','err-route_from','Required.'),
          v3=validateField('routeTo','err-route_to','Required.'), v4=validateField('busNo','err-bus_no','Required.'),
          v5=validateField('kilometer','err-kilometer','Min 1 km.'), v6=validatePickupTime(), v7=validateAmounts();
    if (!v1||!v2||!v3||!v4||!v5||!v6||!v7) {
        e.preventDefault();
        const f = document.querySelector('#busBookingForm .bform-input.error');
        if (f) f.scrollIntoView({behavior:'smooth',block:'center'});
    }
});

@if(session('booking_success'))
window.addEventListener('load', () => {
    showSection('mod-booking', document.querySelector('[data-section=mod-booking]'));
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = @json(session('booking_success'));
    t.style.background = '#1a4731';
    document.querySelector('#toast i').className = 'fas fa-calendar-check';
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 5000);
});
@endif

// ── EDIT BOOKING MODAL ──
function openEditBookingModal(id, bookingDate, routeFrom, routeTo, kilometer, busNumber, pickupTime, bookingAmount, advanceAmount, note) {
    document.getElementById('editBookingForm').action = '/manager/booking/' + id;
    document.getElementById('editBookingDate').value    = bookingDate;
    document.getElementById('editRouteFrom').value      = routeFrom;
    document.getElementById('editRouteTo').value        = routeTo;
    document.getElementById('editKilometer').value      = kilometer;
    document.getElementById('editBusNo').value          = busNumber;
    document.getElementById('editPickupTime').value     = pickupTime;
    document.getElementById('editBookingAmount').value  = bookingAmount;
    document.getElementById('editAdvanceAmount').value  = advanceAmount;
    document.getElementById('editNote').value           = note || '';
    document.getElementById('editModalSubtitle').textContent = 'Editing Booking #' + id;
    document.querySelectorAll('#editBookingModal .bform-input').forEach(el => el.classList.remove('error'));
    document.querySelectorAll('#editBookingModal .bform-error').forEach(el => el.classList.remove('show'));
    updateEditSummary();
    document.getElementById('editBookingModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEditBookingModal() {
    document.getElementById('editBookingModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('editBookingModal').addEventListener('click', function(e) { if (e.target === this) closeEditBookingModal(); });

function editAutoCalcKm() {
    const from = document.getElementById('editRouteFrom').value.trim();
    const to   = document.getElementById('editRouteTo').value.trim();
    const kmInput = document.getElementById('editKilometer');
    const tag = document.getElementById('editKmAutoTag');
    if (from && to) {
        const dist = routeDistances[from+'-'+to] || routeDistances[to+'-'+from];
        if (dist) { kmInput.value = dist; if (tag) tag.style.display = 'block'; editClearErr('editKilometer','eerr-kilometer'); return; }
    }
    if (tag) tag.style.display = 'none';
}
function editClearErr(inputId, errId) {
    const inp = document.getElementById(inputId);
    if (inp) inp.classList.remove('error');
    const err = document.getElementById(errId);
    if (err) err.classList.remove('show');
}
function validateEditDate() {
    const input = document.getElementById('editBookingDate');
    const errEl = document.getElementById('eerr-booking_date');
    const msgEl = document.getElementById('eerr-booking_date-msg');
    if (!input.value) { input.classList.add('error'); msgEl.textContent='Date required.'; errEl.classList.add('show'); return false; }
    const sel = new Date(input.value), today = new Date(); today.setHours(0,0,0,0);
    if (sel <= today) { input.classList.add('error'); msgEl.textContent='Must be after today.'; errEl.classList.add('show'); return false; }
    editClearErr('editBookingDate','eerr-booking_date'); return true;
}
function validateEditPickupTime() {
    const input = document.getElementById('editPickupTime');
    const errEl = document.getElementById('eerr-pickup_time');
    const msgEl = document.getElementById('eerr-pickup_time-msg');
    const dateInput = document.getElementById('editBookingDate');
    if (!input.value) { input.classList.add('error'); msgEl.textContent='Required.'; errEl.classList.add('show'); return false; }
    if (dateInput && dateInput.value) {
        const todayStr = new Date().toISOString().split('T')[0];
        if (dateInput.value === todayStr) {
            const now = new Date();
            const nowStr = now.getHours().toString().padStart(2,'0')+':'+now.getMinutes().toString().padStart(2,'0');
            if (input.value <= nowStr) { input.classList.add('error'); msgEl.textContent='Must be after '+nowStr+'.'; errEl.classList.add('show'); return false; }
        }
    }
    editClearErr('editPickupTime','eerr-pickup_time'); return true;
}
function updateEditSummary() {
    const b = parseFloat(document.getElementById('editBookingAmount').value) || 0;
    const a = parseFloat(document.getElementById('editAdvanceAmount').value) || 0;
    const bal = b - a;
    const fmt = v => '₹ ' + v.toLocaleString('en-IN',{minimumFractionDigits:2,maximumFractionDigits:2});
    document.getElementById('editSummaryTotal').textContent   = b > 0 ? fmt(b) : '₹ —';
    document.getElementById('editSummaryAdvance').textContent = b > 0 ? fmt(a) : '₹ —';
    const balEl = document.getElementById('editSummaryBalance');
    if (b > 0) { balEl.textContent = fmt(bal < 0 ? 0 : bal); balEl.style.color = bal > 0 ? 'var(--danger)' : 'var(--success)'; }
    else { balEl.textContent = '₹ —'; balEl.style.color = 'var(--danger)'; }
}
document.getElementById('editBookingForm').addEventListener('submit', function(e) {
    const v1=validateEditDate();
    const v2 = !!document.getElementById('editRouteFrom').value.trim() || (()=>{ document.getElementById('editRouteFrom').classList.add('error'); document.getElementById('eerr-route_from').classList.add('show'); return false; })();
    const v3 = !!document.getElementById('editRouteTo').value.trim()   || (()=>{ document.getElementById('editRouteTo').classList.add('error');   document.getElementById('eerr-route_to').classList.add('show');   return false; })();
    const v4 = !!document.getElementById('editBusNo').value.trim()     || (()=>{ document.getElementById('editBusNo').classList.add('error');     document.getElementById('eerr-bus_no').classList.add('show');     return false; })();
    const kmVal = parseFloat(document.getElementById('editKilometer').value) || 0;
    const v5 = kmVal >= 1 || (()=>{ document.getElementById('editKilometer').classList.add('error'); document.getElementById('eerr-kilometer').classList.add('show'); return false; })();
    const v6=validateEditPickupTime();
    const ba = parseFloat(document.getElementById('editBookingAmount').value) || 0;
    const aa = parseFloat(document.getElementById('editAdvanceAmount').value) || 0;
    let v7=true, v8=true;
    if (ba<=0) { document.getElementById('editBookingAmount').classList.add('error'); document.getElementById('eerr-booking_amount-msg').textContent='Must be > 0.'; document.getElementById('eerr-booking_amount').classList.add('show'); v7=false; } else editClearErr('editBookingAmount','eerr-booking_amount');
    if (aa<0) { document.getElementById('editAdvanceAmount').classList.add('error'); document.getElementById('eerr-advance_amount-msg').textContent='Must be 0+.'; document.getElementById('eerr-advance_amount').classList.add('show'); v8=false; }
    else if (aa>ba) { document.getElementById('editAdvanceAmount').classList.add('error'); document.getElementById('eerr-advance_amount-msg').textContent='Cannot exceed ₹'+ba.toLocaleString('en-IN')+'.'; document.getElementById('eerr-advance_amount').classList.add('show'); v8=false; }
    else editClearErr('editAdvanceAmount','eerr-advance_amount');
    if (!v1||!v2||!v3||!v4||!v5||!v6||!v7||!v8) {
        e.preventDefault();
        const f = document.querySelector('#editBookingForm .bform-input.error');
        if (f) f.scrollIntoView({behavior:'smooth',block:'center'});
    }
});

@if($errors->hasBag('editBooking') && $errors->getBag('editBooking')->any())
window.addEventListener('load', () => { showSection('mod-booking', document.querySelector('[data-section=mod-booking]')); });
@endif

// ══════════════════════════════════════════════
// MAINTENANCE — CLIENT-SIDE SEARCH + SORT
// (no page reload — stays in maintenance section)
// ══════════════════════════════════════════════

let _maintSortCol = 'date';
let _maintSortDir = 'desc';

/**
 * Read all .maint-row <tr> elements from the DOM once into an array of objects.
 * We cache the original order so we can always re-sort from scratch.
 */
function _getMaintRows() {
    return Array.from(document.querySelectorAll('#maintTbody .maint-row'));
}

/**
 * Compare helper for sorting.
 */
function _maintCompare(a, b, col, dir) {
    let av = a.dataset[col] || '';
    let bv = b.dataset[col] || '';

    // Numeric sort for amount
    if (col === 'amount') {
        av = parseFloat(av) || 0;
        bv = parseFloat(bv) || 0;
        return dir === 'asc' ? av - bv : bv - av;
    }

    // Date sort (stored as YYYY-MM-DD — lexicographic works)
    av = av.toLowerCase();
    bv = bv.toLowerCase();
    if (av < bv) return dir === 'asc' ? -1 :  1;
    if (av > bv) return dir === 'asc' ?  1 : -1;
    return 0;
}

/**
 * Main filter + sort function.
 * Called on every keystroke, every select change, and every column-header click.
 */
function maintApplyFilters() {
    const query  = (document.getElementById('maintSearchInput').value || '').toLowerCase().trim();
    const col    = document.getElementById('maintSortField').value;
    const dir    = document.getElementById('maintSortDir').value;

    _maintSortCol = col;
    _maintSortDir = dir;

    // Update sort icons in column headers
    ['date','bus','type','vendor','amount'].forEach(c => {
        const icon = document.getElementById('msi-' + c);
        if (!icon) return;
        if (c === col) {
            icon.className = 'fas fa-sort-' + (dir === 'asc' ? 'up' : 'down');
            icon.style.opacity = '1';
            icon.style.color   = 'var(--warning)';
        } else {
            icon.className    = 'fas fa-sort';
            icon.style.opacity = '.3';
            icon.style.color   = '';
        }
    });

    const rows    = _getMaintRows();
    const tbody   = document.getElementById('maintTbody');
    const noRes   = document.getElementById('maintNoResults');
    const resInfo = document.getElementById('maintResultInfo');
    const resTxt  = document.getElementById('maintResultText');

    // 1. Filter
    const visible = rows.filter(row => {
        if (!query) return true;
        const haystack = [
            row.dataset.bus,
            row.dataset.type,
            row.dataset.vendor,
            row.dataset.desc,
            row.dataset.date,
        ].join(' ');
        return haystack.includes(query);
    });

    // 2. Sort visible rows
    visible.sort((a, b) => _maintCompare(a, b, col, dir));

    // 3. Re-append in sorted order; hide non-matching
    const hiddenSet = new Set(rows.filter(r => !visible.includes(r)));
    hiddenSet.forEach(r => r.style.display = 'none');

    visible.forEach((row, idx) => {
        row.style.display = '';
        // Re-number
        const numCell = row.querySelector('.maint-row-num');
        if (numCell) numCell.textContent = idx + 1;
        tbody.appendChild(row);   // moves to end in sorted order
    });

    // 4. Show / hide no-results indicator
    if (visible.length === 0) {
        noRes.style.display = 'block';
    } else {
        noRes.style.display = 'none';
    }

    // 5. Result count info
    if (query) {
        resInfo.style.display = 'flex';
        resTxt.innerHTML = `Showing <strong style="color:var(--navy);">${visible.length}</strong> of <strong style="color:var(--navy);">${rows.length}</strong> records for "<strong style="color:var(--navy);">${query}</strong>"`;
    } else {
        resInfo.style.display = 'none';
    }
}

/**
 * Click on a column header — toggle sort direction if same col, else sort asc.
 */
function maintSortByCol(col) {
    const sortField = document.getElementById('maintSortField');
    const sortDir   = document.getElementById('maintSortDir');

    if (_maintSortCol === col) {
        // Toggle direction
        const newDir = _maintSortDir === 'asc' ? 'desc' : 'asc';
        sortDir.value = newDir;
    } else {
        sortField.value = col;
        sortDir.value   = 'asc';
    }
    maintApplyFilters();
}

/**
 * Clear all filters and reset to default (date desc).
 */
function maintClearFilters() {
    document.getElementById('maintSearchInput').value = '';
    document.getElementById('maintSortField').value   = 'date';
    document.getElementById('maintSortDir').value     = 'desc';
    maintApplyFilters();
}

// Run once on page load so sort icons initialise correctly
document.addEventListener('DOMContentLoaded', function () {
    maintApplyFilters();
});

// ══════════════════════════════════════════════
// BOOKING — CLIENT-SIDE SEARCH + SORT
// (no page reload — stays in booking section)
// ══════════════════════════════════════════════

let _bkSortCol = 'date';
let _bkSortDir = 'desc';

function _bkCompare(a, b, col, dir) {
    let av = a.dataset[col] || '';
    let bv = b.dataset[col] || '';
    // Numeric columns
    if (['km','amount','advance','balance'].includes(col)) {
        av = parseFloat(av) || 0;
        bv = parseFloat(bv) || 0;
        return dir === 'asc' ? av - bv : bv - av;
    }
    // Date (YYYY-MM-DD) and time (HH:MM) both sort correctly as strings
    av = av.toLowerCase(); bv = bv.toLowerCase();
    if (av < bv) return dir === 'asc' ? -1 :  1;
    if (av > bv) return dir === 'asc' ?  1 : -1;
    return 0;
}

function bkApply() {
    const query = (document.getElementById('bkSearchInput').value || '').toLowerCase().trim();
    const col   = document.getElementById('bkSortField').value;
    const dir   = document.getElementById('bkSortDir').value;

    _bkSortCol = col; _bkSortDir = dir;

    // Update column-header icons
    ['date','route','km','bus','amount','advance','balance','pickup'].forEach(c => {
        const icon = document.getElementById('bki-' + c);
        if (!icon) return;
        if (c === col) {
            icon.className     = 'fas fa-sort-' + (dir === 'asc' ? 'up' : 'down');
            icon.style.opacity = '1';
            icon.style.color   = 'var(--gold)';
        } else {
            icon.className     = 'fas fa-sort';
            icon.style.opacity = '.3';
            icon.style.color   = '';
        }
    });

    const rows    = Array.from(document.querySelectorAll('#bkTbody .bk-row'));
    const tbody   = document.getElementById('bkTbody');
    const noRes   = document.getElementById('bkNoResults');
    const resInfo = document.getElementById('bkResultInfo');
    const resTxt  = document.getElementById('bkResultText');

    // 1. Filter
    const visible = rows.filter(row => {
        if (!query) return true;
        const haystack = [row.dataset.date, row.dataset.bus, row.dataset.route, row.dataset.note].join(' ');
        return haystack.includes(query);
    });

    // 2. Sort
    visible.sort((a, b) => _bkCompare(a, b, col, dir));

    // 3. Apply to DOM
    new Set(rows.filter(r => !visible.includes(r))).forEach(r => r.style.display = 'none');
    visible.forEach((row, idx) => {
        row.style.display = '';
        const cell = row.querySelector('.bk-num');
        if (cell) cell.textContent = idx + 1;
        tbody.appendChild(row);
    });

    // 4. No-results
    noRes.style.display = visible.length === 0 ? 'block' : 'none';

    // 5. Result count
    if (query) {
        resInfo.style.display = 'flex';
        resTxt.innerHTML = `Showing <strong style="color:var(--navy);">${visible.length}</strong> of <strong style="color:var(--navy);">${rows.length}</strong> bookings for "<strong style="color:var(--navy);">${query}</strong>"`;
    } else {
        resInfo.style.display = 'none';
    }
}

function bkSortCol(col) {
    const sf = document.getElementById('bkSortField');
    const sd = document.getElementById('bkSortDir');
    if (_bkSortCol === col) {
        sd.value = _bkSortDir === 'asc' ? 'desc' : 'asc';
    } else {
        sf.value = col; sd.value = 'asc';
    }
    bkApply();
}

function bkClear() {
    document.getElementById('bkSearchInput').value = '';
    document.getElementById('bkSortField').value   = 'date';
    document.getElementById('bkSortDir').value     = 'desc';
    bkApply();
}

document.addEventListener('DOMContentLoaded', () => bkApply());

// ══════════════════════════════════════════════
// BILLING — CLIENT-SIDE SEARCH + SORT
// (no page reload — stays in billing section)
// ══════════════════════════════════════════════

let _blSortCol = 'date';
let _blSortDir = 'desc';

function _blCompare(a, b, col, dir) {
    let av = a.dataset[col] || '';
    let bv = b.dataset[col] || '';
    // Numeric columns
    if (['ref','bookingamt','expenses','profit'].includes(col)) {
        av = parseFloat(av) || 0;
        bv = parseFloat(bv) || 0;
        return dir === 'asc' ? av - bv : bv - av;
    }
    av = av.toLowerCase(); bv = bv.toLowerCase();
    if (av < bv) return dir === 'asc' ? -1 :  1;
    if (av > bv) return dir === 'asc' ?  1 : -1;
    return 0;
}

function blApply() {
    const query = (document.getElementById('blSearchInput').value || '').toLowerCase().trim();
    const col   = document.getElementById('blSortField').value;
    const dir   = document.getElementById('blSortDir').value;

    _blSortCol = col; _blSortDir = dir;

    // Update column-header icons — accent green to match billing theme
    ['ref','route','bus','date','driver','bookingamt','expenses','profit'].forEach(c => {
        const icon = document.getElementById('bli-' + c);
        if (!icon) return;
        if (c === col) {
            icon.className     = 'fas fa-sort-' + (dir === 'asc' ? 'up' : 'down');
            icon.style.opacity = '1';
            icon.style.color   = '#15803d';
        } else {
            icon.className     = 'fas fa-sort';
            icon.style.opacity = '.3';
            icon.style.color   = '';
        }
    });

    const rows    = Array.from(document.querySelectorAll('#blTbody .bl-row'));
    const tbody   = document.getElementById('blTbody');
    const noRes   = document.getElementById('blNoResults');
    const resInfo = document.getElementById('blResultInfo');
    const resTxt  = document.getElementById('blResultText');

    // 1. Filter — also match booking ref "bk-0001" pattern
    const visible = rows.filter(row => {
        if (!query) return true;
        const refStr = 'bk-' + String(row.dataset.ref).padStart(4, '0');
        const haystack = [row.dataset.date, row.dataset.bus, row.dataset.route, row.dataset.driver, refStr].join(' ');
        return haystack.includes(query);
    });

    // 2. Sort
    visible.sort((a, b) => _blCompare(a, b, col, dir));

    // 3. Apply to DOM
    new Set(rows.filter(r => !visible.includes(r))).forEach(r => r.style.display = 'none');
    visible.forEach((row, idx) => {
        row.style.display = '';
        const cell = row.querySelector('.bl-num');
        if (cell) cell.textContent = idx + 1;
        tbody.appendChild(row);
    });

    // 4. No-results
    noRes.style.display = visible.length === 0 ? 'block' : 'none';

    // 5. Result count
    if (query) {
        resInfo.style.display = 'flex';
        resTxt.innerHTML = `Showing <strong style="color:var(--navy);">${visible.length}</strong> of <strong style="color:var(--navy);">${rows.length}</strong> records for "<strong style="color:var(--navy);">${query}</strong>"`;
    } else {
        resInfo.style.display = 'none';
    }
}

function blSortCol(col) {
    const sf = document.getElementById('blSortField');
    const sd = document.getElementById('blSortDir');
    if (_blSortCol === col) {
        sd.value = _blSortDir === 'asc' ? 'desc' : 'asc';
    } else {
        sf.value = col; sd.value = 'asc';
    }
    blApply();
}

function blClear() {
    document.getElementById('blSearchInput').value = '';
    document.getElementById('blSortField').value   = 'date';
    document.getElementById('blSortDir').value     = 'desc';
    blApply();
}

document.addEventListener('DOMContentLoaded', () => blApply());

// ══════════════════════════════════════════════
// MAINTENANCE MODALS
// ══════════════════════════════════════════════
function openMaintenanceModal() {
    document.getElementById('maintModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMaintenanceModal() {
    document.getElementById('maintModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('maintModal').addEventListener('click', function(e) { if (e.target === this) closeMaintenanceModal(); });

/**
 * Show/hide the custom-type text field when "Other" is selected.
 * @param {string} wrapId  - id of the wrapper div
 * @param {string} value   - current select value
 */
function toggleMaintCustomType(wrapId, value) {
    const wrap = document.getElementById(wrapId);
    if (!wrap) return;
    if (value === 'Other') {
        wrap.style.display = 'flex';
    } else {
        wrap.style.display = 'none';
        // Clear the custom input when hidden
        const input = wrap.querySelector('input[name="custom_type"]');
        if (input) input.value = '';
    }
}

/**
 * Preview an uploaded image in the maintenance modal.
 */
function previewMaintFile(input, previewDivId, nameSpanId, labelId) {
    const previewDiv = document.getElementById(previewDivId);
    const nameSpan   = document.getElementById(nameSpanId);
    const label      = document.getElementById(labelId);

    if (!input.files || !input.files[0]) return;
    const file = input.files[0];

    // Show filename
    if (nameSpan) { nameSpan.textContent = file.name.length > 22 ? file.name.slice(0,20)+'…' : file.name; nameSpan.style.display = 'block'; }

    // Show image thumbnail (images only — PDFs show icon)
    if (previewDiv) {
        const thumbId = previewDivId.replace('Preview', 'ImgThumb')
                     || previewDivId.replace('ImagePreview', 'ImgThumb');
        // derive thumb id from pattern: e.g. tierImagePreview → tierImgThumb
        let thumb = null;
        if (previewDivId === 'tierImagePreview')     thumb = document.getElementById('tierImgThumb');
        if (previewDivId === 'billImagePreview')     thumb = document.getElementById('billImgThumb');
        if (previewDivId === 'editTierImagePreview') thumb = document.getElementById('editTierImgThumb');
        if (previewDivId === 'editBillImagePreview') thumb = document.getElementById('editBillImgThumb');

        if (thumb && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = e => { thumb.src = e.target.result; thumb.style.display = 'block'; };
            reader.readAsDataURL(file);
        } else if (thumb) {
            // PDF: show generic icon
            thumb.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"><rect width="60" height="60" rx="8" fill="%23fee2e2"/><text x="30" y="38" text-anchor="middle" font-size="24" fill="%23dc2626">PDF</text></svg>';
            thumb.style.display = 'block';
        }
        previewDiv.style.display = 'block';
    }
    // Dim the label to indicate file selected
    if (label) label.style.opacity = '0.7';
}

/**
 * Clear a file input and reset its preview.
 */
function clearMaintFile(inputId, previewDivId, nameSpanId, labelId) {
    const input = document.getElementById(inputId);
    if (input) { input.value = ''; }
    const previewDiv = document.getElementById(previewDivId);
    if (previewDiv) previewDiv.style.display = 'none';
    const nameSpan = document.getElementById(nameSpanId);
    if (nameSpan) { nameSpan.textContent = ''; nameSpan.style.display = 'none'; }
    const label = document.getElementById(labelId);
    if (label) label.style.opacity = '1';
}

function openEditMaintenanceModal(id, date, busNo, type, customType, vendor, description, amount, tierImageUrl, billImageUrl) {
    document.getElementById('editMaintForm').action = '/manager/maintenance/' + id;
    document.getElementById('editMaintDate').value    = date;
    document.getElementById('editMaintBusNo').value   = busNo;
    document.getElementById('editMaintAmount').value  = amount;
    document.getElementById('editMaintVendor').value  = vendor || '';
    document.getElementById('editMaintDesc').value    = description || '';
    document.getElementById('editMaintSubtitle').textContent = 'Editing Maintenance Record #' + id;

    // Set type select
    const typeSelect = document.getElementById('editMaintType');
    typeSelect.value = type;
    toggleMaintCustomType('editMaintCustomTypeWrap', type);

    // Set custom type if "Other"
    const customInput = document.getElementById('editMaintCustomType');
    if (customInput) customInput.value = customType || '';

    // Show existing tier image thumbnail
    const tierWrap  = document.getElementById('editExistingTierWrap');
    const tierThumb = document.getElementById('editExistingTierThumb');
    const tierLink  = document.getElementById('editExistingTierLink');
    if (tierImageUrl) {
        tierThumb.src  = tierImageUrl;
        tierLink.href  = tierImageUrl;
        tierWrap.style.display = 'block';
    } else {
        tierWrap.style.display = 'none';
    }

    // Show existing bill image thumbnail
    const billWrap  = document.getElementById('editExistingBillWrap');
    const billThumb = document.getElementById('editExistingBillThumb');
    const billLink  = document.getElementById('editExistingBillLink');
    if (billImageUrl) {
        billThumb.src  = billImageUrl;
        billLink.href  = billImageUrl;
        billWrap.style.display = 'block';
    } else {
        billWrap.style.display = 'none';
    }

    // Reset new-upload previews
    clearMaintFile('editTierImageInput', 'editTierImagePreview', 'editTierImageName', 'editTierImageLabel');
    clearMaintFile('editBillImageInput', 'editBillImagePreview', 'editBillImageName', 'editBillImageLabel');

    document.getElementById('editMaintModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEditMaintenanceModal() {
    document.getElementById('editMaintModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('editMaintModal').addEventListener('click', function(e) { if (e.target === this) closeEditMaintenanceModal(); });

// Auto-open maintenance section on success or errors
@if(session('maintenance_success'))
window.addEventListener('load', () => {
    showSection('mod-maintenance', document.querySelector('[data-section=mod-maintenance]'));
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = @json(session('maintenance_success'));
    t.style.background = '#78350f';
    document.querySelector('#toast i').className = 'fas fa-screwdriver-wrench';
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 5000);
});
@endif
@if($errors->hasBag('maintenance') && $errors->getBag('maintenance')->any())
window.addEventListener('load', () => {
    showSection('mod-maintenance', document.querySelector('[data-section=mod-maintenance]'));
    openMaintenanceModal();
});
@endif
@if($errors->hasBag('editMaintenance') && $errors->getBag('editMaintenance')->any())
window.addEventListener('load', () => { showSection('mod-maintenance', document.querySelector('[data-section=mod-maintenance]')); });
@endif

// ══════════════════════════════════════════════
// BILLING MODULE JS
// ══════════════════════════════════════════════
const bookingAmounts = {
    @foreach($busBookings as $bk)
    {{ $bk->id }}: { amount: {{ $bk->booking_amount }}, route: "{{ $bk->route_from }} → {{ $bk->route_to }}", km: {{ $bk->kilometer }} },
    @endforeach
};

function bpFmt(v) {
    return '₹ ' + parseFloat(v || 0).toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2});
}

function openBillingModal() { document.getElementById('billingModal').classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeBillingModal() { document.getElementById('billingModal').classList.remove('open'); document.body.style.overflow = ''; }
document.getElementById('billingModal').addEventListener('click', function(e) { if (e.target === this) closeBillingModal(); });

function updateBillingBookingInfo(sel) {
    const id = parseInt(sel.value);
    const inf = document.getElementById('billingBookingInfo');
    const txt = document.getElementById('billingInfoText');
    if (id && bookingAmounts[id]) {
        const bk = bookingAmounts[id];
        txt.textContent = bk.route + ' — ' + bk.km + ' km — ₹' + parseFloat(bk.amount).toLocaleString('en-IN', {minimumFractionDigits:2});
        inf.style.display = 'block';
    } else { inf.style.display = 'none'; }
    updateBillingProfit();
}

function updateBillingProfit() {
    const selId = parseInt(document.getElementById('billingBookingId').value) || 0;
    const bkAmt = selId && bookingAmounts[selId] ? parseFloat(bookingAmounts[selId].amount) : 0;
    const exp = (parseFloat(document.getElementById('billingDiesel').value)   || 0)
              + (parseFloat(document.getElementById('billingToll').value)      || 0)
              + (parseFloat(document.getElementById('billingPermit').value)    || 0)
              + (parseFloat(document.getElementById('billingDriverAmt').value) || 0)
              + (parseFloat(document.getElementById('billingOther').value)     || 0);
    const profit = bkAmt - exp;
    document.getElementById('bpBookingAmt').textContent = bkAmt > 0 ? bpFmt(bkAmt) : '₹ —';
    document.getElementById('bpTotalExp').textContent   = exp  > 0 ? bpFmt(exp)    : '₹ —';
    const profEl = document.getElementById('bpNetProfit');
    profEl.textContent = bkAmt > 0 ? bpFmt(profit) : '₹ —';
    profEl.style.color = profit >= 0 ? 'var(--success)' : 'var(--danger)';
}

document.getElementById('billingForm').addEventListener('submit', function(e) {
    const sel = document.getElementById('billingBookingId');
    const err = document.getElementById('berr-bus_booking_id');
    if (!sel.value) { sel.classList.add('error'); err.classList.add('show'); e.preventDefault(); return; }
    sel.classList.remove('error'); err.classList.remove('show');
});

let editBillingBookingAmount = 0;

function openEditBillingModal(id, bookingId, rateKm, diesel, toll, permit, driverAmt, other, driverName, driverMobile, description) {
    document.getElementById('editBillingForm').action = '/manager/billing/' + id;
    document.getElementById('editBillingBookingId').value    = bookingId;
    document.getElementById('editBillingRateKm').value       = rateKm     || '';
    document.getElementById('editBillingDiesel').value       = diesel     || '';
    document.getElementById('editBillingToll').value         = toll       || '';
    document.getElementById('editBillingPermit').value       = permit     || '';
    document.getElementById('editBillingDriverAmt').value    = driverAmt  || '';
    document.getElementById('editBillingOther').value        = other      || '';
    document.getElementById('editBillingDriverName').value   = driverName   || '';
    document.getElementById('editBillingDriverMobile').value = driverMobile || '';
    document.getElementById('editBillingDesc').value         = description  || '';
    document.getElementById('editBillingSubtitle').textContent = 'Editing Billing Record #' + id;
    if (bookingAmounts[bookingId]) {
        const bk = bookingAmounts[bookingId];
        editBillingBookingAmount = parseFloat(bk.amount);
        document.getElementById('editBillingInfoText').textContent =
            '#BK-' + String(bookingId).padStart(4,'0') + ' — ' + bk.route + ' — ' + bk.km + ' km — ₹' +
            parseFloat(bk.amount).toLocaleString('en-IN', {minimumFractionDigits:2});
    } else {
        editBillingBookingAmount = 0;
        document.getElementById('editBillingInfoText').textContent = 'Booking #' + bookingId;
    }
    updateEditBillingProfit();
    document.getElementById('editBillingModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEditBillingModal() { document.getElementById('editBillingModal').classList.remove('open'); document.body.style.overflow = ''; }
document.getElementById('editBillingModal').addEventListener('click', function(e) { if (e.target === this) closeEditBillingModal(); });

function updateEditBillingProfit() {
    const exp = (parseFloat(document.getElementById('editBillingDiesel').value)   || 0)
              + (parseFloat(document.getElementById('editBillingToll').value)      || 0)
              + (parseFloat(document.getElementById('editBillingPermit').value)    || 0)
              + (parseFloat(document.getElementById('editBillingDriverAmt').value) || 0)
              + (parseFloat(document.getElementById('editBillingOther').value)     || 0);
    const profit = editBillingBookingAmount - exp;
    document.getElementById('ebpBookingAmt').textContent = editBillingBookingAmount > 0 ? bpFmt(editBillingBookingAmount) : '₹ —';
    document.getElementById('ebpTotalExp').textContent   = exp > 0 ? bpFmt(exp) : '₹ —';
    const profEl = document.getElementById('ebpNetProfit');
    profEl.textContent = editBillingBookingAmount > 0 ? bpFmt(profit) : '₹ —';
    profEl.style.color = profit >= 0 ? 'var(--success)' : 'var(--danger)';
}

@if($errors->hasBag('editBilling') && $errors->getBag('editBilling')->any())
window.addEventListener('load', () => { showSection('mod-billing', document.querySelector('[data-section=mod-billing]')); });
@endif
@if(session('billing_success'))
window.addEventListener('load', () => {
    showSection('mod-billing', document.querySelector('[data-section=mod-billing]'));
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = @json(session('billing_success'));
    t.style.background = '#1a4731';
    document.querySelector('#toast i').className = 'fas fa-file-invoice-dollar';
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 5000);
});
@endif

// ══════════════════════════════════════════════
// INSURANCE MODULE — MODAL OPEN / CLOSE
// ══════════════════════════════════════════════

function openTaxModal() {
    document.getElementById('taxModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeTaxModal() {
    document.getElementById('taxModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('taxModal').addEventListener('click', function(e) {
    if (e.target === this) closeTaxModal();
});

/**
 * Populate and open Edit Tax modal.
 * @param {number} id          — record ID
 * @param {string} date        — YYYY-MM-DD payment date
 * @param {string} bus         — bus_number
 * @param {string} from        — YYYY-MM-DD tax_from
 * @param {string} to          — YYYY-MM-DD tax_to
 * @param {number} amount      — amount paid
 * @param {string} notes       — optional notes
 * @param {string} imageUrl    — existing receipt URL or empty string
 */
function openEditTaxModal(id, date, bus, from, to, amount, notes, imageUrl) {
    document.getElementById('editTaxForm').action = '/manager/tax/' + id;
    document.getElementById('editTaxDate').value   = date;
    document.getElementById('editTaxBus').value    = bus;
    document.getElementById('editTaxFrom').value   = from;
    document.getElementById('editTaxTo').value     = to;
    document.getElementById('editTaxAmount').value = amount;
    document.getElementById('editTaxNotes').value  = notes || '';
    document.getElementById('editTaxSubtitle').textContent = 'Editing record #' + id + ' — ' + bus;

    const existWrap = document.getElementById('editTaxExistingImg');
    if (imageUrl) {
        existWrap.style.display = 'block';
        document.getElementById('editTaxImgLink').href = imageUrl;
    } else {
        existWrap.style.display = 'none';
    }
    insClearFile('editTaxImgInput', 'editTaxImgPreview', 'editTaxImgName');

    document.getElementById('editTaxModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEditTaxModal() {
    document.getElementById('editTaxModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('editTaxModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditTaxModal();
});

/**
 * When "Tax Valid From" changes, auto-set "Tax Valid To" to exactly 1 year minus 1 day.
 * e.g. From 2025-04-01 → To 2026-03-31
 */
function taxAutoSetTo() {
    const fromVal = document.getElementById('taxFromDate').value;
    if (!fromVal) return;
    const d = new Date(fromVal);
    d.setFullYear(d.getFullYear() + 1);
    d.setDate(d.getDate() - 1);
    const yyyy = d.getFullYear();
    const mm   = String(d.getMonth() + 1).padStart(2, '0');
    const dd   = String(d.getDate()).padStart(2, '0');
    document.getElementById('taxToDate').value = `${yyyy}-${mm}-${dd}`;
}

function openInsuranceModal() {
    document.getElementById('insuranceModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeInsuranceModal() {
    document.getElementById('insuranceModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('insuranceModal').addEventListener('click', function(e) {
    if (e.target === this) closeInsuranceModal();
});

/**
 * Populate and open Edit Insurance modal.
 */
function openEditInsuranceModal(id, date, bus, amount, notes) {
    document.getElementById('editInsuranceForm').action = '/manager/insurance/' + id;
    document.getElementById('editInsDate').value   = date;
    document.getElementById('editInsBus').value    = bus;
    document.getElementById('editInsAmount').value = amount;
    document.getElementById('editInsNotes').value  = notes || '';
    document.getElementById('editInsSubtitle').textContent = 'Editing record #' + id + ' — ' + bus;
    document.getElementById('editInsuranceModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEditInsuranceModal() {
    document.getElementById('editInsuranceModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('editInsuranceModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditInsuranceModal();
});

// ── Shared file-preview helpers for insurance modals ──
function insPreviewFile(input, previewId, nameId, thumbId) {
    const file = input.files[0];
    if (!file) return;
    const nameEl = document.getElementById(nameId);
    if (nameEl) { nameEl.textContent = file.name; nameEl.style.display = 'block'; }
    const preview = document.getElementById(previewId);
    if (!preview) return;
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            const thumb = document.getElementById(thumbId);
            if (thumb) thumb.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        // PDF — show remove button only (no thumbnail)
        preview.style.display = 'block';
    }
}
function insClearFile(inputId, previewId, nameId) {
    const inp  = document.getElementById(inputId);
    const prev = document.getElementById(previewId);
    const nm   = document.getElementById(nameId);
    if (inp)  inp.value = '';
    if (prev) prev.style.display = 'none';
    if (nm)   { nm.textContent = ''; nm.style.display = 'none'; }
}

// ══════════════════════════════════════════════
// TAX — CLIENT-SIDE SEARCH + SORT
// (mirrors exactly the maintApplyFilters pattern)
// ══════════════════════════════════════════════

let _taxSortCol = 'taxdate';
let _taxSortDir = 'desc';

function _getTaxRows() {
    return Array.from(document.querySelectorAll('#taxTbody .tax-row'));
}

function _taxCompare(a, b, col, dir) {
    let av = a.dataset[col] || '';
    let bv = b.dataset[col] || '';
    // Numeric sort for amount
    if (col === 'amount') {
        av = parseFloat(av) || 0;
        bv = parseFloat(bv) || 0;
        return dir === 'asc' ? av - bv : bv - av;
    }
    // Date / string — YYYY-MM-DD sorts lexicographically
    av = av.toLowerCase(); bv = bv.toLowerCase();
    if (av < bv) return dir === 'asc' ? -1 :  1;
    if (av > bv) return dir === 'asc' ?  1 : -1;
    return 0;
}

function taxApplyFilters() {
    const query = (document.getElementById('taxSearchInput').value || '').toLowerCase().trim();
    const col   = document.getElementById('taxSortField').value;
    const dir   = document.getElementById('taxSortDir').value;

    _taxSortCol = col;
    _taxSortDir = dir;

    // Update sort icons in column headers
    ['taxdate','bus','taxfrom','taxto','amount'].forEach(c => {
        const icon = document.getElementById('txi-' + c);
        if (!icon) return;
        if (c === col) {
            icon.className     = 'fas fa-sort-' + (dir === 'asc' ? 'up' : 'down');
            icon.style.opacity = '1';
            icon.style.color   = '#0891b2';
        } else {
            icon.className     = 'fas fa-sort';
            icon.style.opacity = '.3';
            icon.style.color   = '';
        }
    });

    const rows    = _getTaxRows();
    const tbody   = document.getElementById('taxTbody');
    const noRes   = document.getElementById('taxNoResults');
    const resInfo = document.getElementById('taxResultInfo');
    const resTxt  = document.getElementById('taxResultText');

    // 1. Filter
    const visible = rows.filter(row => {
        if (!query) return true;
        const haystack = [
            row.dataset.bus,
            row.dataset.notes,
            row.dataset.taxdate,
            row.dataset.taxfrom,
            row.dataset.taxto,
        ].join(' ');
        return haystack.includes(query);
    });

    // 2. Sort
    visible.sort((a, b) => _taxCompare(a, b, col, dir));

    // 3. Re-append in sorted order; hide non-matching
    const hiddenSet = new Set(rows.filter(r => !visible.includes(r)));
    hiddenSet.forEach(r => r.style.display = 'none');
    visible.forEach((row, idx) => {
        row.style.display = '';
        const numCell = row.querySelector('.tax-row-num');
        if (numCell) numCell.textContent = idx + 1;
        tbody.appendChild(row);
    });

    // 4. No-results indicator
    noRes.style.display = visible.length === 0 ? 'block' : 'none';

    // 5. Result count
    if (query) {
        resInfo.style.display = 'flex';
        resTxt.innerHTML = `Showing <strong style="color:var(--navy);">${visible.length}</strong> of <strong style="color:var(--navy);">${rows.length}</strong> tax records for "<strong style="color:var(--navy);">${query}</strong>"`;
    } else {
        resInfo.style.display = 'none';
    }
}

function taxSortByCol(col) {
    const sortField = document.getElementById('taxSortField');
    const sortDir   = document.getElementById('taxSortDir');
    if (_taxSortCol === col) {
        sortDir.value = _taxSortDir === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = col;
        sortDir.value   = 'asc';
    }
    taxApplyFilters();
}

function taxClearFilters() {
    document.getElementById('taxSearchInput').value = '';
    document.getElementById('taxSortField').value   = 'taxdate';
    document.getElementById('taxSortDir').value     = 'desc';
    taxApplyFilters();
}

document.addEventListener('DOMContentLoaded', function () {
    taxApplyFilters();
});

// ══════════════════════════════════════════════
// INSURANCE — CLIENT-SIDE SEARCH + SORT
// (mirrors exactly the maintApplyFilters pattern)
// ══════════════════════════════════════════════

let _insSortCol = 'insdate';
let _insSortDir = 'desc';

function _getInsRows() {
    return Array.from(document.querySelectorAll('#insTbody .ins-row'));
}

function _insCompare(a, b, col, dir) {
    let av = a.dataset[col] || '';
    let bv = b.dataset[col] || '';
    if (col === 'amount') {
        av = parseFloat(av) || 0;
        bv = parseFloat(bv) || 0;
        return dir === 'asc' ? av - bv : bv - av;
    }
    av = av.toLowerCase(); bv = bv.toLowerCase();
    if (av < bv) return dir === 'asc' ? -1 :  1;
    if (av > bv) return dir === 'asc' ?  1 : -1;
    return 0;
}

function insApplyFilters() {
    const query = (document.getElementById('insSearchInput').value || '').toLowerCase().trim();
    const col   = document.getElementById('insSortField').value;
    const dir   = document.getElementById('insSortDir').value;

    _insSortCol = col;
    _insSortDir = dir;

    ['insdate','bus','amount'].forEach(c => {
        const icon = document.getElementById('ini-' + c);
        if (!icon) return;
        if (c === col) {
            icon.className     = 'fas fa-sort-' + (dir === 'asc' ? 'up' : 'down');
            icon.style.opacity = '1';
            icon.style.color   = '#4f46e5';
        } else {
            icon.className     = 'fas fa-sort';
            icon.style.opacity = '.3';
            icon.style.color   = '';
        }
    });

    const rows    = _getInsRows();
    const tbody   = document.getElementById('insTbody');
    const noRes   = document.getElementById('insNoResults');
    const resInfo = document.getElementById('insResultInfo');
    const resTxt  = document.getElementById('insResultText');

    const visible = rows.filter(row => {
        if (!query) return true;
        const haystack = [
            row.dataset.bus,
            row.dataset.notes,
            row.dataset.insdate,
        ].join(' ');
        return haystack.includes(query);
    });

    visible.sort((a, b) => _insCompare(a, b, col, dir));

    const hiddenSet = new Set(rows.filter(r => !visible.includes(r)));
    hiddenSet.forEach(r => r.style.display = 'none');
    visible.forEach((row, idx) => {
        row.style.display = '';
        const numCell = row.querySelector('.ins-row-num');
        if (numCell) numCell.textContent = idx + 1;
        tbody.appendChild(row);
    });

    noRes.style.display = visible.length === 0 ? 'block' : 'none';

    if (query) {
        resInfo.style.display = 'flex';
        resTxt.innerHTML = `Showing <strong style="color:var(--navy);">${visible.length}</strong> of <strong style="color:var(--navy);">${rows.length}</strong> insurance records for "<strong style="color:var(--navy);">${query}</strong>"`;
    } else {
        resInfo.style.display = 'none';
    }
}

function insSortByCol(col) {
    const sortField = document.getElementById('insSortField');
    const sortDir   = document.getElementById('insSortDir');
    if (_insSortCol === col) {
        sortDir.value = _insSortDir === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = col;
        sortDir.value   = 'asc';
    }
    insApplyFilters();
}

function insClearFilters() {
    document.getElementById('insSearchInput').value = '';
    document.getElementById('insSortField').value   = 'insdate';
    document.getElementById('insSortDir').value     = 'desc';
    insApplyFilters();
}

document.addEventListener('DOMContentLoaded', function () {
    insApplyFilters();
});

// ── Auto-return to insurance section on form errors / success ──
@if($errors->hasBag('tax') || $errors->hasBag('editTax') || session('tax_success') || $errors->hasBag('insurance') || $errors->hasBag('editInsurance') || session('insurance_success'))
window.addEventListener('load', () => {
    showSection('mod-insurance', document.querySelector('[data-section=mod-insurance]'));
});
@endif

</script>

{{-- ══════════════ NEW TAX MODAL ══════════════ --}}
<div class="ins-modal-overlay" id="taxModal">
    <div class="ins-modal">
        <div class="ins-modal-header tax-hdr">
            <div>
                <h3><i class="fas fa-receipt" style="margin-right:8px; color:rgba(255,255,255,.85);"></i>Add Tax Record</h3>
                <p>Log a road tax payment for a vehicle</p>
            </div>
            <button class="ins-modal-close" onclick="closeTaxModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form action="{{ route('manager.tax.store') }}" method="POST"
              enctype="multipart/form-data" novalidate>
            @csrf
            <div class="ins-modal-body">
                <div class="imod-grid">

                    {{-- Payment Date --}}
                    <div class="imod-group">
                        <label class="imod-label">Payment Date <span class="req">*</span></label>
                        <input type="date" name="tax_date" class="imod-input tax-input"
                               value="{{ old('tax_date', date('Y-m-d')) }}" required>
                    </div>

                    {{-- Bus Number --}}
                    <div class="imod-group">
                        <label class="imod-label">Bus Number <span class="req">*</span></label>
                        <input type="text" name="bus_number" class="imod-input tax-input"
                               placeholder="e.g. MH12AB1234"
                               style="text-transform:uppercase;"
                               oninput="this.value=this.value.toUpperCase();"
                               value="{{ old('bus_number') }}" required>
                    </div>

                    {{-- Tax Valid From --}}
                    <div class="imod-group">
                        <label class="imod-label">Tax Valid From <span class="req">*</span></label>
                        <input type="date" name="tax_from" id="taxFromDate"
                               class="imod-input tax-input"
                               value="{{ old('tax_from') }}" required
                               onchange="taxAutoSetTo()">
                    </div>

                    {{-- Tax Valid To --}}
                    <div class="imod-group">
                        <label class="imod-label">Tax Valid To <span class="req">*</span></label>
                        <input type="date" name="tax_to" id="taxToDate"
                               class="imod-input tax-input"
                               value="{{ old('tax_to') }}" required>
                        <span class="imod-hint">
                            <i class="fas fa-circle-info" style="color:#0891b2;"></i>
                            Auto-filled to +1 year from start date
                        </span>
                    </div>

                    {{-- Amount --}}
                    <div class="imod-group">
                        <label class="imod-label">Amount Paid (₹) <span class="req">*</span></label>
                        <div class="imod-prefix-wrap">
                            <span class="imod-prefix">₹</span>
                            <input type="number" name="amount" class="imod-input tax-input"
                                   placeholder="0.00" min="0" step="0.01"
                                   value="{{ old('amount') }}" required>
                        </div>
                    </div>

                    {{-- Receipt Image --}}
                    <div class="imod-group">
                        <label class="imod-label">Receipt / Document</label>
                        <label id="taxImgLabel"
                               style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
                                      border:2px dashed #d1d5db; border-radius:10px; padding:14px 10px;
                                      background:#f8fafc; cursor:pointer; transition:border-color .2s, background .2s; min-height:86px;"
                               onmouseover="this.style.borderColor='#0891b2'; this.style.background='#ecfeff';"
                               onmouseout="this.style.borderColor='#d1d5db'; this.style.background='#f8fafc';">
                            <i class="fas fa-cloud-arrow-up" style="font-size:19px; color:#0891b2;"></i>
                            <span style="font-size:12px; color:var(--text-muted); text-align:center;">JPG / PNG / PDF — max 5 MB</span>
                            <span id="taxImgName" style="font-size:11px; color:var(--navy); font-weight:600; display:none;"></span>
                            <input type="file" name="tax_image" id="taxImgInput"
                                   accept="image/*,.pdf" style="display:none;"
                                   onchange="insPreviewFile(this,'taxImgPreview','taxImgName','taxImgThumb')">
                        </label>
                        <div id="taxImgPreview" style="display:none; margin-top:6px; text-align:center;">
                            <img id="taxImgThumb" src=""
                                 style="max-width:100%; max-height:70px; border-radius:8px; border:1.5px solid #e2e8f0; object-fit:cover;">
                            <button type="button"
                                    onclick="insClearFile('taxImgInput','taxImgPreview','taxImgName')"
                                    style="display:block; margin:5px auto 0; background:rgba(224,85,85,.1); color:var(--danger); border:none; border-radius:6px; padding:3px 10px; font-size:11px; cursor:pointer;">
                                <i class="fas fa-xmark"></i> Remove
                            </button>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="imod-group imod-full">
                        <label class="imod-label">Notes</label>
                        <textarea name="notes" class="imod-input tax-input" rows="2"
                                  style="resize:vertical;"
                                  placeholder="Any additional notes…">{{ old('notes') }}</textarea>
                    </div>

                </div>
            </div>
            <div class="ins-modal-footer">
                <button type="button" class="btn-outline" onclick="closeTaxModal()">
                    <i class="fas fa-xmark"></i> Cancel
                </button>
                <button type="submit" class="btn-primary"
                        style="background:linear-gradient(135deg,#0e7490,#0891b2);">
                    <i class="fas fa-floppy-disk"></i> Save Tax Record
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ EDIT TAX MODAL ══════════════ --}}
<div class="ins-modal-overlay" id="editTaxModal">
    <div class="ins-modal">
        <div class="ins-modal-header tax-hdr" style="background:linear-gradient(135deg,#0c4f5e,#0e7490);">
            <div>
                <h3><i class="fas fa-pen-to-square" style="margin-right:8px; color:rgba(255,255,255,.85);"></i>Edit Tax Record</h3>
                <p id="editTaxSubtitle">Update tax details</p>
            </div>
            <button class="ins-modal-close" onclick="closeEditTaxModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form id="editTaxForm" method="POST" enctype="multipart/form-data" novalidate>
            @csrf @method('PUT')
            <div class="ins-modal-body">
                <div class="imod-grid">

                    <div class="imod-group">
                        <label class="imod-label">Payment Date <span class="req">*</span></label>
                        <input type="date" name="tax_date" id="editTaxDate"
                               class="imod-input tax-input" required>
                    </div>

                    <div class="imod-group">
                        <label class="imod-label">Bus Number <span class="req">*</span></label>
                        <input type="text" name="bus_number" id="editTaxBus"
                               class="imod-input tax-input"
                               style="text-transform:uppercase;"
                               oninput="this.value=this.value.toUpperCase();" required>
                    </div>

                    <div class="imod-group">
                        <label class="imod-label">Tax Valid From <span class="req">*</span></label>
                        <input type="date" name="tax_from" id="editTaxFrom"
                               class="imod-input tax-input" required>
                    </div>

                    <div class="imod-group">
                        <label class="imod-label">Tax Valid To <span class="req">*</span></label>
                        <input type="date" name="tax_to" id="editTaxTo"
                               class="imod-input tax-input" required>
                    </div>

                    <div class="imod-group">
                        <label class="imod-label">Amount Paid (₹) <span class="req">*</span></label>
                        <div class="imod-prefix-wrap">
                            <span class="imod-prefix">₹</span>
                            <input type="number" name="amount" id="editTaxAmount"
                                   class="imod-input tax-input"
                                   placeholder="0.00" min="0" step="0.01" required>
                        </div>
                    </div>

                    <div class="imod-group">
                        <label class="imod-label">Replace Receipt Image</label>
                        <div id="editTaxExistingImg" style="display:none; margin-bottom:8px;">
                            <span style="font-size:11px; color:var(--text-muted);">Current:</span>
                            <a id="editTaxImgLink" href="#" target="_blank"
                               style="display:inline-flex; align-items:center; gap:4px; background:rgba(8,145,178,.09); color:#0891b2; padding:3px 10px; border-radius:6px; font-size:11px; font-weight:600; text-decoration:none; margin-left:6px;">
                                <i class="fas fa-file-image"></i> View
                            </a>
                        </div>
                        <label id="editTaxImgLabel"
                               style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:5px;
                                      border:2px dashed #d1d5db; border-radius:10px; padding:12px 10px;
                                      background:#f8fafc; cursor:pointer; transition:border-color .2s, background .2s; min-height:76px;"
                               onmouseover="this.style.borderColor='#0891b2'; this.style.background='#ecfeff';"
                               onmouseout="this.style.borderColor='#d1d5db'; this.style.background='#f8fafc';">
                            <i class="fas fa-cloud-arrow-up" style="font-size:17px; color:#0891b2;"></i>
                            <span style="font-size:11.5px; color:var(--text-muted); text-align:center;">Upload new to replace</span>
                            <span id="editTaxImgName" style="font-size:11px; color:var(--navy); font-weight:600; display:none;"></span>
                            <input type="file" name="tax_image" id="editTaxImgInput"
                                   accept="image/*,.pdf" style="display:none;"
                                   onchange="insPreviewFile(this,'editTaxImgPreview','editTaxImgName','editTaxImgThumb')">
                        </label>
                        <div id="editTaxImgPreview" style="display:none; margin-top:6px; text-align:center;">
                            <img id="editTaxImgThumb" src=""
                                 style="max-width:100%; max-height:70px; border-radius:8px; border:1.5px solid #e2e8f0; object-fit:cover;">
                            <button type="button"
                                    onclick="insClearFile('editTaxImgInput','editTaxImgPreview','editTaxImgName')"
                                    style="display:block; margin:5px auto 0; background:rgba(224,85,85,.1); color:var(--danger); border:none; border-radius:6px; padding:3px 10px; font-size:11px; cursor:pointer;">
                                <i class="fas fa-xmark"></i> Remove
                            </button>
                        </div>
                    </div>

                    <div class="imod-group imod-full">
                        <label class="imod-label">Notes</label>
                        <textarea name="notes" id="editTaxNotes"
                                  class="imod-input tax-input" rows="2" style="resize:vertical;"></textarea>
                    </div>

                </div>
            </div>
            <div class="ins-modal-footer">
                <button type="button" class="btn-outline" onclick="closeEditTaxModal()">
                    <i class="fas fa-xmark"></i> Cancel
                </button>
                <button type="submit" class="btn-primary"
                        style="background:linear-gradient(135deg,#0c4f5e,#0e7490);">
                    <i class="fas fa-floppy-disk"></i> Update Tax Record
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ NEW INSURANCE MODAL ══════════════ --}}
<div class="ins-modal-overlay" id="insuranceModal">
    <div class="ins-modal">
        <div class="ins-modal-header ins-hdr">
            <div>
                <h3><i class="fas fa-shield-halved" style="margin-right:8px; color:rgba(255,255,255,.85);"></i>Add Insurance Record</h3>
                <p>Log a vehicle insurance payment</p>
            </div>
            <button class="ins-modal-close" onclick="closeInsuranceModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form action="{{ route('manager.insurance.store') }}" method="POST" novalidate>
            @csrf
            <div class="ins-modal-body">
                <div class="imod-grid">

                    <div class="imod-group">
                        <label class="imod-label">Date <span class="req">*</span></label>
                        <input type="date" name="insurance_date" class="imod-input ins-input"
                               value="{{ old('insurance_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="imod-group">
                        <label class="imod-label">Bus Number <span class="req">*</span></label>
                        <input type="text" name="bus_number" class="imod-input ins-input"
                               placeholder="e.g. MH12AB1234"
                               style="text-transform:uppercase;"
                               oninput="this.value=this.value.toUpperCase();"
                               value="{{ old('bus_number') }}" required>
                    </div>

                    <div class="imod-group imod-full">
                        <label class="imod-label">Amount Paid (₹) <span class="req">*</span></label>
                        <div class="imod-prefix-wrap">
                            <span class="imod-prefix">₹</span>
                            <input type="number" name="amount" class="imod-input ins-input"
                                   placeholder="0.00" min="0" step="0.01"
                                   value="{{ old('amount') }}" required>
                        </div>
                    </div>

                    <div class="imod-group imod-full">
                        <label class="imod-label">Notes</label>
                        <textarea name="notes" class="imod-input ins-input" rows="2"
                                  style="resize:vertical;"
                                  placeholder="Policy number, insurer name, coverage details…">{{ old('notes') }}</textarea>
                    </div>

                </div>
            </div>
            <div class="ins-modal-footer">
                <button type="button" class="btn-outline" onclick="closeInsuranceModal()">
                    <i class="fas fa-xmark"></i> Cancel
                </button>
                <button type="submit" class="btn-primary"
                        style="background:linear-gradient(135deg,#3730a3,#4f46e5);">
                    <i class="fas fa-floppy-disk"></i> Save Insurance Record
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════ EDIT INSURANCE MODAL ══════════════ --}}
<div class="ins-modal-overlay" id="editInsuranceModal">
    <div class="ins-modal">
        <div class="ins-modal-header ins-hdr" style="background:linear-gradient(135deg,#1e1b4b,#3730a3);">
            <div>
                <h3><i class="fas fa-pen-to-square" style="margin-right:8px; color:rgba(255,255,255,.85);"></i>Edit Insurance Record</h3>
                <p id="editInsSubtitle">Update insurance details</p>
            </div>
            <button class="ins-modal-close" onclick="closeEditInsuranceModal()"><i class="fas fa-xmark"></i></button>
        </div>
        <form id="editInsuranceForm" method="POST" novalidate>
            @csrf @method('PUT')
            <div class="ins-modal-body">
                <div class="imod-grid">

                    <div class="imod-group">
                        <label class="imod-label">Date <span class="req">*</span></label>
                        <input type="date" name="insurance_date" id="editInsDate"
                               class="imod-input ins-input" required>
                    </div>

                    <div class="imod-group">
                        <label class="imod-label">Bus Number <span class="req">*</span></label>
                        <input type="text" name="bus_number" id="editInsBus"
                               class="imod-input ins-input"
                               style="text-transform:uppercase;"
                               oninput="this.value=this.value.toUpperCase();" required>
                    </div>

                    <div class="imod-group imod-full">
                        <label class="imod-label">Amount Paid (₹) <span class="req">*</span></label>
                        <div class="imod-prefix-wrap">
                            <span class="imod-prefix">₹</span>
                            <input type="number" name="amount" id="editInsAmount"
                                   class="imod-input ins-input"
                                   placeholder="0.00" min="0" step="0.01" required>
                        </div>
                    </div>

                    <div class="imod-group imod-full">
                        <label class="imod-label">Notes</label>
                        <textarea name="notes" id="editInsNotes"
                                  class="imod-input ins-input" rows="2" style="resize:vertical;"></textarea>
                    </div>

                </div>
            </div>
            <div class="ins-modal-footer">
                <button type="button" class="btn-outline" onclick="closeEditInsuranceModal()">
                    <i class="fas fa-xmark"></i> Cancel
                </button>
                <button type="submit" class="btn-primary"
                        style="background:linear-gradient(135deg,#1e1b4b,#3730a3);">
                    <i class="fas fa-floppy-disk"></i> Update Insurance Record
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>