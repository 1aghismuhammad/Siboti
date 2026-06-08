<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Remove placeholder dummy account if it exists.
        User::where('email', 'test@example.com')->delete();

        // User::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            TrainerSeeder::class,
            DemoDataSeeder::class,
        ]);

    }
}
