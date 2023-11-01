<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TrailerController;

Route::group(['prefix' => 'trailer'], function(){
    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::get('/', [TrailerController::class , 'index']);
        Route::post('/create', [TrailerController::class , 'create']);
    });
    Route::get('/types', [TrailerController::class , 'getTrailerTypes']);
});
