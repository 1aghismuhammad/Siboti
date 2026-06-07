<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Siboti</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0d0d0d;
            color: #e0e0e0;
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .r-sidebar {
            width: 230px;
            background: #0a0a0a;
            border-right: 1px solid #1e1e1e;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
        }

        .r-sidebar__brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid #1a1a1a;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .r-sidebar__logo-icon {
            background: #c6f135;
            color: #111;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 17px;
        }

        .r-sidebar__logo-name {
            font-size: 16px;
            font-weight: 700;
            color: #c6f135;
            letter-spacing: 0.5px;
        }

        .r-sidebar__logo-sub {
            font-size: 9px;
            color: #555;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .r-sidebar__nav {
            padding: 16px 12px;
            flex: 1;
        }

        .r-sidebar__item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            color: #777;
            font-size: 13.5px;
            text-decoration: none;
            margin-bottom: 3px;
            transition: background 0.15s, color 0.15s;
        }

        .r-sidebar__item:hover {
            background: #1a1a1a;
            color: #bbb;
        }

        .r-sidebar__item--active {
            background: #1a2a06;
            color: #c6f135;
        }

        .r-sidebar__item .material-symbols-outlined {
            font-size: 19px;
        }

        .r-sidebar__footer {
            padding: 12px;
            border-top: 1px solid #1a1a1a;
        }

        .r-sidebar__footer .r-sidebar__item {
            color: #444;
        }

        .r-sidebar__footer .r-sidebar__item:hover {
            color: #777;
        }

        /* ── MAIN AREA ── */
        .r-main {
            margin-left: 230px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        .r-topbar {
            background: #0d0d0d;
            border-bottom: 1px solid #1e1e1e;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .r-topbar__sub {
            font-size: 10px;
            color: #444;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .r-topbar__title {
            font-size: 22px;
            font-weight: 700;
            color: #e8e8e8;
        }

        .r-topbar__right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .r-search {
            background: #141414;
            border: 1px solid #222;
            border-radius: 8px;
            padding: 8px 16px;
            color: #555;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 200px;
        }

        .r-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #c6f135;
            color: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
        }

        /* ── PAGE CONTENT ── */
        .r-content {
            padding: 28px;
            flex: 1;
        }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="r-sidebar">
    <div class="r-sidebar__brand">
        <div class="r-sidebar__logo-icon">S</div>
        <div>
            <div class="r-sidebar__logo-name">Siboti</div>
            <div class="r-sidebar__logo-sub">Receptionist Desk</div>
        </div>
    </div>

    <nav class="r-sidebar__nav">
        <a href="{{ route('receptionist.dashboard') }}"
           class="r-sidebar__item {{ request()->routeIs('receptionist.dashboard') ? 'r-sidebar__item--active' : '' }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('scan-qr.index') }}"
           class="r-sidebar__item {{ request()->routeIs('scan-qr.*') ? 'r-sidebar__item--active' : '' }}">
            <span class="material-symbols-outlined">qr_code_scanner</span>
            <span>Scan QR</span>
        </a>
        <a href="{{ route('pos.dashboard') }}"
           class="r-sidebar__item {{ request()->routeIs('pos.dashboard') ? 'r-sidebar__item--active' : '' }}">
            <span class="material-symbols-outlined">point_of_sale</span>
            <span>Transaksi POS</span>
        </a>
        <a href="{{ route('pos.history') }}"
           class="r-sidebar__item {{ request()->routeIs('pos.history') ? 'r-sidebar__item--active' : '' }}">
            <span class="material-symbols-outlined">receipt_long</span>
            <span>Riwayat Transaksi</span>
        </a>
    </nav>

    <div class="r-sidebar__footer">
        <a href="{{ route('receptionist.settings') }}" class="r-sidebar__item">
            <span class="material-symbols-outlined">settings</span>
            <span>Pengaturan</span>
        </a>
        <a href="{{ route('logout') }}" class="r-sidebar__item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
            <span class="material-symbols-outlined">logout</span>
            <span>Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
            @csrf
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="r-main">
    <header class="r-topbar">
        <div>
            <div class="r-topbar__sub">Panel Operasional Front Desk</div>
            <div class="r-topbar__title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="r-topbar__right">
            <div class="r-search">
                <span class="material-symbols-outlined" style="font-size:16px;">search</span>
                Cari member atau ID...
            </div>
            <span class="material-symbols-outlined" style="color:#555; font-size:22px;">notifications</span>
            <div class="r-avatar">RC</div>
        </div>
    </header>

    <main class="r-content">
        @yield('content')
    </main>
</div>

</body>
</html>