<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Trainer — Siboti</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trainer.css') }}">
</head>
<body class="trainer-auth-page">

<div class="trainer-auth-card">
    {{-- Kiri --}}
    <div class="trainer-auth-card__left"
     style="display:flex;align-items:center;justify-content:flex-start;">

    <div class="trainer-auth-logo"
         style="
            display:flex;
            flex-direction:column;
            align-items:center;
            text-align:center;
            margin-top:80px;
         ">

        <img src="{{ asset('image/Icon/logo_putih.webp') }}"
             alt="Siboti Logo"
             style="height:140px;width:auto;margin-bottom:1rem;">

        <p class="trainer-auth-logo__text" style="font-size:2.6rem;">
            SIBOTI
        </p>

        <p class="trainer-auth-logo__sub">
            Trainer Panel
        </p>

    </div>
</div>

    {{-- Kanan --}}
    <div class="trainer-auth-card__right">
        <p class="trainer-auth-form-title">Buat Akun Trainer</p>

        <form class="trainer-auth-form" action="#" method="POST">
            @csrf
            <div class="trainer-auth-form__group">
                <label class="trainer-auth-form__label">Nama</label>
                <input type="text" class="trainer-auth-form__input" placeholder="Nama lengkap kamu">
            </div>
            <div class="trainer-auth-form__group">
                <label class="trainer-auth-form__label">Email</label>
                <input type="email" class="trainer-auth-form__input" placeholder="trainer@siboti.id">
            </div>
            <div class="trainer-auth-form__group">
                <label class="trainer-auth-form__label">Nomor HP</label>
                <input type="tel" class="trainer-auth-form__input" placeholder="08xxxxxxxxxx">
            </div>
            <div class="trainer-auth-form__group">
                <label class="trainer-auth-form__label">Password</label>
                <input type="password" class="trainer-auth-form__input" placeholder="••••••••">
            </div>
            <div class="trainer-auth-form__group">
                <label class="trainer-auth-form__label">Confirm Password</label>
                <input type="password" class="trainer-auth-form__input" placeholder="••••••••">
            </div>
            <label class="trainer-auth-check" style="font-size:0.7rem;color:rgba(255,255,255,0.3);">
                <input type="checkbox">
                Saya menyetujui syarat & ketentuan serta kebijakan privasi Getzo Gym.
            </label>
            <button type="submit" class="trainer-auth-btn">CREATE ACCOUNT</button>
        </form>

        <div class="trainer-auth-divider">OR CONTINUE</div>

        <button class="trainer-auth-google">
            <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            LOG IN WITH GOOGLE
        </button>

        <p class="trainer-auth-footer">
            Sudah punya akun? <a href="{{ url('/trainer/login') }}">Masuk di sini</a>
        </p>
    </div>
</div>

</body>
</html>