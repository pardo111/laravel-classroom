<?php

namespace App\Models;

use App\Models\Subject;

 

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category',
        'state'
    ];
    public function Subject() 
    {
        return $this->belongsToMany(Subject::class,   'subject_category' ,'category_id' ,  'subject_id');
    }
}
