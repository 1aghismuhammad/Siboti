<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — Siboti Gym</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .auth-card__left {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2.5rem;
            min-height: 420px;
        }

        .auth-left__top { width: 100%; }

        .auth-left__welcome {
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            font-weight: 900;
            color: #ffffff;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .auth-left__welcome span {
            color: #CCFF00;
            display: block;
        }

        .auth-left__bottom {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            flex: 1;
            padding: 1rem 0;
            width: 100%;
        }

        .auth-left__logo-img {
            height: 200px;
            width: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .auth-left__logo-text {
            font-size: 2.25rem;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -0.01em;
            line-height: 1;
            text-align: center;
            width: 100%;
        }

        .auth-left__logo-text span { color: #CCFF00; }

        @media (max-width: 639px) {
            .auth-card__left { min-height: auto; padding: 1.5rem; }
            .auth-left__logo-img { height: 100px; }
            .auth-left__bottom { padding: 1rem 0 0.5rem; }
        }
    </style>
</head>
<body class="auth-page">

<div class="auth-card">
    {{-- Kiri --}}
    <div class="auth-card__left">
        <div class="auth-left__top">
            <p class="auth-left__welcome">
                HALOOO
                <span>HEROOO!!!</span>
            </p>
        </div>
        <div class="auth-left__bottom">
            <img src="{{ asset('image/Icon/logo_putih.webp') }}"
                 alt="Siboti Logo"
                 class="auth-left__logo-img">
            <p class="auth-left__logo-text">SIBOTI<span>!</span></p>
        </div>
    </div>

    {{-- Kanan --}}
    <div class="auth-card__right">
        <p class="auth-card__form-title">Buat akun baru</p>

        <form class="auth-form" action="#" method="POST">
            @csrf
            <div class="auth-form__group">
                <label class="auth-form__label">Nama Lengkap</label>
                <input type="text" class="auth-form__input" placeholder="Nama kamu">
            </div>
            <div class="auth-form__group">
                <label class="auth-form__label">Email</label>
                <input type="email" class="auth-form__input" placeholder="email@example.com">
            </div>
            <div class="auth-form__group">
                <label class="auth-form__label">Nomor HP</label>
                <input type="tel" class="auth-form__input" placeholder="08xxxxxxxxxx">
            </div>
            <div class="auth-form__group">
                <label class="auth-form__label">Password</label>
                <input type="password" class="auth-form__input" placeholder="••••••••">
            </div>
            <div class="auth-form__group">
                <label class="auth-form__label">Konfirmasi Password</label>
                <input type="password" class="auth-form__input" placeholder="••••••••">
            </div>
            <label class="auth-form__check" style="font-size:0.7rem;">
                <input type="checkbox">
                Saya menyetujui syarat & ketentuan serta kebijakan privasi Siboti Gym.
            </label>
            <button type="submit" class="auth-btn-primary">CREATE ACCOUNT</button>
        </form>

        <div class="auth-divider">OR CONTINUE</div>

        <button class="auth-btn-google">
            <svg width="16" height="16" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            LOG IN WITH GOOGLE
        </button>

        <p class="auth-footer-text">
            Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a>
        </p>
    </div>
</div>

</body>
</html>