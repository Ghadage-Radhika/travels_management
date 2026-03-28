@extends('layouts.public')

@section('title', 'Contact Us – Venkatesh Tours & Travels')
@section('nav-bg', 'bg-black')
@section('nav-contact', 'active-page')

@section('page-styles')
<style>
    /* ── Info Cards ──────────────────────────────── */
    .info-card {
        background: #fff;
        border-radius: 20px;
        padding: 34px 26px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.07);
        transition: transform 0.3s;
        text-align: center;
        height: 100%;
    }
    .info-card:hover { transform: translateY(-8px); }
    .info-card-icon {
        width: 68px;
        height: 68px;
        background: #fff8e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        font-size: 28px;
        color: #ffc107;
    }
    .info-card h5 { font-weight: 700; margin-bottom: 10px; font-size: 17px; color: #111; }
    .info-card p  { color: #666; font-size: 15px; margin: 0; line-height: 1.75; }
    .info-card a  { color: #666; text-decoration: none; transition: color 0.25s; }
    .info-card a:hover { color: #ffc107; }

    /* ── Contact Form Wrap ───────────────────────── */
    .contact-form-wrap {
        background: #fff;
        border-radius: 24px;
        padding: 50px 46px;
        box-shadow: 0 16px 60px rgba(0,0,0,0.09);
    }
    @media (max-width: 576px) { .contact-form-wrap { padding: 32px 24px; } }

    .contact-form-wrap .form-label {
        font-weight: 600;
        font-size: 14px;
        color: #444;
        margin-bottom: 7px;
    }
    .contact-form-wrap .form-control,
    .contact-form-wrap .form-select {
        border-radius: 12px;
        border: 1.5px solid #e5e5e5;
        padding: 13px 16px;
        font-size: 15px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .contact-form-wrap .form-control:focus,
    .contact-form-wrap .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 4px rgba(255,193,7,0.12);
        outline: none;
    }
    .contact-form-wrap .form-control::placeholder { color: #bbb; }

    .btn-submit {
        background: gold;
        color: #111;
        font-weight: 700;
        padding: 14px 40px;
        border-radius: 30px;
        border: none;
        font-size: 15px;
        width: 100%;
        transition: background 0.3s, transform 0.2s;
        cursor: pointer;
        letter-spacing: 0.5px;
    }
    .btn-submit:hover { background: #ffc107; transform: scale(1.02); }

    /* ── Dark Contact Aside ──────────────────────── */
    .contact-aside {
        background: #111;
        color: #eee;
        border-radius: 24px;
        padding: 46px 38px;
        height: 100%;
    }
    .contact-aside h3 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }
    .contact-aside > p { color: #aaa; font-size: 15px; line-height: 1.75; margin-bottom: 28px; }

    .aside-row {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        padding: 18px 0;
        border-top: 1px solid #222;
    }
    .aside-row:first-of-type { border-top: none; padding-top: 0; }

    .aside-icon {
        width: 46px;
        height: 46px;
        background: #1e1e1e;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: gold;
        font-size: 20px;
        flex-shrink: 0;
    }
    .aside-row h6 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 4px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .aside-row p { color: #aaa; margin: 0; font-size: 14px; line-height: 1.65; }
    .aside-row a { color: #aaa; text-decoration: none; transition: color 0.25s; }
    .aside-row a:hover { color: gold; }

    .aside-social { display: flex; gap: 12px; margin-top: 30px; }
    .aside-social a {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff !important;
        font-size: 18px;
        text-decoration: none;
        transition: transform 0.3s;
    }
    .aside-social a:hover { transform: scale(1.15); }

    /* ── Floating WhatsApp ───────────────────────── */
    .whatsapp-float {
        position: fixed;
        bottom: 26px;
        right: 26px;
        z-index: 999;
        width: 58px;
        height: 58px;
        background: #25D366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #fff !important;
        text-decoration: none;
        box-shadow: 0 6px 24px rgba(0,0,0,0.25);
        transition: transform 0.3s;
    }
    .whatsapp-float:hover { transform: scale(1.1); }

    @media (max-width: 768px) {
        .contact-aside { padding: 32px 24px; }
    }
</style>
@endsection

@section('content')

<!-- ─── PAGE HERO ────────────────────────────────────────────────── -->
<div class="page-hero">
    <div class="page-hero-content animate__animated animate__fadeInUp">
        <h1 class="page-hero-title">Contact <span>Us</span></h1>
        <div class="breadcrumb-bar">
            <a href="{{ route('welcome') }}">Home</a>
            <span class="sep">/</span>
            <span class="current">Contact Us</span>
        </div>
    </div>
</div>

<!-- ─── INFO CARDS ───────────────────────────────────────────────── -->
<section style="padding:70px 0 40px;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-card-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <h5>Our Location</h5>
                    <p>Near Tata Showroom, Faltan Road,<br>Baramati, Dist-Pune, Maharashtra</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-card-icon"><i class="bi bi-telephone-fill"></i></div>
                    <h5>Phone</h5>
                    <p><a href="tel:+917796208383">+91 7796208383</a></p>
                    <p style="margin-top:6px;"><small class="text-muted">Mon – Sat: 9:00 AM – 7:00 PM</small></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-card-icon"><i class="bi bi-envelope-fill"></i></div>
                    <h5>Email Us</h5>
                    <p><a href="mailto:info@venkateshtoursandtravels.com">info@venkateshtoursandtravels.com</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ─── FORM + ASIDE ─────────────────────────────────────────────── -->
<section style="padding:40px 0 80px;">
    <div class="container">
        <div class="row g-5">

            <!-- Form -->
            <div class="col-lg-7">
                <div class="contact-form-wrap">
                    <h2 class="section-title" style="text-align:left;margin-bottom:8px;">Send Us a <span>Message</span></h2>
                    <p style="color:#888;font-size:15px;margin-bottom:32px;">Fill in the form and our team will get back to you promptly.</p>

                    @if(session('success'))
                        <div class="alert alert-success rounded-3 mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Your full name"
                                       value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="+91 XXXXX XXXXX"
                                       value="{{ old('phone') }}" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="your@email.com"
                                       value="{{ old('email') }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Service Required</label>
                                <select name="service" class="form-select">
                                    <option value="" disabled selected>Select a service</option>
                                    <option value="seater"  {{ old('service')=='seater'  ? 'selected':'' }}>Seater Bus Booking</option>
                                    <option value="sleeper" {{ old('service')=='sleeper' ? 'selected':'' }}>Sleeper Bus Booking</option>
                                    <option value="tour"    {{ old('service')=='tour'    ? 'selected':'' }}>Tour Package</option>
                                    <option value="rental"  {{ old('service')=='rental'  ? 'selected':'' }}>Bus Rental</option>
                                    <option value="wedding" {{ old('service')=='wedding' ? 'selected':'' }}>Wedding / Event Booking</option>
                                    <option value="other"   {{ old('service')=='other'   ? 'selected':'' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Travel Date</label>
                                <input type="date" name="travel_date" class="form-control" value="{{ old('travel_date') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message / Trip Details <span class="text-danger">*</span></label>
                                <textarea name="message" rows="5"
                                          class="form-control @error('message') is-invalid @enderror"
                                          placeholder="Describe your travel plans, destinations, number of passengers…"
                                          required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-submit">
                                    <i class="bi bi-send-fill me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Aside -->
            <div class="col-lg-5">
                <div class="contact-aside">
                    <h3>Get in Touch</h3>
                    <p>We're just a call or message away. Our team is happy to help you plan your perfect journey.</p>

                    <div class="aside-row">
                        <div class="aside-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <h6>Address</h6>
                            <p>Near Tata Showroom, Faltan Road,<br>Baramati, Dist-Pune, Maharashtra</p>
                        </div>
                    </div>

                    <div class="aside-row">
                        <div class="aside-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <h6>Phone</h6>
                            <p><a href="tel:+917796208383">+91 7796208383</a></p>
                        </div>
                    </div>

                    <div class="aside-row">
                        <div class="aside-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <h6>Email</h6>
                            <p><a href="mailto:info@venkateshtoursandtravels.com">info@venkateshtoursandtravels.com</a></p>
                        </div>
                    </div>

                    <div class="aside-row">
                        <div class="aside-icon"><i class="bi bi-clock-fill"></i></div>
                        <div>
                            <h6>Office Hours</h6>
                            <p>Monday – Saturday: 9:00 AM – 7:00 PM<br>Sunday: Closed</p>
                        </div>
                    </div>

                    <div class="aside-social">
                        <a href="https://wa.me/917796208383" target="_blank" title="WhatsApp" style="background:#25D366;">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" title="Instagram"
                           style="background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.facebook.com/" target="_blank" title="Facebook" style="background:#1877F2;">
                            <i class="bi bi-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ─── MAP ──────────────────────────────────────────────────────── -->
<iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.6!2d74.5784!3d18.1522!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc3838b5e7a2e4b%3A0x0!2sTata+Showroom%2C+Faltan+Road%2C+Baramati%2C+Maharashtra!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"
    width="100%" height="420" style="border:0;display:block;"
    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
    title="Venkatesh Tours &amp; Travels Location">
</iframe>

<!-- Floating WhatsApp -->
<a href="https://wa.me/917796208383" target="_blank" class="whatsapp-float" title="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>

@endsection