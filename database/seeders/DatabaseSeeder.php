<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SubjectSeeder;
use Database\Seeders\TeacherSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\ActivityLogSeeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users for foreign key references
        $admin = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'approved',
        ]);
        $scheduler = User::factory()->create([
            'name' => 'Test Scheduler',
            'email' => 'scheduler@example.com',
            'password' => bcrypt('password'),
            'role' => 'scheduler',
            'status' => 'approved',
        ]);

        // Audit log: user creation
        \App\Models\ActivityLog::create([
            'username' => $admin->name,
            'action' => 'user_created',
            'entity_type' => 'user',
            'entity_id' => $admin->id,
            'description' => 'Admin user created during seeding.'
        ]);
        \App\Models\ActivityLog::create([
            'username' => $scheduler->name,
            'action' => 'user_created',
            'entity_type' => 'user',
            'entity_id' => $scheduler->id,
            'description' => 'Scheduler user created during seeding.'
        ]);

        $this->call([
            SubjectSeeder::class,
            TeacherSeeder::class,
            RoomSeeder::class,
            ScheduleSeeder::class,
            ActivityLogSeeder::class,
        ]);
    }
}
