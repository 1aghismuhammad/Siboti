@extends('layouts.admin')
@section('title', 'Laporan - Admin')
@section('content')
<div class="admin-shell">
    {{-- OVERLAY MOBILE --}}
    <div class="admin-sidebar-overlay" id="adminSidebarOverlay"></div>
    
    {{-- SIDEBAR --}}
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Navigasi admin">
        <div class="admin-brand">
            <a href="{{ url('/') }}" class="admin-brand__mark" aria-label="Kembali ke beranda Siboti">
                <span class="material-symbols-outlined">fitness_center</span>
            </a>
            <div>
                <p class="admin-brand__name">Siboti</p>
                <p class="admin-brand__label">Gym Management</p>
            </div>
        </div>
        <nav class="admin-menu">
            <a href="{{ route('admin.dashboard') }}" class="admin-menu__item {{ request()->routeIs('admin.dashboard') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.memberships') }}" class="admin-menu__item {{ request()->routeIs('admin.memberships') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">card_membership</span>
                <span>Paket Keanggotaan</span>
            </a>
            <a href="{{ route('admin.trainers') }}" class="admin-menu__item {{ request()->routeIs('admin.trainers') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">fitness_center</span>
                <span>Personal Trainer</span>
            </a>
            <a href="{{ route('admin.bookings') }}" class="admin-menu__item {{ request()->routeIs('admin.bookings') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">event_available</span>
                <span>Booking</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="admin-menu__item {{ request()->routeIs('admin.reports') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">bar_chart</span>
                <span>Laporan</span>
            </a>
        </nav>
        <div class="admin-sidebar__footer">
            <a href="{{ route('admin.maintenance') }}" class="admin-menu__item {{ request()->routeIs('admin.maintenance') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">build</span>
                <span>Pemeliharaan Sistem</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="admin-menu__item admin-menu__item--danger" style="width: 100%; border: 0; background: transparent; cursor: pointer; text-align: left;">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="admin-main">
        {{-- TOPBAR --}}
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle" aria-label="Toggle Menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <p class="admin-eyebrow">Analisis Bisnis</p>
                    <h1>Laporan & Statistik</h1>
                </div>
            </div>
            <div class="admin-topbar__actions">
                <button type="button" class="admin-primary-button">
                    <span class="material-symbols-outlined" style="margin-right: 0.5rem; font-size: 1.2rem;">download</span> Unduh PDF
                </button>
                <div class="admin-profile" aria-label="Profil admin">AD</div>
            </div>
        </header>

        <main class="admin-content">
            {{-- SUMMARY CHARTS --}}
            <section class="admin-grid admin-grid--two">
                <article class="admin-card admin-chart-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Tren Pendapatan Bulanan</h2>
                            <p>Data total revenue bulan Januari hingga Juni</p>
                        </div>
                    </div>
                    <div class="admin-line-chart" aria-hidden="true">
                        <svg viewBox="0 0 600 220" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="lineArea" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#ccff00" stop-opacity="0.28" />
                                    <stop offset="100%" stop-color="#ccff00" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <path d="M0 180 L100 120 L200 150 L300 80 L400 40 L500 70 L600 30 L600 220 L0 220 Z" fill="url(#lineArea)" />
                            <path d="M0 180 L100 120 L200 150 L300 80 L400 40 L500 70 L600 30" fill="none" stroke="#ccff00" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="100" cy="120" r="6" />
                            <circle cx="200" cy="150" r="6" />
                            <circle cx="300" cy="80" r="6" />
                            <circle cx="400" cy="40" r="6" />
                            <circle cx="500" cy="70" r="6" />
                            <circle cx="600" cy="30" r="6" />
                        </svg>
                    </div>
                </article>

                <article class="admin-card admin-chart-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Analisis Kunjungan Member</h2>
                            <p>Tingkat kehadiran per paket keanggotaan</p>
                        </div>
                    </div>
                    <div class="admin-bar-chart" aria-label="Grafik aktivitas">
                        @foreach ([40, 60, 50, 90, 75, 85, 60] as $height)
                            <div class="admin-bar-chart__group">
                                <span class="admin-bar admin-bar--neon" style="height: {{ $height }}%"></span>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('adminSidebarToggle');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminSidebarOverlay');
        const body = document.body;
        function toggleSidebar() {
            const isOpen = sidebar.classList.toggle('is-open');
            overlay.classList.toggle('is-active');
            if (isOpen) {
                body.classList.add('admin-noscroll');
            } else {
                body.classList.remove('admin-noscroll');
            }
        }
        if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);
    });
</script>
@endsection
