<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\Tools;
use App\Http\Helpers\UsersTools;
/*


*/



class UserController extends Controller
{

    public static function createUser(Request $request)
    {
        try {
        $data_cleaned = Tools::cleanData($request, [
            'name',
            'lastname',
            'email',
            'password',
            'born_date',
            'state',
            'rol',
        ]);
        $validate = UsersTools::ValidateData($data_cleaned);
        $data_cleaned['password'] = Hash::make($data_cleaned['password']);
        $data_cleaned['code'] = UsersTools::Code();
      
             return User::create($data_cleaned);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th]);
        }
    }




    public static function getAll()
    {
        $users = User::all();
        return $users ?
            response()->json(['data' => $users], Response::HTTP_OK) :
            response()->json('data not found', Response::HTTP_NOT_FOUND);
    }


    public static function getBy(Request $req)
    {
        $dynamicKey = $req->all();

        if (empty($dynamicKey)) {
            return response()->json(['message' => 'No key provided'], Response::HTTP_BAD_REQUEST);
        }
        $expectedKeys = ['name', 'email', 'state'];
        $invalidKeys = array_diff(array_keys($dynamicKey), $expectedKeys);


        if (!empty($invalidKeys)) {
            return response()->json([
                'message' => 'Invalid keys provided: ' . implode(', ', $invalidKeys)
            ], Response::HTTP_BAD_REQUEST);
        };
        $filteredKey = array_intersect_key($dynamicKey, array_flip($expectedKeys));
        $cacheKey = 'users_' . md5(json_encode($filteredKey));

        $users = cache()->remember($cacheKey, 1, function () use ($filteredKey) {
            $query = User::query();
            foreach ($filteredKey as $key => $value) {
                if ($value !== '') {
                    $query->where($key, 'like', '%' . $value . '%');
                }
            }
            return $query->take(5)->get();
        });

        return $users->isNotEmpty()
            ? response()->json(['data' => $users], Response::HTTP_OK)
            : response()->json(['message' => 'Data not found'], Response::HTTP_NOT_FOUND);
    }

    public static function registrer(Request $req) {}
}
