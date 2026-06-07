@extends('layouts.admin')
@section('title','POS Transaksi')

@section('content')
<div class="admin-shell receptionist-shell">
    <aside class="admin-sidebar" aria-label="Navigasi receptionist">
        <div class="admin-brand">
            <a href="{{ url('/') }}" class="admin-brand__mark" aria-label="Kembali ke beranda Siboti">
                <span class="material-symbols-outlined">fitness_center</span>
            </a>
            <div>
                <p class="admin-brand__name">Siboti</p>
                <p class="admin-brand__label">Receptionist Desk</p>
            </div>
        </div>

        <nav class="admin-menu">
            <a href="{{ route('receptionist.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('scan-qr.index') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">qr_code_scanner</span>
                <span>Scan QR</span>
            </a>
            <a href="{{ route('pos.dashboard') }}" class="admin-menu__item admin-menu__item--active">
                <span class="material-symbols-outlined">point_of_sale</span>
                <span>Transaksi POS</span>
            </a>
            <a href="{{ route('pos.history') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">receipt_long</span>
                <span>Riwayat Transaksi</span>
            </a>
        </nav>

        <div class="admin-sidebar__footer">
            <a href="#" class="admin-menu__item">
                <span class="material-symbols-outlined">settings</span>
                <span>Pengaturan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-menu__item admin-menu__item--danger" style="width:100%;border:0;background:transparent;cursor:pointer;">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <p class="admin-eyebrow">Panel Operasional Front Desk</p>
                <h1>Transaksi POS</h1>
            </div>
            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="search" placeholder="Cari member atau ID..." aria-label="Cari member">
                </label>
                <button type="button" class="admin-icon-button" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <div class="admin-profile" aria-label="Profil receptionist">
                    <span>RC</span>
                </div>
            </div>
        </header>

        <main class="admin-content">
            <section class="admin-grid admin-grid--two">

                {{-- DAFTAR PRODUK --}}
                <article class="admin-card">
                    <div class="admin-section-head admin-section-head--bordered">
                        <div>
                            <h2>Produk Gym</h2>
                            <p>Minuman & suplemen</p>
                        </div>
                    </div>

                    <div class="admin-transaction-list" id="productList">
                        @php
                        $products = [
                            ['id' => 1, 'name' => 'Protein Shake',   'icon' => 'local_drink',      'stock' => 18, 'price' => 25000],
                            ['id' => 2, 'name' => 'Energy Drink',    'icon' => 'bolt',             'stock' => 12, 'price' => 15000],
                            ['id' => 3, 'name' => 'Whey Protein',    'icon' => 'fitness_center',   'stock' => 8,  'price' => 75000],
                            ['id' => 4, 'name' => 'BCAA Drink',      'icon' => 'water_drop',       'stock' => 20, 'price' => 30000],
                            ['id' => 5, 'name' => 'Vitamin C',       'icon' => 'medication',       'stock' => 35, 'price' => 10000],
                            ['id' => 6, 'name' => 'Air Mineral',     'icon' => 'opacity',          'stock' => 50, 'price' => 5000],
                            ['id' => 7, 'name' => 'Pre-Workout',     'icon' => 'electric_bolt',    'stock' => 6,  'price' => 50000],
                            ['id' => 8, 'name' => 'Creatine Shot',   'icon' => 'science',          'stock' => 10, 'price' => 40000],
                        ];
                        @endphp

                        @foreach($products as $product)
                        <div class="admin-transaction pos-product-row"
                             data-id="{{ $product['id'] }}"
                             data-name="{{ $product['name'] }}"
                             data-price="{{ $product['price'] }}"
                             data-stock="{{ $product['stock'] }}"
                             style="cursor:pointer;">
                            <div class="admin-transaction__item">
                                <span class="material-symbols-outlined">{{ $product['icon'] }}</span>
                                <div>
                                    <strong>{{ $product['name'] }}</strong>
                                    <small>Stok: <span id="stock-{{ $product['id'] }}">{{ $product['stock'] }}</span></small>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <strong>Rp{{ number_format($product['price'],0,',','.') }}</strong>
                                <button type="button" class="admin-small-button pos-add-btn" data-id="{{ $product['id'] }}">
                                    <span class="material-symbols-outlined" style="font-size:16px;">add</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </article>

                {{-- KERANJANG --}}
                <article class="admin-card">
                    <div class="admin-section-head admin-section-head--bordered">
                        <div>
                            <h2>Ringkasan Transaksi</h2>
                            <p>Kasir POS</p>
                        </div>
                        <button type="button" class="admin-small-button" id="clearCart">
                            <span class="material-symbols-outlined" style="font-size:15px;">delete_sweep</span>
                            Kosongkan
                        </button>
                    </div>

                    <div id="cartList" style="min-height:120px;">
                        <p id="cartEmpty" style="color:var(--color-text-muted,#888);font-size:13px;padding:1rem 0;">
                            Belum ada produk dipilih.
                        </p>
                    </div>

                    <div class="admin-summary-line" style="margin-top:auto;padding-top:1rem;border-top:1px solid var(--color-border,#2a2a2a);">
                        <span>Total Bayar</span>
                        <strong id="cartTotal">Rp0</strong>
                    </div>

                    <button class="admin-primary-button" id="saveBtn" style="width:100%;margin-top:1.5rem;" disabled>
                        Simpan Transaksi
                    </button>
                </article>

            </section>
        </main>
    </div>
