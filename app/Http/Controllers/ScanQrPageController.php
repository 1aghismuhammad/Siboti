<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ScanQrPageController extends Controller
{


    public function __invoke(): View
    {
        $this->authorizeRole('receptionist');

        $todayScans = Checkin::whereDate('checkin_time', Carbon::today());
        $checkinsCount = $todayScans->count();
        $failedAccessCount = Subscription::where('status', 'expired')->count();
        $duplicateCount = Checkin::select('user_id')
            ->whereDate('checkin_time', Carbon::today())
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        $stats = [
            [
                'label' => 'Scan Hari Ini',
                'value' => number_format($todayScans->count(), 0, ',', '.'),
                'note' => sprintf('%d scan tercatat', $checkinsCount),
                'icon' => 'qr_code_scanner',
                'variant' => 'positive',
            ],
            [
                'label' => 'Check-in Berhasil',
                'value' => number_format($checkinsCount, 0, ',', '.'),
                'note' => 'Data langsung dari checkin',
                'icon' => 'check_circle',
                'variant' => 'positive',
            ],
            [
                'label' => 'Akses Ditolak',
                'value' => number_format($failedAccessCount, 0, ',', '.'),
                'note' => 'Expired / suspended',
                'icon' => 'block',
                'variant' => 'danger',
            ],
            [
                'label' => 'Scan Duplikat',
                'value' => number_format($duplicateCount, 0, ',', '.'),
                'note' => 'Perlu verifikasi',
                'icon' => 'repeat',
                'variant' => 'neutral',
            ],
        ];

        $members = Subscription::with('user', 'membershipPlan')
            ->latest('end_date')
            ->limit(5)
            ->get()
            ->mapWithKeys(function (Subscription $subscription) {
                $user = $subscription->user;
                $lastCheckin = Checkin::where('user_id', $user?->id)
                    ->latest('checkin_time')
                    ->first();
                $status = $subscription->status === 'active' ? 'AKTIF' : 'EXPIRED';
                return [
                    sprintf('MEM-%04d', $user?->id ?? 0) => [
                        'name' => $user?->name ?? 'Guest',
                        'memberId' => sprintf('MEM-%04d', $user?->id ?? 0),
                        'package' => $subscription->membershipPlan?->name ?? 'Membership',
                        'remaining' => $subscription->end_date->diffInDays(Carbon::today()) . ' Hari',
                        'lastCheckin' => $lastCheckin ? 'Terakhir check-in ' . $lastCheckin->checkin_time->format('H.i') : 'Belum check-in hari ini',
                        'status' => $status,
                        'statusClass' => $status === 'AKTIF' ? 'success' : 'danger',
                        'note' => $status === 'AKTIF'
                            ? 'Member aktif. Check-in dapat dikonfirmasi.'
                            : 'Membership sudah expired. Arahkan member ke proses perpanjangan.',
                        'initials' => $this->getInitials($user?->name ?? 'GM'),
                        'access' => $status === 'AKTIF',
                        'qrToken' => sprintf('QR-SBT-%04d-%s', $user?->id ?? 0, strtoupper($status)),
                    ],
                ];
            })
            ->toArray();

        $recentScans = Checkin::with('user')
            ->latest('checkin_time')
            ->limit(4)
            ->get()
            ->map(function (Checkin $checkin) {
                return [
                    'time' => $checkin->checkin_time->format('H.i'),
                    'name' => $checkin->user?->name ?? 'Guest',
                    'memberId' => sprintf('MEM-%04d', $checkin->user?->id ?? 0),
                    'package' => $checkin->user?->subscriptions()->where('status', 'active')->latest('end_date')->first()?->membershipPlan?->name ?? 'Membership',
                    'method' => 'QR Scanner',
                    'gate' => 'Front Desk',
                    'status' => 'Berhasil',
                    'statusClass' => 'success',
                ];
            })
            ->toArray();

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
                'description' => sprintf('%d scan duplikat terdeteksi hari ini.', $duplicateCount),
                'type' => 'warning',
                'icon' => 'repeat',
            ],
            [
                'title' => 'Membership Expired',
                'description' => sprintf('%d member expired mencoba check-in pada shift hari ini.', $failedAccessCount),
                'type' => 'danger',
                'icon' => 'event_busy',
            ],
        ];

        return view('scan-qr.index', compact('stats', 'members', 'recentScans', 'instructions', 'alerts'));
    }

    private function getInitials(string $name): string
    {
        return collect(explode(' ', $name))->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join('');
    }

    private function normalizeScanStatus(?string $status): string
    {
        return match ($status) {
            'rejected' => 'Ditolak',
            'duplicate' => 'Duplikat',
            'approved' => 'Berhasil',
            default => 'Berhasil',
        };
    }

    private function getStatusClass(?string $status): string
    {
        return match ($status) {
            'rejected' => 'danger',
            'duplicate' => 'warning',
            'approved' => 'success',
            default => 'success',
        };
    }

    public function checkin(Request $request)
    {
        $request->validate(['member_id' => 'required|string']);

        $memberIdStr = strtoupper(trim($request->member_id));
        $userId = intval(preg_replace('/[^0-9]/', '', $memberIdStr));

        $user = \App\Models\User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.',
            ], 404);
        }

        $subscription = Subscription::with('membershipPlan')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest('end_date')
            ->first();

        if (!$subscription || $subscription->end_date->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak aktif atau sudah expired.',
            ], 422);
        }

        Checkin::create([
            'user_id' => $user->id,
            'checkin_time' => now()
        ]);

        $memberData = [
            'name'      => $user->name,
            'initials'  => $this->getInitials($user->name),
            'memberId'  => sprintf('MEM-%04d', $user->id),
            'package'   => $subscription->membershipPlan?->name ?? 'Membership',
            'remaining' => now()->diffInDays($subscription->end_date, false) . ' Hari',
            'status'    => 'active',
        ];

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil dicatat.',
            'member'  => $memberData,
            'time'    => now()->format('H:i'),
        ]);
    }
}