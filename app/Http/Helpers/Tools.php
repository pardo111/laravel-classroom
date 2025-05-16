<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;


class Tools
{
    public static function  cleanData(Request $data, array $required)
    {
        $cleanedData = collect($required)->mapWithKeys(function ($item) use ($data) {
             return [$item => trim($data->input($item, ''))];
        })->toArray();
        return $cleanedData; 
    }
}
