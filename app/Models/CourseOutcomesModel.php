<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOutcomesModel extends Model
{
    use HasFactory;
    protected $table = "course_outcomes";
    protected $fillable = array(
        'outcomeId',
        'outcomeTitle',
        'objDesc',
        'objId',
        'added_by',
        'created_at',
        'updated_at',
    );
}
