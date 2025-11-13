<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = \App\Models\Student::class;

    public function definition(): array
    {
        $genders = ['Male', 'Female', 'Other'];

        return [
            'student_id' => $this->faker->unique()->numerify('2025-####'),
            'full_name' => $this->faker->name(),
            'date_of_birth' => $this->faker->date('Y-m-d', '2006-01-01'), // adjust age as needed
            'gender' => $this->faker->randomElement($genders),
            'email' => $this->faker->unique()->safeEmail(),
            'course_program' => $this->faker->randomElement([
                'BS Information Technology', 
                'BS Computer Science', 
                'BS Electronics Engineering',
                'BS Information Systems'
            ]),
            'year_level' => $this->faker->randomElement(['1st Year','2nd Year','3rd Year','4th Year']),
        ];
    }
}
