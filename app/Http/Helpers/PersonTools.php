<?php

 namespace App\Http\Helpers;
 use Illuminate\Support\Facades\Validator;

class PersonTools{

    public static function ValidateData(array $res){
        $validator = Validator::make($res, [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'born_date' => 'date',
            'state' => 'required|string',
            'user_id'=>'required'
        ]);

        return !$validator->fails(); 
    }


}
 