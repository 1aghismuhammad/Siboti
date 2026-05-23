<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Progress — SibotiHUB</title>
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

@include('hub.partials.sidebar', ['active' => 'progress'])

<main class="hub-main">
    <div class="hub-main__header">
        <div>
            <p class="hub-main__greeting">Pantau dua minggu terakhir, terus tingkatkan latihan kamu.</p>
            <h1 class="hub-main__title">Progress Kamu.</h1>
        </div>
        <div style="font-size:0.7rem;color:rgba(255,255,255,0.4);font-weight:600;">MINGGU INI · 1–7 Jun 2026</div>
    </div>

    {{-- Stats --}}
    <div class="progress-stats">
        @foreach([
            ['Sesi Minggu Ini','18','↑ +2'],
            ['Total Kalori','12.4k','↑ +8%'],
            ['Durasi Rata-rata','58m','↓ -3%'],
            ['Konsistensi','92%','↑ +5%'],
        ] as $s)
        <div class="progress-stat">
            <p class="progress-stat__label">{{ $s[0] }}</p>
            <p class="progress-stat__value">{{ $s[1] }}</p>
            <p class="progress-stat__change">{{ $s[2] }}</p>
        </div>
        @endforeach
    </div>

    <div class="progress-grid">
        {{-- Grafik --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="hub-card">
                <div class="hub-card__header">
                    <p class="hub-card__title">Volume Mingguan</p>
                    <a href="#" class="hub-card__link">Bulan ini →</a>
                </div>
                <div class="chart-bars">
                    @foreach([
                        ['Sen', 60, false],
                        ['Sel', 40, false],
                        ['Rab', 80, false],
                        ['Kam', 55, false],
                        ['Jum', 90, true],
                        ['Sab', 70, false],
                        ['Min', 30, false],
                    ] as $bar)
                    <div class="chart-bar-wrap">
                        <div class="chart-bar {{ $bar[2] ? 'chart-bar--active' : '' }}"
                             style="height:{{ $bar[1] }}%"></div>
                        <span class="chart-bar-label">{{ $bar[0] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Angkatan --}}
            <div class="hub-card">
                <div class="hub-card__header">
                    <p class="hub-card__title">Angkatan Utama</p>
                    <a href="#" class="hub-card__link">Lihat semua →</a>
                </div>
                <div class="angkatan-grid">
                    @foreach([
                        ['Bench Press','80','kg','↑ +5kg'],
                        ['Squat','100','kg','↑ +10kg'],
                        ['Deadlift','120','kg','↑ +7.5kg'],
                        ['OHP','50','kg','↑ +2.5kg'],
                    ] as $a)
                    <div class="angkatan-item">
                        <p class="angkatan-item__name">{{ $a[0] }}</p>
                        <p class="angkatan-item__value">{{ $a[1] }}<span class="angkatan-item__unit"> {{ $a[2] }}</span></p>
                        <p class="angkatan-item__change">{{ $a[3] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Target --}}
        <div class="hub-card">
            <div class="hub-card__header">
                <p class="hub-card__title">Target Bulanan</p>
            </div>
            <div class="target-list">
                @foreach([
                    ['Berat Badan (kg)','72.5 / 70 kg', 85],
                    ['Volume Angkat (ton)','12.4 / 15 ton', 65],
                    ['Sesi Cardio','8 / 12 sesi', 55],
                    ['Konsistensi Hadir','92% / 90%', 100],
                ] as $t)
                <div>
                    <div class="target-item__header">
                        <p class="target-item__name">{{ $t[0] }}</p>
                        <p class="target-item__value">{{ $t[2] }}%</p>
                    </div>
                    <div class="target-bar">
                        <div class="target-bar__fill" style="width:{{ $t[2] }}%"></div>
                    </div>
                    <p style="font-size:0.65rem;color:rgba(255,255,255,0.3);margin-top:0.3rem;">{{ $t[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</main>

</body>
</html>