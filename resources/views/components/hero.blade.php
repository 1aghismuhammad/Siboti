<section class="relative min-h-screen flex items-center bg-[#0a0a0a] overflow-hidden">

    {{-- Background Image --}}
    <div class="absolute inset-0 z-0">
        <img
            src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600&q=80"
            alt="Gym Background"
            class="w-full h-full object-cover opacity-40"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-[#0a0a0a] via-[#0a0a0a]/70 to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 pt-24 pb-16">

        {{-- Label --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-[2px] bg-[#CCFF00]"></div>
            <span class="text-[#CCFF00] text-xs font-bold tracking-[0.2em] uppercase">
                Gym Premium · Semarang
            </span>
        </div>

        {{-- Heading --}}
        <h1 class="text-5xl md:text-7xl font-black uppercase leading-none mb-4">
            BENTUK TUBUH <br>
            TERBAIKMU,<br>
            <span class="text-[#CCFF00]">MULAI HARI INI.</span>
        </h1>

        {{-- Subtext --}}
        <p class="text-white/60 text-base md:text-lg max-w-md mt-6 mb-8 leading-relaxed">
            Latihan profesional, peralatan modern, dan suasana premium
            dalam satu tempat.
        </p>

        {{-- Buttons --}}
        <div class="flex items-center gap-6 flex-wrap">
            <a href="#booking"
               class="bg-[#CCFF00] text-black text-sm font-bold px-7 py-3.5 rounded-full hover:bg-[#b8e600] transition">
                BOOKING SEKARANG →
            </a>
            <a href="#fasilitas"
               class="text-white text-sm font-semibold hover:text-[#CCFF00] transition">
                Lihat Fasilitas →
            </a>
        </div>

    </div>
</section>