<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShippingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/calculation',[ShippingController::class, 'calculation']);
    Route::patch('/user/{user}',[ShippingController::class, 'updatePricePerKm']);
});