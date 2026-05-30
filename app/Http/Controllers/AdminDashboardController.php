<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            [
                'label' => 'Total Member Aktif',
                'value' => '1.284',
                'note' => '+12% bulan ini',
                'icon' => 'groups',
                'variant' => 'positive',
            ],
            [
                'label' => 'Booking Hari Ini',
                'value' => '42',
                'note' => '5 pending',
                'icon' => 'event_available',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Check-in Hari Ini',
                'value' => '86',
                'note' => 'Puncak 17.00',
                'icon' => 'qr_code_scanner',
                'variant' => 'positive',
            ],
            [
                'label' => 'Pendapatan Bulanan',
                'value' => 'Rp142,5 jt',
                'note' => '+8% bulan ini',
                'icon' => 'payments',
                'variant' => 'positive',
            ],
        ];

        $bookings = [
            [
                'member' => 'Andi Wijaya',
                'trainer' => 'Coach Budi',
                'session' => 'Personal Training',
                'date' => '24 Mei 2026',
                'time' => '10.00',
                'status' => 'Confirmed',
                'statusClass' => 'success',
            ],
            [
                'member' => 'Siti Rahma',
                'trainer' => 'Coach Clara',
                'session' => 'Yoga Class',
                'date' => '24 Mei 2026',
                'time' => '15.30',
                'status' => 'Pending',
                'statusClass' => 'warning',
            ],
            [
                'member' => 'Reza Pahlevi',
                'trainer' => '-',
                'session' => 'Free Weight',
                'date' => '24 Mei 2026',
                'time' => '18.00',
                'status' => 'Confirmed',
                'statusClass' => 'success',
            ],
            [
                'member' => 'Bima Satria',
                'trainer' => 'Coach Budi',
                'session' => 'Crossfit',
                'date' => '23 Mei 2026',
                'time' => '08.00',
                'status' => 'Cancelled',
                'statusClass' => 'danger',
            ],
            [
                'member' => 'Diana Putri',
                'trainer' => 'Coach Clara',
                'session' => 'Zumba',
                'date' => '23 Mei 2026',
                'time' => '19.00',
                'status' => 'Completed',
                'statusClass' => 'neutral',
            ],
        ];

        $transactions = [
            ['item' => 'Protein Shake', 'time' => 'Hari ini, 16.45', 'amount' => 'Rp45.000', 'icon' => 'local_cafe'],
            ['item' => 'Gym Glove Pro', 'time' => 'Hari ini, 15.20', 'amount' => 'Rp250.000', 'icon' => 'fitness_center'],
            ['item' => 'Mineral Water', 'time' => 'Hari ini, 14.10', 'amount' => 'Rp10.000', 'icon' => 'water_bottle'],
            ['item' => 'Siboti T-Shirt', 'time' => 'Kemarin, 18.30', 'amount' => 'Rp150.000', 'icon' => 'checkroom'],
        ];

        $activities = [
            ['icon' => 'person_add', 'text' => 'Member baru Budi Santoso mendaftar.', 'time' => '10 menit yang lalu'],
            ['icon' => 'update', 'text' => 'Paket Citra Lestari diperbarui ke Premium.', 'time' => '1 jam yang lalu'],
            ['icon' => 'edit_calendar', 'text' => 'Jadwal kelas Yoga diubah oleh Admin.', 'time' => '3 jam yang lalu'],
        ];

        $alerts = [
            ['title' => '12 Membership Mendekati Expired', 'description' => 'Harap tindak lanjuti untuk perpanjangan.', 'type' => 'danger', 'icon' => 'warning'],
            ['title' => '5 Booking Pending', 'description' => 'Menunggu konfirmasi ketersediaan pelatih.', 'type' => 'info', 'icon' => 'info'],
            ['title' => 'Stok Air Mineral Menipis', 'description' => 'Sisa 10 botol di etalase POS.', 'type' => 'neutral', 'icon' => 'inventory_2'],
        ];

        return view('admin.dashboard', compact('stats', 'bookings', 'transactions', 'activities', 'alerts'));
    }
}
