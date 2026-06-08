@extends('layouts.admin')
@section('title', 'Scan QR Member')

@section('content')
<div class="admin-shell receptionist-shell">
    <aside class="admin-sidebar" aria-label="Navigasi receptionist">
        <div class="admin-brand">
            <a href="{{ url('/') }}" class="admin-brand__mark" aria-label="Kembali ke beranda Siboti">
                <span class="material-symbols-outlined">fitness_center</span>
            </a>
            <div>
                <p class="admin-brand__name">Siboti</p>
                <p class="admin-brand__label">Receptionist Desk</p>
            </div>
        </div>

        <nav class="admin-menu">
            <a href="{{ route('receptionist.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('scan-qr.index') }}" class="admin-menu__item admin-menu__item--active">
                <span class="material-symbols-outlined">qr_code_scanner</span>
                <span>Scan QR</span>
            </a>
            <a href="{{ route('pos.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">point_of_sale</span>
                <span>Transaksi POS</span>
            </a>
            <a href="{{ route('pos.history') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">receipt_long</span>
                <span>Riwayat Transaksi</span>
            </a>
        </nav>

        <div class="admin-sidebar__footer">
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">settings</span>
                <span>Pengaturan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-menu__item admin-menu__item--danger"
                    style="width:100%;border:0;background:transparent;cursor:pointer;">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <p class="admin-eyebrow">Panel Operasional Front Desk</p>
                <h1>Scan QR Member</h1>
            </div>
            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="search" placeholder="Cari member atau ID..." aria-label="Cari member">
                </label>
                <button type="button" class="admin-icon-button" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <div class="admin-profile" aria-label="Profil receptionist">
                    <span>RC</span>
                </div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-grid admin-grid--two">

                {{-- PANEL SCAN --}}
                <article class="admin-card receptionist-scanner-card">
                    <div class="admin-section-head admin-section-head--bordered">
                        <div>
                            <h2>Scan QR Member</h2>
                            <p>Arahkan kamera ke QR code atau masukkan ID manual.</p>
                        </div>
                        <span id="cameraStatus" class="admin-pill admin-pill--positive">Ready</span>
                    </div>

                    {{-- Viewport kamera --}}
                    <div style="position:relative;background:#0d0d0d;border-radius:10px;overflow:hidden;aspect-ratio:4/3;margin-bottom:16px;">
                        <video id="cameraFeed" autoplay playsinline
                            style="width:100%;height:100%;object-fit:cover;display:block;"></video>

                        {{-- Overlay garis scanner --}}
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;">
                            <div style="width:180px;height:180px;border:2px solid #c6f135;border-radius:12px;position:relative;">
                                <span style="position:absolute;top:-1px;left:-1px;width:20px;height:20px;border-top:3px solid #c6f135;border-left:3px solid #c6f135;border-radius:3px 0 0 0;"></span>
                                <span style="position:absolute;top:-1px;right:-1px;width:20px;height:20px;border-top:3px solid #c6f135;border-right:3px solid #c6f135;border-radius:0 3px 0 0;"></span>
                                <span style="position:absolute;bottom:-1px;left:-1px;width:20px;height:20px;border-bottom:3px solid #c6f135;border-left:3px solid #c6f135;border-radius:0 0 0 3px;"></span>
                                <span style="position:absolute;bottom:-1px;right:-1px;width:20px;height:20px;border-bottom:3px solid #c6f135;border-right:3px solid #c6f135;border-radius:0 0 3px 0;"></span>
                                <div id="scanLine" style="position:absolute;left:4px;right:4px;height:2px;background:#c6f135;opacity:0.8;animation:scanAnim 2s linear infinite;top:0;"></div>
                            </div>
                        </div>

                        {{-- Tombol kamera --}}
                        <div style="position:absolute;bottom:10px;right:10px;display:flex;gap:8px;">
                            <button type="button" id="startCamera"
                                style="background:#c6f135;color:#111;border:none;border-radius:8px;padding:7px 14px;font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
                                <span class="material-symbols-outlined" style="font-size:15px;">videocam</span>
                                Mulai Kamera
                            </button>
                            <button type="button" id="stopCamera"
                                style="display:none;background:#2a2a2a;color:#ccc;border:1px solid #333;border-radius:8px;padding:7px 14px;font-size:12px;cursor:pointer;display:none;align-items:center;gap:6px;">
                                <span class="material-symbols-outlined" style="font-size:15px;">videocam_off</span>
                                Stop
                            </button>
                        </div>
                    </div>

                    {{-- Input manual --}}
                    <div class="receptionist-form">
                        <label for="memberCode" style="font-size:12px;color:#888;margin-bottom:6px;display:block;">
                            Atau masukkan ID Member secara manual
                        </label>
                        <input id="memberCode" type="text" placeholder="Contoh: MEM-2024-0891"
                            style="text-transform:uppercase;">
                        <button type="button" id="validateBtn" class="admin-primary-button"
                            style="margin-top:10px;width:100%;">
                            <span class="material-symbols-outlined" style="font-size:16px;vertical-align:-3px;">search</span>
                            Validasi Member
                        </button>
                    </div>
                </article>

                {{-- PANEL HASIL VALIDASI --}}
                <article class="admin-card receptionist-validation-card">
                    <div class="admin-section-head admin-section-head--bordered">
                        <div>
                            <h2>Hasil Validasi</h2>
                            <p>Status member sesuai ID yang diinput.</p>
                        </div>
                        <span id="memberStatusBadge" class="admin-status admin-status--success">AKTIF</span>
                    </div>

                    <div class="receptionist-member" style="margin:24px 0;">
                        <div id="memberInitials" class="receptionist-member__avatar">--</div>
                        <h3 id="memberName" style="margin-top:12px;">Belum divalidasi</h3>
                        <p id="memberId" style="font-size:12px;color:#666;margin-top:4px;">Masukkan ID member di sebelah kiri</p>
                    </div>

                    <div class="receptionist-member-grid" style="margin-bottom:16px;">
                        <div>
                            <span>Paket</span>
                            <strong id="memberPackage">—</strong>
                        </div>
                        <div>
                            <span>Sisa Hari</span>
                            <strong id="memberRemaining">—</strong>
                        </div>
                    </div>

                    <p id="memberNote" class="receptionist-note"
                        style="font-size:12px;color:#888;margin-bottom:16px;padding:10px;background:#141414;border-radius:8px;border-left:3px solid #333;">
                        Menunggu validasi ID member...
                    </p>

                    <button type="button" id="confirmBtn" class="admin-primary-button receptionist-confirm-button"
                        style="width:100%;" disabled>
                        <span class="material-symbols-outlined" style="font-size:16px;vertical-align:-3px;">how_to_reg</span>
                        Konfirmasi Check-in
                    </button>
                </article>
            </section>

            {{-- RIWAYAT CHECK-IN HARI INI --}}
            <section class="admin-card admin-table-card" style="margin-top:0;">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Riwayat Check-in Hari Ini</h2>
                        <p>Log validasi member pada shift receptionist hari ini</p>
                    </div>
                    <span class="admin-pill admin-pill--positive" id="checkinCount">
                        {{ count($recentScans) }} check-in
                    </span>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table" id="checkinTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>ID Member</th>
                                <th>Paket</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="checkinBody">
                            @forelse($recentScans as $c)
                            <tr>
                                <td class="admin-table__strong">{{ $c['name'] }}</td>
                                <td>{{ $c['memberId'] }}</td>
                                <td>{{ $c['package'] }}</td>
                                <td>{{ $c['time'] }}</td>
                                <td><span class="admin-status admin-status--{{ $c['statusClass'] }}">{{ $c['status'] }}</span></td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="5" style="text-align:center;color:#555;padding:24px;">
                                    Belum ada check-in hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</div>

