@extends('layouts.admin')
@section('title', 'Pemeliharaan Sistem - Admin')
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
                    <p class="admin-eyebrow">Developer & IT</p>
                    <h1>Pemeliharaan Sistem</h1>
                </div>
            </div>
            <div class="admin-topbar__actions">
                <div class="admin-profile">AD</div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-grid admin-grid--two">
                {{-- STATUS SERVER --}}
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Status Server Terkini</h2>
                            <p>Indikator kesehatan layanan Siboti Gym Management</p>
                        </div>
                        <button type="button" class="admin-small-button" id="btnRefreshStatus">
                            <span class="material-symbols-outlined" style="font-size:14px;vertical-align:-2px;">refresh</span>
                            Refresh
                        </button>
                    </div>
                    <div class="admin-progress-list" style="margin-top:1rem;">
                        <div class="admin-progress-item">
                            <div>
                                <span>Database SQL</span>
                                <strong id="statusDB" style="color:#2ed573;">{{ $systemStatus['database']['status'] }}</strong>
                            </div>
                            <progress max="100" value="100"></progress>
                        </div>
                        <div class="admin-progress-item">
                            <div>
                                <span>Redis Cache</span>
                                <strong id="statusRedis" style="color:#2ed573;">{{ $systemStatus['redis']['status'] }}</strong>
                            </div>
                            <progress max="100" value="100"></progress>
                        </div>
                        <div class="admin-progress-item admin-progress-item--muted">
                            <div>
                                <span>Penyimpanan Lokal</span>
                                <strong id="statusStorage">{{ $systemStatus['storage']['status'] }}</strong>
                            </div>
                            <progress id="storageBar" max="100" value="45"></progress>
                        </div>
                    </div>

                    {{-- Log aktivitas maintenance --}}
                    <div style="margin-top:1.5rem;border-top:1px solid rgba(255,255,255,0.06);padding-top:1.25rem;">
                        <p style="font-size:0.75rem;color:#666;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:12px;">Log Terbaru</p>
                        <div id="maintenanceLog" style="display:flex;flex-direction:column;gap:8px;font-size:0.78rem;color:#888;max-height:140px;overflow-y:auto;">
                            <span>— Belum ada aktivitas pemeliharaan.</span>
                        </div>
                    </div>
                </article>

                {{-- TINDAKAN PEMELIHARAAN --}}
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Tindakan Pemeliharaan</h2>
                            <p>Aksi cepat untuk merawat performa server</p>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:12px;">

                        {{-- Backup --}}
                        <button type="button" id="btnBackup"
                            style="display:flex;align-items:center;gap:1rem;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.08);padding:1rem;border-radius:14px;text-decoration:none;color:#fff;width:100%;cursor:pointer;transition:all 0.25s ease;font-family:inherit;text-align:left;">
                            <span class="material-symbols-outlined" style="color:#ccff00;background:rgba(204,255,0,0.1);padding:0.5rem;border-radius:10px;font-size:1.4rem;">cloud_download</span>
                            <div style="flex:1;">
                                <strong style="font-size:0.875rem;display:block;">Backup Database</strong>
                                <small style="color:#666;font-size:0.75rem;">Unduh salinan data terkini</small>
                            </div>
                            <span class="material-symbols-outlined" style="color:#555;font-size:1.2rem;">chevron_right</span>
                        </button>

                        {{-- Bersihkan Cache --}}
                        <button type="button" id="btnClearCache"
                            style="display:flex;align-items:center;gap:1rem;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.08);padding:1rem;border-radius:14px;text-decoration:none;color:#fff;width:100%;cursor:pointer;transition:all 0.25s ease;font-family:inherit;text-align:left;">
                            <span class="material-symbols-outlined" style="color:#ffa502;background:rgba(255,165,2,0.1);padding:0.5rem;border-radius:10px;font-size:1.4rem;">delete_sweep</span>
                            <div style="flex:1;">
                                <strong style="font-size:0.875rem;display:block;">Bersihkan Cache Aplikasi</strong>
                                <small style="color:#666;font-size:0.75rem;">Hapus cache dan optimasi performa</small>
                            </div>
                            <span class="material-symbols-outlined" style="color:#555;font-size:1.2rem;">chevron_right</span>
                        </button>

                        {{-- Mode Maintenance --}}
                        <button type="button" id="btnMaintenance"
                            style="display:flex;align-items:center;gap:1rem;padding:1rem;border-radius:14px;text-decoration:none;width:100%;cursor:pointer;transition:all 0.25s ease;font-family:inherit;text-align:left; 
                            @if($isMaintenance ?? false)
                                background:rgba(255,71,87,0.1); border:1px solid rgba(255,71,87,0.4); color:#ff4757;
                            @else
                                background:rgba(255,71,87,0.03); border:1px solid rgba(255,71,87,0.2); color:#ff4757;
                            @endif">
                            <span class="material-symbols-outlined" style="color:#ff4757;background:rgba(255,71,87,0.1);padding:0.5rem;border-radius:10px;font-size:1.4rem;">power_settings_new</span>
                            <div style="flex:1;">
                                <strong style="font-size:0.875rem;display:block;" id="maintenanceBtnLabel">
                                    {{ ($isMaintenance ?? false) ? 'Nonaktifkan Mode Maintenance' : 'Aktifkan Mode Maintenance' }}
                                </strong>
                                <small style="color:#ff475799;font-size:0.75rem;">Sistem akan tidak dapat diakses user</small>
                            </div>
                            <span class="material-symbols-outlined" style="color:#ff4757;font-size:1.2rem;">chevron_right</span>
                        </button>
                    </div>
                </article>
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

