# Dokumen Scope Pengembangan SiBoti

**Project:** SiBoti - Sistem Manajemen Gym Digital  
**Jenis Dokumen:** Scope kerja backend, frontend, integrasi, dan standar responsive design  
**Tujuan:** Menjaga pengembangan aplikasi tetap sesuai rancangan awal, tidak melebar terlalu jauh dari desain website yang sudah dibuat.  
**Basis Rancangan:** Dokumen RPL Kelompok 4 dan source awal Laravel `Siboti-coba-frontend`.

---

## 1. Ringkasan Project

SiBoti adalah aplikasi manajemen gym digital yang dirancang untuk membantu operasional pusat kebugaran, khususnya pada proses membership, booking sesi latihan, QR check-in, pengelolaan jadwal trainer, input progres member, transaksi POS sederhana, dan laporan admin.

Source frontend yang sudah ada saat ini masih berupa landing page gym dengan struktur Laravel Blade. Halaman yang tersedia sudah mencakup beberapa section utama, yaitu:

- Navbar
- Hero section
- Statistik
- About
- Pricing / paket membership
- Trainers
- Booking sesi
- CTA
- Footer

Artinya, desain awal sudah memiliki arah visual yang jelas, yaitu website gym dengan nuansa premium, gelap, modern, dan aksen neon hijau. Pengembangan berikutnya tidak boleh mengubah arah desain secara ekstrem. Fokusnya adalah mengubah landing page statis menjadi aplikasi manajemen gym sederhana yang bisa berjalan.

---

## 2. Batasan Scope Project

Project ini tidak diarahkan menjadi sistem gym enterprise yang terlalu kompleks. Untuk kebutuhan RPL, target utama adalah membuat sistem yang bisa didemokan dengan alur yang jelas.

### Yang Akan Dibuat

Fitur yang masuk scope utama:

1. Landing page sesuai desain awal.
2. Login dan register user.
3. Role user: Admin, Member, Personal Trainer, dan Receptionist.
4. Dashboard berbeda berdasarkan role.
5. Membership plan dan status membership member.
6. Booking kelas atau sesi personal trainer.
7. QR Code check-in member.
8. Verifikasi kunjungan oleh receptionist.
9. Input progres fisik member oleh personal trainer.
10. POS sederhana untuk transaksi produk gym.
11. Laporan sederhana untuk admin.
12. Responsive design untuk Android dan website desktop.

### Yang Tidak Dibuat pada Versi Awal

Agar project tidak terlalu jauh dari rancangan awal, fitur berikut tidak menjadi prioritas MVP:

1. Payment gateway asli seperti Midtrans/Xendit.
2. Real-time chat antara member dan staff.
3. Mobile app native Android.
4. Sistem notifikasi real-time kompleks.
5. Multi-cabang gym.
6. Sistem payroll trainer.
7. Sistem inventory alat gym yang terlalu detail.
8. Laporan keuangan lanjutan.
9. Integrasi WhatsApp gateway.
10. Role Owner/Manager terpisah secara kompleks.

Jika diperlukan untuk demo, payment cukup dibuat simulasi dengan status `pending`, `paid`, atau `expired`.

---

## 3. Prinsip Desain yang Harus Dipertahankan

Desain awal SiBoti sudah memiliki identitas visual yang cukup kuat. Karena itu, pengembangan halaman dashboard dan fitur internal harus tetap mengikuti karakter visual landing page.

### Warna Utama

Palet warna SiBoti harus mengikuti konsep **dark premium + neon fitness accent** seperti rancangan visual awal. Palet ini dipakai konsisten untuk landing page, dashboard admin, dashboard member, dashboard trainer, dashboard receptionist, form, tabel, card, modal, dan komponen mobile Android.

