# Catatan Integrasi Siboti

Base project: `Siboti-backend (2).zip`

Frontend Fadhil hanya diambil bagian tampilan/dashboard, asset CSS, dan controller sementara untuk supply data tampilan.

## File backend yang dipertahankan

- Auth Breeze dan routes/auth.php
- config/
- database migrations dan seeders
- app/Models/
- composer.json dan composer.lock
- package.json dan package-lock.json
- tailwind.config.js

## File FE yang dimasukkan

- app/Http/Controllers/AdminDashboardController.php
- app/Http/Controllers/ReceptionistDashboardController.php
- app/Http/Controllers/PersonalTrainerDashboardController.php
- app/Http/Controllers/PosDashboardController.php
- app/Http/Controllers/ScanQrPageController.php
- app/Http/Controllers/ReportPageController.php
- resources/views/layouts/admin.blade.php
- resources/views/layouts/receptionist.blade.php
- resources/views/admin/dashboard.blade.php
- resources/views/receptionist/dashboard.blade.php
- resources/views/trainer/dashboard.blade.php
- resources/views/pos/dashboard.blade.php
- resources/views/reports/index.blade.php
- resources/views/scan-qr/index.blade.php
- public/css/admin-dashboard.css
- public/css/receptionist.css

## Penyesuaian penting

- routes/web.php digabung dengan base backend.
- Semua route dashboard FE dimasukkan ke dalam middleware auth.
- Route name ditambahkan agar link Blade tidak error:
  - admin.dashboard
  - receptionist.dashboard
  - trainer.dashboard
  - pos.dashboard
  - scan-qr.index
  - reports.index
  - member.dashboard
- Tombol Keluar di dashboard FE diubah menjadi POST ke route logout backend, bukan sekadar link ke `/`.
- resources/views/layouts/app.blade.php dibuat hybrid agar mendukung `@yield('content')` dan `$slot`.

## Validasi yang sudah dilakukan

- PHP syntax check untuk app, routes, database, config, bootstrap, dan tests: lolos.
- Artisan route:list belum dijalankan karena folder vendor tidak tersedia di ZIP. Jalankan `composer install` dulu di lokal.

## Test lokal setelah extract

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Lalu buka:

- /
- /login
- /dashboard
- /admin/dashboard
- /receptionist/dashboard
- /trainer/dashboard
- /pos/dashboard
- /scan-qr/check-in
- /reports/dashboard

