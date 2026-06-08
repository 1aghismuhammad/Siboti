<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Checkin;
use App\Models\MembershipPlan;
use App\Models\ProgressRecord;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $receptionist = User::updateOrCreate(
            ['email' => 'receptionist@siboti.com'],
            [
                'name' => 'Receptionist SiBoti',
                'role' => 'receptionist',
                'password' => Hash::make('password'),
            ]
        );

        $member = User::updateOrCreate(
            ['email' => 'member@siboti.com'],
            [
                'name' => 'Member SiBoti',
                'role' => 'member',
                'password' => Hash::make('password'),
            ]
        );

        $memberTwo = User::updateOrCreate(
            ['email' => 'member2@siboti.com'],
            [
                'name' => 'Member Budi',
                'role' => 'member',
                'password' => Hash::make('password'),
            ]
        );

        $basicPlan = MembershipPlan::firstOrCreate(
            ['name' => 'Membership Bulanan'],
            [
                'description' => 'Akses penuh gym selama 30 hari dengan fasilitas standar.',
                'duration_days' => 30,
                'price' => 299000,
                'is_active' => true,
            ]
        );

        $premiumPlan = MembershipPlan::firstOrCreate(
            ['name' => 'Membership Premium'],
            [
                'description' => 'Akses penuh gym selama 90 hari plus satu sesi personal trainer setiap minggu.',
                'duration_days' => 90,
                'price' => 799000,
                'is_active' => true,
            ]
        );

        $annualPlan = MembershipPlan::firstOrCreate(
            ['name' => 'Membership Tahunan'],
            [
                'description' => 'Akses gym selama 365 hari dengan potongan harga khusus dan fasilitas VIP.',
                'duration_days' => 365,
                'price' => 2499000,
                'is_active' => true,
            ]
        );

        Subscription::firstOrCreate(
            [
                'user_id' => $member->id,
                'membership_plan_id' => $basicPlan->id,
            ],
            [
                'start_date' => Carbon::today()->toDateString(),
                'end_date' => Carbon::today()->addDays($basicPlan->duration_days)->toDateString(),
                'status' => 'active',
            ]
        );

        Booking::firstOrCreate(
            [
                'user_id' => $member->id,
                'booking_date' => Carbon::today()->addDay()->toDateString(),
                'booking_time' => '10:00:00',
            ],
            [
                'session_type' => 'Personal Training',
                'status' => 'pending',
            ]
        );

        Booking::firstOrCreate(
            [
                'user_id' => $memberTwo->id,
                'booking_date' => Carbon::today()->addDays(2)->toDateString(),
                'booking_time' => '15:30:00',
            ],
            [
                'session_type' => 'Gym Umum',
                'status' => 'approved',
            ]
        );

        Checkin::firstOrCreate(
            [
                'user_id' => $member->id,
                'checkin_time' => Carbon::now()->subDays(1),
            ]
        );

        ProgressRecord::firstOrCreate(
            [
                'user_id' => $member->id,
                'weight' => 68.5,
                'height' => 172.0,
            ],
            [
                'muscle_mass' => 28.4,
                'fat_percentage' => 18.2,
                'notes' => 'Mulai program kebugaran dengan fokus meningkatkan kekuatan dan menurunkan lemak.',
            ]
        );
    }
}
