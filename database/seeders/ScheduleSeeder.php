<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('schedules')->insert([
            [
                'type' => 'normal',
                'subject_id' => 1,
                'teacher_id' => 1,
                'room_id' => 1,
                'day' => 'Monday',
                'start_time' => '08:00:00',
                'end_time' => '09:00:00',
                'created_by' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'normal',
                'subject_id' => 2,
                'teacher_id' => 2,
                'room_id' => 2,
                'day' => 'Tuesday',
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
                'created_by' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
