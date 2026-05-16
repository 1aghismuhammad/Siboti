<section id="paket" class="pricing">
    <div class="container">
        <div class="section-label">
            <div class="section-label__line"></div>
            <span class="section-label__text">Paket Membership</span>
        </div>
        <div class="pricing__header">
            <h2 class="section-title">PILIH PAKET YANG <br>SESUAI UNTUKMU</h2>
            <p class="pricing__desc">Mulai dari latihan harian hingga pengalaman premium tanpa batas.</p>
        </div>
        <div class="pricing__chips">
            <button onclick="filterPaket('semua')" id="chip-semua" class="chip-btn chip-btn--active">Semua</button>
            <button onclick="filterPaket('bulanan')" id="chip-bulanan" class="chip-btn chip-btn--inactive">Bulanan</button>
            <button onclick="filterPaket('tahunan')" id="chip-tahunan" class="chip-btn chip-btn--inactive">Tahunan</button>
            <button onclick="filterPaket('personal')" id="chip-personal" class="chip-btn chip-btn--inactive">Personal Training</button>
        </div>
        <div class="pricing__grid">
            <div class="paket-card bulanan tahunan">
                <p class="paket-card__tier">Basic</p>
                <p class="paket-card__price">499<span>k</span></p>
                <p class="paket-card__period">/bulan</p>
                <ul class="paket-card__features">
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Akses jam 06.00 - 17.00</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Free locker & cardio area</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> 1 sesi konsultasi trainer</li>
                </ul>
                <a href="#booking" class="btn-outline" style="display:block;text-align:center;">PILIH PAKET</a>
            </div>
            <div class="paket-card paket-card--featured bulanan tahunan">
                <div class="paket-card__badge">PALING POPULER</div>
                <p class="paket-card__tier">Pro</p>
                <p class="paket-card__price">899<span>k</span></p>
                <p class="paket-card__period">/bulan</p>
                <ul class="paket-card__features">
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Akses penuh 06.00 - 23.00</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Semua fasilitas gym</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> 4x sesi personal trainer</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Akses kelas grup</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Body composition analysis</li>
                </ul>
                <a href="#booking" class="btn-primary" style="display:block;text-align:center;">PILIH PAKET</a>
            </div>
            <div class="paket-card tahunan personal">
                <p class="paket-card__tier">Elite</p>
                <p class="paket-card__price">1.499<span>k</span></p>
                <p class="paket-card__period">/bulan</p>
                <ul class="paket-card__features">
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Akses tanpa batas</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Unlimited personal trainer</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Nutrition planning</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Lounge access VIP</li>
                    <li class="paket-card__feature"><span class="paket-card__feature-check">✓</span> Tamu +1 setiap sesi</li>
                </ul>
                <a href="#booking" class="btn-outline" style="display:block;text-align:center;">PILIH PAKET</a>
            </div>
        </div>
    </div>
</section>
<script>
function filterPaket(kategori) {
    document.querySelectorAll('.chip-btn').forEach(c => {
        c.classList.remove('chip-btn--active');
        c.classList.add('chip-btn--inactive');
    });
    document.getElementById('chip-'+kategori).classList.add('chip-btn--active');
    document.getElementById('chip-'+kategori).classList.remove('chip-btn--inactive');
    document.querySelectorAll('.paket-card').forEach(card => {
        card.style.display = (kategori==='semua' || card.classList.contains(kategori)) ? 'block' : 'none';
    });
}
</script>