{{-- MODAL SUKSES --}}
<div id="successModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#1a1a1a;border:1px solid #2a3d0a;border-radius:16px;padding:40px 36px;text-align:center;max-width:360px;width:90%;">
        <div style="width:64px;height:64px;border-radius:50%;background:#1e2a0a;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <span class="material-symbols-outlined" style="font-size:32px;color:#c6f135;">how_to_reg</span>
        </div>
        <h2 style="font-size:18px;font-weight:700;color:#e0e0e0;margin-bottom:6px;">Check-in Berhasil!</h2>
        <p id="modalName" style="font-size:15px;color:#c6f135;font-weight:600;margin-bottom:4px;"></p>
        <p id="modalPackage" style="font-size:12px;color:#888;margin-bottom:8px;"></p>
        <p id="modalTime" style="font-size:12px;color:#555;margin-bottom:24px;"></p>
        <button type="button" id="modalClose" class="admin-primary-button" style="width:100%;">
            Scan Berikutnya
        </button>
    </div>
</div>

@push('scripts')
{{-- Library jsQR untuk decode QR dari kamera --}}
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

<style>
@keyframes scanAnim {
    0%   { top: 4px; }
    50%  { top: calc(100% - 6px); }
    100% { top: 4px; }
}
</style>

<script>
const members = @json($members);
const csrfToken = '{{ csrf_token() }}';

