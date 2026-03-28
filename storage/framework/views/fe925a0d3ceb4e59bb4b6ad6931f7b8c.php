<?php $__env->startSection('title', 'Venkatesh Tours & Travels'); ?>
<?php $__env->startSection('nav-bg', 'bg-transparent'); ?>
<?php $__env->startSection('nav-home', 'active-page'); ?>

<?php $__env->startSection('page-styles'); ?>
<style>
    /* ── Hero Carousel ─────────────────────────── */
    .hero-slide {
        height: 100vh;
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
    }
    .hero-slide::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.55);
    }
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        padding: 0 20px;
    }
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 56px;
        font-weight: 900;
        text-shadow: 2px 4px 12px rgba(0,0,0,0.6);
        line-height: 1.1;
        margin-bottom: 0;
    }
    .hero-subtitle {
        font-size: 18px;
        font-weight: 300;
        letter-spacing: 1px;
        margin: 16px 0 28px;
        opacity: 0.9;
    }
    .hero-badge {
        display: inline-block;
        background: gold;
        color: #111;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 6px 18px;
        border-radius: 30px;
        margin-bottom: 20px;
    }
    .hero-info-strip {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 30px;
        flex-wrap: wrap;
    }
    .hero-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.5px;
        opacity: 0.9;
    }
    .hero-info-item i { color: gold; font-size: 18px; }
    .carousel-control-prev,
    .carousel-control-next { width: 5%; }

    /* ── Services ──────────────────────────────── */
    .service-icon {
        width: 70px;
        height: 70px;
        background: #fff8e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    /* ── About on welcome ──────────────────────── */
    #about { background-color: #f8f9fa; }

    /* ── Contact form ──────────────────────────── */
    #contact .form-control {
        border-radius: 10px;
        border: 1.5px solid #e0e0e0;
        padding: 11px 14px;
        font-size: 15px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    #contact .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 4px rgba(255,193,7,0.15);
        outline: none;
    }

    @media (max-width: 576px) {
        .hero-title { font-size: 34px; }
        .hero-info-strip { gap: 14px; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- ─── HERO CAROUSEL ───────────────────────────────────────────── -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">

        <div class="carousel-item active">
            <div class="hero-slide" style="background-image:url('https://images.unsplash.com/photo-1722934804353-0d9f6a55ab5e?q=80&w=1200&auto=format&fit=crop')">
                <div class="hero-content animate__animated animate__fadeInUp">
                    <span class="hero-badge">🏛 Heritage Destination</span>
                    <h1 class="hero-title">Hampi Heritage Tour</h1>
                    <p class="hero-subtitle">Ancient Temples · Stone Chariots · Virupaksha Ruins</p>
                    <a href="#contact" class="btn-gold">Explore</a>
                    <div class="hero-info-strip">
                        <div class="hero-info-item"><i class="bi bi-map"></i> UNESCO World Heritage</div>
                        <div class="hero-info-item"><i class="bi bi-people-fill"></i> Group Packages</div>
                        <div class="hero-info-item"><i class="bi bi-camera"></i> Guided Tours</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="hero-slide" style="background-image:url('https://plus.unsplash.com/premium_photo-1697730359975-8f1885936530?w=1200&auto=format&fit=crop&q=60')">
                <div class="hero-content animate__animated animate__fadeInUp">
                    <span class="hero-badge">🏔 North India Tours</span>
                    <h1 class="hero-title">Uttar Bharat Trips</h1>
                    <p class="hero-subtitle">Shimla · Manali · Kashmir · Leh · Dharamshala</p>
                    <a href="#contact" class="btn-gold">Book Now</a>
                    <div class="hero-info-strip">
                        <div class="hero-info-item"><i class="bi bi-calendar-check"></i> 10–15 Day Packages</div>
                        <div class="hero-info-item"><i class="bi bi-bus-front"></i> Sleeper Buses</div>
                        <div class="hero-info-item"><i class="bi bi-shield-check"></i> Safe &amp; Comfortable</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="hero-slide" style="background-image:url('https://media.istockphoto.com/id/2184292292/photo/rock-cut-caves-of-6th-century-badami.webp?a=1&b=1&s=612x612&w=0&k=20&c=ehdwmuTwznV8y5phHwRnYiIHPjG5jcypdjK9Cw7KEE4=')">
                <div class="hero-content animate__animated animate__fadeInUp">
                    <span class="hero-badge">🪨 Cave Temples</span>
                    <h1 class="hero-title">Badami Caves</h1>
                    <p class="hero-subtitle">Rock-cut Temples · Chalukya Architecture · Agastya Lake</p>
                    <a href="#contact" class="btn-gold">View Details</a>
                    <div class="hero-info-strip">
                        <div class="hero-info-item"><i class="bi bi-clock-history"></i> 6th Century History</div>
                        <div class="hero-info-item"><i class="bi bi-geo-alt-fill"></i> Karnataka, India</div>
                        <div class="hero-info-item"><i class="bi bi-star-fill"></i> Top-rated Tour</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="hero-slide" style="background-image:url('https://media.istockphoto.com/id/1382471104/photo/scenic-wid-horizontal-view-of-beach-and-coast-line.webp?a=1&b=1&s=612x612&w=0&k=20&c=JVsagH90oTHQV5U4sH8XxVtMFSrA-JSsoh4eI3QQ6Cc=')">
                <div class="hero-content animate__animated animate__fadeInUp">
                    <span class="hero-badge">🌊 Beach Getaway</span>
                    <h1 class="hero-title">Kokan &amp; Sleeper Trips</h1>
                    <p class="hero-subtitle">Ganpatipule · Ratnagiri · Tarkarli · Sindhudurg</p>
                    <a href="#contact" class="btn-gold">Plan Trip</a>
                    <div class="hero-info-strip">
                        <div class="hero-info-item"><i class="bi bi-moon-stars-fill"></i> Overnight Sleeper</div>
                        <div class="hero-info-item"><i class="bi bi-sunset"></i> Scenic Coastline</div>
                        <div class="hero-info-item"><i class="bi bi-currency-rupee"></i> Budget Friendly</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
    </div>
</div>

<!-- ─── SERVICES ────────────────────────────────────────────────── -->
<section id="services">
    <div class="container">
        <h2 class="section-title">Our <span>Services</span></h2>
        <div class="row g-4 justify-content-center">

            <div class="col-md-3 col-sm-6">
                <div class="card p-4 text-center h-100">
                    <div class="service-icon"><i class="bi bi-bus-front fs-2 text-warning"></i></div>
                    <h5 class="fw-bold">Seater Bus Booking</h5>
                    <p class="text-muted small">Comfortable seater buses for day trips and short-distance travel with reclining seats.</p>
                    <a href="#contact" class="btn btn-outline-warning btn-sm mt-auto rounded-pill">Book Now</a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card p-4 text-center h-100">
                    <div class="service-icon"><i class="bi bi-moon-stars fs-2 text-warning"></i></div>
                    <h5 class="fw-bold">Sleeper Bus Booking</h5>
                    <p class="text-muted small">Fully flat sleeper berths with AC for overnight long-distance journeys across India.</p>
                    <a href="#contact" class="btn btn-outline-warning btn-sm mt-auto rounded-pill">Book Now</a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card p-4 text-center h-100">
                    <div class="service-icon"><i class="bi bi-map fs-2 text-warning"></i></div>
                    <h5 class="fw-bold">Tours Packages</h5>
                    <p class="text-muted small">All-inclusive packages covering North India, Karnataka, Goa, Kokan &amp; more.</p>
                    <a href="#contact" class="btn btn-outline-warning btn-sm mt-auto rounded-pill">Explore</a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card p-4 text-center h-100">
                    <div class="service-icon"><i class="bi bi-truck-front fs-2 text-warning"></i></div>
                    <h5 class="fw-bold">Bus Rental</h5>
                    <p class="text-muted small">Hire buses for weddings, corporate events, school picnics, and private group travel.</p>
                    <a href="#contact" class="btn btn-outline-warning btn-sm mt-auto rounded-pill">Enquire</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ─── ABOUT ────────────────────────────────────────────────────── -->
<section id="about">
    <div class="container">
        <h2 class="section-title">About <span>Us</span></h2>
        <div class="row align-items-center g-4">
            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80"
                     class="img-fluid rounded-4 shadow" alt="Travel Bus">
            </div>
            <div class="col-md-6">
                <p class="lead fw-semibold">
                    Venkatesh Tours &amp; Travels provides safe, comfortable, and affordable travel services across Maharashtra and India.
                </p>
                <p class="text-muted">
                    We specialise in local Maharashtra trips, sleeper buses, North India tours, and bus rentals for all occasions. With years of experience and a fleet of well-maintained buses, our mission is to create memorable travel experiences for every passenger.
                </p>
                <div class="row mt-4 text-center g-3">
                    <div class="col-4">
                        <h3 class="fw-bold text-warning mb-0">10+</h3>
                        <small class="text-muted">Years Experience</small>
                    </div>
                    <div class="col-4">
                        <h3 class="fw-bold text-warning mb-0">500+</h3>
                        <small class="text-muted">Trips Completed</small>
                    </div>
                    <div class="col-4">
                        <h3 class="fw-bold text-warning mb-0">5000+</h3>
                        <small class="text-muted">Happy Travellers</small>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="<?php echo e(route('about')); ?>" class="btn-gold">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ─── CONTACT ──────────────────────────────────────────────────── -->
<section id="contact">
    <div class="container">
        <h2 class="section-title">Contact <span>Us</span></h2>
        <div class="row g-4">
            <div class="col-md-6">
                <form method="POST" action="<?php echo e(route('contact.send')); ?>">
                    <?php echo csrf_field(); ?>
                    <input  type="text"  name="name"    class="form-control mb-3" placeholder="Your Name"         required>
                    <input  type="email" name="email"   class="form-control mb-3" placeholder="Your Email">
                    <input  type="tel"   name="phone"   class="form-control mb-3" placeholder="Your Phone Number"  required>
                    <textarea            name="message" class="form-control mb-3" rows="4" placeholder="Message / Trip Details" required></textarea>
                    <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill py-2">Send Message</button>
                </form>
            </div>
            <div class="col-md-6 ps-md-5">
                <h5>📍 Location:</h5>
                <p class="text-muted">Near Tata Showroom, Faltan Road, Baramati, Dist-Pune, Maharashtra</p>
                <h5>📞 Phone:</h5>
                <p><a href="tel:+917796208383" style="color:#111;">+91 7796208383</a></p>
                <h5>✉ Email:</h5>
                <p><a href="mailto:info@venkateshtoursandtravels.com" style="color:#111;">info@venkateshtoursandtravels.com</a></p>
                <h5>🕐 Office Hours:</h5>
                <p class="text-muted">Mon – Sat: 9:00 AM – 7:00 PM</p>
            </div>
        </div>
    </div>
</section>

<!-- ─── MAP ──────────────────────────────────────────────────────── -->
<section style="padding:0;">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.6!2d74.5784!3d18.1522!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc3838b5e7a2e4b%3A0x0!2sTata+Showroom%2C+Faltan+Road%2C+Baramati%2C+Maharashtra!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"
        width="100%" height="420" style="border:0;display:block;"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        title="Venkatesh Tours &amp; Travels Location">
    </iframe>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    /* Re-animate hero content on each carousel slide change */
    document.getElementById('heroCarousel').addEventListener('slide.bs.carousel', function (e) {
        var incoming = e.relatedTarget.querySelector('.hero-content');
        if (incoming) {
            incoming.classList.remove('animate__animated', 'animate__fadeInUp');
            void incoming.offsetWidth;
            incoming.classList.add('animate__animated', 'animate__fadeInUp');
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\travels_management\resources\views/welcome.blade.php ENDPATH**/ ?>