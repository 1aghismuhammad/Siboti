@extends('layouts.admin')

@section('title', 'Dashboard POS')

@section('content')
<div class="admin-shell pos-shell">
    <aside class="admin-sidebar" aria-label="Navigasi POS">
        <div class="admin-brand">
            <a href="{{ url('/') }}" class="admin-brand__mark" aria-label="Kembali ke beranda Siboti">
                <span class="material-symbols-outlined">fitness_center</span>
            </a>
            <div>
                <p class="admin-brand__name">Siboti</p>
                <p class="admin-brand__label">POS Module</p>
            </div>
        </div>

        <nav class="admin-menu">
            <a href="{{ route('admin.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span>Admin Dashboard</span>
            </a>
            <a href="{{ route('receptionist.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">support_agent</span>
                <span>Receptionist</span>
            </a>
            <a href="{{ route('scan-qr.index') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">qr_code_scanner</span>
                <span>Scan QR</span>
            </a>
            <a href="{{ route('trainer.dashboard') }}" class="admin-menu__item">
                <span class="material-symbols-outlined">fitness_center</span>
                <span>Personal Trainer</span>
            </a>
            <a href="{{ route('pos.dashboard') }}" class="admin-menu__item admin-menu__item--active">
                <span class="material-symbols-outlined">point_of_sale</span>
                <span>POS Dashboard</span>
            </a>
            <a href="#produk" class="admin-menu__item">
                <span class="material-symbols-outlined">inventory_2</span>
                <span>Daftar Produk</span>
            </a>
            <a href="#member-pos" class="admin-menu__item">
                <span class="material-symbols-outlined">person_search</span>
                <span>Cari Member</span>
            </a>
            <a href="#transaksi-pos" class="admin-menu__item">
                <span class="material-symbols-outlined">receipt_long</span>
                <span>Transaksi</span>
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
            <a href="{{ url('/') }}" class="admin-menu__item admin-menu__item--danger">
                <span class="material-symbols-outlined">logout</span>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <p class="admin-eyebrow">Receptionist Portal</p>
                <h1>Dashboard POS</h1>
            </div>

            <div class="admin-topbar__actions">
                <label class="admin-search">
                    <span class="material-symbols-outlined">search</span>
                    <input id="posSearch" type="search" placeholder="Cari produk, member, transaksi..." aria-label="Cari produk POS">
                </label>
                <button type="button" class="admin-icon-button" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="admin-icon-button__dot"></span>
                </button>
                <div class="admin-profile" aria-label="Profil kasir">
                    <span>PS</span>
                </div>
            </div>
        </header>

        <main class="admin-content pos-content">
            <section class="admin-card pos-hero">
                <div>
                    <p class="admin-eyebrow">SiBoti Store</p>
                    <h2>Kelola penjualan produk gym, suplemen, dan merchandise dari satu layar kasir.</h2>
                    <p>Modul ini disiapkan untuk kebutuhan receptionist atau kasir: memilih produk, mencari member, mengatur keranjang, memilih status pembayaran, dan melihat transaksi POS terbaru.</p>
                </div>
                <a href="#produk" class="admin-primary-button pos-hero__button">
                    <span class="material-symbols-outlined">add_shopping_cart</span>
                    Mulai Transaksi
                </a>
            </section>

            <section class="admin-stats" aria-label="Statistik POS">
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

            <section class="pos-main-grid">
                <div class="pos-left-column">
                    <section id="produk" class="admin-card pos-product-section">
                        <div class="admin-section-head">
                            <div>
                                <h2>Daftar Produk</h2>
                                <p>Pilih produk untuk dimasukkan ke keranjang transaksi.</p>
                            </div>
                            <div class="pos-category-tabs" aria-label="Filter kategori produk">
                                <button type="button" class="pos-category-tab is-active" data-category="Semua">Semua</button>
                                <button type="button" class="pos-category-tab" data-category="Minuman">Minuman</button>
                                <button type="button" class="pos-category-tab" data-category="Supplement">Supplement</button>
                                <button type="button" class="pos-category-tab" data-category="Aksesoris">Aksesoris</button>
                                <button type="button" class="pos-category-tab" data-category="Merchandise">Merchandise</button>
                            </div>
                        </div>

                        <div class="pos-product-grid" id="productGrid">
                            @foreach ($products as $product)
                                <article class="pos-product-card" data-product-card data-category="{{ $product['category'] }}" data-name="{{ strtolower($product['name']) }}">
                                    <div class="pos-product-card__visual pos-product-card__visual--{{ $product['badgeClass'] }}">
                                        <span class="material-symbols-outlined">{{ $product['icon'] }}</span>
                                        <b>{{ $product['category'] }}</b>
                                    </div>
                                    <div class="pos-product-card__body">
                                        <div class="pos-product-card__head">
                                            <span class="admin-status admin-status--{{ $product['badgeClass'] }}">{{ $product['badge'] }}</span>
                                            <small>Stok {{ $product['stock'] }}</small>
                                        </div>
                                        <h3>{{ $product['name'] }}</h3>
                                        <p>{{ $product['description'] }}</p>
                                        <div class="pos-product-card__bottom">
                                            <strong>{{ $product['priceText'] }}</strong>
                                            <button type="button" class="pos-add-button" data-add-product="{{ $product['id'] }}" aria-label="Tambah {{ $product['name'] }} ke keranjang">
                                                <span class="material-symbols-outlined">add</span>
                                            </button>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section id="member-pos" class="admin-card pos-member-card">
                        <div class="admin-section-head">
                            <div>
                                <h2>Cari Member</h2>
                                <p>Opsional. Transaksi tetap bisa disimpan sebagai non-member.</p>
                            </div>
                            <span class="admin-pill admin-pill--neutral">Manual Search</span>
                        </div>

                        <div class="pos-member-search">
                            <label class="pos-input-with-icon">
                                <span class="material-symbols-outlined">id_card</span>
                                <input id="memberLookup" type="text" value="MEM-0012" placeholder="Masukkan ID atau nama member...">
                            </label>
                            <button type="button" id="findMemberButton" class="admin-primary-button">Cari Member</button>
                        </div>

                        <div id="memberPreview" class="pos-member-preview">
                            <div class="pos-member-preview__avatar">BS</div>
                            <div>
                                <strong>Budi Santoso</strong>
                                <span>MEM-0012 • Gold Annual • Aktif • Sisa 148 hari</span>
                            </div>
                            <span class="admin-status admin-status--success">Terhubung</span>
                        </div>
                    </section>

                    <section id="transaksi-pos" class="admin-card admin-table-card">
                        <div class="admin-section-head admin-section-head--bordered">
                            <div>
                                <h2>Transaksi POS Terbaru</h2>
                                <p>Riwayat transaksi kasir dan receptionist hari ini.</p>
                            </div>
                            <a href="#" class="admin-text-link">Download Report</a>
                        </div>
                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID Transaksi</th>
                                        <th>Kasir</th>
                                        <th>Member</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td class="admin-table__strong">{{ $transaction['trxId'] }}</td>
                                            <td>{{ $transaction['cashier'] }}</td>
                                            <td>{{ $transaction['member'] }}</td>
                                            <td class="pos-table-price">{{ $transaction['total'] }}</td>
                                            <td><span class="admin-status admin-status--{{ $transaction['statusClass'] }}">{{ $transaction['status'] }}</span></td>
                                            <td>{{ $transaction['time'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>

                <aside class="pos-cart-column" aria-label="Keranjang transaksi POS">
                    <section class="admin-card pos-cart-card">
                        <div class="pos-cart-card__head">
                            <div>
                                <h2>Keranjang</h2>
                                <p>Transaksi aktif</p>
                            </div>
                            <span id="cartCount" class="pos-cart-count">0</span>
                        </div>

                        <div id="cartItems" class="pos-cart-items"></div>

                        <div class="pos-payment-summary">
                            <div class="pos-summary-row">
                                <span>Subtotal</span>
                                <strong id="cartSubtotal">Rp0</strong>
                            </div>
                            <div class="pos-summary-row">
                                <span>Pajak</span>
                                <strong>Rp0</strong>
                            </div>
                            <div class="pos-summary-row pos-summary-row--total">
                                <span>Total</span>
                                <strong id="cartTotal">Rp0</strong>
                            </div>

                            <div class="pos-payment-status" aria-label="Status pembayaran">
                                <p>Status Pembayaran</p>
                                <div>
                                    <button type="button" class="pos-payment-button is-active" data-payment="Lunas">Lunas</button>
                                    <button type="button" class="pos-payment-button" data-payment="Pending">Pending</button>
                                    <button type="button" class="pos-payment-button pos-payment-button--danger" data-payment="Batal">Batal</button>
                                </div>
                            </div>

                            <button type="button" id="saveTransaction" class="admin-primary-button pos-save-button">Simpan Transaksi</button>
                            <p id="transactionMessage" class="pos-transaction-message" role="status"></p>
                        </div>
                    </section>

                    <section class="admin-card pos-empty-state">
                        <span class="material-symbols-outlined">shopping_cart_off</span>
                        <p>Tampilan keranjang kosong akan muncul otomatis saat semua item dihapus.</p>
                    </section>
                </aside>
            </section>

            <section class="admin-grid admin-grid--two pos-report-grid">
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Ringkasan Produk Terjual</h2>
                            <p>Produk dengan jumlah penjualan tertinggi.</p>
                        </div>
                    </div>
                    <div class="pos-top-product-list">
                        @foreach ($topProducts as $product)
                            <div class="pos-top-product-item">
                                <span>{{ $product['rank'] }}</span>
                                <strong>{{ $product['name'] }}</strong>
                                <b>{{ $product['sold'] }}</b>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Produk Sedang Tren</h2>
                            <p>Produk dengan pertumbuhan transaksi paling menonjol.</p>
                        </div>
                    </div>
                    <div class="pos-trending-grid">
                        @foreach ($trendingProducts as $product)
                            <div class="pos-trending-card">
                                <div>
                                    <span class="material-symbols-outlined">trending_up</span>
                                    <strong>{{ $product['growth'] }}</strong>
                                </div>
                                <h3>{{ $product['name'] }}</h3>
                                <p>{{ $product['note'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>

            <section class="admin-grid admin-grid--two">
                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Aktivitas Sistem POS</h2>
                            <p>Log aktivitas kasir, inventory, dan transaksi.</p>
                        </div>
                    </div>
                    <div class="admin-activity-list">
                        @foreach ($activities as $activity)
                            <div class="admin-activity">
                                <span class="material-symbols-outlined">{{ $activity['icon'] }}</span>
                                <div>
                                    <strong>{{ $activity['text'] }}</strong>
                                    <small>{{ $activity['time'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="admin-card">
                    <div class="admin-section-head">
                        <div>
                            <h2>Peringatan POS</h2>
                            <p>Masalah operasional yang perlu dipantau.</p>
                        </div>
                    </div>
                    <div class="admin-alert-list">
                        @foreach ($alerts as $alert)
                            <div class="admin-alert admin-alert--{{ $alert['type'] }}">
                                <span class="material-symbols-outlined">{{ $alert['icon'] }}</span>
                                <div>
                                    <strong>{{ $alert['title'] }}</strong>
                                    <small>{{ $alert['description'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const posProducts = @json($products);
    const initialCart = @json($initialCart);
    const posMembers = @json($members);

    const productMap = new Map(posProducts.map((product) => [product.id, product]));
    const formatCurrency = (value) => new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(value);

    let cart = initialCart.map((item) => ({ ...item }));
    let paymentStatus = 'Lunas';
    let activeMember = posMembers[0];

    const cartItems = document.getElementById('cartItems');
    const cartCount = document.getElementById('cartCount');
    const cartSubtotal = document.getElementById('cartSubtotal');
    const cartTotal = document.getElementById('cartTotal');
    const transactionMessage = document.getElementById('transactionMessage');
    const memberPreview = document.getElementById('memberPreview');

    function renderCart() {
        const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        const total = cart.reduce((sum, item) => {
            const product = productMap.get(item.productId);
            return sum + (product ? product.price * item.qty : 0);
        }, 0);

        cartCount.textContent = totalItems;
        cartSubtotal.textContent = formatCurrency(total);
        cartTotal.textContent = formatCurrency(total);

        if (cart.length === 0) {
            cartItems.innerHTML = `
                <div class="pos-cart-empty">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    <strong>Keranjang masih kosong</strong>
                    <p>Pilih produk dari daftar untuk memulai transaksi.</p>
                </div>
            `;
            return;
        }

        cartItems.innerHTML = cart.map((item) => {
            const product = productMap.get(item.productId);
            if (!product) return '';
            return `
                <div class="pos-cart-item">
                    <div class="pos-cart-item__icon">
                        <span class="material-symbols-outlined">${product.icon}</span>
                    </div>
                    <div class="pos-cart-item__body">
                        <strong>${product.name}</strong>
                        <span>${formatCurrency(product.price)}</span>
                    </div>
                    <div class="pos-qty-control">
                        <button type="button" data-qty-minus="${product.id}" aria-label="Kurangi ${product.name}">−</button>
                        <b>${item.qty}</b>
                        <button type="button" data-qty-plus="${product.id}" aria-label="Tambah ${product.name}">+</button>
                    </div>
                </div>
            `;
        }).join('');
    }

    function addProduct(productId) {
        const existing = cart.find((item) => item.productId === productId);
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ productId, qty: 1 });
        }
        transactionMessage.textContent = '';
        renderCart();
    }

    function updateQty(productId, delta) {
        const item = cart.find((cartItem) => cartItem.productId === productId);
        if (!item) return;
        item.qty += delta;
        if (item.qty <= 0) {
            cart = cart.filter((cartItem) => cartItem.productId !== productId);
        }
        transactionMessage.textContent = '';
        renderCart();
    }

    document.querySelectorAll('[data-add-product]').forEach((button) => {
        button.addEventListener('click', () => addProduct(button.dataset.addProduct));
    });

    cartItems.addEventListener('click', (event) => {
        const minus = event.target.closest('[data-qty-minus]');
        const plus = event.target.closest('[data-qty-plus]');
        if (minus) updateQty(minus.dataset.qtyMinus, -1);
        if (plus) updateQty(plus.dataset.qtyPlus, 1);
    });

    document.querySelectorAll('.pos-payment-button').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.pos-payment-button').forEach((item) => item.classList.remove('is-active'));
            button.classList.add('is-active');
            paymentStatus = button.dataset.payment;
            transactionMessage.textContent = '';
        });
    });

    document.getElementById('saveTransaction').addEventListener('click', () => {
        if (cart.length === 0) {
            transactionMessage.textContent = 'Transaksi belum dapat disimpan karena keranjang kosong.';
            transactionMessage.classList.add('is-danger');
            return;
        }

        const total = cart.reduce((sum, item) => {
            const product = productMap.get(item.productId);
            return sum + (product ? product.price * item.qty : 0);
        }, 0);

        transactionMessage.classList.remove('is-danger');
        transactionMessage.textContent = `Transaksi ${paymentStatus.toLowerCase()} untuk ${activeMember ? activeMember.name : 'Non-Member'} berhasil disiapkan. Total ${formatCurrency(total)}.`;
    });

    document.getElementById('findMemberButton').addEventListener('click', () => {
        const keyword = document.getElementById('memberLookup').value.trim().toLowerCase();
        const member = posMembers.find((item) =>
            item.memberId.toLowerCase().includes(keyword) || item.name.toLowerCase().includes(keyword)
        );

        if (!member) {
            activeMember = null;
            memberPreview.innerHTML = `
                <div class="pos-member-preview__avatar">NM</div>
                <div>
                    <strong>Non-Member</strong>
                    <span>Data member tidak ditemukan. Transaksi dapat dilanjutkan sebagai non-member.</span>
                </div>
                <span class="admin-status admin-status--neutral">Guest</span>
            `;
            return;
        }

        activeMember = member;
        memberPreview.innerHTML = `
            <div class="pos-member-preview__avatar">${member.initials}</div>
            <div>
                <strong>${member.name}</strong>
                <span>${member.memberId} • ${member.package} • ${member.status} • Sisa ${member.remaining}</span>
            </div>
            <span class="admin-status admin-status--${member.statusClass}">${member.status}</span>
        `;
    });

    document.querySelectorAll('.pos-category-tab').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.pos-category-tab').forEach((tab) => tab.classList.remove('is-active'));
            button.classList.add('is-active');

            const category = button.dataset.category;
            document.querySelectorAll('[data-product-card]').forEach((card) => {
                const matchCategory = category === 'Semua' || card.dataset.category === category;
                const matchSearch = !document.getElementById('posSearch').value || card.dataset.name.includes(document.getElementById('posSearch').value.toLowerCase());
                card.hidden = !(matchCategory && matchSearch);
            });
        });
    });

    document.getElementById('posSearch').addEventListener('input', (event) => {
        const keyword = event.target.value.toLowerCase();
        const activeCategory = document.querySelector('.pos-category-tab.is-active').dataset.category;
        document.querySelectorAll('[data-product-card]').forEach((card) => {
            const matchCategory = activeCategory === 'Semua' || card.dataset.category === activeCategory;
            const matchSearch = card.dataset.name.includes(keyword);
            card.hidden = !(matchCategory && matchSearch);
        });
    });

    renderCart();
</script>
@endpush
