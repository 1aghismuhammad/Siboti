@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="admin-shell">
    <aside class="admin-sidebar" aria-label="Navigasi admin">
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
            <a href="{{ url('/admin/dashboard') }}" class="admin-menu__item admin-menu__item--active">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">group</span>
                <span>Pengguna</span>
            </a>
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">card_membership</span>
                <span>Paket Keanggotaan</span>
            </a>
            <a href="{{ route('trainer.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">fitness_center</span>
                <span>Personal Trainer</span>
            </a>
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">event_available</span>
                <span>Booking</span>
            </a>
            <a href="{{ route('receptionist.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">support_agent</span>
                <span>Receptionist</span>
            </a>
            <a href="{{ route('scan-qr.index') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">qr_code_scanner</span>
                <span>Scan QR</span>
            </a>
            <a href="{{ route('pos.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">point_of_sale</span>
                <span>Transaksi POS</span>
            </a>
            <a href="{{ route('reports.index') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">bar_chart</span>
                <span>Laporan</span>
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
                <p class="admin-eyebrow">Panel Administrator</p>
                <h1>Dashboard Admin</h1>
            </div>

            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="search" placeholder="Cari member, booking, transaksi..." aria-label="Cari data admin">
                </label>
                <button type="button" class="admin-icon-button" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="admin-icon-button__dot"></span>
                </button>
                <div class="admin-profile" aria-label="Profil admin">
                    <span>AD</span>
                </div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-stats" aria-label="Statistik ringkas">
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

            <section class="admin-grid admin-grid--two">
                <article class="admin-card admin-chart-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Pertumbuhan Membership Bulanan</h2>
                            <p>Januari sampai Juni 2026</p>
                        </div>
                        <button type="button" class="admin-small-button">Filter</button>
                    </div>
                    <div class="admin-line-chart" aria-hidden="true">
                        <svg viewBox="0 0 600 220" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="lineArea" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#ccff00" stop-opacity="0.28" />
                                    <stop offset="100%" stop-color="#ccff00" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <path d="M0 180 L120 150 L240 85 L360 110 L480 55 L600 32 L600 220 L0 220 Z" fill="url(#lineArea)" />
                            <path d="M0 180 L120 150 L240 85 L360 110 L480 55 L600 32" fill="none" stroke="#ccff00" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="120" cy="150" r="6" />
                            <circle cx="240" cy="85" r="6" />
                            <circle cx="360" cy="110" r="6" />
                            <circle cx="480" cy="55" r="6" />
                        </svg>
                    </div>
                </article>

                <article class="admin-card admin-chart-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Aktivitas Booking & Check-in</h2>
                            <p>7 hari terakhir</p>
                        </div>
                    </div>
                    <div class="admin-bar-chart" aria-label="Grafik aktivitas booking dan check-in">
                        @foreach ([60, 70, 45, 80, 55, 90, 75] as $height)
                            <div class="admin-bar-chart__group">
                                <span class="admin-bar admin-bar--muted" style="height: {{ max($height - 18, 25) }}%"></span>
                                <span class="admin-bar admin-bar--neon" style="height: {{ $height }}%"></span>
                            </div>
                        @endforeach
                    </div>
                    <div class="admin-chart-legend">
                        <span><i class="legend-muted"></i> Booking</span>
                        <span><i class="legend-neon"></i> Check-in</span>
                    </div>
                </article>
            </section>

            <section class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Booking Terbaru</h2>
                        <p>Daftar reservasi kelas dan personal training terbaru</p>
                    </div>
                    <button type="button" class="admin-primary-button">+ Booking Baru</button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Pelatih</th>
                                <th>Sesi</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td class="admin-table__strong">{{ $booking['member'] }}</td>
                                    <td>{{ $booking['trainer'] }}</td>
                                    <td>{{ $booking['session'] }}</td>
                                    <td>{{ $booking['date'] }}</td>
                                    <td>{{ $booking['time'] }}</td>
                                    <td><span class="admin-status admin-status--{{ $booking['statusClass'] }}">{{ $booking['status'] }}</span></td>
                                    <td class="text-right">
                                        @if($booking['status'] === 'Pending')
                                            <form action="{{ route('booking.update', $booking['id']) }}" method="POST" style="display:inline-block; margin-right:.5rem;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="admin-link-button">Setujui</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('booking.destroy', $booking['id']) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-link-button admin-link-button--danger">Batalkan</button>
                                        </form>
                                    </td>
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
                            <h2>Ringkasan Status Membership</h2>
                            <p>Kondisi keanggotaan aktif dan expired</p>
                        </div>
                    </div>
                    <div class="admin-progress-list">
                        <div class="admin-progress-item">
                            <div><span>Aktif</span><strong>75%</strong></div>
                            <progress max="100" value="75"></progress>
                        </div>
                        <div class="admin-progress-item admin-progress-item--danger">
                            <div><span>Mendekati Expired</span><strong>15%</strong></div>
                            <progress max="100" value="15"></progress>
                        </div>
                        <div class="admin-progress-item admin-progress-item--muted">
                            <div><span>Telah Expired</span><strong>10%</strong></div>
                            <progress max="100" value="10"></progress>
                        </div>
                    </div>
                    <div class="admin-summary-line">
                        <span>Total expired bulan ini</span>
                        <strong>12</strong>
                    </div>
                </article>

                <article class="admin-card admin-table-card">
                    <div class="admin-section-head admin-section-head--bordered">
                        <div>
                            <h2>Transaksi POS Terbaru</h2>
                            <p>Penjualan produk gym dan minuman</p>
                        </div>
                        <a href="#" class="admin-text-link">Lihat Semua</a>
                    </div>
                    <div class="admin-transaction-list">
                        @foreach ($transactions as $transaction)
                            <div class="admin-transaction">
                                <div class="admin-transaction__item">
                                    <span class="material-symbols-outlined">{{ $transaction['icon'] }}</span>
                                    <div>
                                        <strong>{{ $transaction['item'] }}</strong>
                                        <small>{{ $transaction['time'] }}</small>
                                    </div>
                                </div>
                                <strong>{{ $transaction['amount'] }}</strong>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>

            <section class="admin-quick-actions" aria-label="Aksi cepat admin">
                <a href="{{ route('receptionist.dashboard') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">support_agent</span>
                    <strong>Dashboard Receptionist</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
                <a href="{{ route('scan-qr.index') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">qr_code_scanner</span>
                    <strong>Scan QR Check-in</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
                <a href="{{ route('pos.dashboard') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">point_of_sale</span>
                    <strong>Dashboard POS</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
                <a href="{{ route('trainer.dashboard') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">sports</span>
                    <strong>Dashboard Personal Trainer</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
                <a href="{{ route('reports.index') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">insert_chart</span>
                    <strong>Laporan Operasional</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
            </section>

            <section class="admin-grid admin-grid--two">
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Aktivitas Pengguna Terbaru</h2>
                            <p>Riwayat aktivitas singkat dalam sistem</p>
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
                            <p>Notifikasi penting untuk operasional gym</p>
                        </div>
                        <span class="admin-pill admin-pill--danger">3 Alerts</span>
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
