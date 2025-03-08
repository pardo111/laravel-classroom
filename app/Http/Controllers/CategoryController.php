<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public static function createCategory($name, $state){
        return Category::create([$name,$state]);
    }
    public static function dropCategory($name){
        return Category::where('category',$name)->update(['state'=>false]);
    }
}
