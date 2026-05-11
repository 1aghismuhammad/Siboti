<section id="booking" class="bg-[#111111] py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-6 h-[2px] bg-[#CCFF00]"></div>
            <span class="text-[#CCFF00] text-xs font-bold tracking-widest uppercase">Booking Sesi</span>
        </div>
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <h2 class="text-3xl md:text-5xl font-black uppercase leading-tight">BOOKING SESI <br>DALAM 2 LANGKAH.</h2>
            <p class="text-white/40 text-sm max-w-xs">Tanpa biaya pendaftaran. Pilih, konfirmasi, datang.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Step 1: Pilih Tanggal --}}
            <div class="bg-[#1a1a1a] rounded-2xl p-6 border border-white/10">
                <div class="flex items-center gap-3 mb-6">
                    <span class="bg-[#CCFF00] text-black text-xs font-black w-6 h-6 rounded-full flex items-center justify-center">1</span>
                    <p class="text-white font-bold text-sm">Pilih Tanggal</p>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <button onclick="prevMonth()" class="text-white/40 hover:text-white transition text-xl">‹</button>
                    <p id="month-label" class="text-sm font-bold text-white"></p>
                    <button onclick="nextMonth()" class="text-white/40 hover:text-white transition text-xl">›</button>
                </div>
                <div class="grid grid-cols-7 text-center text-xs text-white/30 mb-2">
                    <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
                </div>
                <div id="calendar-days" class="grid grid-cols-7 text-center text-sm gap-y-1"></div>
            </div>

            {{-- Step 2: Pilih Waktu --}}
            <div class="bg-[#1a1a1a] rounded-2xl p-6 border border-white/10">
                <div class="flex items-center gap-3 mb-2">
                    <span class="bg-[#CCFF00] text-black text-xs font-black w-6 h-6 rounded-full flex items-center justify-center">2</span>
                    <p class="text-white font-bold text-sm">Pilih Waktu</p>
                </div>
                <p id="selected-date-label" class="text-white/30 text-xs mb-2">Belum ada tanggal dipilih</p>
                <p class="text-white/20 text-xs mb-6">Maksimal 2 sesi, harus jam berdekatan</p>

                <div class="grid grid-cols-3 gap-3 mb-6">
                    @foreach(['06.00','08.00','10.00','14.00','16.00','19.00'] as $jam)
                    <button onclick="pilihWaktu(this)"
                        data-jam="{{ $jam }}"
                        class="waktu-btn border border-white/10 text-white/60 text-xs font-bold py-3 rounded-xl hover:border-[#CCFF00] hover:text-[#CCFF00] transition">
                        {{ $jam }}
                    </button>
                    @endforeach
                </div>

                {{-- Ringkasan pilihan --}}
                <div id="ringkasan" class="hidden bg-[#0a0a0a] rounded-xl px-4 py-3 mb-4 text-xs text-white/50">
                    Sesi dipilih: <span id="ringkasan-waktu" class="text-[#CCFF00] font-bold"></span>
                </div>

                <a href="#" onclick="konfirmasi(event)"
                   class="block text-center bg-[#CCFF00] text-black text-sm font-bold py-3.5 rounded-full hover:bg-[#b8e600] transition">
                    KONFIRMASI BOOKING
                </a>
            </div>

        </div>
    </div>
</section>

<script>
const jadwal = ['06.00','08.00','10.00','14.00','16.00','19.00'];
let selectedWaktu = [];
let currentDate = new Date();
let selectedDate = null;

// ── Kalender ──────────────────────────────────────────
function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const months = ['Januari','Februari','Maret','April','Mei','Juni',
                    'Juli','Agustus','September','Oktober','November','Desember'];
    document.getElementById('month-label').textContent = months[month] + ' ' + year;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();
    let html = '';

    for (let i = 0; i < firstDay; i++) html += '<span></span>';

    for (let d = 1; d <= daysInMonth; d++) {
        const isToday    = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
        const isSelected = selectedDate && d === selectedDate.getDate() && month === selectedDate.getMonth() && year === selectedDate.getFullYear();
        const isPast     = new Date(year, month, d) < new Date(today.getFullYear(), today.getMonth(), today.getDate());

        let cls = 'w-8 h-8 mx-auto rounded-full text-xs font-bold transition ';
        if (isSelected)     cls += 'bg-[#CCFF00] text-black';
        else if (isToday)   cls += 'border border-[#CCFF00] text-[#CCFF00]';
        else if (isPast)    cls += 'text-white/20 cursor-not-allowed';
        else                cls += 'text-white/60 hover:text-white';

        html += `<button onclick="pilihTanggal(${d})" class="${cls}" ${isPast ? 'disabled' : ''}>${d}</button>`;
    }
    document.getElementById('calendar-days').innerHTML = html;
}

