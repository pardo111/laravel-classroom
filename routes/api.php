<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubjectController;




 
Route::post('/register',[AuthController::class , 'register']);
Route::get('/login',[AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/getAll',[UserController::class , 'getAll']);
    Route::get('/getBy',[UserController::class , 'getBy']);
});
Route::post('/uploadTask',[SubjectController::class,'uploadTask']);
Route::post('/getTask',[SubjectController::class,'getData']);
Route::post('/createSubject', [SubjectController::class, 'createSubject']);

