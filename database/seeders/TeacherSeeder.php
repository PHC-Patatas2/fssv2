<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('teachers')->insert([
            ['name' => 'Alice Johnson', 'email' => 'alice.johnson@example.com', 'contact' => '09171234567'],
            ['name' => 'Bob Smith', 'email' => 'bob.smith@example.com', 'contact' => '09179876543'],
            ['name' => 'Carol Lee', 'email' => 'carol.lee@example.com', 'contact' => '09172345678'],
        ]);
    }
}
