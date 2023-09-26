<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;

Route::group(['prefix' => 'chat'], function(){
    Route::post('/', [MessageController::class , 'sendMessage']);
    Route::get('/{senderId}', [MessageController::class , 'index']);
    Route::get('/show/{senderId}/{receiverId}', [MessageController::class , 'show']);
});
