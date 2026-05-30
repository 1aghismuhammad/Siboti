<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ReportPageController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            [
                'label' => 'Total Member Aktif',
                'value' => '1.248',
                'note' => '+6,8% bulan ini',
                'icon' => 'groups',
                'variant' => 'positive',
            ],
            [
                'label' => 'Total Booking',
                'value' => '456',
                'note' => 'Periode berjalan',
                'icon' => 'event_available',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Total Check-in',
                'value' => '389',
                'note' => '85% dari booking',
                'icon' => 'qr_code_scanner',
                'variant' => 'positive',
            ],
            [
                'label' => 'Transaksi POS',
                'value' => 'Rp45,2 jt',
                'note' => '+8% dari target',
                'icon' => 'point_of_sale',
                'variant' => 'positive',
            ],
            [
                'label' => 'Membership Expired',
                'value' => '42',
                'note' => 'Perlu follow-up',
                'icon' => 'event_busy',
                'variant' => 'danger',
            ],
            [
                'label' => 'Booking Selesai',
                'value' => '412',
                'note' => '90,3% selesai',
                'icon' => 'task_alt',
                'variant' => 'positive',
            ],
            [
                'label' => 'Pendapatan Simulasi',
                'value' => 'Rp128 jt',
                'note' => 'Membership + POS',
                'icon' => 'payments',
                'variant' => 'positive',
            ],
            [
                'label' => 'Trainer Aktif',
                'value' => '18',
                'note' => '4 jadwal penuh',
                'icon' => 'sports',
                'variant' => 'neutral',
            ],
        ];

        $bookingCheckinChart = [
            ['label' => 'Sen', 'booking' => 54, 'checkin' => 46],
            ['label' => 'Sel', 'booking' => 68, 'checkin' => 59],
            ['label' => 'Rab', 'booking' => 61, 'checkin' => 52],
            ['label' => 'Kam', 'booking' => 77, 'checkin' => 71],
            ['label' => 'Jum', 'booking' => 82, 'checkin' => 75],
            ['label' => 'Sab', 'booking' => 93, 'checkin' => 88],
            ['label' => 'Min', 'booking' => 69, 'checkin' => 62],
        ];

        $memberGrowth = [
            ['month' => 'Jan', 'total' => 920],
            ['month' => 'Feb', 'total' => 984],
            ['month' => 'Mar', 'total' => 1060],
            ['month' => 'Apr', 'total' => 1138],
            ['month' => 'Mei', 'total' => 1248],
            ['month' => 'Jun', 'total' => 1312],
        ];

        $reportCategories = [
            [
                'title' => 'Laporan Membership',
                'description' => 'Status member aktif, expired, paket, dan tanggal kadaluarsa.',
                'icon' => 'card_membership',
                'target' => '#membership-report',
            ],
            [
                'title' => 'Laporan Booking & Check-in',
                'description' => 'Perbandingan jadwal booking, waktu check-in, dan status sesi.',
                'icon' => 'fact_check',
                'target' => '#booking-checkin-report',
            ],
            [
                'title' => 'Laporan Transaksi POS',
                'description' => 'Rekap item terjual, metode pembayaran, dan status transaksi.',
                'icon' => 'receipt_long',
                'target' => '#pos-report',
            ],
            [
                'title' => 'Ringkasan Operasional',
                'description' => 'Kondisi operasional utama untuk evaluasi harian admin.',
                'icon' => 'monitoring',
                'target' => '#operational-summary',
            ],
        ];

        $memberships = [
            ['id' => 'MEM-2024-0891', 'name' => 'Adrian Pratama', 'package' => 'Monthly Elite', 'registered' => '01 Mei 2026', 'expired' => '01 Jun 2026', 'status' => 'Aktif', 'statusClass' => 'success'],
            ['id' => 'MEM-2024-0455', 'name' => 'Santi Rahayu', 'package' => 'Silver Monthly', 'registered' => '12 Apr 2026', 'expired' => '12 Mei 2026', 'status' => 'Expired', 'statusClass' => 'danger'],
            ['id' => 'MEM-2024-0921', 'name' => 'Joko Susanto', 'package' => 'Platinum Elite', 'registered' => '20 Mei 2026', 'expired' => '20 Jun 2026', 'status' => 'Aktif', 'statusClass' => 'success'],
            ['id' => 'MEM-2024-0770', 'name' => 'Dewi Lestari', 'package' => 'Gold Annual', 'registered' => '06 Jan 2026', 'expired' => '06 Jan 2027', 'status' => 'Aktif', 'statusClass' => 'success'],
            ['id' => 'MEM-2024-0632', 'name' => 'Rangga Saputra', 'package' => 'Trial Pass', 'registered' => '22 Mei 2026', 'expired' => '29 Mei 2026', 'status' => 'Trial', 'statusClass' => 'warning'],
        ];

        $bookingCheckins = [
            ['id' => 'BK-240501', 'member' => 'Rina Susanti', 'session' => 'Strength Conditioning', 'bookingTime' => '24 Mei 2026, 07.00', 'checkinTime' => '24 Mei 2026, 06.54', 'status' => 'Selesai', 'statusClass' => 'success'],
            ['id' => 'BK-240502', 'member' => 'Dandi Pratama', 'session' => 'Fat Loss HIIT', 'bookingTime' => '24 Mei 2026, 09.00', 'checkinTime' => '24 Mei 2026, 08.58', 'status' => 'Terjadwal', 'statusClass' => 'neutral'],
            ['id' => 'BK-240503', 'member' => 'Siska Amalia', 'session' => 'Personal Training', 'bookingTime' => '25 Mei 2026, 08.00', 'checkinTime' => '-', 'status' => 'Menunggu', 'statusClass' => 'warning'],
            ['id' => 'BK-240504', 'member' => 'Budi Santoso', 'session' => 'Hypertrophy', 'bookingTime' => '23 Mei 2026, 06.00', 'checkinTime' => '23 Mei 2026, 06.06', 'status' => 'Selesai', 'statusClass' => 'success'],
            ['id' => 'BK-240505', 'member' => 'Melani Putri', 'session' => 'Weight Loss', 'bookingTime' => '23 Mei 2026, 17.30', 'checkinTime' => '-', 'status' => 'Batal', 'statusClass' => 'danger'],
        ];

        $posTransactions = [
            ['id' => 'TRX-9821', 'date' => '24 Mei 2026', 'item' => 'Whey Protein 1kg', 'total' => 'Rp850.000', 'method' => 'QRIS', 'status' => 'Berhasil', 'statusClass' => 'success'],
            ['id' => 'TRX-9820', 'date' => '24 Mei 2026', 'item' => 'Air Mineral 600ml', 'total' => 'Rp5.000', 'method' => 'Cash', 'status' => 'Berhasil', 'statusClass' => 'success'],
            ['id' => 'TRX-9819', 'date' => '24 Mei 2026', 'item' => 'Pre-Workout Sachet', 'total' => 'Rp25.000', 'method' => 'QRIS', 'status' => 'Pending', 'statusClass' => 'warning'],
            ['id' => 'TRX-9818', 'date' => '23 Mei 2026', 'item' => 'SiBoti Microfiber Towel', 'total' => 'Rp85.000', 'method' => 'Cash', 'status' => 'Berhasil', 'statusClass' => 'success'],
            ['id' => 'TRX-9817', 'date' => '23 Mei 2026', 'item' => 'Protein Shake Vanilla', 'total' => 'Rp35.000', 'method' => 'QRIS', 'status' => 'Dibatalkan', 'statusClass' => 'danger'],
        ];

        $alerts = [
            ['icon' => 'warning', 'title' => '42 membership sudah expired', 'description' => 'Prioritaskan follow-up untuk paket bulanan dan trial pass.', 'type' => 'danger'],
            ['icon' => 'pending_actions', 'title' => '3 transaksi POS pending', 'description' => 'Perlu dicek ulang sebelum tutup kas harian.', 'type' => 'info'],
            ['icon' => 'inventory_2', 'title' => '2 produk stok rendah', 'description' => 'Air Mineral 600ml dan Pre-Workout Sachet perlu restok.', 'type' => 'neutral'],
        ];

        return view('reports.index', compact(
            'stats',
            'bookingCheckinChart',
            'memberGrowth',
            'reportCategories',
            'memberships',
            'bookingCheckins',
            'posTransactions',
            'alerts'
        ));
    }
}
