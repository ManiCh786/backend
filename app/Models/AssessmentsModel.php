<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentsModel extends Model
{
    use HasFactory;
    protected $table = "assessments";
    protected $fillable = array(
        'asId',
        'outlineId',
        'assessmentType',
        'assFileName',
        'ass_added_by',
        'senttoHod',
        'created_at',
        'updated_at',
    );
}
