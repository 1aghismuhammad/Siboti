<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ProgressRecord;
use App\Models\Booking;
use App\Models\User;

$member = User::where('email', 'member@siboti.com')->first();
$trainer = User::where('email', 'trainer@siboti.com')->first();
$progress = ProgressRecord::where('user_id', $member->id ?? 0)->get();
$bookings = Booking::where('user_id', $member->id ?? 0)->with('trainer')->get();
$trainers = User::where('role', 'trainer')->get();

echo "========================================\n";
echo "DATABASE CONNECTION VERIFICATION\n";
echo "========================================\n";
echo "Member ID: " . ($member ? $member->id : 'NOT FOUND') . "\n";
echo "Member Email: " . ($member ? $member->email : 'N/A') . "\n";
echo "\nTrainer ID: " . ($trainer ? $trainer->id : 'NOT FOUND') . "\n";
echo "Trainer Email: " . ($trainer ? $trainer->email : 'N/A') . "\n";
echo "\n--- Progress Records ---\n";
echo "Total Progress Records: " . $progress->count() . "\n";
if ($progress->count() > 0) {
    echo "Latest Progress:\n";
    foreach ($progress->take(3) as $p) {
        echo "  - Weight: " . $p->weight . " kg | Muscle: " . $p->muscle_mass . "% | Fat: " . $p->fat_percentage . "% | Date: " . $p->created_at->format('Y-m-d H:i') . "\n";
    }
}

echo "\n--- Bookings ---\n";
echo "Total Bookings: " . $bookings->count() . "\n";
if ($bookings->count() > 0) {
    echo "Recent Bookings:\n";
    foreach ($bookings->take(3) as $b) {
        echo "  - Trainer: " . ($b->trainer ? $b->trainer->name : 'UNKNOWN') . " | Date: " . $b->booking_date . " | Status: " . $b->status . "\n";
    }
}

echo "\n--- Trainers in Database ---\n";
echo "Total Trainers: " . $trainers->count() . "\n";
foreach ($trainers as $t) {
    echo "  - " . $t->name . " (ID: " . $t->id . ", Email: " . $t->email . ")\n";
}

echo "\n========================================\n";
echo "✓ All database connections verified!\n";
echo "========================================\n";
