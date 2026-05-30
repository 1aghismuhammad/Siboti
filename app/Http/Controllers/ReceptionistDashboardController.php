<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ReceptionistDashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            [
                'label' => 'Check-in Hari Ini',
                'value' => '142',
                'note' => '+12% dari kemarin',
                'icon' => 'login',
                'variant' => 'positive',
            ],
            [
                'label' => 'Member Aktif',
                'value' => '1.204',
                'note' => 'Siap check-in',
                'icon' => 'groups',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Member Expired',
                'value' => '18',
                'note' => 'Perlu tindak lanjut',
                'icon' => 'event_busy',
                'variant' => 'danger',
            ],
            [
                'label' => 'Transaksi POS Hari Ini',
                'value' => 'Rp4,2 jt',
                'note' => '36 transaksi',
                'icon' => 'point_of_sale',
                'variant' => 'positive',
            ],
        ];

        $members = [
            'MEM-2024-0891' => [
                'name' => 'Adrian Pratama',
                'memberId' => 'MEM-2024-0891',
                'package' => 'Monthly Elite',
                'remaining' => '24 Hari',
                'status' => 'AKTIF',
                'statusClass' => 'success',
                'note' => 'Member valid. Silakan konfirmasi check-in.',
                'initials' => 'AP',
            ],
            'MEM-0455' => [
                'name' => 'Santi Rahayu',
                'memberId' => 'MEM-0455',
                'package' => 'Silver Monthly',
                'remaining' => '0 Hari',
                'status' => 'EXPIRED',
                'statusClass' => 'danger',
                'note' => 'Membership sudah berakhir. Arahkan ke proses perpanjangan.',
                'initials' => 'SR',
            ],
            'MEM-0921' => [
                'name' => 'Joko Susanto',
                'memberId' => 'MEM-0921',
                'package' => 'Platinum Elite',
                'remaining' => '19 Hari',
                'status' => 'DUPLIKAT',
                'statusClass' => 'warning',
                'note' => 'Member sudah check-in hari ini. Validasi ulang hanya jika ada kesalahan scan.',
                'initials' => 'JS',
            ],
        ];

        $checkIns = [
            [
                'name' => 'Budi Setiawan',
                'memberId' => 'MEM-0012',
                'package' => 'Gold Annual',
                'time' => '08.45',
                'status' => 'Berhasil',
                'statusClass' => 'success',
            ],
            [
                'name' => 'Santi Rahayu',
                'memberId' => 'MEM-0455',
                'package' => 'Silver Monthly',
                'time' => '08.32',
                'status' => 'Ditolak',
                'statusClass' => 'danger',
            ],
            [
                'name' => 'Joko Susanto',
                'memberId' => 'MEM-0921',
                'package' => 'Platinum Elite',
                'time' => '08.15',
                'status' => 'Duplikat',
                'statusClass' => 'warning',
            ],
        ];

        $posTransactions = [
            [
                'trxId' => '#TRX-98210',
                'cashier' => 'Receptionist',
                'member' => 'Adrian P.',
                'product' => 'Whey Protein 1kg',
                'total' => 'Rp850.000',
                'status' => 'Paid',
                'statusClass' => 'success',
            ],
            [
                'trxId' => '#TRX-98211',
                'cashier' => 'Receptionist',
                'member' => 'Guest',
                'product' => 'Mineral Water 600ml',
                'total' => 'Rp10.000',
                'status' => 'Paid',
                'statusClass' => 'success',
            ],
            [
                'trxId' => '#TRX-98212',
                'cashier' => 'Receptionist',
                'member' => 'Budi S.',
                'product' => 'Pre-Workout Sachet',
                'total' => 'Rp25.000',
                'status' => 'Pending',
                'statusClass' => 'warning',
            ],
        ];

        $activities = [
            ['icon' => 'verified_user', 'text' => 'Berhasil memvalidasi check-in Adrian Pratama.', 'time' => '2 menit yang lalu'],
            ['icon' => 'block', 'text' => 'Penolakan akses MEM-0455 karena membership expired.', 'time' => '15 menit yang lalu'],
            ['icon' => 'point_of_sale', 'text' => 'Berhasil input transaksi POS Protein Shake Whey.', 'time' => '28 menit yang lalu'],
        ];

        $alerts = [
            [
                'title' => '12 Member Mendekati Expired',
                'description' => 'Masa aktif akan berakhir dalam 3 hari ke depan. Ingatkan saat check-in.',
                'type' => 'info',
                'icon' => 'info',
            ],
            [
                'title' => 'Percobaan Scan Berulang',
                'description' => 'ID MEM-0921 mencoba check-in 3 kali dalam 5 menit terakhir.',
                'type' => 'danger',
                'icon' => 'warning',
            ],
        ];

        return view('receptionist.dashboard', compact('stats', 'members', 'checkIns', 'posTransactions', 'activities', 'alerts'));
    }
}
