@extends('layouts.public')

@section('title', 'Gallery – Venkatesh Tours & Travels')
@section('nav-bg', 'bg-black')
@section('nav-gallery', 'active-page')

@section('page-styles')
<style>
    /* ── Filter Tabs ─────────────────────────────── */
    .filter-tabs {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
        margin: 52px 0 38px;
    }
    .filter-btn {
        padding: 9px 26px;
        border-radius: 30px;
        border: 2px solid #ddd;
        background: transparent;
        color: #666;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: border-color 0.3s, background 0.3s, color 0.3s;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }
    .filter-btn:hover,
    .filter-btn.active { border-color: gold; background: gold; color: #111; }

    /* ── Masonry Grid ────────────────────────────── */
    .gallery-grid {
        columns: 4;
        column-gap: 16px;
        padding-bottom: 90px;
    }
    @media (max-width: 1200px) { .gallery-grid { columns: 3; } }
    @media (max-width: 768px)  { .gallery-grid { columns: 2; } }
    @media (max-width: 480px)  { .gallery-grid { columns: 1; } }

    .gallery-item {
        break-inside: avoid;
        margin-bottom: 16px;
        border-radius: 14px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        transition: transform 0.3s;
    }
    .gallery-item:hover { transform: scale(1.02); }

    .gallery-item img {
        width: 100%;
        display: block;
        border-radius: 14px;
        transition: filter 0.4s;
        object-fit: cover;
    }
    .gallery-item:hover img { filter: brightness(0.6); }

    .gallery-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: flex-end;
        padding: 18px;
        opacity: 0;
        transition: opacity 0.4s;
        background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, transparent 60%);
        border-radius: 14px;
    }
    .gallery-item:hover .gallery-overlay { opacity: 1; }
    .gallery-overlay h6 { color: #fff; font-weight: 700; margin: 0 0 3px; font-size: 15px; }
    .gallery-overlay small { color: gold; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; }

    .gallery-zoom {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: gold;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #111;
        font-size: 17px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .gallery-item:hover .gallery-zoom { opacity: 1; }

    /* ── Lightbox ────────────────────────────────── */
    .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0,0,0,0.95);
        align-items: center;
        justify-content: center;
    }
    .lightbox.open { display: flex; }

    .lightbox-img {
        max-width: 88vw;
        max-height: 86vh;
        border-radius: 12px;
        box-shadow: 0 20px 80px rgba(0,0,0,0.9);
        display: block;
    }
    .lightbox-close {
        position: absolute;
        top: 22px;
        right: 30px;
        color: #fff;
        font-size: 38px;
        cursor: pointer;
        line-height: 1;
        background: none;
        border: none;
        padding: 0;
        transition: color 0.2s;
    }
    .lightbox-close:hover { color: gold; }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: rgba(255,193,7,0.9);
        color: #111;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        cursor: pointer;
        border: none;
        transition: background 0.25s, transform 0.25s;
    }
    .lightbox-nav:hover { background: gold; transform: translateY(-50%) scale(1.1); }
    #lightboxPrev { left: 22px; }
    #lightboxNext { right: 22px; }

    .lightbox-caption {
        position: absolute;
        bottom: 22px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        font-size: 14px;
        background: rgba(0,0,0,0.55);
        padding: 7px 22px;
        border-radius: 20px;
        white-space: nowrap;
    }
</style>
@endsection

@section('content')

<!-- ─── PAGE HERO ────────────────────────────────────────────────── -->
<div class="page-hero">
    <div class="page-hero-content animate__animated animate__fadeInUp">
        <h1 class="page-hero-title">Our <span>Gallery</span></h1>
        <div class="breadcrumb-bar">
            <a href="{{ route('welcome') }}">Home</a>
            <span class="sep">/</span>
            <span class="current">Gallery</span>
        </div>
    </div>
</div>

<!-- ─── FILTER TABS ──────────────────────────────────────────────── -->
<div class="container">
    <div class="filter-tabs">
        <button class="filter-btn active" data-filter="all">All Photos</button>
        <button class="filter-btn" data-filter="buses">Our Buses</button>
        <button class="filter-btn" data-filter="tours">Tour Destinations</button>
        <button class="filter-btn" data-filter="events">Events &amp; Trips</button>
    </div>
</div>

