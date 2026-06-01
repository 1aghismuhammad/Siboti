<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Checkin;
use App\Models\PosTransaction;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReportPageController extends Controller
{
    public function __invoke(): View
    {
        $activeMembers = Subscription::where('status', 'active')
            ->whereDate('end_date', '>=', Carbon::today())
            ->count();

        $totalBookings = Booking::count();
        $totalCheckins = Checkin::count();
        $totalPosRevenue = PosTransaction::sum('total');
        $expiredMembers = Subscription::where('status', 'expired')->count();
        $completedBookings = Booking::where('status', 'approved')->count();
        $trainerCount = 1;

        if (class_exists(\App\Models\User::class)) {
            $trainerCount = \App\Models\User::where('role', 'trainer')->count();
        }

        $stats = [
            [
                'label' => 'Total Member Aktif',
                'value' => number_format($activeMembers, 0, ',', '.'),
                'note' => '+6,8% bulan ini',
                'icon' => 'groups',
                'variant' => 'positive',
            ],
            [
                'label' => 'Total Booking',
                'value' => number_format($totalBookings, 0, ',', '.'),
                'note' => 'Periode berjalan',
                'icon' => 'event_available',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Total Check-in',
                'value' => number_format($totalCheckins, 0, ',', '.'),
                'note' => $totalBookings ? sprintf('%d%% dari booking', round($totalCheckins / max($totalBookings, 1) * 100)) : '0%',
                'icon' => 'qr_code_scanner',
                'variant' => 'positive',
            ],
            [
                'label' => 'Transaksi POS',
                'value' => 'Rp' . number_format($totalPosRevenue, 0, ',', '.'),
                'note' => '+8% dari target',
                'icon' => 'point_of_sale',
                'variant' => 'positive',
            ],
            [
                'label' => 'Membership Expired',
                'value' => number_format($expiredMembers, 0, ',', '.'),
                'note' => 'Perlu follow-up',
                'icon' => 'event_busy',
                'variant' => 'danger',
            ],
            [
                'label' => 'Booking Selesai',
                'value' => number_format($completedBookings, 0, ',', '.'),
                'note' => $totalBookings ? sprintf('%s%% selesai', round($completedBookings / max($totalBookings, 1) * 100, 1)) : '0%',
                'icon' => 'task_alt',
                'variant' => 'positive',
            ],
            [
                'label' => 'Pendapatan Simulasi',
                'value' => 'Rp' . number_format($totalPosRevenue + ($activeMembers * 299000), 0, ',', '.'),
                'note' => 'Membership + POS',
                'icon' => 'payments',
                'variant' => 'positive',
            ],
            [
                'label' => 'Trainer Aktif',
                'value' => number_format($trainerCount, 0, ',', '.'),
                'note' => 'Jumlah trainer terdaftar',
                'icon' => 'sports',
                'variant' => 'neutral',
            ],
        ];

        $weekStart = Carbon::today()->startOfWeek();
        $weekDays = [];
        $bookingCheckinChart = [];

        for ($i = 0; $i < 7; $i++) {
            $day = $weekStart->copy()->addDays($i);
            $bookingCount = Booking::whereDate('booking_date', $day)->count();
            $checkinCount = Checkin::whereDate('checkin_time', $day)->count();

            $bookingCheckinChart[] = [
                'label' => $day->locale('id')->isoFormat('ddd'),
                'booking' => $bookingCount,
                'checkin' => $checkinCount,
            ];
        }

        $memberGrowth = collect(range(1, 6))->map(function ($index) {
            $month = Carbon::now()->subMonths(6 - $index)->locale('id')->isoFormat('MMM');
            return ['month' => $month, 'total' => 920 + ($index * 60)];
        })->values()->toArray();

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

        $memberships = Subscription::with('user', 'membershipPlan')
            ->latest('end_date')
            ->limit(5)
            ->get()
            ->map(function (Subscription $subscription) {
                $isActive = $subscription->status === 'active' && $subscription->end_date->isFuture();
                return [
                    'id' => sprintf('MEM-%04d', $subscription->user?->id ?? 0),
                    'name' => $subscription->user?->name ?? 'Guest',
                    'package' => $subscription->membershipPlan?->name ?? 'Membership',
                    'registered' => $subscription->start_date->format('d M Y'),
                    'expired' => $subscription->end_date->format('d M Y'),
                    'status' => $isActive ? 'Aktif' : 'Expired',
                    'statusClass' => $isActive ? 'success' : 'danger',
                ];
            })
            ->toArray();

        $bookingCheckins = Booking::with('user')
            ->latest('booking_date')
            ->limit(5)
            ->get()
            ->map(function (Booking $booking) {
                $checkin = Checkin::where('user_id', $booking->user_id)
                    ->whereDate('checkin_time', $booking->booking_date)
                    ->first();

                return [
                    'id' => sprintf('BK-%s', str_replace('-', '', $booking->booking_date->format('ymd'))),
                    'member' => $booking->user?->name ?? 'Guest',
                    'session' => $booking->session_type,
                    'bookingTime' => $booking->booking_date->format('d M Y') . ', ' . substr($booking->booking_time, 0, 5),
                    'checkinTime' => $checkin ? $checkin->checkin_time->format('d M Y, H.i') : '-',
                    'status' => $this->normalizeBookingStatus($booking->status),
                    'statusClass' => $this->getStatusClass($booking->status),
                ];
            })
            ->toArray();

        $posTransactions = PosTransaction::latest('transacted_at')
            ->limit(5)
            ->get()
            ->map(function (PosTransaction $transaction) {
                return [
                    'id' => $transaction->transaction_id,
                    'date' => $transaction->transacted_at->format('d M Y'),
                    'item' => $transaction->member_name,
                    'total' => 'Rp' . number_format($transaction->total, 0, ',', '.'),
                    'method' => $transaction->payment_method ?? 'QRIS',
                    'status' => $transaction->status,
                    'statusClass' => $transaction->status_class,
                ];
            })
            ->toArray();

        $alerts = [
            [
                'icon' => 'warning',
                'title' => sprintf('%d membership sudah expired', $expiredMembers),
                'description' => 'Prioritaskan follow-up untuk paket bulanan dan trial pass.',
                'type' => 'danger',
            ],
            [
                'icon' => 'pending_actions',
                'title' => sprintf('%d transaksi POS pending', PosTransaction::where('status', 'Pending')->count()),
                'description' => 'Perlu dicek ulang sebelum tutup kas harian.',
                'type' => 'info',
            ],
            [
                'icon' => 'inventory_2',
                'title' => sprintf('%d produk stok rendah', Product::where('stock', '<=', 5)->count()),
                'description' => 'Produk stok rendah perlu restok.',
                'type' => 'neutral',
            ],
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

    private function getStatusClass(string $status): string
    {
        return match ($status) {
            'approved', 'completed' => 'success',
            'cancelled' => 'danger',
            'pending' => 'warning',
            default => 'neutral',
        };
    }

    private function normalizeBookingStatus(string $status): string
    {
        return match ($status) {
            'approved' => 'Selesai',
            'pending' => 'Menunggu',
            'cancelled' => 'Batal',
            default => ucfirst($status),
        };
    }
}
