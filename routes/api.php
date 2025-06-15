<?php


use App\Http\Controllers\API\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController as PostController;
use App\Http\Controllers\API\V1\PostController as PostControllerV1;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/v1/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/v1/logout', [AuthController::class, 'logout']);


// Route::apiResource('/posts', PostController::class);


Route::middleware(['auth.sanctum', 'check.token.expiry'])->prefix('v1')->group(function (){

      Route::apiResource('/post', PostControllerV1::class);

});



Route::prefix('v2')->group(function (){

      Route::apiResource('/posts', PostController::class);

});