// ── State
let currentMember = null;
let cameraStream   = null;
let scanInterval   = null;
let checkinCount   = {{ count($recentScans) }};

// ── Elemen
const memberCode        = document.getElementById('memberCode');
const validateBtn       = document.getElementById('validateBtn');
const confirmBtn        = document.getElementById('confirmBtn');
const startCameraBtn    = document.getElementById('startCamera');
const stopCameraBtn     = document.getElementById('stopCamera');
const cameraFeed        = document.getElementById('cameraFeed');
const cameraStatus      = document.getElementById('cameraStatus');
const memberStatusBadge = document.getElementById('memberStatusBadge');
const memberInitials    = document.getElementById('memberInitials');
const memberName        = document.getElementById('memberName');
const memberId          = document.getElementById('memberId');
const memberPackage     = document.getElementById('memberPackage');
const memberRemaining   = document.getElementById('memberRemaining');
const memberNote        = document.getElementById('memberNote');
const successModal      = document.getElementById('successModal');
const checkinBody       = document.getElementById('checkinBody');
const checkinCountBadge = document.getElementById('checkinCount');

// ── Render hasil validasi
function renderMember(member) {
    currentMember = member;

    if (!member) {
        memberStatusBadge.className = 'admin-status admin-status--danger';
        memberStatusBadge.textContent = 'TIDAK VALID';
        memberInitials.textContent = '?';
        memberName.textContent = 'Member Tidak Ditemukan';
        memberId.textContent = 'ID tidak terdaftar dalam sistem';
        memberPackage.textContent = '—';
        memberRemaining.textContent = '—';
        memberNote.textContent = 'ID member tidak ditemukan. Periksa ulang atau hubungi admin.';
        memberNote.style.borderLeftColor = '#a32d2d';
        confirmBtn.disabled = true;
        return;
    }

    const isActive = member.status === 'active';
    const statusLabel = isActive ? 'AKTIF' : (member.status === 'expired' ? 'EXPIRED' : 'SUSPENDED');
    const statusClass = isActive ? 'success' : 'danger';

    memberStatusBadge.className = `admin-status admin-status--${statusClass}`;
    memberStatusBadge.textContent = statusLabel;
    memberInitials.textContent = member.initials;
    memberName.textContent = member.name;
    memberId.textContent = 'ID: ' + member.memberId;
    memberPackage.textContent = member.package;
    memberRemaining.textContent = member.remaining > 0 ? member.remaining + ' Hari' : 'Expired';
    memberNote.style.borderLeftColor = isActive ? '#c6f135' : '#a32d2d';

    if (isActive) {
        memberNote.textContent = 'Member valid. Silakan konfirmasi check-in.';
        confirmBtn.disabled = false;
    } else {
        memberNote.textContent = 'Member tidak aktif. Check-in tidak dapat dilakukan.';
        confirmBtn.disabled = true;
    }
}

// ── Validasi manual
function validateMember(code) {
    const key = code.trim().toUpperCase();
    renderMember(members[key] || null);
}

validateBtn.addEventListener('click', () => {
    validateMember(memberCode.value);
});

