@extends('layouts.admin')

@section('title', 'Dashboard Receptionist')

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
            <a href="{{ route('receptionist.dashboard') }}" class="admin-menu__item admin-menu__item--active">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('scan-qr.index') }}" class="admin-menu__item">
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
                <button type="submit" class="admin-menu__item admin-menu__item--danger" style="width: 100%; border: 0; background: transparent; cursor: pointer;">
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
                <h1>Dashboard Receptionist</h1>
            </div>

            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input id="globalMemberSearch" type="search" placeholder="Cari member atau ID..." aria-label="Cari member">
                </label>
                <button type="button" class="admin-icon-button" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="admin-icon-button__dot"></span>
                </button>
                <div class="admin-profile" aria-label="Profil receptionist">
                    <span>RC</span>
                </div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-card receptionist-hero">
                <div>
                    <p class="admin-eyebrow">Shift Hari Ini</p>
                    <h2>Selamat Datang, Receptionist</h2>
                    <p>Kelola check-in member, validasi status membership, dan transaksi POS harian melalui satu dashboard operasional.</p>
                </div>
                <a href="{{ route('scan-qr.index') }}" class="admin-primary-button receptionist-hero__button">
                    <span class="material-symbols-outlined">qr_code_scanner</span>
                    Scan QR Sekarang
                </a>
            </section>

            <section class="admin-stats" aria-label="Statistik receptionist">
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

            <section id="scan-qr" class="admin-grid admin-grid--two">
                <article class="admin-card receptionist-scanner-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Scan QR Member</h2>
                            <p>Gunakan kamera scanner atau masukkan ID member secara manual.</p>
                        </div>
                        <span class="admin-pill admin-pill--positive">Ready</span>
                    </div>

                    <div class="receptionist-scanner" aria-hidden="true">
                        <span class="material-symbols-outlined">qr_code_2</span>
                        <i></i>
                    </div>

                    <div class="receptionist-form">
                        <label for="memberCode">ID Member</label>
                        <input id="memberCode" type="text" value="MEM-2024-0891" placeholder="Contoh: MEM-2024-0891">
                        <button type="button" id="validateMember" class="admin-primary-button">Validasi Check-in</button>
                    </div>
                </article>

                <article class="admin-card receptionist-validation-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Hasil Validasi</h2>
                            <p>Status member akan berubah sesuai input ID.</p>
                        </div>
                        <span id="memberStatus" class="admin-status admin-status--success">AKTIF</span>
                    </div>

                    <div class="receptionist-member">
                        <div id="memberInitials" class="receptionist-member__avatar">AP</div>
                        <h3 id="memberName">Adrian Pratama</h3>
                        <p id="memberId">ID: MEM-2024-0891</p>
                    </div>

                    <div class="receptionist-member-grid">
                        <div>
                            <span>Paket</span>
                            <strong id="memberPackage">Monthly Elite</strong>
                        </div>
                        <div>
                            <span>Sisa Hari</span>
                            <strong id="memberRemaining">24 Hari</strong>
                        </div>
                    </div>

                    <p id="memberNote" class="receptionist-note">Member valid. Silakan konfirmasi check-in.</p>

                    <button type="button" id="confirmCheckin" class="admin-primary-button receptionist-confirm-button">
                        Konfirmasi Check-in
                    </button>
                </article>
            </section>

            <section id="riwayat-checkin" class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Riwayat Check-in Terbaru</h2>
                        <p>Log validasi member pada shift receptionist hari ini</p>
                    </div>
                    <a href="#" class="admin-text-link">Lihat Semua</a>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>ID Member</th>
                                <th>Paket</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checkIns as $checkIn)
                                <tr>
                                    <td class="admin-table__strong">{{ $checkIn['name'] }}</td>
                                    <td>{{ $checkIn['memberId'] }}</td>
                                    <td>{{ $checkIn['package'] }}</td>
                                    <td>{{ $checkIn['time'] }}</td>
                                    <td><span class="admin-status admin-status--{{ $checkIn['statusClass'] }}">{{ $checkIn['status'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="admin-grid admin-grid--two">
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Aktivitas Receptionist</h2>
                            <p>Aktivitas operasional terbaru di front desk</p>
                        </div>
                        <button type="button" class="admin-small-button">Refresh</button>
                    </div>
                    <div class="admin-activity-list">
                        @foreach ($activities as $activity)
                            <div class="admin-activity">
                                <span class="material-symbols-outlined">{{ $activity['icon'] }}</span>
                                <div>
                                    <p>{{ $activity['text'] }}</p>
                                    <small>{{ $activity['time'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Peringatan Sistem</h2>
                            <p>Informasi penting untuk validasi member dan keamanan akses</p>
                        </div>
                        <span class="admin-pill admin-pill--danger">2 Alerts</span>
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

            <section id="transaksi-pos" class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Transaksi POS Terbaru</h2>
                        <p>Penjualan produk gym dan minuman dari meja receptionist</p>
                    </div>
                    <button type="button" class="admin-small-button">Download Report</button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Kasir</th>
                                <th>Member</th>
                                <th>Produk</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posTransactions as $transaction)
                                <tr>
                                    <td class="admin-table__strong">{{ $transaction['trxId'] }}</td>
                                    <td>{{ $transaction['cashier'] }}</td>
                                    <td>{{ $transaction['member'] }}</td>
                                    <td>{{ $transaction['product'] }}</td>
                                    <td class="admin-table__strong">{{ $transaction['total'] }}</td>
                                    <td><span class="admin-status admin-status--{{ $transaction['statusClass'] }}">{{ $transaction['status'] }}</span></td>
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
    const receptionistMembers = @json($members);
    const fallbackMember = {
        name: 'Member Tidak Ditemukan',
        memberId: '-',
        package: '-',
        remaining: '-',
        status: 'TIDAK VALID',
        statusClass: 'danger',
        note: 'ID member tidak ditemukan pada data simulasi. Periksa ulang input atau hubungi admin.',
        initials: 'NA'
    };

    const memberCode = document.getElementById('memberCode');
    const validateMember = document.getElementById('validateMember');
    const confirmCheckin = document.getElementById('confirmCheckin');
    const memberStatus = document.getElementById('memberStatus');
    const memberInitials = document.getElementById('memberInitials');
    const memberName = document.getElementById('memberName');
    const memberId = document.getElementById('memberId');
    const memberPackage = document.getElementById('memberPackage');
    const memberRemaining = document.getElementById('memberRemaining');
    const memberNote = document.getElementById('memberNote');

    function renderMember(member) {
        memberStatus.className = `admin-status admin-status--${member.statusClass}`;
        memberStatus.textContent = member.status;
        memberInitials.textContent = member.initials;
        memberName.textContent = member.name;
        memberId.textContent = `ID: ${member.memberId}`;
        memberPackage.textContent = member.package;
        memberRemaining.textContent = member.remaining;
        memberNote.textContent = member.note;
        confirmCheckin.disabled = member.statusClass !== 'success';
        confirmCheckin.classList.toggle('receptionist-confirm-button--disabled', confirmCheckin.disabled);
    }

    validateMember.addEventListener('click', () => {
        const code = memberCode.value.trim().toUpperCase();
        renderMember(receptionistMembers[code] || fallbackMember);
    });

    memberCode.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            validateMember.click();
        }
    });

    confirmCheckin.addEventListener('click', () => {
        confirmCheckin.textContent = 'Check-in Berhasil Dicatat';
        setTimeout(() => {
            confirmCheckin.textContent = 'Konfirmasi Check-in';
        }, 1800);
    });
</script>
@endpush
