<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Validator;
use  App\Models\User;


class UsersTools
{

    public static function ValidateData(  $res)
    {
        $validator = Validator::make($res, [
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'born_date' => 'required|date_format:Y-m-d',
            'password'=>'required|confirmed|min:8|max:40',
            'email'=>'required|email|unique:users,email'
        ]); 

        return $validator->fails() ?   $validator->errors(): true;
    }

    public static function Code (){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()`~';

 
        do {
             $code = substr(str_shuffle($caracteres), 0, 15);
    
             $code = substr_replace($code, (string) mt_rand(1, 9), mt_rand(0, 14), 1);
    
             $exist = User::where('code', $code)->exists();
    
        } while ($exist);  
        return $code;

    }
}
