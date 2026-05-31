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

            {{-- Step 1: Pilih Tanggal --}}
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

            {{-- Step 2: Pilih Waktu --}}
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
                <a href="#" onclick="bukaPopup1(event)" class="btn-primary" style="display:block;text-align:center;">
                    KONFIRMASI BOOKING
                </a>
            </div>

        </div>

        {{-- ═══ RIWAYAT BOOKING ═══ --}}
        <div id="riwayat-section" style="display:none;margin-top:2.5rem;">
            <div style="border-top:1px solid rgba(255,255,255,0.06);padding-top:2rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:0.75rem;">
                    <div>
                        <p style="font-size:1rem;font-weight:900;color:#fff;">3 Booking Terakhir</p>
                    </div>
                    <button onclick="hapusSemuaRiwayat()"
                        style="font-size:0.7rem;font-weight:600;color:rgba(255,100,100,0.6);background:none;border:1px solid rgba(255,100,100,0.2);padding:0.4rem 0.875rem;border-radius:0.5rem;cursor:pointer;font-family:'Inter',sans-serif;"
                        onmouseover="this.style.borderColor='rgba(255,100,100,0.5)';this.style.color='rgba(255,100,100,0.9)'"
                        onmouseout="this.style.borderColor='rgba(255,100,100,0.2)';this.style.color='rgba(255,100,100,0.6)'">
                        Hapus Semua
                    </button>
                </div>
                <div id="riwayat-list" style="display:flex;flex-direction:column;gap:0.75rem;"></div>
            </div>
        </div>

    </div>
</section>

{{-- ═══ POPUP 1: Ringkasan Booking ═══ --}}
<div id="popup-ringkasan" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);z-index:999;align-items:center;justify-content:center;padding:1rem;backdrop-filter:blur(6px);">
    <div style="background:#111111;border-radius:1.25rem;border:1px solid rgba(255,255,255,0.1);width:100%;max-width:420px;padding:2rem;position:relative;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <p style="font-size:1.1rem;font-weight:900;color:#fff;">Konfirmasi Booking</p>
            <button onclick="tutupPopup1()" style="width:1.75rem;height:1.75rem;border-radius:50%;background:rgba(255,255,255,0.06);border:none;color:rgba(255,255,255,0.5);cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.875rem;margin-bottom:1.75rem;">
            <div style="display:flex;align-items:center;gap:0.875rem;padding:0.875rem 1rem;background:rgba(255,255,255,0.04);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.06);">
                <span style="font-size:1.25rem;">👤</span>
                <div>
                    <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.3);">Member</p>
                    <p style="font-size:0.875rem;font-weight:700;color:#fff;">Budi Santoso</p>
                </div>
                <span style="margin-left:auto;background:rgba(204,255,0,0.1);color:#CCFF00;font-size:0.6rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:9999px;">Paket Pro</span>
            </div>
            <div style="display:flex;align-items:center;gap:0.875rem;padding:0.875rem 1rem;background:rgba(255,255,255,0.04);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.06);">
                <span style="font-size:1.25rem;">📅</span>
                <div>
                    <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.3);">Tanggal</p>
                    <p id="popup-tanggal" style="font-size:0.875rem;font-weight:700;color:#fff;">-</p>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:0.875rem;padding:0.875rem 1rem;background:rgba(255,255,255,0.04);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.06);">
                <span style="font-size:1.25rem;">⏰</span>
                <div>
                    <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.3);">Waktu Sesi</p>
                    <p id="popup-waktu" style="font-size:0.875rem;font-weight:700;color:#CCFF00;">-</p>
                </div>
            </div>
            {{-- Baris nominal --}}
            <div style="display:flex;align-items:center;justify-content:space-between;padding:0.875rem 1rem;background:rgba(204,255,0,0.05);border-radius:0.75rem;border:1px solid rgba(204,255,0,0.15);">
                <div style="display:flex;align-items:center;gap:0.875rem;">
                    <span style="font-size:1.25rem;">💳</span>
                    <div>
                        <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.3);">Total Pembayaran</p>
                        <p id="popup-nominal" style="font-size:0.875rem;font-weight:900;color:#CCFF00;">-</p>
                    </div>
                </div>
                <span id="popup-jumlah-sesi" style="font-size:0.65rem;font-weight:600;color:rgba(204,255,0,0.5);"></span>
            </div>
        </div>
        <p style="font-size:0.7rem;color:rgba(255,255,255,0.3);text-align:center;margin-bottom:1.25rem;line-height:1.5;">
            Pastikan data sudah benar sebelum konfirmasi.
        </p>
        <div style="display:flex;gap:0.75rem;">
            <button onclick="tutupPopup1()"
                style="flex:1;padding:0.875rem;border-radius:0.625rem;border:1px solid rgba(255,255,255,0.1);background:transparent;color:rgba(255,255,255,0.5);font-size:0.875rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;"
                onmouseover="this.style.borderColor='rgba(255,255,255,0.3)';this.style.color='#fff'"
                onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';this.style.color='rgba(255,255,255,0.5)'">
                Batal
            </button>
            <button onclick="lanjutKePayment()"
                style="flex:2;padding:0.875rem;border-radius:0.625rem;border:none;background:#CCFF00;color:#000;font-size:0.875rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;"
                onmouseover="this.style.background='#b8e600'"
                onmouseout="this.style.background='#CCFF00'">
                LANJUT BAYAR →
            </button>
        </div>
    </div>
