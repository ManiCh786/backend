<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationModel extends Model
{
    use HasFactory;
    protected $table = "user_registration";
    protected $fillable = array('regId', 'fName', 'lName', 'email', 'phone', 'password', 'created_at', 'updated_at');
}