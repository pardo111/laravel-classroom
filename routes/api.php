<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubjectController;





Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

    //CREATE
    Route::post('/createSubject', [SubjectController::class, 'createSubject']);
    Route::post('/photo', [UserController::class, 'uploadPhoto']);
    Route::post('/uploadTask', [SubjectController::class, 'uploadTask']);
    
    //READ
    Route::get('/getAll', [UserController::class, 'getAll']);
    Route::post('/getTask', [SubjectController::class, 'getData']);
    Route::post('/getAllSubject', [SubjectController::class, 'getAll']);
    Route::post('/getBySubject', [SubjectController::class, 'getBy']);
    Route::post('/getBy', [UserController::class, 'getBy']);
    
    //UPDATE
    Route::post('/visibilitySubject', [SubjectController::class, 'visibilitySubject']);
    Route::post('/updateUser', [UserController::class, 'update']);

});

