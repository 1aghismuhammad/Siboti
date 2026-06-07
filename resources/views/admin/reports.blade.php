@extends('layouts.admin')
@section('title', 'Laporan - Admin')
@section('content')
<div class="admin-shell">
    <div class="admin-sidebar-overlay" id="adminSidebarOverlay"></div>
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Navigasi admin">
        <div class="admin-brand">
            <a href="{{ url('/') }}" class="admin-brand__mark">
                <span class="material-symbols-outlined">fitness_center</span>
            </a>
            <div>
                <p class="admin-brand__name">Siboti</p>
                <p class="admin-brand__label">Gym Management</p>
            </div>
        </div>
        <nav class="admin-menu">
            <a href="{{ route('admin.dashboard') }}" class="admin-menu__item {{ request()->routeIs('admin.dashboard') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">dashboard</span><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.memberships') }}" class="admin-menu__item {{ request()->routeIs('admin.memberships') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">card_membership</span><span>Paket Keanggotaan</span>
            </a>
            <a href="{{ route('admin.trainers') }}" class="admin-menu__item {{ request()->routeIs('admin.trainers') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">fitness_center</span><span>Personal Trainer</span>
            </a>
            <a href="{{ route('admin.bookings') }}" class="admin-menu__item {{ request()->routeIs('admin.bookings') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">event_available</span><span>Booking</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="admin-menu__item {{ request()->routeIs('admin.reports') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">bar_chart</span><span>Laporan</span>
            </a>
        </nav>
        <div class="admin-sidebar__footer">
            <a href="{{ route('admin.maintenance') }}" class="admin-menu__item {{ request()->routeIs('admin.maintenance') ? 'admin-menu__item--active' : '' }}">
                <span class="material-symbols-outlined">build</span><span>Pemeliharaan Sistem</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="admin-menu__item admin-menu__item--danger" style="width:100%;border:0;background:transparent;cursor:pointer;text-align:left;">
                    <span class="material-symbols-outlined">logout</span><span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <p class="admin-eyebrow">Analisis Bisnis</p>
                    <h1>Laporan & Statistik</h1>
                </div>
            </div>
            <div class="admin-topbar__actions">
                <button type="button" class="admin-primary-button" id="btnUnduhPDF">
                    <span class="material-symbols-outlined" style="font-size:1.1rem;">download</span>
                    Unduh PDF
                </button>
                <div class="admin-profile">AD</div>
            </div>
        </header>

        <main class="admin-content">
            {{-- RINGKASAN STATS --}}
            <section class="admin-stats" id="reportStats">
                <article class="admin-card admin-stat-card">
                    <div class="admin-stat-card__top">
                        <div class="admin-card-icon"><span class="material-symbols-outlined">payments</span></div>
                        <span class="admin-pill admin-pill--success">+12%</span>
                    </div>
                    <p>Total Pendapatan</p>
                    <h2>Rp84,5jt</h2>
                </article>
                <article class="admin-card admin-stat-card">
                    <div class="admin-stat-card__top">
                        <div class="admin-card-icon"><span class="material-symbols-outlined">group</span></div>
                        <span class="admin-pill admin-pill--success">+8%</span>
                    </div>
                    <p>Member Aktif</p>
                    <h2>342</h2>
                </article>
                <article class="admin-card admin-stat-card">
                    <div class="admin-stat-card__top">
                        <div class="admin-card-icon"><span class="material-symbols-outlined">event_available</span></div>
                        <span class="admin-pill admin-pill--warning">-3%</span>
                    </div>
                    <p>Total Booking</p>
                    <h2>128</h2>
                </article>
                <article class="admin-card admin-stat-card">
                    <div class="admin-stat-card__top">
                        <div class="admin-card-icon"><span class="material-symbols-outlined">how_to_reg</span></div>
                        <span class="admin-pill admin-pill--success">+5%</span>
                    </div>
                    <p>Rata-rata Kunjungan</p>
                    <h2>4,2x</h2>
                </article>
            </section>

            {{-- CHARTS --}}
            <section class="admin-grid admin-grid--two" id="reportCharts">
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Tren Pendapatan Bulanan</h2>
                            <p>Data total revenue Januari hingga Juni 2026</p>
                        </div>
                    </div>
                    <div class="admin-line-chart">
                        <svg viewBox="0 0 600 220" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="lineArea2" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#ccff00" stop-opacity="0.28"/>
                                    <stop offset="100%" stop-color="#ccff00" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <path d="M0 180 L100 120 L200 150 L300 80 L400 40 L500 70 L600 30 L600 220 L0 220 Z" fill="url(#lineArea2)"/>
                            <path d="M0 180 L100 120 L200 150 L300 80 L400 40 L500 70 L600 30" fill="none" stroke="#ccff00" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="100" cy="120" r="6" fill="#111" stroke="#ccff00" stroke-width="3"/>
                            <circle cx="200" cy="150" r="6" fill="#111" stroke="#ccff00" stroke-width="3"/>
                            <circle cx="300" cy="80"  r="6" fill="#111" stroke="#ccff00" stroke-width="3"/>
                            <circle cx="400" cy="40"  r="6" fill="#111" stroke="#ccff00" stroke-width="3"/>
                            <circle cx="500" cy="70"  r="6" fill="#111" stroke="#ccff00" stroke-width="3"/>
                            <circle cx="600" cy="30"  r="6" fill="#111" stroke="#ccff00" stroke-width="3"/>
                        </svg>
                    </div>
                </article>

                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Analisis Kunjungan Member</h2>
                            <p>Tingkat kehadiran per paket keanggotaan</p>
                        </div>
                    </div>
                    <div class="admin-bar-chart">
                        @foreach ([40,60,50,90,75,85,60] as $height)
                        <div class="admin-bar-chart__group">
                            <span class="admin-bar admin-bar--neon" style="height:{{ $height }}%"></span>
                        </div>
                        @endforeach
                    </div>
                    <div class="admin-chart-legend">
                        <span><i class="legend-neon"></i>Kunjungan</span>
                    </div>
                </article>
            </section>

            {{-- TABEL RINGKASAN --}}
            <section class="admin-card admin-table-card" id="reportTable">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Ringkasan Per Bulan</h2>
                        <p>Data pendapatan dan kunjungan Januari–Juni 2026</p>
                    </div>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Bulan</th><th>Member Baru</th>
                                <th>Total Booking</th><th>Pendapatan</th><th>Pertumbuhan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ([
                                ['Januari 2026','42','88','Rp12,4jt','+0%'],
                                ['Februari 2026','38','76','Rp11,8jt','-4,8%'],
                                ['Maret 2026','55','102','Rp15,2jt','+28,8%'],
                                ['April 2026','49','95','Rp13,9jt','-8,5%'],
                                ['Mei 2026','61','118','Rp17,1jt','+23%'],
                                ['Juni 2026','67','128','Rp14,1jt','+17,5%'],
                            ] as $row)
                            <tr>
                                <td class="admin-table__strong">{{ $row[0] }}</td>
                                <td>{{ $row[1] }}</td>
                                <td>{{ $row[2] }}</td>
                                <td style="color:#ccff00;font-weight:700;">{{ $row[3] }}</td>
                                <td>
                                    <span class="admin-status admin-status--{{ str_starts_with($row[4],'+') ? 'success' : 'danger' }}">
                                        {{ $row[4] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</div>

<div id="toast" style="position:fixed;bottom:2rem;right:2rem;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;"></div>

<style>
@keyframes slideIn  { from{opacity:0;transform:translateX(20px);}to{opacity:1;transform:translateX(0);} }
@keyframes slideOut { from{opacity:1;transform:translateX(0);}to{opacity:0;transform:translateX(20px);} }
@keyframes spin     { from{transform:rotate(0deg);}to{transform:rotate(360deg);} }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function showToast(message, type = 'success') {
    const colors = {
        success: { bg:'rgba(46,213,115,0.1)', border:'rgba(46,213,115,0.3)', color:'#2ed573', icon:'check_circle' },
        danger:  { bg:'rgba(255,71,87,0.1)',  border:'rgba(255,71,87,0.3)',  color:'#ff4757', icon:'cancel' },
        warning: { bg:'rgba(255,165,2,0.1)',  border:'rgba(255,165,2,0.3)',  color:'#ffa502', icon:'warning' },
        info:    { bg:'rgba(100,180,255,0.1)',border:'rgba(100,180,255,0.3)',color:'#64b4ff', icon:'info' },
    };
    const c = colors[type] || colors.success;
    const t = document.createElement('div');
    t.style.cssText = `pointer-events:auto;display:flex;align-items:center;gap:10px;background:${c.bg};border:1px solid ${c.border};color:${c.color};padding:12px 18px;border-radius:10px;font-size:0.85rem;font-weight:600;backdrop-filter:blur(8px);box-shadow:0 8px 24px rgba(0,0,0,0.4);animation:slideIn 0.3s ease;min-width:260px;`;
    t.innerHTML = `<span class="material-symbols-outlined" style="font-size:20px;">${c.icon}</span>${message}`;
    document.getElementById('toast').appendChild(t);
    setTimeout(() => { t.style.animation = 'slideOut 0.3s ease forwards'; setTimeout(() => t.remove(), 300); }, 3500);
}

// ── Unduh PDF
document.getElementById('btnUnduhPDF').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:1.1rem;animation:spin 1s linear infinite;">refresh</span> Memproses...';
    showToast('Menyiapkan laporan PDF...', 'info');

    const element = document.getElementById('reportTable');
    const opt = {
        margin:       [10, 10, 10, 10],
        filename:     `laporan-siboti-${new Date().toISOString().slice(0,10)}.pdf`,
        image:        { type:'jpeg', quality:0.98 },
        html2canvas:  { scale:2, backgroundColor:'#111111' },
        jsPDF:        { unit:'mm', format:'a4', orientation:'landscape' },
    };

    html2pdf().set(opt).from(element).save().then(() => {
        btn.disabled = false;
        btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:1.1rem;">download</span> Unduh PDF';
        showToast('Laporan berhasil diunduh', 'success');
    }).catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:1.1rem;">download</span> Unduh PDF';
        showToast('Gagal mengunduh laporan', 'danger');
    });
});

// ── Sidebar
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('adminSidebarToggle');
    const sidebar   = document.getElementById('adminSidebar');
    const overlay   = document.getElementById('adminSidebarOverlay');
    function toggleSidebar() {
        sidebar.classList.toggle('is-open');
        overlay.classList.toggle('is-active');
        document.body.classList.toggle('admin-noscroll');
    }
    toggleBtn?.addEventListener('click', toggleSidebar);
    overlay?.addEventListener('click', toggleSidebar);
});
</script>
@endsection