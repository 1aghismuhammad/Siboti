<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Checkin;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $activeMembers = Subscription::where('status', 'active')
            ->whereDate('end_date', '>=', Carbon::today())
            ->distinct('user_id')
            ->count('user_id');

        $bookingToday = Booking::whereDate('booking_date', Carbon::today())->count();

        $checkinToday = Checkin::whereDate('checkin_time', Carbon::today())->count();

        $monthlyRevenue = Subscription::whereMonth('start_date', Carbon::today()->month)
            ->join('membership_plans', 'membership_plans.id', '=', 'subscriptions.membership_plan_id')
            ->sum('membership_plans.price');

        $stats = [
            [
                'label' => 'Total Member Aktif',
                'value' => number_format($activeMembers, 0, ',', '.'),
                'note' => 'Berbasis subscription aktif',
                'icon' => 'groups',
                'variant' => 'positive',
            ],
            [
                'label' => 'Booking Hari Ini',
                'value' => number_format($bookingToday, 0, ',', '.'),
                'note' => 'Termasuk pending dan approved',
                'icon' => 'event_available',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Check-in Hari Ini',
                'value' => number_format($checkinToday, 0, ',', '.'),
                'note' => 'Data live check-in',
                'icon' => 'qr_code_scanner',
                'variant' => 'positive',
            ],
            [
                'label' => 'Pendapatan Bulanan',
                'value' => 'Rp' . number_format($monthlyRevenue, 0, ',', '.'),
                'note' => 'Dari start subscription bulan ini',
                'icon' => 'payments',
                'variant' => 'positive',
            ],
        ];

        $bookings = Booking::with('user')
            ->orderByDesc('booking_date')
            ->limit(5)
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'member' => $booking->user?->name ?? 'Guest',
                    'trainer' => '-',
                    'session' => $booking->session_type,
                    'date' => $booking->booking_date?->format('d M Y') ?? '-',
                    'time' => substr($booking->booking_time, 0, 5),
                    'status' => ucfirst($booking->status),
                    'statusClass' => $this->getStatusClass($booking->status),
                ];
            })
            ->toArray();



        $activities = Checkin::with('user')
            ->latest('checkin_time')
            ->limit(3)
            ->get()
            ->map(function (Checkin $checkin) {
                return [
                    'icon' => 'person_add',
                    'text' => sprintf('Member %s melakukan check-in.', $checkin->user?->name ?? 'Guest'),
                    'time' => $checkin->checkin_time->diffForHumans(),
                ];
            })
            ->toArray();

        $expiredCount = Subscription::where('status', 'expired')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $lowStockCount = Product::where('stock', '<', 10)->count();

        $alerts = [];

        if ($expiredCount > 0) {
            $alerts[] = [
                'title' => sprintf('%d Membership Expired', $expiredCount),
                'description' => 'Harap tindak lanjuti untuk perpanjangan.',
                'type' => 'danger',
                'icon' => 'warning',
            ];
        }

        if ($pendingBookings > 0) {
            $alerts[] = [
                'title' => sprintf('%d Booking Pending', $pendingBookings),
                'description' => 'Menunggu konfirmasi ketersediaan pelatih.',
                'type' => 'info',
                'icon' => 'info',
            ];
        }

        if ($lowStockCount > 0) {
            $alerts[] = [
                'title' => 'Stok Produk Menipis',
                'description' => sprintf('%d produk perlu restok.', $lowStockCount),
                'type' => 'neutral',
                'icon' => 'inventory_2',
            ];
        }

        return view('admin.dashboard', compact('stats', 'bookings', 'activities', 'alerts'));
    }

    private function getStatusClass(string $status): string
    {
        return match ($status) {
            'approved' => 'success',
            'completed' => 'neutral',
            'cancelled' => 'danger',
            'pending' => 'warning',
            default => 'neutral',
        };
    }
}
