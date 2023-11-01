<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\PaymentMethodsController;



Route::group(['prefix' => 'payment-methods'], function(){
    Route::get('/', [PaymentMethodsController::class , 'index']);
});
Route::group(['prefix' => 'country'], function(){
    Route::get('/', [CountryController::class , 'index']);
});


