@extends('layouts.admin')
@section('title', 'Personal Trainer - Admin')
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
                    <p class="admin-eyebrow">Manajemen Staf</p>
                    <h1>Personal Trainer</h1>
                </div>
            </div>
            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="search" placeholder="Cari pelatih..." id="searchInput">
                </label>
                <div class="admin-profile">AD</div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Daftar Personal Trainer</h2>
                        <p>Kelola akun para pelatih dan lihat spesialisasi mereka.</p>
                    </div>
                    <button type="button" class="admin-primary-button" id="btnTambahPelatih">
                        + Tambah Pelatih
                    </button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table" id="trainerTable">
                        <thead>
                            <tr>
                                <th>ID Pelatih</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Jumlah Member</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="trainerBody">
                            @foreach ($trainers as $trainer)
                            <tr id="trainer-row-{{ $loop->index }}"
                                data-index="{{ $loop->index }}"
                                data-id="{{ $trainer->id }}"
                                data-name="{{ $trainer->name }}"
                                data-email="{{ $trainer->email }}">
                                <td class="admin-table__strong trainer-id">{{ $trainer->id }}</td>
                                <td class="trainer-name">{{ $trainer->name }}</td>
                                <td class="trainer-email">{{ $trainer->email }}</td>
                                <td class="trainer-members">{{ $trainer->active_members_count ?? 0 }} Member</td>
                                <td>⭐ <span class="trainer-rating">5.0</span></td>
                                <td>
                                    <span class="admin-status admin-status--success trainer-status">
                                        Aktif
                                    </span>
                                </td>
                                <td class="text-right" style="white-space: nowrap;">
                                    <button type="button" class="admin-small-button btn-edit"
                                        data-index="{{ $loop->index }}">Edit</button>
                                        
                                    <form action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pelatih ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-small-button btn-hapus"
                                            style="color:#ff4757;border-color:rgba(255,71,87,0.3);margin-left:0.5rem;">Hapus</button>
                                    </form>
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

{{-- MODAL TAMBAH / EDIT PELATIH --}}
<div id="trainerModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);z-index:999;align-items:center;justify-content:center;">
    <form id="trainerForm" method="POST" action="" style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:32px;width:100%;max-width:480px;margin:1rem;">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">
        
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <h2 id="modalTitle" style="margin:0;font-size:1.1rem;font-weight:800;">Tambah Pelatih Baru</h2>
            <button type="button" id="modalClose" style="background:transparent;border:none;color:#888;cursor:pointer;font-size:1.5rem;line-height:1;">×</button>
        </div>

        @if($errors->any())
            <div style="background:rgba(255,71,87,0.1);border:1px solid rgba(255,71,87,0.3);color:#ff4757;padding:12px;border-radius:8px;margin-bottom:16px;font-size:0.85rem;">
                <ul style="margin:0;padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="display:flex;flex-direction:column;gap:16px;">
            <div>
                <label style="font-size:0.75rem;color:#888;font-weight:600;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Nama Lengkap</label>
                <input id="f-name" name="name" type="text" placeholder="Contoh: Andi Firmansyah" required
                    style="width:100%;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.1);color:#fff;padding:10px 14px;border-radius:8px;font-family:inherit;font-size:0.875rem;outline:none;">
            </div>
            <div>
                <label style="font-size:0.75rem;color:#888;font-weight:600;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Email Akun</label>
                <input id="f-email" name="email" type="email" placeholder="Contoh: andi@siboti.com" required
                    style="width:100%;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.1);color:#fff;padding:10px 14px;border-radius:8px;font-family:inherit;font-size:0.875rem;outline:none;">
            </div>
            <div>
                <label style="font-size:0.75rem;color:#888;font-weight:600;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Password</label>
                <input id="f-password" name="password" type="password" placeholder="Minimal 8 karakter" required minlength="8"
                    style="width:100%;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.1);color:#fff;padding:10px 14px;border-radius:8px;font-family:inherit;font-size:0.875rem;outline:none;">
                <small id="password-help" style="color:#666;font-size:0.7rem;margin-top:4px;display:none;">*Kosongkan jika tidak ingin mengubah password saat edit.</small>
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end;">
            <button type="button" id="modalCancel" class="admin-small-button">Batal</button>
            <button type="submit" class="admin-primary-button">Simpan</button>
        </div>
    </form>
</div>

<div id="toast" style="position:fixed;bottom:2rem;right:2rem;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;"></div>

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

function openModal(mode, index = null) {
    const modal = document.getElementById('trainerModal');
    const form = document.getElementById('trainerForm');
    const formMethod = document.getElementById('formMethod');
    const pwdHelp = document.getElementById('password-help');
    
    document.getElementById('modalTitle').textContent = mode === 'add' ? 'Tambah Akun Pelatih' : 'Edit Akun Pelatih';

    if (mode === 'edit' && index !== null) {
        const row = document.getElementById(`trainer-row-${index}`);
        const id = row.dataset.id;
        
        form.action = `/admin/trainers/${id}`;
        formMethod.value = 'PUT';
        
        document.getElementById('f-name').value  = row.dataset.name;
        document.getElementById('f-email').value = row.dataset.email;
        
        document.getElementById('f-password').value = '';
        document.getElementById('f-password').required = false;
        pwdHelp.style.display = 'block';
    } else {
        form.action = `{{ route('admin.trainers.store') }}`;
        formMethod.value = 'POST';
        
        document.getElementById('f-name').value  = '';
        document.getElementById('f-email').value = '';
        document.getElementById('f-password').value = '';
        document.getElementById('f-password').required = true;
        pwdHelp.style.display = 'none';
    }

    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('trainerModal').style.display = 'none';
}

document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
        openModal('edit', this.dataset.index);
    });
});

document.getElementById('btnTambahPelatih').addEventListener('click', () => openModal('add'));
document.getElementById('modalClose').addEventListener('click', closeModal);
document.getElementById('modalCancel').addEventListener('click', closeModal);
document.getElementById('trainerModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

// Search
document.getElementById('searchInput')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#trainerTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
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