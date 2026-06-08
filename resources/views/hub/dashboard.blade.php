<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — SibotiHUB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hub.css') }}">
    <style>
    /* ══════════════════════════════════════════
       BASE & LAYOUT
       ══════════════════════════════════════════ */
    * { box-sizing: border-box; }
    body.hub-page {
        font-family: 'Inter', sans-serif;
        margin: 0;
        background: #0a0a0a;
        color: #e5e5e5;
    }
    .hub-main {
        margin-left: 260px;
        min-height: 100vh;
        padding: 1.5rem 2rem;
        background: #0a0a0a;
        transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    /* ══════════════════════════════════════════
       SIDEBAR OVERLAY (mobile)
       ══════════════════════════════════════════ */
    .hub-sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        z-index: 998 !important;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .hub-sidebar-overlay.is-visible {
        display: block;
        opacity: 1;
    }
    /* ══════════════════════════════════════════
       MOBILE SIDEBAR TOGGLE BUTTON
       ══════════════════════════════════════════ */
    .hub-sidebar-toggle {
        display: none; /* hidden on desktop */
        position: fixed;
        top: 0.85rem;
        left: 0.85rem;
        z-index: 1001 !important;
        width: 40px;
        height: 40px;
        background: #161616;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 4px;
        padding: 0;
        transition: background 0.25s ease;
    }
    .hub-sidebar-toggle:hover {
        background: #1f1f1f;
    }
    .hub-sidebar-toggle span {
        display: block;
        width: 18px;
        height: 2px;
        background: #ccff00;
        border-radius: 2px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: center;
    }
    .hub-sidebar-toggle.is-active span:nth-child(1) {
        transform: translateY(6px) rotate(45deg);
    }
    .hub-sidebar-toggle.is-active span:nth-child(2) {
        opacity: 0;
        transform: scaleX(0);
    }
    .hub-sidebar-toggle.is-active span:nth-child(3) {
        transform: translateY(-6px) rotate(-45deg);
    }
    /* ══════════════════════════════════════════
       HEADER
       ══════════════════════════════════════════ */
    .hub-main__header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .hub-main__greeting {
        margin: 0 0 0.15rem;
        font-size: 0.8rem;
        color: #888;
        letter-spacing: 0.02em;
    }
    .hub-main__title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: #fff;
    }
    .hub-main__actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }
    /* ══════════════════════════════════════════
       BUTTONS
       ══════════════════════════════════════════ */
    .hub-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.55rem 1rem;
        font-size: 0.72rem;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        color: #000;
        background: #ccff00;
        border: none;
        border-radius: 9999px;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
        letter-spacing: 0.03em;
        transition: all 0.25s ease;
    }
    .hub-btn:hover {
        background: #b6e600;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(204, 255, 0, 0.2);
    }
    .hub-btn--ghost {
        background: transparent;
        color: #ccc;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .hub-btn--ghost:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(255, 255, 255, 0.15);
        color: #fff;
        box-shadow: none;
        transform: none;
    }
    /* ══════════════════════════════════════════
       STAT CARDS
       ══════════════════════════════════════════ */
    .hub-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .hub-stat-card {
        background: #111111;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 1.25rem;
        transition: border-color 0.25s ease, transform 0.25s ease;
    }
    .hub-stat-card:hover {
        border-color: rgba(204, 255, 0, 0.15);
        transform: translateY(-2px);
    }
    .hub-stat-card__label {
        margin: 0 0 0.5rem;
        font-size: 0.72rem;
        color: #777;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-weight: 600;
    }
    .hub-stat-card__value {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 900;
        color: #fff;
        line-height: 1;
    }
    .hub-stat-card__unit {
        font-size: 0.8rem;
        font-weight: 600;
        color: #666;
    }
    .hub-stat-card__change {
        margin: 0.5rem 0 0;
        font-size: 0.7rem;
        color: #ccff00;
        font-weight: 600;
    }
    /* ══════════════════════════════════════════
       CONTENT GRID (2 columns)
       ══════════════════════════════════════════ */
    .hub-content-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }
    .hub-content-col {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    /* ══════════════════════════════════════════
       CARDS
       ══════════════════════════════════════════ */
    .hub-card {
        background: #111111;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 1.25rem;
        transition: border-color 0.25s ease;
    }
    .hub-card:hover {
        border-color: rgba(255, 255, 255, 0.1);
    }
    .hub-card__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .hub-card__title {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 700;
        color: #fff;
    }
    .hub-card__link {
        font-size: 0.72rem;
        color: #ccff00;
        text-decoration: none;
        font-weight: 600;
        transition: opacity 0.2s ease;
        white-space: nowrap;
    }
    .hub-card__link:hover {
        opacity: 0.8;
    }
    /* ── JADWAL ITEM ── */
    .jadwal-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        transition: background 0.2s ease;
        border-radius: 8px;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    .jadwal-item:last-child {
        border-bottom: none;
    }
    .jadwal-item:hover {
        background: rgba(255, 255, 255, 0.02);
    }
    .jadwal-item__date {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 42px;
        background: rgba(204, 255, 0, 0.08);
        border-radius: 10px;
        padding: 0.4rem 0.5rem;
    }
    .jadwal-item__day {
        font-size: 0.6rem;
        color: #ccff00;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .jadwal-item__num {
        font-size: 1.1rem;
        font-weight: 900;
        color: #fff;
        line-height: 1.2;
    }
    .jadwal-item__info {
        flex: 1;
        min-width: 0;
    }
    .jadwal-item__name {
        margin: 0;
        font-size: 0.82rem;
        font-weight: 600;
        color: #eee;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .jadwal-item__time {
        margin: 0.15rem 0 0;
        font-size: 0.7rem;
        color: #777;
    }
    .jadwal-item__arrow {
        font-size: 1.2rem;
        color: #444;
        flex-shrink: 0;
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .jadwal-item:hover .jadwal-item__arrow {
        color: #ccff00;
        transform: translateX(2px);
    }
    /* ── AKTIVITAS ── */
    .aktivitas-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }
    .aktivitas-item {
        background: rgba(255, 255, 255, 0.025);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 10px;
        padding: 0.85rem;
        transition: border-color 0.25s ease, transform 0.25s ease;
    }
    .aktivitas-item:hover {
        border-color: rgba(204, 255, 0, 0.12);
        transform: translateY(-1px);
    }
    .aktivitas-item__when {
        margin: 0 0 0.3rem;
        font-size: 0.62rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
    }
    .aktivitas-item__name {
        margin: 0;
        font-size: 0.82rem;
        font-weight: 700;
        color: #eee;
    }
    .aktivitas-item__detail {
        margin: 0.2rem 0 0;
        font-size: 0.72rem;
        color: #ccff00;
        font-weight: 600;
    }
    /* ── PAKET AKTIF ── */
    .paket-aktif {
        background: linear-gradient(145deg, #141414, #0e0e0e);
        border: 1px solid rgba(204, 255, 0, 0.1);
        border-radius: 14px;
        padding: 1.5rem;
    }
    .paket-aktif__label {
        margin: 0 0 0.25rem;
        font-size: 0.68rem;
        color: #ccff00;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }
    .paket-aktif__name {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 900;
        color: #fff;
    }
    .paket-aktif__desc {
        margin: 0.4rem 0 1.25rem;
        font-size: 0.78rem;
        color: #888;
        line-height: 1.5;
    }
    .paket-aktif__info {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }
    .paket-aktif__info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        font-size: 0.75rem;
    }
    .paket-aktif__info-row:last-child {
        border-bottom: none;
    }
    .paket-aktif__info-row span:first-child {
        color: #777;
    }
    .paket-aktif__info-row span:last-child {
        color: #eee;
        font-weight: 600;
    }
    /* ══════════════════════════════════════════
       RESPONSIVE — TABLET (≤ 1024px)
       ══════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .hub-stats {
            grid-template-columns: repeat(2, 1fr);
        }
        .hub-content-grid {
            grid-template-columns: 1fr;
        }
        .aktivitas-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    /* ══════════════════════════════════════════
       RESPONSIVE — MOBILE (≤ 768px)
       ══════════════════════════════════════════ */
    @media (max-width: 768px) {
        /* Tampilkan sidebar toggle */
        .hub-sidebar-toggle {
            display: flex;
        }
        /* Sidebar → offcanvas */
        .hub-sidebar {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            height: 100dvh;
            z-index: 1000 !important;
            transform: translateX(-100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hub-sidebar.is-open {
            transform: translateX(0);
        }
        /* Main content: full width */
        .hub-main {
            margin-left: 0;
            padding: 1.25rem 1rem;
            padding-top: 3.75rem; /* space for toggle button */
        }
        /* Header stacks */
        .hub-main__header {
            flex-direction: column;
            gap: 0.75rem;
        }
        .hub-main__title {
            font-size: 1.25rem;
        }
        .hub-main__actions {
            width: 100%;
        }
        /* Stats: 2 columns */
        .hub-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .hub-stat-card {
            padding: 1rem;
        }
        .hub-stat-card__value {
            font-size: 1.4rem;
        }
        /* Content grid: 1 column */
        .hub-content-grid {
            grid-template-columns: 1fr;
        }
        /* Aktivitas: 1 column on mobile */
        .aktivitas-grid {
            grid-template-columns: 1fr;
        }
        /* Jadwal text truncation */
        .jadwal-item__name {
            white-space: normal;
        }
    }
    /* ══════════════════════════════════════════
       RESPONSIVE — SMALL MOBILE (≤ 480px)
       ══════════════════════════════════════════ */
    @media (max-width: 480px) {
        .hub-main {
            padding: 1rem 0.75rem;
            padding-top: 3.5rem;
        }
        .hub-main__title {
            font-size: 1.1rem;
        }
        .hub-main__greeting {
            font-size: 0.72rem;
        }
        /* Actions stack vertically */
        .hub-main__actions {
            flex-direction: column;
            align-items: stretch;
        }
        .hub-main__actions .hub-btn {
            justify-content: center;
            width: 100%;
        }
        /* Stats: still 2 columns but tighter */
        .hub-stats {
            gap: 0.5rem;
        }
        .hub-stat-card {
            padding: 0.85rem;
            border-radius: 10px;
        }
        .hub-stat-card__value {
            font-size: 1.2rem;
        }
        .hub-stat-card__label {
            font-size: 0.65rem;
        }
        .hub-stat-card__change {
            font-size: 0.62rem;
        }
        /* Cards tighter */
        .hub-card {
            padding: 1rem;
            border-radius: 10px;
        }
        .hub-card__header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.35rem;
        }
        /* Jadwal compact */
        .jadwal-item {
            gap: 0.65rem;
        }
        .jadwal-item__time {
            font-size: 0.65rem;
        }
        /* Paket aktif */
        .paket-aktif {
            padding: 1.15rem;
        }
        .paket-aktif__name {
            font-size: 1.15rem;
        }
        .paket-aktif__info-row {
            font-size: 0.7rem;
        }
    }
    /* ── Lock body scroll saat sidebar terbuka ── */
    body.hub-sidebar-open {
        overflow: hidden;
    }
    </style>
</head>
<body class="hub-page">
{{-- ══════════ SIDEBAR TOGGLE (muncul di ≤768px) ══════════ --}}
<button class="hub-sidebar-toggle" id="hubSidebarToggle" aria-label="Toggle sidebar" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
</button>
{{-- ══════════ SIDEBAR (existing partial — tidak diubah) ══════════ --}}
@include('hub.partials.sidebar', ['active' => 'dashboard'])
{{-- ══════════ SIDEBAR OVERLAY ══════════ --}}
<div class="hub-sidebar-overlay" id="hubSidebarOverlay"></div>
{{-- ══════════ MAIN CONTENT ══════════ --}}
<main class="hub-main">
    {{-- HEADER --}}
    <div class="hub-main__header">
        <div>
            <p class="hub-main__greeting">Selamat datang kembali</p>
            @auth
                <h1 class="hub-main__title">Halo, {{ auth()->user()->name }}. 👋</h1>
            @else
                <h1 class="hub-main__title">Halo, Pengunjung. 👋</h1>
            @endauth
        </div>
        <div class="hub-main__actions">
            <a href="{{ url('/hub/qr') }}" class="hub-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3m0 4h4v-4m-7 0h3"/></svg>
                CHECK IN SEKARANG
            </a>
            @auth
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="hub-btn hub-btn--ghost">LOGOUT</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hub-btn hub-btn--ghost">LOGIN</a>
            @endauth
        </div>
    </div>
    {{-- STATS --}}
    <div class="hub-stats">
        @foreach($stats as $s)
        <div class="hub-stat-card">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <p class="hub-stat-card__label">{{ $s['label'] }}</p>
                    <p class="hub-stat-card__value">{{ $s['value'] }} <span class="hub-stat-card__unit">{{ $s['unit'] }}</span></p>
                </div>
                <div style="width:36px; height:36px; border-radius:10px; background:rgba(204,255,0,0.1); color:#CCFF00; display:flex; align-items:center; justify-content:center; font-size:1.2rem;">
                    @if(str_contains(strtolower($s['label']), 'sesi')) 🏋️ @elseif(str_contains(strtolower($s['label']), 'berat')) ⚖️ @else 📈 @endif
                </div>
            </div>
            <p class="hub-stat-card__change">{{ $s['change'] }}</p>
        </div>
        @endforeach
    </div>
    {{-- CONTENT GRID --}}
    <div class="hub-content-grid">
        {{-- KOLOM KIRI --}}
        <div class="hub-content-col">
            {{-- Jadwal --}}
            <div class="hub-card">
                <div class="hub-card__header">
                    <p class="hub-card__title">Jadwal Mendatang</p>
                    <a href="#" class="hub-card__link">Lihat semua →</a>
                </div>
                @forelse($upcomingBookings as $jadwal)
                <div class="jadwal-item">
                    <div class="jadwal-item__date">
                        <span class="jadwal-item__day">{{ $jadwal['day'] }}</span>
                        <span class="jadwal-item__num">{{ $jadwal['date'] }}</span>
                    </div>
                    <div class="jadwal-item__info">
                        <p class="jadwal-item__name">{{ $jadwal['type'] }}</p>
                        <p class="jadwal-item__time">{{ $jadwal['time_coach'] }}</p>
                    </div>
                    <span class="jadwal-item__arrow">›</span>
                </div>
                @empty
                <p style="padding: 1rem; color: rgba(255,255,255,0.4); text-align: center; font-size: 0.8rem;">Belum ada jadwal booking yang disetujui.</p>
                @endforelse
            </div>
            {{-- Aktivitas --}}
            <div class="hub-card">
                <div class="hub-card__header">
                    <p class="hub-card__title">Aktivitas Terbaru</p>
                    <a href="{{ url('/hub/progress') }}" class="hub-card__link">Lihat progress →</a>
                </div>
                <div class="aktivitas-grid">
                    @forelse($recentActivities as $akt)
                    <div class="aktivitas-item">
                        <p class="aktivitas-item__when">{{ $akt['when'] }}</p>
                        <p class="aktivitas-item__name">{{ $akt['name'] }}</p>
                        <p class="aktivitas-item__detail">{{ $akt['detail'] }}</p>
                    </div>
                    @empty
                    <p style="grid-column: 1 / -1; color: rgba(255,255,255,0.4); font-size: 0.8rem;">Belum ada progress dicatat.</p>
                    @endforelse
                </div>
            </div>
        </div>
        {{-- KOLOM KANAN --}}
        <div class="hub-content-col">
            <div class="paket-aktif">
                <p class="paket-aktif__label">Membership Aktif</p>
                <p class="paket-aktif__name">{{ $paketAktif }}</p>
                <p class="paket-aktif__desc">Berlatih maksimal dengan pendampingan personal trainer.</p>
                <div class="paket-aktif__info">
                    <div class="paket-aktif__info-row">
                        <span>Berlaku hingga</span>
                        <span>{{ $berlakuHingga }}</span>
                    </div>
                    <div class="paket-aktif__info-row">
                        <span>ID Member</span>
                        <span>{{ sprintf('GZ-%05d', $userId) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
{{-- ══════════ JAVASCRIPT ══════════ --}}
<script>
(function () {
    const toggle  = document.getElementById('hubSidebarToggle');
    const overlay = document.getElementById('hubSidebarOverlay');
    // Cari sidebar: coba beberapa selector yang umum digunakan
    const sidebar = document.querySelector('.hub-sidebar')
                 || document.querySelector('[class*="sidebar"]')
                 || document.querySelector('aside');
    if (!toggle || !sidebar) return;
    function openSidebar() {
        sidebar.classList.add('is-open');
        toggle.classList.add('is-active');
        overlay.classList.add('is-visible');
        document.body.classList.add('hub-sidebar-open');
        toggle.setAttribute('aria-expanded', 'true');
    }
    function closeSidebar() {
        sidebar.classList.remove('is-open');
        toggle.classList.remove('is-active');
        overlay.classList.remove('is-visible');
        document.body.classList.remove('hub-sidebar-open');
        toggle.setAttribute('aria-expanded', 'false');
    }
    // Toggle
    toggle.addEventListener('click', function () {
        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });
    // Overlay click → close
    overlay.addEventListener('click', closeSidebar);
    // Escape key → close
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar.classList.contains('is-open')) {
            closeSidebar();
        }
    });
    // Auto-close on resize to desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
    // Close sidebar when clicking nav links inside it
    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 768) {
                closeSidebar();
            }
        });
    });
})();
</script>
</body>
</html>