</div>

{{-- ═══ POPUP 2: QR Payment ═══ --}}
<div id="popup-payment" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.8);z-index:1000;align-items:center;justify-content:center;padding:1rem;backdrop-filter:blur(8px);">
    <div style="background:#111111;border-radius:1.25rem;border:1px solid rgba(255,255,255,0.1);width:100%;max-width:400px;padding:2rem;position:relative;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <div>
                <p style="font-size:1.1rem;font-weight:900;color:#fff;margin:0;">Pembayaran QRIS</p>
                <p style="font-size:0.7rem;color:rgba(255,255,255,0.3);margin:0.2rem 0 0;">Scan QR untuk membayar</p>
            </div>
            <button onclick="tutupPopupPayment()" style="width:1.75rem;height:1.75rem;border-radius:50%;background:rgba(255,255,255,0.06);border:none;color:rgba(255,255,255,0.5);cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;">✕</button>
        </div>

        {{-- Nominal --}}
        <div style="text-align:center;margin-bottom:1.25rem;">
            <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.3);margin-bottom:0.25rem;">Total Pembayaran</p>
            <p id="payment-nominal" style="font-size:2rem;font-weight:900;color:#CCFF00;letter-spacing:-0.02em;">Rp 50.000</p>
            <p id="payment-detail-sesi" style="font-size:0.7rem;color:rgba(255,255,255,0.3);margin-top:0.2rem;">1 sesi × Rp 50.000</p>
        </div>

        {{-- QR Box --}}
        <div id="qr-container" style="position:relative;margin:0 auto 1.25rem;width:220px;">

            {{-- QR Active State --}}
            <div id="qr-active" style="background:#fff;border-radius:1rem;padding:1.25rem;text-align:center;">
                {{-- Dummy QR SVG --}}
                <svg id="qr-svg" width="176" height="176" viewBox="0 0 176 176" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Top-left finder pattern -->
                    <rect x="8" y="8" width="48" height="48" rx="4" fill="#000"/>
                    <rect x="16" y="16" width="32" height="32" rx="2" fill="#fff"/>
                    <rect x="22" y="22" width="20" height="20" rx="1" fill="#000"/>
                    <!-- Top-right finder pattern -->
                    <rect x="120" y="8" width="48" height="48" rx="4" fill="#000"/>
                    <rect x="128" y="16" width="32" height="32" rx="2" fill="#fff"/>
                    <rect x="134" y="22" width="20" height="20" rx="1" fill="#000"/>
                    <!-- Bottom-left finder pattern -->
                    <rect x="8" y="120" width="48" height="48" rx="4" fill="#000"/>
                    <rect x="16" y="128" width="32" height="32" rx="2" fill="#fff"/>
                    <rect x="22" y="134" width="20" height="20" rx="1" fill="#000"/>
                    <!-- Data modules (dummy pattern) -->
                    <rect x="68" y="8" width="8" height="8" fill="#000"/>
                    <rect x="82" y="8" width="8" height="8" fill="#000"/>
                    <rect x="96" y="8" width="8" height="8" fill="#000"/>
                    <rect x="68" y="22" width="8" height="8" fill="#000"/>
                    <rect x="96" y="22" width="8" height="8" fill="#000"/>
                    <rect x="68" y="36" width="8" height="8" fill="#000"/>
                    <rect x="82" y="36" width="8" height="8" fill="#000"/>
                    <rect x="8" y="68" width="8" height="8" fill="#000"/>
                    <rect x="22" y="68" width="8" height="8" fill="#000"/>
                    <rect x="36" y="68" width="8" height="8" fill="#000"/>
                    <rect x="8" y="82" width="8" height="8" fill="#000"/>
                    <rect x="36" y="82" width="8" height="8" fill="#000"/>
                    <rect x="22" y="96" width="8" height="8" fill="#000"/>
                    <rect x="36" y="96" width="8" height="8" fill="#000"/>
                    <rect x="68" y="68" width="8" height="8" fill="#000"/>
                    <rect x="82" y="68" width="8" height="8" fill="#000"/>
                    <rect x="96" y="68" width="8" height="8" fill="#000"/>
                    <rect x="110" y="68" width="8" height="8" fill="#000"/>
                    <rect x="68" y="82" width="8" height="8" fill="#000"/>
                    <rect x="110" y="82" width="8" height="8" fill="#000"/>
                    <rect x="82" y="96" width="8" height="8" fill="#000"/>
                    <rect x="96" y="96" width="8" height="8" fill="#000"/>
                    <rect x="120" y="68" width="8" height="8" fill="#000"/>
                    <rect x="134" y="68" width="8" height="8" fill="#000"/>
                    <rect x="148" y="68" width="8" height="8" fill="#000"/>
                    <rect x="162" y="68" width="8" height="8" fill="#000"/>
                    <rect x="120" y="82" width="8" height="8" fill="#000"/>
                    <rect x="148" y="82" width="8" height="8" fill="#000"/>
                    <rect x="134" y="96" width="8" height="8" fill="#000"/>
                    <rect x="162" y="96" width="8" height="8" fill="#000"/>
                    <rect x="8" y="120" width="8" height="8" fill="none"/>
                    <rect x="68" y="120" width="8" height="8" fill="#000"/>
                    <rect x="96" y="120" width="8" height="8" fill="#000"/>
                    <rect x="110" y="120" width="8" height="8" fill="#000"/>
                    <rect x="124" y="120" width="8" height="8" fill="#000"/>
                    <rect x="148" y="120" width="8" height="8" fill="#000"/>
                    <rect x="68" y="134" width="8" height="8" fill="#000"/>
                    <rect x="82" y="134" width="8" height="8" fill="#000"/>
                    <rect x="124" y="134" width="8" height="8" fill="#000"/>
                    <rect x="162" y="134" width="8" height="8" fill="#000"/>
                    <rect x="68" y="148" width="8" height="8" fill="#000"/>
                    <rect x="96" y="148" width="8" height="8" fill="#000"/>
                    <rect x="110" y="148" width="8" height="8" fill="#000"/>
                    <rect x="138" y="148" width="8" height="8" fill="#000"/>
                    <rect x="162" y="148" width="8" height="8" fill="#000"/>
                    <rect x="68" y="162" width="8" height="8" fill="#000"/>
                    <rect x="82" y="162" width="8" height="8" fill="#000"/>
                    <rect x="110" y="162" width="8" height="8" fill="#000"/>
                    <rect x="138" y="162" width="8" height="8" fill="#000"/>
                    <rect x="152" y="162" width="8" height="8" fill="#000"/>
                    <!-- Center logo placeholder -->
                    <rect x="76" y="76" width="24" height="24" rx="4" fill="#CCFF00"/>
                    <text x="88" y="92" text-anchor="middle" font-size="11" font-weight="900" fill="#000" font-family="Inter,sans-serif">SG</text>
                </svg>
                {{-- QRIS label --}}
                <div style="margin-top:0.5rem;display:flex;align-items:center;justify-content:center;gap:0.4rem;">
                    <div style="height:2px;width:20px;background:#e0e0e0;border-radius:1px;"></div>
                    <p style="font-size:0.65rem;font-weight:800;color:#999;letter-spacing:0.15em;">QRIS</p>
                    <div style="height:2px;width:20px;background:#e0e0e0;border-radius:1px;"></div>
                </div>
            </div>

            {{-- QR Expired Overlay --}}
            <div id="qr-expired" style="display:none;position:absolute;inset:0;background:rgba(17,17,17,0.92);border-radius:1rem;display:none;flex-direction:column;align-items:center;justify-content:center;gap:0.75rem;">
                <div style="width:3rem;height:3rem;background:rgba(255,80,80,0.12);border-radius:50%;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,80,80,0.3);font-size:1.4rem;">⏰</div>
                <p style="font-size:0.8rem;font-weight:800;color:#fff;text-align:center;">QR Expired</p>
                <button onclick="generateUlangQR()"
                    style="font-size:0.75rem;font-weight:700;color:#000;background:#CCFF00;border:none;padding:0.5rem 1.25rem;border-radius:0.5rem;cursor:pointer;font-family:'Inter',sans-serif;"
                    onmouseover="this.style.background='#b8e600'"
                    onmouseout="this.style.background='#CCFF00'">
                    ↻ Generate Ulang
                </button>
            </div>

        </div>

        {{-- Timer --}}
        <div id="timer-box" style="display:flex;align-items:center;justify-content:center;gap:0.6rem;margin-bottom:1.25rem;">
            <div id="timer-dot" style="width:7px;height:7px;border-radius:50%;background:#CCFF00;animation:timerPulse 1.2s ease-in-out infinite;flex-shrink:0;"></div>
            <p style="font-size:0.75rem;color:rgba(255,255,255,0.5);">QR berlaku selama</p>
            <p id="timer-display" style="font-size:0.875rem;font-weight:800;color:#CCFF00;font-family:'Courier New',monospace;min-width:2.5rem;">05:00</p>
        </div>

        {{-- Info pembayaran --}}
        <div style="background:rgba(255,255,255,0.03);border-radius:0.75rem;padding:0.875rem 1rem;margin-bottom:1.25rem;border:1px solid rgba(255,255,255,0.06);">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                <p style="font-size:0.7rem;color:rgba(255,255,255,0.35);">Merchant</p>
                <p style="font-size:0.75rem;font-weight:700;color:#fff;">Siboti Gym</p>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                <p style="font-size:0.7rem;color:rgba(255,255,255,0.35);">Kode Booking</p>
                <p id="payment-kode" style="font-size:0.75rem;font-weight:700;color:#CCFF00;letter-spacing:0.08em;">SBT-DUMMY-001</p>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <p style="font-size:0.7rem;color:rgba(255,255,255,0.35);">Status</p>
                <span id="payment-status-badge" style="font-size:0.6rem;font-weight:700;background:rgba(255,200,0,0.1);color:#ffc107;padding:0.2rem 0.625rem;border-radius:9999px;border:1px solid rgba(255,200,0,0.2);">Menunggu Pembayaran</span>
            </div>
        </div>


        {{-- Tombol simulasi (untuk demo/testing) --}}
        <button onclick="simulasiBayarBerhasil()"
            style="width:100%;padding:0.875rem;border-radius:0.625rem;border:none;background:#CCFF00;color:#000;font-size:0.875rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;"
            onmouseover="this.style.background='#b8e600'"
            onmouseout="this.style.background='#CCFF00'">
            ✓ PEMBAYARAN BERHASIL
        </button>

    </div>