| Elemen | Token CSS | Warna | Penggunaan |
|---|---|---|---|
| Background utama | `--bg-dark` | `#0a0a0a` | Body, halaman utama, area paling belakang |
| Background section | `--bg-section` | `#111111` | Pembeda antar section, navbar, sidebar, bottom navigation |
| Background card | `--bg-card` | `#1a1a1a` | Card, dashboard widget, form container, modal, tabel |
| Aksen utama/neon | `--neon` | `#CCFF00` | CTA utama, badge aktif, icon aktif, highlight angka/statistik |
| Aksen hover neon | `--neon-dark` | `#b8e600` | Hover button, hover link penting, active interaction |
| Teks utama | `--white` | `#ffffff` | Heading, label penting, angka utama |
| Teks sekunder | `--white-60` | `rgba(255,255,255,0.6)` | Deskripsi, subtitle, metadata |
| Teks nonaktif | `--white-40` | `rgba(255,255,255,0.4)` | Placeholder, menu nonaktif, keterangan kecil |
| Border halus | `--white-10` | `rgba(255,255,255,0.1)` | Border card, divider, garis tabel, outline input |
| Border aktif | `--neon-border` | `rgba(204,255,0,0.45)` | Focus input, card aktif, selected state |
| Shadow neon | `--neon-shadow` | `rgba(204,255,0,0.25)` | Glow halus pada button/card aktif |

Catatan penting: warna primer di source frontend saat ini adalah `#CCFF00`. Jika ingin dibuat lebih mendekati referensi visual pada gambar yang terlihat sedikit lebih terang, alternatifnya adalah `#D4FF00`. Namun untuk menjaga konsistensi dengan source yang sudah ada, standar project tetap memakai `#CCFF00` sebagai aksen utama.

### CSS Variable Standar

Frontend wajib menyimpan palet warna di satu tempat, yaitu pada `public/css/app.css` bagian `:root`. Jangan menulis warna langsung berulang-ulang di setiap komponen, karena nanti sulit dikontrol saat revisi desain.

```css
:root {
    /* Core Palette */
    --bg-dark: #0a0a0a;
    --bg-section: #111111;
    --bg-card: #1a1a1a;

    /* Brand Accent */
    --neon: #CCFF00;
    --neon-dark: #b8e600;
    --neon-border: rgba(204,255,0,0.45);
    --neon-shadow: rgba(204,255,0,0.25);

    /* Text */
    --white: #ffffff;
    --white-80: rgba(255,255,255,0.8);
    --white-60: rgba(255,255,255,0.6);
    --white-50: rgba(255,255,255,0.5);
    --white-40: rgba(255,255,255,0.4);
    --white-30: rgba(255,255,255,0.3);
    --white-20: rgba(255,255,255,0.2);
    --white-10: rgba(255,255,255,0.1);

    /* Layout */
    --max-width: 1280px;
    --px: 1.5rem;
}
```

### Aturan Penggunaan Warna

1. `#0a0a0a` dipakai untuk background utama agar website tetap terasa gelap, premium, dan tidak melelahkan mata.
2. `#111111` dipakai untuk section atau area pembeda supaya halaman tidak terlihat flat.
3. `#1a1a1a` dipakai untuk card, form, modal, table wrapper, dan komponen dashboard.
4. `#CCFF00` hanya dipakai sebagai aksen, bukan warna background besar. Warna ini efektif untuk CTA, status aktif, icon aktif, badge, garis highlight, dan angka penting.
5. Teks utama memakai putih penuh. Teks penjelas memakai opacity 60%. Teks minor memakai opacity 40%.
6. Border tidak boleh terlalu terang. Gunakan `rgba(255,255,255,0.1)` agar tampilan tetap halus.
7. Hover tidak perlu mengubah layout. Cukup ubah warna, border, shadow, atau transform kecil.
8. Jangan memakai warna tambahan yang terlalu jauh dari palet, seperti biru terang, ungu, merah dominan, atau gradient ramai, kecuali untuk status error/success yang benar-benar diperlukan.

### Karakter UI

Frontend harus menjaga gaya berikut:

- Dark mode sebagai default.
- Aksen neon hijau untuk CTA, status aktif, badge, dan elemen penting.
- Card rounded dengan border tipis.
- Layout bersih dan tidak terlalu ramai.
- Typography tebal untuk heading.
- Tombol berbentuk pill/rounded.
- Navbar mobile bawah tetap dipertahankan untuk pengalaman Android.
- Dashboard internal tetap terlihat seperti bagian dari brand SiBoti, bukan template admin generik.

---

## 4. Struktur Aktor dan Hak Akses

Aplikasi memiliki empat role utama.

