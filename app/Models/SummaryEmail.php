<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryEmail extends Model
{
    use HasFactory;

    // Explicit table name
    protected $table = 'grades_email';

    // these are the properties of a enrollment
    protected $fillable = [
        'student_id',
        'year_sem',
        'subject_count',
        'subject_with_grades',
        'average_grades',
        'sent',
    ];
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id'); ; // 'student_id' is the FK in enrollments table
    }
}
