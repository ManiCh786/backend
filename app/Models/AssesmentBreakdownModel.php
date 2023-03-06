<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssesmentBreakdownModel extends Model
{
    use HasFactory;
    protected $table = "assessment_breakdown";
    protected $fillable = array(
        'asBreaId',
        'ploId',
        'objective',
        'assessmenttype',
        'btLevel',
        'Qno',
        'added_by',
        'created_at',
        'updated_at',
    );
}
