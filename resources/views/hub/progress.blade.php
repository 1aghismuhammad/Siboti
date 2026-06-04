<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Progress — SibotiHUB</title>
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
       SIDEBAR OVERLAY & TOGGLE (KONSISTEN)
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
    .hub-sidebar-overlay.is-visible { display: block; opacity: 1; }
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
    .hub-sidebar-toggle:hover { background: #1f1f1f; }
    .hub-sidebar-toggle span {
        display: block;
        width: 18px;
        height: 2px;
        background: #ccff00;
        border-radius: 2px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: center;
    }
    .hub-sidebar-toggle.is-active span:nth-child(1) { transform: translateY(6px) rotate(45deg); }
    .hub-sidebar-toggle.is-active span:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .hub-sidebar-toggle.is-active span:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }
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
    .progress-date {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.4);
        font-weight: 600;
        background: rgba(255, 255, 255, 0.03);
        padding: 0.5rem 0.875rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    /* ══════════════════════════════════════════
       STATS
       ══════════════════════════════════════════ */
    .progress-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .progress-stat {
        background: #111111;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 1.25rem;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .progress-stat:hover {
        transform: translateY(-2px);
        border-color: rgba(204, 255, 0, 0.15);
    }
    .progress-stat__label {
        margin: 0 0 0.5rem;
        font-size: 0.72rem;
        color: #777;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-weight: 600;
    }
    .progress-stat__value {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 900;
        color: #fff;
        line-height: 1;
    }
    .progress-stat__change {
        margin: 0.5rem 0 0;
        font-size: 0.7rem;
        color: #ccff00;
        font-weight: 600;
    }
    .progress-stat__change.down {
        color: #ff6b6b;
    }
    /* ══════════════════════════════════════════
       MAIN GRID
       ══════════════════════════════════════════ */
    .progress-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
        align-items: start;
    }
    .progress-col {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    /* ── HUB CARD ── */
    .hub-card {
        background: #111111;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 1.25rem;
    }
    .hub-card__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
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
    }
    .hub-card__link:hover { text-decoration: underline; }
    /* ── CHART BARS ── */
    .chart-bars {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 0.5rem;
        height: 140px;
        padding-top: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding-bottom: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .chart-bar-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
        height: 100%;
        justify-content: flex-end;
    }
    .chart-bar {
        width: 100%;
        max-width: 32px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        transition: height 0.5s cubic-bezier(0.4, 0, 0.2, 1), background 0.2s;
    }
    .chart-bar:hover { background: rgba(255, 255, 255, 0.2); }
    .chart-bar--active {
        background: #ccff00;
        box-shadow: 0 0 12px rgba(204, 255, 0, 0.3);
    }
    
    .chart-bar--active:hover { background: #d4ff33; }
    .chart-bar-label {
        font-size: 0.7rem;
        color: #777;
        font-weight: 600;
    }
    /* ── ANGKATAN GRID ── */
    .angkatan-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
    }
    .angkatan-item {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 10px;
        padding: 0.85rem;
        text-align: center;
    }
    .angkatan-item__name {
        margin: 0 0 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: #aaa;
    }
    .angkatan-item__value {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 900;
        color: #fff;
    }
    .angkatan-item__unit {
        font-size: 0.75rem;
        color: #777;
    }
    .angkatan-item__change {
        margin: 0.35rem 0 0;
        font-size: 0.65rem;
        color: #ccff00;
        font-weight: 600;
    }
    /* ── TARGET BULANAN ── */
    .target-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .target-item__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .target-item__name {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 600;
        color: #eee;
    }
    .target-item__value {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 700;
        color: #fff;
    }
    .target-bar {
        height: 6px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 3px;
        overflow: hidden;
    }
    .target-bar__fill {
        height: 100%;
        background: #ccff00;
        border-radius: 3px;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    /* ══════════════════════════════════════════
       RESPONSIVE — TABLET (≤ 1024px)
       ══════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .progress-grid { grid-template-columns: 1fr; }
        .progress-stats { grid-template-columns: repeat(2, 1fr); }
    }
    /* ══════════════════════════════════════════
       RESPONSIVE — MOBILE (≤ 768px)
       ══════════════════════════════════════════ */
    @media (max-width: 768px) {
        .hub-sidebar-toggle { display: flex; }
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
        .hub-sidebar.is-open { transform: translateX(0); }
        .hub-main {
            margin-left: 0;
            padding: 1.25rem 1rem;
            padding-top: 3.75rem;
        }
        .hub-main__header { flex-direction: column; gap: 0.75rem; }
        .progress-date { align-self: flex-start; }
        .angkatan-grid { grid-template-columns: repeat(2, 1fr); }
    }
    /* ══════════════════════════════════════════
       RESPONSIVE — SMALL MOBILE (≤ 480px)
       ══════════════════════════════════════════ */
    @media (max-width: 480px) {
        .hub-main { padding: 1rem 0.75rem; padding-top: 3.5rem; }
        .hub-main__title { font-size: 1.2rem; }
        .hub-main__greeting { font-size: 0.75rem; }
        .progress-stats { gap: 0.75rem; }
        .progress-stat { padding: 1rem; }
        .progress-stat__value { font-size: 1.4rem; }
        .chart-bars { gap: 0.3rem; }
        .chart-bar-label { font-size: 0.6rem; }
        .hub-card { padding: 1rem; }
    }
    body.hub-sidebar-open { overflow: hidden; }
    </style>
</head>
<body class="hub-page">
{{-- ══════════ SIDEBAR TOGGLE ══════════ --}}
<button class="hub-sidebar-toggle" id="hubSidebarToggle" aria-label="Toggle sidebar" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
</button>
{{-- ══════════ SIDEBAR OVERLAY ══════════ --}}
<div class="hub-sidebar-overlay" id="hubSidebarOverlay"></div>
{{-- ══════════ SIDEBAR ══════════ --}}
@include('hub.partials.sidebar', ['active' => 'progress'])
{{-- ══════════ MAIN CONTENT ══════════ --}}
<main class="hub-main">
    {{-- HEADER --}}
    <div class="hub-main__header">
        <div>
            <p class="hub-main__greeting">Pantau dua minggu terakhir, terus tingkatkan latihan kamu.</p>
            <h1 class="hub-main__title">Progress Kamu.</h1>
        </div>
        <div class="progress-date">MINGGU INI · 1–7 Jun 2026</div>
    </div>
    {{-- STATS --}}
    <div class="progress-stats">
        @foreach([
            ['Sesi Minggu Ini','18','↑ +2', false],
            ['Total Kalori','12.4k','↑ +8%', false],
            ['Durasi Rata-rata','58m','↓ -3%', true],
            ['Konsistensi','92%','↑ +5%', false],
        ] as $s)
        <div class="progress-stat">
            <p class="progress-stat__label">{{ $s[0] }}</p>
            <p class="progress-stat__value">{{ $s[1] }}</p>
            <p class="progress-stat__change {{ $s[3] ? 'down' : '' }}">{{ $s[2] }}</p>
        </div>
        @endforeach
    </div>
    {{-- MAIN GRID --}}
    <div class="progress-grid">
        
        {{-- KOLOM KIRI --}}
        <div class="progress-col">
            {{-- Grafik Volume --}}
            <div class="hub-card">
                <div class="hub-card__header">
                    <p class="hub-card__title">Volume Mingguan</p>
                    <a href="#" class="hub-card__link">Bulan ini →</a>
                </div>
                <div class="chart-bars">
                    @foreach([
                        ['Sen', 60, false],
                        ['Sel', 40, false],
                        ['Rab', 80, false],
                        ['Kam', 55, false],
                        ['Jum', 90, true],
                        ['Sab', 70, false],
                        ['Min', 30, false],
                    ] as $bar)
                    <div class="chart-bar-wrap">
                        <div class="chart-bar {{ $bar[2] ? 'chart-bar--active' : '' }}"
                             style="height:{{ $bar[1] }}%"></div>
                        <span class="chart-bar-label">{{ $bar[0] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            {{-- Angkatan Utama --}}
            <div class="hub-card">
                <div class="hub-card__header">
                    <p class="hub-card__title">Angkatan Utama</p>
                    <a href="#" class="hub-card__link">Lihat semua →</a>
                </div>
                <div class="angkatan-grid">
                    @foreach([
                        ['Bench Press','80','kg','↑ +5kg'],
                        ['Squat','100','kg','↑ +10kg'],
                        ['Deadlift','120','kg','↑ +7.5kg'],
                        ['OHP','50','kg','↑ +2.5kg'],
                    ] as $a)
                    <div class="angkatan-item">
                        <p class="angkatan-item__name">{{ $a[0] }}</p>
                        <p class="angkatan-item__value">{{ $a[1] }}<span class="angkatan-item__unit"> {{ $a[2] }}</span></p>
                        <p class="angkatan-item__change">{{ $a[3] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- KOLOM KANAN: Target Bulanan --}}
        <div class="progress-col">
            <div class="hub-card">
                <div class="hub-card__header" style="margin-bottom: 1.5rem;">
                    <p class="hub-card__title">Target Bulanan</p>
                </div>
                <div class="target-list">
                    @foreach([
                        ['Berat Badan (kg)','72.5 / 70 kg', 85],
                        ['Volume Angkat (ton)','12.4 / 15 ton', 65],
                        ['Sesi Cardio','8 / 12 sesi', 55],
                        ['Konsistensi Hadir','92% / 90%', 100],
                    ] as $t)
                    <div>
                        <div class="target-item__header">
                            <p class="target-item__name">{{ $t[0] }}</p>
                            <p class="target-item__value">{{ $t[2] }}%</p>
                        </div>
                        <div class="target-bar">
                            <div class="target-bar__fill" style="width:{{ $t[2] }}%"></div>
                        </div>
                        <p style="font-size:0.65rem;color:rgba(255,255,255,0.3);margin-top:0.4rem;font-weight:600;">{{ $t[1] }}</p>
                    </div>
                    @endforeach
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
        if (e.key === 'Escape' && sidebar.classList.contains('is-open')) closeSidebar();
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