<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB; // <-- Add this

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            ['subject_code' => 'CS101', 'subject_name' => 'Introduction to Programming', 'created_at' => now(), 'updated_at' => now()],
            ['subject_code' => 'MATH201', 'subject_name' => 'Calculus II', 'created_at' => now(), 'updated_at' => now()],
            ['subject_code' => 'ENG102', 'subject_name' => 'English Composition', 'created_at' => now(), 'updated_at' => now()],
            ['subject_code' => 'PHY301', 'subject_name' => 'Modern Physics', 'created_at' => now(), 'updated_at' => now()],
            ['subject_code' => 'BIO150', 'subject_name' => 'Biology Fundamentals', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
