<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — SibotiHUB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hub.css') }}">

    <style>
        .hub-main {
            margin-left: 260px;        
            min-height: 100vh;
            padding: 1.5rem 2rem;
            background: #0a0a0a;
        }
    </style>
</head>
<body class="hub-page">

@include('hub.partials.sidebar', ['active' => 'dashboard'])

<main class="hub-main">
    
    <div class="hub-main__header">
        <div>
            <p class="hub-main__greeting">Selamat datang kembali</p>
            @auth
                <h1 class="hub-main__title">Halo, {{ auth()->user()->name }}. 👋</h1>
            @else
                <h1 class="hub-main__title">Halo, Pengunjung. 👋</h1>
            @endauth
        </div>
        <div style="display:flex;gap:0.75rem;align-items:center;">
            <a href="{{ url('/hub/qr') }}" class="hub-btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3m0 4h4v-4m-7 0h3"/></svg>
            CHECK IN SEKARANG
        </a>
            @auth
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="hub-btn" style="background:transparent;border:1px solid rgba(255,255,255,0.06);">LOGOUT</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hub-btn" style="background:transparent;border:1px solid rgba(255,255,255,0.06);">LOGIN</a>
            @endauth
        </div>
    </div>

    {{-- Stats --}}
    <div class="hub-stats">
        <div class="hub-stat-card">
            <p class="hub-stat-card__label">Sisa Sesi</p>
            <p class="hub-stat-card__value">14 <span class="hub-stat-card__unit">hari</span></p>
            <p class="hub-stat-card__change">Aktif hingga 30 Jun</p>
        </div>
        <div class="hub-stat-card">
            <p class="hub-stat-card__label">Total Sesi</p>
            <p class="hub-stat-card__value">42 <span class="hub-stat-card__unit">sesi</span></p>
            <p class="hub-stat-card__change">+3 minggu ini</p>
        </div>
        <div class="hub-stat-card">
            <p class="hub-stat-card__label">Hari Aktif Ini</p>
            <p class="hub-stat-card__value">18 <span class="hub-stat-card__unit">hr</span></p>
            <p class="hub-stat-card__change">+2 dari bulan lalu</p>
        </div>
        <div class="hub-stat-card">
            <p class="hub-stat-card__label">Kalori</p>
            <p class="hub-stat-card__value">12.4 <span class="hub-stat-card__unit">kcal</span></p>
            <p class="hub-stat-card__change">Bulan ini</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="hub-content-grid">
        <div style="display:flex;flex-direction:column;gap:1.5rem;">

            {{-- Jadwal --}}
            <div class="hub-card">
                <div class="hub-card__header">
                    <p class="hub-card__title">Jadwal Mendatang</p>
                    <a href="#" class="hub-card__link">Lihat semua →</a>
                </div>
                @foreach([
                    ['Sen','26','Strength & Conditioning','07.00 – 09.00 · Coach Dimas'],
                    ['Rab','28','HIIT Cardio Session','16.00 – 17.00 · Coach Yanu'],
                    ['Jum','30','Personal Training','09.00 – 11.00 · Coach Raya'],
                ] as $jadwal)
                <div class="jadwal-item">
                    <div class="jadwal-item__date">
                        <span class="jadwal-item__day">{{ $jadwal[0] }}</span>
                        <span class="jadwal-item__num">{{ $jadwal[1] }}</span>
                    </div>
                    <div class="jadwal-item__info">
                        <p class="jadwal-item__name">{{ $jadwal[2] }}</p>
                        <p class="jadwal-item__time">{{ $jadwal[3] }}</p>
                    </div>
                    <span class="jadwal-item__arrow">›</span>
                </div>
                @endforeach
            </div>

            {{-- Aktivitas --}}
            <div class="hub-card">
                <div class="hub-card__header">
                    <p class="hub-card__title">Aktivitas Terbaru</p>
                    <a href="{{ url('/hub/progress') }}" class="hub-card__link">Lihat progress →</a>
                </div>
                <div class="aktivitas-grid">
                    @foreach([
                        ['Kemarin','Bench Press','80 kg × 10'],
                        ['2 Hari Lalu','Treadmill','5.2 km · 28 min'],
                        ['3 Hari Lalu','Squat','100 kg × 8'],
                    ] as $akt)
                    <div class="aktivitas-item">
                        <p class="aktivitas-item__when">{{ $akt[0] }}</p>
                        <p class="aktivitas-item__name">{{ $akt[1] }}</p>
                        <p class="aktivitas-item__detail">{{ $akt[2] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Bagian ini sudah diperbaiki dari error typo sebelumnya --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="paket-aktif">
                <p class="paket-aktif__label">Membership Aktif</p>
                <p class="paket-aktif__name">Paket Pro</p>
                <p class="paket-aktif__desc">Akses penuh 1 – 4 sesi personal training per bulan.</p>
                <div class="paket-aktif__info">
                    <div class="paket-aktif__info-row">
                        <span>Berlaku hingga</span>
                        <span>30 Jun 2026</span>
                    </div>
                    <div class="paket-aktif__info-row">
                        <span>Sesi terpakai</span>
                        <span>3 / 4</span>
                    </div>
                    <div class="paket-aktif__info-row">
                        <span>ID Member</span>
                        <span>GZ-08421</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>