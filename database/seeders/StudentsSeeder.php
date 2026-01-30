<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB; // <-- Add this

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'student_id' => 'STU001',
                'full_name' => 'Marc King',
                'date_of_birth' => '2003-05-15',
                'gender' => 'Male',
                'email' => 'marclawrenceking@gmail.com',
                'course_program' => 'Information Technology',
                'year_level' => '4th year',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'STU002',
                'full_name' => 'Maria Garcia',
                'date_of_birth' => '2002-08-22',
                'gender' => 'Female',
                'email' => 'maria.garcia@university.edu',
                'course_program' => 'Business Administration',
                'year_level' => '1st year',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'STU003',
                'full_name' => 'David Chen',
                'date_of_birth' => '2004-01-30',
                'gender' => 'Male',
                'email' => 'david.chen@university.edu',
                'course_program' => 'Electrical Engineering',
                'year_level' => '1st year',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'STU004',
                'full_name' => 'Sarah Williams',
                'date_of_birth' => '2001-11-05',
                'gender' => 'Female',
                'email' => 'sarah.williams@university.edu',
                'course_program' => 'Psychology',
                'year_level' => '1st year',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'STU005',
                'full_name' => 'Jordan Lee',
                'date_of_birth' => '2003-03-18',
                'gender' => 'Other',
                'email' => 'jordan.lee@university.edu',
                'course_program' => 'Biology',
                'year_level' => '1st year',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
