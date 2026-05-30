<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PersonalTrainerDashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            [
                'label' => 'Jadwal Hari Ini',
                'value' => '08',
                'note' => '+2 sesi hari ini',
                'icon' => 'calendar_today',
                'variant' => 'positive',
            ],
            [
                'label' => 'Klien Aktif',
                'value' => '24',
                'note' => 'Stabil',
                'icon' => 'group',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Booking Minggu Ini',
                'value' => '15',
                'note' => '3 perlu respon',
                'icon' => 'event_available',
                'variant' => 'warning',
            ],
            [
                'label' => 'Progres Diinput',
                'value' => '18',
                'note' => '75% selesai',
                'icon' => 'trending_up',
                'variant' => 'positive',
            ],
        ];

        $todaySchedules = [
            [
                'start' => '06.00',
                'end' => '07.00',
                'member' => 'Budi Santoso',
                'program' => 'Hypertrophy',
                'focus' => 'Chest & Back',
                'status' => 'Selesai',
                'statusClass' => 'neutral',
                'initials' => 'BS',
            ],
            [
                'start' => '07.00',
                'end' => '08.30',
                'member' => 'Rina Susanti',
                'program' => 'Strength & Conditioning',
                'focus' => 'Leg Day',
                'status' => 'Sedang Berjalan',
                'statusClass' => 'success',
                'initials' => 'RS',
            ],
            [
                'start' => '09.00',
                'end' => '10.00',
                'member' => 'Dandi Pratama',
                'program' => 'Fat Loss Program',
                'focus' => 'HIIT',
                'status' => 'Mendatang',
                'statusClass' => 'warning',
                'initials' => 'DP',
            ],
        ];

        $recentBookings = [
            [
                'member' => 'Siska Amalia',
                'membership' => 'Gold Member',
                'time' => 'Besok, 08.00',
                'status' => 'Menunggu',
                'statusClass' => 'warning',
            ],
            [
                'member' => 'Aditya Wijaya',
                'membership' => 'Silver Member',
                'time' => 'Rabu, 16.30',
                'status' => 'Menunggu',
                'statusClass' => 'warning',
            ],
            [
                'member' => 'Melani Putri',
                'membership' => 'Premium Member',
                'time' => 'Jumat, 18.00',
                'status' => 'Confirmed',
                'statusClass' => 'success',
            ],
        ];

        $bookings = [
            [
                'member' => 'Rina Susanti',
                'program' => 'Strength Conditioning',
                'dateTime' => '24 Mei 2026, 07.00',
                'status' => 'Terjadwal',
                'statusClass' => 'success',
                'initials' => 'RS',
            ],
            [
                'member' => 'Amalia Melati',
                'program' => 'Yoga Vinyasa',
                'dateTime' => '24 Mei 2026, 14.00',
                'status' => 'Menunggu',
                'statusClass' => 'warning',
                'initials' => 'AM',
            ],
            [
                'member' => 'Budi Santoso',
                'program' => 'Hypertrophy Program',
                'dateTime' => '24 Mei 2026, 06.00',
                'status' => 'Selesai',
                'statusClass' => 'neutral',
                'initials' => 'BS',
            ],
            [
                'member' => 'Dandi Pratama',
                'program' => 'Fat Loss HIIT',
                'dateTime' => '23 Mei 2026, 10.00',
                'status' => 'Dibatalkan',
                'statusClass' => 'danger',
                'initials' => 'DP',
            ],
        ];

        $clients = [
            [
                'name' => 'Siska Amalia',
                'clientId' => 'SBT-29012',
                'package' => 'Personal Training (12 Sesi)',
                'remainingLabel' => 'Sisa Sesi',
                'remaining' => '5 Sesi lagi',
                'statusClass' => 'success',
                'initials' => 'SA',
            ],
            [
                'name' => 'Aditya Wijaya',
                'clientId' => 'SBT-29044',
                'package' => 'Bulking Program (24 Sesi)',
                'remainingLabel' => 'Sisa Sesi',
                'remaining' => '18 Sesi lagi',
                'statusClass' => 'success',
                'initials' => 'AW',
            ],
            [
                'name' => 'Melani Putri',
                'clientId' => 'SBT-29008',
                'package' => 'Weight Loss (Monthly)',
                'remainingLabel' => 'Masa Aktif',
                'remaining' => 'Habis dalam 3 hari',
                'statusClass' => 'danger',
                'initials' => 'MP',
            ],
        ];

        $progressHistory = [
            ['member' => 'Dandi Pratama', 'time' => '2 jam yang lalu', 'weight' => '78 kg', 'waist' => '85 cm'],
            ['member' => 'Rina Susanti', 'time' => '5 jam yang lalu', 'weight' => '55 kg', 'waist' => '68 cm'],
            ['member' => 'Budi Santoso', 'time' => 'Kemarin', 'weight' => '82 kg', 'waist' => '88 cm'],
        ];

        $performanceSummaries = [
            ['label' => 'Target Tercapai', 'value' => '12', 'unit' => 'Member', 'progress' => 70, 'variant' => 'positive'],
            ['label' => 'Konsistensi Tinggi', 'value' => '85%', 'unit' => '', 'progress' => 85, 'variant' => 'positive'],
            ['label' => 'Butuh Perhatian', 'value' => '03', 'unit' => 'Member', 'progress' => 15, 'variant' => 'danger'],
            ['label' => 'Sesi Selesai MoM', 'value' => '+12%', 'unit' => '', 'progress' => 60, 'variant' => 'positive'],
        ];

        $activities = [
            ['icon' => 'task_alt', 'text' => 'Coach Aris menyelesaikan sesi Strength dengan Rina Susanti.', 'time' => 'Hari ini, 08.32'],
            ['icon' => 'edit_note', 'text' => 'Coach Aris menginput data progres fisik untuk Dandi Pratama.', 'time' => 'Hari ini, 06.15'],
            ['icon' => 'event_available', 'text' => 'Booking Siska Amalia telah disetujui otomatis oleh sistem.', 'time' => 'Kemarin, 21.05'],
        ];

        $alerts = [
            [
                'title' => '3 Klien Butuh Evaluasi',
                'description' => 'Progres dua minggu terakhir belum mencapai target minimal program.',
                'type' => 'danger',
                'icon' => 'warning',
            ],
            [
                'title' => 'Maintenance Kalender',
                'description' => 'Sinkronisasi jadwal akan dibatasi pada Minggu pukul 02.00 - 04.00 WIB.',
                'type' => 'info',
                'icon' => 'info',
            ],
        ];

        return view('trainer.dashboard', compact(
            'stats',
            'todaySchedules',
            'recentBookings',
            'bookings',
            'clients',
            'progressHistory',
            'performanceSummaries',
            'activities',
            'alerts'
        ));
    }
}
