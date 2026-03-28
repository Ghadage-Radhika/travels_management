<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --navy: #0f1b2d;
            --navy-light: #162235;
            --navy-mid: #1e3052;
            --gold: #c9a84c;
            --gold-light: #e8c96a;
            --cream: #f5f0e8;
            --white: #ffffff;
            --text-muted: #8a9ab5;
            --danger: #e05555;
            --success: #3db87a;
            --sidebar-w: 270px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: #eef2f7;
            color: var(--navy);
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--navy);
            display: flex; flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }
        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(201,168,76,0.2);
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-logo .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: var(--navy);
        }
        .sidebar-logo span {
            font-family: 'Playfair Display', serif;
            font-size: 18px; color: var(--white);
            letter-spacing: 0.5px;
        }
        .sidebar-logo span em {
            display: block; font-style: normal;
            font-family: 'DM Sans', sans-serif;
            font-size: 10px; color: var(--gold);
            letter-spacing: 2px; text-transform: uppercase; margin-top: 1px;
        }

        .sidebar-section-label {
            padding: 20px 24px 8px;
            font-size: 10px; letter-spacing: 2px;
            text-transform: uppercase; color: var(--text-muted);
            font-weight: 600;
        }
        .sidebar-nav { padding: 0 12px; flex: 1; }
        .nav-item {
            display: flex; align-items: center; gap: 13px;
            padding: 12px 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 4px;
            color: #a0b0c8;
            font-size: 14px; font-weight: 500;
            text-decoration: none;
        }
        .nav-item:hover { background: var(--navy-mid); color: var(--white); }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.05));
            color: var(--gold-light);
            border: 1px solid rgba(201,168,76,0.2);
        }
        .nav-item .nav-icon {
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px;
            font-size: 14px;
            background: rgba(255,255,255,0.05);
            flex-shrink: 0;
        }
        .nav-item.active .nav-icon {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--navy);
        }
        .sidebar-bottom {
            padding: 16px 12px 24px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        /* TOPBAR */
        .topbar {
            position: fixed; top: 0;
            left: var(--sidebar-w); right: 0;
            height: 68px;
            background: var(--white);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px;
            box-shadow: 0 1px 0 rgba(0,0,0,0.06);
            z-index: 50;
        }
        .topbar-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 20px; font-weight: 600; color: var(--navy);
        }
        .topbar-left p { font-size: 12px; color: var(--text-muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 20px; }
        .user-badge {
            display: flex; align-items: center; gap: 10px;
            background: var(--cream);
            padding: 6px 14px 6px 8px;
            border-radius: 30px;
        }
        .user-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--navy), var(--navy-mid));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: 14px; font-weight: 700;
        }
        .user-name { font-size: 13px; font-weight: 600; color: var(--navy); }
        .logout-btn {
            display: flex; align-items: center; gap: 7px;
            background: var(--navy);
            color: var(--white);
            border: none; cursor: pointer;
            padding: 9px 16px;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px; font-weight: 500;
            transition: background 0.2s;
            text-decoration: none;
        }
        .logout-btn:hover { background: var(--danger); }

        /* MAIN */
        .main {
            margin-left: var(--sidebar-w);
            padding-top: 68px;
            min-height: 100vh;
        }
        .main-content { padding: 32px; }

        /* STATS CARDS */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: var(--white);
            border-radius: 14px;
            padding: 20px 22px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
            display: flex; align-items: center; gap: 14px;
        }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-icon.gold { background: rgba(201,168,76,0.12); color: var(--gold); }
        .stat-icon.blue { background: rgba(30,48,82,0.1); color: var(--navy-mid); }
        .stat-icon.green { background: rgba(61,184,122,0.1); color: var(--success); }
        .stat-icon.red { background: rgba(224,85,85,0.1); color: var(--danger); }
        .stat-label { font-size: 12px; color: var(--text-muted); margin-bottom: 3px; }
        .stat-value { font-size: 24px; font-weight: 700; color: var(--navy); line-height: 1; }

        /* PANEL */
        .panel {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 28px;
            overflow: hidden;
        }
        .panel-header {
            padding: 20px 26px;
            border-bottom: 1px solid #f0f0f0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .panel-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 17px; font-weight: 600; color: var(--navy);
        }
        .panel-header p { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .panel-body { padding: 26px; }

        /* FORM */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label {
            font-size: 12px; font-weight: 600;
            color: var(--navy); letter-spacing: 0.5px; text-transform: uppercase;
        }
        .form-control {
            padding: 11px 14px;
            border: 1.5px solid #e5e9ef;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px; color: var(--navy);
            background: #fafbfc;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
            background: var(--white);
        }
        select.form-control { cursor: pointer; }
        .date-field {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.35s ease, opacity 0.3s ease;
        }
        .date-field.visible { max-height: 80px; opacity: 1; }

        .btn-submit {
            margin-top: 6px;
            background: linear-gradient(135deg, var(--navy), var(--navy-mid));
            color: var(--white);
            border: none; cursor: pointer;
            padding: 13px 28px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 8px;
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15,27,45,0.25);
        }
        .btn-submit:active { transform: translateY(0); }

        /* TABLE */
        .enquiry-table { width: 100%; border-collapse: collapse; }
        .enquiry-table thead tr {
            background: #f6f8fb;
        }
        .enquiry-table th {
            padding: 12px 16px;
            font-size: 11px; font-weight: 700;
            letter-spacing: 1px; text-transform: uppercase;
            color: var(--text-muted);
            text-align: left; white-space: nowrap;
        }
        .enquiry-table td {
            padding: 14px 16px;
            font-size: 13.5px; color: #374151;
            border-top: 1px solid #f0f4f8;
            vertical-align: middle;
        }
        .enquiry-table tbody tr:hover { background: #fafcff; }
        .badge {
            display: inline-flex; align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .badge-bus { background: rgba(30,48,82,0.1); color: var(--navy-mid); }
        .badge-sleeper { background: rgba(201,168,76,0.15); color: #8a6a15; }
        .badge-package { background: rgba(61,184,122,0.12); color: #1e7a4e; }
        .badge-rental { background: rgba(224,85,85,0.1); color: var(--danger); }
        .status-dot {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12px; font-weight: 500;
        }
        .status-dot::before {
            content: ''; width: 7px; height: 7px;
            border-radius: 50%; display: inline-block;
        }
        .status-pending .status-dot::before { background: #f59e0b; }
        .status-resolved .status-dot::before { background: var(--success); }
        .status-pending .status-dot { color: #92400e; }
        .status-resolved .status-dot { color: #166534; }

        .empty-state {
            text-align: center; padding: 48px;
            color: var(--text-muted);
        }
        .empty-state i { font-size: 36px; margin-bottom: 12px; opacity: 0.4; }
        .empty-state p { font-size: 14px; }

        /* TOAST */
        .toast {
            position: fixed; bottom: 28px; right: 28px;
            background: var(--navy);
            color: var(--white);
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 13px; font-weight: 500;
            display: flex; align-items: center; gap: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            transform: translateY(80px); opacity: 0;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 999;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast i { color: var(--gold); font-size: 16px; }

        @media (max-width: 1100px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
            .topbar { left: 0; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="fas fa-route"></i></div>
        <span>Venkatesh Tours & Travels<em>User Portal</em></span>
    </div>

    <div class="sidebar-section-label">Main Menu</div>
    <nav class="sidebar-nav">
        <a href="#" class="nav-item active" onclick="setActive(this)">
            <div class="nav-icon"><i class="fas fa-gauge-high"></i></div>
            Dashboard
        </a>
        <a href="#" class="nav-item" onclick="setActive(this)">
            <div class="nav-icon"><i class="fas fa-bus"></i></div>
            Bus Booking
        </a>
        <a href="#" class="nav-item" onclick="setActive(this)">
            <div class="nav-icon"><i class="fas fa-moon"></i></div>
            Sleeper Coach Booking
        </a>
        <a href="#" class="nav-item" onclick="setActive(this)">
            <div class="nav-icon"><i class="fas fa-umbrella-beach"></i></div>
            Package Tours
        </a>
        <a href="#" class="nav-item" onclick="setActive(this)">
            <div class="nav-icon"><i class="fas fa-truck-ramp-box"></i></div>
            Bus Rental Information
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="nav-item" style="color:#a0b0c8; font-size:13px; cursor:default;">
            <div class="nav-icon"><i class="fas fa-circle-question"></i></div>
            Help & Support
        </div>
    </div>
</aside>

<!-- TOPBAR -->
<header class="topbar">
    <div class="topbar-left">
        <h1>Welcome Back 👋</h1>
        <p>{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
    </div>
    <div class="topbar-right">
        <div class="user-badge">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <span class="user-name">{{ auth()->user()->name }}</span>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</header>

<!-- MAIN -->
<main class="main">
    <div class="main-content">

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon gold"><i class="fas fa-file-lines"></i></div>
                <div>
                    <div class="stat-label">Total Enquiries</div>
                    <div class="stat-value">{{ $enquiries->count() }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-bus"></i></div>
                <div>
                    <div class="stat-label">Bus Bookings</div>
                    <div class="stat-value">{{ $enquiries->where('type_of_enquiry','Bus Booking')->count() }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-clock-rotate-left"></i></div>
                <div>
                    <div class="stat-label">Pending</div>
                    <div class="stat-value">{{ $enquiries->where('status','pending')->count() }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><i class="fas fa-circle-check"></i></div>
                <div>
                    <div class="stat-label">Approved</div>
                    <div class="stat-value">{{ $enquiries->where('status','approved')->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Enquiry Form Panel -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2>New Enquiry</h2>
                    <p>Fill in the details below and we'll get back to you shortly</p>
                </div>
                <i class="fas fa-pen-to-square" style="color:var(--gold); font-size:20px;"></i>
            </div>
            <div class="panel-body">
                <form action="{{ route('enquiry.store') }}" method="POST" id="enquiryForm">
                    @csrf
                    @if(session('enquiry_success'))
                        <div style="background:rgba(61,184,122,0.1); border:1px solid rgba(61,184,122,0.3); color:#166534; padding:12px 16px; border-radius:9px; font-size:13px; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                            <i class="fas fa-circle-check"></i> {{ session('enquiry_success') }}
                        </div>
                    @endif
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Your full name"
                                value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')<span style="color:var(--danger);font-size:12px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="tel" name="mobile" class="form-control" placeholder="10-digit mobile number"
                                value="{{ old('mobile') }}" maxlength="10" required>
                            @error('mobile')<span style="color:var(--danger);font-size:12px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group full">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Your full address"
                                value="{{ old('address') }}" required>
                            @error('address')<span style="color:var(--danger);font-size:12px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Type of Enquiry</label>
                            <select name="type_of_enquiry" id="enquiryType" class="form-control" onchange="toggleDateField()" required>
                                <option value="" disabled {{ old('type_of_enquiry') ? '' : 'selected' }}>Select enquiry type</option>
                                <option value="Bus Booking" {{ old('type_of_enquiry')=='Bus Booking' ? 'selected' : '' }}>Bus Booking</option>
                                <option value="Sleeper Coach Booking" {{ old('type_of_enquiry')=='Sleeper Coach Booking' ? 'selected' : '' }}>Sleeper Coach Booking</option>
                                <option value="Package Tours" {{ old('type_of_enquiry')=='Package Tours' ? 'selected' : '' }}>Package Tours</option>
                                <option value="Bus Rental" {{ old('type_of_enquiry')=='Bus Rental' ? 'selected' : '' }}>Bus Rental</option>
                            </select>
                            @error('type_of_enquiry')<span style="color:var(--danger);font-size:12px;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group" id="dateWrapper">
                            <div class="date-field" id="dateField">
                                <label>Date of Requirement</label>
                                <input type="date" name="date_of_requirement" class="form-control" id="dateInput"
                                    value="{{ old('date_of_requirement') }}"
                                    min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                @error('date_of_requirement')<span style="color:var(--danger);font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group full">
                            <label>Message / Details</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Describe your requirement in detail...">{{ old('message') }}</textarea>
                        </div>

                        <div class="form-group full">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Submit Enquiry
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Previous Enquiries Panel -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2>My Enquiries</h2>
                    <p>Track the status of all your previous enquiries</p>
                </div>
                <span style="font-size:13px; color:var(--text-muted);">
                    {{ $enquiries->count() }} record(s)
                </span>
            </div>

            @if($enquiries->count() > 0)
            <div style="overflow-x:auto;">
                <table class="enquiry-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Type</th>
                            <th>Date of Requirement</th>
                            <th>Submitted On</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enquiries as $index => $enquiry)
                        <tr>
                            <td style="color:var(--text-muted); font-weight:600;">{{ $index + 1 }}</td>
                            <td style="font-weight:600;">{{ $enquiry->name }}</td>
                            <td>{{ $enquiry->mobile }}</td>
                            <td style="max-width:160px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $enquiry->address }}
                            </td>
                            <td>
                                @php
                                    $typeClass = [
                                        'Bus Booking' => 'badge-bus',
                                        'Sleeper Coach Booking' => 'badge-sleeper',
                                        'Package Tours' => 'badge-package',
                                        'Bus Rental' => 'badge-rental',
                                    ][$enquiry->type_of_enquiry] ?? 'badge-bus';
                                @endphp
                                <span class="badge {{ $typeClass }}">{{ $enquiry->type_of_enquiry }}</span>
                            </td>
                            <td>
                                @if($enquiry->date_of_requirement)
                                    <span style="display:flex; align-items:center; gap:5px; font-size:13px;">
                                        <i class="fas fa-calendar-day" style="color:var(--gold); font-size:11px;"></i>
                                        {{ \Carbon\Carbon::parse($enquiry->date_of_requirement)->format('d M Y') }}
                                    </span>
                                @else
                                    <span style="color:var(--text-muted); font-size:12px;">—</span>
                                @endif
                            </td>
                            <td style="color:var(--text-muted); font-size:13px;">
                                {{ $enquiry->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <div class="{{ $enquiry->status == 'resolved' ? 'status-resolved' : 'status-pending' }}">
                                    <span class="status-dot">{{ ucfirst($enquiry->status ?? 'pending') }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>No enquiries submitted yet. Use the form above to get started.</p>
            </div>
            @endif
        </div>

    </div>
</main>

<!-- Toast notification -->
<div class="toast" id="toast">
    <i class="fas fa-circle-check"></i>
    <span id="toastMsg">Enquiry submitted successfully!</span>
</div>

<script>
    function toggleDateField() {
        const type = document.getElementById('enquiryType').value;
        const dateField = document.getElementById('dateField');
        const dateInput = document.getElementById('dateInput');
        const needsDate = ['Bus Booking', 'Sleeper Coach Booking', 'Bus Rental'].includes(type);

        if (needsDate) {
            dateField.classList.add('visible');
            dateInput.required = true;
        } else {
            dateField.classList.remove('visible');
            dateInput.required = false;
            dateInput.value = '';
        }
    }

    function setActive(el) {
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
        el.classList.add('active');
    }

    // Show login success toast
    @if(session('login_success'))
    window.addEventListener('load', () => {
        const toast = document.getElementById('toast');
        document.getElementById('toastMsg').textContent = @json(session('login_success'));
        toast.style.background = 'var(--navy)';
        document.querySelector('#toast i').className = 'fas fa-hand-wave';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 4500);
    });
    @endif

    // Show enquiry submitted toast
    @if(session('enquiry_success'))
    window.addEventListener('load', () => {
        const toast = document.getElementById('toast');
        document.getElementById('toastMsg').textContent = @json(session('enquiry_success'));
        toast.style.background = '#1a4731';
        document.querySelector('#toast i').className = 'fas fa-circle-check';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 5000);
    });
    @endif

    // Init date field on load if old input exists
    window.addEventListener('DOMContentLoaded', toggleDateField);
</script>
</body>
</html>