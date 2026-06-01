<section class="cta">
    <div class="cta__bg">
        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600&q=80" alt="Siboti Gym Semarang">
        <div class="cta__bg-overlay"></div>
    </div>
    <div class="cta__content">
        <h2 class="cta__title">SIAP MEMULAI <br><span>PERJALANANMU?</span></h2>
        <p class="cta__desc">Kunjungi Siboti Gym dan rasakan pengalaman latihan premium.</p>
        @guest
            <a href="{{ route('login') }}" class="btn-primary">BOOKING SEKARANG JUGA →</a>
        @else
            <a href="{{ url('/hub/booking') }}" class="btn-primary">BOOKING SEKARANG JUGA →</a>
        @endguest
        <div class="cta__meta">
            <span>📍 Jl. Sudirman No. 10, Semarang</span>
            <span>🕐 Senin – Minggu, 06.00 – 23.00</span>
        </div>
    </div>
</section>