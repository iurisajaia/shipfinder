<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CargoController;

Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::group(['prefix' => 'cargo'], function(){
            Route::post('/my', [CargoController::class , 'getMyCargos']);
            Route::post('/all', [CargoController::class , 'index']);
            Route::post('/', [CargoController::class , 'create']);
            Route::get('/package-types', [CargoController::class , 'getPackageTypes']);
            Route::get('/contacts', [CargoController::class , 'getUserContacts']);
            Route::get('/danger-statuses', [CargoController::class , 'getDangerStatuses']);
            Route::group(['prefix' => 'bid'], function() {
                Route::post('/response', [CargoController::class, 'responseBid']);
                Route::post('/create', [CargoController::class, 'createBid']);
            });
        });
    });
});
