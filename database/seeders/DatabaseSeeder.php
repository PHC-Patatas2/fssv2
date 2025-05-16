<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Test Admin
        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        // Test Scheduler
        User::factory()->create([
            'name' => 'Test Scheduler',
            'email' => 'scheduler@example.com',
            'password' => bcrypt('password'),
            'role' => 'scheduler',
        ]);
    }
}
