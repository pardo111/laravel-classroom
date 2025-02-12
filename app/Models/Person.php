<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
   
    protected $table='person';
    protected $fillable  = [
        'name',
        'lastname',
        'born_date',
        'state',
        'user_id'
    ];
}
