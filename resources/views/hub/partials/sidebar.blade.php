<style>
.hub-sidebar {
    position: fixed;
    top: 0; left: 0; bottom: 0;
    width: 260px;
    background: linear-gradient(180deg, #000000, #0b0b0b);
    padding: 1.5rem 1.25rem;
    display: flex;
    flex-direction: column;
    color: #ffffff;
    z-index: 40;
    overflow-y: auto;
}

.hub-sidebar__logo {
    display: flex;
    align-items: flex-end;
    gap: 0.4rem;
}

.hub-sidebar__logo img {
    height: 26px;
    width: auto;
    display: block;
}

.hub-sidebar__logo-text {
    font-size: 1.3rem;
    font-weight: 800;
    line-height: 1;
    letter-spacing: 0.04em;
}
.hub-sidebar__logo-text span { color: #CCFF00; }

.hub-sidebar__subtitle {
    margin-top: 0.35rem;
    font-size: 0.7rem;
    letter-spacing: 0.18em;
    color: #9ca3af;
    text-transform: uppercase;
}

.hub-sidebar__nav {
    margin-top: 2rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.hub-nav-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.6rem 0.75rem;
    border-radius: 0.75rem;
    color: rgba(255,255,255,0.4);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.hub-nav-item img {
    width: 18px;
    height: 18px;
    object-fit: contain;
    filter: brightness(0) invert(0.5);
    transition: filter 0.2s;
    flex-shrink: 0;
}

.hub-nav-item:hover {
    background: #111111;
    color: #ffffff;
}

.hub-nav-item:hover img {
    filter: brightness(0) invert(1);
}

.hub-nav-item--active {
    background: #CCFF00;
    color: #000000;
    font-weight: 700;
}

.hub-nav-item--active img {
    filter: brightness(0) saturate(100%) invert(0%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(0%);
}

.hub-sidebar__profile {
    margin-top: auto;
    background: #0f0f0f;
    border-radius: 0.75rem;
    padding: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.hub-sidebar__avatar {
    width: 36px;
    height: 36px;
    border-radius: 9999px;
    background: #CCFF00;
    color: #000000;
    font-weight: 700;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.hub-sidebar__profile-name {
    font-size: 0.8rem;
    font-weight: 600;
}

.hub-sidebar__profile-paket {
    font-size: 0.65rem;
    color: #9ca3af;
}
</style>

<aside class="hub-sidebar">
    {{-- Logo --}}
    <div class="hub-sidebar__logo">
        <img src="{{ asset('image/Icon/logo_putih.webp') }}" alt="Siboti Logo">
        <span class="hub-sidebar__logo-text">SIBOTI</span>
    </div>
    <p class="hub-sidebar__subtitle">Member System</p>

    {{-- Nav --}}
    <nav class="hub-sidebar__nav">
        <a href="{{ url('/hub/dashboard') }}"
           class="hub-nav-item {{ $active === 'dashboard' ? 'hub-nav-item--active' : '' }}">
            <img src="{{ asset('image/Icon/dashboard.webp') }}" alt="Dashboard">
            Dashboard
        </a>

        <a href="{{ url('/hub/qr') }}"
           class="hub-nav-item {{ $active === 'qr' ? 'hub-nav-item--active' : '' }}">
            <img src="{{ asset('image/Icon/qr.webp') }}" alt="QR Check-In">
            QR Check-In
        </a>

        <a href="{{ url('/hub/progress') }}"
           class="hub-nav-item {{ $active === 'progress' ? 'hub-nav-item--active' : '' }}">
            <img src="{{ asset('image/Icon/progress.webp') }}" alt="Progress">
            Progress
        </a>

        <a href="{{ url('/') }}"
           class="hub-nav-item {{ $active === 'profile' ? 'hub-nav-item--active' : '' }}">
            <img src="{{ asset('image/Icon/back.webp') }}" alt="Profil">
            Profil
        </a>
    </nav>

    {{-- Profile --}}
    <div class="hub-sidebar__profile">
        <div class="hub-sidebar__avatar">BS</div>
        <div>
            <p class="hub-sidebar__profile-name">Budi Santoso</p>
            <p class="hub-sidebar__profile-paket">Paket Pro</p>
        </div>
    </div>
</aside>