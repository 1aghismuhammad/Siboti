<section id="booking" class="booking">
    <div class="container">
        <div class="section-label">
            <div class="section-label__line"></div>
            <span class="section-label__text">Booking Sesi</span>
        </div>
        <div class="booking__header">
            <h2 class="section-title">BOOKING SESI <br>DALAM 2 LANGKAH.</h2>
            <p class="booking__desc">Tanpa biaya pendaftaran. Pilih, konfirmasi, datang.</p>
        </div>
        <div class="booking__grid">
            <div class="booking-card">
                <div class="booking-card__step">
                    <span class="booking-card__step-num">1</span>
                    <p class="booking-card__step-title">Pilih Tanggal</p>
                </div>
                <div class="calendar__nav">
                    <button onclick="prevMonth()" class="calendar__nav-btn">‹</button>
                    <p id="month-label" class="calendar__month"></p>
                    <button onclick="nextMonth()" class="calendar__nav-btn">›</button>
                </div>
                <div class="calendar__days-header">
                    <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
                </div>
                <div id="calendar-days" class="calendar__days"></div>
            </div>
            <div class="booking-card">
                <div class="booking-card__step">
                    <span class="booking-card__step-num">2</span>
                    <p class="booking-card__step-title">Pilih Waktu</p>
                </div>
                <p id="selected-date-label" class="waktu__date-label">Belum ada tanggal dipilih</p>
                <p class="waktu__hint">Maksimal 2 sesi, harus jam berdekatan</p>
                <div class="waktu__grid">
                    @foreach(['06.00','08.00','10.00','14.00','16.00','19.00'] as $jam)
                    <button onclick="pilihWaktu(this)" data-jam="{{ $jam }}" class="waktu-btn">{{ $jam }}</button>
                    @endforeach
                </div>
                <div id="ringkasan" class="ringkasan">
                    Sesi dipilih: <span id="ringkasan-waktu" class="ringkasan__waktu"></span>
                </div>
                @guest
                    <div class="booking__notice" style="margin-top:1rem; text-align:center;">
                        <p style="margin-bottom:1rem; color:#efefef;">Silakan login dulu untuk membuat booking.</p>
                        <a href="{{ route('login') }}" class="btn-primary" style="display:inline-block; text-align:center;">LOGIN / REGISTER</a>
                    </div>
                @else
                    <form id="bookingForm" method="POST" action="{{ route('member.booking.store') }}" style="margin-top:1rem;">
                        @csrf
                        <input type="hidden" name="booking_date" id="booking_date">
                        <input type="hidden" name="booking_time" id="booking_time">
                        <input type="hidden" name="session_type" id="session_type" value="Sesi Gym">
                        <button type="submit" onclick="konfirmasi(event)" class="btn-primary" style="display:block;text-align:center;">KONFIRMASI BOOKING</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</section>

<script>
const jadwal = ['06.00','08.00','10.00','14.00','16.00','19.00'];
let selectedWaktu = [];
let currentDate = new Date();
let selectedDate = null;

function renderCalendar() {
    const year = currentDate.getFullYear(), month = currentDate.getMonth();
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    document.getElementById('month-label').textContent = months[month] + ' ' + year;
    const firstDay = new Date(year,month,1).getDay();
    const daysInMonth = new Date(year,month+1,0).getDate();
    const today = new Date();
    let html = '';
    for(let i=0;i<firstDay;i++) html+='<span></span>';
    for(let d=1;d<=daysInMonth;d++){
        const isToday = d===today.getDate()&&month===today.getMonth()&&year===today.getFullYear();
        const isSelected = selectedDate&&d===selectedDate.getDate()&&month===selectedDate.getMonth()&&year===selectedDate.getFullYear();
        const isPast = new Date(year,month,d)<new Date(today.getFullYear(),today.getMonth(),today.getDate());
        let cls = 'cal-day ';
        if(isSelected) cls+='cal-day--selected';
        else if(isToday) cls+='cal-day--today';
        else if(isPast) cls+='cal-day--past';
        else cls+='cal-day--normal';
        html+=`<button onclick="pilihTanggal(${d})" class="${cls}" ${isPast?'disabled':''}>${d}</button>`;
    }
    document.getElementById('calendar-days').innerHTML=html;
}

