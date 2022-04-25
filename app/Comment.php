<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'project_id', 'user_id', 'task_id', 'comment', 'created_at', 'updated_at'
    ];


    function user() {
        return $this->hasOne(User::class);
    }

 

}
