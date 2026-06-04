<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Checkin;
use App\Models\ProgressRecord;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PersonalTrainerDashboardController extends Controller
{
    public function __invoke(): View
    {
        $todaySchedules = Booking::with('user')
            ->whereDate('booking_date', Carbon::today())
            ->orderBy('booking_time')
            ->get();

        $activeClients = Subscription::where('status', 'active')
            ->whereDate('end_date', '>=', Carbon::today())
            ->distinct('user_id')
            ->count('user_id');

        $bookingsThisWeek = Booking::whereBetween('booking_date', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])
            ->count();

        $progressCount = ProgressRecord::count();

        $stats = [
            [
                'label' => 'Jadwal Hari Ini',
                'value' => number_format($todaySchedules->count(), 0, ',', '.'),
                'note' => $todaySchedules->count() > 0 ? sprintf('%d sesi hari ini', $todaySchedules->count()) : 'Belum ada sesi',
                'icon' => 'calendar_today',
                'variant' => 'positive',
            ],
            [
                'label' => 'Klien Aktif',
                'value' => number_format($activeClients, 0, ',', '.'),
                'note' => 'Berbasis subscription aktif',
                'icon' => 'group',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Booking Minggu Ini',
                'value' => number_format($bookingsThisWeek, 0, ',', '.'),
                'note' => sprintf('%d booking minggu ini', $bookingsThisWeek),
                'icon' => 'event_available',
                'variant' => 'warning',
            ],
            [
                'label' => 'Progres Diinput',
                'value' => number_format($progressCount, 0, ',', '.'),
                'note' => 'Total progress records',
                'icon' => 'trending_up',
                'variant' => 'positive',
            ],
        ];

        $recentBookings = Booking::with('user')
            ->latest('booking_date')
            ->limit(3)
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'member' => $booking->user?->name ?? 'Guest',
                    'membership' => ucfirst($booking->status),
                    'time' => $booking->booking_date->format('d M Y') . ', ' . substr($booking->booking_time, 0, 5),
                    'status' => $booking->status === 'pending' ? 'Menunggu' : 'Confirmed',
                    'statusClass' => $booking->status === 'pending' ? 'warning' : 'success',
                ];
            })
            ->toArray();

        $bookings = Booking::with('user')
            ->latest('booking_date')
            ->limit(4)
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'member' => $booking->user?->name ?? 'Guest',
                    'program' => $booking->session_type,
                    'dateTime' => $booking->booking_date->format('d M Y') . ', ' . substr($booking->booking_time, 0, 5),
                    'status' => $this->normalizeBookingStatus($booking->status),
                    'statusClass' => $this->getStatusClass($booking->status),
                    'initials' => $this->getInitials($booking->user?->name ?? 'GM'),
                ];
            })
            ->toArray();

        $clients = Subscription::with('user', 'membershipPlan')
            ->where('status', 'active')
            ->whereDate('end_date', '>=', Carbon::today())
            ->latest('end_date')
            ->limit(3)
            ->get()
            ->map(function (Subscription $subscription) {
                $user = $subscription->user;
                return [
                    'name' => $user?->name ?? 'Guest',
                    'clientId' => sprintf('SBT-%04d', $user?->id ?? 0),
                    'package' => $subscription->membershipPlan?->name ?? 'Membership',
                    'remainingLabel' => 'Sisa Hari',
                    'remaining' => Carbon::today()->diffInDays($subscription->end_date, false) . ' Hari',
                    'statusClass' => 'success',
                    'initials' => $this->getInitials($user?->name ?? 'GM'),
                ];
            })
            ->toArray();

        $progressHistory = ProgressRecord::with('user')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function (ProgressRecord $record) {
                return [
                    'member' => $record->user?->name ?? 'Guest',
                    'time' => $record->created_at->diffForHumans(),
                    'weight' => $record->weight ? number_format($record->weight, 1, ',', '.') . ' kg' : '-',
                    'waist' => $record->height ? number_format($record->height, 1, ',', '.') . ' cm' : '-',
                ];
            })
            ->toArray();

        $performanceSummaries = [
            [
                'label' => 'Target Tercapai',
                'value' => number_format(Booking::where('status', 'approved')->count(), 0, ',', '.'),
                'unit' => 'Booking',
                'progress' => 70,
                'variant' => 'positive',
            ],
            [
                'label' => 'Konsistensi Tinggi',
                'value' => number_format($progressCount ? floor(($progressCount / max($activeClients, 1)) * 100) : 0, 0, ',', '.') . '%',
                'unit' => '',
                'progress' => min(100, $activeClients ? intval(($progressCount / $activeClients) * 100) : 0),
                'variant' => 'positive',
            ],
            [
                'label' => 'Butuh Perhatian',
                'value' => number_format(Booking::where('status', 'pending')->count(), 0, ',', '.'),
                'unit' => 'Booking',
                'progress' => 15,
                'variant' => 'danger',
            ],
            [
                'label' => 'Sesi Selesai MoM',
                'value' => '+12%',
                'unit' => '',
                'progress' => 60,
                'variant' => 'positive',
            ],
        ];

        $activities = Checkin::with('user')
            ->latest('checkin_time')
            ->limit(3)
            ->get()
            ->map(function (Checkin $checkin) {
                return [
                    'icon' => 'task_alt',
                    'text' => sprintf('Coach mencatat check-in %s.', $checkin->user?->name ?? 'Guest'),
                    'time' => $checkin->checkin_time->diffForHumans(),
                ];
            })
            ->toArray();

        $alerts = [
            [
                'icon' => 'warning',
                'title' => sprintf('%d Klien Butuh Evaluasi', Booking::where('status', 'pending')->count()),
                'description' => 'Setelah review, beberapa program perlu disesuaikan.',
                'type' => 'danger',
            ],
            [
                'icon' => 'info',
                'title' => 'Maintenance Kalender',
                'description' => 'Sinkronisasi jadwal akan dibatasi pada Minggu dini hari.',
                'type' => 'info',
            ],
        ];

        return view('crud_pelatih.dashboard', compact(
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

    private function normalizeBookingStatus(string $status): string
    {
        return $status === 'pending' ? 'Menunggu' : ucfirst($status);
    }

    private function getInitials(string $name): string
    {
        return collect(explode(' ', $name))->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join('');
    }
}
