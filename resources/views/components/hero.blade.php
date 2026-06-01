<section class="hero">
    <div class="hero__bg">
        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600&q=80" alt="Gym Background">
        <div class="hero__bg-overlay"></div>
    </div>
    <div class="hero__content">
        <div class="section-label">
            <div class="section-label__line"></div>
            <span class="section-label__text">Gym Premium · Semarang</span>
        </div>
        <h1 class="hero__heading">
            BENTUK TUBUH <br>
            TERBAIKMU,<br>
            <span>MULAI HARI INI.</span>
        </h1>
        <p class="hero__subtext">
            Latihan profesional, peralatan modern, dan suasana premium dalam satu tempat.
        </p>
        <div class="hero__buttons">
            @guest
                <a href="{{ route('login') }}" class="btn-primary">BOOKING SEKARANG →</a>
            @else
                <a href="#booking" class="btn-primary">BOOKING SEKARANG →</a>
            @endguest
            <a href="#fasilitas" class="hero__btn-secondary">Lihat Fasilitas →</a>
        </div>
    </div>
</section>