<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // these are the properties of a student
    protected $fillable = [
        'student_id',
        'full_name',
        'date_of_birth',
        'gender',
        'email',
        'course_program',
        'year_level',
    ];}
