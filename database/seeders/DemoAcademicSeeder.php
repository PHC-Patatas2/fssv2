<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Major;
use App\Models\Year;
use App\Models\Semester;
use App\Models\Section;
use App\Models\TeacherQualification;

class DemoAcademicSeeder extends Seeder
{
    public function run(): void
    {
        // Courses
        $bsit = Course::create(['name' => 'Bachelor of Science in Information Technology', 'acronym' => 'BSIT']);
        $bscs = Course::create(['name' => 'Bachelor of Science in Computer Science', 'acronym' => 'BSCS']);
        $bsba = Course::create(['name' => 'Bachelor of Science in Business Administration', 'acronym' => 'BSBA']);

        // Majors
        $majorNet = Major::create(['name' => 'Networking', 'course_id' => $bsit->id]);
        $majorSE = Major::create(['name' => 'Software Engineering', 'course_id' => $bsit->id]);
        $majorFin = Major::create(['name' => 'Financial Management', 'course_id' => $bsba->id]);

        // Years
        $year1 = Year::create(['name' => '1st Year', 'year_level' => 1]);
        $year2 = Year::create(['name' => '2nd Year', 'year_level' => 2]);
        $year3 = Year::create(['name' => '3rd Year', 'year_level' => 3]);
        $year4 = Year::create(['name' => '4th Year', 'year_level' => 4]);

        // Semesters
        $sem1 = Semester::create(['name' => '1st Semester']);
        $sem2 = Semester::create(['name' => '2nd Semester']);

        // Sections
        Section::create(['name' => 'A', 'year_id' => $year1->id, 'major_id' => $majorNet->id, 'course_id' => $bsit->id, 'semester_id' => $sem1->id]);
        Section::create(['name' => 'B', 'year_id' => $year2->id, 'major_id' => $majorSE->id, 'course_id' => $bsit->id, 'semester_id' => $sem2->id]);
        Section::create(['name' => 'C', 'year_id' => $year3->id, 'major_id' => null, 'course_id' => $bscs->id, 'semester_id' => $sem1->id]);

        // Teacher Qualifications
        TeacherQualification::create(['name' => 'MS in IT', 'description' => 'Master of Science in Information Technology']);
        TeacherQualification::create(['name' => 'PhD in CS', 'description' => 'Doctor of Philosophy in Computer Science']);
        TeacherQualification::create(['name' => 'MBA', 'description' => 'Master of Business Administration']);
    }
}