memberCode.addEventListener('keydown', e => {
    if (e.key === 'Enter') validateMember(memberCode.value);
});

// ── Kamera & QR Scan
startCameraBtn.addEventListener('click', async () => {
    try {
        cameraStream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' }
        });
        cameraFeed.srcObject = cameraStream;
        cameraStatus.textContent = 'Kamera Aktif';
        cameraStatus.className = 'admin-pill admin-pill--positive';
        startCameraBtn.style.display = 'none';
        stopCameraBtn.style.display = 'flex';

        // Scan frame setiap 500ms
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        scanInterval = setInterval(() => {
            if (cameraFeed.readyState !== cameraFeed.HAVE_ENOUGH_DATA) return;
            canvas.width  = cameraFeed.videoWidth;
            canvas.height = cameraFeed.videoHeight;
            ctx.drawImage(cameraFeed, 0, 0, canvas.width, canvas.height);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, canvas.width, canvas.height);
            if (code && code.data) {
                memberCode.value = code.data;
                validateMember(code.data);
                stopCamera(); // stop setelah berhasil scan
            }
        }, 500);

    } catch (err) {
        cameraStatus.textContent = 'Kamera Ditolak';
        cameraStatus.className = 'admin-pill admin-pill--danger';
        alert('Akses kamera ditolak. Gunakan input manual.');
    }
});

function stopCamera() {
    if (cameraStream) {
        cameraStream.getTracks().forEach(t => t.stop());
        cameraStream = null;
    }
    if (scanInterval) {
        clearInterval(scanInterval);
        scanInterval = null;
    }
    cameraFeed.srcObject = null;
    cameraStatus.textContent = 'Ready';
    cameraStatus.className = 'admin-pill admin-pill--positive';
    startCameraBtn.style.display = 'flex';
    stopCameraBtn.style.display = 'none';
}

stopCameraBtn.addEventListener('click', stopCamera);

// ── Konfirmasi Check-in (POST ke server)
confirmBtn.addEventListener('click', async () => {
    if (!currentMember) return;
    confirmBtn.disabled = true;
    confirmBtn.textContent = 'Menyimpan...';

    try {
        const res = await fetch('{{ route("scan-qr.checkin") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ member_id: currentMember.memberId }),
        });

        const data = await res.json();

        if (data.success) {
            // Tampilkan modal
            document.getElementById('modalName').textContent    = currentMember.name;
            document.getElementById('modalPackage').textContent = currentMember.package;
            document.getElementById('modalTime').textContent    = 'Check-in pukul ' + data.time;
            successModal.style.display = 'flex';

            // Tambahkan baris ke tabel riwayat
            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) emptyRow.remove();

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="admin-table__strong">${currentMember.name}</td>
                <td>${currentMember.memberId}</td>
                <td>${currentMember.package}</td>
                <td>${data.time}</td>
                <td><span class="admin-status admin-status--success">Berhasil</span></td>
            `;
            checkinBody.prepend(tr);

            checkinCount++;
            checkinCountBadge.textContent = checkinCount + ' check-in';
        } else {
            alert(data.message);
        }
    } catch (err) {
        alert('Terjadi kesalahan. Coba lagi.');
    } finally {
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = '<span class="material-symbols-outlined" style="font-size:16px;vertical-align:-3px;">how_to_reg</span> Konfirmasi Check-in';
    }
});

// ── Tutup modal
document.getElementById('modalClose').addEventListener('click', () => {
    successModal.style.display = 'none';
    memberCode.value = '';
    renderMember(null);
    memberStatusBadge.className = 'admin-status admin-status--success';
    memberStatusBadge.textContent = 'AKTIF';
    memberInitials.textContent = '--';
    memberName.textContent = 'Belum divalidasi';
    memberId.textContent = 'Masukkan ID member di sebelah kiri';
    memberNote.textContent = 'Menunggu validasi ID member...';
    memberNote.style.borderLeftColor = '#333';
    memberPackage.textContent = '—';
    memberRemaining.textContent = '—';
    currentMember = null;
});
</script>
@endpush

@endsection