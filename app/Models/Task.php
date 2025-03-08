<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subject;

class Task extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'subject_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'id');
    }
}