</div>

{{-- ═══ POPUP 3: Booking Berhasil ═══ --}}
<div id="popup-sukses" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);z-index:999;align-items:center;justify-content:center;padding:1rem;backdrop-filter:blur(6px);">
    <div style="background:#111111;border-radius:1.25rem;border:1px solid rgba(204,255,0,0.2);width:100%;max-width:420px;padding:2rem;text-align:center;">
        <div style="width:4rem;height:4rem;background:rgba(204,255,0,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:1.75rem;border:2px solid rgba(204,255,0,0.3);">✅</div>
        <p style="font-size:1.25rem;font-weight:900;color:#fff;margin-bottom:0.5rem;">Booking Berhasil!</p>
        <p id="sukses-detail" style="font-size:0.8rem;color:rgba(255,255,255,0.4);margin-bottom:0.25rem;">-</p>
        <div style="border-top:1px solid rgba(255,255,255,0.08);margin:1.5rem 0;"></div>
        <div style="background:rgba(255,255,255,0.03);border-radius:0.875rem;padding:1.25rem;margin-bottom:1.5rem;border:1px solid rgba(255,255,255,0.06);">
            <p style="font-size:0.75rem;font-weight:700;color:#fff;margin-bottom:0.5rem;">Langkah Selanjutnya</p>
            <p style="font-size:0.75rem;color:rgba(255,255,255,0.4);line-height:1.6;">
                Hubungi admin Siboti Gym untuk konfirmasi pembayaran dan mendapatkan kode booking kamu.
            </p>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.75rem;">
            <a id="wa-btn" href="#" target="_blank"
               style="display:flex;align-items:center;justify-content:center;gap:0.625rem;padding:0.875rem;border-radius:0.625rem;background:#25D366;color:#fff;font-size:0.875rem;font-weight:700;text-decoration:none;"
               onmouseover="this.style.background='#1fb855'"
               onmouseout="this.style.background='#25D366'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Chat WhatsApp Admin
            </a>
            <button onclick="tutupPopupSukses()"
                style="padding:0.875rem;border-radius:0.625rem;border:1px solid rgba(255,255,255,0.1);background:transparent;color:rgba(255,255,255,0.5);font-size:0.875rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;"
                onmouseover="this.style.borderColor='rgba(255,255,255,0.3)';this.style.color='#fff'"
                onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';this.style.color='rgba(255,255,255,0.5)'">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
