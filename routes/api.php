<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'v1'], function() {
    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::group(['prefix' => 'user'], function() {
            Route::get('/', function (Request $request) {
                return $request->user();
            });
        });
    });

    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [AuthController::class, 'createUser']);
        Route::get('login', [AuthController::class, 'loginUser']);
    });
});

Route::get('unauthorized', function () {
    return response()->json(['error' => 'Unauthorized.'], 401);
})->name('unauthorized');

Route::any('{segment}', function () {
    return response()->json(['error' => 'Bad request.'], 400);
})->where('segment', '.*');
