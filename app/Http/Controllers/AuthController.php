<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;

class AuthController extends Controller
{
    // 🔹 Registrar un usuario
    public function register(Request $request)
    {
        $user  =   UserController::createUser($request);

        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user;
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

     public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email  ',
            'password' => 'required',
        ]);

       try {
         $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
       } catch (\Throwable $th) {
        return response()->json(["error"=>$th]);
       }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
    
        return response()->json(['message' => 'Successfully logged out from all devices']);
    }


}
