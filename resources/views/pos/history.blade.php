@extends('layouts.admin')

@section('title', 'Riwayat Transaksi POS')

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
            <a href="{{ route('scan-qr.index') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">qr_code_scanner</span>
                <span>Scan QR</span>
            </a>
            <a href="{{ route('pos.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">point_of_sale</span>
                <span>Transaksi POS</span>
            </a>
            <a href="{{ route('pos.history') }}" class="admin-menu__item admin-menu__item--active">
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
                <h1>Riwayat Transaksi</h1>
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
            <section class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Riwayat Transaksi</h2>
                        <p>Penjualan produk gym</p>
                    </div>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Item</th>
                                <th>Total</th>
                                <th>Kasir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12 Jun 2026</td>
                                <td>Protein Shake x2</td>
                                <td class="admin-table__strong">Rp50.000</td>
                                <td>Admin</td>
                            </tr>
                            <tr>
                                <td>12 Jun 2026</td>
                                <td>Energy Drink x1</td>
                                <td class="admin-table__strong">Rp15.000</td>
                                <td>Admin</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection