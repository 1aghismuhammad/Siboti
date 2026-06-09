<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Trainer — Siboti</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    
    <!-- Anggap file CSS ini ada dari framework/aset utamamu -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.0">
    <style>
    /* ═══════════════════════════════════════
       PREMIUM TRAINER DASHBOARD UI
       ═══════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    /* Custom Scrollbar Premium */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
    ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(204,255,0,0.5); }
    body.trainer-page {
        background: #050505; /* Lebih gelap dari admin, fokus ke konten */
        color: rgba(255,255,255,0.7);
        font-family: 'Inter', sans-serif;
        font-size: 0.875rem;
        min-height: 100vh;
        display: flex;
        overflow-x: hidden;
    }
    /* ═══════════════════════════════════════
       TAB SYSTEM — Pure CSS
       ═══════════════════════════════════════ */
    #tab-jadwal, #tab-booking, #tab-progress { display: none; }
    .tab-panel { display: none; animation: fadeIn 0.4s ease forwards; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    #tab-jadwal:checked  ~ .trainer-main .tab-panel--jadwal,
    #tab-booking:checked ~ .trainer-main .tab-panel--booking,
    #tab-progress:checked ~ .trainer-main .tab-panel--progress { display: block; }
    #tab-jadwal:checked  ~ .trainer-main .tab-nav__item[for="tab-jadwal"],
    #tab-booking:checked ~ .trainer-main .tab-nav__item[for="tab-booking"],
    #tab-progress:checked ~ .trainer-main .tab-nav__item[for="tab-progress"] {
        color: #000; background: #CCFF00; box-shadow: 0 4px 15px rgba(204,255,0,0.2);
    }
    /* ═══ SIDEBAR (MEMBER SELECTOR) ═══ */
    .trainer-sidebar {
        width: 280px;
        background: #0a0a0a;
        border-right: 1px solid rgba(255,255,255,0.05);
        display: flex; flex-direction: column;
        position: sticky; top: 0; height: 100vh;
        overflow: hidden; flex-shrink: 0; z-index: 50;
    }
    
    .trainer-sidebar__header {
        padding: 1.75rem 1.5rem 1rem;
        background: linear-gradient(180deg, #0a0a0a 60%, rgba(10,10,10,0) 100%);
        z-index: 2;
    }
    .trainer-sidebar__logo { margin-bottom: 0.25rem; display: flex; align-items: center; justify-content: space-between;}
    .trainer-sidebar__logo-text { font-size: 1.5rem; font-weight: 900; color: #fff; letter-spacing: -0.03em; }
    .trainer-sidebar__subtitle { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #CCFF00; margin-bottom: 1.5rem; }
    
    .trainer-sidebar__search-wrap { position: relative; margin-bottom: 1.5rem; }
    .trainer-sidebar__search {
        width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08); border-radius: 0.75rem;
        color: #fff; font-size: 0.8rem; font-family: inherit; transition: all 0.25s;
    }
    .trainer-sidebar__search:focus { border-color: #CCFF00; background: rgba(204,255,0,0.02); box-shadow: 0 0 0 3px rgba(204,255,0,0.1); outline: none; }
    .trainer-sidebar__search-icon { position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); font-size: 1rem; color: rgba(255,255,255,0.3); }
    .trainer-sidebar__section-title { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.3); margin-bottom: 0.75rem; padding: 0 1.5rem; }
    
    .trainer-member-list {
        display: flex; flex-direction: column; gap: 0.4rem;
        flex: 1; overflow-y: auto; padding: 0 1rem 1rem;
    }
    
    .trainer-member-item {
        display: flex; align-items: center; gap: 0.875rem;
        padding: 0.75rem; border-radius: 0.75rem;
        text-decoration: none; border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    .trainer-member-item:hover { background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.05); transform: translateX(4px); }
    .trainer-member-item--active { background: rgba(204,255,0,0.05); border-color: rgba(204,255,0,0.15); transform: translateX(4px); }
    
    .trainer-member-item__avatar {
        width: 2.25rem; height: 2.25rem; border-radius: 0.6rem;
        background: rgba(255,255,255,0.05); display: flex; align-items: center;
        justify-content: center; font-size: 0.75rem; font-weight: 700; color: #fff; flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .trainer-member-item--active .trainer-member-item__avatar { background: #CCFF00; color: #000; box-shadow: 0 4px 10px rgba(204,255,0,0.2); }
    
    .trainer-member-item__info { flex: 1; min-width: 0; }
    .trainer-member-item__name { font-size: 0.85rem; font-weight: 700; color: #fff; margin-bottom: 0.15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .trainer-member-item__paket { font-size: 0.65rem; color: rgba(255,255,255,0.4); }
    .trainer-member-item--active .trainer-member-item__name { color: #CCFF00; }
    .trainer-sidebar__footer {
        padding: 1.25rem 1.5rem; background: rgba(255,255,255,0.02);
        border-top: 1px solid rgba(255,255,255,0.05);
        display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;
    }
    .trainer-sidebar__footer-user { display: flex; align-items: center; gap: 0.75rem; }
    .trainer-sidebar__footer-avatar {
        width: 2.25rem; height: 2.25rem; border-radius: 50%;
        background: #111; display: flex; align-items: center;
        justify-content: center; font-size: 0.75rem; font-weight: 700; color: #CCFF00; border: 1px solid rgba(204,255,0,0.2);
    }
    .trainer-sidebar__footer-name { font-size: 0.8rem; font-weight: 700; color: #fff; margin-bottom: 0.1rem;}
    .trainer-sidebar__footer-role { font-size: 0.65rem; color: rgba(255,255,255,0.3); }
    
    .logout-btn { background: none; border: none; color: rgba(255,100,100,0.6); display: flex; align-items: center; justify-content: center; cursor: pointer; padding: 0.4rem; border-radius: 0.4rem; transition: all 0.2s; }
    .logout-btn:hover { color: #ff5050; background: rgba(255,80,80,0.1); }
    
    .trainer-member-item__delete {
        position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%);
        background: rgba(255,80,80,0.1); border: 1px solid rgba(255,80,80,0.2);
        color: #ff5050; width: 24px; height: 24px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: all 0.2s; cursor: pointer;
    }
    .trainer-member-item:hover .trainer-member-item__delete { opacity: 1; }
    .trainer-member-item__delete:hover { background: rgba(255,80,80,0.2); color: #ff8080; }
    /* ═══ MAIN AREA ═══ */
    .trainer-main {
        flex: 1; padding: 2.5rem 3rem 4rem;
        min-width: 0; height: 100vh; overflow-y: auto;
    }
    
    .trainer-main__header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 1.5rem; margin-bottom: 0.5rem; flex-wrap: wrap;
    }
    .trainer-main__label { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #CCFF00; margin-bottom: 0.5rem; }
    .trainer-main__title { font-size: 2.25rem; font-weight: 900; color: #fff; letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 0.25rem; }
    .trainer-main__desc { font-size: 0.85rem; color: rgba(255,255,255,0.4); margin-bottom: 2rem; max-width: 600px; line-height: 1.5; }
    /* ═══ TAB NAV ═══ */
    .tab-nav-wrapper { margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0; display: flex; gap: 1.5rem; overflow-x: auto;}
    .tab-nav__item {
        padding: 0 0 1rem 0; font-size: 0.85rem; font-weight: 700; cursor: pointer;
        color: rgba(255,255,255,0.4); border-bottom: 2px solid transparent;
        transition: all 0.25s; user-select: none; white-space: nowrap;
    }
    .tab-nav__item:hover { color: #fff; }
    /* ═══ STAT CARDS ═══ */
    .trainer-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px,1fr)); gap: 1rem; margin-bottom: 2rem; }
    .trainer-stat-card {
        background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem; padding: 1.25rem 1.5rem;
        display: flex; align-items: flex-start; justify-content: space-between;
        transition: all 0.3s ease;
    }
    .trainer-stat-card:hover { background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.1); transform: translateY(-3px); }
    .trainer-stat-card__label { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.3); margin-bottom: 0.5rem; }
    .trainer-stat-card__value { font-size: 1.75rem; font-weight: 900; color: #fff; letter-spacing: -0.03em; line-height: 1; }
    .trainer-stat-card__unit { font-size: 0.8rem; font-weight: 700; color: rgba(255,255,255,0.4); margin-left: 0.25rem; }
    .trainer-stat-card__icon { width: 2.25rem; height: 2.25rem; display: flex; align-items: center; justify-content: center; background: rgba(204,255,0,0.05); border-radius: 0.6rem; color: #CCFF00; font-size: 1.1rem; }
    /* ═══ CARD WRAPPER ═══ */
    .trainer-card {
        background: #0a0a0a; border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1.25rem; padding: 1.75rem; margin-bottom: 1.5rem;
    }
    .trainer-card__header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;}
    .trainer-card__title { font-size: 1rem; font-weight: 800; color: #fff; }
    /* ═══ TABEL (Scrollable with shadow hint) ═══ */
    .trainer-table-wrap { position: relative; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05); overflow: hidden;}
    .trainer-table-scroll { overflow-x: auto; width: 100%; background: #0a0a0a; }
    
    .trainer-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; min-width: 700px;}
    .trainer-table th {
        padding: 1rem 1.25rem; text-align: left; background: rgba(255,255,255,0.02);
        font-size: 0.65rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
        color: rgba(255,255,255,0.4); border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .trainer-table td { padding: 1.125rem 1.25rem; color: rgba(255,255,255,0.6); border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }
    .trainer-table tr:hover td { background: rgba(255,255,255,0.015); }
    .trainer-table__badge {
        display: inline-block; padding: 0.3rem 0.75rem;
        background: rgba(204,255,0,0.08); color: #CCFF00;
        border-radius: 9999px; font-size: 0.7rem; font-weight: 700;
        border: 1px solid rgba(204,255,0,0.15);
    }
    .trainer-table__action {
        width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);
        color: rgba(255,255,255,0.6); cursor: pointer; transition: all 0.2s; font-size: 0.8rem; margin-right: 0.25rem;
    }
    .trainer-table__action:hover { background: rgba(255,255,255,0.1); color: #fff; }
    .trainer-table__action--delete:hover { background: rgba(255,80,80,0.1); border-color: rgba(255,80,80,0.2); color: #ff5050;}
    /* ═══ BUTTONS ═══ */
    .trainer-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
        padding: 0.75rem 1.5rem; background: #CCFF00; color: #000;
        border: none; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 700;
        cursor: pointer; font-family: 'Inter', sans-serif; white-space: nowrap;
        transition: all 0.25s ease; box-shadow: 0 4px 15px rgba(204,255,0,0.1);
    }
    .trainer-btn:hover { background: #b8e600; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(204,255,0,0.2); }
    
    .trainer-btn-outline {
        background: transparent; color: rgba(255,255,255,0.8);
        border: 1px solid rgba(255,255,255,0.15); box-shadow: none;
    }
    .trainer-btn-outline:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.3); color: #fff; transform: translateY(-2px); }
    /* ═══ BOOKING LIST ═══ */
    .booking-filter-bar { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .booking-filter-btn {
        padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;
        border: 1px solid rgba(255,255,255,0.1); background: transparent;
        color: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.2s;
    }
    .booking-filter-btn:hover { border-color: rgba(255,255,255,0.3); color: #fff; }
    .booking-filter-btn--active { background: rgba(204,255,0,0.1); border-color: rgba(204,255,0,0.3); color: #CCFF00; }
    
    .booking-list { display: flex; flex-direction: column; gap: 0.875rem; }
    .booking-item {
        background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem; padding: 1.25rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;
        transition: border-color 0.3s;
    }
    .booking-item:hover { border-color: rgba(255,255,255,0.1); }
    .booking-item--pending { border-left: 4px solid #ffc107; }
    .booking-item--confirmed { border-left: 4px solid #CCFF00; }
    .booking-item--rejected { border-left: 4px solid #ff5050; opacity: 0.6; }
    
    .booking-item__left { display: flex; align-items: center; gap: 1rem; flex: 1; min-width: 200px;}
    .booking-item__avatar {
        width: 3rem; height: 3rem; border-radius: 0.75rem; flex-shrink: 0;
        background: rgba(255,255,255,0.05); display: flex; align-items: center;
        justify-content: center; font-size: 0.9rem; font-weight: 700; color: #fff; border: 1px solid rgba(255,255,255,0.08);
    }
    .booking-item__info { flex: 1; }
    .booking-item__nama { font-size: 0.95rem; font-weight: 800; color: #fff; margin-bottom: 0.25rem; }
    .booking-item__meta { font-size: 0.75rem; color: rgba(255,255,255,0.4); display: flex; gap: 1rem; flex-wrap: wrap; }
    .booking-item__meta span { display: flex; align-items: center; gap: 0.35rem; }
    
    .booking-item__center { display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-start; min-width: 120px;}
    .booking-item__badge {
        font-size: 0.65rem; font-weight: 700; padding: 0.25rem 0.75rem;
        border-radius: 9999px; white-space: nowrap; border: 1px solid transparent;
    }
    .badge--pro { background: rgba(204,255,0,0.1); color: #CCFF00; border-color: rgba(204,255,0,0.2); }
    .badge--basic { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.6); border-color: rgba(255,255,255,0.1); }
    .badge--lunas { background: rgba(0,200,100,0.1); color: #00c864; border-color: rgba(0,200,100,0.2); }
    .badge--pending { background: rgba(255,200,0,0.1); color: #ffc107; border-color: rgba(255,200,0,0.2); }
    
    .booking-item__actions { display: flex; gap: 0.5rem; flex-shrink: 0; }
    .booking-btn-confirm {
        padding: 0.6rem 1.25rem; background: #CCFF00; color: #000;
        border: none; border-radius: 0.6rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s;
    }
    .booking-btn-confirm:hover { background: #b8e600; }
    .booking-btn-reject {
        padding: 0.6rem 1rem; background: transparent;
        border: 1px solid rgba(255,80,80,0.2); color: rgba(255,80,80,0.8);
        border-radius: 0.6rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s;
    }
    .booking-btn-reject:hover { background: rgba(255,80,80,0.1); border-color: rgba(255,80,80,0.5); }
    .booking-status-label { font-size: 0.75rem; font-weight: 700; padding: 0.5rem 1rem; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem;}
    .booking-status-label--confirmed { background: rgba(204,255,0,0.08); color: #CCFF00; border: 1px solid rgba(204,255,0,0.15); }
    .booking-status-label--rejected { background: rgba(255,80,80,0.08); color: #ff5050; border: 1px solid rgba(255,80,80,0.15); }
    /* ═══ JADWAL ═══ */
    .jadwal-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;}
    .jadwal-datepicker { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .jadwal-datepicker input[type="date"] {
        padding: 0.75rem 1rem; background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem;
        color: #fff; font-size: 0.85rem; font-family: 'Inter', sans-serif;
        outline: none; cursor: pointer; transition: border-color 0.2s;
    }
    .jadwal-datepicker input[type="date"]:focus { border-color: #CCFF00; }
    
    .jadwal-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;}
    .jadwal-hari-card {
        background: rgba(255,255,255,0.015); border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem; overflow: hidden;
    }
    .jadwal-hari-card__header {
        padding: 1rem 1.25rem; display: flex; align-items: center;
        justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05);
        background: rgba(255,255,255,0.01);
    }
    .jadwal-hari-card__nama { font-size: 0.85rem; font-weight: 800; color: #fff; }
    .jadwal-hari-card__tanggal { font-size: 0.7rem; color: rgba(255,255,255,0.4); }
    
    .jadwal-slot {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.75rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.03);
        cursor: pointer; transition: background 0.2s;
    }
    .jadwal-slot:last-child { border-bottom: none; }
    .jadwal-slot:hover { background: rgba(255,255,255,0.03); }
    .jadwal-slot__jam { font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.6); transition: color 0.2s;}
    .jadwal-slot--on .jadwal-slot__jam { color: #CCFF00; font-weight: 700; }
    
    /* Toggle Switch Premium */
    .toggle-switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; cursor: pointer; inset: 0;
        background: rgba(255,255,255,0.1); border-radius: 34px; transition: .3s;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .toggle-slider:before {
        position: absolute; content: ""; height: 18px; width: 18px;
        left: 2px; bottom: 2px; background: rgba(255,255,255,0.5);
        border-radius: 50%; transition: .3s; box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .toggle-switch input:checked + .toggle-slider { background: #CCFF00; border-color: #CCFF00; }
    .toggle-switch input:checked + .toggle-slider:before { transform: translateX(20px); background: #000; }
    /* ═══ MODAL ═══ */
    .modal-overlay {
        display: flex; position: fixed; inset: 0; background: rgba(0,0,0,0.8);
        z-index: 1000; align-items: center; justify-content: center;
        padding: 1rem; backdrop-filter: blur(8px); opacity: 0; pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .modal-overlay.is-open { opacity: 1; pointer-events: auto; }
    .modal-box {
        background: #0a0a0a; border-radius: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
        width: 100%; max-width: 500px; padding: 2.5rem;
        max-height: 90vh; overflow-y: auto; transform: translateY(20px);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .modal-overlay.is-open .modal-box { transform: translateY(0); }
    
    .modal-box__header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; }
    .modal-box__title { font-size: 1.25rem; font-weight: 900; color: #fff; }
    .modal-box__close {
        width: 2rem; height: 2rem; border-radius: 50%;
        background: rgba(255,255,255,0.05); border: none;
        color: rgba(255,255,255,0.6); cursor: pointer; font-size: 1.25rem;
        display: flex; align-items: center; justify-content: center; transition: all 0.2s;
    }
    .modal-box__close:hover { background: rgba(255,255,255,0.1); color: #fff; }
    
    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.4); margin-bottom: 0.6rem; }
    .form-control {
        width: 100%; padding: 0.875rem 1rem;
        background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 0.75rem; color: #fff; font-size: 0.875rem;
        font-family: inherit; outline: none; transition: all 0.2s;
    }
    .form-control:focus { border-color: #CCFF00; background: rgba(204,255,0,0.02); }
    textarea.form-control { resize: vertical; min-height: 100px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-actions { display: flex; gap: 1rem; margin-top: 2rem; }
    
    /* Toast */
    #toast-container { position: fixed; bottom: 2rem; left: 50%; transform: translateX(-50%); z-index: 9999; display: flex; flex-direction: column; gap: 0.5rem; pointer-events: none;}
    .toast { background: #CCFF00; color: #000; padding: 0.875rem 1.5rem; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 700; box-shadow: 0 10px 30px rgba(0,0,0,0.3); animation: toastIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
    @keyframes toastIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    /* ═══════════════════════════════════════════
       RESPONSIVE DESIGN (MOBILE & TABLET)
       ═══════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .trainer-sidebar { width: 240px; }
        .trainer-main { padding: 2rem; }
    }
    @media (max-width: 768px) {
        body.trainer-page { flex-direction: column; }
        
        /* Sidebar berubah jadi Top Sticky Header & Horizontal Member List */
        .trainer-sidebar {
            width: 100%; height: auto; min-height: 0; border-right: none;
            border-bottom: 1px solid rgba(255,255,255,0.05); z-index: 100;
            background: rgba(10,10,10,0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        }
        
        .trainer-sidebar__header {
            padding: 1rem 1.25rem 0.5rem; background: none;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        }
        .trainer-sidebar__subtitle { display: none; }
        .trainer-sidebar__logo { margin-bottom: 0; }
        .trainer-sidebar__logo-text { font-size: 1.25rem; }
        
        .trainer-sidebar__search-wrap { margin-bottom: 0; flex: 1; max-width: 200px;}
        .trainer-sidebar__search { padding: 0.6rem 0.8rem 0.6rem 2.2rem; font-size: 0.75rem;}
        
        .trainer-sidebar__section-title { display: none; }
        .trainer-sidebar__footer { display: none; } /* Sembunyikan profil trainer di header hp */
        
        /* Horizontal Member Scroll */
        .trainer-member-list {
            flex-direction: row; padding: 0.5rem 1.25rem 1rem; overflow-x: auto;
            overflow-y: hidden; gap: 0.5rem; flex: unset; align-items: center;
            /* Hide scrollbar for cleaner look on mobile */
            -ms-overflow-style: none; scrollbar-width: none;
        }
        .trainer-member-list::-webkit-scrollbar { display: none; }
        
        .trainer-member-item {
            flex-shrink: 0; padding: 0.5rem 0.75rem; border-radius: 9999px; /* Pill shape on mobile */
            border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.03);
        }
        .trainer-member-item--active { border-color: #CCFF00; background: rgba(204,255,0,0.1); transform: none;}
        .trainer-member-item__avatar { width: 1.75rem; height: 1.75rem; font-size: 0.65rem; border-radius: 50%;}
        .trainer-member-item__name { font-size: 0.75rem; margin-bottom: 0;}
        .trainer-member-item__paket { display: none; } /* Hide paket on mobile pills */
        /* Main Content Adjustments */
        .trainer-main { padding: 1.5rem 1.25rem 4rem; overflow-y: visible; height: auto;}
        .trainer-main__title { font-size: 1.75rem; }
        .trainer-main__header { flex-direction: column; gap: 1rem; align-items: flex-start;}
        .trainer-main__desc { margin-bottom: 1.5rem; }
        .trainer-btn { width: 100%; justify-content: center; } /* Full width button on mobile */
        .tab-nav-wrapper { margin-bottom: 1.5rem; gap: 1rem; }
        .tab-nav__item { font-size: 0.8rem; padding: 0 0 0.75rem 0; }
        
        .trainer-stats { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
        .trainer-stat-card { padding: 1rem; }
        .trainer-stat-card__value { font-size: 1.25rem; }
        
        .trainer-card { padding: 1.25rem; }
        .booking-item { flex-direction: column; align-items: flex-start; gap: 1.25rem; }
        .booking-item__left { width: 100%; }
        .booking-item__center { flex-direction: row; width: 100%; }
        .booking-item__actions { width: 100%; }
        .booking-item__actions button, .booking-item__actions span { flex: 1; text-align: center; justify-content: center;}
        
        .form-grid { grid-template-columns: 1fr; }
        .modal-box { padding: 1.5rem; margin: 1rem; }
    }
    
    @media (max-width: 480px) {
        .trainer-sidebar__search-wrap { display: none; } /* Sembunyikan search jika layar terlalu kecil, fokus ke list */
    }
    </style>
</head>
<body class="trainer-page">
{{-- ═══ Radio inputs untuk tab system (tanpa JS) ═══ --}}
<input type="radio" name="trainer-tab" id="tab-progress" checked>
<input type="radio" name="trainer-tab" id="tab-booking">
<input type="radio" name="trainer-tab" id="tab-jadwal">
{{-- ═══ SIDEBAR (MEMBER SELECTOR & STICKY HEADER) ═══ --}}
<aside class="trainer-sidebar">
    <div class="trainer-sidebar__header">
        <div class="trainer-sidebar__logo">
            <div>
                <span class="trainer-sidebar__logo-text">SIBOTI</span>
                <p class="trainer-sidebar__subtitle">Trainer Panel</p>
            </div>
        </div>
        
        <div class="trainer-sidebar__search-wrap">
            <span class="trainer-sidebar__search-icon">🔍</span>
            <input type="text" class="trainer-sidebar__search" placeholder="Cari member..." oninput="filterMember(this.value)">
        </div>
    </div>
    <p class="trainer-sidebar__section-title">Member Saya ({{ count($clients) }})</p>
    <div class="trainer-member-list" id="member-list">
        @forelse($clients as $index => $m)
        <div class="trainer-member-item {{ $index === 0 ? 'trainer-member-item--active' : '' }}"
             data-nama="{{ strtolower($m['name']) }}" style="position:relative; cursor:pointer;"
             onclick="pilihMember('{{ $m['name'] }}', event)">
            <div class="trainer-member-item__avatar">{{ $m['initials'] }}</div>
            <div class="trainer-member-item__info">
                <p class="trainer-member-item__name">{{ $m['name'] }}</p>
                <p class="trainer-member-item__paket">{{ $m['package'] }}</p>
            </div>
            <form action="{{ route('trainer.member.remove', $m['user_id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus member ini? Seluruh jadwal yang terhubung akan dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="trainer-member-item__delete" onclick="event.stopPropagation();" title="Hapus Member">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"></path></svg>
                </button>
            </form>
        </div>
        @empty
        <p style="text-align: center; color: rgba(255,255,255,0.4); padding: 1rem; font-size: 0.8rem;">Belum ada member yang booking.</p>
        @endforelse
    </div>
    <div class="trainer-sidebar__footer">
        <div class="trainer-sidebar__footer-user">
            <div class="trainer-sidebar__footer-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 2)) }}</div>
            <div>
                <p class="trainer-sidebar__footer-name">{{ auth()->user()->name ?? 'Trainer' }}</p>
                <p class="trainer-sidebar__footer-role">Personal Trainer</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn" title="Keluar">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </button>
        </form>
    </div>
</aside>
{{-- ═══ MAIN CONTENT ═══ --}}
<main class="trainer-main">
    {{-- Header Content --}}
    <div class="trainer-main__header">
        <div>
            <p class="trainer-main__label">Dashboard Member</p>
            <h1 class="trainer-main__title" id="member-title">{{ count($clients) > 0 ? $clients[0]['name'] . '.' : 'Pilih Member' }}</h1>
            <p class="trainer-main__desc">Kelola jadwal, pantau booking yang masuk, dan catat progress latihan member secara mendetail.</p>
        </div>
        <button class="trainer-btn" onclick="bukaModal()">
            <span>+</span> Tambah Progress
        </button>
    </div>
    {{-- Tab Navigation --}}
    <div class="tab-nav-wrapper">
        <label class="tab-nav__item" for="tab-progress">Progress Member</label>
        <label class="tab-nav__item" for="tab-booking">Booking Masuk <span style="background:rgba(204,255,0,0.1); color:#CCFF00; padding:2px 6px; border-radius:4px; font-size:0.65rem; margin-left:4px;">{{ $pendingCount ?? 0 }}</span></label>
        <label class="tab-nav__item" for="tab-jadwal">Atur Jadwal Saya</label>
    </div>
    {{-- ══════════════════════════════════════
         TAB 1: PROGRESS MEMBER
         ══════════════════════════════════════ --}}
    <div class="tab-panel tab-panel--progress">
        {{-- Stat Cards --}}
        <div class="trainer-stats">
            @foreach($stats as $s)
            <div class="trainer-stat-card">
                <div>
                    <p class="trainer-stat-card__label">{{ $s['label'] }}</p>
                    <p class="trainer-stat-card__value">{{ $s['value'] }}<span class="trainer-stat-card__unit"></span></p>
                </div>
            </div>
            @endforeach
        </div>
        {{-- Tabel Riwayat Latihan --}}
        <div class="trainer-card" style="padding:0; overflow:hidden;">
            <div class="trainer-card__header" style="padding: 1.5rem 1.5rem 0; margin-bottom: 1rem;">
                <p class="trainer-card__title">Riwayat Latihan</p>
                <button class="trainer-btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; border-radius: 0.5rem; cursor:pointer;">Filter Data ▾</button>
            </div>
            
            <div class="trainer-table-wrap">
                <div class="trainer-table-scroll">
                    <table class="trainer-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Member</th>
                                <th>Berat Badan</th>
                                <th>Tinggi Badan</th>
                                <th>Otot / Lemak</th>
                                <th>Catatan Trainer</th>
                            </tr>
                        </thead>
                        <tbody id="progress-tbody">
                            @forelse($progressHistory as $r)
                            <tr>
                                <td style="font-weight:600; color:#fff;">{{ $r['time'] }}</td>
                                <td><span class="trainer-table__badge">{{ $r['member'] }}</span></td>
                                <td style="color:#CCFF00; font-weight:700;">{{ $r['weight'] }}</td>
                                <td>{{ $r['height'] }}</td>
                                <td>{{ $r['muscle_mass'] }} / {{ $r['fat_percentage'] }}</td>
                                <td style="max-width:200px; color:rgba(255,255,255,0.5); font-size:0.75rem; line-height:1.4;">{{ $r['notes'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding: 2rem; color: rgba(255,255,255,0.4);">Belum ada riwayat progress dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- ══════════════════════════════════════
         TAB 2: BOOKING MASUK
         ══════════════════════════════════════ --}}
    <div class="tab-panel tab-panel--booking">
        {{-- Filter bar --}}
        <div class="booking-filter-bar" style="margin-bottom: 1.5rem;">
            <button class="booking-filter-btn booking-filter-btn--active" onclick="filterBooking('semua', this)">Semua Booking</button>
            <button class="booking-filter-btn" onclick="filterBooking('pending', this)">Menunggu ({{ $pendingCount ?? 0 }})</button>
            <button class="booking-filter-btn" onclick="filterBooking('confirmed', this)">Dikonfirmasi</button>
        </div>
        <div class="booking-list" id="booking-list">
            @forelse($bookings as $booking)
            <div class="booking-item booking-item--{{ $booking['statusClass'] === 'warning' ? 'pending' : ($booking['statusClass'] === 'success' ? 'confirmed' : 'rejected') }}" data-status="{{ $booking['statusClass'] === 'warning' ? 'pending' : ($booking['statusClass'] === 'success' ? 'confirmed' : 'rejected') }}">
                <div class="booking-item__left">
                    <div class="booking-item__avatar">{{ $booking['initials'] }}</div>
                    <div class="booking-item__info">
                        <p class="booking-item__nama">{{ $booking['member'] }}</p>
                        <div class="booking-item__meta">
                            <span>📅 {{ explode(', ', $booking['dateTime'])[0] }}</span>
                            <span style="color:#fff; font-weight:600;">⏰ {{ explode(', ', $booking['dateTime'])[1] ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="booking-item__center">
                    <span class="booking-item__badge badge--pro">{{ $booking['program'] }}</span>
                </div>
                <div class="booking-item__actions">
                    @if(strtolower($booking['status']) === 'menunggu' || strtolower($booking['status']) === 'pending')
                    <form action="{{ route('trainer.bookings.update', $booking['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="booking-btn-confirm">Terima</button>
                    </form>
                    <form action="{{ route('trainer.bookings.update', $booking['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="booking-btn-reject">Tolak</button>
                    </form>
                    @else
                    <span class="booking-status-label booking-status-label--{{ $booking['statusClass'] === 'success' ? 'confirmed' : 'rejected' }}">
                        {{ $booking['statusClass'] === 'success' ? '✓ Dikonfirmasi' : '✕ Dibatalkan' }}
                    </span>
                    @endif
                </div>
            </div>
            @empty
            <p style="text-align: center; color: rgba(255,255,255,0.4); padding: 2rem;">Tidak ada booking masuk.</p>
            @endforelse
        </div>
    </div>
    {{-- ══════════════════════════════════════
         TAB 3: JADWAL SAYA
         ══════════════════════════════════════ --}}
    <div class="tab-panel tab-panel--jadwal">
        <div class="trainer-card">
            <div class="jadwal-header">
                <div>
                    <p class="trainer-card__title" style="margin-bottom:0.25rem;">Ketersediaan Jam Kerja</p>
                    <p style="font-size:0.75rem; color:rgba(255,255,255,0.4);">Tentukan jam berapa saja kamu bisa melatih pada tanggal tertentu.</p>
                </div>
                <div class="jadwal-datepicker">
                    <input type="date" id="jadwal-date" value="{{ date('Y-m-d') }}" onchange="gantiTanggalJadwal(this.value)">
                </div>
            </div>
            <div class="jadwal-grid" id="jadwal-grid" style="margin-top: 1rem;">
                {{-- Di-generate JS berdasarkan tanggal --}}
            </div>
            <div style="display:flex; justify-content:flex-end; margin-bottom: 2rem;">
                <button class="trainer-btn" onclick="simpanJadwal()">Simpan Perubahan Jadwal</button>
            </div>
            
            <div style="margin-top: 2rem; margin-bottom: 1rem;">
                <h3 style="color:#fff; font-size: 1.1rem; margin: 0;">Sesi Terjadwal</h3>
                <p style="font-size:0.75rem; color:rgba(255,255,255,0.4); margin-top: 0.25rem;">Daftar member dengan booking yang telah disetujui pada hari ini.</p>
            </div>
            <div class="trainer-table-wrap" style="margin-bottom: 2rem;">
                <div class="trainer-table-scroll">
                    <table class="trainer-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Nama Member</th>
                                <th>Program / Sesi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings ?? [] as $booking)
                                @if(strtolower($booking['statusClass']) === 'success')
                                <tr>
                                    <td style="font-weight:600; color:#CCFF00;">{{ explode(', ', $booking['dateTime'])[1] ?? '00:00' }}</td>
                                    <td><span class="trainer-table__badge">{{ $booking['member'] ?? 'Member' }}</span></td>
                                    <td>{{ $booking['program'] ?? 'Personal Training' }}</td>
                                    <td><span style="color:#00c864; font-weight:700;">Dikonfirmasi</span></td>
                                    <td>
                                        <button class="trainer-btn-outline" style="padding:0.4rem 0.8rem; font-size:0.75rem;">Mulai Sesi</button>
                                    </td>
                                </tr>
                                @endif
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:2rem; color:rgba(255,255,255,0.4);">
                                    Belum ada sesi jadwal yang disetujui.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
{{-- ═══ MODAL TAMBAH/EDIT PROGRESS ═══ --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal-box">
        <div class="modal-box__header">
            <p class="modal-box__title" id="modal-title">Catat Progress Baru</p>
            <button class="modal-box__close" onclick="tutupModal()">✕</button>
        </div>
        <form action="{{ route('trainer.progress.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Pilih Member</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Pilih Member --</option>
                    @foreach($clients as $c)
                        <option value="{{ $c['user_id'] }}">{{ $c['name'] }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Berat Badan (KG)</label>
                    <input type="number" step="0.1" name="weight" class="form-control" placeholder="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tinggi Badan (CM)</label>
                    <input type="number" step="0.1" name="height" class="form-control" placeholder="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Massa Otot (%)</label>
                    <input type="number" step="0.1" name="muscle_mass" class="form-control" placeholder="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Lemak Tubuh (%)</label>
                    <input type="number" step="0.1" name="fat_percentage" class="form-control" placeholder="0" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Catatan Trainer</label>
                <textarea name="notes" class="form-control" placeholder="Catat progress..."></textarea>
            </div>
            
            <div class="form-actions">
                <button type="button" class="trainer-btn-outline" style="flex:1; padding:0.875rem; border-radius:0.75rem;" onclick="tutupModal()">Batal</button>
                <button type="submit" class="trainer-btn" style="flex:2;">Simpan Data Progress</button>
            </div>
        </form>
    </div>
</div>
<div id="toast-container"></div>
<script>
/* ════ Member Selection ════ */
function pilihMember(nama, e) {
    e.preventDefault();
    document.getElementById('member-title').textContent = nama + '.';
    document.querySelectorAll('.trainer-member-item').forEach(el => el.classList.remove('trainer-member-item--active'));
    e.currentTarget.classList.add('trainer-member-item--active');
    
    // Smooth scroll main area to top on mobile when member changes
    if(window.innerWidth <= 768) {
        document.querySelector('.trainer-main').scrollTo({top: 0, behavior: 'smooth'});
    }
}
function filterMember(q) {
    document.querySelectorAll('.trainer-member-item').forEach(el => {
        const nama = el.dataset.nama || '';
        if(nama.includes(q.toLowerCase())) {
            el.style.display = window.innerWidth <= 768 ? 'flex' : 'flex';
        } else {
            el.style.display = 'none';
        }
    });
}
/* ════ Modal Progress ════ */
function bukaModal() {
    document.getElementById('modal-title').textContent = 'Catat Progress Baru';
    document.getElementById('edit-index').value = '';
    document.getElementById('progress-form').reset();
    document.getElementById('f-tanggal').value = new Date().toISOString().split('T')[0];
    document.getElementById('modal-tambah').classList.add('is-open');
}
function bukaModalEdit(btn) {
    const row = btn.closest('tr');
    const cells = row.querySelectorAll('td');
    document.getElementById('modal-title').textContent = 'Edit Data Progress';
    document.getElementById('f-tanggal').value = cells[0].textContent;
    document.getElementById('f-latihan').value = cells[1].querySelector('.trainer-table__badge').textContent;
    document.getElementById('f-beban').value = cells[2].textContent.replace(' kg','');
    const setRep = cells[3].textContent.split(' × ');
    document.getElementById('f-set').value = setRep[0];
    document.getElementById('f-rep').value = setRep[1];
    document.getElementById('f-durasi').value = cells[4].textContent.replace('m','');
    document.getElementById('f-catatan').value = cells[5].textContent;
    document.getElementById('edit-index').value = Array.from(row.parentNode.children).indexOf(row);
    document.getElementById('modal-tambah').classList.add('is-open');
}
function tutupModal() {
    document.getElementById('modal-tambah').classList.remove('is-open');
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
    const tbody = document.getElementById('progress-tbody');
    const rowHtml = `
        <tr>
            <td style="font-weight:600; color:#fff;">${tanggal}</td>
            <td><span class="trainer-table__badge">${latihan}</span></td>
            <td style="color:#CCFF00; font-weight:700;">${beban} kg</td>
            <td>${set} × ${rep}</td>
            <td>${durasi}m</td>
            <td style="max-width:200px; color:rgba(255,255,255,0.5); font-size:0.75rem; line-height:1.4;">${catatan}</td>
            <td>
                <div style="display:flex;">
                    <button class="trainer-table__action" title="Edit" onclick="bukaModalEdit(this)">✏️</button>
                    <button class="trainer-table__action trainer-table__action--delete" title="Hapus" onclick="hapusRow(this)">🗑</button>
                </div>
            </td>
        </tr>`;
    if(editIdx !== '') {
        tbody.rows[parseInt(editIdx)].outerHTML = rowHtml;
        showToast('Data progress berhasil diperbarui!');
    } else {
        tbody.insertAdjacentHTML('afterbegin', rowHtml);
        showToast('Data progress berhasil ditambahkan!');
    }
    tutupModal();
}
function hapusRow(btn) {
    if(confirm('Yakin ingin menghapus data ini secara permanen?')) {
        btn.closest('tr').remove();
        showToast('Data berhasil dihapus');
    }
}
/* ════ Booking Actions ════ */
function filterBooking(status, btn) {
    document.querySelectorAll('.booking-filter-btn').forEach(b => b.classList.remove('booking-filter-btn--active'));
    btn.classList.add('booking-filter-btn--active');
    document.querySelectorAll('.booking-item').forEach(item => {
        item.style.display = (status === 'semua' || item.dataset.status === status) ? '' : 'none';
    });
}
function konfirmasiBooking(btn) {
    const item = btn.closest('.booking-item');
    item.className = 'booking-item booking-item--confirmed';
    item.dataset.status = 'confirmed';
    const actionsEl = item.querySelector('.booking-item__actions');
    actionsEl.innerHTML = '<span class="booking-status-label booking-status-label--confirmed">✓ Dikonfirmasi</span>';
    showToast('Jadwal booking berhasil diterima!');
}
function tolakBooking(btn) {
    if(confirm('Yakin ingin menolak booking jadwal ini?')) {
        const item = btn.closest('.booking-item');
        item.className = 'booking-item booking-item--rejected';
        item.dataset.status = 'rejected';
        const actionsEl = item.querySelector('.booking-item__actions');
        actionsEl.innerHTML = '<span class="booking-status-label booking-status-label--rejected">✕ Ditolak</span>';
        showToast('Booking telah ditolak.');
    }
}
/* ════ Jadwal ════ */
const JAM_SLOTS = ['06.00','08.00','10.00','13.00','15.00','17.00','19.00'];
let jadwalState = {}; 
function gantiTanggalJadwal(tgl) { renderJadwalGrid(tgl); }
function renderJadwalGrid(tgl) {
    if(!jadwalState[tgl]) jadwalState[tgl] = { '08.00':true, '10.00':true, '17.00':true }; // Dummy default
    const hariNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const d = new Date(tgl);
    const namaHari = hariNames[d.getDay()];
    const tanggalFmt = d.getDate() + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
    let slotHtml = JAM_SLOTS.map(jam => {
        const isOn = jadwalState[tgl][jam] || false;
        return `
        <div class="jadwal-slot ${isOn ? 'jadwal-slot--on' : ''}" onclick="toggleSlot('${tgl}','${jam}',this)">
            <span class="jadwal-slot__jam">${jam}</span>
            <label class="toggle-switch" onclick="event.stopPropagation()">
                <input type="checkbox" ${isOn ? 'checked' : ''} onchange="toggleSlot('${tgl}','${jam}',this.closest('.jadwal-slot'))">
                <span class="toggle-slider"></span>
            </label>
        </div>`;
    }).join('');
    document.getElementById('jadwal-grid').innerHTML = `
        <div class="jadwal-hari-card">
            <div class="jadwal-hari-card__header">
                <span class="jadwal-hari-card__nama">${namaHari}</span>
                <span class="jadwal-hari-card__tanggal">${tanggalFmt}</span>
            </div>
            <div>${slotHtml}</div>
        </div>`;
}
function toggleSlot(tgl, jam, slotEl) {
    jadwalState[tgl][jam] = !jadwalState[tgl][jam];
    const isOn = jadwalState[tgl][jam];
    slotEl.classList.toggle('jadwal-slot--on', isOn);
    const cb = slotEl.querySelector('input[type=checkbox]');
    if(cb) cb.checked = isOn;
}
function simpanJadwal() {
    showToast('Perubahan jadwal berhasil disimpan ke sistem!');
}
/* ════ Utilities ════ */
document.getElementById('modal-tambah').addEventListener('click', function(e) { if(e.target === this) tutupModal(); });
function showToast(msg) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = msg;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
document.addEventListener('DOMContentLoaded', () => renderJadwalGrid(document.getElementById('jadwal-date').value));
</script>
</body>
</html>
