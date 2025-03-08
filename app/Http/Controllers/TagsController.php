<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;

class TagsController extends Controller
{
    public static function createTag($name, $state){
        return Tags::create([$name, $state]);
    }

    public static function dropTag($name){
        return Tags::where('tags',$name)->update(['state'=>false]);
    }
}
