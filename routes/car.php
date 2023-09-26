<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;

Route::group(['prefix' => 'car'], function(){
    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::get('/', [CarController::class , 'index']);
        Route::post('/create', [CarController::class , 'create']);
    });
    Route::get('/body-types', [CarController::class , 'getCarBodyTypes']);
    Route::get('/loading-types', [CarController::class , 'getCarLoadingTypes']);
});