function pilihTanggal(d){
    selectedDate=new Date(currentDate.getFullYear(),currentDate.getMonth(),d);
    const days=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    document.getElementById('selected-date-label').textContent=days[selectedDate.getDay()]+', '+d+' '+months[selectedDate.getMonth()]+' '+selectedDate.getFullYear();
    selectedWaktu=[];
    document.querySelectorAll('.waktu-btn').forEach(b=>{b.classList.remove('waktu-btn--active');});
    updateRingkasan();
    renderCalendar();
}

function prevMonth(){currentDate.setMonth(currentDate.getMonth()-1);renderCalendar();}
function nextMonth(){currentDate.setMonth(currentDate.getMonth()+1);renderCalendar();}

function pilihWaktu(btn){
    const jam=btn.dataset.jam;
    const idx=jadwal.indexOf(jam);
    if(selectedWaktu.includes(jam)){
        selectedWaktu=selectedWaktu.filter(j=>j!==jam);
        btn.classList.remove('waktu-btn--active');
        updateRingkasan(); return;
    }
    if(selectedWaktu.length>=2){showToast('Maksimal 2 sesi per booking!');return;}
    if(selectedWaktu.length===1){
        const idxPertama=jadwal.indexOf(selectedWaktu[0]);
        if(Math.abs(idx-idxPertama)!==1){showToast('Pilih jam yang berdekatan!\nContoh: 06.00 → 08.00');return;}
    }
    selectedWaktu.push(jam);
    btn.classList.add('waktu-btn--active');
    updateRingkasan();
}

function updateRingkasan(){
    const el=document.getElementById('ringkasan');
    const elW=document.getElementById('ringkasan-waktu');
    if(selectedWaktu.length>0){
        const sorted=[...selectedWaktu].sort((a,b)=>jadwal.indexOf(a)-jadwal.indexOf(b));
        elW.textContent=sorted.join(' - ');
        el.classList.add('ringkasan--visible');
    } else { el.classList.remove('ringkasan--visible'); }
}

function konfirmasi(e){
    e.preventDefault();
    if(!selectedDate){showToast('Pilih tanggal terlebih dahulu!');return;}
    if(selectedWaktu.length===0){showToast('Pilih minimal 1 sesi waktu!');return;}
    const sorted=[...selectedWaktu].sort((a,b)=>jadwal.indexOf(a)-jadwal.indexOf(b));
    const bookingDate = selectedDate.toISOString().slice(0,10);
    const bookingTime = sorted.join(' - ');
    const bookingDateInput = document.getElementById('booking_date');
    const bookingTimeInput = document.getElementById('booking_time');
    bookingDateInput.value = bookingDate;
    bookingTimeInput.value = bookingTime;
    showToast('✅ Booking dikonfirmasi!\n📅 '+bookingDate+'\n⏰ '+sorted.join(' & '),true);
    document.getElementById('bookingForm').submit();
}

function showToast(msg,success=false){
    const existing=document.getElementById('toast-notif');
    if(existing) existing.remove();
    const toast=document.createElement('div');
    toast.id='toast-notif';
    toast.style.cssText='position:fixed;bottom:80px;left:50%;transform:translateX(-50%);z-index:9999;background:'+(success?'#CCFF00':'#1a1a1a')+';color:'+(success?'#000':'#fff')+';padding:12px 20px;border-radius:12px;font-size:12px;font-weight:700;white-space:pre-line;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);border:1px solid '+(success?'#CCFF00':'rgba(255,255,255,0.1)');
    toast.textContent=msg;
    document.body.appendChild(toast);
    setTimeout(()=>toast.remove(),3000);
}

renderCalendar();
</script>