@keyframes timerPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.75); }
}
@keyframes timerWarning {
    0%, 100% { color: #ff4444; }
    50% { color: rgba(255,68,68,0.4); }
}
.timer-warning {
    animation: timerWarning 0.8s ease-in-out infinite !important;
}
.timer-dot-warning {
    background: #ff4444 !important;
}
</style>

<script>
/* ════════════════════════════════════════
   CONFIG — backend tinggal ganti nilai ini
   ════════════════════════════════════════ */
const HARGA_PER_SESI = 50000;          // TODO: dari API
const QR_DURASI_DETIK = 5 * 60;        // 5 menit
const NOMOR_WA_ADMIN = '6281234567890'; // TODO: dari config

/* ════ State ════ */
const jadwal = ['06.00','08.00','10.00','14.00','16.00','19.00'];
let selectedWaktu = [];
let currentDate = new Date();
let selectedDate = null;
let timerInterval = null;
let sisaDetik = QR_DURASI_DETIK;

/* ════ Helper Format ════ */
function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}

function generateKodeBooking() {
    /* TODO: ganti dengan kode dari response backend */
    const rnd = Math.random().toString(36).substring(2, 6).toUpperCase();
    return 'SBT-' + rnd + '-' + new Date().getFullYear();
}

/* ════ Kalender ════ */
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
        const isToday=d===today.getDate()&&month===today.getMonth()&&year===today.getFullYear();
        const isSelected=selectedDate&&d===selectedDate.getDate()&&month===selectedDate.getMonth()&&year===selectedDate.getFullYear();
        const isPast=new Date(year,month,d)<new Date(today.getFullYear(),today.getMonth(),today.getDate());
        let cls='cal-day ';
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

