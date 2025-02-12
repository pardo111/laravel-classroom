<?php

namespace App\Http\Helpers; 

use Illuminate\Http\Request;
use Illuminate\Support\Collection; 


class Tools {

    public static function  cleanData(Request $data, array $required) {
 
        return collect($required)->mapWithKeys(function ($item) use ($data) {
            return [$item => trim($data->input($item, ''))];
        })->toArray();
    }

}

?>
