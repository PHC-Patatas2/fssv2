<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rooms')->delete();
        DB::statement('ALTER TABLE rooms AUTO_INCREMENT = 1');
        DB::table('rooms')->insert([
            ['name' => 'Room 101', 'capacity' => 40, 'status' => 'available'],
            ['name' => 'Room 102', 'capacity' => 35, 'status' => 'available'],
            ['name' => 'Room 201', 'capacity' => 50, 'status' => 'unavailable'],
            ['name' => 'Lab 1', 'capacity' => 30, 'status' => 'available'],
            ['name' => 'Lab 2', 'capacity' => 25, 'status' => 'available'],
        ]);
    }
}
