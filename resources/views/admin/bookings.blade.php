@extends('layouts.admin')
@section('title', 'Konfirmasi Booking - Admin')
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
                    <p class="admin-eyebrow">Aktivitas Member</p>
                    <h1>Konfirmasi Booking</h1>
                </div>
            </div>
            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="search" placeholder="Cari ID Booking..." id="searchInput">
                </label>
                <div class="admin-profile">AD</div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Daftar Booking Menunggu Konfirmasi</h2>
                        <p>Konfirmasi pesanan kelas atau personal trainer sebelum diteruskan ke sistem pelatih.</p>
                    </div>
                    <span class="admin-pill admin-pill--warning" id="pendingCount">
                        {{ $bookings->where('admin_approved', false)->count() }} Pending
                    </span>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table" id="bookingTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Member</th>
                                <th>Pelatih Dituju</th>
                                <th>Tipe</th>
                                <th>Jadwal</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                            @php
                                $hasActiveSub = \App\Models\Subscription::where('user_id', $booking->user_id)
                                    ->where('status', 'active')
                                    ->where('end_date', '>=', now())
                                    ->exists();
                            @endphp
                            <tr id="booking-row-{{ $loop->index }}">
                                <td class="admin-table__strong">{{ $booking->id }}</td>
                                <td>
                                    {{ $booking->user->name ?? '-' }}
                                    @if(!$hasActiveSub)
                                    <span style="display:block;font-size:0.65rem;color:#ff4757;font-weight:700;margin-top:2px;">
                                        <span class="material-symbols-outlined" style="font-size:12px;vertical-align:-2px;">warning</span>
                                        Belum Membership
                                    </span>
                                    @endif
                                </td>
                                <td>{{ $booking->trainer->name ?? '-' }}</td>
                                <td>
                                    @if($booking->is_direct)
                                    <span class="admin-status admin-status--danger" style="font-size:0.65rem;">Direct</span>
                                    @else
                                    <span class="admin-status admin-status--success" style="font-size:0.65rem;">Member</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                    <small style="color:#888;">Pukul {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</small>
                                </td>
                                <td>
                                    <span class="admin-status admin-status--{{ !$booking->admin_approved ? 'warning' : ($booking->status === 'approved' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'pending')) }}" id="booking-status-{{ $loop->index }}">
                                        @if(!$booking->admin_approved)
                                            Pending Admin
                                        @else
                                            {{ ucfirst($booking->status) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="text-right" style="display:flex;gap:6px;justify-content:flex-end;">
                                    {{-- Detail button --}}
                                    <button type="button" class="admin-small-button btn-detail"
                                        data-member="{{ $booking->user->name ?? '-' }}"
                                        data-trainer="{{ $booking->trainer->name ?? '-' }}"
                                        data-session="{{ $booking->session_type ?? 'Personal Training' }}"
                                        data-date="{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}"
                                        data-time="{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}"
                                        data-status="{{ !$booking->admin_approved ? 'Pending Admin' : ucfirst($booking->status) }}"
                                        data-is-direct="{{ $booking->is_direct ? '1' : '0' }}"
                                        data-has-sub="{{ $hasActiveSub ? '1' : '0' }}"
                                        style="padding:0.4rem 0.6rem;font-size:0.7rem;">
                                        Detail
                                    </button>
                                    {{-- Forward button --}}
                                    @if(!$booking->admin_approved)
                                    <form action="{{ route('admin.bookings.forward', $booking->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            class="admin-primary-button btn-forward"
                                            style="padding:0.4rem 0.8rem;font-size:0.75rem;">
                                            Teruskan
                                        </button>
                                    </form>
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

{{-- MODAL DETAIL BOOKING --}}
<div id="detailModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:28px 32px;width:100%;max-width:520px;margin:1rem;max-height:90vh;overflow-y:auto;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h2 style="margin:0;font-size:1.1rem;font-weight:800;color:#fff;">Detail Booking</h2>
            <button type="button" id="detailModalClose" style="background:transparent;border:none;color:#888;cursor:pointer;font-size:1.5rem;line-height:1;">×</button>
        </div>

        {{-- Booking Info --}}
        <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:20px;">
            <div style="display:flex;justify-content:space-between;padding:10px 14px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:10px;">
                <span style="color:#888;font-size:0.8rem;font-weight:600;">Member</span>
                <span style="color:#fff;font-size:0.85rem;font-weight:700;" id="modal-member"></span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:10px 14px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:10px;">
                <span style="color:#888;font-size:0.8rem;font-weight:600;">Pelatih</span>
                <span style="color:#fff;font-size:0.85rem;font-weight:700;" id="modal-trainer"></span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:10px 14px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:10px;">
                <span style="color:#888;font-size:0.8rem;font-weight:600;">Tipe Sesi</span>
                <span style="color:#fff;font-size:0.85rem;font-weight:700;" id="modal-session"></span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:10px 14px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:10px;">
                <span style="color:#888;font-size:0.8rem;font-weight:600;">Jadwal</span>
                <span style="color:#fff;font-size:0.85rem;font-weight:700;" id="modal-jadwal"></span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:10px 14px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:10px;">
                <span style="color:#888;font-size:0.8rem;font-weight:600;">Status</span>
                <span style="font-size:0.85rem;font-weight:700;" id="modal-status"></span>
            </div>
        </div>

        {{-- Warning jika belum membership --}}
        <div id="noMembershipAlert" style="display:none;background:rgba(255,71,87,0.06);border:1px solid rgba(255,71,87,0.2);border-radius:12px;padding:16px;margin-bottom:20px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                <span class="material-symbols-outlined" style="color:#ff4757;font-size:20px;">error</span>
                <strong style="color:#ff4757;font-size:0.85rem;">Member Belum Memiliki Membership!</strong>
            </div>
            <p style="margin:0 0 14px 0;color:#ccc;font-size:0.78rem;line-height:1.5;">
                Member ini belum memiliki paket membership aktif. Booking bersifat <strong style="color:#ffa502;">Direct</strong> dan membutuhkan pembayaran terpisah. Sarankan member untuk membeli salah satu paket berikut:
            </p>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @foreach ($membershipPlans as $plan)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:rgba(204,255,0,0.03);border:1px solid rgba(204,255,0,0.12);border-radius:10px;">
                    <div>
                        <strong style="color:#fff;font-size:0.82rem;display:block;">{{ $plan->name }}</strong>
                        <small style="color:#888;font-size:0.68rem;">{{ $plan->duration_days }} hari · {{ $plan->description }}</small>
                    </div>
                    <span style="color:#ccff00;font-weight:800;font-size:0.85rem;white-space:nowrap;">Rp{{ number_format($plan->price, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Info jika sudah membership --}}
        <div id="hasMembershipAlert" style="display:none;background:rgba(46,213,115,0.06);border:1px solid rgba(46,213,115,0.2);border-radius:12px;padding:16px;margin-bottom:20px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="material-symbols-outlined" style="color:#2ed573;font-size:20px;">verified</span>
                <strong style="color:#2ed573;font-size:0.85rem;">Member Memiliki Membership Aktif</strong>
            </div>
            <p style="margin:8px 0 0;color:#ccc;font-size:0.78rem;line-height:1.5;">
                Member ini sudah terdaftar dengan paket membership aktif. Booking bisa langsung diteruskan ke trainer.
            </p>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button type="button" id="detailModalCloseBtn" class="admin-small-button">Tutup</button>
        </div>
    </div>
</div>

<div id="toast" style="position:fixed;bottom:2rem;right:2rem;z-index:99999;display:flex;flex-direction:column;gap:10px;pointer-events:none;"></div>

<script>
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

@if(session('success'))
    showToast("{{ session('success') }}", 'success');
@endif

// Search
document.getElementById('searchInput')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#bookingTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

// Detail Modal
const detailModal = document.getElementById('detailModal');
document.getElementById('detailModalClose').addEventListener('click', () => { detailModal.style.display = 'none'; });
document.getElementById('detailModalCloseBtn').addEventListener('click', () => { detailModal.style.display = 'none'; });
detailModal.addEventListener('click', e => { if (e.target === detailModal) detailModal.style.display = 'none'; });

document.querySelectorAll('.btn-detail').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('modal-member').textContent = this.dataset.member;
        document.getElementById('modal-trainer').textContent = this.dataset.trainer;
        document.getElementById('modal-session').textContent = this.dataset.session;
        document.getElementById('modal-jadwal').textContent = this.dataset.date + ', Pukul ' + this.dataset.time;

        const statusEl = document.getElementById('modal-status');
        statusEl.textContent = this.dataset.status;
        statusEl.style.color = this.dataset.status === 'Pending Admin' ? '#ffa502' : '#2ed573';

        const hasSub = this.dataset.hasSub === '1';
        document.getElementById('noMembershipAlert').style.display = hasSub ? 'none' : 'block';
        document.getElementById('hasMembershipAlert').style.display = hasSub ? 'block' : 'none';

        detailModal.style.display = 'flex';
    });
});

// Sidebar
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