| Role | Fungsi Utama | Akses Halaman |
|---|---|---|
| Member | Registrasi, membership, booking, QR check-in, melihat progres | Dashboard member, membership, booking, QR, progres |
| Personal Trainer | Mengatur jadwal dan input progres member | Dashboard trainer, jadwal, daftar klien, input progres |
| Receptionist | Verifikasi QR check-in dan transaksi POS | Dashboard receptionist, scan QR, POS |
|  | Mengelola master data, akun pengguna, laporan | Dashboard admin, paket, user, trainer, laporan |

### Catatan PM

Jangan memberikan semua akses ke semua role. Role harus jelas sejak awal karena ini memengaruhi route, menu, dashboard, dan validasi backend.

---

## 5. Scope Backend

Backend bertanggung jawab membuat sistem data, validasi, dan aturan bisnis. Backend tidak hanya membuat tabel, tetapi juga memastikan setiap fitur punya alur yang bisa digunakan frontend.

### Modul Backend yang Dibuat

| Modul | Detail Pekerjaan | Prioritas |
|---|---|---|
| Auth | Login, register, logout, session user | Wajib |
| Role Access | Middleware akses berdasarkan role | Wajib |
| User Management | Data user dan role | Wajib |
| Membership Plan | CRUD paket membership | Wajib |
| Subscription | Status paket aktif member | Wajib |
| Booking | Simpan booking tanggal, jam, trainer/kelas | Wajib |
| Trainer Schedule | Jadwal ketersediaan trainer | Sedang |
| QR Check-in | Generate dan validasi QR member | Wajib |
| Visit Log | Riwayat kunjungan member | Wajib |
| Progress Record | Catatan progres fisik member | Sedang |
| POS Product | Data produk retail gym | Opsional MVP |
| POS Transaction | Transaksi penjualan sederhana | Opsional MVP |
| Reports | Ringkasan member, booking, check-in, transaksi | Wajib sederhana |

### Migration Database Minimal

Backend disarankan membuat tabel berikut:

```text
users
roles atau kolom role pada users
membership_plans
subscriptions
trainer_schedules
bookings
checkins
progress_records
products
transactions
transaction_items
```

Untuk versi sederhana, role cukup menggunakan kolom `role` pada tabel `users`.

Contoh nilai role:

```text
admin
member
trainer
receptionist
```

### Controller yang Disarankan

```text
AuthController
DashboardController
MembershipController
BookingController
CheckinController
TrainerScheduleController
ProgressController
PosController
ReportController
Admin/UserController
Admin/MembershipPlanController
```

### Route Backend Minimal

| Method | Route | Fungsi | Role |
|---|---|---|---|
| GET | `/` | Landing page | Public |
| GET | `/login` | Form login | Public |
| POST | `/login` | Proses login | Public |
| GET | `/register` | Form register member | Public |
| POST | `/register` | Simpan member baru | Public |
| POST | `/logout` | Logout | Semua user login |
| GET | `/dashboard` | Redirect dashboard sesuai role | Semua user login |
| GET | `/member/dashboard` | Dashboard member | Member |
| GET | `/member/membership` | Lihat paket membership | Member |
| POST | `/member/membership/subscribe` | Pilih/perpanjang paket | Member |
| GET | `/member/booking` | Halaman booking | Member |
| POST | `/member/booking` | Simpan booking | Member |
| GET | `/member/qr` | Tampilkan QR member | Member |
| GET | `/member/progress` | Lihat progres member | Member |
| GET | `/trainer/dashboard` | Dashboard trainer | Trainer |
| GET | `/trainer/schedules` | Jadwal trainer | Trainer |
| POST | `/trainer/schedules` | Simpan jadwal trainer | Trainer |
| GET | `/trainer/progress/create` | Form input progres | Trainer |
| POST | `/trainer/progress` | Simpan progres member | Trainer |
| GET | `/receptionist/dashboard` | Dashboard receptionist | Receptionist |
| GET | `/receptionist/checkin` | Halaman scan QR | Receptionist |
| POST | `/receptionist/checkin` | Validasi check-in | Receptionist |
| GET | `/receptionist/pos` | Halaman POS | Receptionist |
| POST | `/receptionist/pos/transaction` | Simpan transaksi POS | Receptionist |
| GET | `/admin/dashboard` | Dashboard admin | Admin |
| GET | `/admin/users` | Kelola user | Admin |
| GET | `/admin/membership-plans` | Kelola paket | Admin |
| GET | `/admin/reports` | Laporan | Admin |

