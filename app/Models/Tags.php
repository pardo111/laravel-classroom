<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{

    protected $fillable = [
        'tags',
        'state'
    ];
         public function Subject() 
        {
            return $this->belongsToMany(Subject::class,   'subject_tags' ,'tags_id' ,  'subject_id');
        }
}
