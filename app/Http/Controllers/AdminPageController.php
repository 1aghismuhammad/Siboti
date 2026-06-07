<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    public function memberships(): View
    {
        $prospectiveMembers = [
            [
                'id' => 'PR-001',
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'phone' => '081234567890',
                'plan' => 'Monthly Elite',
                'date' => '06 Jun 2026',
                'status' => 'Pending',
                'statusClass' => 'warning'
            ],
            [
                'id' => 'PR-002',
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@example.com',
                'phone' => '085678901234',
                'plan' => 'Annual Pro',
                'date' => '05 Jun 2026',
                'status' => 'Pending',
                'statusClass' => 'warning'
            ],
            [
                'id' => 'PR-003',
                'name' => 'Joko Anwar',
                'email' => 'joko.anwar@example.com',
                'phone' => '082123456789',
                'plan' => 'Weekly Pass',
                'date' => '05 Jun 2026',
                'status' => 'Approved',
                'statusClass' => 'success'
            ],
        ];

        return view('admin.memberships', compact('prospectiveMembers'));
    }

    public function trainers(): View
    {
        $trainers = [
            [
                'id' => 'TR-001',
                'name' => 'Ade Rai',
                'specialty' => 'Bodybuilding',
                'members' => 15,
                'rating' => '4.9',
                'status' => 'Active',
                'statusClass' => 'success'
            ],
            [
                'id' => 'TR-002',
                'name' => 'Rina Fitriani',
                'specialty' => 'Yoga & Pilates',
                'members' => 22,
                'rating' => '4.8',
                'status' => 'Active',
                'statusClass' => 'success'
            ],
            [
                'id' => 'TR-003',
                'name' => 'Agus Yudhoyono',
                'specialty' => 'CrossFit',
                'members' => 8,
                'rating' => '4.5',
                'status' => 'On Leave',
                'statusClass' => 'warning'
            ],
        ];

        return view('admin.trainers', compact('trainers'));
    }

    public function bookings(): View
    {
        $bookings = [
            [
                'id' => 'BK-001',
                'member' => 'Rizky Febian',
                'trainer' => 'Ade Rai',
                'type' => 'Personal Training',
                'date' => '07 Jun 2026',
                'time' => '09:00',
                'status' => 'Pending Confirmation',
                'statusClass' => 'warning'
            ],
            [
                'id' => 'BK-002',
                'member' => 'Isyana Sarasvati',
                'trainer' => 'Rina Fitriani',
                'type' => 'Yoga Class',
                'date' => '07 Jun 2026',
                'time' => '10:30',
                'status' => 'Approved',
                'statusClass' => 'success'
            ],
            [
                'id' => 'BK-003',
                'member' => 'Ahmad Dhani',
                'trainer' => 'Agus Yudhoyono',
                'type' => 'CrossFit',
                'date' => '08 Jun 2026',
                'time' => '16:00',
                'status' => 'Pending Confirmation',
                'statusClass' => 'warning'
            ],
        ];

        return view('admin.bookings', compact('bookings'));
    }

    public function reports(): View
    {
        $monthlyRevenue = [
            'Jan' => 12000000,
            'Feb' => 15000000,
            'Mar' => 13500000,
            'Apr' => 18000000,
            'May' => 22000000,
            'Jun' => 19500000,
        ];

        return view('admin.reports', compact('monthlyRevenue'));
    }

    public function maintenance(): View
    {
        $systemStatus = [
            'database' => ['status' => 'Connected', 'latency' => '12ms', 'class' => 'success'],
            'redis' => ['status' => 'Connected', 'latency' => '4ms', 'class' => 'success'],
            'storage' => ['status' => '45% Used', 'latency' => '-', 'class' => 'neutral'],
            'last_backup' => ['status' => 'Today, 02:00 AM', 'latency' => '-', 'class' => 'success']
        ];

        return view('admin.maintenance', compact('systemStatus'));
    }
}
