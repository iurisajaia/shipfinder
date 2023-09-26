<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CargoController;
use App\Http\Controllers\Api\DriverController;

Route::group(['prefix' => 'user'], function () {

    Route::get('/roles', [UserController::class, 'roles']);
    Route::post('/phone', [UserController::class, 'checkUserExistence']);

    Route::post('/login', [UserController::class, 'login']);
    Route::post('/verify', [UserController::class, 'verify']);
    Route::post('/create', [UserController::class, 'create']);
    Route::post('/get-login-code', [UserController::class, 'getLoginCode']);
    Route::post('/forgot-password', [UserController::class, 'forgotPassword']);

    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::put('/update', [UserController::class, 'update']);
        Route::put('/change-password', [UserController::class, 'changePassword']);
        Route::get('/', [UserController::class , 'currentUser']);
        Route::delete('/delete/{id}', [UserController::class, 'delete']);

        Route::group(['prefix' => 'driver'], function(){
            Route::post('/create', [DriverController::class , 'create']);
        });

        Route::group(['prefix' => 'cargo'], function(){
            Route::get('/', [CargoController::class , 'index']);
            Route::post('/', [CargoController::class , 'create']);
            Route::get('/package-types', [CargoController::class , 'getPackageTypes']);
            Route::get('/contacts', [CargoController::class , 'getUserContacts']);
            Route::get('/danger-statuses', [CargoController::class , 'getDangerStatuses']);
        });
    });
});