---

## 6. Scope Frontend

Frontend bertanggung jawab membuat tampilan yang sesuai desain awal dan menghubungkannya ke route backend.

### Halaman Public

| Halaman | Status | Catatan |
|---|---|---|
| Home/Landing Page | Sudah ada dasar | Tetap dipertahankan |
| About | Sudah ada dasar | Bisa dirapikan |
| Pricing | Sudah ada dasar | Nanti ambil data dari backend |
| Trainers | Sudah ada dasar | Ganti data hardcoded menjadi data trainer |
| Booking Section | Sudah ada dasar | Ubah agar tersimpan ke database |
| Login | Perlu dibuat | Desain mengikuti dark-neon style |
| Register | Perlu dibuat | Untuk member baru |

### Halaman Member

| Halaman | Isi |
|---|---|
| Dashboard Member | Ringkasan status membership, booking aktif, QR shortcut |
| Membership | Pilih paket dan lihat status paket aktif |
| Booking | Pilih tanggal, jam, kelas/PT, lalu submit |
| QR Code | QR member untuk check-in |
| Progress | Riwayat progres fisik dari trainer |

### Halaman Personal Trainer

| Halaman | Isi |
|---|---|
| Dashboard Trainer | Ringkasan jadwal hari ini dan jumlah klien |
| Jadwal Trainer | Tambah/edit ketersediaan jadwal |
| Daftar Booking | Member yang sudah booking sesi |
| Input Progres | Form input progres fisik member |

### Halaman Receptionist

| Halaman | Isi |
|---|---|
| Dashboard Receptionist | Ringkasan check-in hari ini dan transaksi |
| Scan QR | Input/scan QR member dan validasi status membership |
| POS | Pilih produk, jumlah, total, simpan transaksi |

### Halaman Admin

| Halaman | Isi |
|---|---|
| Dashboard Admin | Statistik member, booking, check-in, pendapatan simulasi |
| Kelola User | Data member, trainer, receptionist |
| Kelola Paket | CRUD paket membership |
| Kelola Trainer | Data trainer dan spesialisasi |
| Laporan | Tabel ringkas transaksi, kunjungan, dan booking |

---

## 7. Alur Integrasi Backend dan Frontend

Project menggunakan Laravel Blade terlebih dahulu. Jadi hubungan frontend dan backend menggunakan route web Laravel, bukan API terpisah.

### Alur Dasar

```text
User klik tombol / isi form
        ↓
Blade mengirim request ke route Laravel
        ↓
Route memanggil Controller
        ↓
Controller validasi request
        ↓
Controller memproses data lewat Model
        ↓
Data disimpan / diambil dari Database
        ↓
Controller mengembalikan view atau redirect
        ↓
Frontend menampilkan hasil
```

### Contoh Alur Booking

```text
Member login
        ↓
Member membuka halaman booking
        ↓
Member memilih tanggal dan jam
        ↓
Frontend submit form ke POST /member/booking
        ↓
Backend validasi membership aktif dan slot jadwal
        ↓
Backend menyimpan booking
        ↓
Member mendapat notifikasi booking berhasil
        ↓
Trainer dan admin bisa melihat data booking
```

### Contoh Alur QR Check-in

```text
Member membuka QR Code
        ↓
Receptionist scan/input kode QR
        ↓
Backend cek data member
        ↓
Backend cek membership aktif
        ↓
Backend cek apakah sudah check-in hari ini
        ↓
Jika valid, data kunjungan disimpan
        ↓
Admin dapat melihat statistik kunjungan
```

---

## 8. Standar Responsive Design

Aplikasi harus nyaman digunakan pada Android dan website desktop. Karena member kemungkinan lebih sering memakai HP, tampilan mobile harus diprioritaskan.

### Breakpoint Standar

| Target | Ukuran Layar | Standar Layout |
|---|---:|---|
| Android kecil | 320px - 374px | 1 kolom, padding kecil, tombol full width |
| Android umum | 375px - 480px | 1 kolom, bottom navbar aktif |
| Tablet kecil | 481px - 767px | 1-2 kolom sesuai konten |
| Tablet besar | 768px - 1023px | 2 kolom, top navbar aktif |
| Desktop | 1024px - 1279px | 2-3 kolom |
| Large desktop | 1280px ke atas | Maksimal container 1280px |

