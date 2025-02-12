<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    
    public function createUser (Request $request){

        $validator =  Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed'
        ]);
        if ($validator->fails() ) {    
            return response()->json([
                "error" => "Error en registrar",
                "errores" => $validator->errors()
            ], 400);
        }

        try {
            $user =   User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),           
            ]
            
        );
            
            $request->user_id= $user->id;
            $person = PersonController::createPerson($request);

            if (!$person['success']) {
                return response()->json([
                    'error' => 'Error en registrar persona',
                    'errores' => $person['message']
                ], 400);
            }
    
            return response()->json([
                'success' => true,
                'user' => $user,
                'person' => $person['person']
            ], Response::HTTP_CREATED);
    
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error creando usuario',
                'message' => $th->getMessage()
            ], 500);
        }
        


        
        
         
        
           
        return response($user , Response::HTTP_CREATED) ;
         

      
 
       


    }

    public static function getAllUsers(){
        $users = User::with('person')->get();
        return $users;
    }

}
