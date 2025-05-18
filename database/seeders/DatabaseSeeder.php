<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SubjectSeeder;
use Database\Seeders\TeacherSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\ActivityLogSeeder;
use App\Models\User;
use Database\Seeders\DemoAcademicSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users first for foreign key references
        $this->call([
            TestUserSeeder::class,
            SubjectSeeder::class,
            TeacherSeeder::class,
            RoomSeeder::class,
            ScheduleSeeder::class,
            ActivityLogSeeder::class,
            DemoAcademicSeeder::class,
        ]);
    }
}