### Standar Mobile Android

Untuk Android, frontend harus mengikuti aturan berikut:

1. Layout utama menggunakan 1 kolom.
2. Tombol utama menggunakan lebar penuh jika berada di form.
3. Bottom navigation tetap digunakan untuk menu utama member.
4. Font body minimal 14px.
5. Font input minimal 16px agar tidak zoom otomatis di mobile browser.
6. Jarak antar tombol minimal 8px.
7. Tinggi tombol minimal 44px agar mudah disentuh.
8. Card tidak terlalu banyak dalam satu baris.
9. Tabel panjang harus diubah menjadi card list atau horizontal scroll.
10. Kalender booking harus tetap bisa dipakai dengan nyaman pada layar 360px.

### Standar Website Desktop

Untuk desktop, frontend harus mengikuti aturan berikut:

1. Gunakan top navbar.
2. Container maksimal 1280px.
3. Dashboard boleh memakai grid 2 sampai 4 kolom.
4. Tabel admin boleh digunakan untuk data banyak.
5. Sidebar boleh digunakan untuk dashboard admin, trainer, dan receptionist.
6. Hover effect boleh dipakai pada card dan tombol.
7. Jangan membuat elemen terlalu melebar penuh tanpa batas container.
8. Gunakan whitespace yang cukup.

### Standar Komponen Responsive

| Komponen | Mobile | Desktop |
|---|---|---|
| Navbar | Bottom nav + logo sederhana | Top nav + CTA |
| Hero | 1 kolom, heading ringkas | Heading besar, visual kuat |
| Pricing Card | 1 kolom | 3 kolom |
| Trainer Card | 1 kolom atau horizontal scroll | Grid 3-4 kolom |
| Booking Calendar | 1 kolom | 2 kolom: tanggal dan waktu |
| Dashboard Stats | 1 kolom/2 kolom kecil | 4 kolom |
| Data Table | Card list/horizontal scroll | Tabel penuh |
| Form | Full width | Card form maksimal 600px |
| POS | Produk dalam grid 2 kolom | Produk grid 3-4 kolom |
| Report | Ringkasan card | Card + tabel |

---

## 9. Standar Struktur Folder Frontend

Struktur view Laravel yang disarankan:

```text
resources/views/
├── home.blade.php
├── layouts/
│   ├── app.blade.php
│   ├── auth.blade.php
│   └── dashboard.blade.php
├── components/
│   ├── navbar.blade.php
│   ├── footer.blade.php
│   ├── hero.blade.php
│   ├── stats.blade.php
│   ├── about.blade.php
│   ├── pricing.blade.php
│   ├── trainers.blade.php
│   ├── booking.blade.php
│   └── cta.blade.php
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── member/
│   ├── dashboard.blade.php
│   ├── membership.blade.php
│   ├── booking.blade.php
│   ├── qr.blade.php
│   └── progress.blade.php
├── trainer/
│   ├── dashboard.blade.php
│   ├── schedules.blade.php
│   ├── bookings.blade.php
│   └── progress-create.blade.php
├── receptionist/
│   ├── dashboard.blade.php
│   ├── checkin.blade.php
│   └── pos.blade.php
└── admin/
    ├── dashboard.blade.php
    ├── users.blade.php
    ├── membership-plans.blade.php
    ├── trainers.blade.php
    └── reports.blade.php
```

### CSS yang Perlu Diperbaiki

Saat ini file `public/css/responsive.css` masih kosong. File ini perlu diisi untuk standar mobile dan desktop.

Disarankan struktur CSS:

```text
public/css/app.css              → variabel global, reset, utility
public/css/navbar.css           → navbar top dan bottom
public/css/hero.css             → hero section
public/css/components.css       → komponen landing page
public/css/dashboard.css        → dashboard internal role
public/css/forms.css            → form login/register/form input
public/css/responsive.css       → seluruh media query responsive
```

---

## 10. Standar UI Dashboard

Dashboard tidak boleh menggunakan desain yang berbeda jauh dari landing page. Gunakan dark theme yang sama.

