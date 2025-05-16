<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Helpers\Tools;
use App\Http\Helpers\UsersTools;
/*
clase UserController 
 
*/



class UserController extends Controller
{

    public static function create(Request $request)
    {
        try {
            $data_cleaned = Tools::cleanData($request, [
                'name',
                'lastname',
                'email',
                'password',
                'born_date',
                'rol',
            ]);
    
            $validationErrors = UsersTools::ValidateData($data_cleaned);
            if ($validationErrors) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validationErrors
                ], 422);
            }
    
            $data_cleaned['code'] = UsersTools::Code();
    
            return User::create($data_cleaned);
    
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    
    //envia en rango
    public static function getAll(Request $request)
    {
        $users = User::whereBetween('id', $request['range'])->where(['state' => true])->get();
        return $users ?
            response()->json(['data' => $users], Response::HTTP_OK) :
            response()->json('data not found', Response::HTTP_NOT_FOUND);
    }

    //  envia un solo parametro variable
    public static function getBy(Request $request)
    {
        $data = $request->json()->all();
        $key = key($data);
        $user = User::where($key, 'like', '%' . $data[$key] . '%')->where('state', true)->get();
        return response()->json($user, 200);
    }
    //id y params con todos los campos a cambiar 
    public static function update(Request $request)
    {
        User::where('id', $request['id'])->update($request['params']);
        $user = User::where('id', $request['id'])->get();
        return response()->json($user, 200);
    }
    // params id, photo

    public static function uploadPhoto(Request $request)
    {
        try {
            $request->validate([
                'user' => 'required|integer|exists:users,id',
                'photo' => 'required '
            ]);
            $photo = $request['photo'];
            $userId = $request['user'];
            $user = User::where(['id' => $userId])->select('name')->get();
            $userHashed =  hash('sha256', $user[0]['name'] . $userId);
            $profile = 'profile';

            $path = $userHashed . "/" . $profile;
            $upload = FileController::upload($photo, $path);

            return  $upload ? response()->json("archivo guardado con exito ", 200) : response()->json("error al subir el archivo: ", 500);
        } catch (\Throwable $th) {
            return response()->json(["errores: " => $th->getMessage()], 500);
        }
    }
}
