<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LangSwitcher;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::group(['middleware' => ['verifyToken', 'LangSwitcher']], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::apiResource('categories', CategoryController::class);
    });


    /*
        If I want to use Sanctum to generate token and save it in database
        /*
        Route::group(['middleware' => ['auth:sanctum']], function() {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);
        });
    */

    // Crud operations for categories
    // Route::apiResource('categories', CategoryController::class);
