@extends('layouts.admin')
@section('title', 'Pemeliharaan Sistem - Admin')
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
                    <p class="admin-eyebrow">Developer & IT</p>
                    <h1>Pemeliharaan Sistem</h1>
                </div>
            </div>
            <div class="admin-topbar__actions">
                <div class="admin-profile" aria-label="Profil admin">AD</div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-grid admin-grid--two">
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Status Server Terkini</h2>
                            <p>Indikator kesehatan layanan Siboti Gym Management</p>
                        </div>
                        <button type="button" class="admin-small-button">Refresh</button>
                    </div>
                    
                    <div class="admin-progress-list" style="margin-top: 1rem;">
                        <div class="admin-progress-item">
                            <div><span>Database SQL</span><strong>{{ $systemStatus['database']['status'] }}</strong></div>
                            <progress max="100" value="100"></progress>
                        </div>
                        <div class="admin-progress-item">
                            <div><span>Redis Cache</span><strong>{{ $systemStatus['redis']['status'] }}</strong></div>
                            <progress max="100" value="100"></progress>
                        </div>
                        <div class="admin-progress-item admin-progress-item--muted">
                            <div><span>Penyimpanan Lokal</span><strong>{{ $systemStatus['storage']['status'] }}</strong></div>
                            <progress max="100" value="45"></progress>
                        </div>
                    </div>
                </article>

                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Tindakan Pemeliharaan</h2>
                            <p>Aksi cepat untuk merawat performa server</p>
                        </div>
                    </div>
                    <div class="admin-quick-actions" style="grid-template-columns: 1fr;">
                        <a href="#" class="admin-quick-action" style="padding: 1rem;">
                            <span class="material-symbols-outlined" style="color: var(--neon); background: rgba(204, 255, 0, 0.1);">cloud_download</span>
                            <strong>Backup Database</strong>
                            <i class="material-symbols-outlined">chevron_right</i>
                        </a>
                        <a href="#" class="admin-quick-action" style="padding: 1rem;">
                            <span class="material-symbols-outlined" style="color: var(--warning); background: rgba(255, 165, 2, 0.1);">delete_sweep</span>
                            <strong>Bersihkan Cache Aplikasi</strong>
                            <i class="material-symbols-outlined">chevron_right</i>
                        </a>
                        <a href="#" class="admin-quick-action" style="padding: 1rem; border-color: rgba(255, 71, 87, 0.3);">
                            <span class="material-symbols-outlined" style="color: var(--danger); background: rgba(255, 71, 87, 0.1);">power_settings_new</span>
                            <strong style="color: var(--danger);">Aktifkan Mode Maintenance</strong>
                            <i class="material-symbols-outlined">chevron_right</i>
                        </a>
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