<script>
let maintenanceMode = {{ ($isMaintenance ?? false) ? 'true' : 'false' }};

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

function addLog(message) {
    const log = document.getElementById('maintenanceLog');
    const now = new Date().toLocaleTimeString('id-ID');
    const entry = document.createElement('div');
    entry.style.cssText = 'display:flex;gap:8px;align-items:flex-start;padding:6px 0;border-bottom:1px solid rgba(255,255,255,0.04);';
    entry.innerHTML = `<span style="color:#555;flex-shrink:0;">${now}</span><span>${message}</span>`;
    if (log.querySelector('span')?.textContent.includes('Belum')) log.innerHTML = '';
    log.prepend(entry);
}

// ── Refresh Status
document.getElementById('btnRefreshStatus').addEventListener('click', function() {
    const icon = this.querySelector('.material-symbols-outlined');
    icon.style.animation = 'spin 0.6s linear';
    setTimeout(() => { icon.style.animation = ''; }, 600);

    // Simulasi perubahan nilai storage
    const storage = Math.floor(Math.random() * 30) + 35;
    document.getElementById('storageBar').value = storage;
    addLog(`Status server diperbarui — Storage: ${storage}%`);
    showToast('Status server berhasil diperbarui', 'info');
});

// ── Backup Database
document.getElementById('btnBackup').addEventListener('click', function() {
    const btn = this;
    btn.style.opacity = '0.6';
    btn.style.pointerEvents = 'none';
    showToast('Memproses backup database...', 'info');

    setTimeout(() => {
        // Simulasi download file
        const blob = new Blob(
            [`SIBOTI DATABASE BACKUP\nTanggal: ${new Date().toLocaleString('id-ID')}\n\n[DATA SIMULASI]\nMember: 342\nBooking: 128\nTransaksi: 89`],
            { type: 'text/plain' }
        );
        const url  = URL.createObjectURL(blob);
        const a    = document.createElement('a');
        a.href     = url;
        a.download = `siboti-backup-${new Date().toISOString().slice(0,10)}.txt`;
        a.click();
        URL.revokeObjectURL(url);

        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
        addLog('Backup database berhasil diunduh');
        showToast('Backup database berhasil diunduh', 'success');
    }, 1800);
});

// ── Bersihkan Cache
document.getElementById('btnClearCache').addEventListener('click', function() {
    const btn = this;
    btn.style.opacity = '0.6';
    btn.style.pointerEvents = 'none';
    showToast('Membersihkan cache aplikasi...', 'warning');

    setTimeout(() => {
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
        addLog('Cache aplikasi berhasil dibersihkan');
        showToast('Cache berhasil dibersihkan — performa dioptimalkan', 'success');
    }, 1500);
});

// ── Mode Maintenance Toggle
document.getElementById('btnMaintenance').addEventListener('click', async function() {
    const btn = this;
    const label = document.getElementById('maintenanceBtnLabel');
    btn.style.opacity = '0.6';
    btn.style.pointerEvents = 'none';

    try {
        const res = await fetch('{{ route("admin.maintenance.toggle") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        maintenanceMode = (data.status === 'on');

        if (maintenanceMode) {
            label.textContent = 'Nonaktifkan Mode Maintenance';
            btn.style.background = 'rgba(255,71,87,0.1)';
            btn.style.borderColor = 'rgba(255,71,87,0.4)';
            addLog('⚠ Mode Maintenance DIAKTIFKAN');
            showToast('Mode Maintenance aktif — sistem tidak dapat diakses user', 'danger');
        } else {
            label.textContent = 'Aktifkan Mode Maintenance';
            btn.style.background = 'rgba(255,71,87,0.03)';
            btn.style.borderColor = 'rgba(255,71,87,0.2)';
            addLog('✓ Mode Maintenance DINONAKTIFKAN');
            showToast('Mode Maintenance dinonaktifkan — sistem kembali normal', 'success');
        }
    } catch (e) {
        showToast('Gagal mengubah mode maintenance', 'danger');
    } finally {
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
    }
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