<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Travels Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold: #c9a84c;
            --gold-light: #e8c97a;
            --dark: #0a0f1e;
            --card-bg: rgba(10, 15, 30, 0.75);
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
            overflow: hidden;
            background: var(--dark);
        }

        .bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                linear-gradient(180deg,
                    rgba(5,8,20,0.55) 0%,
                    rgba(10,15,30,0.3) 40%,
                    rgba(5,8,20,0.8) 100%),
                url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1920&q=80') center/cover no-repeat;
        }

        .particles { position: fixed; inset: 0; z-index: 1; pointer-events: none; }
        .particle {
            position: absolute;
            width: 2px; height: 2px;
            border-radius: 50%;
            background: var(--gold-light);
            opacity: 0;
            animation: float-up linear infinite;
        }
        .particle:nth-child(1)  { left: 10%; animation-duration: 8s;  animation-delay: 0s;   width: 3px; height: 3px; }
        .particle:nth-child(2)  { left: 20%; animation-duration: 12s; animation-delay: 2s; }
        .particle:nth-child(3)  { left: 35%; animation-duration: 9s;  animation-delay: 4s;   width: 3px; height: 3px; }
        .particle:nth-child(4)  { left: 55%; animation-duration: 11s; animation-delay: 1s; }
        .particle:nth-child(5)  { left: 70%; animation-duration: 7s;  animation-delay: 3s;   width: 4px; height: 4px; }
        .particle:nth-child(6)  { left: 80%; animation-duration: 10s; animation-delay: 5s; }
        .particle:nth-child(7)  { left: 90%; animation-duration: 13s; animation-delay: 0.5s; width: 3px; height: 3px; }
        .particle:nth-child(8)  { left: 45%; animation-duration: 8s;  animation-delay: 6s; }
        @keyframes float-up {
            0%   { transform: translateY(100vh) scale(0); opacity: 0; }
            10%  { opacity: 0.7; }
            90%  { opacity: 0.4; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        .drift-tags { position: fixed; inset: 0; z-index: 1; pointer-events: none; overflow: hidden; }
        .drift-tag {
            position: absolute;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0;
            animation: drift linear infinite;
            white-space: nowrap;
            border: 1px solid rgba(201,168,76,0.2);
            padding: 4px 10px;
            border-radius: 20px;
            backdrop-filter: blur(4px);
            background: rgba(10,15,30,0.3);
        }
        .drift-tag:nth-child(1) { top: 15%; left: -150px; animation-duration: 22s; animation-delay: 0s; }
        .drift-tag:nth-child(2) { top: 35%; left: -150px; animation-duration: 28s; animation-delay: 5s; }
        .drift-tag:nth-child(3) { top: 55%; left: -150px; animation-duration: 20s; animation-delay: 10s; }
        .drift-tag:nth-child(4) { top: 75%; left: -150px; animation-duration: 25s; animation-delay: 3s; }
        .drift-tag:nth-child(5) { top: 90%; left: -150px; animation-duration: 18s; animation-delay: 7s; }
        @keyframes drift {
            0%   { transform: translateX(0);        opacity: 0; }
            5%   { opacity: 1; }
            95%  { opacity: 0.8; }
            100% { transform: translateX(110vw);    opacity: 0; }
        }

        .page {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 24px;
            animation: page-enter 0.9s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes page-enter {
            from { opacity: 0; transform: translateY(40px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .brand-header { text-align: center; margin-bottom: 28px; }
        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px; height: 56px;
            border: 1.5px solid var(--gold);
            border-radius: 50%;
            margin-bottom: 12px;
            animation: pulse-ring 3s ease-in-out infinite;
        }
        @keyframes pulse-ring {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201,168,76,0.4); }
            50%       { box-shadow: 0 0 0 12px rgba(201,168,76,0); }
        }
        .brand-icon svg { width: 26px; height: 26px; fill: var(--gold); }
        .brand-name { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 600; color: var(--text); letter-spacing: 0.04em; }
        .brand-name span { color: var(--gold); }
        .brand-tagline { font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--muted); margin-top: 4px; }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px 40px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 30px 80px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.05);
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .section-title { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 400; color: var(--text); margin-bottom: 6px; }
        .section-sub { font-size: 12px; color: var(--muted); letter-spacing: 0.06em; margin-bottom: 28px; }
        .divider { width: 36px; height: 1px; background: var(--gold); margin: 10px 0 24px; }

        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 11px; font-weight: 500; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            opacity: 0.7;
            pointer-events: none;
        }
        .input-icon svg { width: 16px; height: 16px; }

        /* ── Eye toggle button ── */
        .eye-toggle {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gold);
            opacity: 0.6;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: opacity 0.2s;
        }
        .eye-toggle:hover { opacity: 1; }
        .eye-toggle svg { width: 18px; height: 18px; }

        .form-control {
            width: 100%;
            padding: 13px 44px 13px 42px; /* right padding for eye icon */
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s, background 0.3s, box-shadow 0.3s;
        }
        .form-control:focus {
            border-color: var(--gold);
            background: rgba(201,168,76,0.06);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
        }
        .form-control::placeholder { color: rgba(240,236,226,0.3); }
        .form-control.is-invalid { border-color: #e06060; }
        .invalid-feedback { color: #e06060; font-size: 12px; margin-top: 5px; display: block; }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #b8922f, var(--gold), #e8c97a);
            background-size: 200% 200%;
            border: none;
            border-radius: 10px;
            color: var(--dark);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 8px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            animation: shimmer 4s ease infinite;
        }
        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; }
            50%       { background-position: 100% 50%; }
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(201,168,76,0.4); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(255,255,255,0.15), transparent);
            pointer-events: none;
        }

        .form-footer { text-align: center; margin-top: 20px; font-size: 13px; color: var(--muted); }
        .form-footer a { color: var(--gold-light); text-decoration: none; font-weight: 500; transition: color 0.2s; }
        .form-footer a:hover { color: #fff; }

        .compass { text-align: center; margin-top: 24px; opacity: 0.4; }
        .compass svg { width: 20px; height: 20px; fill: var(--gold); animation: spin-slow 12s linear infinite; }
        @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body>

<div class="bg"></div>

<div class="particles">
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
    <div class="particle"></div><div class="particle"></div>
</div>

<div class="drift-tags">
    <div class="drift-tag">✈ Kulu Manali</div>
    <div class="drift-tag">🏔 Sindhudurga Fort</div>
    <div class="drift-tag">🌊 Gokarna, Murudeshwar</div>
    <div class="drift-tag">🗺 Nepal</div>
    <div class="drift-tag">🌅 Kokan Darshan</div>
</div>

<div class="page">

    <div class="brand-header">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 3L3 10.53v.98l6.84 2.65L12.48 21h.98L21 3z"/>
            </svg>
        </div>
        <div class="brand-name">Venkatesh <span>Tours & Travels</span></div>
        <div class="brand-tagline">Your journey, seamlessly managed</div>
    </div>

    <div class="card">
        <div class="section-title">Welcome back</div>
        <div class="section-sub">Sign in to continue your adventure</div>
        <div class="divider"></div>
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </span>
                    <input type="email" name="email"
                           class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           value="<?php echo e(old('email')); ?>"
                           placeholder="your@email.com" required>
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <input type="password" name="password" id="loginPassword"
                           class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="••••••••" required>
                    <button type="button" class="eye-toggle" onclick="togglePassword('loginPassword', this)" aria-label="Toggle password visibility">
                        <!-- Eye icon (visible = password hidden) -->
                        <svg id="loginPassword-eye-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <!-- Eye-off icon (visible = password shown) -->
                        <svg id="loginPassword-eye-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="btn-submit">Sign In &nbsp;→</button>
        </form>

        <div class="form-footer">
            Don't have an account?
            <a href="<?php echo e(route('register')); ?>">Create one</a>
        </div>
    </div>

    <div class="compass">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-2-6 6-2-4 8zm2-8l2 6-6 2 4-8z"/>
        </svg>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php if(session('register_success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Account Created!',
            text: <?php echo json_encode(session('register_success'), 15, 512) ?>,
            confirmButtonColor: '#c9a84c',
            background: '#0e1628',
            color: '#f0ece2',
            confirmButtonText: 'Sign In Now',
            customClass: { confirmButton: 'swal-gold-btn' }
        });
    });
</script>
<?php endif; ?>


<?php if(session('logout_success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'info',
            title: 'Logged Out',
            text: <?php echo json_encode(session('logout_success'), 15, 512) ?>,
            confirmButtonColor: '#c9a84c',
            background: '#0e1628',
            color: '#f0ece2',
            confirmButtonText: 'OK',
            customClass: { confirmButton: 'swal-gold-btn' }
        });
    });
</script>
<?php endif; ?>


<?php if($errors->any()): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: <?php echo json_encode($errors->first(), 15, 512) ?>,
            confirmButtonColor: '#e06060',
            background: '#0e1628',
            color: '#f0ece2'
        });
    });
</script>
<?php endif; ?>

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
</html><?php /**PATH C:\xampp\htdocs\travels_management\resources\views/auth/login.blade.php ENDPATH**/ ?>