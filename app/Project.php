<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'project_file'
    ];
}
