<!-- ===================== SIBOTI NAVBAR ===================== -->
<style>
/* ── RESET ── */
* {
    box-sizing: border-box;
}
/* ── NAVBAR CONTAINER ── */
.navbar-top {
    position: fixed;
    top: 0;
    width: 100%;
    background: linear-gradient(to bottom, #000000, #0b0b0b);
    z-index: 1000;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}
.navbar-top__inner {
    max-width: 1280px;
    margin: auto;
    padding: 0.75rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}
/* ── LOGO ── */
.navbar-top__logo {
    display: flex;
    align-items: flex-end;
    gap: 0.2rem;
    font-weight: 800;
    color: #ffffff;
    text-decoration: none;
    z-index: 1001;
}
.navbar-top__logo img {
    height: 40px;
}
/* ── DESKTOP MENU ── */
.navbar-top__menu {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
}
.navbar-top__menu li {
    list-style: none;
}
.navbar-top__menu a {
    color: #e5e5e5;
    font-size: 0.875rem;
    text-decoration: none;
    transition: color 0.25s ease;
    position: relative;
}
.navbar-top__menu a::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 2px;
    background: #ccff00;
    transition: width 0.3s ease;
    border-radius: 2px;
}
.navbar-top__menu a:hover {
    color: #ccff00;
}
.navbar-top__menu a:hover::after {
    width: 100%;
}
/* ── ACTIONS (user icon + CTA) ── */
.navbar-top__actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: 1001;
}
/* ── USER ICON ── */
.navbar-top__user {
    display: flex;
    align-items: center;
    justify-content: center;
}
.navbar-top__user img {
    width: 36px;
    height: 36px;
    border-radius: 9999px;
    object-fit: cover;
    border: 1px solid #222;
    transition: border-color 0.25s ease;
}
.navbar-top__user:hover img {
    border-color: #ccff00;
}
/* ── CTA BUTTON ── */
.navbar-top__cta {
    background: #ccff00;
    color: #000;
    font-weight: 700;
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    text-decoration: none;
    transition: all 0.25s ease;
    white-space: nowrap;
}
.navbar-top__cta:hover {
    background: #b6e600;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(204, 255, 0, 0.25);
}
/* ── HAMBURGER TOGGLE ── */
.navbar-top__toggle {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 36px;
    height: 36px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    z-index: 1001;
    gap: 5px;
}
.navbar-top__toggle span {
    display: block;
    width: 22px;
    height: 2px;
    background: #ffffff;
    border-radius: 2px;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    transform-origin: center;
}
/* Hamburger → X animation */
.navbar-top__toggle.is-active span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}
.navbar-top__toggle.is-active span:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}
.navbar-top__toggle.is-active span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}
/* ── OVERLAY (mobile backdrop) ── */
.navbar-top__overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
    z-index: 999;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.navbar-top__overlay.is-visible {
    display: block;
    opacity: 1;
}
/* ── SPACER ── */
.navbar-spacer {
    height: 64px;
}
/* ══════════════════════════════════════════
   RESPONSIVE — TABLET (≤ 900px)
   ══════════════════════════════════════════ */
@media (max-width: 900px) {
    .navbar-top__menu {
        gap: 1rem;
    }
    .navbar-top__menu a {
        font-size: 0.8rem;
    }
    .navbar-top__cta {
        font-size: 0.7rem;
        padding: 0.45rem 0.85rem;
    }
}
/* ══════════════════════════════════════════
   RESPONSIVE — MOBILE (≤ 768px)
   ══════════════════════════════════════════ */
