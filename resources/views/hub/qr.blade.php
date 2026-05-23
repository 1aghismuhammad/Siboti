<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Check-in — SibotiHUB</title>
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

@include('hub.partials.sidebar', ['active' => 'qr'])

<main class="hub-main">
    <div class="hub-main__header">
        <div>
            <p class="hub-main__greeting">Tunjukkan QR code ini ke staff</p>
            <h1 class="hub-main__title">QR Check-in</h1>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr;gap:1.5rem;max-width:720px;">

        {{-- QR Card --}}
        <div class="hub-card" style="display:flex;flex-direction:column;align-items:center;padding:2rem;">
            <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.3);margin-bottom:1.5rem;">AKTIF MEMBER PASS</p>

            <div class="qr-card">
                <p class="qr-card__label">SCAN QR CODE</p>
                <div class="qr-code">
                    {{-- QR Code SVG dummy --}}
                    <svg viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:140px;height:140px;">
                        <rect width="21" height="21" fill="white"/>
                        <rect x="1" y="1" width="7" height="7" fill="black"/>
                        <rect x="2" y="2" width="5" height="5" fill="white"/>
                        <rect x="3" y="3" width="3" height="3" fill="black"/>
                        <rect x="13" y="1" width="7" height="7" fill="black"/>
                        <rect x="14" y="2" width="5" height="5" fill="white"/>
                        <rect x="15" y="3" width="3" height="3" fill="black"/>
                        <rect x="1" y="13" width="7" height="7" fill="black"/>
                        <rect x="2" y="14" width="5" height="5" fill="white"/>
                        <rect x="3" y="15" width="3" height="3" fill="black"/>
                        <rect x="9" y="1" width="1" height="1" fill="black"/>
                        <rect x="11" y="1" width="1" height="1" fill="black"/>
                        <rect x="9" y="3" width="3" height="1" fill="black"/>
                        <rect x="9" y="5" width="1" height="3" fill="black"/>
                        <rect x="11" y="5" width="1" height="1" fill="black"/>
                        <rect x="13" y="9" width="1" height="3" fill="black"/>
                        <rect x="15" y="9" width="3" height="1" fill="black"/>
                        <rect x="15" y="11" width="1" height="3" fill="black"/>
                        <rect x="17" y="11" width="3" height="1" fill="black"/>
                        <rect x="9" y="9" width="3" height="3" fill="black"/>
                        <rect x="1" y="9" width="1" height="3" fill="black"/>
                        <rect x="3" y="9" width="3" height="1" fill="black"/>
                        <rect x="5" y="11" width="1" height="3" fill="black"/>
                        <rect x="9" y="13" width="1" height="5" fill="black"/>
                        <rect x="11" y="13" width="3" height="1" fill="black"/>
                        <rect x="13" y="15" width="1" height="3" fill="black"/>
                        <rect x="15" y="15" width="3" height="1" fill="black"/>
                        <rect x="17" y="17" width="3" height="3" fill="black"/>
                        <rect x="11" y="17" width="1" height="3" fill="black"/>
                    </svg>
                </div>
                <p class="qr-card__name">BUDI SANTOSO</p>
                <p class="qr-card__meta">ID: GZ-08421 · PAKET PRO</p>
                <p class="qr-card__status">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="5" fill="#16a34a"/></svg>
                    QR Aktif & Valid
                </p>
            </div>

            <button class="qr-refresh-btn" style="margin-top:1.5rem;" onclick="this.textContent='Memperbarui..';setTimeout(()=>this.textContent='↺ Refresh QR',1500)">↺ Refresh QR</button>
        </div>

        {{-- Riwayat --}}
        <div class="hub-card">
            <div class="hub-card__header">
                <p class="hub-card__title">Riwayat Check-in</p>
            </div>
            <div class="riwayat-list">
                @foreach([
                    ['Aman & Pribadi','QR code valid pagi ini. Tidak bisa dipakai ulang dan kedaluwarsa otomatis.',[]],
                    ['Riwayat Check-in','3 check-in terakhir',[
                        ['Hari Ini','Pagi (Sabtu)','06.45'],
                        ['Kemarin','Pagi (Jumat)','07.21'],
                        ['3 Hari Lalu','Siang (Rabu)','09.05'],
                    ]],
                ] as $item)
                <div class="riwayat-item">
                    <div class="riwayat-item__header">
                        <div class="riwayat-item__dot"></div>
                        <p class="riwayat-item__title">{{ $item[0] }}</p>
                    </div>
                    <p style="font-size:0.7rem;color:rgba(255,255,255,0.4);">{{ $item[1] }}</p>
                    @if(count($item[2]) > 0)
                    <div class="riwayat-item__rows" style="margin-top:0.75rem;">
                        @foreach($item[2] as $row)
                        <div class="riwayat-row">
                            <span>{{ $row[0] }} · {{ $row[1] }}</span>
                            <span>{{ $row[2] }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>
</main>

</body>
</html>