<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\PaymentMethodsController;



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
    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::get('/', [CarController::class , 'index']);
        Route::post('/create', [CarController::class , 'create']);
    });
    Route::get('/body-types', [CarController::class , 'getCarBodyTypes']);
    Route::get('/trailer-types', [CarController::class , 'getCarTrailerTypes']);
    Route::get('/loading-types', [CarController::class , 'getCarLoadingTypes']);
});

Route::group(['prefix' => 'payment-methods'], function(){
    Route::get('/', [PaymentMethodsController::class , 'index']);
});

Route::group(['prefix' => 'country'], function(){
    Route::get('/', [CountryController::class , 'index']);
});

