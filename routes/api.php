<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


 
Route::post('/register',[UserController::class , 'createUser']);
Route::get('/getAll',[UserController::class , 'getAll']);
Route::get('/getBy',[UserController::class , 'getBy']);