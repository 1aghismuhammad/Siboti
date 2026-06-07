@extends('layouts.admin')
@section('title', 'Paket Keanggotaan - Admin')
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
                    <p class="admin-eyebrow">Manajemen Member</p>
                    <h1>Paket Keanggotaan</h1>
                </div>
            </div>
            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="search" placeholder="Cari pendaftar..." id="searchInput">
                </label>
                <div class="admin-profile">AD</div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Konfirmasi Pendaftar Baru</h2>
                        <p>Daftar calon member yang mendaftar melalui landing page dan menunggu persetujuan.</p>
                    </div>
                    <span class="admin-pill admin-pill--warning" id="pendingCount">
                        {{ collect($prospectiveMembers)->where('statusClass','warning')->count() }} Pending
                    </span>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table" id="memberTable">
                        <thead>
                            <tr>
                                <th>ID Daftar</th>
                                <th>Nama Lengkap</th>
                                <th>Email / Kontak</th>
                                <th>Paket Pilihan</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prospectiveMembers as $member)
                            <tr id="member-row-{{ $loop->index }}">
                                <td class="admin-table__strong">{{ $member['id'] }}</td>
                                <td>{{ $member['name'] }}</td>
                                <td>
                                    <div>{{ $member['email'] }}</div>
                                    <small style="color:#888;">{{ $member['phone'] }}</small>
                                </td>
                                <td>{{ $member['plan'] }}</td>
                                <td>{{ $member['date'] }}</td>
                                <td>
                                    <span class="admin-status admin-status--{{ $member['statusClass'] }}" id="member-status-{{ $loop->index }}">
                                        {{ $member['status'] }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    @if($member['statusClass'] == 'warning')
                                    <button type="button"
                                        class="admin-primary-button btn-approve"
                                        style="padding:0.4rem 0.8rem;font-size:0.75rem;"
                                        data-index="{{ $loop->index }}"
                                        data-name="{{ $member['name'] }}">
                                        Approve
                                    </button>
                                    @else
                                    <button type="button" class="admin-small-button">Lihat</button>
                                    @endif
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

{{-- TOAST --}}
<div id="toast" style="position:fixed;bottom:2rem;right:2rem;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;"></div>

<script>
// ── Toast
function showToast(message, type = 'success') {
    const colors = {
        success: { bg: 'rgba(46,213,115,0.1)', border: 'rgba(46,213,115,0.3)', color: '#2ed573', icon: 'check_circle' },
        danger:  { bg: 'rgba(255,71,87,0.1)',  border: 'rgba(255,71,87,0.3)',  color: '#ff4757', icon: 'cancel' },
        warning: { bg: 'rgba(255,165,2,0.1)',  border: 'rgba(255,165,2,0.3)',  color: '#ffa502', icon: 'warning' },
    };
    const c = colors[type] || colors.success;
    const toast = document.createElement('div');
    toast.style.cssText = `pointer-events:auto;display:flex;align-items:center;gap:10px;background:${c.bg};border:1px solid ${c.border};color:${c.color};padding:12px 18px;border-radius:10px;font-size:0.85rem;font-weight:600;backdrop-filter:blur(8px);box-shadow:0 8px 24px rgba(0,0,0,0.4);animation:slideIn 0.3s ease;min-width:260px;`;
    toast.innerHTML = `<span class="material-symbols-outlined" style="font-size:20px;">${c.icon}</span>${message}`;
    document.getElementById('toast').appendChild(toast);
    setTimeout(() => { toast.style.animation = 'slideOut 0.3s ease forwards'; setTimeout(() => toast.remove(), 300); }, 3000);
}

// ── Approve
document.querySelectorAll('.btn-approve').forEach(btn => {
    btn.addEventListener('click', function() {
        const index = this.dataset.index;
        const name  = this.dataset.name;

        // Update UI
        const statusEl = document.getElementById(`member-status-${index}`);
        statusEl.className = 'admin-status admin-status--success';
        statusEl.textContent = 'Approved';

        // Ganti tombol
        this.outerHTML = `<button type="button" class="admin-small-button">Lihat</button>`;

        // Update counter
        const counter = document.getElementById('pendingCount');
        const current = parseInt(counter.textContent) || 0;
        if (current > 1) {
            counter.textContent = `${current - 1} Pending`;
        } else {
            counter.className = 'admin-pill admin-pill--success';
            counter.textContent = 'Semua Approved';
        }

        showToast(`${name} berhasil diapprove`, 'success');
    });
});

// ── Search
document.getElementById('searchInput')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#memberTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

// ── Sidebar toggle
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

<style>
@keyframes slideIn  { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
@keyframes slideOut { from { opacity:1; transform:translateX(0); } to { opacity:0; transform:translateX(20px); } }
</style>
@endsection