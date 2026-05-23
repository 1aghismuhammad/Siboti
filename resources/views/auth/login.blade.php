<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Siboti Gym</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-page">

<div class="auth-card">
    {{-- Kiri --}}
    <div class="auth-card__left">
        <div>
            <p class="auth-card__left-title">
                WELCOME BACK
                <span>HEROOO!!!</span>
            </p>
        </div>
        <div class="auth-card__logo" style="margin-top:auto;">
            <svg width="48" height="48" viewBox="0 0 100 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="18" r="10" stroke="white" stroke-width="4" fill="none"/>
                <line x1="50" y1="28" x2="50" y2="65" stroke="white" stroke-width="4"/>
                <line x1="50" y1="45" x2="28" y2="35" stroke="white" stroke-width="4"/>
                <line x1="50" y1="45" x2="72" y2="35" stroke="white" stroke-width="4"/>
                <line x1="50" y1="65" x2="35" y2="90" stroke="white" stroke-width="4"/>
                <line x1="50" y1="65" x2="65" y2="90" stroke="white" stroke-width="4"/>
                <line x1="28" y1="35" x2="18" y2="22" stroke="white" stroke-width="3"/>
                <line x1="72" y1="35" x2="82" y2="22" stroke="white" stroke-width="3"/>
            </svg>
            <span class="auth-card__logo-text">SIBOT<span>!</span></span>
        </div>
    </div>

    {{-- Kanan --}}
    <div class="auth-card__right">
        <p class="auth-card__form-title">Masuk ke akun kamu</p>

        <form class="auth-form" action="#" method="POST">
            @csrf
            <div class="auth-form__group">
                <label class="auth-form__label">Username</label>
                <input type="text" class="auth-form__input" placeholder="Masukkan username kamu">
            </div>
            <div class="auth-form__group">
                <label class="auth-form__label">Password</label>
                <input type="password" class="auth-form__input" placeholder="••••••••">
            </div>
            <div class="auth-form__row">
                <label class="auth-form__check">
                    <input type="checkbox"> Ingat saya
                </label>
                <a href="#" class="auth-form__forgot">Lupa password?</a>
            </div>
            <button type="submit" class="auth-btn-primary">SIGN IN</button>
        </form>

        <div class="auth-divider">OR CONTINUE</div>

        <button class="auth-btn-google">
            <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            LOG IN WITH GOOGLE
        </button>

        <p class="auth-footer-text">
            Belum punya akun? <a href="{{ url('/register') }}">Daftar sekarang</a>
        </p>
    </div>
</div>

</body>
</html>