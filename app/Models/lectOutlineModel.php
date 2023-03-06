<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lectOutlineModel extends Model
{
    use HasFactory;
    protected $table = "lecturesOutline";
    protected $fillable = array(
        'outlineId',
        'lecNo',
        'weekNo',
        'session',
        'subject',
        'fileName',
        'fileName1',
        'fileName2',
        'fileName3',
        'fileName4',
        'btLevel',
        'relatedTopic',
        'courseObj',
        'approved',
        'approved_by',
        'created_at',
        'updated_at',
    );
}
