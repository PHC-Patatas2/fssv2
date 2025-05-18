<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('schedules')->delete();
        DB::statement('ALTER TABLE schedules AUTO_INCREMENT = 1');

        $subjectIds = DB::table('subjects')->pluck('id')->toArray();
        $teacherIds = DB::table('teachers')->pluck('id')->toArray();
        $roomIds = DB::table('rooms')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();

        // Use the minimum count to avoid out-of-bounds
        $count = min(count($subjectIds), count($teacherIds), count($roomIds), count($userIds), 5);
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $startTimes = ['08:00:00', '09:00:00', '10:00:00', '11:00:00', '13:00:00'];
        $endTimes = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '14:00:00'];

        $schedules = [];
        for ($i = 0; $i < $count; $i++) {
            $schedules[] = [
                'type' => 'normal',
                'subject_id' => $subjectIds[$i],
                'teacher_id' => $teacherIds[$i],
                'room_id' => $roomIds[$i],
                'day' => $days[$i],
                'start_time' => $startTimes[$i],
                'end_time' => $endTimes[$i],
                'created_by' => $userIds[$i],
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if ($count > 0) {
            DB::table('schedules')->insert($schedules);
        }
    }
}