### Komponen Dashboard Wajib

1. Header halaman.
2. Card statistik.
3. Card status atau informasi penting.
4. Tabel atau list data.
5. Tombol aksi utama.
6. Empty state ketika belum ada data.
7. Alert sukses/error.
8. Loading state sederhana jika menggunakan JavaScript.

### Contoh Card Statistik

```text
Total Member Aktif
128
Naik 12% bulan ini
```

### Contoh Empty State

```text
Belum ada booking.
Silakan pilih jadwal latihan terlebih dahulu.
[Tombol Booking Sekarang]
```

---

## 11. Prioritas Pengerjaan

### Sprint 1: Fondasi Sistem

Target:

1. Auth login/register.
2. Role user.
3. Dashboard redirect berdasarkan role.
4. Layout dashboard.
5. Migration database utama.
6. Seeder data dummy.

Output Sprint 1:

```text
User bisa login dan diarahkan ke dashboard sesuai role.
```

### Sprint 2: Membership dan Booking

Target:

1. CRUD paket membership oleh admin.
2. Member memilih paket.
3. Status membership aktif.
4. Halaman booking member.
5. Booking tersimpan ke database.
6. Trainer bisa melihat daftar booking.

Output Sprint 2:

```text
Member bisa memilih membership dan melakukan booking sesi.
```

### Sprint 3: QR Check-in dan Progress

Target:

1. QR Code member.
2. Receptionist melakukan verifikasi QR.
3. Check-in tersimpan ke database.
4. Trainer input progres member.
5. Member melihat progres.

Output Sprint 3:

```text
Member bisa check-in dan melihat progres latihan.
```

### Sprint 4: POS dan Laporan

Target:

1. Produk POS sederhana.
2. Transaksi POS.
3. Laporan ringkas admin.
4. Testing responsive.
5. Perapian UI.

Output Sprint 4:

```text
Admin bisa melihat ringkasan data operasional gym.
```

---

## 12. Pembagian Tugas Tim

### Project Manager

Tanggung jawab:

1. Mengunci scope MVP.
2. Menentukan prioritas task.
3. Membuat dan merapikan Trello.
4. Memastikan backend dan frontend memakai route yang sama.
5. Mengecek apakah fitur sudah bisa didemokan.
6. Menolak penambahan fitur yang tidak masuk MVP.
7. Menyiapkan skenario presentasi.

### Backend

Tanggung jawab:

1. Membuat migration database.
2. Membuat model dan relasi.
3. Membuat controller.
4. Membuat route.
5. Membuat validasi form.
6. Membuat middleware role.
7. Membuat seeder data dummy.
8. Menyediakan daftar route untuk frontend.

### Frontend 1

Fokus:

1. Landing page.
2. Login dan register.
3. Dashboard member.
4. Membership page.
5. Booking page.
6. QR member.
7. Responsive mobile member.

### Frontend 2

Fokus:

1. Dashboard admin.
2. Dashboard trainer.
3. Dashboard receptionist.
4. Scan QR page.
5. POS page.
6. Report page.
7. Responsive desktop dashboard.

---

## 13. Definition of Done

Sebuah fitur dianggap selesai jika memenuhi syarat berikut:

1. Tampilan sudah sesuai desain SiBoti.
2. Responsive di Android dan desktop.
3. Form sudah terhubung ke route backend.
4. Data tersimpan ke database jika fitur membutuhkan data.
5. Ada validasi input.
6. Ada feedback sukses/gagal.
7. Role access berjalan.
8. Tidak ada error ketika didemokan.
9. Data bisa muncul kembali di halaman terkait.
10. PM sudah mengecek alur dari awal sampai akhir.

Fitur belum dianggap selesai jika hanya tampilannya jadi tetapi data belum tersimpan.

---

## 14. Skenario Demo Utama

Skenario demo yang harus bisa berjalan:

### Demo 1: Member Register dan Booking

```text
User membuka website
→ klik register
→ daftar sebagai member
→ login
→ memilih paket membership
→ membuka booking
→ memilih tanggal dan jam
→ booking berhasil tersimpan
```

### Demo 2: QR Check-in

```text
Member membuka halaman QR
→ receptionist login
→ receptionist membuka scan QR
→ QR/member code divalidasi
→ check-in berhasil
→ data masuk ke riwayat kunjungan
```

