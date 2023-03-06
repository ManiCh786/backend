<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentsMarksModel extends Model
{
    use HasFactory;
    protected $table = "assessment_marks";
    protected $fillable = array(
        'as_marks_id',
        'assessment_id',
        'qno',
        'obtmarks',
        'total_marks',
        'student_id',
        'objName',
        'added_by',
        'created_at',
        'updated_at',
    );

}
