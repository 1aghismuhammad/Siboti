<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Checkin;
use App\Models\MembershipPlan;
use App\Models\ProgressRecord;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $trainer = User::factory()->create([
            'name' => 'Trainer SiBoti',
            'email' => 'trainer@siboti.com',
            'role' => 'trainer',
        ]);

        $receptionist = User::factory()->create([
            'name' => 'Receptionist SiBoti',
            'email' => 'receptionist@siboti.com',
            'role' => 'receptionist',
        ]);

        $member = User::factory()->create([
            'name' => 'Member SiBoti',
            'email' => 'member@siboti.com',
            'role' => 'member',
        ]);

        $memberTwo = User::factory()->create([
            'name' => 'Member Budi',
            'email' => 'member2@siboti.com',
            'role' => 'member',
        ]);

        $basicPlan = MembershipPlan::create([
            'name' => 'Membership Bulanan',
            'description' => 'Akses penuh gym selama 30 hari dengan fasilitas standar.',
            'duration_days' => 30,
            'price' => 299000,
            'is_active' => true,
        ]);

        $premiumPlan = MembershipPlan::create([
            'name' => 'Membership Premium',
            'description' => 'Akses penuh gym selama 90 hari plus satu sesi personal trainer setiap minggu.',
            'duration_days' => 90,
            'price' => 799000,
            'is_active' => true,
        ]);

        $annualPlan = MembershipPlan::create([
            'name' => 'Membership Tahunan',
            'description' => 'Akses gym selama 365 hari dengan potongan harga khusus dan fasilitas VIP.',
            'duration_days' => 365,
            'price' => 2499000,
            'is_active' => true,
        ]);

        Subscription::create([
            'user_id' => $member->id,
            'membership_plan_id' => $basicPlan->id,
            'start_date' => Carbon::today()->toDateString(),
            'end_date' => Carbon::today()->addDays($basicPlan->duration_days)->toDateString(),
            'status' => 'active',
        ]);

        Booking::create([
            'user_id' => $member->id,
            'booking_date' => Carbon::today()->addDay()->toDateString(),
            'booking_time' => '10:00:00',
            'session_type' => 'Personal Training',
            'status' => 'pending',
        ]);

        Booking::create([
            'user_id' => $memberTwo->id,
            'booking_date' => Carbon::today()->addDays(2)->toDateString(),
            'booking_time' => '15:30:00',
            'session_type' => 'Gym Umum',
            'status' => 'approved',
        ]);

        Checkin::create([
            'user_id' => $member->id,
            'checkin_time' => Carbon::now()->subDays(1),
        ]);

        ProgressRecord::create([
            'user_id' => $member->id,
            'weight' => 68.5,
            'height' => 172.0,
            'muscle_mass' => 28.4,
            'fat_percentage' => 18.2,
            'notes' => 'Mulai program kebugaran dengan fokus meningkatkan kekuatan dan menurunkan lemak.',
        ]);
    }
}
