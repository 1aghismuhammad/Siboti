<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Checkin;
use App\Models\ProgressRecord;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PersonalTrainerDashboardController extends Controller
{
    public function __invoke(): View
    {
        $this->authorizeRole('trainer');

        $trainerId = Auth::id();

        $todaySchedules = Booking::with('user')
            ->where('trainer_id', $trainerId)
            ->where('admin_approved', true)
            ->whereDate('booking_date', Carbon::today())
            ->orderBy('booking_time')
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'member' => $booking->user?->name ?? 'Guest',
                    'start' => substr($booking->booking_time, 0, 5),
                    'end' => Carbon::parse($booking->booking_time)->addHour()->format('H:i'),
                    'program' => $booking->session_type ?? 'Personal Training',
                    'focus' => 'Sesi Latihan',
                    'status' => $this->normalizeBookingStatus($booking->status),
                    'statusClass' => $this->getStatusClass($booking->status),
                    'initials' => $this->getInitials($booking->user?->name ?? 'GM'),
                ];
            });

        $activeClients = Booking::where('trainer_id', $trainerId)
            ->where('admin_approved', true)
            ->distinct('user_id')
            ->count('user_id');

        $bookingsThisWeek = Booking::where('trainer_id', $trainerId)
            ->whereBetween('booking_date', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])
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
            ->where('trainer_id', $trainerId)
            ->where('admin_approved', true)
            ->latest('booking_date')
            ->limit(3)
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'id' => $booking->id,
                    'member' => $booking->user?->name ?? 'Guest',
                    'membership' => ucfirst($booking->status),
                    'time' => $booking->booking_date->format('d M Y') . ', ' . substr($booking->booking_time, 0, 5),
                    'status' => $booking->status === 'pending' ? 'Menunggu' : ucfirst($booking->status),
                    'statusClass' => $booking->status === 'pending' ? 'warning' : ($booking->status === 'approved' ? 'success' : 'danger'),
                ];
            })
            ->toArray();

        $bookings = Booking::with('user')
            ->where('trainer_id', $trainerId)
            ->where('admin_approved', true)
            ->latest('booking_date')
            ->limit(4)
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'id' => $booking->id,
                    'member' => $booking->user?->name ?? 'Guest',
                    'program' => $booking->session_type,
                    'dateTime' => $booking->booking_date->format('d M Y') . ', ' . substr($booking->booking_time, 0, 5),
                    'status' => $this->normalizeBookingStatus($booking->status),
                    'statusClass' => $this->getStatusClass($booking->status),
                    'initials' => $this->getInitials($booking->user?->name ?? 'GM'),
                ];
            })
            ->toArray();

        $clients = Booking::with('user')
            ->where('trainer_id', $trainerId)
            ->where('admin_approved', true)
            ->latest('booking_date')
            ->get()
            ->unique('user_id')
            ->map(function (Booking $booking) {
                $user = $booking->user;
                $subscription = $user?->subscriptions()->where('status', 'active')->latest('end_date')->first();
                return [
                    'user_id' => $user?->id,
                    'name' => $user?->name ?? 'Guest',
                    'clientId' => sprintf('SBT-%04d', $user?->id ?? 0),
                    'package' => $subscription?->membershipPlan?->name ?? 'Membership',
                    'remainingLabel' => 'Sisa Hari',
                    'remaining' => $subscription ? Carbon::today()->diffInDays($subscription->end_date, false) . ' Hari' : 'Tidak aktif',
                    'statusClass' => 'success',
                    'initials' => $this->getInitials($user?->name ?? 'GM'),
                ];
            })
            ->toArray();

        $progressHistory = ProgressRecord::with('user')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function (ProgressRecord $record) {
                return [
                    'id' => $record->id,
                    'member' => $record->user?->name ?? 'Guest',
                    'time' => $record->created_at->format('d M Y'),
                    'weight' => $record->weight ? number_format($record->weight, 1, ',', '.') . ' kg' : '-',
                    'height' => $record->height ? number_format($record->height, 1, ',', '.') . ' cm' : '-',
                    'muscle_mass' => $record->muscle_mass ? number_format($record->muscle_mass, 1, ',', '.') . ' kg' : '-',
                    'fat_percentage' => $record->fat_percentage ? number_format($record->fat_percentage, 1, ',', '.') . ' %' : '-',
                    'notes' => $record->notes ?? '-',
                ];
            })
            ->toArray();

        $approvedCount = Booking::where('trainer_id', $trainerId)->where('status', 'approved')->count();
        $pendingCount = Booking::where('trainer_id', $trainerId)->where('status', 'pending')->count();
        $completedCount = Booking::where('trainer_id', $trainerId)->where('status', 'completed')->count();
        $totalBookings = max($approvedCount + $pendingCount + $completedCount, 1);

        // Month-over-Month comparison
        $thisMonthCompleted = Booking::where('trainer_id', $trainerId)
            ->where('status', 'completed')
            ->whereMonth('booking_date', Carbon::now()->month)
            ->whereYear('booking_date', Carbon::now()->year)
            ->count();
        $lastMonthCompleted = Booking::where('trainer_id', $trainerId)
            ->where('status', 'completed')
            ->whereMonth('booking_date', Carbon::now()->subMonth()->month)
            ->whereYear('booking_date', Carbon::now()->subMonth()->year)
            ->count();
        $momChange = $lastMonthCompleted > 0
            ? round((($thisMonthCompleted - $lastMonthCompleted) / $lastMonthCompleted) * 100)
            : ($thisMonthCompleted > 0 ? 100 : 0);
        $momLabel = ($momChange >= 0 ? '+' : '') . $momChange . '%';

        $performanceSummaries = [
            [
                'label' => 'Target Tercapai',
                'value' => number_format($approvedCount, 0, ',', '.'),
                'unit' => 'Booking',
                'progress' => min(100, intval(($approvedCount / $totalBookings) * 100)),
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
                'value' => number_format($pendingCount, 0, ',', '.'),
                'unit' => 'Booking',
                'progress' => min(100, intval(($pendingCount / $totalBookings) * 100)),
                'variant' => 'danger',
            ],
            [
                'label' => 'Sesi Selesai MoM',
                'value' => $momLabel,
                'unit' => '',
                'progress' => min(100, max(0, 50 + $momChange)),
                'variant' => $momChange >= 0 ? 'positive' : 'danger',
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

        return view('crud_trainer.dashboard', compact(
            'stats',
            'todaySchedules',
            'recentBookings',
            'bookings',
            'clients',
            'progressHistory',
            'performanceSummaries',
            'activities',
            'alerts',
            'pendingCount'
        ));
    }
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $this->authorizeRole('trainer');

        if ($booking->trainer_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['approved', 'cancelled', 'completed'])],
        ]);

        $booking->status = $validated['status'];
        $booking->save();

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function removeMember(Request $request, $userId)
    {
        $this->authorizeRole('trainer');
        
        Booking::where('trainer_id', Auth::id())
            ->where('user_id', $userId)
            ->update(['status' => 'cancelled', 'admin_approved' => false]);

        return back()->with('success', 'Member berhasil dihapus dari daftar Anda.');
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
