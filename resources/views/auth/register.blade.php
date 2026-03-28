<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Travels Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold: #c9a84c;
            --gold-light: #e8c97a;
            --dark: #0a0f1e;
            --card-bg: rgba(10, 15, 30, 0.78);
            --text: #f0ece2;
            --muted: rgba(240, 236, 226, 0.55);
            --border: rgba(201, 168, 76, 0.25);
            --input-bg: rgba(255,255,255,0.05);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            background: var(--dark);
            padding: 24px;
        }

        .bg {
            position: fixed; inset: 0; z-index: 0;
            background:
                linear-gradient(180deg, rgba(5,8,20,0.6) 0%, rgba(10,15,30,0.25) 50%, rgba(5,8,20,0.85) 100%),
                url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1920&q=80') center/cover no-repeat;
        }
        .bg::after {
            content: '';
            position: absolute; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.5; pointer-events: none;
        }

        .particles { position: fixed; inset: 0; z-index: 1; pointer-events: none; }
        .particle {
            position: absolute; border-radius: 50%;
            background: var(--gold-light); opacity: 0;
            animation: float-up linear infinite;
        }
        .particle:nth-child(1) { left: 5%;  width: 3px; height: 3px; animation-duration: 9s;  animation-delay: 1s; }
        .particle:nth-child(2) { left: 25%; width: 2px; height: 2px; animation-duration: 13s; animation-delay: 3s; }
        .particle:nth-child(3) { left: 42%; width: 4px; height: 4px; animation-duration: 8s;  animation-delay: 0s; }
        .particle:nth-child(4) { left: 60%; width: 2px; height: 2px; animation-duration: 11s; animation-delay: 5s; }
        .particle:nth-child(5) { left: 75%; width: 3px; height: 3px; animation-duration: 7s;  animation-delay: 2s; }
        .particle:nth-child(6) { left: 88%; width: 2px; height: 2px; animation-duration: 14s; animation-delay: 6s; }
        @keyframes float-up {
            0%   { transform: translateY(100vh); opacity: 0; }
            10%  { opacity: 0.8; }
            90%  { opacity: 0.4; }
            100% { transform: translateY(-5vh);  opacity: 0; }
        }

        .drift-tags { position: fixed; inset: 0; z-index: 1; pointer-events: none; overflow: hidden; }
        .drift-tag {
            position: absolute; font-size: 11px; letter-spacing: 0.15em;
            text-transform: uppercase; color: var(--gold); opacity: 0;
            animation: drift linear infinite; white-space: nowrap;
            border: 1px solid rgba(201,168,76,0.2); padding: 4px 10px;
            border-radius: 20px; backdrop-filter: blur(4px);
            background: rgba(10,15,30,0.3);
        }
        .drift-tag:nth-child(1) { top: 8%;  animation-duration: 24s; animation-delay: 0s; }
        .drift-tag:nth-child(2) { top: 28%; animation-duration: 19s; animation-delay: 4s; }
        .drift-tag:nth-child(3) { top: 48%; animation-duration: 27s; animation-delay: 8s; }
        .drift-tag:nth-child(4) { top: 68%; animation-duration: 21s; animation-delay: 2s; }
        .drift-tag:nth-child(5) { top: 85%; animation-duration: 16s; animation-delay: 6s; }
        @keyframes drift {
            0%   { transform: translateX(-150px); opacity: 0; }
            5%   { opacity: 1; }
            95%  { opacity: 0.8; }
            100% { transform: translateX(110vw);  opacity: 0; }
        }

        .page {
            position: relative; z-index: 10; width: 100%; max-width: 900px;
            display: grid; grid-template-columns: 1fr 1fr; gap: 0;
            animation: page-enter 0.9s cubic-bezier(0.16, 1, 0.3, 1) both;
            border-radius: 22px; overflow: hidden;
            box-shadow: 0 40px 100px rgba(0,0,0,0.6);
        }
        @keyframes page-enter {
            from { opacity: 0; transform: translateY(50px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Left panel */
        .left-panel {
            background:
                linear-gradient(160deg, rgba(10,15,30,0.7) 0%, rgba(5,8,20,0.95) 100%),
                url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=800&q=80') center/cover no-repeat;
            padding: 48px 40px;
            display: flex; flex-direction: column; justify-content: space-between;
            border-right: 1px solid var(--border);
        }
        .brand-logo { display: flex; align-items: center; gap: 12px; }
        .logo-icon {
            width: 44px; height: 44px;
            border: 1.5px solid var(--gold); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            animation: pulse-ring 3s ease-in-out infinite;
        }
        @keyframes pulse-ring {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201,168,76,0.5); }
            50%       { box-shadow: 0 0 0 10px rgba(201,168,76,0); }
        }
        .logo-icon svg { width: 20px; height: 20px; fill: var(--gold); }
        .logo-text { font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 600; color: var(--text); letter-spacing: 0.03em; line-height: 1.2; }
        .logo-text small { display: block; font-family: 'DM Sans', sans-serif; font-size: 10px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--muted); font-weight: 300; }
        .panel-headline { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 40px 0; }
        .panel-headline h2 { font-family: 'Cormorant Garamond', serif; font-size: 42px; font-weight: 300; line-height: 1.2; color: var(--text); margin-bottom: 16px; }
        .panel-headline h2 em { font-style: normal; color: var(--gold); }
        .panel-headline p { font-size: 13px; line-height: 1.7; color: var(--muted); max-width: 260px; }
        .divider-gold { width: 40px; height: 2px; background: var(--gold); margin: 16px 0; }
        .stats-row { display: flex; gap: 24px; }
        .stat { display: flex; flex-direction: column; gap: 3px; }
        .stat-num { font-family: 'Cormorant Garamond', serif; font-size: 26px; font-weight: 600; color: var(--gold-light); }
        .stat-lbl { font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); }

        /* Right panel */
        .right-panel {
            background: var(--card-bg);
            backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            padding: 40px 36px; position: relative;
        }
        .right-panel::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .section-title { font-family: 'Cormorant Garamond', serif; font-size: 26px; font-weight: 400; color: var(--text); margin-bottom: 4px; }
        .section-sub { font-size: 12px; color: var(--muted); letter-spacing: 0.05em; margin-bottom: 24px; }
        .thin-divider { width: 32px; height: 1px; background: var(--gold); margin: 8px 0 22px; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { margin-bottom: 16px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { display: block; font-size: 10px; font-weight: 500; letter-spacing: 0.14em; text-transform: uppercase; color: var(--muted); margin-bottom: 6px; }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%);
            color: var(--gold); opacity: 0.7; pointer-events: none;
        }
        .input-icon svg { width: 14px; height: 14px; }

        /* ── Eye toggle ── */
        .eye-toggle {
            position: absolute;
            right: 10px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--gold); opacity: 0.6; padding: 4px;
            display: flex; align-items: center;
            transition: opacity 0.2s;
        }
        .eye-toggle:hover { opacity: 1; }
        .eye-toggle svg { width: 16px; height: 16px; }

        .form-control, .form-select {
            width: 100%;
            padding: 11px 38px 11px 38px; /* left for lock icon, right for eye */
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px; outline: none;
            transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
            appearance: none; -webkit-appearance: none;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--gold);
            background: rgba(201,168,76,0.06);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
        }
        .form-control::placeholder { color: rgba(240,236,226,0.28); }
        .form-control.is-invalid, .form-select.is-invalid { border-color: #e06060; }
        .invalid-feedback { color: #e06060; font-size: 11px; margin-top: 4px; display: block; }

        .select-wrap { position: relative; }
        .select-wrap::after { content: '▾'; position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--gold); pointer-events: none; font-size: 13px; }
        .form-select option { background: #15203a; color: var(--text); }

        /* Role picker */
        .role-picker { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .role-option { display: none; }
        .role-label {
            display: flex; flex-direction: column; align-items: center; gap: 6px;
            padding: 12px 8px;
            border: 1px solid var(--border); border-radius: 10px;
            cursor: pointer; transition: all 0.25s; background: var(--input-bg);
        }
        .role-label:hover { border-color: rgba(201,168,76,0.5); background: rgba(201,168,76,0.06); }
        .role-option:checked + .role-label { border-color: var(--gold); background: rgba(201,168,76,0.12); box-shadow: 0 0 0 2px rgba(201,168,76,0.2); }
        .role-emoji { font-size: 18px; }
        .role-name { font-size: 10px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); font-weight: 500; }
        .role-option:checked + .role-label .role-name { color: var(--gold-light); }

        .btn-submit {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #b8922f, var(--gold), #e8c97a);
            background-size: 200% 200%;
            border: none; border-radius: 10px; color: var(--dark);
            font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 600;
            letter-spacing: 0.14em; text-transform: uppercase; cursor: pointer;
            margin-top: 6px; transition: all 0.3s; position: relative;
            animation: shimmer 4s ease infinite;
        }
        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; }
            50%       { background-position: 100% 50%; }
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(201,168,76,0.4); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit::after { content: ''; position: absolute; inset: 0; background: linear-gradient(rgba(255,255,255,0.15), transparent); border-radius: 10px; pointer-events: none; }

        .form-footer { text-align: center; margin-top: 16px; font-size: 12px; color: var(--muted); }
        .form-footer a { color: var(--gold-light); text-decoration: none; font-weight: 500; }
        .form-footer a:hover { color: #fff; }

        @media (max-width: 700px) {
            .page { grid-template-columns: 1fr; max-width: 460px; }
            .left-panel { display: none; }
            .right-panel { padding: 36px 28px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="bg"></div>
<div class="particles">
    <div class="particle"></div><div class="particle"></div>
    <div class="particle"></div><div class="particle"></div>
    <div class="particle"></div><div class="particle"></div>
</div>
<div class="drift-tags">
    <div class="drift-tag">🌍 Explore Destinations</div>
    <div class="drift-tag">✈ Book Your Journey</div>
    <div class="drift-tag">🗺 Plan Adventures</div>
    <div class="drift-tag">🏝 Tropical Getaways</div>
    <div class="drift-tag">⛰ Mountain Escapes</div>
</div>

<div class="page">

    <!-- Left branding panel -->
    <div class="left-panel">
        <div class="brand-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24"><path d="M21 3L3 10.53v.98l6.84 2.65L12.48 21h.98L21 3z"/></svg>
            </div>
            <div class="logo-text">
                Venkatesh Tours & Travels
                <small>Your journey partner</small>
            </div>
        </div>
        <div class="panel-headline">
            <h2>Begin Your <em>Next</em> Adventure</h2>
            <div class="divider-gold"></div>
            <p>Join thousands of travelers managing their journeys with precision, style, and ease.</p>
        </div>
        <div class="stats-row">
            <div class="stat"><span class="stat-num">200+</span><span class="stat-lbl">Destinations</span></div>
            <div class="stat"><span class="stat-num">18K+</span><span class="stat-lbl">Travelers</span></div>
            <div class="stat"><span class="stat-num">99%</span><span class="stat-lbl">Satisfaction</span></div>
        </div>
    </div>

    <!-- Right form panel -->
    <div class="right-panel">
        <div class="section-title">Create Account</div>
        <div class="section-sub">Start managing your travels today</div>
        <div class="thin-divider"></div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-row">
                <!-- Name -->
                <div class="form-group full">
                    <label class="form-label">Full Name</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </span>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="John Doe" required>
                    </div>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <!-- Email -->
                <div class="form-group full">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="your@email.com" required>
                    </div>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <!-- Password with Eye Toggle -->
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input type="password" name="password" id="regPassword"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••" required>
                        <button type="button" class="eye-toggle" onclick="togglePassword('regPassword', this)" aria-label="Toggle password visibility">
                            <svg id="regPassword-eye-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="regPassword-eye-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <!-- Confirm Password with Eye Toggle -->
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        <input type="password" name="password_confirmation" id="regPasswordConfirm"
                               class="form-control"
                               placeholder="••••••••" required>
                        <button type="button" class="eye-toggle" onclick="togglePassword('regPasswordConfirm', this)" aria-label="Toggle confirm password visibility">
                            <svg id="regPasswordConfirm-eye-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="regPasswordConfirm-eye-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Role -->
            <div class="form-group" style="margin-bottom: 18px;">
                <label class="form-label">Register As</label>
                <div class="role-picker">
                    <div>
                        <input type="radio" name="role" id="role_admin" value="admin"
                               class="role-option" {{ old('role')=='admin'?'checked':'' }}>
                        <label for="role_admin" class="role-label">
                            <span class="role-emoji">🛡</span>
                            <span class="role-name">Admin</span>
                        </label>
                    </div>
                    <div>
                        <input type="radio" name="role" id="role_manager" value="manager"
                               class="role-option" {{ old('role')=='manager'?'checked':'' }}>
                        <label for="role_manager" class="role-label">
                            <span class="role-emoji">📋</span>
                            <span class="role-name">Manager</span>
                        </label>
                    </div>
                    <div>
                        <input type="radio" name="role" id="role_user" value="user"
                               class="role-option" {{ old('role','user')=='user'?'checked':'' }}>
                        <label for="role_user" class="role-label">
                            <span class="role-emoji">🌍</span>
                            <span class="role-name">Traveler</span>
                        </label>
                    </div>
                </div>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn-submit">Create My Account &nbsp;→</button>
        </form>

        <div class="form-footer">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ✅ Success message --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Account Created!',
            text: @json(session('success')),
            confirmButtonColor: '#c9a84c',
            background: '#0e1628',
            color: '#f0ece2',
            confirmButtonText: 'Let\'s Go →'
        });
    });
</script>
@endif

{{-- ❌ Validation errors --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: @json($errors->first()),
            confirmButtonColor: '#e06060',
            background: '#0e1628',
            color: '#f0ece2'
        });
    });
</script>
@endif

<script>
    /**
     * Toggle password field visibility.
     * @param {string} inputId  - The id of the password <input>
     * @param {HTMLElement} btn - The eye-toggle <button>
     */
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeShow = document.getElementById(inputId + '-eye-show');
        const eyeHide = document.getElementById(inputId + '-eye-hide');

        if (input.type === 'password') {
            input.type = 'text';
            eyeShow.style.display = 'none';
            eyeHide.style.display = 'block';
            btn.setAttribute('aria-label', 'Hide password');
        } else {
            input.type = 'password';
            eyeShow.style.display = 'block';
            eyeHide.style.display = 'none';
            btn.setAttribute('aria-label', 'Show password');
        }
    }
</script>
</body>
</html>