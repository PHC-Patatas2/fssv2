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

        $courses = DB::table('courses')->get();
        $years = DB::table('years')->get();
        $semesters = DB::table('semesters')->get();
        $majors = DB::table('majors')->get();

        $demoSubjects = [
            [
                'name' => 'Mathematics',
                'code' => 'MATH101',
                'description' => 'Basic Mathematics',
                'type' => 'major',
            ],
            [
                'name' => 'English',
                'code' => 'ENG101',
                'description' => 'English Language',
                'type' => 'major',
            ],
            [
                'name' => 'Science',
                'code' => 'SCI101',
                'description' => 'General Science',
                'type' => 'minor',
            ],
            [
                'name' => 'History',
                'code' => 'HIST101',
                'description' => 'World History',
                'type' => 'minor',
            ],
            [
                'name' => 'Computer Science',
                'code' => 'CS101',
                'description' => 'Intro to Computer Science',
                'type' => 'major',
            ],
        ];

        $subjectRows = [];
        foreach ($courses as $course) {
            foreach ($years as $year) {
                foreach ($semesters as $semester) {
                    foreach ($demoSubjects as $subject) {
                        // Generate a unique code by appending course, year, and semester IDs
                        $uniqueCode = $subject['code'] . '-' . $course->id . '-' . $year->id . '-' . $semester->id;
                        $subjectRows[] = [
                            'name' => $subject['name'],
                            'code' => $uniqueCode,
                            'description' => $subject['description'],
                            'course_id' => $course->id,
                            'year_id' => $year->id,
                            'semester_id' => $semester->id,
                            'type' => $subject['type'],
                            'major_id' => null, // Optionally assign a major if needed
                        ];
                    }
                }
            }
        }
        DB::table('subjects')->insert($subjectRows);
    }
}
