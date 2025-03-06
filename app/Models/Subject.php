<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */

    use HasFactory, Notifiable, HasApiTokens;
    protected $fillable = [
        'name',
        'code',
        'owner',
        'description',
        'duration',
        'price',
        'next course',
        'last course'
    ];
}
