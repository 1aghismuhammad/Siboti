<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ScanQrPageController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            [
                'label' => 'Scan Hari Ini',
                'value' => '156',
                'note' => '+14 dari shift pagi',
                'icon' => 'qr_code_scanner',
                'variant' => 'positive',
            ],
            [
                'label' => 'Check-in Berhasil',
                'value' => '128',
                'note' => '82% valid',
                'icon' => 'check_circle',
                'variant' => 'positive',
            ],
            [
                'label' => 'Akses Ditolak',
                'value' => '12',
                'note' => 'Expired / suspended',
                'icon' => 'block',
                'variant' => 'danger',
            ],
            [
                'label' => 'Scan Duplikat',
                'value' => '2',
                'note' => 'Perlu verifikasi',
                'icon' => 'repeat',
                'variant' => 'neutral',
            ],
        ];

        $members = [
            'MEM-2024-0891' => [
                'name' => 'Adrian Pratama',
                'memberId' => 'MEM-2024-0891',
                'package' => 'Monthly Elite',
                'remaining' => '24 Hari',
                'lastCheckin' => 'Belum check-in hari ini',
                'status' => 'AKTIF',
                'statusClass' => 'success',
                'note' => 'Member aktif. Check-in dapat dikonfirmasi.',
                'initials' => 'AP',
                'access' => true,
                'qrToken' => 'QR-SBT-0891-ACTIVE',
            ],
            'MEM-0012' => [
                'name' => 'Budi Setiawan',
                'memberId' => 'MEM-0012',
                'package' => 'Gold Annual',
                'remaining' => '148 Hari',
                'lastCheckin' => 'Terakhir check-in 08.45',
                'status' => 'AKTIF',
                'statusClass' => 'success',
                'note' => 'Member valid. Periksa apakah check-in ulang memang diperlukan.',
                'initials' => 'BS',
                'access' => true,
                'qrToken' => 'QR-SBT-0012-ACTIVE',
            ],
            'MEM-0455' => [
                'name' => 'Santi Rahayu',
                'memberId' => 'MEM-0455',
                'package' => 'Silver Monthly',
                'remaining' => '0 Hari',
                'lastCheckin' => 'Ditolak 08.32',
                'status' => 'EXPIRED',
                'statusClass' => 'danger',
                'note' => 'Membership sudah expired. Arahkan member ke proses perpanjangan.',
                'initials' => 'SR',
                'access' => false,
                'qrToken' => 'QR-SBT-0455-EXPIRED',
            ],
            'MEM-0921' => [
                'name' => 'Joko Susanto',
                'memberId' => 'MEM-0921',
                'package' => 'Platinum Elite',
                'remaining' => '19 Hari',
                'lastCheckin' => 'Sudah check-in 08.15',
                'status' => 'DUPLIKAT',
                'statusClass' => 'warning',
                'note' => 'Member sudah melakukan check-in hari ini. Konfirmasi manual hanya jika scan pertama bermasalah.',
                'initials' => 'JS',
                'access' => false,
                'qrToken' => 'QR-SBT-0921-DUPLICATE',
            ],
            'MEM-0777' => [
                'name' => 'Raka Mahendra',
                'memberId' => 'MEM-0777',
                'package' => 'Trial Pass',
                'remaining' => '1 Hari',
                'lastCheckin' => 'Belum check-in hari ini',
                'status' => 'SUSPENDED',
                'statusClass' => 'danger',
                'note' => 'Akun sedang ditahan oleh admin. Hubungi admin sebelum memberi akses.',
                'initials' => 'RM',
                'access' => false,
                'qrToken' => 'QR-SBT-0777-SUSPENDED',
            ],
        ];

        $recentScans = [
            [
                'time' => '10.45',
                'name' => 'Adrian Pratama',
                'memberId' => 'MEM-2024-0891',
                'method' => 'QR Scanner',
                'gate' => 'Front Desk',
                'status' => 'Berhasil',
                'statusClass' => 'success',
            ],
            [
                'time' => '10.38',
                'name' => 'Santi Rahayu',
                'memberId' => 'MEM-0455',
                'method' => 'Manual Input',
                'gate' => 'Front Desk',
                'status' => 'Ditolak',
                'statusClass' => 'danger',
            ],
            [
                'time' => '10.27',
                'name' => 'Joko Susanto',
                'memberId' => 'MEM-0921',
                'method' => 'QR Scanner',
                'gate' => 'Front Desk',
                'status' => 'Duplikat',
                'statusClass' => 'warning',
            ],
            [
                'time' => '10.10',
                'name' => 'Budi Setiawan',
                'memberId' => 'MEM-0012',
                'method' => 'QR Scanner',
                'gate' => 'Front Desk',
                'status' => 'Berhasil',
                'statusClass' => 'success',
            ],
        ];

        $instructions = [
            ['step' => '01', 'title' => 'Arahkan QR ke area scanner', 'description' => 'Gunakan kamera scanner front desk atau pilih mode simulasi untuk demo.'],
            ['step' => '02', 'title' => 'Validasi status member', 'description' => 'Sistem mengecek masa aktif, duplikasi check-in, dan status blokir.'],
            ['step' => '03', 'title' => 'Konfirmasi akses gym', 'description' => 'Receptionist menekan konfirmasi jika status valid dan member boleh masuk.'],
        ];

        $alerts = [
            [
                'title' => 'Kamera Scanner Siap',
                'description' => 'Mode kamera aktif untuk front desk. Input manual tetap tersedia sebagai cadangan.',
                'type' => 'info',
                'icon' => 'photo_camera',
            ],
            [
                'title' => 'Percobaan Duplikat Terdeteksi',
                'description' => 'MEM-0921 melakukan scan ulang dalam interval kurang dari 5 menit.',
                'type' => 'warning',
                'icon' => 'repeat',
            ],
            [
                'title' => 'Membership Expired',
                'description' => '12 member expired mencoba check-in pada shift hari ini.',
                'type' => 'danger',
                'icon' => 'event_busy',
            ],
        ];

        return view('scan-qr.index', compact('stats', 'members', 'recentScans', 'instructions', 'alerts'));
    }
}