### Demo 3: Trainer Input Progres

```text
Trainer login
→ melihat daftar member/booking
→ memilih member
→ input progres fisik
→ member login
→ member melihat progres terbaru
```

### Demo 4: Admin Melihat Laporan

```text
Admin login
→ membuka dashboard admin
→ melihat jumlah member aktif
→ melihat jumlah booking
→ melihat jumlah check-in
→ melihat transaksi POS jika tersedia
```

---

## 15. Risiko Scope Melebar

Beberapa hal yang berisiko membuat project terlalu jauh:

1. Memaksakan payment gateway asli.
2. Membuat aplikasi mobile native.
3. Menambah fitur chat.
4. Membuat laporan terlalu kompleks.
5. Membuat POS seperti sistem kasir profesional.
6. Menambah terlalu banyak role.
7. Mengganti desain total dari landing page awal.
8. Membuat API terpisah sebelum versi Blade selesai.

Keputusan PM:

```text
Semua fitur tambahan ditunda sampai MVP selesai.
```

---

## 16. Catatan Teknis Penting

1. Untuk tahap awal gunakan Laravel Blade, bukan frontend terpisah React/Vue.
2. Gunakan `routes/web.php` untuk alur utama.
3. Gunakan form Blade dengan `@csrf`.
4. Jangan menyimpan data penting hanya di JavaScript frontend.
5. Data yang saat ini hardcoded di pricing dan trainers sebaiknya nanti diambil dari database.
6. Booking yang saat ini hanya menampilkan toast harus diubah menjadi submit form ke backend.
7. Gunakan middleware role agar halaman tidak bisa diakses sembarangan.
8. Seeder wajib dibuat agar demo tidak kosong.
9. Setiap halaman dashboard harus punya versi mobile yang layak.
10. Gunakan warna dan style yang konsisten dengan CSS awal.

---

## 17. Kesimpulan Scope

Project SiBoti akan dikembangkan sebagai aplikasi manajemen gym sederhana berbasis Laravel. Desain awal landing page tetap dipertahankan sebagai identitas utama. Pengembangan difokuskan pada fitur operasional yang paling penting, yaitu auth, role, membership, booking, QR check-in, progress member, POS sederhana, dan laporan admin.

Target akhir project bukan membuat sistem gym yang sangat kompleks, tetapi membuat aplikasi yang punya alur bisnis jelas, tampilan konsisten, responsive di Android dan website, serta bisa didemokan dari awal sampai akhir.

---

## 18. Checklist PM

Gunakan checklist ini untuk memantau pekerjaan tim.

### Backend Checklist

- [ ] Migration user dan role selesai.
- [ ] Auth login/register selesai.
- [ ] Middleware role selesai.
- [ ] Migration membership selesai.
- [ ] Migration booking selesai.
- [ ] Migration check-in selesai.
- [ ] Migration progress selesai.
- [ ] Seeder data dummy selesai.
- [ ] Route utama terdokumentasi.
- [ ] Controller utama selesai.
- [ ] Validasi form tersedia.
- [ ] Laporan ringkas admin tersedia.

### Frontend Checklist

- [ ] Landing page tetap rapi.
- [ ] Login page selesai. ✅
- [ ] Register page selesai. ✅
- [ ] Dashboard member selesai. 
- [ ] Dashboard trainer selesai. (pugres)
- [ ] Dashboard receptionist selesai.
- [ ] Dashboard admin selesai.
- [ ] Booking page terhubung backend.
- [ ] QR page selesai.✅
- [ ] Scan QR page selesai.
- [ ] Progress page selesai.✅
- [ ] POS page selesai.
- [ ] Report page selesai.
- [ ] Mobile Android rapi.
- [ ] Desktop web rapi.

### Integrasi Checklist

- [ ] Form register masuk database.
- [ ] Login redirect sesuai role.
- [ ] Member bisa memilih paket.
- [ ] Member bisa booking.
- [ ] Trainer bisa melihat booking.
- [ ] Receptionist bisa validasi check-in.
- [ ] Trainer bisa input progres.
- [ ] Member bisa melihat progres.
- [ ] Admin bisa melihat laporan.
- [ ] Tidak ada route yang bisa diakses role salah.

