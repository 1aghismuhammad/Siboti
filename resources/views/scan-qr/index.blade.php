@extends('layouts.admin')

@section('title', 'Scan QR Check-in')

@section('content')
<div class="admin-shell scanqr-shell">
    <aside class="admin-sidebar" aria-label="Navigasi Scan QR">
        <div class="admin-brand">
            <a href="{{ url('/') }}" class="admin-brand__mark" aria-label="Kembali ke beranda Siboti">
                <span class="material-symbols-outlined">fitness_center</span>
            </a>
            <div>
                <p class="admin-brand__name">Siboti</p>
                <p class="admin-brand__label">Receptionist Portal</p>
            </div>
        </div>

        <nav class="admin-menu">
            <a href="{{ route('admin.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span>Admin Dashboard</span>
            </a>
            <a href="{{ route('receptionist.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard Receptionist</span>
            </a>
            <a href="{{ route('scan-qr.index') }}" class="admin-menu__item admin-menu__item--active">
                <span class="material-symbols-outlined">qr_code_scanner</span>
                <span>Scan QR</span>
            </a>
            <a href="#riwayat-scan" class="admin-menu__item">
                <span class="material-symbols-outlined">history</span>
                <span>Riwayat Check-in</span>
            </a>
            <a href="{{ route('pos.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">point_of_sale</span>
                <span>POS</span>
            </a>
            <a href="{{ route('reports.index') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">bar_chart</span>
                <span>Laporan</span>
            </a>
            <a href="#hasil-validasi" class="admin-menu__item">
                <span class="material-symbols-outlined">person_search</span>
                <span>Cari Member</span>
            </a>
            <a href="{{ route('trainer.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">fitness_center</span>
                <span>Personal Trainer</span>
            </a>
        </nav>

        <div class="admin-sidebar__footer">
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">settings</span>
                <span>Pengaturan</span>
            </a>
            <a href="{{ url('/') }}" class="admin-menu__item admin-menu__item--danger">
                <span class="material-symbols-outlined">logout</span>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <p class="admin-eyebrow">Front Desk Access Control</p>
                <h1>Scan QR Check-in</h1>
            </div>

            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input id="topScanSearch" type="search" placeholder="Cari ID member atau nama..." aria-label="Cari data scan QR">
                </label>
                <button type="button" class="admin-icon-button" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="admin-icon-button__dot"></span>
                </button>
                <div class="admin-profile" aria-label="Profil receptionist">
                    <span>QR</span>
                </div>
            </div>
        </header>

        <main class="admin-content scanqr-content">
            <section class="admin-card scanqr-hero">
                <div>
                    <p class="admin-eyebrow">Validasi Akses Member</p>
                    <h2>Scan QR member, cek status membership, lalu konfirmasi check-in dari satu halaman.</h2>
                    <p>Halaman ini disiapkan untuk receptionist saat member datang ke gym. Data masih dummy untuk kebutuhan presentasi frontend, tetapi alur UI sudah mengikuti kebutuhan check-in nyata.</p>
                </div>
                <div class="scanqr-hero__actions">
                    <button type="button" class="admin-primary-button" data-fill-code="MEM-2024-0891">
                        <span class="material-symbols-outlined">qr_code_scanner</span>
                        Simulasi Scan Valid
                    </button>
                    <button type="button" class="admin-small-button" data-fill-code="MEM-0455">
                        Simulasi Expired
                    </button>
                </div>
            </section>

            <section class="admin-stats" aria-label="Statistik scan QR">
                @foreach ($stats as $stat)
                    <article class="admin-card admin-stat-card">
                        <div class="admin-stat-card__top">
                            <div class="admin-card-icon">
                                <span class="material-symbols-outlined">{{ $stat['icon'] }}</span>
                            </div>
                            <span class="admin-pill admin-pill--{{ $stat['variant'] }}">{{ $stat['note'] }}</span>
                        </div>
                        <p>{{ $stat['label'] }}</p>
                        <h2>{{ $stat['value'] }}</h2>
                    </article>
                @endforeach
            </section>

            <section class="scanqr-main-grid">
                <article class="admin-card scanqr-scanner-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Area Scanner</h2>
                            <p>Pilih mode scan, lalu masukkan ID member untuk validasi manual atau demo.</p>
                        </div>
                        <span id="scannerModeBadge" class="admin-pill admin-pill--positive">QR Ready</span>
                    </div>

                    <div class="scanqr-mode-tabs" aria-label="Mode scanner">
                        <button type="button" class="scanqr-mode-tab is-active" data-scan-mode="QR Ready">
                            <span class="material-symbols-outlined">qr_code_scanner</span>
                            QR Scanner
                        </button>
                        <button type="button" class="scanqr-mode-tab" data-scan-mode="Manual Input">
                            <span class="material-symbols-outlined">keyboard</span>
                            Manual Input
                        </button>
                        <button type="button" class="scanqr-mode-tab" data-scan-mode="Kamera Demo">
                            <span class="material-symbols-outlined">photo_camera</span>
                            Kamera Demo
                        </button>
                    </div>

                    <div class="scanqr-scanner" aria-hidden="true">
                        <span class="material-symbols-outlined">qr_code_2</span>
                        <i></i>
                    </div>

                    <div class="scanqr-form">
                        <label for="scanCodeInput">ID Member / QR Token</label>
                        <div class="scanqr-input-row">
                            <input id="scanCodeInput" type="text" value="MEM-2024-0891" placeholder="Contoh: MEM-2024-0891">
                            <button type="button" id="scanValidateButton" class="admin-primary-button">Validasi</button>
                        </div>
                        <p id="scanHelperText">Contoh dummy: MEM-2024-0891, MEM-0012, MEM-0455, MEM-0921, MEM-0777.</p>
                    </div>
                </article>

                <aside class="scanqr-side-stack">
                    <article id="hasil-validasi" class="admin-card scanqr-result-card">
                        <div class="admin-section-head">
                            <div>
                                <h2>Hasil Validasi</h2>
                                <p>Status akses member muncul setelah QR divalidasi.</p>
                            </div>
                            <span id="scanStatus" class="admin-status admin-status--success">AKTIF</span>
                        </div>

                        <div class="scanqr-member-card">
                            <div id="scanMemberInitials" class="scanqr-member-avatar">AP</div>
                            <div>
                                <h3 id="scanMemberName">Adrian Pratama</h3>
                                <p id="scanMemberId">MEM-2024-0891</p>
                            </div>
                        </div>

                        <div class="scanqr-member-meta">
                            <div>
                                <span>Paket</span>
                                <strong id="scanMemberPackage">Monthly Elite</strong>
                            </div>
                            <div>
                                <span>Sisa Masa Aktif</span>
                                <strong id="scanMemberRemaining">24 Hari</strong>
                            </div>
                            <div>
                                <span>Check-in Terakhir</span>
                                <strong id="scanMemberLastCheckin">Belum check-in hari ini</strong>
                            </div>
                        </div>

                        <p id="scanMemberNote" class="scanqr-member-note">Member aktif. Check-in dapat dikonfirmasi.</p>

                        <div class="scanqr-result-actions">
                            <button type="button" id="confirmScanButton" class="admin-primary-button">
                                <span class="material-symbols-outlined">how_to_reg</span>
                                Konfirmasi Check-in
                            </button>
                            <button type="button" id="resetScanButton" class="admin-small-button">Reset</button>
                        </div>
                    </article>

                    <article class="admin-card scanqr-status-card">
                        <div class="scanqr-status-row">
                            <span class="material-symbols-outlined">settings_input_antenna</span>
                            <div>
                                <strong>Status Scanner</strong>
                                <p>Kamera front desk siap menerima QR member.</p>
                            </div>
                            <b>Online</b>
                        </div>
                        <div class="scanqr-status-row">
                            <span class="material-symbols-outlined">badge</span>
                            <div>
                                <strong>Mode Validasi</strong>
                                <p>Membership, duplikasi, dan blokir akun.</p>
                            </div>
                            <b>Aktif</b>
                        </div>
                    </article>
                </aside>
            </section>

            <section class="admin-grid admin-grid--two">
                <article class="admin-card scanqr-guide-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Cara Penggunaan</h2>
                            <p>Alur operasional receptionist saat melakukan check-in member.</p>
                        </div>
                    </div>
                    <div class="scanqr-guide-list">
                        @foreach ($instructions as $instruction)
                            <div class="scanqr-guide-item">
                                <span>{{ $instruction['step'] }}</span>
                                <div>
                                    <strong>{{ $instruction['title'] }}</strong>
                                    <p>{{ $instruction['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Peringatan Scan</h2>
                            <p>Informasi penting yang perlu diperhatikan receptionist.</p>
                        </div>
                    </div>
                    <div class="admin-alert-list">
                        @foreach ($alerts as $alert)
                            <div class="admin-alert admin-alert--{{ $alert['type'] }}">
                                <span class="material-symbols-outlined">{{ $alert['icon'] }}</span>
                                <div>
                                    <strong>{{ $alert['title'] }}</strong>
                                    <p>{{ $alert['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>

            <section id="riwayat-scan" class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Riwayat Scan Terbaru</h2>
                        <p>Log check-in QR dan validasi manual pada shift hari ini.</p>
                    </div>
                    <a href="{{ route('receptionist.dashboard') }}#riwayat-checkin" class="admin-text-link">Lihat Dashboard Receptionist</a>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Nama</th>
                                <th>ID Member</th>
                                <th>Metode</th>
                                <th>Gate</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="recentScanTable">
                            @foreach ($recentScans as $scan)
                                <tr>
                                    <td>{{ $scan['time'] }}</td>
                                    <td class="admin-table__strong">{{ $scan['name'] }}</td>
                                    <td>{{ $scan['memberId'] }}</td>
                                    <td>{{ $scan['method'] }}</td>
                                    <td>{{ $scan['gate'] }}</td>
                                    <td><span class="admin-status admin-status--{{ $scan['statusClass'] }}">{{ $scan['status'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const scanMembers = @json($members);

    const scanInput = document.getElementById('scanCodeInput');
    const scanStatus = document.getElementById('scanStatus');
    const scanMemberInitials = document.getElementById('scanMemberInitials');
    const scanMemberName = document.getElementById('scanMemberName');
    const scanMemberId = document.getElementById('scanMemberId');
    const scanMemberPackage = document.getElementById('scanMemberPackage');
    const scanMemberRemaining = document.getElementById('scanMemberRemaining');
    const scanMemberLastCheckin = document.getElementById('scanMemberLastCheckin');
    const scanMemberNote = document.getElementById('scanMemberNote');
    const confirmScanButton = document.getElementById('confirmScanButton');
    const scanHelperText = document.getElementById('scanHelperText');
    const recentScanTable = document.getElementById('recentScanTable');
    const scannerModeBadge = document.getElementById('scannerModeBadge');

    let selectedMember = scanMembers['MEM-2024-0891'];

    function normalizeScanCode(value) {
        const code = value.trim().toUpperCase();
        const tokenEntry = Object.values(scanMembers).find((member) => member.qrToken === code);
        return tokenEntry ? tokenEntry.memberId : code;
    }

    function setStatusClass(element, statusClass) {
        element.className = `admin-status admin-status--${statusClass}`;
    }

    function renderMember(member) {
        selectedMember = member;
        setStatusClass(scanStatus, member.statusClass);
        scanStatus.textContent = member.status;
        scanMemberInitials.textContent = member.initials;
        scanMemberName.textContent = member.name;
        scanMemberId.textContent = member.memberId;
        scanMemberPackage.textContent = member.package;
        scanMemberRemaining.textContent = member.remaining;
        scanMemberLastCheckin.textContent = member.lastCheckin;
        scanMemberNote.textContent = member.note;

        confirmScanButton.disabled = !member.access;
        confirmScanButton.classList.toggle('scanqr-confirm-disabled', !member.access);
        scanHelperText.textContent = member.access
            ? 'Status valid. Tekan Konfirmasi Check-in untuk mencatat akses masuk.'
            : 'Status tidak valid. Jangan beri akses sebelum masalah diselesaikan.';
    }

    function validateScan() {
        const normalizedCode = normalizeScanCode(scanInput.value);
        const member = scanMembers[normalizedCode];

        if (!member) {
            renderMember({
                name: 'Member Tidak Ditemukan',
                memberId: normalizedCode || 'UNKNOWN',
                package: '-',
                remaining: '-',
                lastCheckin: '-',
                status: 'INVALID',
                statusClass: 'danger',
                note: 'ID member atau QR token tidak ditemukan pada data dummy.',
                initials: '??',
                access: false,
            });
            return;
        }

        scanInput.value = member.memberId;
        renderMember(member);
    }

    document.getElementById('scanValidateButton').addEventListener('click', validateScan);
    scanInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            validateScan();
        }
    });

    document.querySelectorAll('[data-fill-code]').forEach((button) => {
        button.addEventListener('click', () => {
            scanInput.value = button.dataset.fillCode;
            validateScan();
        });
    });

    document.querySelectorAll('.scanqr-mode-tab').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.scanqr-mode-tab').forEach((tab) => tab.classList.remove('is-active'));
            button.classList.add('is-active');
            scannerModeBadge.textContent = button.dataset.scanMode;
        });
    });

    confirmScanButton.addEventListener('click', () => {
        if (!selectedMember || !selectedMember.access) {
            scanHelperText.textContent = 'Check-in tidak bisa dikonfirmasi karena status member tidak valid.';
            return;
        }

        const now = new Date();
        const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace(':', '.');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${time}</td>
            <td class="admin-table__strong">${selectedMember.name}</td>
            <td>${selectedMember.memberId}</td>
            <td>QR Scanner</td>
            <td>Front Desk</td>
            <td><span class="admin-status admin-status--success">Berhasil</span></td>
        `;
        recentScanTable.prepend(row);
        scanHelperText.textContent = `Check-in ${selectedMember.name} berhasil dicatat pada ${time}.`;
    });

    document.getElementById('resetScanButton').addEventListener('click', () => {
        scanInput.value = 'MEM-2024-0891';
        renderMember(scanMembers['MEM-2024-0891']);
    });

    document.getElementById('topScanSearch').addEventListener('input', (event) => {
        scanInput.value = event.target.value;
    });
</script>
@endpush
