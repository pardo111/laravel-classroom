<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'lastname',
        'born_date',
        'state'
    ];
}
