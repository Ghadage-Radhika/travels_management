<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Venkatesh Tours & Travels')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- ═══ GLOBAL STYLES ═══ -->
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Lato', sans-serif; margin: 0; padding: 0; }

        /* ── Navbar ──────────────────────────────────── */
        #mainNav { transition: background 0.35s ease, box-shadow 0.35s ease; z-index: 1050; }
        #mainNav.scrolled { background: #000 !important; box-shadow: 0 4px 24px rgba(0,0,0,0.5); }

        #mainNav .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            color: gold !important;
            font-weight: 700;
            text-decoration: none;
        }
        #mainNav .nav-link {
            color: rgba(255,255,255,0.92) !important;
            font-weight: 500;
            letter-spacing: 0.3px;
            position: relative;
            padding-bottom: 5px !important;
        }
        #mainNav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            right: 50%;
            height: 2px;
            background: gold;
            transition: left 0.3s, right 0.3s;
        }
        #mainNav .nav-link:hover::after,
        #mainNav .nav-link.active-page::after { left: 0; right: 0; }

        #mainNav .nav-link:hover,
        #mainNav .nav-link.active-page { color: gold !important; }

        /* ── Shared Sections ─────────────────────────── */
        section { padding: 80px 0; }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 38px;
            color: #111;
        }
        .section-title span { color: #ffc107; }

        /* ── Shared Button ───────────────────────────── */
        .btn-gold {
            background: gold;
            color: #111 !important;
            padding: 12px 32px;
            border-radius: 30px;
            text-decoration: none !important;
            font-weight: 700;
            font-size: 15px;
            display: inline-block;
            transition: background 0.3s, transform 0.3s;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
        }
        .btn-gold:hover { background: #ffc107; transform: scale(1.05); }

        /* ── Cards ───────────────────────────────────── */
        .card {
            border: none;
            border-radius: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        .card:hover { transform: translateY(-8px); box-shadow: 0 16px 40px rgba(0,0,0,0.14); }

        /* ── Page Hero (inner pages only) ───────────── */
        .page-hero {
            min-height: 380px;
            background: linear-gradient(135deg, #1a1a1a 0%, #111 55%, #1c1200 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-top: 56px;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at center, rgba(255,193,7,0.13) 0%, transparent 68%);
            pointer-events: none;
        }
        .page-hero-content { position: relative; z-index: 2; padding: 0 20px; }

        .page-hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 56px;
            font-weight: 900;
            color: #fff;
            margin: 0;
            text-shadow: 0 4px 28px rgba(0,0,0,0.7);
            line-height: 1.1;
        }
        .page-hero-title span { color: gold; }

        .breadcrumb-bar { margin-top: 16px; font-size: 14px; }
        .breadcrumb-bar a { color: gold; text-decoration: none; }
        .breadcrumb-bar a:hover { text-decoration: underline; }
        .breadcrumb-bar .sep { color: #888; margin: 0 8px; }
        .breadcrumb-bar .current { color: #ddd; }

        /* ── Footer ──────────────────────────────────── */
        footer { background: #111; color: #aaa; padding: 60px 0 0; }
        footer a { color: #aaa; text-decoration: none; transition: color 0.25s; }
        footer a:hover { color: #fff; }

        .footer-link {
            color: #aaa;
            text-decoration: none;
            display: inline-block;
            transition: color 0.25s, padding-left 0.2s;
        }
        .footer-link:hover { color: gold !important; padding-left: 4px; }

        .footer-social {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff !important;
            font-size: 18px;
            text-decoration: none;
            transition: transform 0.3s;
            flex-shrink: 0;
        }
        .footer-social:hover { transform: scale(1.15); }

        /* ── Responsive ──────────────────────────────── */
        @media (max-width: 576px) {
            .page-hero-title { font-size: 34px; }
            .section-title { font-size: 30px; }
        }
    </style>

    {{-- PAGE-SPECIFIC STYLES: each child yields a full <style> block here --}}
    @yield('page-styles')
</head>
<body>

{{-- ═══ NAVBAR ═══ --}}
<nav id="mainNav" class="navbar navbar-expand-lg navbar-dark fixed-top @yield('nav-bg', 'bg-transparent')">
    <div class="container">
        <a class="navbar-brand" href="{{ route('welcome') }}">Venkatesh Tours &amp; Travels</a>
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link @yield('nav-home')" href="{{ route('welcome') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @yield('nav-about')" href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @yield('nav-gallery')" href="{{ route('gallery') }}">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @yield('nav-contact')" href="{{ route('contact') }}">Contact Us</a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link d-flex align-items-center gap-1" href="{{ route('login') }}" title="Login">
                            <i class="bi bi-person-circle" style="font-size:20px;"></i>
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link d-flex align-items-center gap-1" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2" style="font-size:18px;"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
{{-- /NAVBAR --}}


{{-- ═══ PAGE CONTENT ═══ --}}
@yield('content')
{{-- /PAGE CONTENT --}}


{{-- ═══ FOOTER ═══ --}}
<footer>
    <div class="container">
        <div class="row g-4 pb-4">

            <!-- Brand + Social -->
            <div class="col-md-3 col-sm-6">
                <p style="font-family:'Playfair Display',serif;font-size:22px;color:gold;margin-bottom:10px;line-height:1.3;">
                    Venkatesh Tours &amp; Travels
                </p>
                <p style="font-size:14px;line-height:1.75;">Your trusted travel partner for comfortable and affordable journeys across India.</p>
                <div class="mt-3 d-flex gap-3">
                    <a href="https://wa.me/917796208383" target="_blank" title="WhatsApp"
                       class="footer-social" style="background:#25D366;">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank" title="Instagram"
                       class="footer-social" style="background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/" target="_blank" title="Facebook"
                       class="footer-social" style="background:#1877F2;">
                        <i class="bi bi-facebook"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3 col-sm-6">
                <h6 style="color:#fff;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:18px;">Quick Links</h6>
                <ul style="list-style:none;padding:0;margin:0;font-size:14px;line-height:2.4;">
                    <li><a class="footer-link" href="{{ route('welcome') }}"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Home</a></li>
                    <li><a class="footer-link" href="{{ route('about') }}"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> About Us</a></li>
                    <li><a class="footer-link" href="{{ route('gallery') }}"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Gallery</a></li>
                    <li><a class="footer-link" href="{{ route('contact') }}"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Contact Us</a></li>
                    <li><a class="footer-link" href="#"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Privacy Policy</a></li>
                    <li><a class="footer-link" href="#"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Terms of Service</a></li>
                </ul>
            </div>

            <!-- Our Services -->
            <div class="col-md-3 col-sm-6">
                <h6 style="color:#fff;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:18px;">Our Services</h6>
                <ul style="list-style:none;padding:0;margin:0;font-size:14px;line-height:2.4;">
                    <li><a class="footer-link" href="{{ route('welcome') }}#services"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Seater Bus Booking</a></li>
                    <li><a class="footer-link" href="{{ route('welcome') }}#services"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Sleeper Bus Booking</a></li>
                    <li><a class="footer-link" href="{{ route('welcome') }}#services"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Tours Packages</a></li>
                    <li><a class="footer-link" href="{{ route('welcome') }}#services"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Bus Rental</a></li>
                    <li><a class="footer-link" href="{{ route('welcome') }}#services"><i class="bi bi-chevron-right text-warning" style="font-size:11px;"></i> Marriage Booking</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-3 col-sm-6">
                <h6 style="color:#fff;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:18px;">Contact Info</h6>
                <p style="font-size:14px;line-height:1.85;">
                    <i class="bi bi-geo-alt-fill text-warning"></i>&nbsp;
                    Near Tata Showroom, Faltan Road,<br>&nbsp;&nbsp;&nbsp;&nbsp;Baramati, Dist-Pune, Maharashtra
                </p>
                <p style="font-size:14px;">
                    <i class="bi bi-telephone-fill text-warning"></i>&nbsp;
                    <a href="tel:+917796208383">+91 7796208383</a>
                </p>
                <p style="font-size:14px;">
                    <i class="bi bi-envelope-fill text-warning"></i>&nbsp;
                    <a href="mailto:info@venkateshtoursandtravels.com">info@venkateshtoursandtravels.com</a>
                </p>
                <p style="font-size:14px;">
                    <i class="bi bi-clock-fill text-warning"></i>&nbsp;
                    Mon &ndash; Sat: 9:00 AM &ndash; 7:00 PM
                </p>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div style="border-top:1px solid #2a2a2a;padding:20px 0;text-align:center;font-size:13px;">
            &copy; 2026 Venkatesh Tours &amp; Travels | All Rights Reserved
        </div>
    </div>
</footer>
{{-- /FOOTER --}}

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* Navbar transparent → solid on scroll */
    (function () {
        var nav = document.getElementById('mainNav');
        var startTransparent = nav.classList.contains('bg-transparent');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
                if (startTransparent) nav.classList.remove('bg-transparent');
            } else {
                nav.classList.remove('scrolled');
                if (startTransparent) nav.classList.add('bg-transparent');
            }
        }, { passive: true });
    })();
</script>

@yield('scripts')
</body>
</html>