<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TrainerSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'trainer@siboti.com'],
            [
                'name' => 'Trainer SiBoti',
                'role' => 'trainer',
                'password' => Hash::make('trainer123'),
            ]
        );
    }
}
