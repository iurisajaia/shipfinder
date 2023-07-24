<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\CarController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'user'], function () {

    Route::get('/roles', [UserController::class, 'roles']);

    Route::post('/login', [UserController::class, 'login']);
    Route::post('/verify', [UserController::class, 'verify']);
    Route::post('/create', [UserController::class, 'create']);
    Route::post('/get-login-code', [UserController::class, 'getLoginCode']);

    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::put('/update', [UserController::class, 'update']);
        Route::get('/', [UserController::class , 'currentUser']);
        Route::delete('/delete/{id}', [UserController::class, 'delete']);

        Route::group(['prefix' => 'driver'], function(){
            Route::post('/create', [DriverController::class , 'create']);
        });
    });
});

Route::group(['prefix' => 'car'], function(){
    Route::get('/body-types', [CarController::class , 'getCarBodyTypes']);
    Route::get('/trailer-types', [CarController::class , 'getCarTrailerTypes']);
    Route::get('/loading-types', [CarController::class , 'getCarLoadingTypes']);
});

