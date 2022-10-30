<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesModel extends Model
{
    use HasFactory;
    protected $table = "courses";
    protected $fillable = array(
        'courseId',
        'courseName',
        'courseCode',
        'courseCrHr',
        'courseDesc',
        'created_at',
        'updated_at',
    );
}