/* ════ Popup 1: Konfirmasi ════ */
function bukaPopup1(e){
    e.preventDefault();
    if(!selectedDate){showToast('Pilih tanggal terlebih dahulu!');return;}
    if(selectedWaktu.length===0){showToast('Pilih minimal 1 sesi waktu!');return;}

    const sorted=[...selectedWaktu].sort((a,b)=>jadwal.indexOf(a)-jadwal.indexOf(b));
    const days=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const tgl=days[selectedDate.getDay()]+', '+selectedDate.getDate()+' '+months[selectedDate.getMonth()]+' '+selectedDate.getFullYear();

    const jumlahSesi = selectedWaktu.length;
    const total = jumlahSesi * HARGA_PER_SESI;

    document.getElementById('popup-tanggal').textContent = tgl;
    document.getElementById('popup-waktu').textContent = sorted.join(' & ');
    document.getElementById('popup-nominal').textContent = formatRupiah(total);
    document.getElementById('popup-jumlah-sesi').textContent = jumlahSesi + ' sesi';

    const popup = document.getElementById('popup-ringkasan');
    popup.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function tutupPopup1(){
    document.getElementById('popup-ringkasan').style.display = 'none';
    document.body.style.overflow = '';
}

/* ════ Popup 2: QR Payment ════ */
function lanjutKePayment(){
    const jumlahSesi = selectedWaktu.length;
    const total = jumlahSesi * HARGA_PER_SESI;
    const sorted=[...selectedWaktu].sort((a,b)=>jadwal.indexOf(a)-jadwal.indexOf(b));

    /* ── Isi konten payment ── */
    document.getElementById('payment-nominal').textContent = formatRupiah(total);
    document.getElementById('payment-detail-sesi').textContent = jumlahSesi + ' sesi × ' + formatRupiah(HARGA_PER_SESI);
    document.getElementById('payment-kode').textContent = generateKodeBooking();

    /* ── Reset QR state ── */
    resetQRState();

    /* ── Tutup popup 1, buka popup payment ── */
    tutupPopup1();
    document.getElementById('popup-payment').style.display = 'flex';
    document.body.style.overflow = 'hidden';

    /* ── Mulai timer ── */
    mulaiTimer();
}

function tutupPopupPayment(){
    stopTimer();
    document.getElementById('popup-payment').style.display = 'none';
    document.body.style.overflow = '';
}

/* ════ Timer Logic ════ */
function mulaiTimer(){
    sisaDetik = QR_DURASI_DETIK;
    updateTimerDisplay();
    timerInterval = setInterval(function(){
        sisaDetik--;
        updateTimerDisplay();
        if(sisaDetik <= 0){
            stopTimer();
            tampilkanQRExpired();
        }
    }, 1000);
}

function stopTimer(){
    if(timerInterval) { clearInterval(timerInterval); timerInterval = null; }
}

function updateTimerDisplay(){
    const menit = Math.floor(sisaDetik / 60);
    const detik = sisaDetik % 60;
    const display = String(menit).padStart(2,'0') + ':' + String(detik).padStart(2,'0');
    const timerEl = document.getElementById('timer-display');
    const dotEl = document.getElementById('timer-dot');

    timerEl.textContent = display;

    /* Warning state di 60 detik terakhir */
    if(sisaDetik <= 60){
        timerEl.style.color = '#ff4444';
        timerEl.classList.add('timer-warning');
        dotEl.style.background = '#ff4444';
    } else {
        timerEl.style.color = '#CCFF00';
        timerEl.classList.remove('timer-warning');
        dotEl.style.background = '#CCFF00';
    }
}

function tampilkanQRExpired(){
    document.getElementById('qr-expired').style.display = 'flex';
    document.getElementById('timer-display').textContent = '00:00';
    document.getElementById('timer-display').style.color = '#ff4444';
    document.getElementById('timer-dot').style.background = 'rgba(255,68,68,0.3)';
    /* Update status badge */
    const badge = document.getElementById('payment-status-badge');
    badge.textContent = 'QR Expired';
    badge.style.background = 'rgba(255,68,68,0.1)';
    badge.style.color = '#ff4444';
    badge.style.borderColor = 'rgba(255,68,68,0.2)';
}

function resetQRState(){
    document.getElementById('qr-expired').style.display = 'none';
    const badge = document.getElementById('payment-status-badge');
    badge.textContent = 'Menunggu Pembayaran';
    badge.style.background = 'rgba(255,200,0,0.1)';
    badge.style.color = '#ffc107';
    badge.style.borderColor = 'rgba(255,200,0,0.2)';
    document.getElementById('timer-display').style.color = '#CCFF00';
    document.getElementById('timer-dot').style.background = '#CCFF00';
}

function generateUlangQR(){
    /* TODO: panggil API backend untuk generate QR baru */
    document.getElementById('payment-kode').textContent = generateKodeBooking();
    resetQRState();
    stopTimer();
    mulaiTimer();
}

/* ════ Simulasi Bayar Berhasil (untuk dummy/testing) ════ */
function simulasiBayarBerhasil(){
    stopTimer();

    const sorted=[...selectedWaktu].sort((a,b)=>jadwal.indexOf(a)-jadwal.indexOf(b));
    const days=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const tgl=days[selectedDate.getDay()]+', '+selectedDate.getDate()+' '+months[selectedDate.getMonth()]+' '+selectedDate.getFullYear();

    document.getElementById('sukses-detail').textContent = tgl + ' · ' + sorted.join(' & ');

    const pesanWA = encodeURIComponent(
        'Halo Admin Siboti Gym! 👋\n' +
        'Saya ingin konfirmasi booking sesi latihan:\n\n' +
        '👤 Nama: Budi Santoso\n' +
        '📅 Tanggal: ' + tgl + '\n' +
        '⏰ Waktu: ' + sorted.join(' & ') + '\n' +
        '🎫 Paket: Pro\n' +
        '🧾 Kode: ' + document.getElementById('payment-kode').textContent + '\n\n' +
        'Mohon konfirmasi pembayaran. Terima kasih!'
    );
    document.getElementById('wa-btn').href = 'https://wa.me/' + NOMOR_WA_ADMIN + '?text=' + pesanWA;

    simpanRiwayat(tgl, sorted.join(' & '));
    tutupPopupPayment();
    document.getElementById('popup-sukses').style.display = 'flex';
}

/* ════ Popup 3: Sukses ════ */
function tutupPopupSukses(){
    document.getElementById('popup-sukses').style.display = 'none';
    document.body.style.overflow = '';
}

/* ════ Klik luar popup ════ */
document.getElementById('popup-ringkasan').addEventListener('click', function(e){
    if(e.target === this) tutupPopup1();
});
document.getElementById('popup-payment').addEventListener('click', function(e){
    if(e.target === this){ stopTimer(); tutupPopupPayment(); }
});
document.getElementById('popup-sukses').addEventListener('click', function(e){
    if(e.target === this) tutupPopupSukses();
});

/* ════ Riwayat Booking ════ */
function simpanRiwayat(tanggal, waktu) {
    let riwayat = JSON.parse(localStorage.getItem('siboti_booking') || '[]');
    riwayat.unshift({
        tanggal: tanggal,
        waktu: waktu,
        nama: 'Budi Santoso',
        paket: 'Pro',
        status: 'Menunggu Konfirmasi',
        created: new Date().toLocaleDateString('id-ID')
    });
    if(riwayat.length > 3) riwayat = riwayat.slice(0, 3);
    localStorage.setItem('siboti_booking', JSON.stringify(riwayat));
    tampilkanRiwayat();
}

function tampilkanRiwayat() {
    const riwayat = JSON.parse(localStorage.getItem('siboti_booking') || '[]');
    const section = document.getElementById('riwayat-section');
    const list = document.getElementById('riwayat-list');
    if(riwayat.length === 0){ section.style.display = 'none'; return; }
    section.style.display = 'block';
    list.innerHTML = riwayat.map(item => `
        <div style="background:#111111;border-radius:0.875rem;padding:1.25rem 1.5rem;border:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
            <div style="width:2.5rem;height:2.5rem;background:rgba(204,255,0,0.08);border-radius:0.625rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;border:1px solid rgba(204,255,0,0.15);">📅</div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:0.875rem;font-weight:700;color:#fff;margin-bottom:0.2rem;">${item.tanggal}</p>
                <p style="font-size:0.75rem;color:#CCFF00;font-weight:600;">⏰ ${item.waktu}</p>
            </div>
            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.35rem;">
                <span style="background:rgba(255,200,0,0.1);color:#ffc107;font-size:0.6rem;font-weight:700;padding:0.2rem 0.625rem;border-radius:9999px;border:1px solid rgba(255,200,0,0.2);">${item.status}</span>
                <span style="font-size:0.65rem;color:rgba(255,255,255,0.25);">Dibuat: ${item.created}</span>
            </div>
            <button onclick="hubungiAdmin('${item.tanggal}','${item.waktu}')"
                style="display:flex;align-items:center;gap:0.4rem;background:#25D366;color:#fff;border:none;padding:0.5rem 0.875rem;border-radius:0.5rem;font-size:0.7rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;white-space:nowrap;"
                onmouseover="this.style.background='#1fb855'"
                onmouseout="this.style.background='#25D366'">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Hubungi Admin
            </button>
        </div>
    `).join('');
}

function hubungiAdmin(tanggal, waktu) {
    const pesanWA = encodeURIComponent(
        'Halo Admin Siboti Gym! 👋\n' +
        'Saya ingin konfirmasi booking:\n\n' +
        '👤 Nama: Budi Santoso\n' +
        '📅 Tanggal: ' + tanggal + '\n' +
        '⏰ Waktu: ' + waktu + '\n' +
        '🎫 Paket: Pro\n\n' +
        'Mohon konfirmasi pembayaran. Terima kasih!'
    );
    window.open('https://wa.me/' + NOMOR_WA_ADMIN + '?text=' + pesanWA, '_blank');
}

function hapusSemuaRiwayat() {
    if(confirm('Hapus semua riwayat booking?')) {
        localStorage.removeItem('siboti_booking');
        tampilkanRiwayat();
    }
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
document.addEventListener('DOMContentLoaded', tampilkanRiwayat);
</script>