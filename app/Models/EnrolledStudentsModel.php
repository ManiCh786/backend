<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledStudentsModel extends Model
{
    use HasFactory;
    protected $table = "enrolledstudents";
    protected $fillable = array(
        'eId',
        'userId',
        'courseId',
        'session',
        'enrolled_by',
        'startDate',
        'completionDate',
        'created_at',
        'updated_at',
    );
}
