<?php

use App\Http\Controllers\Api\AccessTokenController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::delete('/auth/access-token/{$token?',[AccessTokenController::class,'destroy']);
Route::apiResource('products',ProductController::class);
Route::post('auth/access-token',[AccessTokenController::class,'store'])
->middleware('guest:sanctum');

Route::get('delivery/{deliver}/',[DeliveryController::class,'show']);

Route::put('delivery/{deliver}',[DeliveryController::class,'update']);
