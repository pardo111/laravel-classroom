<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Tags;
use App\Models\Category;


class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */

    use HasFactory, Notifiable, HasApiTokens;
    protected $fillable = [
        'name',
        'code',
        'owner',
        'category',
        'tags',
        'description',
        'duration',
        'price',
        'next_course',
        'last_course'
    ];

    public function Tags()
    {
        return $this->belongsToMany(Tags::class, 'subject_tags', 'tags_id', 'subject_id');
    }
    public function Category()
    {
        return $this->belongsToMany(Category::class, 'subject_category', 'category_id', 'subject_id');
    }
}
