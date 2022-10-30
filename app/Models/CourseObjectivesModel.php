<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseObjectivesModel extends Model
{
    use HasFactory;
    protected $table = "course_objectives";
    protected $fillable = array(
        'objId',
        'objName',
        'objDesc',
        'courseId',
        'added_by',
        'created_at',
        'updated_at',
    );
}
