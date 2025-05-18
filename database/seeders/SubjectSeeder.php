<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subjects')->delete();
        DB::statement('ALTER TABLE subjects AUTO_INCREMENT = 1');
        DB::table('subjects')->insert([
            ['name' => 'Mathematics', 'code' => 'MATH101', 'description' => 'Basic Mathematics'],
            ['name' => 'English', 'code' => 'ENG101', 'description' => 'English Language'],
            ['name' => 'Science', 'code' => 'SCI101', 'description' => 'General Science'],
            ['name' => 'History', 'code' => 'HIST101', 'description' => 'World History'],
            ['name' => 'Computer Science', 'code' => 'CS101', 'description' => 'Intro to Computer Science'],
        ]);
    }
}
