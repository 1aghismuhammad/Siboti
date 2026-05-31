<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Trainer — Siboti</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trainer.css') }}">
    <style>
    /* ═══════════════════════════════════════
       TAB SYSTEM — Pure CSS, zero JS routing
       ═══════════════════════════════════════ */

    /* Hidden radio inputs drive tab state */
    #tab-jadwal, #tab-booking, #tab-progress { display: none; }

    /* Default: semua panel hidden */
    .tab-panel { display: none; }

    /* Aktifkan panel sesuai radio yang dicek */
    #tab-jadwal:checked  ~ .trainer-main .tab-panel--jadwal,
    #tab-booking:checked ~ .trainer-main .tab-panel--booking,
    #tab-progress:checked ~ .trainer-main .tab-panel--progress { display: block; }

    /* Tab nav styling */
    #tab-jadwal:checked  ~ .trainer-main .tab-nav__item[for="tab-jadwal"],
    #tab-booking:checked ~ .trainer-main .tab-nav__item[for="tab-booking"],
    #tab-progress:checked ~ .trainer-main .tab-nav__item[for="tab-progress"] {
        color: #000;
        background: #CCFF00;
        border-color: #CCFF00;
    }

    /* ═══ BASE LAYOUT ═══ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body.trainer-page {
        background: #0a0a0a;
        color: rgba(255,255,255,0.7);
        font-family: 'Inter', sans-serif;
        font-size: 0.875rem;
        min-height: 100vh;
        display: flex;
    }

    /* ═══ SIDEBAR ═══ */
    .trainer-sidebar {
        width: 260px;
        min-height: 100vh;
        background: #111111;
        border-right: 1px solid rgba(255,255,255,0.06);
        display: flex;
        flex-direction: column;
        padding: 1.75rem 1.25rem;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        flex-shrink: 0;
    }
    .trainer-sidebar__logo { margin-bottom: 0.25rem; }
    .trainer-sidebar__logo-text { font-size: 1.5rem; font-weight: 900; color: #fff; letter-spacing: -0.03em; }
    .trainer-sidebar__subtitle { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.25); margin-bottom: 1.5rem; }
    .trainer-sidebar__search {
        width: 100%; padding: 0.625rem 0.875rem; background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08); border-radius: 0.625rem;
        color: #fff; font-size: 0.8rem; font-family: 'Inter', sans-serif;
        outline: none; margin-bottom: 1.25rem;
    }
    .trainer-sidebar__search:focus { border-color: rgba(204,255,0,0.4); }
    .trainer-sidebar__section-title { font-size: 0.6rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.2); margin-bottom: 0.75rem; }
    .trainer-member-list { display: flex; flex-direction: column; gap: 0.375rem; flex: 1; }
    .trainer-member-item {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 0.625rem 0.75rem; border-radius: 0.625rem;
        text-decoration: none; border: 1px solid transparent;
        transition: background 0.15s;
    }
    .trainer-member-item:hover { background: rgba(255,255,255,0.04); }
    .trainer-member-item--active { background: rgba(204,255,0,0.06); border-color: rgba(204,255,0,0.2); }
    .trainer-member-item__avatar {
        width: 2rem; height: 2rem; border-radius: 0.5rem;
        background: rgba(255,255,255,0.08); display: flex; align-items: center;
        justify-content: center; font-size: 0.7rem; font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .trainer-member-item--active .trainer-member-item__avatar { background: rgba(204,255,0,0.15); color: #CCFF00; }
    .trainer-member-item__name { font-size: 0.8rem; font-weight: 700; color: #fff; }
    .trainer-member-item__paket { font-size: 0.65rem; color: rgba(255,255,255,0.3); }
    .trainer-sidebar__footer {
        display: flex; align-items: center; gap: 0.75rem;
        padding-top: 1.25rem; border-top: 1px solid rgba(255,255,255,0.06); margin-top: 1.25rem;
    }
    .trainer-sidebar__footer-avatar {
        width: 2.25rem; height: 2.25rem; border-radius: 50%;
        background: rgba(204,255,0,0.12); display: flex; align-items: center;
        justify-content: center; font-size: 0.75rem; font-weight: 700; color: #CCFF00; flex-shrink: 0;
    }
    .trainer-sidebar__footer-name { font-size: 0.8rem; font-weight: 700; color: #fff; }
    .trainer-sidebar__footer-role { font-size: 0.65rem; color: rgba(255,255,255,0.3); }

    /* ═══ MAIN ═══ */
    .trainer-main {
        flex: 1;
        padding: 2rem 2rem 4rem;
        min-width: 0;
        overflow-y: auto;
    }
    .trainer-main__header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 1rem; margin-bottom: 0.5rem; flex-wrap: wrap;
    }
    .trainer-main__label { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.25); margin-bottom: 0.25rem; }
    .trainer-main__title { font-size: 2rem; font-weight: 900; color: #fff; letter-spacing: -0.03em; line-height: 1; }
    .trainer-main__desc { font-size: 0.8rem; color: rgba(255,255,255,0.3); margin-bottom: 1.75rem; }

    /* ═══ TAB NAV ═══ */
    .tab-nav {
        display: flex; gap: 0.5rem; margin-bottom: 2rem;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 0.75rem; padding: 0.375rem;
        width: fit-content;
    }
    .tab-nav__item {
        padding: 0.5rem 1.25rem; border-radius: 0.5rem;
        font-size: 0.8rem; font-weight: 700; cursor: pointer;
        color: rgba(255,255,255,0.4);
        border: 1px solid transparent;
        transition: all 0.15s; user-select: none;
        white-space: nowrap;
    }
    .tab-nav__item:hover { color: #fff; }

    /* ═══ STAT CARDS ═══ */
    .trainer-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px,1fr)); gap: 0.875rem; margin-bottom: 1.5rem; }
    .trainer-stat-card {
        background: #111111; border: 1px solid rgba(255,255,255,0.07);
        border-radius: 0.875rem; padding: 1rem 1.125rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .trainer-stat-card__label { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.25); margin-bottom: 0.375rem; }
    .trainer-stat-card__value { font-size: 1.5rem; font-weight: 900; color: #fff; letter-spacing: -0.03em; line-height: 1; }
    .trainer-stat-card__unit { font-size: 0.8rem; font-weight: 700; color: rgba(255,255,255,0.3); margin-left: 0.15rem; }
    .trainer-stat-card__icon { width: 1.5rem; height: 1.5rem; color: rgba(204,255,0,0.3); flex-shrink: 0; }

    /* ═══ CARD WRAPPER ═══ */
    .trainer-card {
        background: #111111; border: 1px solid rgba(255,255,255,0.07);
        border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.25rem;
    }
    .trainer-card__title { font-size: 0.875rem; font-weight: 700; color: #fff; margin-bottom: 1.25rem; }

    /* ═══ TABEL ═══ */
    .trainer-table-card {
        background: #111111; border: 1px solid rgba(255,255,255,0.07);
        border-radius: 1rem; overflow: hidden;
    }
    .trainer-table-card__header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .trainer-table-card__title { font-size: 0.875rem; font-weight: 700; color: #fff; }
    .trainer-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }
    .trainer-table th {
        padding: 0.75rem 1.25rem; text-align: left;
        font-size: 0.6rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
        color: rgba(255,255,255,0.25); border-bottom: 1px solid rgba(255,255,255,0.06);
        white-space: nowrap;
    }
    .trainer-table td { padding: 0.875rem 1.25rem; color: rgba(255,255,255,0.6); border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
    .trainer-table tr:last-child td { border-bottom: none; }
    .trainer-table tr:hover td { background: rgba(255,255,255,0.02); }
    .trainer-table__badge {
        display: inline-block; padding: 0.25rem 0.625rem;
        background: rgba(204,255,0,0.08); color: #CCFF00;
        border-radius: 9999px; font-size: 0.7rem; font-weight: 700;
        border: 1px solid rgba(204,255,0,0.15); white-space: nowrap;
    }
    .trainer-table__action {
        background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);
        border-radius: 0.4rem; padding: 0.3rem 0.5rem; cursor: pointer; font-size: 0.75rem;
    }
    .trainer-table__action--delete:hover { background: rgba(255,80,80,0.1); border-color: rgba(255,80,80,0.2); }

    /* ═══ JADWAL — Kalender Ketersediaan ═══ */
    .jadwal-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; }
    .jadwal-hari-card {
        background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07);
        border-radius: 0.875rem; overflow: hidden;
    }
    .jadwal-hari-card__header {
        padding: 0.75rem 1rem; display: flex; align-items: center;
        justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .jadwal-hari-card__nama { font-size: 0.8rem; font-weight: 700; color: #fff; }
    .jadwal-hari-card__tanggal { font-size: 0.65rem; color: rgba(255,255,255,0.3); }
    .jadwal-slot-list { display: flex; flex-direction: column; gap: 0; }
    .jadwal-slot {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.625rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.04);
        cursor: pointer; transition: background 0.1s;
    }
    .jadwal-slot:last-child { border-bottom: none; }
    .jadwal-slot:hover { background: rgba(255,255,255,0.03); }
    .jadwal-slot__jam { font-size: 0.8rem; font-weight: 600; color: rgba(255,255,255,0.7); }
    .jadwal-slot__toggle { position: relative; width: 2.25rem; height: 1.25rem; flex-shrink: 0; }
    .jadwal-slot__toggle input { opacity: 0; width: 0; height: 0; }
    .jadwal-slot__toggle-track {
        position: absolute; inset: 0; background: rgba(255,255,255,0.1);
        border-radius: 9999px; transition: background 0.2s; border: 1px solid rgba(255,255,255,0.1);
    }
    .jadwal-slot__toggle input:checked + .jadwal-slot__toggle-track { background: #CCFF00; border-color: #CCFF00; }
    .jadwal-slot__toggle-thumb {
        position: absolute; top: 2px; left: 2px;
        width: 17px; height: 17px; background: rgba(255,255,255,0.4);
        border-radius: 50%; transition: transform 0.2s, background 0.2s; pointer-events: none;
    }
    .jadwal-slot__toggle input:checked ~ .jadwal-slot__toggle-thumb { transform: translateX(1rem); background: #000; }
    .jadwal-slot--on .jadwal-slot__jam { color: #CCFF00; }

    /* Date picker untuk jadwal */
    .jadwal-datepicker {
        display: flex; align-items: center; gap: 0.75rem;
        margin-bottom: 1.25rem; flex-wrap: wrap;
    }
    .jadwal-datepicker label { font-size: 0.75rem; font-weight: 700; color: rgba(255,255,255,0.4); }
    .jadwal-datepicker input[type="date"] {
        padding: 0.5rem 0.875rem; background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1); border-radius: 0.625rem;
        color: #fff; font-size: 0.8rem; font-family: 'Inter', sans-serif;
        outline: none; cursor: pointer;
    }
    .jadwal-datepicker input[type="date"]:focus { border-color: rgba(204,255,0,0.4); }
    .jadwal-simpan-btn {
        padding: 0.6rem 1.5rem; background: #CCFF00; color: #000;
        border: none; border-radius: 0.625rem; font-size: 0.8rem; font-weight: 700;
        cursor: pointer; font-family: 'Inter', sans-serif; margin-top: 1.25rem;
    }
    .jadwal-simpan-btn:hover { background: #b8e600; }
    .jadwal-info-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.375rem 0.75rem; background: rgba(204,255,0,0.06);
        border: 1px solid rgba(204,255,0,0.15); border-radius: 0.5rem;
        font-size: 0.7rem; font-weight: 600; color: rgba(204,255,0,0.7);
    }

    /* ═══ BOOKING MASUK ═══ */
    .booking-filter-bar {
        display: flex; gap: 0.5rem; margin-bottom: 1.25rem; flex-wrap: wrap;
    }
    .booking-filter-btn {
        padding: 0.4rem 0.875rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 700;
        border: 1px solid rgba(255,255,255,0.1); background: transparent;
        color: rgba(255,255,255,0.4); cursor: pointer; font-family: 'Inter', sans-serif;
        transition: all 0.15s;
    }
    .booking-filter-btn:hover { border-color: rgba(255,255,255,0.3); color: #fff; }
    .booking-filter-btn--active { background: rgba(204,255,0,0.1); border-color: rgba(204,255,0,0.3); color: #CCFF00; }
    .booking-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .booking-item {
        background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07);
        border-radius: 0.875rem; padding: 1.125rem 1.25rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
    }
    .booking-item--pending { border-left: 3px solid rgba(255,200,0,0.5); }
    .booking-item--confirmed { border-left: 3px solid rgba(204,255,0,0.5); }
    .booking-item--rejected { border-left: 3px solid rgba(255,80,80,0.3); opacity: 0.6; }
    .booking-item__avatar {
        width: 2.5rem; height: 2.5rem; border-radius: 0.625rem; flex-shrink: 0;
        background: rgba(255,255,255,0.07); display: flex; align-items: center;
        justify-content: center; font-size: 0.8rem; font-weight: 700; color: #fff;
    }
    .booking-item__info { flex: 1; min-width: 140px; }
    .booking-item__nama { font-size: 0.875rem; font-weight: 700; color: #fff; margin-bottom: 0.2rem; }
    .booking-item__meta { font-size: 0.7rem; color: rgba(255,255,255,0.35); display: flex; gap: 0.75rem; flex-wrap: wrap; }
    .booking-item__meta span { display: flex; align-items: center; gap: 0.25rem; }
    .booking-item__paket {
        font-size: 0.6rem; font-weight: 700; padding: 0.2rem 0.625rem;
        border-radius: 9999px; white-space: nowrap; flex-shrink: 0;
    }
    .booking-item__paket--pro { background: rgba(204,255,0,0.1); color: #CCFF00; border: 1px solid rgba(204,255,0,0.2); }
    .booking-item__paket--basic { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.1); }
    .booking-item__paket--elite { background: rgba(255,200,0,0.1); color: #ffc107; border: 1px solid rgba(255,200,0,0.2); }
    .booking-item__payment {
        font-size: 0.65rem; font-weight: 700; padding: 0.2rem 0.625rem;
        border-radius: 9999px; white-space: nowrap; flex-shrink: 0;
    }
    .booking-item__payment--lunas { background: rgba(0,200,100,0.1); color: #00c864; border: 1px solid rgba(0,200,100,0.2); }
    .booking-item__payment--pending { background: rgba(255,200,0,0.1); color: #ffc107; border: 1px solid rgba(255,200,0,0.2); }
    .booking-item__actions { display: flex; gap: 0.5rem; flex-shrink: 0; }
    .booking-btn-confirm {
        padding: 0.5rem 1rem; background: #CCFF00; color: #000;
        border: none; border-radius: 0.5rem; font-size: 0.72rem; font-weight: 700;
        cursor: pointer; font-family: 'Inter', sans-serif; white-space: nowrap;
    }
    .booking-btn-confirm:hover { background: #b8e600; }
    .booking-btn-reject {
        padding: 0.5rem 0.875rem; background: transparent;
        border: 1px solid rgba(255,80,80,0.2); color: rgba(255,80,80,0.6);
        border-radius: 0.5rem; font-size: 0.72rem; font-weight: 700;
        cursor: pointer; font-family: 'Inter', sans-serif; white-space: nowrap;
    }
    .booking-btn-reject:hover { border-color: rgba(255,80,80,0.5); color: rgba(255,80,80,0.9); }
    .booking-status-label {
        font-size: 0.7rem; font-weight: 700; padding: 0.35rem 0.875rem;
        border-radius: 0.4rem;
    }
    .booking-status-label--confirmed { background: rgba(204,255,0,0.08); color: rgba(204,255,0,0.6); border: 1px solid rgba(204,255,0,0.15); }
    .booking-status-label--rejected { background: rgba(255,80,80,0.06); color: rgba(255,80,80,0.5); border: 1px solid rgba(255,80,80,0.12); }

    /* ═══ MODAL ═══ */
    .modal-overlay {
        display: flex; position: fixed; inset: 0; background: rgba(0,0,0,0.75);
        z-index: 999; align-items: center; justify-content: center;
        padding: 1rem; backdrop-filter: blur(6px);
    }
    .modal-overlay.hidden { display: none; }
    .modal-box {
        background: #111111; border-radius: 1.25rem;
        border: 1px solid rgba(255,255,255,0.1);
        width: 100%; max-width: 480px; padding: 2rem;
        max-height: 90vh; overflow-y: auto;
    }
    .modal-box__header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
    .modal-box__title { font-size: 1rem; font-weight: 900; color: #fff; }
    .modal-box__close {
        width: 1.75rem; height: 1.75rem; border-radius: 50%;
        background: rgba(255,255,255,0.06); border: none;
        color: rgba(255,255,255,0.5); cursor: pointer; font-size: 1rem;
        display: flex; align-items: center; justify-content: center;
    }
    .modal-form__group { margin-bottom: 1rem; }
    .modal-form__label { display: block; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.3); margin-bottom: 0.5rem; }
    .modal-form__input, .modal-form__textarea {
        width: 100%; padding: 0.75rem 0.875rem;
        background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 0.625rem; color: #fff; font-size: 0.875rem;
        font-family: 'Inter', sans-serif; outline: none;
    }
    .modal-form__input:focus, .modal-form__textarea:focus { border-color: rgba(204,255,0,0.4); }
    .modal-form__textarea { resize: vertical; min-height: 80px; }
    .modal-form__grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
    .modal-form__actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; }
    .modal-btn-cancel {
        flex: 1; padding: 0.875rem; border-radius: 0.625rem;
        border: 1px solid rgba(255,255,255,0.1); background: transparent;
        color: rgba(255,255,255,0.5); font-size: 0.875rem; font-weight: 700;
        cursor: pointer; font-family: 'Inter', sans-serif;
    }
    .trainer-btn {
        padding: 0.625rem 1.25rem; background: #CCFF00; color: #000;
        border: none; border-radius: 0.625rem; font-size: 0.8rem; font-weight: 700;
        cursor: pointer; font-family: 'Inter', sans-serif; white-space: nowrap;
    }
    .trainer-btn:hover { background: #b8e600; }

    /* ═══ EMPTY STATE ═══ */
    .empty-state {
        text-align: center; padding: 3rem 1rem;
        color: rgba(255,255,255,0.2);
    }
    .empty-state__icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
    .empty-state__text { font-size: 0.8rem; font-weight: 600; }

    /* ═══ MOBILE ═══ */
    @media (max-width: 768px) {
        body.trainer-page { flex-direction: column; }

        .trainer-sidebar {
            width: 100%; min-height: auto; height: auto;
            position: static; flex-direction: row;
            align-items: center; flex-wrap: wrap;
            padding: 1rem; gap: 0.75rem;
            border-right: none; border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .trainer-sidebar__logo { margin-bottom: 0; }
        .trainer-sidebar__subtitle { display: none; }
        .trainer-sidebar__search { width: 140px; margin-bottom: 0; flex-shrink: 0; }
        .trainer-sidebar__section-title { display: none; }
        .trainer-member-list {
            flex-direction: row; flex-wrap: nowrap;
            overflow-x: auto; gap: 0.375rem;
            flex: 1; min-width: 0; padding-bottom: 2px;
        }
        .trainer-member-item { flex-shrink: 0; }
        .trainer-member-item__paket { display: none; }
        .trainer-sidebar__footer { display: none; }

        .trainer-main { padding: 1.25rem 1rem 4rem; }
        .trainer-main__title { font-size: 1.5rem; }
        .tab-nav { width: 100%; justify-content: stretch; }
        .tab-nav__item { flex: 1; text-align: center; padding: 0.5rem 0.5rem; font-size: 0.72rem; }
        .trainer-stats { grid-template-columns: repeat(2, 1fr); }
        .modal-form__grid { grid-template-columns: 1fr; }
        .booking-item { gap: 0.75rem; }
        .jadwal-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 400px) {
        .trainer-stats { grid-template-columns: 1fr 1fr; }
        .tab-nav__item { font-size: 0.68rem; padding: 0.45rem 0.4rem; }
    }
    </style>
</head>
<body class="trainer-page">

{{-- ═══ Radio inputs untuk tab system (harus di luar sidebar/main) ═══ --}}
<input type="radio" name="trainer-tab" id="tab-progress" checked>
<input type="radio" name="trainer-tab" id="tab-booking">
<input type="radio" name="trainer-tab" id="tab-jadwal">

{{-- ═══ SIDEBAR ═══ --}}
<aside class="trainer-sidebar">
    <div class="trainer-sidebar__logo">
        <span class="trainer-sidebar__logo-text">SIBOTI</span>
    </div>
    <p class="trainer-sidebar__subtitle">Trainer Panel</p>

    <input type="text" class="trainer-sidebar__search" placeholder="Cari member..." oninput="filterMember(this.value)">

    <p class="trainer-sidebar__section-title">Member Saya</p>

    <div class="trainer-member-list" id="member-list">
        @foreach([
            ['RA','Rizky Adhitya','Paket Pro', true],
            ['NP','Nadia Pramesti','Paket Basic', false],
            ['DW','Danu Wicaksono','Paket Elite', false],
            ['SL','Sinta Lestari','Paket Pro', false],
        ] as $m)
        <a href="#" onclick="pilihMember('{{ $m[1] }}', event)"
           class="trainer-member-item {{ $m[3] ? 'trainer-member-item--active' : '' }}"
           data-nama="{{ strtolower($m[1]) }}">
            <div class="trainer-member-item__avatar">{{ $m[0] }}</div>
            <div>
                <p class="trainer-member-item__name">{{ $m[1] }}</p>
                <p class="trainer-member-item__paket">{{ $m[2] }}</p>
            </div>
        </a>
        @endforeach
    </div>

    <div class="trainer-sidebar__footer">
        <div class="trainer-sidebar__footer-avatar">CD</div>
        <div>
            <p class="trainer-sidebar__footer-name">Coach Dimas</p>
            <p class="trainer-sidebar__footer-role">Personal Trainer</p>
        </div>
    </div>
</aside>

{{-- ═══ MAIN ═══ --}}
<main class="trainer-main">

    {{-- Header --}}
    <div class="trainer-main__header">
        <div>
            <p class="trainer-main__label">Dashboard Trainer</p>
            <h1 class="trainer-main__title" id="member-title">Rizky Adhitya.</h1>
        </div>
        <button class="trainer-btn" onclick="bukaModal()">+ Tambah Progress</button>
    </div>
    <p class="trainer-main__desc">Kelola jadwal, pantau booking masuk, dan catat progress member.</p>

    {{-- Tab Nav --}}
    <nav class="tab-nav">
        <label class="tab-nav__item" for="tab-progress">Progress Member</label>
        <label class="tab-nav__item" for="tab-booking">Booking Masuk</label>
        <label class="tab-nav__item" for="tab-jadwal">Jadwal Saya</label>
    </nav>

    {{-- ══════════════════════════════════════
         TAB 1: PROGRESS MEMBER
         ══════════════════════════════════════ --}}
    <div class="tab-panel tab-panel--progress">

        {{-- Stat Cards --}}
        <div class="trainer-stats">
            @foreach([
                ['Total Sesi','2',''],
                ['Total Volume','5.1','T'],
                ['Total Durasi','75','M'],
                ['Paket','Pro',''],
            ] as $s)
            <div class="trainer-stat-card">
                <div>
                    <p class="trainer-stat-card__label">{{ $s[0] }}</p>
                    <p class="trainer-stat-card__value">{{ $s[1] }}<span class="trainer-stat-card__unit">{{ $s[2] }}</span></p>
                </div>
                <svg class="trainer-stat-card__icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            @endforeach
        </div>

        {{-- Tabel Riwayat --}}
        <div class="trainer-table-card">
            <div class="trainer-table-card__header">
                <p class="trainer-table-card__title">Riwayat Latihan</p>
                <a href="#" style="font-size:0.7rem;color:rgba(255,255,255,0.3);text-decoration:none;">Filter →</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="trainer-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Latihan</th>
                            <th>Beban</th>
                            <th>Set × Rep</th>
                            <th>Durasi</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="progress-tbody">
                        @foreach([
                            ['2025-05-20','Bench Press','100 kg','4 × 8','50m','Form rapi, naikkan beban minggu depan.'],
                            ['2025-05-24','Squat','120 kg','5 × 5','40m','Depth bagus.'],
                        ] as $r)
                        <tr>
                            <td>{{ $r[0] }}</td>
                            <td><span class="trainer-table__badge">{{ $r[1] }}</span></td>
                            <td style="color:#fff;font-weight:700;">{{ $r[2] }}</td>
                            <td>{{ $r[3] }}</td>
                            <td>{{ $r[4] }}</td>
                            <td style="max-width:180px;color:rgba(255,255,255,0.4);font-size:0.75rem;">{{ $r[5] }}</td>
                            <td>
                                <div style="display:flex;gap:0.4rem;">
                                    <button class="trainer-table__action" title="Edit" onclick="bukaModalEdit(this)">✏️</button>
                                    <button class="trainer-table__action trainer-table__action--delete" title="Hapus" onclick="hapusRow(this)">🗑</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         TAB 2: BOOKING MASUK
         ══════════════════════════════════════ --}}
    <div class="tab-panel tab-panel--booking">

        {{-- Filter bar --}}
        <div class="booking-filter-bar">
            <button class="booking-filter-btn booking-filter-btn--active" onclick="filterBooking('semua', this)">Semua</button>
            <button class="booking-filter-btn" onclick="filterBooking('pending', this)">Menunggu</button>
            <button class="booking-filter-btn" onclick="filterBooking('confirmed', this)">Dikonfirmasi</button>
            <button class="booking-filter-btn" onclick="filterBooking('rejected', this)">Ditolak</button>
        </div>

        {{-- List booking --}}
        <div class="booking-list" id="booking-list">

            {{-- Item: pending --}}
            <div class="booking-item booking-item--pending" data-status="pending">
                <div class="booking-item__avatar">RA</div>
                <div class="booking-item__info">
                    <p class="booking-item__nama">Rizky Adhitya</p>
                    <div class="booking-item__meta">
                        <span>📅 Senin, 2 Jun 2025</span>
                        <span>⏰ 08.00 & 10.00</span>
                    </div>
                </div>
                <span class="booking-item__paket booking-item__paket--pro">Paket Pro</span>
                <span class="booking-item__payment booking-item__payment--lunas">Lunas</span>
                <div class="booking-item__actions">
                    <button class="booking-btn-confirm" onclick="konfirmasiBooking(this)">✓ Konfirmasi</button>
                    <button class="booking-btn-reject" onclick="tolakBooking(this)">✕</button>
                </div>
            </div>

            {{-- Item: pending --}}
            <div class="booking-item booking-item--pending" data-status="pending">
                <div class="booking-item__avatar">NP</div>
                <div class="booking-item__info">
                    <p class="booking-item__nama">Nadia Pramesti</p>
                    <div class="booking-item__meta">
                        <span>📅 Selasa, 3 Jun 2025</span>
                        <span>⏰ 06.00</span>
                    </div>
                </div>
                <span class="booking-item__paket booking-item__paket--basic">Paket Basic</span>
                <span class="booking-item__payment booking-item__payment--pending">Belum Bayar</span>
                <div class="booking-item__actions">
                    <button class="booking-btn-confirm" onclick="konfirmasiBooking(this)">✓ Konfirmasi</button>
                    <button class="booking-btn-reject" onclick="tolakBooking(this)">✕</button>
                </div>
            </div>

            {{-- Item: confirmed --}}
            <div class="booking-item booking-item--confirmed" data-status="confirmed">
                <div class="booking-item__avatar">DW</div>
                <div class="booking-item__info">
                    <p class="booking-item__nama">Danu Wicaksono</p>
                    <div class="booking-item__meta">
                        <span>📅 Rabu, 4 Jun 2025</span>
                        <span>⏰ 16.00 & 19.00</span>
                    </div>
                </div>
                <span class="booking-item__paket booking-item__paket--elite">Paket Elite</span>
                <span class="booking-item__payment booking-item__payment--lunas">Lunas</span>
                <div class="booking-item__actions">
                    <span class="booking-status-label booking-status-label--confirmed">✓ Dikonfirmasi</span>
                </div>
            </div>

            {{-- Item: rejected --}}
            <div class="booking-item booking-item--rejected" data-status="rejected">
                <div class="booking-item__avatar">SL</div>
                <div class="booking-item__info">
                    <p class="booking-item__nama">Sinta Lestari</p>
                    <div class="booking-item__meta">
                        <span>📅 Kamis, 5 Jun 2025</span>
                        <span>⏰ 14.00</span>
                    </div>
                </div>
                <span class="booking-item__paket booking-item__paket--pro">Paket Pro</span>
                <span class="booking-item__payment booking-item__payment--lunas">Lunas</span>
                <div class="booking-item__actions">
                    <span class="booking-status-label booking-status-label--rejected">✕ Ditolak</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════
         TAB 3: JADWAL SAYA
         ══════════════════════════════════════ --}}
    <div class="tab-panel tab-panel--jadwal">

        {{-- Date picker --}}
        <div class="trainer-card">
            <p class="trainer-card__title">Atur Ketersediaan Sesi</p>

            <div class="jadwal-datepicker">
                <label>Pilih Tanggal:</label>
                <input type="date" id="jadwal-date" value="{{ date('Y-m-d') }}" onchange="gantiTanggalJadwal(this.value)">
                <span class="jadwal-info-badge">
                    <span id="jadwal-aktif-count">0</span> slot aktif
                </span>
            </div>

            {{-- Grid slot per hari --}}
            <div class="jadwal-grid" id="jadwal-grid">
                {{-- Di-generate JS berdasarkan tanggal yang dipilih --}}
            </div>

            <button class="jadwal-simpan-btn" onclick="simpanJadwal()">Simpan Jadwal</button>
        </div>

        {{-- Ringkasan jadwal tersimpan --}}
        <div class="trainer-card">
            <p class="trainer-card__title">Jadwal Tersimpan</p>
            <div id="jadwal-tersimpan-list">
                <div class="empty-state">
                    <div class="empty-state__icon">📭</div>
                    <p class="empty-state__text">Belum ada jadwal tersimpan</p>
                </div>
            </div>
        </div>

    </div>

</main>

{{-- ═══ MODAL TAMBAH PROGRESS ═══ --}}
<div class="modal-overlay hidden" id="modal-tambah">
    <div class="modal-box">
        <div class="modal-box__header">
            <p class="modal-box__title" id="modal-title">Tambah Progress</p>
            <button class="modal-box__close" onclick="tutupModal()">✕</button>
        </div>
        <form class="modal-form" id="progress-form" onsubmit="submitProgress(event)">
            @csrf
            <input type="hidden" id="edit-index" value="">
            <div class="modal-form__group">
                <label class="modal-form__label">Tanggal</label>
                <input type="date" class="modal-form__input" id="f-tanggal" value="{{ date('Y-m-d') }}">
            </div>
            <div class="modal-form__group">
                <label class="modal-form__label">Latihan</label>
                <input type="text" class="modal-form__input" id="f-latihan" placeholder="c/h: Bench Press">
            </div>
            <div class="modal-form__grid">
                <div class="modal-form__group">
                    <label class="modal-form__label">Beban (KG)</label>
                    <input type="number" class="modal-form__input" id="f-beban" placeholder="0">
                </div>
                <div class="modal-form__group">
                    <label class="modal-form__label">Durasi (Menit)</label>
                    <input type="number" class="modal-form__input" id="f-durasi" placeholder="30">
                </div>
            </div>
            <div class="modal-form__grid">
                <div class="modal-form__group">
                    <label class="modal-form__label">Set</label>
                    <input type="number" class="modal-form__input" id="f-set" placeholder="3">
                </div>
                <div class="modal-form__group">
                    <label class="modal-form__label">Rep</label>
                    <input type="number" class="modal-form__input" id="f-rep" placeholder="10">
                </div>
            </div>
            <div class="modal-form__group">
                <label class="modal-form__label">Catatan Trainer</label>
                <textarea class="modal-form__textarea" id="f-catatan" placeholder="Form, postur, target minggu depan..."></textarea>
            </div>
            <div class="modal-form__actions">
                <button type="button" class="modal-btn-cancel" onclick="tutupModal()">Batal</button>
                <button type="submit" class="trainer-btn">+ Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
/* ════════════════════════════════════════
   CONFIG
   ════════════════════════════════════════ */
const JAM_SLOTS = ['06.00','08.00','10.00','14.00','16.00','19.00'];

/* ════ Member ════ */
function pilihMember(nama, e) {
    e.preventDefault();
    document.getElementById('member-title').textContent = nama + '.';
    document.querySelectorAll('.trainer-member-item').forEach(el => el.classList.remove('trainer-member-item--active'));
    e.currentTarget.classList.add('trainer-member-item--active');
    /* TODO: fetch data progress & stat per member dari backend */
}

function filterMember(q) {
    document.querySelectorAll('.trainer-member-item').forEach(el => {
        const nama = el.dataset.nama || '';
        el.style.display = nama.includes(q.toLowerCase()) ? '' : 'none';
    });
}

/* ════ Modal Progress ════ */
function bukaModal() {
    document.getElementById('modal-title').textContent = 'Tambah Progress';
    document.getElementById('edit-index').value = '';
    document.getElementById('progress-form').reset();
    document.getElementById('f-tanggal').value = new Date().toISOString().split('T')[0];
    document.getElementById('modal-tambah').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function bukaModalEdit(btn) {
    const row = btn.closest('tr');
    const cells = row.querySelectorAll('td');
    document.getElementById('modal-title').textContent = 'Edit Progress';
    document.getElementById('f-tanggal').value = cells[0].textContent;
    document.getElementById('f-latihan').value = cells[1].querySelector('.trainer-table__badge').textContent;
    document.getElementById('f-beban').value = cells[2].textContent.replace(' kg','');
    const setRep = cells[3].textContent.split(' × ');
    document.getElementById('f-set').value = setRep[0];
    document.getElementById('f-rep').value = setRep[1];
    document.getElementById('f-durasi').value = cells[4].textContent.replace('m','');
    document.getElementById('f-catatan').value = cells[5].textContent;
    /* Simpan referensi row untuk update */
    document.getElementById('edit-index').value = Array.from(row.parentNode.children).indexOf(row);
    document.getElementById('modal-tambah').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function tutupModal() {
    document.getElementById('modal-tambah').classList.add('hidden');
    document.body.style.overflow = '';
}

function submitProgress(e) {
    e.preventDefault();
    const tanggal  = document.getElementById('f-tanggal').value;
    const latihan  = document.getElementById('f-latihan').value;
    const beban    = document.getElementById('f-beban').value;
    const durasi   = document.getElementById('f-durasi').value;
    const set      = document.getElementById('f-set').value;
    const rep      = document.getElementById('f-rep').value;
    const catatan  = document.getElementById('f-catatan').value;
    const editIdx  = document.getElementById('edit-index').value;

    if(!latihan){ showToast('Isi nama latihan terlebih dahulu!'); return; }

    const tbody = document.getElementById('progress-tbody');
    const rowHtml = `
        <tr>
            <td>${tanggal}</td>
            <td><span class="trainer-table__badge">${latihan}</span></td>
            <td style="color:#fff;font-weight:700;">${beban} kg</td>
            <td>${set} × ${rep}</td>
            <td>${durasi}m</td>
            <td style="max-width:180px;color:rgba(255,255,255,0.4);font-size:0.75rem;">${catatan}</td>
            <td>
                <div style="display:flex;gap:0.4rem;">
                    <button class="trainer-table__action" title="Edit" onclick="bukaModalEdit(this)">✏️</button>
                    <button class="trainer-table__action trainer-table__action--delete" title="Hapus" onclick="hapusRow(this)">🗑</button>
                </div>
            </td>
        </tr>`;

    if(editIdx !== '') {
        /* Update row yang ada */
        tbody.rows[parseInt(editIdx)].outerHTML = rowHtml;
        showToast('Progress diperbarui!', true);
    } else {
        /* Tambah row baru */
        tbody.insertAdjacentHTML('afterbegin', rowHtml);
        showToast('Progress ditambahkan!', true);
    }
    /* TODO: kirim ke backend via fetch/axios */
    tutupModal();
}

function hapusRow(btn) {
    if(!confirm('Hapus data ini?')) return;
    btn.closest('tr').remove();
    showToast('Data dihapus.');
    /* TODO: kirim delete request ke backend */
}

/* ════ Booking Filter ════ */
function filterBooking(status, btn) {
    document.querySelectorAll('.booking-filter-btn').forEach(b => b.classList.remove('booking-filter-btn--active'));
    btn.classList.add('booking-filter-btn--active');
    document.querySelectorAll('.booking-item').forEach(item => {
        item.style.display = (status === 'semua' || item.dataset.status === status) ? '' : 'none';
    });
}

function konfirmasiBooking(btn) {
    const item = btn.closest('.booking-item');
    item.classList.remove('booking-item--pending');
    item.classList.add('booking-item--confirmed');
    item.dataset.status = 'confirmed';
    const actionsEl = item.querySelector('.booking-item__actions');
    actionsEl.innerHTML = '<span class="booking-status-label booking-status-label--confirmed">✓ Dikonfirmasi</span>';
    showToast('Booking dikonfirmasi!', true);
    /* TODO: PATCH /api/bookings/{id}/confirm */
}

function tolakBooking(btn) {
    if(!confirm('Tolak booking ini?')) return;
    const item = btn.closest('.booking-item');
    item.classList.remove('booking-item--pending');
    item.classList.add('booking-item--rejected');
    item.dataset.status = 'rejected';
    item.style.opacity = '0.6';
    const actionsEl = item.querySelector('.booking-item__actions');
    actionsEl.innerHTML = '<span class="booking-status-label booking-status-label--rejected">✕ Ditolak</span>';
    showToast('Booking ditolak.');
    /* TODO: PATCH /api/bookings/{id}/reject */
}

/* ════ Jadwal Ketersediaan ════ */
let jadwalState = {}; /* { 'YYYY-MM-DD': { '06.00': true, ... } } */

function gantiTanggalJadwal(tgl) {
    renderJadwalGrid(tgl);
}

function renderJadwalGrid(tgl) {
    if(!jadwalState[tgl]) jadwalState[tgl] = {};
    const hariNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const d = new Date(tgl);
    const namaHari = hariNames[d.getDay()];
    const tanggalFmt = d.getDate() + '/' + (d.getMonth()+1) + '/' + d.getFullYear();

    let slotHtml = JAM_SLOTS.map(jam => {
        const isOn = jadwalState[tgl][jam] || false;
        return `
        <div class="jadwal-slot ${isOn ? 'jadwal-slot--on' : ''}" onclick="toggleSlot('${tgl}','${jam}',this)">
            <span class="jadwal-slot__jam">${jam}</span>
            <label class="jadwal-slot__toggle" onclick="event.stopPropagation()">
                <input type="checkbox" ${isOn ? 'checked' : ''} onchange="toggleSlot('${tgl}','${jam}',this.closest('.jadwal-slot'))">
                <span class="jadwal-slot__toggle-track"></span>
                <span class="jadwal-slot__toggle-thumb"></span>
            </label>
        </div>`;
    }).join('');

    document.getElementById('jadwal-grid').innerHTML = `
        <div class="jadwal-hari-card">
            <div class="jadwal-hari-card__header">
                <span class="jadwal-hari-card__nama">${namaHari}</span>
                <span class="jadwal-hari-card__tanggal">${tanggalFmt}</span>
            </div>
            <div class="jadwal-slot-list">${slotHtml}</div>
        </div>`;

    updateAktifCount(tgl);
}

function toggleSlot(tgl, jam, slotEl) {
    if(!jadwalState[tgl]) jadwalState[tgl] = {};
    jadwalState[tgl][jam] = !jadwalState[tgl][jam];
    const isOn = jadwalState[tgl][jam];
    slotEl.classList.toggle('jadwal-slot--on', isOn);
    const cb = slotEl.querySelector('input[type=checkbox]');
    if(cb) cb.checked = isOn;
    updateAktifCount(tgl);
}

function updateAktifCount(tgl) {
    const count = Object.values(jadwalState[tgl] || {}).filter(Boolean).length;
    document.getElementById('jadwal-aktif-count').textContent = count;
}

function simpanJadwal() {
    const tgl = document.getElementById('jadwal-date').value;
    const slots = jadwalState[tgl] || {};
    const aktif = JAM_SLOTS.filter(j => slots[j]);

    if(aktif.length === 0) { showToast('Pilih minimal 1 slot waktu!'); return; }

    /* TODO: POST /api/trainer/jadwal { tanggal: tgl, slots: aktif } */

    /* Update ringkasan tersimpan */
    tampilkanJadwalTersimpan(tgl, aktif);
    showToast('Jadwal disimpan!', true);
}

let jadwalTersimpan = [];

function tampilkanJadwalTersimpan(tgl, slots) {
    /* Cek apakah tanggal sudah ada, update jika ada */
    const existing = jadwalTersimpan.findIndex(j => j.tgl === tgl);
    if(existing >= 0) jadwalTersimpan[existing].slots = slots;
    else jadwalTersimpan.unshift({ tgl, slots });

    const hariNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const list = document.getElementById('jadwal-tersimpan-list');

    list.innerHTML = jadwalTersimpan.map(item => {
        const d = new Date(item.tgl);
        const label = hariNames[d.getDay()] + ', ' + d.getDate() + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
        return `
        <div style="display:flex;align-items:center;justify-content:space-between;padding:0.875rem 0;border-bottom:1px solid rgba(255,255,255,0.05);flex-wrap:wrap;gap:0.5rem;">
            <div>
                <p style="font-size:0.8rem;font-weight:700;color:#fff;margin-bottom:0.25rem;">${label}</p>
                <p style="font-size:0.7rem;color:#CCFF00;">${item.slots.join(' · ')}</p>
            </div>
            <span style="font-size:0.65rem;background:rgba(204,255,0,0.08);color:rgba(204,255,0,0.6);padding:0.2rem 0.625rem;border-radius:9999px;border:1px solid rgba(204,255,0,0.15);">
                ${item.slots.length} slot
            </span>
        </div>`;
    }).join('');
}

/* ════ Modal klik luar ════ */
document.getElementById('modal-tambah').addEventListener('click', function(e) {
    if(e.target === this) tutupModal();
});

/* ════ Toast ════ */
function showToast(msg, success=false) {
    const existing = document.getElementById('toast-notif');
    if(existing) existing.remove();
    const toast = document.createElement('div');
    toast.id = 'toast-notif';
    toast.style.cssText = 'position:fixed;bottom:1.5rem;left:50%;transform:translateX(-50%);z-index:9999;background:'+(success?'#CCFF00':'#1a1a1a')+';color:'+(success?'#000':'#fff')+';padding:0.75rem 1.25rem;border-radius:0.75rem;font-size:0.75rem;font-weight:700;white-space:pre-line;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);border:1px solid '+(success?'#CCFF00':'rgba(255,255,255,0.1)')+';font-family:Inter,sans-serif;';
    toast.textContent = msg;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

/* ════ Init ════ */
document.addEventListener('DOMContentLoaded', function() {
    const todayVal = document.getElementById('jadwal-date').value;
    renderJadwalGrid(todayVal);
});
</script>

</body>
</html>