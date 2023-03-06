<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectivesBreakdownModel extends Model
{
    use HasFactory;
    protected $table = "objectives_breakdown";
    protected $fillable = array('obId', 'objId', 'quiz','assignment','presentation','project', 'added_by','created_at', 'updated_at');
}
