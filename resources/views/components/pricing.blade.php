<section id="paket" class="bg-[#111111] py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-6 h-[2px] bg-[#CCFF00]"></div>
            <span class="text-[#CCFF00] text-xs font-bold tracking-widest uppercase">Paket Membership</span>
        </div>
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <h2 class="text-3xl md:text-5xl font-black uppercase leading-tight">PILIH PAKET YANG <br>SESUAI UNTUKMU</h2>
            <p class="text-white/40 text-sm max-w-xs">Mulai dari latihan harian hingga pengalaman premium tanpa batas.</p>
        </div>
        <div class="flex gap-2 mb-8 overflow-x-auto pb-2">
            <button onclick="filterPaket('semua')" id="chip-semua" class="chip-btn bg-[#CCFF00] text-black text-xs font-bold px-4 py-2 rounded-full whitespace-nowrap">Semua</button>
            <button onclick="filterPaket('bulanan')" id="chip-bulanan" class="chip-btn bg-white/10 text-white text-xs font-bold px-4 py-2 rounded-full whitespace-nowrap">Bulanan</button>
            <button onclick="filterPaket('tahunan')" id="chip-tahunan" class="chip-btn bg-white/10 text-white text-xs font-bold px-4 py-2 rounded-full whitespace-nowrap">Tahunan</button>
            <button onclick="filterPaket('personal')" id="chip-personal" class="chip-btn bg-white/10 text-white text-xs font-bold px-4 py-2 rounded-full whitespace-nowrap">Personal Training</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="paket-card bulanan tahunan bg-[#1a1a1a] rounded-2xl p-6 border border-white/10">
                <p class="text-white/40 text-xs font-bold uppercase mb-2">Basic</p>
                <p class="text-4xl font-black text-white mb-1">499<span class="text-lg text-white/40">k</span></p>
                <p class="text-white/30 text-xs mb-6">/bulan</p>
                <ul class="space-y-3 text-sm text-white/60 mb-8">
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Akses jam 06.00 - 17.00</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Free locker & cardio area</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> 1 sesi konsultasi trainer</li>
                </ul>
                <a href="#booking" class="block text-center border border-white/20 text-white text-xs font-bold py-3 rounded-full hover:border-[#CCFF00] hover:text-[#CCFF00] transition">PILIH PAKET</a>
            </div>
            <div class="paket-card bulanan tahunan bg-[#0a0a0a] rounded-2xl p-6 border-2 border-[#CCFF00] relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#CCFF00] text-black text-xs font-black px-4 py-1 rounded-full">PALING POPULER</div>
                <p class="text-white/40 text-xs font-bold uppercase mb-2">Pro</p>
                <p class="text-4xl font-black text-white mb-1">899<span class="text-lg text-white/40">k</span></p>
                <p class="text-white/30 text-xs mb-6">/bulan</p>
                <ul class="space-y-3 text-sm text-white/60 mb-8">
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Akses penuh 06.00 - 23.00</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Semua fasilitas gym</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> 4x sesi personal trainer</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Akses kelas grup</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Body composition analysis</li>
                </ul>
                <a href="#booking" class="block text-center bg-[#CCFF00] text-black text-xs font-bold py-3 rounded-full hover:bg-[#b8e600] transition">PILIH PAKET</a>
            </div>
            <div class="paket-card tahunan personal bg-[#1a1a1a] rounded-2xl p-6 border border-white/10">
                <p class="text-white/40 text-xs font-bold uppercase mb-2">Elite</p>
                <p class="text-4xl font-black text-white mb-1">1.499<span class="text-lg text-white/40">k</span></p>
                <p class="text-white/30 text-xs mb-6">/bulan</p>
                <ul class="space-y-3 text-sm text-white/60 mb-8">
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Akses tanpa batas</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Unlimited personal trainer</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Nutrition planning</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Lounge access VIP</li>
                    <li class="flex items-center gap-2"><span class="text-[#CCFF00]">✓</span> Tamu +1 setiap sesi</li>
                </ul>
                <a href="#booking" class="block text-center border border-white/20 text-white text-xs font-bold py-3 rounded-full hover:border-[#CCFF00] hover:text-[#CCFF00] transition">PILIH PAKET</a>
            </div>
        </div>
    </div>
</section>
<script>
function filterPaket(kategori) {
    document.querySelectorAll('.chip-btn').forEach(c => {
        c.classList.remove('bg-[#CCFF00]','text-black');
        c.classList.add('bg-white/10','text-white');
    });
    document.getElementById('chip-'+kategori).classList.add('bg-[#CCFF00]','text-black');
    document.getElementById('chip-'+kategori).classList.remove('bg-white/10','text-white');
    document.querySelectorAll('.paket-card').forEach(card => {
        card.style.display = (kategori==='semua' || card.classList.contains(kategori)) ? 'block' : 'none';
    });
}
</script>