@media (max-width: 768px) {
    .navbar-top__inner {
        padding: 0.65rem 1rem;
    }
    /* Tampilkan hamburger */
    .navbar-top__toggle {
        display: flex;
    }
    /* Sembunyikan CTA di navbar utama (pindah ke menu mobile) */
    .navbar-top__cta {
        display: none;
    }
    /* ── MOBILE MENU ── */
    .navbar-top__menu {
        position: fixed;
        top: 0;
        right: 0;
        width: 280px;
        height: 100vh;
        height: 100dvh;
        flex-direction: column;
        align-items: flex-start;
        gap: 0;
        background: #0a0a0a;
        padding: 80px 1.5rem 2rem;
        transform: translateX(100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 1px solid rgba(255, 255, 255, 0.08);
        overflow-y: auto;
    }
    .navbar-top__menu.is-open {
        transform: translateX(0);
    }
    .navbar-top__menu li {
        width: 100%;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
    }
    .navbar-top__menu.is-open li {
        opacity: 1;
        transform: translateX(0);
    }
    /* Stagger animation delay untuk tiap item */
    .navbar-top__menu.is-open li:nth-child(1) { transition-delay: 0.08s; }
    .navbar-top__menu.is-open li:nth-child(2) { transition-delay: 0.14s; }
    .navbar-top__menu.is-open li:nth-child(3) { transition-delay: 0.20s; }
    .navbar-top__menu.is-open li:nth-child(4) { transition-delay: 0.26s; }
    .navbar-top__menu.is-open li:nth-child(5) { transition-delay: 0.32s; }
    .navbar-top__menu a {
        display: block;
        font-size: 1rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        color: #d4d4d4;
        width: 100%;
    }
    .navbar-top__menu a::after {
        display: none;
    }
    .navbar-top__menu a:hover {
        color: #ccff00;
        padding-left: 0.5rem;
    }
    /* CTA inside mobile menu */
    .navbar-top__menu-cta {
        display: inline-block !important;
        margin-top: 1.5rem;
        background: #ccff00;
        color: #000;
        font-weight: 700;
        padding: 0.7rem 1.5rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        text-decoration: none;
        text-align: center;
        width: 100%;
        transition: background 0.25s ease;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.35s ease 0.38s;
    }
    .navbar-top__menu.is-open .navbar-top__menu-cta {
        opacity: 1;
        transform: translateY(0);
    }
    .navbar-top__menu-cta:hover {
        background: #b6e600;
    }
}
/* ══════════════════════════════════════════
   RESPONSIVE — SMALL MOBILE (≤ 400px)
   ══════════════════════════════════════════ */
@media (max-width: 400px) {
    .navbar-top__inner {
        padding: 0.6rem 0.75rem;
    }
    .navbar-top__logo img {
        height: 32px;
    }
    .navbar-top__logo span {
        font-size: 0.9rem;
    }
    .navbar-top__user img {
        width: 30px;
        height: 30px;
    }
    .navbar-top__menu {
        width: 100%;
    }
}
/* ── Nonaktifkan scroll saat menu terbuka ── */
body.navbar-menu-open {
    overflow: hidden;
}
</style>
<!-- ══════════════════════════════════════════ -->
<!-- NAVBAR HTML                               -->
<!-- ══════════════════════════════════════════ -->
<nav class="navbar-top" id="navbarTop">
    <div class="navbar-top__inner">
        <!-- LOGO -->
        <a href="/" class="navbar-top__logo">
            <span>SIBOTI</span>
            <img src="image/Icon/logo_putih.webp" alt="Siboti Logo">
        </a>
        <!-- MENU -->
        <ul class="navbar-top__menu" id="navbarMenu">
            <li><a href="#">Beranda</a></li>
            <li><a href="#fasilitas">Fasilitas</a></li>
            <li><a href="#trainer">Trainer</a></li>
            <li><a href="#paket">Paket</a></li>
            <li><a href="#kontak">Kontak</a></li>
            <!-- CTA duplikat khusus mobile menu (tersembunyi di desktop) -->
            @guest
                <a href="{{ route('login') }}" class="navbar-top__menu-cta" style="display:none;">BOOKING SEKARANG →</a>
            @else
                <a href="{{ url('/hub/booking') }}" class="navbar-top__menu-cta" style="display:none;">BOOKING SEKARANG →</a>
            @endguest
        </ul>
        <!-- RIGHT ACTIONS -->
        <div class="navbar-top__actions">
            <a href="/login" class="navbar-top__user">
                <img src="Image/Icon/user.webp" alt="User">
            </a>
            <!-- CTA desktop (tersembunyi di mobile via CSS) -->
            @guest
                <a href="{{ route('login') }}" class="btn-primary navbar-top__cta">BOOKING SEKARANG →</a>
            @else
                <a href="{{ url('/hub/booking') }}" class="btn-primary navbar-top__cta">BOOKING SEKARANG →</a>
            @endguest
            <!-- HAMBURGER (muncul di ≤768px) -->
            <button class="navbar-top__toggle" id="navbarToggle" aria-label="Toggle menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</nav>
<!-- OVERLAY -->
<div class="navbar-top__overlay" id="navbarOverlay"></div>
<!-- SPACER -->
<div class="navbar-spacer"></div>
<!-- ══════════════════════════════════════════ -->
<!-- JAVASCRIPT (Vanilla, no dependencies)     -->
<!-- ══════════════════════════════════════════ -->
<script>
(function () {
    const toggle  = document.getElementById('navbarToggle');
    const menu    = document.getElementById('navbarMenu');
    const overlay = document.getElementById('navbarOverlay');
    function openMenu() {
        menu.classList.add('is-open');
        toggle.classList.add('is-active');
        overlay.classList.add('is-visible');
        document.body.classList.add('navbar-menu-open');
        toggle.setAttribute('aria-expanded', 'true');
    }
    function closeMenu() {
        menu.classList.remove('is-open');
        toggle.classList.remove('is-active');
        overlay.classList.remove('is-visible');
        document.body.classList.remove('navbar-menu-open');
        toggle.setAttribute('aria-expanded', 'false');
    }
    // Toggle hamburger
    toggle.addEventListener('click', function () {
        if (menu.classList.contains('is-open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });
    // Klik overlay → tutup
    overlay.addEventListener('click', closeMenu);
    // Klik menu link → tutup (supaya anchor scroll berjalan)
    menu.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMenu);
    });
    // Tutup saat layar di-resize ke desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            closeMenu();
        }
    });
    // Tutup dengan tombol Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && menu.classList.contains('is-open')) {
            closeMenu();
        }
    });
})();
</script>