function pilihTanggal(d) {
    selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), d);
    const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni',
                    'Juli','Agustus','September','Oktober','November','Desember'];
    document.getElementById('selected-date-label').textContent =
        days[selectedDate.getDay()] + ', ' + d + ' ' + months[selectedDate.getMonth()] + ' ' + selectedDate.getFullYear();

    // Reset pilihan waktu saat ganti tanggal
    selectedWaktu = [];
    document.querySelectorAll('.waktu-btn').forEach(b => {
        b.classList.remove('bg-[#CCFF00]', 'text-black');
        b.classList.add('border-white/10', 'text-white/60');
    });
    updateRingkasan();
    renderCalendar();
}

function prevMonth() { currentDate.setMonth(currentDate.getMonth() - 1); renderCalendar(); }
function nextMonth() { currentDate.setMonth(currentDate.getMonth() + 1); renderCalendar(); }

// ── Pilih Waktu ───────────────────────────────────────
function pilihWaktu(btn) {
    const jam = btn.dataset.jam;
    const idx = jadwal.indexOf(jam);

    // Deselect jika sudah dipilih
    if (selectedWaktu.includes(jam)) {
        selectedWaktu = selectedWaktu.filter(j => j !== jam);
        btn.classList.remove('bg-[#CCFF00]', 'text-black');
        btn.classList.add('border-white/10', 'text-white/60');
        updateRingkasan();
        return;
    }

    // Maksimal 2 sesi
    if (selectedWaktu.length >= 2) {
        showToast('Maksimal 2 sesi per booking!');
        return;
    }

    // Harus berdekatan jika sudah ada 1 pilihan
    if (selectedWaktu.length === 1) {
        const idxPertama = jadwal.indexOf(selectedWaktu[0]);
        if (Math.abs(idx - idxPertama) !== 1) {
            showToast('Pilih jam yang berdekatan!\nContoh: 06.00 → 08.00');
            return;
        }
    }

    selectedWaktu.push(jam);
    btn.classList.add('bg-[#CCFF00]', 'text-black');
    btn.classList.remove('border-white/10', 'text-white/60');
    updateRingkasan();
}

function updateRingkasan() {
    const el = document.getElementById('ringkasan');
    const elWaktu = document.getElementById('ringkasan-waktu');
    if (selectedWaktu.length > 0) {
        const sorted = [...selectedWaktu].sort((a, b) => jadwal.indexOf(a) - jadwal.indexOf(b));
        elWaktu.textContent = sorted.join(' - ');
        el.classList.remove('hidden');
    } else {
        el.classList.add('hidden');
    }
}

function konfirmasi(e) {
    e.preventDefault();
    if (!selectedDate) { showToast('Pilih tanggal terlebih dahulu!'); return; }
    if (selectedWaktu.length === 0) { showToast('Pilih minimal 1 sesi waktu!'); return; }
    const sorted  = [...selectedWaktu].sort((a, b) => jadwal.indexOf(a) - jadwal.indexOf(b));
    const days    = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months  = ['Januari','Februari','Maret','April','Mei','Juni',
                     'Juli','Agustus','September','Oktober','November','Desember'];
    const tgl = days[selectedDate.getDay()] + ', ' + selectedDate.getDate() + ' ' +
                months[selectedDate.getMonth()] + ' ' + selectedDate.getFullYear();
    showToast('✅ Booking dikonfirmasi!\n📅 ' + tgl + '\n⏰ ' + sorted.join(' & '), true);
}

// ── Toast Notification ────────────────────────────────
function showToast(msg, success = false) {
    const existing = document.getElementById('toast-notif');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'toast-notif';
    toast.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);z-index:9999;' +
        'background:' + (success ? '#CCFF00' : '#1a1a1a') + ';color:' + (success ? '#000' : '#fff') + ';' +
        'padding:12px 20px;border-radius:12px;font-size:12px;font-weight:700;white-space:pre-line;' +
        'text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);border:1px solid ' + (success ? '#CCFF00' : 'rgba(255,255,255,0.1)');
    toast.textContent = msg;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

renderCalendar();
</script>