</div>

{{-- MODAL SUKSES --}}
<div id="successModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#1a1a1a;border:1px solid #2a3d0a;border-radius:16px;padding:40px 36px;text-align:center;max-width:360px;width:90%;">
        <div style="width:64px;height:64px;border-radius:50%;background:#1e2a0a;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <span class="material-symbols-outlined" style="font-size:32px;color:#c6f135;">check_circle</span>
        </div>
        <h2 style="font-size:18px;font-weight:700;color:#e0e0e0;margin-bottom:8px;">Transaksi Berhasil!</h2>
        <p style="font-size:13px;color:#888;margin-bottom:6px;">Total dibayar</p>
        <p id="modalTotal" style="font-size:24px;font-weight:700;color:#c6f135;margin-bottom:24px;">Rp0</p>
        <button type="button" id="modalClose" class="admin-primary-button" style="width:100%;">
            Transaksi Baru
        </button>
    </div>
</div>

@push('scripts')
<script>
const cart = {};

const products = {
    @foreach($products as $p)
    {{ $p['id'] }}: { name: '{{ $p['name'] }}', price: {{ $p['price'] }}, stock: {{ $p['stock'] }} },
    @endforeach
};

function formatRp(n) {
    return 'Rp' + n.toLocaleString('id-ID');
}

function renderCart() {
    const cartList = document.getElementById('cartList');
    const cartEmpty = document.getElementById('cartEmpty');
    const cartTotal = document.getElementById('cartTotal');
    const saveBtn = document.getElementById('saveBtn');

    const ids = Object.keys(cart).filter(id => cart[id] > 0);

    if (ids.length === 0) {
        cartList.innerHTML = '<p id="cartEmpty" style="color:#888;font-size:13px;padding:1rem 0;">Belum ada produk dipilih.</p>';
        cartTotal.textContent = 'Rp0';
        saveBtn.disabled = true;
        return;
    }

    let html = '';
    let total = 0;

    ids.forEach(id => {
        const p = products[id];
        const qty = cart[id];
        const subtotal = p.price * qty;
        total += subtotal;
        html += `
        <div class="admin-progress-item" style="margin-bottom:10px;">
            <div style="display:flex;justify-content:space-between;align-items:center;width:100%;">
                <span style="font-size:13px;color:#ccc;">${p.name}</span>
                <div style="display:flex;align-items:center;gap:10px;">
                    <button type="button" onclick="changeQty(${id}, -1)"
                        style="width:24px;height:24px;border-radius:6px;border:1px solid #333;background:#111;color:#ccc;cursor:pointer;font-size:14px;line-height:1;display:flex;align-items:center;justify-content:center;">−</button>
                    <span style="font-size:13px;font-weight:600;color:#e0e0e0;min-width:16px;text-align:center;">${qty}</span>
                    <button type="button" onclick="changeQty(${id}, 1)"
                        style="width:24px;height:24px;border-radius:6px;border:1px solid #333;background:#111;color:#ccc;cursor:pointer;font-size:14px;line-height:1;display:flex;align-items:center;justify-content:center;">+</button>
                    <strong style="color:#c6f135;min-width:72px;text-align:right;font-size:13px;">${formatRp(subtotal)}</strong>
                </div>
            </div>
        </div>`;
    });

    cartList.innerHTML = html;
    cartTotal.textContent = formatRp(total);
    saveBtn.disabled = false;
}

function changeQty(id, delta) {
    const p = products[id];
    const current = cart[id] || 0;
    const newQty = current + delta;

    if (newQty <= 0) {
        delete cart[id];
    } else if (newQty > p.stock) {
        return;
    } else {
        cart[id] = newQty;
    }
    renderCart();
}

document.querySelectorAll('.pos-add-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const id = btn.dataset.id;
        const p = products[id];
        const current = cart[id] || 0;
        if (current >= p.stock) return;
        cart[id] = current + 1;
        renderCart();
    });
});

document.getElementById('clearCart').addEventListener('click', () => {
    Object.keys(cart).forEach(k => delete cart[k]);
    renderCart();
});

document.getElementById('saveBtn').addEventListener('click', () => {
    const total = document.getElementById('cartTotal').textContent;
    document.getElementById('modalTotal').textContent = total;
    const modal = document.getElementById('successModal');
    modal.style.display = 'flex';
});

document.getElementById('modalClose').addEventListener('click', () => {
    document.getElementById('successModal').style.display = 'none';
    Object.keys(cart).forEach(k => delete cart[k]);
    renderCart();
});
</script>
@endpush

@endsection