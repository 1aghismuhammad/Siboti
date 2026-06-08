<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\PosTransaction;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReceptionistDashboardController extends Controller
{
    public function __invoke(): View
    {
        $this->authorizeRole('receptionist');

        $checkinToday = Checkin::whereDate('checkin_time', Carbon::today())->count();
        $activeMembers = Subscription::where('status', 'active')
            ->whereDate('end_date', '>=', Carbon::today())
            ->count();
        $expiredMembers = Subscription::where('status', 'expired')->count();
        $approachingExpMembers = Subscription::where('status', 'active')
            ->whereDate('end_date', '<=', Carbon::today()->addDays(3))
            ->whereDate('end_date', '>=', Carbon::today())
            ->count();
        $posToday = PosTransaction::whereDate('transacted_at', Carbon::today())->count();

        $stats = [
            [
                'label' => 'Check-in Hari Ini',
                'value' => number_format($checkinToday, 0, ',', '.'),
                'note' => 'Data langsung dari checkin',
                'icon' => 'login',
                'variant' => 'positive',
            ],
            [
                'label' => 'Member Aktif',
                'value' => number_format($activeMembers, 0, ',', '.'),
                'note' => 'Siap check-in',
                'icon' => 'groups',
                'variant' => 'neutral',
            ],
            [
                'label' => 'Member Expired',
                'value' => number_format($expiredMembers, 0, ',', '.'),
                'note' => 'Perlu tindak lanjut',
                'icon' => 'event_busy',
                'variant' => 'danger',
            ],
            [
                'label' => 'Transaksi POS Hari Ini',
                'value' => 'Rp' . number_format(PosTransaction::whereDate('transacted_at', Carbon::today())->sum('total'), 0, ',', '.'),
                'note' => sprintf('%d transaksi', $posToday),
                'icon' => 'point_of_sale',
                'variant' => 'positive',
            ],
        ];

        $members = Subscription::with('user', 'membershipPlan')
            ->latest('end_date')
            ->limit(3)
            ->get()
            ->mapWithKeys(function (Subscription $subscription) {
                $user = $subscription->user;
                $isActive = $subscription->status === 'active' && $subscription->end_date->isFuture();

                return [
                    sprintf('MEM-%04d', $user?->id ?? 0) => [
                        'name' => $user?->name ?? 'Guest',
                        'memberId' => sprintf('MEM-%04d', $user?->id ?? 0),
                        'package' => $subscription->membershipPlan?->name ?? 'Membership',
                        'remaining' => $isActive ? Carbon::today()->diffInDays($subscription->end_date) . ' Hari' : '0 Hari',
                        'status' => $isActive ? 'AKTIF' : 'EXPIRED',
                        'statusClass' => $isActive ? 'success' : 'danger',
                        'note' => $isActive
                            ? 'Member valid. Silakan konfirmasi check-in.'
                            : 'Membership sudah berakhir. Arahkan ke proses perpanjangan.',
                        'initials' => $this->getInitials($user?->name ?? 'GM'),
                    ],
                ];
            })
            ->toArray();

        $checkIns = Checkin::with('user')
            ->latest('checkin_time')
            ->limit(3)
            ->get()
            ->map(function (Checkin $checkin) {
                return [
                    'name' => $checkin->user?->name ?? 'Guest',
                    'memberId' => sprintf('MEM-%04d', $checkin->user?->id ?? 0),
                    'package' => $checkin->user?->subscriptions()->where('status', 'active')->latest('end_date')->first()?->membershipPlan?->name ?? 'Membership',
                    'time' => $checkin->checkin_time->format('H:i'),
                    'status' => 'Berhasil',
                    'statusClass' => 'success',
                ];
            })
            ->toArray();

        $posTransactions = PosTransaction::latest('transacted_at')
            ->limit(3)
            ->get()
            ->map(function (PosTransaction $transaction) {
                return [
                    'trxId' => $transaction->transaction_id,
                    'cashier' => $transaction->cashier,
                    'member' => $transaction->member_name,
                    'product' => $transaction->items_count > 1 ? $transaction->items_count . ' item' : '1 item',
                    'total' => 'Rp' . number_format($transaction->total, 0, ',', '.'),
                    'status' => $transaction->status,
                    'statusClass' => $transaction->status_class,
                ];
            })
            ->toArray();

        $activities = Checkin::with('user')
            ->latest('checkin_time')
            ->limit(3)
            ->get()
            ->map(function (Checkin $checkin) {
                return [
                    'icon' => 'verified_user',
                    'text' => sprintf('Berhasil memvalidasi check-in %s.', $checkin->user?->name ?? 'Guest'),
                    'time' => $checkin->checkin_time->diffForHumans(),
                ];
            })
            ->toArray();

        $alerts = [
            [
                'title' => sprintf('%d Member Mendekati Expired', $approachingExpMembers),
                'description' => 'Masa aktif akan berakhir dalam 3 hari ke depan. Ingatkan saat check-in.',
                'type' => 'info',
                'icon' => 'info',
            ],
            [
                'title' => 'Transaksi Pending',
                'description' => sprintf('%d transaksi pending belum diselesaikan.', PosTransaction::where('status', 'Pending')->count()),
                'type' => 'warning',
                'icon' => 'warning',
            ],
        ];

        return view('receptionist.dashboard', compact('stats', 'members', 'checkIns', 'posTransactions', 'activities', 'alerts'));
    }

    private function getInitials(string $name): string
    {
        return collect(explode(' ', $name))->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join('');
    }
}
