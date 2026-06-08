<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;

echo "========================================\n";
echo "BOOKING DETAILS\n";
echo "========================================\n";

$bookings = Booking::all();
echo "Total Bookings: " . $bookings->count() . "\n\n";

foreach ($bookings as $b) {
    echo "Booking ID: " . $b->id . "\n";
    echo "  User ID: " . $b->user_id . "\n";
    echo "  Trainer ID: " . $b->trainer_id . "\n";
    echo "  Booking Date: " . $b->booking_date . "\n";
    echo "  Status: " . $b->status . "\n";
    echo "  Session Type: " . $b->session_type . "\n";
    echo "\n";
}
