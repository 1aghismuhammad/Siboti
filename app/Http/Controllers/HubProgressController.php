<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ProgressRecord;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class HubProgressController extends Controller
{
    public function index(): View
    {
        $this->authorizeRole('member');

        $userId = auth()->id();

        // Get member's active subscription and trainer
        $subscription = Subscription::with(['user', 'membershipPlan'])
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->latest('end_date')
            ->first();

        // Get trainer from member's approved bookings
        $trainerBooking = Booking::where('user_id', $userId)
            ->where('status', 'approved')
            ->with('trainer')
            ->latest('booking_date')
            ->first();

        $trainer = $trainerBooking?->trainer;

        // Get progress records for this member from SQLite
        $progressRecords = ProgressRecord::where('user_id', $userId)
            ->latest('created_at')
            ->limit(12)
            ->get()
            ->map(function (ProgressRecord $record) {
                return [
                    'date' => $record->created_at->format('d M Y'),
                    'weight' => $record->weight ? number_format($record->weight, 1, ',', '.') . ' kg' : '-',
                    'height' => $record->height ? number_format($record->height, 1, ',', '.') . ' cm' : '-',
                    'muscleMass' => $record->muscle_mass ? number_format($record->muscle_mass, 1, ',', '.') . '%' : '-',
                    'fatPercentage' => $record->fat_percentage ? number_format($record->fat_percentage, 1, ',', '.') . '%' : '-',
                    'notes' => $record->notes ?? 'Tidak ada catatan',
                    'createdAt' => $record->created_at->diffForHumans(),
                ];
            })
            ->toArray();

        // Get latest progress record for stats
        $latestProgress = ProgressRecord::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        $weight = $latestProgress?->weight ?? 0;
        $muscleMass = $latestProgress?->muscle_mass ?? 0;
        $fatPercentage = $latestProgress?->fat_percentage ?? 0;

        // Calculate weight change (compare with previous)
        $previousProgress = ProgressRecord::where('user_id', $userId)
            ->latest('created_at')
            ->skip(1)
            ->first();

        $weightChange = 0;
        if ($latestProgress && $previousProgress && $latestProgress->weight && $previousProgress->weight) {
            $weightChange = $latestProgress->weight - $previousProgress->weight;
        }

        $stats = [
            [
                'label' => 'Berat Badan',
                'value' => $weight ? number_format($weight, 1, ',', '.') . ' kg' : '-',
                'change' => $weightChange !== 0 ? ($weightChange > 0 ? '+' : '') . number_format($weightChange, 1, ',', '.') . ' kg' : 'Stabil',
                'changeClass' => $weightChange > 0 ? 'up' : ($weightChange < 0 ? 'down' : 'neutral'),
            ],
            [
                'label' => 'Otot',
                'value' => $muscleMass ? number_format($muscleMass, 1, ',', '.') . '%' : '-',
                'change' => '+2.5%',
                'changeClass' => 'up',
            ],
            [
                'label' => 'Lemak Tubuh',
                'value' => $fatPercentage ? number_format($fatPercentage, 1, ',', '.') . '%' : '-',
                'change' => '-1.2%',
                'changeClass' => 'down',
            ],
            [
                'label' => 'Total Catatan',
                'value' => number_format(count($progressRecords), 0, ',', '.'),
                'change' => 'dari trainer',
                'changeClass' => 'neutral',
            ],
        ];

        return view('hub.progress', compact(
            'stats',
            'progressRecords',
            'subscription',
            'trainer',
            'weight',
            'muscleMass',
            'fatPercentage'
        ));
    }
}
