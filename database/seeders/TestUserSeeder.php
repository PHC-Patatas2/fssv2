<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // Delete all entity edit locks first (foreign key constraint)
        DB::table('entity_edit_locks')->delete();
        // Delete all users
        DB::table('users')->delete();

        // Insert 1 approved admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved',
            'last_login_at' => now()->subDays(2),
        ]);
        // Insert 1 approved scheduler
        User::create([
            'name' => 'Scheduler Approved',
            'email' => 'scheduler.approved@example.com',
            'password' => Hash::make('password'),
            'role' => 'scheduler',
            'status' => 'approved',
            'last_login_at' => now()->subDays(1),
        ]);
        // Insert 2 pending schedulers
        User::create([
            'name' => 'Scheduler Pending 1',
            'email' => 'scheduler.pending1@example.com',
            'password' => Hash::make('password'),
            'role' => 'scheduler',
            'status' => 'pending',
            'last_login_at' => null,
        ]);
        User::create([
            'name' => 'Scheduler Pending 2',
            'email' => 'scheduler.pending2@example.com',
            'password' => Hash::make('password'),
            'role' => 'scheduler',
            'status' => 'pending',
            'last_login_at' => null,
        ]);
        // Insert 2 declined schedulers
        User::create([
            'name' => 'Scheduler Declined 1',
            'email' => 'scheduler.declined1@example.com',
            'password' => Hash::make('password'),
            'role' => 'scheduler',
            'status' => 'declined',
            'last_login_at' => null,
        ]);
        User::create([
            'name' => 'Scheduler Declined 2',
            'email' => 'scheduler.declined2@example.com',
            'password' => Hash::make('password'),
            'role' => 'scheduler',
            'status' => 'declined',
            'last_login_at' => null,
        ]);
    }
}
