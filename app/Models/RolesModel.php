<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    use HasFactory;
    protected $table = "roles";
    protected $fillable = array('roleId', 'roleName', 'roleDesc', 'created_at', 'updated_at');
}