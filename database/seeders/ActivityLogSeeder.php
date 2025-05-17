<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('activity_logs')->insert([
            [
                'username' => 'Test Admin',
                'action' => 'created_schedule',
                'entity_type' => 'schedule',
                'entity_id' => 1,
                'description' => 'Created a new schedule for Mathematics.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Test Scheduler',
                'action' => 'updated_schedule',
                'entity_type' => 'schedule',
                'entity_id' => 2,
                'description' => 'Updated schedule for English.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
