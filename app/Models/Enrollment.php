<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    // these are the properties of a enrollment
    protected $fillable = [
        'student_id',
        'subject_code',
        'year_sem',
        'grade',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id'); ; // 'student_id' is the FK in enrollments table
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_code', 'subject_code');
    }
}
