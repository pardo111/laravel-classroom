<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;



 
Route::post('/register',[AuthController::class , 'register']);
Route::get('/login',[AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/getAll',[UserController::class , 'getAll']);
    Route::get('/getBy',[UserController::class , 'getBy']);
});
