<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking — SibotiHUB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/hub.css') }}?v=1.0">
    <style>
    /* ══════════════════════════════════════════
       BASE & LAYOUT
       ══════════════════════════════════════════ */
    * { box-sizing: border-box; }
    body.hub-page {
        font-family: 'Inter', sans-serif;
        margin: 0;
        background: #0a0a0a;
        color: #e5e5e5;
    }
    .hub-main {
        margin-left: 260px;
        min-height: 100vh;
        padding: 1.5rem 2rem;
        background: #0a0a0a;
        transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    /* ══════════════════════════════════════════
       SIDEBAR OVERLAY & TOGGLE
       ══════════════════════════════════════════ */
    .hub-sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(3px);
        z-index: 998 !important;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .hub-sidebar-overlay.is-visible { display: block; opacity: 1; }
    .hub-sidebar-toggle {
        display: none;
        position: fixed;
        top: 0.85rem;
        left: 0.85rem;
        z-index: 1001 !important;
        width: 40px;
        height: 40px;
        background: #161616;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 10px;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 4px;
        padding: 0;
        transition: background 0.25s ease;
    }
    .hub-sidebar-toggle:hover { background: #1f1f1f; }
    .hub-sidebar-toggle span {
        display: block;
        width: 18px;
        height: 2px;
        background: #ccff00;
        border-radius: 2px;
        transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        transform-origin: center;
    }
    .hub-sidebar-toggle.is-active span:nth-child(1) { transform: translateY(6px) rotate(45deg); }
    .hub-sidebar-toggle.is-active span:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .hub-sidebar-toggle.is-active span:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }
    /* ══════════════════════════════════════════
       HEADER
       ══════════════════════════════════════════ */
    .hub-main__header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .hub-main__greeting { margin: 0 0 0.15rem; font-size: 0.8rem; color: #888; letter-spacing: 0.02em; }
    .hub-main__title { margin: 0; font-size: 1.5rem; font-weight: 800; color: #fff; }
    .booking-header-badge {
        background: rgba(204,255,0,0.08);
        border: 1px solid rgba(204,255,0,0.2);
        border-radius: 0.625rem;
        padding: 0.625rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
    }
    .booking-header-badge__label { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.3); margin: 0; }
    .booking-header-badge__value { font-size: 0.75rem; font-weight: 700; color: #CCFF00; margin: 0; }
    /* ══════════════════════════════════════════
       STEP PT (FULL WIDTH)
       ══════════════════════════════════════════ */
    .booking-step-pt {
        margin-bottom: 1.5rem;
    }
    .booking-card {
        background: #111111;
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 14px;
        padding: 1.25rem;
        transition: border-color 0.25s ease;
    }
    .booking-card:hover { border-color: rgba(255,255,255,0.1); }
    .booking-card--disabled {
        opacity: 0.45;
        pointer-events: none;
        user-select: none;
    }
    .booking-card__step {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1rem;
    }
    .booking-card__step-num {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(204,255,0,0.1);
        color: #ccff00;
        font-weight: 900;
        font-size: 0.75rem;
        border-radius: 8px;
        border: 1px solid rgba(204,255,0,0.2);
        flex-shrink: 0;
    }
    .booking-card__step-title { margin: 0; font-size: 0.9rem; font-weight: 700; color: #fff; }
    /* ── PT Grid ── */
    .pt-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.875rem;
    }
    .pt-card {
        background: rgba(255,255,255,0.03);
        border: 1.5px solid rgba(255,255,255,0.07);
        border-radius: 12px;
        padding: 1rem 0.75rem;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        text-align: center;
        position: relative;
    }
    .pt-card:hover {
        border-color: rgba(204,255,0,0.35);
        background: rgba(204,255,0,0.04);
        transform: translateY(-2px);
    }
    .pt-card--active {
        border-color: #CCFF00 !important;
        background: rgba(204,255,0,0.07) !important;
        box-shadow: 0 0 0 1px rgba(204,255,0,0.2);
    }
    .pt-card__check {
        position: absolute;
        top: 0.6rem;
        right: 0.6rem;
        width: 18px;
        height: 18px;
        background: #CCFF00;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        color: #000;
        font-weight: 900;
    }
    .pt-card--active .pt-card__check { display: flex; }
    .pt-card__img {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.08);
        transition: border-color 0.25s;
    }
    .pt-card--active .pt-card__img { border-color: #CCFF00; }
    .pt-card__name { font-size: 0.78rem; font-weight: 700; color: #fff; margin: 0; line-height: 1.3; }
    .pt-card__role { font-size: 0.65rem; color: rgba(255,255,255,0.35); margin: 0; line-height: 1.4; }
    .pt-card__days {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
        justify-content: center;
    }
    .pt-card__day-chip {
        font-size: 0.55rem;
        font-weight: 700;
        color: #CCFF00;
        background: rgba(204,255,0,0.1);
        border: 1px solid rgba(204,255,0,0.2);
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
    }
    /* ── Selected PT Info ── */
    .pt-selected-info {
        display: none;
        margin-top: 1rem;
        padding: 0.75rem 1rem;
        background: rgba(204,255,0,0.06);
        border: 1px solid rgba(204,255,0,0.2);
        border-radius: 0.625rem;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.6);
        align-items: center;
        gap: 0.75rem;
    }
    .pt-selected-info.is-visible { display: flex; }
    .pt-selected-info__dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #CCFF00;
        flex-shrink: 0;
    }
    .pt-selected-info__text { flex: 1; }
    .pt-selected-info__text strong { color: #CCFF00; }
    /* ══════════════════════════════════════════
       BOOKING GRID (tanggal + waktu)
       ══════════════════════════════════════════ */
    .booking__grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    /* ── Calendar ── */
    .calendar__nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .calendar__nav-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 8px;
        color: #ccc;
        font-size: 1.1rem;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s ease;
    }
    .calendar__nav-btn:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .calendar__month { margin: 0; font-size: 0.82rem; font-weight: 700; color: #fff; }
    .calendar__days-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        margin-bottom: 0.35rem;
    }
    .calendar__days-header span {
        text-align: center;
        font-size: 0.6rem;
        font-weight: 700;
        color: rgba(255,255,255,0.3);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.3rem 0;
    }
    .calendar__days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
    /* ── Waktu ── */
    .waktu__date-label { margin: 0 0 0.25rem; font-size: 0.82rem; font-weight: 700; color: #ccff00; }
    .waktu__hint { margin: 0 0 1rem; font-size: 0.68rem; color: rgba(255,255,255,0.3); }
    .waktu__grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; margin-bottom: 1rem; }
    /* ── Ringkasan ── */
    .ringkasan {
        display: none;
        background: rgba(204,255,0,0.05);
        border: 1px solid rgba(204,255,0,0.15);
        border-radius: 0.625rem;
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.5);
        margin-bottom: 1rem;
    }
    .ringkasan--visible { display: block; }
    .ringkasan__waktu { color: #ccff00; font-weight: 700; }
    /* ── CTA ── */
    .booking-cta {
        display: block;
        text-align: center;
        padding: 0.75rem 1rem;
        background: #ccff00;
        color: #000;
        font-weight: 700;
        font-size: 0.82rem;
        font-family: 'Inter', sans-serif;
        border: none;
        border-radius: 0.625rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
        letter-spacing: 0.02em;
    }
    .booking-cta:hover { background: #b8e600; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(204,255,0,0.2); }
    /* ══════════════════════════════════════════
       HUB CARD (riwayat)
       ══════════════════════════════════════════ */
    .hub-card { background: #111111; border: 1px solid rgba(255,255,255,0.05); border-radius: 14px; padding: 1.25rem; }
    .hub-card__header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; gap: 0.75rem; flex-wrap: wrap; }
    .hub-card__title { margin: 0; font-size: 0.9rem; font-weight: 700; color: #fff; }
    .hapus-semua-btn {
        font-size: 0.7rem; font-weight: 600; color: rgba(255,100,100,0.6);
        background: none; border: 1px solid rgba(255,100,100,0.2);
        padding: 0.35rem 0.75rem; border-radius: 0.5rem; cursor: pointer;
        font-family: 'Inter', sans-serif; transition: all 0.25s ease;
    }
    .hapus-semua-btn:hover { border-color: rgba(255,100,100,0.5); color: rgba(255,100,100,0.9); }
    .riwayat-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .riwayat-card {
        background: rgba(255,255,255,0.03); border-radius: 0.75rem;
        padding: 1rem 1.25rem; border: 1px solid rgba(255,255,255,0.06);
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        transition: border-color 0.2s ease;
    }
    .riwayat-card:hover { border-color: rgba(255,255,255,0.1); }
    .riwayat-card__icon {
        width: 2.25rem; height: 2.25rem; background: rgba(204,255,0,0.08);
        border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;
        font-size: 1rem; flex-shrink: 0; border: 1px solid rgba(204,255,0,0.15);
    }
    .riwayat-card__info { flex: 1; min-width: 0; }
    .riwayat-card__date { font-size: 0.875rem; font-weight: 700; color: #fff; margin: 0 0 0.2rem; }
    .riwayat-card__time { font-size: 0.75rem; color: #CCFF00; font-weight: 600; margin: 0; }
    .riwayat-card__pt { font-size: 0.68rem; color: rgba(255,255,255,0.35); margin: 0.15rem 0 0; }
    .riwayat-card__meta { display: flex; flex-direction: column; align-items: flex-end; gap: 0.35rem; }
    .riwayat-card__status {
        background: rgba(255,200,0,0.1); color: #ffc107; font-size: 0.6rem;
        font-weight: 700; padding: 0.2rem 0.625rem; border-radius: 9999px;
        border: 1px solid rgba(255,200,0,0.2); white-space: nowrap;
    }
    .riwayat-card__created { font-size: 0.65rem; color: rgba(255,255,255,0.25); }
    .wa-btn-sm {
        display: flex; align-items: center; gap: 0.4rem;
        background: #25D366; color: #fff; border: none;
        padding: 0.5rem 0.875rem; border-radius: 0.5rem;
        font-size: 0.7rem; font-weight: 700; cursor: pointer;
        font-family: 'Inter', sans-serif; white-space: nowrap; transition: background 0.2s ease;
    }
    .wa-btn-sm:hover { background: #1fb855; }
    /* ══════════════════════════════════════════
       MEMBERSHIP BANNER
       ══════════════════════════════════════════ */
    .membership-warning-banner {
        background: rgba(255,71,87,0.08);
        border: 1px solid rgba(255,71,87,0.25);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .membership-warning-banner__icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .membership-warning-banner__text { flex: 1; }
    .membership-warning-banner__title {
        margin: 0 0 0.2rem;
        font-size: 0.875rem;
        font-weight: 800;
        color: #ff4757;
    }
    .membership-warning-banner__desc {
        margin: 0;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.45);
        line-height: 1.5;
    }
    .membership-warning-banner__btn {
        background: #ff4757;
        color: #fff;
        border: none;
        border-radius: 0.625rem;
        padding: 0.625rem 1.125rem;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        white-space: nowrap;
        transition: background 0.2s ease;
        flex-shrink: 0;
    }
    .membership-warning-banner__btn:hover { background: #e03e4d; }
    /* Popup membership plans */
    .popup-membership {
        background: #111111;
        border-radius: 1.25rem;
        border: 1px solid rgba(255,71,87,0.2);
        width: 100%;
        max-width: 480px;
        padding: 2rem;
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
    }
    /* ══════════════════════════════════════════
       POPUPS
       ══════════════════════════════════════════ */
    .popup-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.75); z-index: 999;
        align-items: center; justify-content: center;
        padding: 1rem; backdrop-filter: blur(6px);
    }
    .popup-overlay.is-open { display: flex; }
    .popup-content {
        background: #111111; border-radius: 1.25rem;
        border: 1px solid rgba(255,255,255,0.1);
        width: 100%; max-width: 420px; padding: 2rem;
        position: relative; max-height: 90vh; overflow-y: auto;
    }
    .popup-content--sukses { border-color: rgba(204,255,0,0.2); text-align: center; }
    .popup-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
    .popup-header__title { font-size: 1.1rem; font-weight: 900; color: #fff; margin: 0; }
    .popup-close {
        width: 1.75rem; height: 1.75rem; border-radius: 50%;
        background: rgba(255,255,255,0.06); border: none;
        color: rgba(255,255,255,0.5); cursor: pointer; font-size: 1rem;
        display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;
    }
    .popup-close:hover { background: rgba(255,255,255,0.12); color: #fff; }
    .popup-info-list { display: flex; flex-direction: column; gap: 0.875rem; margin-bottom: 1.75rem; }
    .popup-info-row {
        display: flex; align-items: center; gap: 0.875rem;
        padding: 0.875rem 1rem; background: rgba(255,255,255,0.04);
        border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.06);
    }
    .popup-info-row__icon { font-size: 1.25rem; flex-shrink: 0; }
    .popup-info-row__content { flex: 1; min-width: 0; }
    .popup-info-row__label { font-size: 0.6rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.3); margin: 0; }
    .popup-info-row__value { font-size: 0.875rem; font-weight: 700; color: #fff; margin: 0; }
    .popup-info-row__value--accent { color: #CCFF00; }
    .popup-info-row__badge { margin-left: auto; background: rgba(204,255,0,0.1); color: #CCFF00; font-size: 0.6rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 9999px; white-space: nowrap; flex-shrink: 0; }
    .popup-note { font-size: 0.7rem; color: rgba(255,255,255,0.3); text-align: center; margin: 0 0 1.25rem; line-height: 1.5; }
    .popup-actions { display: flex; gap: 0.75rem; }
    .popup-btn {
        padding: 0.875rem; border-radius: 0.625rem; font-size: 0.875rem;
        font-weight: 700; cursor: pointer; font-family: 'Inter', sans-serif;
        transition: all 0.25s ease; text-align: center; text-decoration: none;
        display: flex; align-items: center; justify-content: center; gap: 0.625rem;
    }
    .popup-btn--cancel { flex: 1; border: 1px solid rgba(255,255,255,0.1); background: transparent; color: rgba(255,255,255,0.5); }
    .popup-btn--cancel:hover { border-color: rgba(255,255,255,0.3); color: #fff; }
    .popup-btn--confirm { flex: 2; border: none; background: #CCFF00; color: #000; }
    .popup-btn--confirm:hover { background: #b8e600; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(204,255,0,0.2); }
    .popup-btn--wa { flex: 1; background: #25D366; color: #fff; border: none; }
    .popup-btn--wa:hover { background: #1fb855; }
    .popup-btn--ghost { flex: 1; border: 1px solid rgba(255,255,255,0.1); background: transparent; color: rgba(255,255,255,0.5); font-weight: 600; }
    .popup-btn--ghost:hover { border-color: rgba(255,255,255,0.3); color: #fff; }
    .sukses-icon { width: 4rem; height: 4rem; background: rgba(204,255,0,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; font-size: 1.75rem; border: 2px solid rgba(204,255,0,0.3); }
    .sukses-title { font-size: 1.25rem; font-weight: 900; color: #fff; margin: 0 0 0.5rem; }
    .sukses-detail { font-size: 0.8rem; color: rgba(255,255,255,0.4); margin: 0 0 0.25rem; }
    .sukses-divider { border: none; border-top: 1px solid rgba(255,255,255,0.08); margin: 1.5rem 0; }
    .sukses-next { background: rgba(255,255,255,0.03); border-radius: 0.875rem; padding: 1.25rem; margin-bottom: 1.5rem; border: 1px solid rgba(255,255,255,0.06); }
    .sukses-next__title { font-size: 0.75rem; font-weight: 700; color: #fff; margin: 0 0 0.5rem; }
    .sukses-next__desc { font-size: 0.75rem; color: rgba(255,255,255,0.4); line-height: 1.6; margin: 0; }
    .sukses-actions { display: flex; flex-direction: column; gap: 0.75rem; }
    .toast-notif {
        position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%);
        z-index: 9999; background: #1a1a1a; color: #fff;
        padding: 12px 20px; border-radius: 12px; font-size: 12px; font-weight: 700;
        white-space: pre-line; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.1); max-width: calc(100vw - 2rem);
    }
    /* ══════════════════════════════════════════
       RESPONSIVE
       ══════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .pt-grid { grid-template-columns: repeat(2, 1fr); }
        .booking__grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
    }
    @media (max-width: 768px) {
        .hub-sidebar-toggle { display: flex; }
        .hub-sidebar {
            position: fixed !important; top: 0; left: 0;
            width: 260px; height: 100vh; z-index: 1000 !important;
            transform: translateX(-100%);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .hub-sidebar.is-open { transform: translateX(0); }
        .hub-main { margin-left: 0; padding: 1.25rem 1rem; padding-top: 3.75rem; }
        .hub-main__header { flex-direction: column; gap: 0.75rem; }
        .hub-main__title { font-size: 1.25rem; }
        .booking-header-badge { align-self: flex-start; }
        .pt-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
        .pt-card__img { width: 52px; height: 52px; }
        .booking__grid { grid-template-columns: 1fr; }
        .waktu__grid { grid-template-columns: repeat(3, 1fr); }
        .popup-content { padding: 1.5rem; border-radius: 1rem; margin: 0 0.5rem; }
        .popup-actions { flex-direction: column; }
        .popup-btn--cancel, .popup-btn--confirm { flex: unset; }
        .riwayat-card { flex-direction: column; align-items: flex-start; gap: 0.75rem; padding: 1rem; }
        .riwayat-card__meta { align-items: flex-start; flex-direction: row; gap: 0.5rem; width: 100%; }
        .wa-btn-sm { width: 100%; justify-content: center; }
    }
    @media (max-width: 480px) {
        .hub-main { padding: 1rem 0.75rem; padding-top: 3.5rem; }
        .hub-main__title { font-size: 1.1rem; }
        .pt-grid { grid-template-columns: repeat(2, 1fr); gap: 0.625rem; }
        .pt-card { padding: 0.875rem 0.625rem; }
        .pt-card__img { width: 44px; height: 44px; }
        .pt-card__name { font-size: 0.72rem; }
        .pt-card__role { font-size: 0.6rem; }
        .booking-card { padding: 1rem; border-radius: 10px; }
        .waktu__grid { grid-template-columns: repeat(2, 1fr); }
        .booking-cta { font-size: 0.75rem; padding: 0.7rem; }
        .popup-content { padding: 1.25rem; }
        .popup-header__title { font-size: 0.95rem; }
        .popup-info-row { padding: 0.75rem; gap: 0.65rem; }
        .popup-info-row__value { font-size: 0.78rem; }
        .popup-btn { font-size: 0.78rem; padding: 0.75rem; }
        .sukses-icon { width: 3.25rem; height: 3.25rem; font-size: 1.4rem; }
        .sukses-title { font-size: 1.05rem; }
        .hub-card { padding: 1rem; border-radius: 10px; }
    }
    body.popup-open { overflow: hidden; }
    body.hub-sidebar-open { overflow: hidden; }
    </style>
</head>
<body class="hub-page">

{{-- SIDEBAR TOGGLE --}}
<button class="hub-sidebar-toggle" id="hubSidebarToggle" aria-label="Toggle sidebar" aria-expanded="false">
    <span></span><span></span><span></span>
</button>

{{-- SIDEBAR --}}
@include('hub.partials.sidebar', ['active' => 'booking'])

{{-- SIDEBAR OVERLAY --}}
<div class="hub-sidebar-overlay" id="hubSidebarOverlay"></div>

{{-- MAIN --}}
<main class="hub-main">

    {{-- HEADER --}}
    <div class="hub-main__header">
        <div>
            <p class="hub-main__greeting">Pilih jadwal sesi latihanmu</p>
            <h1 class="hub-main__title">Booking Sesi.</h1>
        </div>
        <div class="booking-header-badge">
            <span class="booking-header-badge__label">Paket Aktif:</span>
            @if($hasActiveSub && $activeSub?->membershipPlan)
                <span class="booking-header-badge__value">{{ $activeSub->membershipPlan->name }}</span>
            @else
                <span class="booking-header-badge__value" style="color:#ff4757;">Belum Ada Paket</span>
            @endif
        </div>
    </div>

    {{-- MEMBERSHIP WARNING BANNER --}}
    @if(!$hasActiveSub)
    <div class="membership-warning-banner" id="membershipWarning">
        <span class="membership-warning-banner__icon">⚠️</span>
        <div class="membership-warning-banner__text">
            <p class="membership-warning-banner__title">Kamu Belum Memiliki Paket Membership!</p>
            <p class="membership-warning-banner__desc">Beli paket membership terlebih dahulu untuk dapat booking sesi personal trainer. Booking tanpa membership bersifat <strong style="color:#ffa502;">Direct</strong> dan memerlukan persetujuan admin secara manual.</p>
        </div>
        <button class="membership-warning-banner__btn" onclick="bukaPopupMembership()">Lihat Paket →</button>
    </div>
    @endif

    {{-- STEP 1: PILIH PT --}}
    <div class="booking-step-pt">
        <div class="booking-card">
            <div class="booking-card__step">
                <span class="booking-card__step-num">1</span>
                <p class="booking-card__step-title">Pilih Personal Trainer</p>
            </div>

            <div class="pt-grid">
                @php
                    $trainerSchedules = [
                        ['hari' => ['Sen','Rab','Jum'], 'slots' => ['06.00','08.00','10.00']],
                        ['hari' => ['Sel','Kam','Sab'], 'slots' => ['08.00','14.00','16.00']],
                        ['hari' => ['Sen','Sel','Rab','Kam'], 'slots' => ['06.00','10.00','19.00']],
                        ['hari' => ['Rab','Jum','Sab'], 'slots' => ['14.00','16.00','19.00']],
                    ];
                @endphp

                @foreach($trainers as $index => $trainer)
                    @php
                        $schedule = $trainerSchedules[$index % count($trainerSchedules)];
                        $trainerDisplay = $trainer->name;
                        $trainerRole = 'Personal Trainer';
                    @endphp
                    <div class="pt-card"
                         onclick="pilihPT(this)"
                         data-pt-id="{{ $trainer->id }}"
                         data-pt-nama="{{ $trainerDisplay }}"
                         data-pt-role="{{ $trainerRole }}"
                         data-pt-hari="{{ implode(',', $schedule['hari']) }}"
                         data-pt-slots="{{ implode(',', $schedule['slots']) }}">
                        <div class="pt-card__check">✓</div>
                        <img src="{{ asset('image/Pelatih/pelatih.webp') }}"
                             alt="{{ $trainerDisplay }}"
                             class="pt-card__img">
                        <p class="pt-card__name">{{ $trainerDisplay }}</p>
                        <p class="pt-card__role">{{ $trainerRole }}</p>
                        <div class="pt-card__days">
                            @foreach($schedule['hari'] as $h)
                                <span class="pt-card__day-chip">{{ $h }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Info PT terpilih --}}
            <div class="pt-selected-info" id="pt-selected-info">
                <div class="pt-selected-info__dot"></div>
                <p class="pt-selected-info__text">
                    PT dipilih: <strong id="pt-selected-nama">-</strong> —
                    Tersedia: <strong id="pt-selected-hari">-</strong>
                </p>
            </div>
        </div>
    </div>

    {{-- STEP 2 & 3: TANGGAL & WAKTU --}}
    <div class="booking__grid">

        {{-- Step 2: Pilih Tanggal --}}
        <div class="booking-card booking-card--disabled" id="card-tanggal">
            <div class="booking-card__step">
                <span class="booking-card__step-num">2</span>
                <p class="booking-card__step-title">Pilih Tanggal</p>
            </div>
            <div class="calendar__nav">
                <button onclick="prevMonth()" class="calendar__nav-btn">‹</button>
                <p id="month-label" class="calendar__month"></p>
                <button onclick="nextMonth()" class="calendar__nav-btn">›</button>
            </div>
            <div class="calendar__days-header">
                <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
            </div>
            <div id="calendar-days" class="calendar__days"></div>
        </div>

        {{-- Step 3: Pilih Waktu --}}
        <div class="booking-card booking-card--disabled" id="card-waktu">
            <div class="booking-card__step">
                <span class="booking-card__step-num">3</span>
                <p class="booking-card__step-title">Pilih Waktu</p>
            </div>
            <p id="selected-date-label" class="waktu__date-label">Belum ada tanggal dipilih</p>
            <p class="waktu__hint">Maksimal 2 sesi, harus jam berdekatan</p>
            <div class="waktu__grid" id="waktu-grid"></div>
            <div id="ringkasan" class="ringkasan">
                Sesi dipilih: <span id="ringkasan-waktu" class="ringkasan__waktu"></span>
            </div>
            <a href="#" onclick="bukaPopup1(event)" class="booking-cta">
                KONFIRMASI BOOKING
            </a>
        </div>

    </div>

    <form id="bookingForm" method="POST" action="{{ route('hub.bookings.store') }}">
        @csrf
        <input type="hidden" name="trainer_id" id="bookingTrainerId">
        <input type="hidden" name="booking_date" id="bookingDate">
        <input type="hidden" name="booking_time" id="bookingTime">
        <input type="hidden" name="session_type" id="bookingSessionType">
    </form>

    @if(session('success'))
        <div class="hub-card hub-card--success">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="hub-card hub-card--danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="hub-card hub-booking-list">
        <div class="hub-card__header">
            <p class="hub-card__title">Booking Saya</p>
        </div>

        @if($myBookings->isEmpty())
            <p class="hub-card__empty">Belum ada booking aktif. Pilih trainer dan jadwal untuk membuat reservasi.</p>
        @else
            <table class="hub-table">
                <thead>
                    <tr>
                        <th>Trainer</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myBookings as $booking)
                        <tr>
                            <td>{{ $booking->trainer?->name ?? '-' }}</td>
                            <td>{{ $booking->booking_date->format('d M Y') }}</td>
                            <td>{{ substr($booking->booking_time, 0, 5) }}</td>
                            <td>{{ ucfirst($booking->status) }}</td>
                            <td>
                                @if($booking->status !== 'completed')
                                    <form method="POST" action="{{ route('hub.bookings.destroy', $booking) }}" onsubmit="return confirm('Batalkan booking ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-small-button admin-small-button--danger">Batal</button>
                                    </form>
                                @else
                                    <span class="badge badge--neutral">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

</main>

{{-- POPUP 1: Konfirmasi --}}
<div id="popup-ringkasan" class="popup-overlay">
    <div class="popup-content">
        <div class="popup-header">
            <p class="popup-header__title">Konfirmasi Booking</p>
            <button onclick="tutupPopup1()" class="popup-close">✕</button>
        </div>
        <div class="popup-info-list">
            <div class="popup-info-row">
                <span class="popup-info-row__icon">👤</span>
                <div class="popup-info-row__content">
                    <p class="popup-info-row__label">Member</p>
                    <p class="popup-info-row__value">{{ auth()->user()->name }}</p>
                </div>
                @if($hasActiveSub && $activeSub?->membershipPlan)
                    <span class="popup-info-row__badge">{{ $activeSub->membershipPlan->name }}</span>
                @else
                    <span class="popup-info-row__badge" style="background:rgba(255,71,87,0.1);color:#ff4757;">Direct</span>
                @endif
            </div>
            <div class="popup-info-row">
                <span class="popup-info-row__icon">🏋️</span>
                <div class="popup-info-row__content">
                    <p class="popup-info-row__label">Personal Trainer</p>
                    <p id="popup-pt" class="popup-info-row__value">-</p>
                </div>
            </div>
            <div class="popup-info-row">
                <span class="popup-info-row__icon">📅</span>
                <div class="popup-info-row__content">
                    <p class="popup-info-row__label">Tanggal</p>
                    <p id="popup-tanggal" class="popup-info-row__value">-</p>
                </div>
            </div>
            <div class="popup-info-row">
                <span class="popup-info-row__icon">⏰</span>
                <div class="popup-info-row__content">
                    <p class="popup-info-row__label">Waktu Sesi</p>
                    <p id="popup-waktu" class="popup-info-row__value popup-info-row__value--accent">-</p>
                </div>
            </div>
        </div>
        <p class="popup-note">Pastikan data sudah benar sebelum konfirmasi.</p>
        <div class="popup-actions">
            <button onclick="tutupPopup1()" class="popup-btn popup-btn--cancel">Batal</button>
            <button onclick="lanjutKonfirmasi()" class="popup-btn popup-btn--confirm">YA, KONFIRMASI →</button>
        </div>
    </div>
</div>

{{-- POPUP 2: Sukses --}}
<div id="popup-sukses" class="popup-overlay">
    <div class="popup-content popup-content--sukses">
        <div class="sukses-icon">✅</div>
        <p class="sukses-title">Booking Berhasil!</p>
        <p id="sukses-detail" class="sukses-detail">-</p>
        <hr class="sukses-divider">
        <div class="sukses-next">
            <p class="sukses-next__title">Langkah Selanjutnya</p>
            <p id="sukses-next-desc" class="sukses-next__desc">Hubungi admin Siboti Gym untuk konfirmasi pembayaran dan mendapatkan kode booking kamu.</p>
        </div>
        <div class="sukses-actions">
            <a id="wa-btn" href="#" target="_blank" class="popup-btn popup-btn--wa">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Chat WhatsApp <span id="wa-target-name">Admin</span>
            </a>
            <button onclick="tutupPopupSukses()" class="popup-btn popup-btn--ghost">Tutup</button>
        </div>
    </div>
</div>

{{-- POPUP MEMBERSHIP (jika belum punya membership) --}}
<div id="popup-membership" class="popup-overlay">
    <div class="popup-membership">
        <div class="popup-header">
            <p class="popup-header__title">Pilih Paket Membership</p>
            <button onclick="tutupPopupMembership()" class="popup-close">✕</button>
        </div>
        <div style="margin-bottom:1.25rem;padding:0.875rem 1rem;background:rgba(255,71,87,0.06);border:1px solid rgba(255,71,87,0.15);border-radius:0.75rem;">
            <p style="margin:0;font-size:0.78rem;color:#ccc;line-height:1.6;">
                Kamu belum memiliki paket membership aktif. Silakan beli salah satu paket di bawah dan hubungi admin via WhatsApp untuk konfirmasi. Setelah membership aktif, kamu bisa booking personal trainer dengan lebih mudah.
            </p>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.875rem;margin-bottom:1.5rem;">
            @forelse($membershipPlans as $plan)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.125rem;background:rgba(204,255,0,0.03);border:1px solid rgba(204,255,0,0.12);border-radius:0.875rem;gap:1rem;">
                <div style="flex:1;">
                    <strong style="color:#fff;font-size:0.875rem;display:block;margin-bottom:0.2rem;">{{ $plan->name }}</strong>
                    <small style="color:#888;font-size:0.7rem;">{{ $plan->duration_days }} hari · {{ $plan->description }}</small>
                </div>
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.5rem;flex-shrink:0;">
                    <span style="color:#ccff00;font-weight:800;font-size:0.9rem;">Rp{{ number_format($plan->price, 0, ',', '.') }}</span>
                    <a href="{{ route('hub.membership.buy', $plan->id) }}" style="background:#ccff00;color:#000;border:none;border-radius:0.5rem;padding:0.4rem 0.875rem;font-size:0.72rem;font-weight:700;text-decoration:none;font-family:'Inter',sans-serif;white-space:nowrap;">Beli Sekarang</a>
                </div>
            </div>
            @empty
            <p style="color:#888;font-size:0.8rem;text-align:center;">Tidak ada paket tersedia saat ini.</p>
            @endforelse
        </div>
        <div style="display:flex;gap:0.75rem;">
            <button onclick="tutupPopupMembership()" class="popup-btn popup-btn--cancel" style="flex:1;">Nanti Dulu</button>
            <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin Siboti! Saya ' . auth()->user()->name . ' ingin membeli paket membership. Mohon bantuannya.') }}" target="_blank" class="popup-btn popup-btn--wa" style="flex:1;text-decoration:none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Hubungi Admin
            </a>
        </div>
    </div>
</div>

<script>
/* ── Sidebar Toggle ── */
(function(){
    const toggle=document.getElementById('hubSidebarToggle');
    const overlay=document.getElementById('hubSidebarOverlay');
    const sidebar=document.querySelector('.hub-sidebar')||document.querySelector('aside');
    if(!toggle||!sidebar) return;
    function open(){sidebar.classList.add('is-open');toggle.classList.add('is-active');overlay.classList.add('is-visible');document.body.classList.add('hub-sidebar-open');toggle.setAttribute('aria-expanded','true');}
    function close(){sidebar.classList.remove('is-open');toggle.classList.remove('is-active');overlay.classList.remove('is-visible');document.body.classList.remove('hub-sidebar-open');toggle.setAttribute('aria-expanded','false');}
    toggle.addEventListener('click',()=>sidebar.classList.contains('is-open')?close():open());
    overlay.addEventListener('click',close);
    document.addEventListener('keydown',e=>{if(e.key==='Escape'&&sidebar.classList.contains('is-open'))close();});
    window.addEventListener('resize',()=>{if(window.innerWidth>768)close();});
    sidebar.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{if(window.innerWidth<=768)close();}));
})();

/* ── Data PT & State ── */
const hariMap = {'Min':0,'Sen':1,'Sel':2,'Rab':3,'Kam':4,'Jum':5,'Sab':6};
let selectedPT = null;
let selectedPTId = null;
let selectedPTSlots = [];
let selectedPTHari = [];
let selectedWaktu = [];
let currentDate = new Date();
let selectedDate = null;

/* ── Pilih PT ── */
function pilihPT(card) {
    document.querySelectorAll('.pt-card').forEach(c => c.classList.remove('pt-card--active'));
    card.classList.add('pt-card--active');

    selectedPTId = card.dataset.ptId;
    selectedPT = card.dataset.ptNama;
    selectedPTSlots = card.dataset.ptSlots.split(',');
    selectedPTHari = card.dataset.ptHari.split(',').map(h => hariMap[h.trim()]);

    // Info PT
    document.getElementById('pt-selected-nama').textContent = selectedPT;
    document.getElementById('pt-selected-hari').textContent = card.dataset.ptHari;
    document.getElementById('pt-selected-info').classList.add('is-visible');

    // Aktifkan step 2 & 3
    document.getElementById('card-tanggal').classList.remove('booking-card--disabled');
    document.getElementById('card-waktu').classList.remove('booking-card--disabled');

    // Reset pilihan tanggal & waktu
    selectedDate = null;
    selectedWaktu = [];
    document.getElementById('selected-date-label').textContent = 'Belum ada tanggal dipilih';
    updateRingkasan();
    renderWaktuGrid();
    renderCalendar();
}

/* ── Kalender ── */
function renderCalendar() {
    const year=currentDate.getFullYear(), month=currentDate.getMonth();
    const months=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    document.getElementById('month-label').textContent=months[month]+' '+year;
    const firstDay=new Date(year,month,1).getDay();
    const daysInMonth=new Date(year,month+1,0).getDate();
    const today=new Date();
    let html='';
    for(let i=0;i<firstDay;i++) html+='<span></span>';
    for(let d=1;d<=daysInMonth;d++){
        const dateObj=new Date(year,month,d);
        const dayOfWeek=dateObj.getDay();
        const isToday=d===today.getDate()&&month===today.getMonth()&&year===today.getFullYear();
        const isSelected=selectedDate&&d===selectedDate.getDate()&&month===selectedDate.getMonth()&&year===selectedDate.getFullYear();
        const isPast=dateObj<new Date(today.getFullYear(),today.getMonth(),today.getDate());
        const isUnavailable=selectedPT && !selectedPTHari.includes(dayOfWeek);
        let cls='cal-day ';
        if(isSelected) cls+='cal-day--selected';
        else if(isPast||isUnavailable) cls+='cal-day--past';
        else if(isToday) cls+='cal-day--today';
        else cls+='cal-day--normal';
        html+=`<button onclick="pilihTanggal(${d})" class="${cls}" ${(isPast||isUnavailable)?'disabled':''}>${d}</button>`;
    }
    document.getElementById('calendar-days').innerHTML=html;
}

function pilihTanggal(d){
    selectedDate=new Date(currentDate.getFullYear(),currentDate.getMonth(),d);
    const days=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    document.getElementById('selected-date-label').textContent=days[selectedDate.getDay()]+', '+d+' '+months[selectedDate.getMonth()]+' '+selectedDate.getFullYear();
    selectedWaktu=[];
    updateRingkasan();
    renderWaktuGrid();
    renderCalendar();
}

function prevMonth(){currentDate.setMonth(currentDate.getMonth()-1);renderCalendar();}
function nextMonth(){currentDate.setMonth(currentDate.getMonth()+1);renderCalendar();}

/* ── Waktu Grid ── */
function renderWaktuGrid(){
    const slots = selectedPTSlots.length > 0 ? selectedPTSlots : ['06.00','08.00','10.00','14.00','16.00','19.00'];
    document.getElementById('waktu-grid').innerHTML = slots.map(jam =>
        `<button onclick="pilihWaktu(this)" data-jam="${jam}" class="waktu-btn">${jam}</button>`
    ).join('');
}

function pilihWaktu(btn){
    const jam=btn.dataset.jam;
    const slots=selectedPTSlots.length>0?selectedPTSlots:['06.00','08.00','10.00','14.00','16.00','19.00'];
    const idx=slots.indexOf(jam);
    if(selectedWaktu.includes(jam)){
        selectedWaktu=selectedWaktu.filter(j=>j!==jam);
        btn.classList.remove('waktu-btn--active');
        updateRingkasan(); return;
    }
    if(selectedWaktu.length>=2){showToast('Maksimal 2 sesi per booking!');return;}
    if(selectedWaktu.length===1){
        const idxPertama=slots.indexOf(selectedWaktu[0]);
        if(Math.abs(idx-idxPertama)!==1){showToast('Pilih jam yang berdekatan!\nContoh: 06.00 → 08.00');return;}
    }
    selectedWaktu.push(jam);
    btn.classList.add('waktu-btn--active');
    updateRingkasan();
}

function updateRingkasan(){
    const el=document.getElementById('ringkasan');
    const elW=document.getElementById('ringkasan-waktu');
    if(selectedWaktu.length>0){
        const slots=selectedPTSlots.length>0?selectedPTSlots:['06.00','08.00','10.00','14.00','16.00','19.00'];
        const sorted=[...selectedWaktu].sort((a,b)=>slots.indexOf(a)-slots.indexOf(b));
        elW.textContent=sorted.join(' - ');
        el.classList.add('ringkasan--visible');
    } else { el.classList.remove('ringkasan--visible'); }
}

/* ── Popup Membership ── */
const hasActiveSub = {{ $hasActiveSub ? 'true' : 'false' }};

function bukaPopupMembership() {
    document.getElementById('popup-membership').classList.add('is-open');
    document.body.classList.add('popup-open');
}
function tutupPopupMembership() {
    document.getElementById('popup-membership').classList.remove('is-open');
    document.body.classList.remove('popup-open');
}
document.getElementById('popup-membership').addEventListener('click', function(e) {
    if (e.target === this) tutupPopupMembership();
});

/* ── Popup 1 ── */
function bukaPopup1(e){
    e.preventDefault();
    if(!selectedPT){showToast('Pilih Personal Trainer terlebih dahulu!');return;}
    if(!selectedDate){showToast('Pilih tanggal terlebih dahulu!');return;}
    if(selectedWaktu.length===0){showToast('Pilih minimal 1 sesi waktu!');return;}
    // Frontend check removed so Direct Booking can proceed and hit the backend
    const slots=selectedPTSlots.length>0?selectedPTSlots:['06.00','08.00','10.00','14.00','16.00','19.00'];
    const sorted=[...selectedWaktu].sort((a,b)=>slots.indexOf(a)-slots.indexOf(b));
    const days=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const tgl=days[selectedDate.getDay()]+', '+selectedDate.getDate()+' '+months[selectedDate.getMonth()]+' '+selectedDate.getFullYear();
    document.getElementById('popup-pt').textContent=selectedPT;
    document.getElementById('popup-tanggal').textContent=tgl;
    document.getElementById('popup-waktu').textContent=sorted.join(' & ');
    document.getElementById('popup-ringkasan').classList.add('is-open');
    document.body.classList.add('popup-open');
}

function tutupPopup1(){
    document.getElementById('popup-ringkasan').classList.remove('is-open');
    document.body.classList.remove('popup-open');
}

/* ── Popup 2 ── */
function lanjutKonfirmasi(){
    const slots=selectedPTSlots.length>0?selectedPTSlots:['06.00','08.00','10.00','14.00','16.00','19.00'];
    const sorted=[...selectedWaktu].sort((a,b)=>slots.indexOf(a)-slots.indexOf(b));
    const bookingDate = selectedDate.toISOString().slice(0,10);
    const bookingTime = sorted[0].replace('.', ':');
    const sessionType = sorted.length > 1 ? `${sorted.length} sesi: ${sorted.join(' & ')}` : `1 sesi: ${sorted[0]}`;

    document.getElementById('bookingTrainerId').value = selectedPTId;
    document.getElementById('bookingDate').value = bookingDate;
    document.getElementById('bookingTime').value = bookingTime;
    document.getElementById('bookingSessionType').value = sessionType;

    document.getElementById('bookingForm').submit();
}

function tutupPopupSukses(){
    document.getElementById('popup-sukses').classList.remove('is-open');
    document.body.classList.remove('popup-open');
}

document.getElementById('popup-ringkasan').addEventListener('click',function(e){if(e.target===this)tutupPopup1();});
document.getElementById('popup-sukses').addEventListener('click',function(e){if(e.target===this)tutupPopupSukses();});
document.addEventListener('keydown',function(e){
    if(e.key==='Escape'){
        if(document.getElementById('popup-sukses').classList.contains('is-open'))tutupPopupSukses();
        if(document.getElementById('popup-ringkasan').classList.contains('is-open'))tutupPopup1();
        if(document.getElementById('popup-membership').classList.contains('is-open'))tutupPopupMembership();
    }
});

/* ── Riwayat ── */
function simpanRiwayat(tanggal, waktu, pt) {
    let riwayat=JSON.parse(localStorage.getItem('siboti_booking')||'[]');
    riwayat.unshift({tanggal,waktu,pt,nama:'Budi Santoso',paket:'Pro',status:'Menunggu Konfirmasi',created:new Date().toLocaleDateString('id-ID')});
    if(riwayat.length>3) riwayat=riwayat.slice(0,3);
    localStorage.setItem('siboti_booking',JSON.stringify(riwayat));
    tampilkanRiwayat();
}

function tampilkanRiwayat(){
    const riwayat=JSON.parse(localStorage.getItem('siboti_booking')||'[]');
    const section=document.getElementById('riwayat-section');
    const list=document.getElementById('riwayat-list');
    if(riwayat.length===0){section.style.display='none';return;}
    section.style.display='block';
    list.innerHTML=riwayat.map(item=>`
        <div class="riwayat-card">
            <div class="riwayat-card__icon">📅</div>
            <div class="riwayat-card__info">
                <p class="riwayat-card__date">${item.tanggal}</p>
                <p class="riwayat-card__time">⏰ ${item.waktu}</p>
                <p class="riwayat-card__pt">🏋️ ${item.pt||'-'}</p>
            </div>
            <div class="riwayat-card__meta">
                <span class="riwayat-card__status">${item.status}</span>
                <span class="riwayat-card__created">Dibuat: ${item.created}</span>
            </div>
            <button onclick="hubungiAdmin('${item.tanggal}','${item.waktu}','${item.pt||'-'}')" class="wa-btn-sm">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Hubungi Admin
            </button>
        </div>
    `).join('');
}

function hubungiAdmin(tanggal, waktu, pt){
    const pesanWA=encodeURIComponent('Halo Admin Siboti Gym! 👋\n\nKonfirmasi booking:\n👤 Budi Santoso\n🏋️ PT: '+pt+'\n📅 '+tanggal+'\n⏰ '+waktu+'\n🎫 Paket Pro\n\nTerima kasih!');
    window.open('https://wa.me/6281234567890?text='+pesanWA,'_blank');
}

function hapusSemuaRiwayat(){
    if(confirm('Hapus semua riwayat booking?')){localStorage.removeItem('siboti_booking');tampilkanRiwayat();}
}

function showToast(msg){
    const existing=document.getElementById('toast-notif');
    if(existing)existing.remove();
    const toast=document.createElement('div');
    toast.id='toast-notif';
    toast.className='toast-notif';
    toast.textContent=msg;
    document.body.appendChild(toast);
    setTimeout(()=>toast.remove(),3000);
}

renderCalendar();
renderWaktuGrid();
document.addEventListener('DOMContentLoaded', function() {
    tampilkanRiwayat();
    
    @if(session('direct_wa_url'))
        // Buka tab baru untuk WhatsApp
        window.open("{{ session('direct_wa_url') }}", "_blank");
        
        // Tampilkan popup sukses di tab saat ini
        document.getElementById('sukses-detail').textContent = "{{ session('success') }}";
        @if(session('wa_target') == 'Trainer')
            document.getElementById('sukses-next-desc').textContent = "Hubungi Personal Trainer kamu untuk konfirmasi jadwal latihan.";
            document.getElementById('wa-target-name').textContent = "Trainer";
        @else
            document.getElementById('sukses-next-desc').textContent = "Hubungi admin Siboti Gym untuk konfirmasi pembayaran booking secara direct.";
            document.getElementById('wa-target-name').textContent = "Admin";
        @endif
        document.getElementById('wa-btn').href = "{{ session('direct_wa_url') }}";

        document.getElementById('popup-sukses').classList.add('is-open');
        document.body.classList.add('popup-open');
    @elseif(session('success'))
        // Tampilkan popup sukses biasa
        document.getElementById('sukses-detail').textContent = "{{ session('success') }}";
        document.getElementById('popup-sukses').classList.add('is-open');
        document.body.classList.add('popup-open');
    @endif
});
</script>
</body>
</html>