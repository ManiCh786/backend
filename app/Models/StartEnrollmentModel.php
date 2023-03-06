<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartEnrollmentModel extends Model
{
    use HasFactory;
    protected $table = "startenrollment";
    protected $fillable = array('seId', 'session', 'startDate', 'endDate', 'added_by','created_at','updated_at');

}
