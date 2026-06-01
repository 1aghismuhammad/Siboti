<!-- ===================== SIBOTI NAVBAR ===================== -->
<style>
/* RESET MINIMAL */
* {
    box-sizing: border-box;
}

.navbar-top {
    position: fixed;
    top: 0;
    width: 100%;
    background: linear-gradient(to bottom, #000000, #0b0b0b);
    z-index: 1000;
}

.navbar-top__inner {
    max-width: 1280px;
    margin: auto;
    padding: 0.75rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* LOGO */
.navbar-top__logo {
    display: flex;
    align-items: flex-end;
    gap: 0.2rem;
    font-weight: 800;
    color: #ffffff;
    text-decoration: none;
}

.navbar-top__logo img {
    height: 40px;
}

/* MENU */
.navbar-top__menu {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.navbar-top__menu a {
    color: #e5e5e5;
    font-size: 0.875rem;
    text-decoration: none;
    transition: color 0.2s ease;
}

.navbar-top__menu a:hover {
    color: #ccff00;
}

/* ACTION RIGHT */
.navbar-top__actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* USER ICON */
.navbar-top__user {
    display: flex;
    align-items: center;
    justify-content: center;
}

.navbar-top__user img {
    width: 36px;
    height: 36px;
    border-radius: 9999px;
    object-fit: cover;
    border: 1px solid #222;
}

/* CTA */
.navbar-top__cta {
    background: #ccff00;
    color: #000;
    font-weight: 700;
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.navbar-top__cta:hover {
    background: #b6e600;
}

/* SPACER AGAR KONTEN TIDAK KETUTUP NAVBAR */
.navbar-spacer {
    height: 64px;
}
</style>

<nav class="navbar-top">
    <div class="navbar-top__inner">

        <a href="/" class="navbar-top__logo">
          <span>SIBOTI</span>
          <img src="image/Icon/logo_putih.webp" alt="Siboti Logo">
        </a>

        <!-- MENU -->
        <ul class="navbar-top__menu">
            <li><a href="#">Beranda</a></li>
            <li><a href="#fasilitas">Fasilitas</a></li>
            <li><a href="#trainer">Trainer</a></li>
            <li><a href="#paket">Paket</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>

        
        <div class="navbar-top__actions">
            <a href="/login" class="navbar-top__user">
                <img src="Image/Icon/user.webp" alt="User">
            </a>

            @guest
                <a href="{{ route('login') }}" class="btn-primary navbar-top__cta">BOOKING SEKARANG →</a>
            @else
                <a href="{{ url('/hub/booking') }}" class="btn-primary navbar-top__cta">BOOKING SEKARANG →</a>
            @endguest
        </div>

    </div>
</nav>

<div class="navbar-spacer"></div>