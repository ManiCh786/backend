<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseInstructorsModel extends Model
{
    use HasFactory;
    protected $table = "course_instructors";
    protected $fillable = array(
        'ciId',
        'courseId',
        'instructor_userId',
        'assigned_by',
        'semester',
        'department',
        'session',
        'created_at',
        'updated_at',
    );
}
