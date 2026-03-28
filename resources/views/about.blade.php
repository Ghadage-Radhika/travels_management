@extends('layouts.public')

@section('title', 'About Us – Venkatesh Tours & Travels')
@section('nav-bg', 'bg-black')
@section('nav-about', 'active-page')

@section('page-styles')
<style>
    /* ── Who We Are ─────────────────────────────── */
    .about-feature-img {
        width: 100%;
        object-fit: cover;
        height: 460px;
        border-radius: 24px;
        box-shadow: 20px 20px 0 #ffc107;
        display: block;
    }
    .tag-chip {
        display: inline-block;
        background: #fff8e1;
        color: #b8860b;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 30px;
        margin-bottom: 18px;
    }
    .section-title-left {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #111;
    }
    .section-title-left span { color: #ffc107; }

    .gold-divider {
        width: 60px;
        height: 4px;
        background: gold;
        border-radius: 4px;
        margin: 14px 0 26px;
    }
    .check-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .check-list li {
        padding: 10px 0;
        font-size: 15px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #444;
    }
    .check-list li:last-child { border-bottom: none; }
    .check-list li i { color: gold; font-size: 20px; flex-shrink: 0; }

    /* ── Stats Bar ───────────────────────────────── */
    .stats-bar {
        background: #111;
        padding: 70px 0;
        position: relative;
        overflow: hidden;
    }
    .stats-bar::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 30% 50%, rgba(255,193,7,0.09) 0%, transparent 65%);
        pointer-events: none;
    }
    .stat-number {
        font-family: 'Playfair Display', serif;
        font-size: 56px;
        font-weight: 900;
        color: gold;
        line-height: 1;
    }
    .stat-label {
        font-size: 13px;
        color: #aaa;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-top: 8px;
    }

    /* ── Mission / Vision Cards ─────────────────── */
    .mv-card {
        border: none;
        border-radius: 20px;
        padding: 40px 32px;
        height: 100%;
        box-shadow: 0 8px 30px rgba(0,0,0,0.07);
        transition: transform 0.3s;
        background: #fff;
    }
    .mv-card:hover { transform: translateY(-8px); }
    .mv-icon {
        width: 70px;
        height: 70px;
        background: #fff8e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 22px;
        font-size: 30px;
        color: #ffc107;
    }
    .mv-card h4 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        margin-bottom: 14px;
        color: #111;
    }
    .mv-card p { color: #666; font-size: 15px; line-height: 1.85; margin: 0; }

    /* ── Why Choose Us ───────────────────────────── */
    .why-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        padding: 22px;
        border-radius: 16px;
        transition: box-shadow 0.3s, transform 0.3s;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        background: #fff;
    }
    .why-item:hover { box-shadow: 0 10px 36px rgba(0,0,0,0.1); transform: translateX(5px); }
    .why-icon {
        width: 54px;
        height: 54px;
        background: #fff8e1;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #ffc107;
        flex-shrink: 0;
    }
    .why-item h6 { font-weight: 700; margin-bottom: 6px; font-size: 16px; color: #111; }
    .why-item p { margin: 0; color: #666; font-size: 14px; line-height: 1.65; }

    /* ── CTA Banner ──────────────────────────────── */
    .cta-banner {
        background: linear-gradient(135deg, #1a1a1a 0%, #111 100%);
        padding: 90px 0;
        text-align: center;
    }
    .cta-banner h2 {
        font-family: 'Playfair Display', serif;
        font-size: 42px;
        color: #fff;
        font-weight: 900;
    }
    .cta-banner h2 span { color: gold; }
    .cta-banner p { color: #aaa; font-size: 17px; max-width: 500px; margin: 16px auto 34px; }

    @media (max-width: 768px) {
        .about-feature-img { height: 280px; box-shadow: 10px 10px 0 #ffc107; }
        .section-title-left { font-size: 30px; }
        .stat-number { font-size: 40px; }
        .cta-banner h2 { font-size: 30px; }
    }
</style>
@endsection

@section('content')

<!-- ─── PAGE HERO ────────────────────────────────────────────────── -->
<div class="page-hero">
    <div class="page-hero-content animate__animated animate__fadeInUp">
        <h1 class="page-hero-title">About <span>Us</span></h1>
        <div class="breadcrumb-bar">
            <a href="{{ route('welcome') }}">Home</a>
            <span class="sep">/</span>
            <span class="current">About Us</span>
        </div>
    </div>
</div>

<!-- ─── WHO WE ARE ───────────────────────────────────────────────── -->
<section>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=700&auto=format" class="about-feature-img" alt="Our Bus Fleet">
            </div>
            <div class="col-lg-7">
                <span class="tag-chip">Our Story</span>
                <h2 class="section-title-left">Who We <span>Are</span></h2>
                <div class="gold-divider"></div>
                <p style="color:#555;font-size:16px;line-height:1.9;margin-bottom:20px;">
                    Venkatesh Tours &amp; Travels was founded with a single purpose — to make every journey comfortable, safe, and memorable. Based in Baramati, Maharashtra, we have been serving thousands of happy travellers across India with dedication and passion.
                </p>
                <p style="color:#555;font-size:16px;line-height:1.9;margin-bottom:28px;">
                    From pilgrimage trips to corporate outings, wedding bookings to Himalayan adventures — our fleet and team are ready to take you there.
                </p>
                <ul class="check-list">
                    <li><i class="bi bi-check-circle-fill"></i> Government-registered &amp; fully insured vehicles</li>
                    <li><i class="bi bi-check-circle-fill"></i> Experienced and licensed drivers</li>
                    <li><i class="bi bi-check-circle-fill"></i> 24/7 customer support throughout your journey</li>
                    <li><i class="bi bi-check-circle-fill"></i> Clean, well-maintained AC &amp; Non-AC buses</li>
                    <li><i class="bi bi-check-circle-fill"></i> Customized tour packages at affordable rates</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ─── STATS ────────────────────────────────────────────────────── -->
<div class="stats-bar">
    <div class="container">
        <div class="row g-4 text-center position-relative">
            <div class="col-6 col-md-3">
                <div class="stat-number">15+</div>
                <div class="stat-label">Years of Service</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">10K+</div>
                <div class="stat-label">Happy Travellers</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">50+</div>
                <div class="stat-label">Buses in Fleet</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">200+</div>
                <div class="stat-label">Destinations Covered</div>
            </div>
        </div>
    </div>
</div>

<!-- ─── MISSION / VISION / VALUES ───────────────────────────────── -->
<section style="background:#f9f9f9;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our <span>Mission &amp; Vision</span></h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="mv-card">
                    <div class="mv-icon"><i class="bi bi-rocket-takeoff-fill"></i></div>
                    <h4>Our Mission</h4>
                    <p>To provide safe, comfortable, and affordable travel solutions that connect people to their destinations with a smile.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mv-card">
                    <div class="mv-icon"><i class="bi bi-eye-fill"></i></div>
                    <h4>Our Vision</h4>
                    <p>To become the most trusted and preferred travel company in Maharashtra — known for reliability, warmth, and excellence.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mv-card">
                    <div class="mv-icon"><i class="bi bi-heart-fill"></i></div>
                    <h4>Our Values</h4>
                    <p>Safety first, customer satisfaction always, honest pricing, and a team that treats every traveller like family.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ─── WHY CHOOSE US ────────────────────────────────────────────── -->
<section>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="tag-chip">Why Us</span>
                <h2 class="section-title-left">Why Choose <span>Venkatesh?</span></h2>
                <div class="gold-divider"></div>
                <div class="d-flex flex-column gap-3">
                    <div class="why-item">
                        <div class="why-icon"><i class="bi bi-shield-check-fill"></i></div>
                        <div>
                            <h6>100% Safe Journeys</h6>
                            <p>All buses pass regular safety checks. Every driver is verified, trained, and experienced.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon"><i class="bi bi-cash-coin"></i></div>
                        <div>
                            <h6>Best Price Guarantee</h6>
                            <p>Competitive pricing with no hidden charges. Custom packages to suit any budget.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon"><i class="bi bi-headset"></i></div>
                        <div>
                            <h6>24/7 Customer Support</h6>
                            <p>Our support team is available round the clock before, during, and after your trip.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon"><i class="bi bi-bus-front-fill"></i></div>
                        <div>
                            <h6>Modern Fleet</h6>
                            <p>From AC seater to luxury sleeper coaches — the right bus for every occasion.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=700&auto=format"
                     style="width:100%;border-radius:24px;box-shadow:0 20px 60px rgba(0,0,0,0.12);display:block;" alt="Travel India">
            </div>
        </div>
    </div>
</section>

<!-- ─── CTA ──────────────────────────────────────────────────────── -->
<div class="cta-banner">
    <div class="container">
        <h2>Ready to <span>Travel with Us?</span></h2>
        <p>Book your next journey with Venkatesh Tours &amp; Travels and experience the difference.</p>
        <a href="{{ route('contact') }}" class="btn-gold me-3">Contact Us</a>
        <a href="{{ route('gallery') }}" class="btn btn-outline-warning px-4 py-3 fw-bold rounded-pill">View Gallery</a>
    </div>
</div>

@endsection