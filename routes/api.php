<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;


 

Route::post ('create',[UserController::class, 'createUser']);

Route::get ('getUsers',[UserController::class, 'getAllUsers']);
