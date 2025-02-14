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
            'born_date' => 'date',
            'password'=>'required|confirmed|min:8|max:40',
            'email'=>'required|email|unique:users,email'
        ]); 

        return $validator->fails() ?   $validator->errors(): true;
    }

    public static function Code (){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()`~';

        $code= substr(str_shuffle($caracteres), 0, 15) ; 

        $exist= 'l;';
        while($exist){
            $exist = User::where('code',$code)->exists();

            if(!$exist){
                $code=substr_replace($code, (string) mt_rand(1, 9), mt_rand(1, 15), 1);
            }
        }
        return $code;

    }
}
