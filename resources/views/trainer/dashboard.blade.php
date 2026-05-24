@extends('layouts.admin')

@section('title', 'Dashboard Personal Trainer')

@section('content')
<div class="admin-shell trainer-shell">
    <aside class="admin-sidebar" aria-label="Navigasi personal trainer">
        <div class="admin-brand">
            <a href="{{ url('/') }}" class="admin-brand__mark" aria-label="Kembali ke beranda Siboti">
                <span class="material-symbols-outlined">fitness_center</span>
            </a>
            <div>
                <p class="admin-brand__name">Siboti</p>
                <p class="admin-brand__label">Trainer Desk</p>
            </div>
        </div>

        <nav class="admin-menu">
            <a href="{{ route('admin.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span>Admin Dashboard</span>
            </a>
            <a href="{{ route('receptionist.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">qr_code_scanner</span>
                <span>Receptionist</span>
            </a>
            <a href="{{ route('trainer.dashboard') }}" class="admin-menu__item admin-menu__item--active">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="#jadwal-saya" class="admin-menu__item">
                <span class="material-symbols-outlined">calendar_today</span>
                <span>Jadwal Saya</span>
            </a>
            <a href="#booking-member" class="admin-menu__item">
                <span class="material-symbols-outlined">event_available</span>
                <span>Booking Member</span>
            </a>
            <a href="#daftar-klien" class="admin-menu__item">
                <span class="material-symbols-outlined">group</span>
                <span>Daftar Klien</span>
            </a>
            <a href="#input-progres" class="admin-menu__item">
                <span class="material-symbols-outlined">edit_note</span>
                <span>Input Progres</span>
            </a>
            <a href="#riwayat-progres" class="admin-menu__item">
                <span class="material-symbols-outlined">history</span>
                <span>Riwayat Progres</span>
            </a>
            <a href="{{ route('reports.index') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">bar_chart</span>
                <span>Laporan</span>
            </a>
        </nav>

        <div class="admin-sidebar__footer">
            <div class="trainer-sidebar-profile" aria-label="Profil trainer">
                <div class="trainer-avatar trainer-avatar--small">CA</div>
                <div>
                    <strong>Coach Aris</strong>
                    <span>Senior Trainer</span>
                </div>
            </div>
            <a href="{{ url('/') }}" class="admin-menu__item admin-menu__item--danger">
                <span class="material-symbols-outlined">logout</span>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <p class="admin-eyebrow">Panel Operasional Personal Trainer</p>
                <h1>Dashboard Personal Trainer</h1>
            </div>

            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input id="trainerSearch" type="search" placeholder="Cari klien atau jadwal..." aria-label="Cari klien atau jadwal">
                </label>
                <button type="button" class="admin-icon-button" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="admin-icon-button__dot"></span>
                </button>
                <div class="admin-profile" aria-label="Profil trainer">
                    <span>CA</span>
                </div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-card trainer-hero">
                <div>
                    <p class="admin-eyebrow">Selamat Datang, Coach Aris</p>
                    <h2>Kelola jadwal, booking, klien, dan progres latihan dalam satu dashboard.</h2>
                    <p>Dashboard ini disiapkan untuk aktivitas personal trainer: membaca jadwal harian, memantau booking member, melihat klien aktif, dan mencatat progres fisik setelah sesi latihan.</p>
                </div>
                <a href="#input-progres" class="admin-primary-button trainer-hero__button">
                    <span class="material-symbols-outlined">edit_note</span>
                    Input Progres Baru
                </a>
            </section>

            <section class="admin-stats" aria-label="Statistik personal trainer">
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

            <section class="admin-grid trainer-overview-grid">
                <article id="jadwal-saya" class="admin-card trainer-schedule-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Jadwal Latihan Hari Ini</h2>
                            <p>Urutan sesi personal trainer berdasarkan waktu pelaksanaan</p>
                        </div>
                        <a href="#" class="admin-text-link">Lihat Kalender</a>
                    </div>

                    <div class="trainer-timeline">
                        @foreach ($todaySchedules as $schedule)
                            <div class="trainer-timeline__item trainer-timeline__item--{{ $schedule['statusClass'] }}">
                                <div class="trainer-timeline__time">
                                    <strong>{{ $schedule['start'] }}</strong>
                                    <span>{{ $schedule['end'] }}</span>
                                </div>
                                <div class="trainer-avatar">{{ $schedule['initials'] }}</div>
                                <div class="trainer-timeline__body">
                                    <strong>{{ $schedule['member'] }}</strong>
                                    <span>{{ $schedule['program'] }} • {{ $schedule['focus'] }}</span>
                                </div>
                                <span class="admin-status admin-status--{{ $schedule['statusClass'] }}">{{ $schedule['status'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="admin-card trainer-booking-mini">
                    <div class="admin-section-head">
                        <div>
                            <h2>Booking Terbaru</h2>
                            <p>Antrean booking yang perlu dipantau trainer</p>
                        </div>
                        <a href="#booking-member" class="admin-text-link">Kelola</a>
                    </div>

                    <div class="trainer-booking-list">
                        @foreach ($recentBookings as $booking)
                            <div class="trainer-booking-item">
                                <div>
                                    <strong>{{ $booking['member'] }}</strong>
                                    <span>{{ $booking['membership'] }} • {{ $booking['time'] }}</span>
                                </div>
                                <div class="trainer-booking-item__actions">
                                    <button type="button" aria-label="Setujui booking {{ $booking['member'] }}">
                                        <span class="material-symbols-outlined">check_circle</span>
                                    </button>
                                    <button type="button" class="trainer-action-danger" aria-label="Tolak booking {{ $booking['member'] }}">
                                        <span class="material-symbols-outlined">cancel</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>

            <section id="booking-member" class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Daftar Booking Member</h2>
                        <p>Daftar reservasi sesi yang berkaitan dengan personal trainer</p>
                    </div>
                    <button type="button" class="admin-primary-button">+ Tambah Booking</button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama Member</th>
                                <th>Program</th>
                                <th>Tanggal & Waktu</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td class="admin-table__strong">
                                        <span class="trainer-table-member"><i>{{ $booking['initials'] }}</i>{{ $booking['member'] }}</span>
                                    </td>
                                    <td>{{ $booking['program'] }}</td>
                                    <td>{{ $booking['dateTime'] }}</td>
                                    <td><span class="admin-status admin-status--{{ $booking['statusClass'] }}">{{ $booking['status'] }}</span></td>
                                    <td class="text-right"><a href="#" class="admin-link-button">Detail</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="daftar-klien" class="trainer-client-section">
                <div class="admin-section-head">
                    <div>
                        <h2>Daftar Klien Aktif</h2>
                        <p>Member yang sedang berada dalam program personal training</p>
                    </div>
                    <button type="button" class="admin-primary-button">Tambah Klien Baru</button>
                </div>

                <div class="trainer-client-grid">
                    @foreach ($clients as $client)
                        <article class="admin-card trainer-client-card">
                            <div class="trainer-client-card__head">
                                <div class="trainer-avatar trainer-avatar--large">{{ $client['initials'] }}</div>
                                <div>
                                    <h3>{{ $client['name'] }}</h3>
                                    <p>ID: {{ $client['clientId'] }}</p>
                                </div>
                            </div>

                            <div class="trainer-client-meta">
                                <div>
                                    <span>Paket</span>
                                    <strong>{{ $client['package'] }}</strong>
                                </div>
                                <div>
                                    <span>{{ $client['remainingLabel'] }}</span>
                                    <strong class="trainer-client-meta__{{ $client['statusClass'] }}">{{ $client['remaining'] }}</strong>
                                </div>
                            </div>

                            <div class="trainer-client-card__actions">
                                <button type="button" class="admin-small-button">Lihat Profil</button>
                                <button type="button" class="admin-primary-button trainer-fill-progress" data-client="{{ $client['name'] }}">Input Progres</button>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section id="input-progres" class="admin-grid trainer-progress-grid">
                <article class="admin-card trainer-progress-form-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Input Progres Fisik Member</h2>
                            <p>Form pencatatan progres latihan setelah evaluasi atau sesi selesai</p>
                        </div>
                    </div>

                    <form id="trainerProgressForm" class="trainer-progress-form">
                        <div class="trainer-form-grid trainer-form-grid--two">
                            <label>
                                <span>Pilih Member</span>
                                <select id="progressClient" name="client">
                                    @foreach ($clients as $client)
                                        <option value="{{ $client['name'] }}">{{ $client['name'] }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label>
                                <span>Tanggal Pengukuran</span>
                                <input name="measurement_date" type="date" value="{{ now()->format('Y-m-d') }}">
                            </label>
                        </div>

                        <div class="trainer-form-grid trainer-form-grid--three">
                            <label>
                                <span>Berat Badan (kg)</span>
                                <input name="weight" type="number" step="0.1" placeholder="00.0">
                            </label>
                            <label>
                                <span>Tinggi Badan (cm)</span>
                                <input name="height" type="number" placeholder="000">
                            </label>
                            <label>
                                <span>Lingkar Pinggang (cm)</span>
                                <input name="waist" type="number" placeholder="00">
                            </label>
                        </div>

                        <label>
                            <span>Catatan Evaluasi</span>
                            <textarea name="notes" rows="4" placeholder="Masukkan detail perkembangan klien, kendala latihan, dan rekomendasi sesi berikutnya..."></textarea>
                        </label>

                        <div class="trainer-form-actions">
                            <button type="reset" class="admin-small-button">Reset</button>
                            <button type="submit" class="admin-primary-button">Simpan Progres</button>
                        </div>
                    </form>
                </article>

                <article id="riwayat-progres" class="admin-card trainer-history-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Riwayat Terbaru</h2>
                            <p>Input progres terakhir dari personal trainer</p>
                        </div>
                    </div>

                    <div id="progressHistoryList" class="trainer-history-list">
                        @foreach ($progressHistory as $history)
                            <div class="trainer-history-item">
                                <div>
                                    <strong>{{ $history['member'] }}</strong>
                                    <span>{{ $history['time'] }}</span>
                                </div>
                                <p>BB: {{ $history['weight'] }} • LP: {{ $history['waist'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>

            <section class="trainer-performance-section">
                <div class="admin-section-head">
                    <div>
                        <h2>Ringkasan Performa Klien</h2>
                        <p>Indikator ringkas untuk membaca capaian program latihan</p>
                    </div>
                </div>

                <div class="trainer-performance-grid">
                    @foreach ($performanceSummaries as $summary)
                        <article class="admin-card trainer-performance-card trainer-performance-card--{{ $summary['variant'] }}">
                            <p>{{ $summary['label'] }}</p>
                            <h3>{{ $summary['value'] }} @if($summary['unit']) <span>{{ $summary['unit'] }}</span> @endif</h3>
                            <progress max="100" value="{{ $summary['progress'] }}"></progress>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="admin-grid admin-grid--two">
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Aktivitas Trainer</h2>
                            <p>Riwayat aktivitas operasional terbaru</p>
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
                            <h2>System Alerts</h2>
                            <p>Peringatan untuk trainer dan sinkronisasi jadwal</p>
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
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const progressForm = document.getElementById('trainerProgressForm');
    const progressClient = document.getElementById('progressClient');
    const progressHistoryList = document.getElementById('progressHistoryList');

    document.querySelectorAll('.trainer-fill-progress').forEach((button) => {
        button.addEventListener('click', () => {
            progressClient.value = button.dataset.client;
            document.getElementById('input-progres').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    progressForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(progressForm);
        const client = formData.get('client');
        const weight = formData.get('weight') || '-';
        const waist = formData.get('waist') || '-';

        const item = document.createElement('div');
        item.className = 'trainer-history-item trainer-history-item--new';
        item.innerHTML = `<div><strong>${client}</strong><span>Baru saja</span></div><p>BB: ${weight} kg • LP: ${waist} cm</p>`;
        progressHistoryList.prepend(item);
        progressForm.reset();
        progressClient.value = client;
    });
</script>
@endpush
