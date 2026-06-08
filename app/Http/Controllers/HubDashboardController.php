<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Checkin;
use App\Models\ProgressRecord;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class HubDashboardController extends Controller
{
    public function dashboard(): View
    {
        $this->authorizeRole('member');
        $userId = auth()->id();

        // Active subscription
        $subscription = Subscription::with('membershipPlan')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->latest('end_date')
            ->first();

        $paketAktif = $subscription ? $subscription->membershipPlan->name : 'Tidak ada paket aktif';
        $sisaHari = $subscription ? Carbon::today()->diffInDays($subscription->end_date, false) : 0;
        $sisaHariText = $sisaHari > 0 ? $sisaHari : 0;
        
        $berlakuHingga = $subscription ? Carbon::parse($subscription->end_date)->format('d M Y') : '-';

        // Upcoming bookings
        $upcomingBookings = Booking::with('trainer')
            ->where('user_id', $userId)
            ->where('booking_date', '>=', Carbon::today())
            ->where('status', 'approved')
            ->orderBy('booking_date', 'asc')
            ->orderBy('booking_time', 'asc')
            ->take(5)
            ->get()
            ->map(function ($booking) {
                return [
                    'day' => $booking->booking_date->translatedFormat('D'),
                    'date' => $booking->booking_date->format('d'),
                    'type' => $booking->session_type ?? 'Personal Training',
                    'time_coach' => substr($booking->booking_time, 0, 5) . ' · Coach ' . ($booking->trainer?->name ?? '-'),
                ];
            });

        // Recent activities (progress records)
        $recentActivities = ProgressRecord::where('user_id', $userId)
            ->latest('created_at')
            ->take(3)
            ->get()
            ->map(function ($record) {
                return [
                    'when' => $record->created_at->diffForHumans(),
                    'name' => 'Cek Fisik & Body Stats',
                    'detail' => 'Berat: ' . ($record->weight ?? '-') . 'kg · Otot: ' . ($record->muscle_mass ?? '-') . '%',
                ];
            });

        // Stats
        $totalSesi = Booking::where('user_id', $userId)->where('status', 'completed')->count();
        $totalSesiMingguIni = Booking::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereBetween('booking_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        // Calculate active days from checkins
        $hariAktif = Checkin::where('user_id', $userId)->distinct('checkin_time')->count();

        // Latest muscle mass instead of Kalori
        $latestProgress = ProgressRecord::where('user_id', $userId)->latest('created_at')->first();
        $massaOtot = $latestProgress ? ($latestProgress->muscle_mass ?? 0) : 0;

        $stats = [
            [
                'label' => 'Sisa Sesi',
                'value' => $sisaHariText,
                'unit' => 'hari',
                'change' => 'Aktif hingga ' . ($subscription ? Carbon::parse($subscription->end_date)->format('d M') : '-'),
            ],
            [
                'label' => 'Total Sesi',
                'value' => $totalSesi,
                'unit' => 'sesi',
                'change' => '+' . $totalSesiMingguIni . ' minggu ini',
            ],
            [
                'label' => 'Hari Aktif',
                'value' => $hariAktif,
                'unit' => 'hr',
                'change' => 'Total check-in',
            ],
            [
                'label' => 'Massa Otot',
                'value' => $massaOtot,
                'unit' => '%',
                'change' => 'Data terakhir',
            ],
        ];

        return view('hub.dashboard', compact(
            'subscription',
            'paketAktif',
            'berlakuHingga',
            'upcomingBookings',
            'recentActivities',
            'stats',
            'userId'
        ));
    }

    public function qr(): View
    {
        $this->authorizeRole('member');
        $user = auth()->user();

        $subscription = Subscription::with('membershipPlan')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest('end_date')
            ->first();

        $paketAktif = $subscription ? $subscription->membershipPlan->name : 'TIDAK AKTIF';
        $memberId = sprintf('GZ-%05d', $user->id);

        $checkins = Checkin::where('user_id', $user->id)
            ->latest('checkin_time')
            ->take(10)
            ->get()
            ->map(function ($checkin) {
                $time = Carbon::parse($checkin->checkin_time);
                return [
                    'when' => $time->isToday() ? 'Hari Ini' : ($time->isYesterday() ? 'Kemarin' : $time->diffForHumans()),
                    'period' => $time->format('A') === 'AM' ? 'Pagi' : 'Siang/Sore',
                    'day' => $time->translatedFormat('l'),
                    'time' => $time->format('H.i'),
                ];
            });

        return view('hub.qr', compact('user', 'paketAktif', 'memberId', 'checkins'));
    }
}
