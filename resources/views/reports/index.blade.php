@extends('layouts.admin')

@section('title', 'Laporan Operasional')

@section('content')
<div class="admin-shell report-shell">
    <aside class="admin-sidebar" aria-label="Navigasi laporan">
        <div class="admin-brand">
            <a href="{{ url('/') }}" class="admin-brand__mark" aria-label="Kembali ke beranda Siboti">
                <span class="material-symbols-outlined">fitness_center</span>
            </a>
            <div>
                <p class="admin-brand__name">Siboti</p>
                <p class="admin-brand__label">Report Center</p>
            </div>
        </div>

        <nav class="admin-menu">
            <a href="{{ route('admin.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span>Admin Dashboard</span>
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
                <span>POS</span>
            </a>
            <a href="{{ route('trainer.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">fitness_center</span>
                <span>Personal Trainer</span>
            </a>
            <a href="{{ route('reports.index') }}" class="admin-menu__item admin-menu__item--active">
                <span class="material-symbols-outlined">bar_chart</span>
                <span>Laporan</span>
            </a>
            <a href="#membership-report" class="admin-menu__item">
                <span class="material-symbols-outlined">card_membership</span>
                <span>Membership</span>
            </a>
            <a href="#booking-checkin-report" class="admin-menu__item">
                <span class="material-symbols-outlined">fact_check</span>
                <span>Booking & Check-in</span>
            </a>
            <a href="#pos-report" class="admin-menu__item">
                <span class="material-symbols-outlined">receipt_long</span>
                <span>Transaksi POS</span>
            </a>
        </nav>

        <div class="admin-sidebar__footer">
            <a href="#filter-laporan" class="admin-menu__item">
                <span class="material-symbols-outlined">tune</span>
                <span>Filter Laporan</span>
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
                <p class="admin-eyebrow">Panel Laporan Admin</p>
                <h1>Laporan Operasional Gym</h1>
            </div>

            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input id="reportSearch" type="search" placeholder="Cari laporan, member, transaksi..." aria-label="Cari laporan">
                </label>
                <button type="button" id="exportReport" class="admin-icon-button" aria-label="Export laporan">
                    <span class="material-symbols-outlined">download</span>
                </button>
                <div class="admin-profile" aria-label="Profil admin laporan">
                    <span>RP</span>
                </div>
            </div>
        </header>

        <main class="admin-content report-content">
            <section class="admin-card report-hero" id="filter-laporan">
                <div class="report-hero__copy">
                    <p class="admin-eyebrow">Report Center</p>
                    <h2>Laporan Operasional Gym</h2>
                    <p>Pantau ringkasan member, booking, check-in, trainer, dan transaksi POS dalam satu halaman laporan yang mudah dibaca.</p>
                </div>
                <form class="report-filter" aria-label="Filter laporan">
                    <div>
                        <label for="reportStartDate">Tanggal Awal</label>
                        <input id="reportStartDate" type="date" value="2026-05-01">
                    </div>
                    <div>
                        <label for="reportEndDate">Tanggal Akhir</label>
                        <input id="reportEndDate" type="date" value="2026-05-24">
                    </div>
                    <div>
                        <label for="reportType">Jenis Laporan</label>
                        <select id="reportType">
                            <option>Semua Laporan</option>
                            <option>Membership</option>
                            <option>Booking & Check-in</option>
                            <option>Transaksi POS</option>
                        </select>
                    </div>
                    <div>
                        <label for="reportStatus">Status</label>
                        <select id="reportStatus">
                            <option>Semua Status</option>
                            <option>Aktif</option>
                            <option>Selesai</option>
                            <option>Pending</option>
                            <option>Expired</option>
                        </select>
                    </div>
                    <button type="button" id="applyReportFilter" class="admin-primary-button">Terapkan Filter</button>
                    <button type="reset" class="admin-small-button">Reset</button>
                </form>
            </section>

            <section id="operational-summary" class="admin-stats report-stats" aria-label="Statistik laporan">
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

            <section class="report-category-grid" aria-label="Kategori laporan">
                @foreach ($reportCategories as $category)
                    <a href="{{ $category['target'] }}" class="admin-quick-action report-category-card">
                        <span class="material-symbols-outlined">{{ $category['icon'] }}</span>
                        <div>
                            <strong>{{ $category['title'] }}</strong>
                            <small>{{ $category['description'] }}</small>
                        </div>
                        <i class="material-symbols-outlined">chevron_right</i>
                    </a>
                @endforeach
            </section>

            <section class="admin-grid admin-grid--two">
                <article class="admin-card report-chart-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Aktivitas Booking dan Check-in</h2>
                            <p>Perbandingan jumlah booking dan check-in dalam 7 hari terakhir.</p>
                        </div>
                        <span class="admin-pill admin-pill--positive">Live Dummy</span>
                    </div>
                    <div class="report-combo-chart" aria-label="Grafik booking dan check-in">
                        @foreach ($bookingCheckinChart as $item)
                            <div class="report-combo-chart__group">
                                <div class="report-combo-chart__bars">
                                    <span class="report-bar report-bar--muted" style="height: {{ $item['booking'] }}%"></span>
                                    <span class="report-bar report-bar--neon" style="height: {{ $item['checkin'] }}%"></span>
                                </div>
                                <small>{{ $item['label'] }}</small>
                            </div>
                        @endforeach
                    </div>
                    <div class="admin-chart-legend">
                        <span><i class="legend-muted"></i> Booking</span>
                        <span><i class="legend-neon"></i> Check-in</span>
                    </div>
                </article>

                <article class="admin-card report-chart-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Pertumbuhan Member</h2>
                            <p>Simulasi perkembangan jumlah member aktif dari Januari sampai Juni 2026.</p>
                        </div>
                        <button type="button" class="admin-small-button">Detail</button>
                    </div>
                    <div class="report-growth-list">
                        @php
                            $maxGrowth = max(array_column($memberGrowth, 'total'));
                        @endphp
                        @foreach ($memberGrowth as $growth)
                            <div class="report-growth-row">
                                <span>{{ $growth['month'] }}</span>
                                <div>
                                    <i style="width: {{ round(($growth['total'] / $maxGrowth) * 100) }}%"></i>
                                </div>
                                <strong>{{ number_format($growth['total'], 0, ',', '.') }}</strong>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>

            <section id="membership-report" class="admin-card admin-table-card report-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Laporan Membership</h2>
                        <p>Data status member, paket, tanggal daftar, dan tanggal kadaluarsa.</p>
                    </div>
                    <button type="button" class="admin-small-button report-download-button" data-report="Membership">Download CSV</button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table report-table" data-report-table>
                        <thead>
                            <tr>
                                <th>ID Member</th>
                                <th>Nama</th>
                                <th>Paket</th>
                                <th>Tanggal Daftar</th>
                                <th>Kadaluarsa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memberships as $member)
                                <tr>
                                    <td class="admin-table__strong">{{ $member['id'] }}</td>
                                    <td>{{ $member['name'] }}</td>
                                    <td>{{ $member['package'] }}</td>
                                    <td>{{ $member['registered'] }}</td>
                                    <td>{{ $member['expired'] }}</td>
                                    <td><span class="admin-status admin-status--{{ $member['statusClass'] }}">{{ $member['status'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="booking-checkin-report" class="admin-card admin-table-card report-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Laporan Booking & Check-in</h2>
                        <p>Ringkasan jadwal member, sesi trainer/kelas, waktu check-in, dan status sesi.</p>
                    </div>
                    <button type="button" class="admin-small-button report-download-button" data-report="Booking Check-in">Download CSV</button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table report-table" data-report-table>
                        <thead>
                            <tr>
                                <th>ID Booking</th>
                                <th>Member</th>
                                <th>Trainer/Kelas</th>
                                <th>Waktu Booking</th>
                                <th>Waktu Check-in</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookingCheckins as $booking)
                                <tr>
                                    <td class="admin-table__strong">{{ $booking['id'] }}</td>
                                    <td>{{ $booking['member'] }}</td>
                                    <td>{{ $booking['session'] }}</td>
                                    <td>{{ $booking['bookingTime'] }}</td>
                                    <td>{{ $booking['checkinTime'] }}</td>
                                    <td><span class="admin-status admin-status--{{ $booking['statusClass'] }}">{{ $booking['status'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="pos-report" class="admin-card admin-table-card report-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Laporan Transaksi POS</h2>
                        <p>Daftar transaksi produk gym, metode pembayaran, total harga, dan status pembayaran.</p>
                    </div>
                    <button type="button" class="admin-small-button report-download-button" data-report="Transaksi POS">Download CSV</button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table report-table" data-report-table>
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Item</th>
                                <th>Total Harga</th>
                                <th>Metode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posTransactions as $transaction)
                                <tr>
                                    <td class="admin-table__strong">#{{ $transaction['id'] }}</td>
                                    <td>{{ $transaction['date'] }}</td>
                                    <td>{{ $transaction['item'] }}</td>
                                    <td class="report-table__money">{{ $transaction['total'] }}</td>
                                    <td>{{ $transaction['method'] }}</td>
                                    <td><span class="admin-status admin-status--{{ $transaction['statusClass'] }}">{{ $transaction['status'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="admin-grid admin-grid--two">
                <article class="admin-card report-export-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Export Laporan</h2>
                            <p>Simulasi export file untuk kebutuhan dokumentasi admin.</p>
                        </div>
                    </div>
                    <div class="report-export-actions">
                        <button type="button" class="admin-primary-button report-download-button" data-report="Semua Laporan">Export Semua</button>
                        <button type="button" class="admin-small-button report-download-button" data-report="PDF Ringkasan">Export PDF</button>
                        <button type="button" class="admin-small-button report-download-button" data-report="Excel Detail">Export Excel</button>
                    </div>
                    <p id="reportMessage" class="report-message">Export masih berupa simulasi frontend. Integrasi backend bisa diarahkan ke endpoint laporan saat database siap.</p>
                </article>

                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Peringatan Laporan</h2>
                            <p>Hal yang perlu ditindaklanjuti dari data operasional.</p>
                        </div>
                        <span class="admin-pill admin-pill--danger">{{ count($alerts) }} Alerts</span>
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
    const reportSearch = document.getElementById('reportSearch');
    const reportMessage = document.getElementById('reportMessage');
    const applyReportFilter = document.getElementById('applyReportFilter');
    const exportReport = document.getElementById('exportReport');
    const reportTables = Array.from(document.querySelectorAll('[data-report-table]'));

    function filterReportTables(keyword) {
        const normalizedKeyword = keyword.trim().toLowerCase();

        reportTables.forEach((table) => {
            Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                const rowText = row.textContent.toLowerCase();
                row.hidden = normalizedKeyword !== '' && !rowText.includes(normalizedKeyword);
            });
        });
    }

    function showReportMessage(message) {
        if (!reportMessage) return;
        reportMessage.textContent = message;
        reportMessage.classList.add('report-message--active');
        window.setTimeout(() => reportMessage.classList.remove('report-message--active'), 2400);
    }

    if (reportSearch) {
        reportSearch.addEventListener('input', (event) => filterReportTables(event.target.value));
    }

    if (applyReportFilter) {
        applyReportFilter.addEventListener('click', () => {
            showReportMessage('Filter laporan berhasil diterapkan pada tampilan dummy. Data belum mengambil dari database.');
        });
    }

    if (exportReport) {
        exportReport.addEventListener('click', () => showReportMessage('Export laporan disiapkan. Ini masih simulasi frontend.'));
    }

    document.querySelectorAll('.report-download-button').forEach((button) => {
        button.addEventListener('click', () => {
            const reportName = button.dataset.report || 'Laporan';
            showReportMessage(`${reportName} berhasil disiapkan dalam mode simulasi.`);
        });
    });
</script>
@endpush
