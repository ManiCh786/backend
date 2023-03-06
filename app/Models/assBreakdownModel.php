<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assBreakdownModel extends Model
{
    use HasFactory;
    
    protected $table = "assessment_breakdown_structure";
    protected $fillable = array(
        'asBreaId',
        'ploId',
        'objective',
        'assessmenttype',
        'btLevel',
        'Qno',
        'added_by'
    );
}
