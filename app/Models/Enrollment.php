<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    // these are the properties of a enrollment
    protected $fillable = [
        'id',
        'student_id',
        'subject_code',
        'year_sem',
        'grade',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id'); ; // 'student_id' is the FK in enrollments table
    }
}
