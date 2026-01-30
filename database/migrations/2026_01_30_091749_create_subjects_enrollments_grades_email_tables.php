<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -------------------
        // Subjects Table
        // -------------------
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_code', 20)->index();
            $table->string('subject_name', 100);
            $table->timestamps();
        });

        // -------------------
        // Enrollments Table
        // -------------------
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->constrained('students')
                  ->cascadeOnDelete()
                  ->comment('FK to students')
                  ->index()
                  ->name('enrollments_student_fk'); // explicit FK name
            $table->string('subject_code', 20)->index();
            $table->string('year_sem', 20)->index();
            $table->decimal('grade', 5, 2)->nullable();
            $table->timestamps();

            // prevent duplicate enrollment for same student/subject/year
            $table->unique(['student_id', 'subject_code', 'year_sem'], 'enrollments_unique');
        });

        // -------------------
        // Grades Email Table
        // -------------------
        Schema::create('grades_email', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->constrained('students')
                  ->cascadeOnDelete()
                  ->comment('FK to students')
                  ->index()
                  ->name('grades_email_student_fk'); // explicit FK name
            $table->string('year_sem', 20)->index();
            $table->tinyInteger('subject_count')->unsigned();
            $table->tinyInteger('subject_with_grades')->unsigned();
            $table->decimal('average_grades', 5, 2)->nullable();
            $table->boolean('sent')->default(false);
            $table->timestamps();

            // ensure one record per student per semester
            $table->unique(['student_id', 'year_sem'], 'grades_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades_email');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('subjects');
    }
};