<!-- ─── GALLERY GRID ─────────────────────────────────────────────── -->
<div class="container">
    <div class="gallery-grid">

        <div class="gallery-item" data-category="tours" data-caption="Goa Beach Tour">
            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&auto=format" alt="Goa Beach" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Tours</small><h6>Goa Beach Tour</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="buses" data-caption="Luxury Sleeper Coach">
            <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=600&auto=format" alt="Sleeper Bus" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Our Buses</small><h6>Luxury Sleeper Coach</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="tours" data-caption="Manali Snow Adventure">
            <img src="https://images.unsplash.com/photo-1598091383021-15ddea10925d?w=600&auto=format" alt="Manali" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Tours</small><h6>Manali Snow Adventure</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="events" data-caption="Wedding Fleet Booking">
            <img src="https://images.unsplash.com/photo-1519741347686-c1e0aadf4611?w=600&auto=format" alt="Wedding" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Events</small><h6>Wedding Fleet Booking</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="buses" data-caption="AC Seater Bus">
            <img src="https://images.unsplash.com/photo-1464219789935-c2d9d9aba644?w=600&auto=format" alt="AC Bus" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Our Buses</small><h6>AC Seater Bus</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="tours" data-caption="Rajasthan Heritage Tour">
            <img src="https://images.unsplash.com/photo-1477587458883-47145ed94245?w=600&auto=format" alt="Rajasthan" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Tours</small><h6>Rajasthan Heritage Tour</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="events" data-caption="Corporate Outing 2024">
            <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=600&auto=format" alt="Corporate Outing" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Events</small><h6>Corporate Outing 2024</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="tours" data-caption="Kerala Backwaters">
            <img src="https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=600&auto=format" alt="Kerala" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Tours</small><h6>Kerala Backwaters</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="buses" data-caption="Mini Bus – 20 Seater">
            <img src="https://images.unsplash.com/photo-1570125909517-53cb21c89ff2?w=600&auto=format" alt="Mini Bus" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Our Buses</small><h6>Mini Bus – 20 Seater</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="events" data-caption="School Excursion Trip">
            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&auto=format" alt="School Trip" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Events</small><h6>School Excursion Trip</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="tours" data-caption="Ladakh Road Trip">
            <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&auto=format" alt="Ladakh" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Tours</small><h6>Ladakh Road Trip</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

        <div class="gallery-item" data-category="buses" data-caption="Volvo Bus – Premium Interior">
            <img src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?w=600&auto=format" alt="Volvo Bus" loading="lazy">
            <div class="gallery-overlay">
                <div><small>Our Buses</small><h6>Volvo Bus – Premium Interior</h6></div>
            </div>
            <div class="gallery-zoom"><i class="bi bi-zoom-in"></i></div>
        </div>

    </div>
</div>

<!-- ─── LIGHTBOX ─────────────────────────────────────────────────── -->
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Image lightbox">
    <button class="lightbox-close" id="lightboxClose" aria-label="Close">&times;</button>
    <button class="lightbox-nav" id="lightboxPrev" aria-label="Previous"><i class="bi bi-chevron-left"></i></button>
    <img id="lightboxImg" class="lightbox-img" src="" alt="">
    <button class="lightbox-nav" id="lightboxNext" aria-label="Next"><i class="bi bi-chevron-right"></i></button>
    <div class="lightbox-caption" id="lightboxCaption"></div>
</div>

@endsection

@section('scripts')
<script>
(function () {
    var filterBtns = document.querySelectorAll('.filter-btn');
    var allItems   = document.querySelectorAll('.gallery-item');

    /* ── Filter ─────────────────────────────────────── */
    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterBtns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var filter = btn.getAttribute('data-filter');
            allItems.forEach(function (item) {
                item.style.display = (filter === 'all' || item.getAttribute('data-category') === filter)
                    ? 'block' : 'none';
            });
        });
    });

    /* ── Lightbox ────────────────────────────────────── */
    var lightbox      = document.getElementById('lightbox');
    var lightboxImg   = document.getElementById('lightboxImg');
    var lightboxCap   = document.getElementById('lightboxCaption');
    var visibleItems  = [];
    var currentIndex  = 0;

    function getVisible() {
        return Array.prototype.filter.call(allItems, function (i) {
            return i.style.display !== 'none';
        });
    }

    function showItem(index) {
        var item = visibleItems[index];
        lightboxImg.src = item.querySelector('img').src;
        lightboxCap.textContent = item.getAttribute('data-caption');
    }

    function openLightbox(item) {
        visibleItems = getVisible();
        currentIndex = visibleItems.indexOf(item);
        if (currentIndex < 0) currentIndex = 0;
        showItem(currentIndex);
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('open');
        document.body.style.overflow = '';
    }

    allItems.forEach(function (item) {
        item.addEventListener('click', function () { openLightbox(item); });
    });

    document.getElementById('lightboxClose').addEventListener('click', closeLightbox);

    document.getElementById('lightboxPrev').addEventListener('click', function () {
        currentIndex = (currentIndex - 1 + visibleItems.length) % visibleItems.length;
        showItem(currentIndex);
    });

    document.getElementById('lightboxNext').addEventListener('click', function () {
        currentIndex = (currentIndex + 1) % visibleItems.length;
        showItem(currentIndex);
    });

    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });

    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('open')) return;
        if (e.key === 'ArrowLeft')  document.getElementById('lightboxPrev').click();
        if (e.key === 'ArrowRight') document.getElementById('lightboxNext').click();
        if (e.key === 'Escape')     closeLightbox();
    });
})();
</script>
@endsection