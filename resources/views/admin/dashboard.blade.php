@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('content')
<style>
    /* ══════════════════════════════════════════
       PREMIUM ADMIN DASHBOARD STYLES (DARK MODE)
       ══════════════════════════════════════════ */
    :root {
        --admin-bg-main: #050505;
        --admin-bg-card: #111111;
        --admin-bg-hover: rgba(255, 255, 255, 0.03);
        --admin-border: rgba(255, 255, 255, 0.08);
        --admin-text: #ffffff;
        --admin-text-muted: #888888;
        --admin-accent: #ccff00;
        --admin-accent-hover: #b6e600;
        --admin-danger: #ff4757;
        --admin-warning: #ffa502;
        --admin-success: #2ed573;
        --admin-sidebar-width: 260px;
        --admin-radius-card: 16px;
        --admin-radius-pill: 99px;
    }
    /* ── RESET & BASE ── */
    .admin-shell {
        display: flex;
        min-height: 100vh;
        background: var(--admin-bg-main);
        color: var(--admin-text);
        font-family: 'Inter', sans-serif;
    }
    .admin-shell * {
        box-sizing: border-box;
    }
    /* ── OVERLAY (MOBILE) ── */
    .admin-sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 998;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .admin-sidebar-overlay.is-active {
        display: block;
        opacity: 1;
    }
    /* ── SIDEBAR ── */
    .admin-sidebar {
        width: var(--admin-sidebar-width);
        background: var(--admin-bg-card);
        border-right: 1px solid var(--admin-border);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; bottom: 0; left: 0;
        z-index: 1000;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .admin-brand {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px solid var(--admin-border);
    }
    .admin-brand__mark {
        width: 40px; height: 40px;
        background: var(--admin-accent);
        color: #000;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px;
        text-decoration: none;
        transition: transform 0.2s ease;
    }
    .admin-brand__mark:hover {
        transform: scale(1.05);
    }
    .admin-brand__name { margin: 0; font-weight: 900; font-size: 1.15rem; letter-spacing: 0.02em; }
    .admin-brand__label { margin: 0; font-size: 0.7rem; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; }
    .admin-menu {
        flex: 1;
        padding: 1.5rem 1rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }
    .admin-menu__item {
        display: flex; align-items: center; gap: 0.85rem;
        padding: 0.85rem 1rem;
        color: var(--admin-text-muted);
        text-decoration: none;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .admin-menu__item:hover { background: var(--admin-bg-hover); color: var(--admin-text); }
    .admin-menu__item--active {
        background: rgba(204, 255, 0, 0.08);
        color: var(--admin-accent);
        border: 1px solid rgba(204, 255, 0, 0.15);
    }
    .admin-menu__item--active:hover {
        background: rgba(204, 255, 0, 0.12);
        color: var(--admin-accent);
    }
    .admin-menu__item--danger:hover {
        background: rgba(255, 71, 87, 0.08);
        color: var(--admin-danger);
    }
    .admin-sidebar__footer {
        padding: 1rem;
        border-top: 1px solid var(--admin-border);
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }
    /* ── MAIN CONTENT AREA ── */
    .admin-main {
        flex: 1;
        margin-left: var(--admin-sidebar-width);
        display: flex;
        flex-direction: column;
        min-width: 0;
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    /* ── TOPBAR ── */
    .admin-topbar {
        padding: 1.25rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--admin-border);
        background: rgba(5, 5, 5, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        position: sticky;
        top: 0;
        z-index: 900;
        gap: 1.5rem;
    }
    .admin-topbar-left {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }
    .admin-sidebar-toggle {
        display: none; /* Hidden on desktop */
        background: transparent;
        border: 1px solid var(--admin-border);
        color: var(--admin-text);
        width: 40px; height: 40px;
        border-radius: 10px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }
    .admin-sidebar-toggle:hover { background: var(--admin-bg-hover); }
    .admin-eyebrow { margin: 0 0 0.2rem; font-size: 0.65rem; color: var(--admin-accent); text-transform: uppercase; letter-spacing: 0.08em; font-weight: 700; }
    .admin-topbar h1 { margin: 0; font-size: 1.35rem; font-weight: 900; letter-spacing: -0.02em; }
    .admin-topbar__actions { display: flex; align-items: center; gap: 1.25rem; }
    /* Search Input */
    .admin-search {
        display: flex; align-items: center; gap: 0.6rem;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--admin-border);
        padding: 0.6rem 1.25rem;
        border-radius: var(--admin-radius-pill);
        transition: all 0.25s ease;
    }
    .admin-search:focus-within {
        border-color: rgba(204, 255, 0, 0.4);
        background: rgba(204, 255, 0, 0.02);
        box-shadow: 0 0 0 3px rgba(204, 255, 0, 0.1);
    }
    .admin-search span { color: var(--admin-text-muted); font-size: 1.2rem; }
    .admin-search input {
        border: none; background: transparent; color: var(--admin-text);
        font-family: inherit; outline: none; width: 260px; font-size: 0.85rem;
    }
    .admin-search input::placeholder { color: #666; }
    /* Action Buttons (Notif, Profile) */
    .admin-icon-button {
        background: transparent; border: 1px solid var(--admin-border);
        color: var(--admin-text); width: 42px; height: 42px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; position: relative; transition: all 0.2s ease;
    }
    .admin-icon-button:hover { background: var(--admin-bg-hover); border-color: rgba(255, 255, 255, 0.2); }
    .admin-icon-button__dot {
        position: absolute; top: 10px; right: 10px; width: 8px; height: 8px;
        background: var(--admin-accent); border-radius: 50%;
        box-shadow: 0 0 0 2px var(--admin-bg-main);
    }
    .admin-profile {
        width: 42px; height: 42px; border-radius: 50%;
        background: linear-gradient(135deg, #222, #111);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.85rem; cursor: pointer;
        border: 1px solid var(--admin-border);
        color: var(--admin-accent);
        transition: border-color 0.2s;
    }
    .admin-profile:hover { border-color: var(--admin-accent); }
    /* ── CONTENT CONTAINER ── */
    .admin-content {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        max-width: 1600px;
    }
    /* ── GRIDS ── */
    .admin-grid { display: grid; gap: 1.5rem; }
    .admin-grid--two { grid-template-columns: repeat(2, 1fr); }
    /* ── CARDS ── */
    .admin-card {
        background: var(--admin-bg-card);
        border: 1px solid var(--admin-border);
        border-radius: var(--admin-radius-card);
        padding: 1.5rem;
    }
    .admin-section-head { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap; }
    .admin-section-head--bordered { padding-bottom: 1.25rem; border-bottom: 1px solid var(--admin-border); }
    .admin-section-head h2 { margin: 0 0 0.35rem 0; font-size: 1.1rem; font-weight: 800; letter-spacing: -0.01em; }
    .admin-section-head p { margin: 0; font-size: 0.8rem; color: var(--admin-text-muted); }
    /* Buttons inside cards */
    .admin-small-button {
        background: rgba(255,255,255,0.04); border: 1px solid var(--admin-border);
        color: #fff; padding: 0.4rem 0.875rem; border-radius: 8px;
        font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.2s;
        font-family: inherit;
    }
    .admin-small-button:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); }
    .admin-primary-button {
        background: var(--admin-accent); color: #000; border: none;
        padding: 0.65rem 1.25rem; border-radius: 10px;
        font-size: 0.82rem; font-weight: 700; cursor: pointer; transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(204, 255, 0, 0.15);
        font-family: inherit;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .admin-primary-button:hover { background: var(--admin-accent-hover); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(204, 255, 0, 0.25); }
    .admin-link-button { color: var(--admin-accent); text-decoration: none; font-size: 0.8rem; font-weight: 700; transition: opacity 0.2s; }
    .admin-link-button:hover { opacity: 0.8; }
    .admin-text-link { color: var(--admin-text-muted); text-decoration: none; font-size: 0.8rem; font-weight: 600; transition: color 0.2s; }
    .admin-text-link:hover { color: #fff; }
    /* ── STATS CARDS (Top row) ── */
    .admin-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; }
    .admin-stat-card { display: flex; flex-direction: column; gap: 1.25rem; transition: transform 0.25s ease, border-color 0.25s ease; }
    .admin-stat-card:hover { transform: translateY(-3px); border-color: rgba(204, 255, 0, 0.2); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    
    .admin-stat-card__top { display: flex; justify-content: space-between; align-items: center; }
    .admin-card-icon {
        width: 48px; height: 48px; border-radius: 12px;
        background: rgba(204, 255, 0, 0.05); border: 1px solid rgba(204, 255, 0, 0.15);
        display: flex; align-items: center; justify-content: center; color: var(--admin-accent);
    }
    .admin-stat-card p { margin: 0; font-size: 0.85rem; color: var(--admin-text-muted); font-weight: 600; }
    .admin-stat-card h2 { margin: 0; font-size: 2.25rem; font-weight: 900; letter-spacing: -0.03em; line-height: 1; }
    /* Pills */
    .admin-pill { padding: 0.25rem 0.75rem; border-radius: var(--admin-radius-pill); font-size: 0.65rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
    .admin-pill--success { background: rgba(46, 213, 115, 0.1); color: var(--admin-success); border: 1px solid rgba(46, 213, 115, 0.2); }
    .admin-pill--danger { background: rgba(255, 71, 87, 0.1); color: var(--admin-danger); border: 1px solid rgba(255, 71, 87, 0.2); }
    .admin-pill--warning { background: rgba(255, 165, 2, 0.1); color: var(--admin-warning); border: 1px solid rgba(255, 165, 2, 0.2); }
    /* ── CHARTS ── */
    .admin-line-chart { width: 100%; position: relative; }
    .admin-line-chart svg { width: 100%; height: 220px; overflow: visible; display: block; }
    .admin-line-chart circle { fill: var(--admin-bg-card); stroke: var(--admin-accent); stroke-width: 3; transition: all 0.3s; }
    .admin-line-chart circle:hover { r: 8; fill: var(--admin-accent); cursor: crosshair; }
    .admin-bar-chart { display: flex; align-items: flex-end; justify-content: space-between; height: 180px; gap: 8px; margin-bottom: 1.25rem; padding-top: 1rem; border-bottom: 1px solid var(--admin-border); }
    .admin-bar-chart__group { display: flex; gap: 6px; flex: 1; justify-content: center; height: 100%; align-items: flex-end; }
    .admin-bar { width: 100%; max-width: 24px; border-radius: 4px 4px 0 0; transition: height 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
    .admin-bar--muted { background: rgba(255, 255, 255, 0.08); }
    .admin-bar--neon { background: var(--admin-accent); box-shadow: 0 -4px 15px rgba(204, 255, 0, 0.15); }
    .admin-bar:hover { filter: brightness(1.2); }
    
    .admin-chart-legend { display: flex; gap: 1.5rem; justify-content: center; font-size: 0.75rem; color: var(--admin-text-muted); font-weight: 600; }
    .admin-chart-legend i { display: inline-block; width: 10px; height: 10px; border-radius: 3px; margin-right: 0.5rem; vertical-align: middle; }
    .legend-muted { background: rgba(255, 255, 255, 0.2); }
    .legend-neon { background: var(--admin-accent); }
    /* ── TABLE ── */
    .admin-table-wrap { overflow-x: auto; margin: 0 -1.5rem; padding: 0 1.5rem; }
    .admin-table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 700px; }
    .admin-table th {
        text-align: left; padding: 1rem 1rem 1rem 0; font-size: 0.7rem; text-transform: uppercase;
        letter-spacing: 0.08em; color: #666; border-bottom: 1px solid var(--admin-border); font-weight: 700;
    }
    .admin-table td { padding: 1.25rem 1rem 1.25rem 0; font-size: 0.85rem; border-bottom: 1px solid rgba(255,255,255,0.03); color: #ddd; }
    .admin-table tbody tr { transition: background 0.2s; }
    .admin-table tbody tr:hover td { background: rgba(255,255,255,0.015); }
    .admin-table tbody tr:last-child td { border-bottom: none; }
    .admin-table__strong { color: #fff !important; font-weight: 700; }
    .text-right { text-align: right !important; padding-right: 0 !important; }
    /* Table Status Badges */
    .admin-status { padding: 0.35rem 0.75rem; border-radius: 6px; font-size: 0.7rem; font-weight: 700; display: inline-block; letter-spacing: 0.02em; }
    .admin-status--pending { background: rgba(255, 165, 2, 0.1); color: var(--admin-warning); border: 1px solid rgba(255, 165, 2, 0.2); }
    .admin-status--success { background: rgba(46, 213, 115, 0.1); color: var(--admin-success); border: 1px solid rgba(46, 213, 115, 0.2); }
    .admin-status--danger { background: rgba(255, 71, 87, 0.1); color: var(--admin-danger); border: 1px solid rgba(255, 71, 87, 0.2); }
    /* ── PROGRESS & LISTS ── */
    .admin-progress-list { display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 1.5rem; }
    .admin-progress-item div { display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.85rem; }
    .admin-progress-item span { color: var(--admin-text-muted); font-weight: 600; }
    .admin-progress-item strong { color: #fff; font-weight: 700; }
    .admin-progress-item progress { width: 100%; height: 6px; border-radius: 3px; background: rgba(255,255,255,0.05); appearance: none; border: none; }
    .admin-progress-item progress::-webkit-progress-bar { background: rgba(255,255,255,0.05); border-radius: 3px; }
    .admin-progress-item progress::-webkit-progress-value { background: var(--admin-accent); border-radius: 3px; transition: width 1s ease; }
    .admin-progress-item--danger progress::-webkit-progress-value { background: var(--admin-danger); }
    .admin-progress-item--muted progress::-webkit-progress-value { background: #444; }
    .admin-summary-line { display: flex; justify-content: space-between; align-items: center; padding-top: 1.25rem; border-top: 1px dashed var(--admin-border); font-size: 0.85rem; }
    .admin-summary-line span { color: var(--admin-text-muted); font-weight: 600; }
    .admin-summary-line strong { color: #fff; font-size: 1.25rem; font-weight: 900; }
    /* Transactions */
    .admin-transaction-list { display: flex; flex-direction: column; gap: 0.85rem; }
    .admin-transaction { display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(255,255,255,0.015); border: 1px solid var(--admin-border); border-radius: 12px; transition: all 0.2s ease; }
    .admin-transaction:hover { background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1); transform: translateX(2px); }
    .admin-transaction__item { display: flex; align-items: center; gap: 1rem; }
    .admin-transaction__item .material-symbols-outlined { background: rgba(204, 255, 0, 0.05); padding: 0.6rem; border-radius: 10px; color: var(--admin-accent); border: 1px solid rgba(204, 255, 0, 0.1); }
    .admin-transaction__item div { display: flex; flex-direction: column; gap: 0.15rem; }
    .admin-transaction__item strong { font-size: 0.85rem; color: #fff; }
    .admin-transaction__item small { font-size: 0.7rem; color: var(--admin-text-muted); }
    .admin-transaction > strong { font-size: 0.95rem; color: var(--admin-accent); font-weight: 800; font-variant-numeric: tabular-nums; }
    /* ── QUICK ACTIONS ── */
    .admin-quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; }
    .admin-quick-action {
        display: flex; align-items: center; gap: 1rem;
        background: var(--admin-bg-card); border: 1px solid var(--admin-border);
        padding: 1.25rem; border-radius: 14px; text-decoration: none; color: #fff;
        transition: all 0.25s ease;
    }
    .admin-quick-action:hover {
        border-color: rgba(204, 255, 0, 0.25);
        background: rgba(204, 255, 0, 0.03);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }
    .admin-quick-action .material-symbols-outlined:first-child {
        color: var(--admin-accent); font-size: 1.5rem;
        background: rgba(204, 255, 0, 0.08); padding: 0.5rem; border-radius: 10px;
    }
    .admin-quick-action strong { font-size: 0.85rem; flex: 1; font-weight: 700; }
    .admin-quick-action .material-symbols-outlined:last-child { color: var(--admin-text-muted); font-size: 1.2rem; transition: transform 0.2s; }
    .admin-quick-action:hover .material-symbols-outlined:last-child { transform: translateX(4px); color: var(--admin-accent); }
    /* ── ACTIVITY & ALERTS ── */
    .admin-activity-list { display: flex; flex-direction: column; gap: 1.25rem; }
    .admin-activity { display: flex; gap: 1rem; align-items: flex-start; }
    .admin-activity .material-symbols-outlined { color: var(--admin-text-muted); background: rgba(255,255,255,0.03); padding: 0.5rem; border-radius: 50%; font-size: 1.1rem; border: 1px solid var(--admin-border); }
    .admin-activity p { margin: 0 0 0.25rem 0; font-size: 0.85rem; color: #eee; line-height: 1.5; }
    .admin-activity small { font-size: 0.7rem; color: var(--admin-text-muted); font-weight: 600; }
    .admin-alert-list { display: flex; flex-direction: column; gap: 1rem; }
    .admin-alert { display: flex; gap: 1rem; padding: 1.25rem; border-radius: 12px; border: 1px solid; align-items: flex-start; }
    .admin-alert strong { display: block; font-size: 0.85rem; margin-bottom: 0.35rem; font-weight: 700; }
    .admin-alert p { margin: 0; font-size: 0.75rem; opacity: 0.8; line-height: 1.5; }
    .admin-alert--danger { background: rgba(255, 71, 87, 0.05); border-color: rgba(255, 71, 87, 0.2); color: var(--admin-danger); }
    .admin-alert--warning { background: rgba(255, 165, 2, 0.05); border-color: rgba(255, 165, 2, 0.2); color: var(--admin-warning); }
    .admin-alert .material-symbols-outlined { font-size: 1.5rem; }
    /* ══════════════════════════════════════════
       RESPONSIVE BREAKPOINTS
       ══════════════════════════════════════════ */
    @media (max-width: 1200px) {
        .admin-grid--two { grid-template-columns: 1fr; }
    }
    @media (max-width: 992px) {
        .admin-main { margin-left: 0; }
        .admin-sidebar { transform: translateX(-100%); }
        .admin-sidebar.is-open { transform: translateX(0); }
        
        .admin-sidebar-toggle { display: flex; }
        
        .admin-topbar { padding: 1rem 1.5rem; }
        .admin-content { padding: 1.5rem; }
        .admin-search input { width: 180px; }
    }
    @media (max-width: 768px) {
        .admin-topbar { flex-direction: column; align-items: stretch; gap: 1rem; }
        .admin-topbar-left { width: 100%; }
        .admin-topbar__actions { width: 100%; justify-content: space-between; }
        .admin-search { flex: 1; }
        .admin-search input { width: 100%; }
        
        .admin-stats { grid-template-columns: repeat(2, 1fr); }
        .admin-quick-actions { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .admin-content { padding: 1rem; gap: 1.25rem; }
        .admin-stats { grid-template-columns: 1fr; }
        .admin-card { padding: 1.25rem; }
        .admin-stat-card h2 { font-size: 1.75rem; }
        .admin-section-head { flex-direction: column; gap: 0.75rem; align-items: flex-start; }
        .admin-topbar-left h1 { font-size: 1.15rem; }
        
        .admin-bar-chart { height: 140px; }
        .admin-line-chart svg { height: 160px; }
    }
    /* Utilitas */
    body.admin-noscroll { overflow: hidden; }
</style>
<div class="admin-shell">
    {{-- OVERLAY MOBILE --}}
    <div class="admin-sidebar-overlay" id="adminSidebarOverlay"></div>
    {{-- SIDEBAR --}}
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Navigasi admin">
        <div class="admin-brand">
            <a href="{{ url('/') }}" class="admin-brand__mark" aria-label="Kembali ke beranda Siboti">
                <span class="material-symbols-outlined">fitness_center</span>
            </a>
            <div>
                <p class="admin-brand__name">Siboti</p>
                <p class="admin-brand__label">Gym Management</p>
            </div>
        </div>
        <nav class="admin-menu">
            <a href="{{ url('/admin/dashboard') }}" class="admin-menu__item admin-menu__item--active">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">group</span>
                <span>Pengguna</span>
            </a>
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">card_membership</span>
                <span>Paket Keanggotaan</span>
            </a>
            <a href="{{ route('trainer.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">fitness_center</span>
                <span>Personal Trainer</span>
            </a>
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">event_available</span>
                <span>Booking</span>
            </a>
            <a href="{{ route('receptionist.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">support_agent</span>
                <span>Receptionist</span>
            </a>
            <a href="{{ route('scan-qr.index') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">qr_code_scanner</span>
                <span>Scan QR</span>
            </a>
            <a href="{{ route('pos.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">point_of_sale</span>
                <span>Transaksi POS</span>
            </a>
            <a href="{{ route('reports.index') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">bar_chart</span>
                <span>Laporan</span>
            </a>
        </nav>
        <div class="admin-sidebar__footer">
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">settings</span>
                <span>Pengaturan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="admin-menu__item admin-menu__item--danger" style="width: 100%; border: 0; background: transparent; cursor: pointer; text-align: left;">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>
    {{-- MAIN CONTENT --}}
    <div class="admin-main">
        
        {{-- TOPBAR --}}
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle" aria-label="Toggle Menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <p class="admin-eyebrow">Panel Administrator</p>
                    <h1>Dashboard Admin</h1>
                </div>
            </div>
            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="search" placeholder="Cari member, booking, transaksi..." aria-label="Cari data admin">
                </label>
                <button type="button" class="admin-icon-button" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="admin-icon-button__dot"></span>
                </button>
                <div class="admin-profile" aria-label="Profil admin">
                    AD
                </div>
            </div>
        </header>
        <main class="admin-content">
            
            {{-- STATS SECTION --}}
            <section class="admin-stats" aria-label="Statistik ringkas">
                @foreach ($stats as $stat)
                    <article class="admin-card admin-stat-card">
                        <div class="admin-stat-card__top">
                            <div class="admin-card-icon">
                                <span class="material-symbols-outlined">{{ $stat['icon'] }}</span>
                            </div>
                            <span class="admin-pill admin-pill--{{ $stat['variant'] }}">{{ $stat['note'] }}</span>
                        </div>
                        <p>{{ $stat['label'] }}</p>
                        <h2>{{ $stat['value'] }}</h2>
                    </article>
                @endforeach
            </section>
            {{-- CHARTS SECTION --}}
            <section class="admin-grid admin-grid--two">
                
                {{-- Line Chart --}}
                <article class="admin-card admin-chart-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Pertumbuhan Membership Bulanan</h2>
                            <p>Januari sampai Juni 2026</p>
                        </div>
                        <button type="button" class="admin-small-button">Filter</button>
                    </div>
                    <div class="admin-line-chart" aria-hidden="true">
                        <svg viewBox="0 0 600 220" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="lineArea" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#ccff00" stop-opacity="0.28" />
                                    <stop offset="100%" stop-color="#ccff00" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <path d="M0 180 L120 150 L240 85 L360 110 L480 55 L600 32 L600 220 L0 220 Z" fill="url(#lineArea)" />
                            <path d="M0 180 L120 150 L240 85 L360 110 L480 55 L600 32" fill="none" stroke="#ccff00" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="120" cy="150" r="6" />
                            <circle cx="240" cy="85" r="6" />
                            <circle cx="360" cy="110" r="6" />
                            <circle cx="480" cy="55" r="6" />
                        </svg>
                    </div>
                </article>
                {{-- Bar Chart --}}
                <article class="admin-card admin-chart-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Aktivitas Booking & Check-in</h2>
                            <p>7 hari terakhir</p>
                        </div>
                    </div>
                    <div class="admin-bar-chart" aria-label="Grafik aktivitas booking dan check-in">
                        @foreach ([60, 70, 45, 80, 55, 90, 75] as $height)
                            <div class="admin-bar-chart__group">
                                <span class="admin-bar admin-bar--muted" style="height: {{ max($height - 18, 25) }}%"></span>
                                <span class="admin-bar admin-bar--neon" style="height: {{ $height }}%"></span>
                            </div>
                        @endforeach
                    </div>
                    <div class="admin-chart-legend">
                        <span><i class="legend-muted"></i> Booking</span>
                        <span><i class="legend-neon"></i> Check-in</span>
                    </div>
                </article>
            </section>
            {{-- TABLE SECTION --}}
            <section class="admin-card admin-table-card">
                <div class="admin-section-head admin-section-head--bordered">
                    <div>
                        <h2>Booking Terbaru</h2>
                        <p>Daftar reservasi kelas dan personal training terbaru</p>
                    </div>
                    <button type="button" class="admin-primary-button">+ Booking Baru</button>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Pelatih</th>
                                <th>Sesi</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td class="admin-table__strong">{{ $booking['member'] }}</td>
                                    <td>{{ $booking['trainer'] }}</td>
                                    <td>{{ $booking['session'] }}</td>
                                    <td>{{ $booking['date'] }}</td>
                                    <td>{{ $booking['time'] }}</td>
                                    <td><span class="admin-status admin-status--{{ $booking['statusClass'] }}">{{ $booking['status'] }}</span></td>
                                    <td class="text-right"><a href="#" class="admin-link-button">Detail</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            {{-- SUMMARY & TRANSACTIONS SECTION --}}
            <section class="admin-grid admin-grid--two">
                
                {{-- Progress List --}}
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Ringkasan Status Membership</h2>
                            <p>Kondisi keanggotaan aktif dan expired</p>
                        </div>
                    </div>
                    <div class="admin-progress-list">
                        <div class="admin-progress-item">
                            <div><span>Aktif</span><strong>75%</strong></div>
                            <progress max="100" value="75"></progress>
                        </div>
                        <div class="admin-progress-item admin-progress-item--danger">
                            <div><span>Mendekati Expired</span><strong>15%</strong></div>
                            <progress max="100" value="15"></progress>
                        </div>
                        <div class="admin-progress-item admin-progress-item--muted">
                            <div><span>Telah Expired</span><strong>10%</strong></div>
                            <progress max="100" value="10"></progress>
                        </div>
                    </div>
                    <div class="admin-summary-line">
                        <span>Total expired bulan ini</span>
                        <strong>12</strong>
                    </div>
                </article>
                {{-- Transactions List --}}
                <article class="admin-card admin-table-card">
                    <div class="admin-section-head admin-section-head--bordered">
                        <div>
                            <h2>Transaksi POS Terbaru</h2>
                            <p>Penjualan produk gym dan minuman</p>
                        </div>
                        <a href="#" class="admin-text-link">Lihat Semua</a>
                    </div>
                    <div class="admin-transaction-list">
                        @foreach ($transactions as $transaction)
                            <div class="admin-transaction">
                                <div class="admin-transaction__item">
                                    <span class="material-symbols-outlined">{{ $transaction['icon'] }}</span>
                                    <div>
                                        <strong>{{ $transaction['item'] }}</strong>
                                        <small>{{ $transaction['time'] }}</small>
                                    </div>
                                </div>
                                <strong>{{ $transaction['amount'] }}</strong>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>
            {{-- QUICK ACTIONS SECTION --}}
            <section class="admin-quick-actions" aria-label="Aksi cepat admin">
                <a href="{{ route('receptionist.dashboard') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">support_agent</span>
                    <strong>Dashboard Receptionist</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
                <a href="{{ route('scan-qr.index') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">qr_code_scanner</span>
                    <strong>Scan QR Check-in</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
                <a href="{{ route('pos.dashboard') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">point_of_sale</span>
                    <strong>Dashboard POS</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
                <a href="{{ route('trainer.dashboard') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">sports</span>
                    <strong>Dashboard Personal Trainer</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
                <a href="{{ route('reports.index') }}" class="admin-quick-action">
                    <span class="material-symbols-outlined">insert_chart</span>
                    <strong>Laporan Operasional</strong>
                    <i class="material-symbols-outlined">chevron_right</i>
                </a>
            </section>
            {{-- ALERTS & ACTIVITY SECTION --}}
            <section class="admin-grid admin-grid--two">
                
                {{-- Activity List --}}
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Aktivitas Pengguna Terbaru</h2>
                            <p>Riwayat aktivitas singkat dalam sistem</p>
                        </div>
                        <button type="button" class="admin-small-button">Refresh</button>
                    </div>
                    <div class="admin-activity-list">
                        @foreach ($activities as $activity)
                            <div class="admin-activity">
                                <span class="material-symbols-outlined">{{ $activity['icon'] }}</span>
                                <div>
                                    <p>{{ $activity['text'] }}</p>
                                    <small>{{ $activity['time'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>
                {{-- Alerts List --}}
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Peringatan Sistem</h2>
                            <p>Notifikasi penting untuk operasional gym</p>
                        </div>
                        <span class="admin-pill admin-pill--danger">3 Alerts</span>
                    </div>
                    <div class="admin-alert-list">
                        @foreach ($alerts as $alert)
                            <div class="admin-alert admin-alert--{{ $alert['type'] }}">
                                <span class="material-symbols-outlined">{{ $alert['icon'] }}</span>
                                <div>
                                    <strong>{{ $alert['title'] }}</strong>
                                    <p>{{ $alert['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>
        </main>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar Toggle Logic
        const toggleBtn = document.getElementById('adminSidebarToggle');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminSidebarOverlay');
        const body = document.body;
        function toggleSidebar() {
            const isOpen = sidebar.classList.toggle('is-open');
            overlay.classList.toggle('is-active');
            
            if (isOpen) {
                body.classList.add('admin-noscroll');
            } else {
                body.classList.remove('admin-noscroll');
            }
        }
        if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('is-open')) {
                toggleSidebar();
            }
        });
        // Close on window resize if moving to desktop view
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992 && sidebar.classList.contains('is-open')) {
                toggleSidebar();
            }
        });
    });
</script>
@endsection