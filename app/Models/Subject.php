<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    // these are the properties of a subject
    protected $fillable = [
        'subject_code',
        'subject_name',
    ];}
