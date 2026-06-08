<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Check-in — SibotiHUB</title>
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
       MOBILE SIDEBAR TOGGLE
       ══════════════════════════════════════════ */
    .hub-sidebar-toggle {
        display: none;
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
    /* ══════════════════════════════════════════
       QR PAGE GRID
       ══════════════════════════════════════════ */
    .qr-page-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        max-width: 720px;
    }
    /* ══════════════════════════════════════════
       HUB CARD
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
    /* ══════════════════════════════════════════
       QR CARD (center section)
       ══════════════════════════════════════════ */
    .qr-card-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2rem;
    }
    .qr-card-wrapper__badge {
        font-size: 0.6rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.3);
        margin: 0 0 1.5rem;
    }
    .qr-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 280px;
    }
    .qr-card__label {
        margin: 0 0 1rem;
        font-size: 0.6rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.25);
    }
    /* ── QR Code Container ── */
    .qr-code {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        border-radius: 16px;
        padding: 1.25rem;
        width: 100%;
        max-width: 200px;
        aspect-ratio: 1 / 1;
        box-shadow:
            0 0 0 1px rgba(255, 255, 255, 0.06),
            0 8px 30px rgba(0, 0, 0, 0.4);
        position: relative;
        overflow: hidden;
    }
    .qr-code svg {
        width: 100%;
        height: 100%;
        max-width: 140px;
        max-height: 140px;
    }
    /* Subtle pulse glow */
    .qr-code::after {
        content: '';
        position: absolute;
        inset: -2px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(204,255,0,0.15), transparent, rgba(204,255,0,0.08));
        z-index: -1;
        animation: qrGlow 3s ease-in-out infinite;
    }
    @keyframes qrGlow {
        0%, 100% { opacity: 0.4; }
        50% { opacity: 1; }
    }
    .qr-card__name {
        margin: 1.25rem 0 0;
        font-size: 0.95rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.03em;
        text-align: center;
    }
    .qr-card__meta {
        margin: 0.25rem 0 0;
        font-size: 0.68rem;
        color: rgba(255, 255, 255, 0.35);
        font-weight: 600;
        letter-spacing: 0.04em;
        text-align: center;
    }
    .qr-card__status {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin: 0.75rem 0 0;
        font-size: 0.7rem;
        color: #16a34a;
        font-weight: 600;
    }
    /* ── Refresh Button ── */
    .qr-refresh-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 1.5rem;
        padding: 0.55rem 1.25rem;
        font-size: 0.72rem;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        color: #ccff00;
        background: rgba(204, 255, 0, 0.06);
        border: 1px solid rgba(204, 255, 0, 0.15);
        border-radius: 9999px;
        cursor: pointer;
        letter-spacing: 0.03em;
        transition: all 0.25s ease;
    }
    .qr-refresh-btn:hover {
        background: rgba(204, 255, 0, 0.12);
        border-color: rgba(204, 255, 0, 0.3);
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(204, 255, 0, 0.1);
    }
    /* ══════════════════════════════════════════
       RIWAYAT (History)
       ══════════════════════════════════════════ */
    .riwayat-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .riwayat-item {
        padding: 0;
    }
    .riwayat-item__header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.3rem;
    }
    .riwayat-item__dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ccff00;
        flex-shrink: 0;
        box-shadow: 0 0 6px rgba(204, 255, 0, 0.3);
    }
    .riwayat-item__title {
        margin: 0;
        font-size: 0.82rem;
        font-weight: 700;
        color: #eee;
    }
    .riwayat-item__desc {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.4);
        margin: 0;
        padding-left: 1.1rem; /* align with title (dot width + gap) */
    }
    .riwayat-item__rows {
        margin-top: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        padding-left: 1.1rem;
    }
    .riwayat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.55rem 0.75rem;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 8px;
        font-size: 0.72rem;
        transition: border-color 0.2s ease, background 0.2s ease;
    }
    .riwayat-row:hover {
        border-color: rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.03);
    }
    .riwayat-row span:first-child {
        color: #999;
    }
    .riwayat-row span:last-child {
        color: #fff;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }
    /* ══════════════════════════════════════════
       RESPONSIVE — TABLET (≤ 1024px)
       ══════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .qr-page-grid {
            max-width: 100%;
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
        /* Main: full width */
        .hub-main {
            margin-left: 0;
            padding: 1.25rem 1rem;
            padding-top: 3.75rem;
        }
        .hub-main__title {
            font-size: 1.25rem;
        }
        /* QR wrapper */
        .qr-card-wrapper {
            padding: 1.5rem 1rem;
        }
        .qr-card-wrapper__badge {
            margin-bottom: 1rem;
        }
        .qr-code {
            max-width: 180px;
            padding: 1rem;
            border-radius: 14px;
        }
        .qr-card__name {
            font-size: 0.88rem;
        }
        /* Riwayat rows */
        .riwayat-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.2rem;
            padding: 0.5rem 0.65rem;
        }
        .riwayat-item__rows {
            padding-left: 0;
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
        /* QR section */
        .qr-card-wrapper {
            padding: 1.25rem 0.75rem;
        }
        .qr-code {
            max-width: 160px;
            padding: 0.85rem;
            border-radius: 12px;
        }
        .qr-card__name {
            font-size: 0.82rem;
        }
        .qr-card__meta {
            font-size: 0.62rem;
        }
        .qr-card__status {
            font-size: 0.65rem;
        }
        .qr-refresh-btn {
            font-size: 0.68rem;
            padding: 0.5rem 1rem;
            width: 100%;
            justify-content: center;
        }
        /* Cards */
        .hub-card {
            padding: 1rem;
            border-radius: 10px;
        }
        .riwayat-row {
            font-size: 0.68rem;
        }
        .riwayat-item__title {
            font-size: 0.78rem;
        }
        .riwayat-item__desc {
            font-size: 0.65rem;
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
{{-- ══════════ SIDEBAR (tidak diubah) ══════════ --}}
@include('hub.partials.sidebar', ['active' => 'qr'])
{{-- ══════════ SIDEBAR OVERLAY ══════════ --}}
<div class="hub-sidebar-overlay" id="hubSidebarOverlay"></div>
{{-- ══════════ MAIN CONTENT ══════════ --}}
<main class="hub-main">
    {{-- HEADER --}}
    <div class="hub-main__header">
        <div>
            <p class="hub-main__greeting">Tunjukkan QR code ini ke staff</p>
            <h1 class="hub-main__title">QR Check-in</h1>
        </div>
    </div>
    {{-- QR PAGE GRID --}}
    <div class="qr-page-grid">
        {{-- QR Card --}}
        <div class="hub-card qr-card-wrapper">
            <p class="qr-card-wrapper__badge">AKTIF MEMBER PASS</p>
            <div class="qr-card">
                <p class="qr-card__label">SCAN QR CODE</p>
                <div class="qr-code">
                    {{-- QR Code SVG dummy --}}
                    <svg viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="21" height="21" fill="white"/>
                        <rect x="1" y="1" width="7" height="7" fill="black"/>
                        <rect x="2" y="2" width="5" height="5" fill="white"/>
                        <rect x="3" y="3" width="3" height="3" fill="black"/>
                        <rect x="13" y="1" width="7" height="7" fill="black"/>
                        <rect x="14" y="2" width="5" height="5" fill="white"/>
                        <rect x="15" y="3" width="3" height="3" fill="black"/>
                        <rect x="1" y="13" width="7" height="7" fill="black"/>
                        <rect x="2" y="14" width="5" height="5" fill="white"/>
                        <rect x="3" y="15" width="3" height="3" fill="black"/>
                        <rect x="9" y="1" width="1" height="1" fill="black"/>
                        <rect x="11" y="1" width="1" height="1" fill="black"/>
                        <rect x="9" y="3" width="3" height="1" fill="black"/>
                        <rect x="9" y="5" width="1" height="3" fill="black"/>
                        <rect x="11" y="5" width="1" height="1" fill="black"/>
                        <rect x="13" y="9" width="1" height="3" fill="black"/>
                        <rect x="15" y="9" width="3" height="1" fill="black"/>
                        <rect x="15" y="11" width="1" height="3" fill="black"/>
                        <rect x="17" y="11" width="3" height="1" fill="black"/>
                        <rect x="9" y="9" width="3" height="3" fill="black"/>
                        <rect x="1" y="9" width="1" height="3" fill="black"/>
                        <rect x="3" y="9" width="3" height="1" fill="black"/>
                        <rect x="5" y="11" width="1" height="3" fill="black"/>
                        <rect x="9" y="13" width="1" height="5" fill="black"/>
                        <rect x="11" y="13" width="3" height="1" fill="black"/>
                        <rect x="13" y="15" width="1" height="3" fill="black"/>
                        <rect x="15" y="15" width="3" height="1" fill="black"/>
                        <rect x="17" y="17" width="3" height="3" fill="black"/>
                        <rect x="11" y="17" width="1" height="3" fill="black"/>
                    </svg>
                </div>
                <p class="qr-card__name">{{ strtoupper($user->name) }}</p>
                <p class="qr-card__meta">ID: {{ $memberId }} · {{ strtoupper($paketAktif) }}</p>
                <p class="qr-card__status">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="5" fill="#16a34a"/></svg>
                    QR Aktif & Valid
                </p>
            </div>
            <button class="qr-refresh-btn" onclick="this.textContent='Memperbarui..';setTimeout(()=>this.textContent='↺ Refresh QR',1500)">↺ Refresh QR</button>
        </div>
        {{-- Riwayat --}}
        <div class="hub-card">
            <div class="hub-card__header">
                <p class="hub-card__title">Riwayat Check-in</p>
            </div>
            <div class="riwayat-list">
                <div class="riwayat-item">
                    <div class="riwayat-item__header">
                        <div class="riwayat-item__dot"></div>
                        <p class="riwayat-item__title">Aman & Pribadi</p>
                    </div>
                    <p class="riwayat-item__desc">QR code valid. Tidak bisa dipakai ulang dan kedaluwarsa otomatis.</p>
                </div>

                <div class="riwayat-item">
                    <div class="riwayat-item__header">
                        <div class="riwayat-item__dot"></div>
                        <p class="riwayat-item__title">Riwayat Check-in</p>
                    </div>
                    <p class="riwayat-item__desc">Riwayat check-in gym terakhir kamu.</p>
                    
                    @if(count($checkins) > 0)
                    <div class="riwayat-item__rows">
                        @foreach($checkins as $row)
                        <div class="riwayat-row">
                            <span>{{ $row['when'] }} · {{ $row['period'] }} ({{ $row['day'] }})</span>
                            <span>{{ $row['time'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p style="padding-left: 1.1rem; color: rgba(255,255,255,0.4); font-size: 0.75rem; margin-top: 0.5rem;">Belum ada riwayat check-in.</p>
                    @endif
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
    toggle.addEventListener('click', function () {
        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });
    overlay.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar.classList.contains('is-open')) {
            closeSidebar();
        }
    });
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) closeSidebar();
    });
    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });
})();
</script>
</body>
</html>
