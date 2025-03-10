<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskComments extends Model
{
    protected $fillable = [
        'comment',
        'task_id',
        'user_id'
    ];


}
