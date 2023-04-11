<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\v1\AddressApiController;
use App\Http\Controllers\Api\v1\CityApiController;
use App\Http\Controllers\Api\v1\CustomerApiController;
use App\Http\Controllers\Api\v1\StateApiController;
use App\Http\Controllers\Api\v1\UserApiController;
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
        Route::group(['prefix' => 'customer'], function() {
            Route::post('/', [CustomerApiController::class, 'store'])
                ->name('customer.store');
            Route::put('/{id}', [CustomerApiController::class, 'update'])
                ->name('customer.update');
            Route::delete('/{id}', [CustomerApiController::class, 'destroy'])
                ->name('customer.destroy');
            Route::get('/', [CustomerApiController::class, 'index'])
                ->name('customer.index');
            Route::get('/{id}', [CustomerApiController::class, 'show'])
                ->name('customer.show');
        });

        Route::group(['prefix' => 'city'], function() {
            Route::post('/', [CityApiController::class, 'store'])
                ->name('city.store');
            Route::put('/{id}', [CityApiController::class, 'update'])
                ->name('city.update');
            Route::delete('/{id}', [CityApiController::class, 'destroy'])
                ->name('city.destroy');
            Route::get('/', [CityApiController::class, 'index'])
                ->name('city.index');
            Route::get('/{id}', [CityApiController::class, 'show'])
                ->name('city.show');
        });

        Route::group(['prefix' => 'state'], function() {
            Route::post('/', [StateApiController::class, 'store'])
                ->name('state.store');
            Route::put('/{id}', [StateApiController::class, 'update'])
                ->name('state.update');
            Route::delete('/{id}', [StateApiController::class, 'destroy'])
                ->name('state.destroy');
            Route::get('/', [StateApiController::class, 'index'])
                ->name('state.index');
            Route::get('/{id}', [StateApiController::class, 'show'])
                ->name('state.show');
        });

        Route::group(['prefix' => 'address'], function() {
            Route::post('/', [AddressApiController::class, 'store'])
                ->name('address.store');
            Route::put('/{id}', [AddressApiController::class, 'update'])
                ->name('address.update');
            Route::delete('/{id}', [AddressApiController::class, 'destroy'])
                ->name('address.destroy');
            Route::get('/', [AddressApiController::class, 'index'])
                ->name('address.index');
            Route::get('/{id}', [AddressApiController::class, 'show'])
                ->name('address.show');
        });

        Route::group(['prefix' => 'user'], function() {
            Route::put('/{id}', [UserApiController::class, 'update'])
                ->name('user.update');
            Route::delete('/{id}', [UserApiController::class, 'destroy'])
                ->name('user.destroy');
            Route::get('/', [UserApiController::class, 'index'])
                ->name('user.index');
            Route::get('/{id}', [UserApiController::class, 'show'])
                ->name('user.show');
        });
    });

    Route::group(['prefix' => 'user'], function() {
        Route::post('/', [UserApiController::class, 'store'])
            ->name('user.store');
    });

    Route::group(['prefix' => 'auth'], function() {
        Route::get('login', [AuthController::class, 'loginUser'])
            ->name('auth.show');
    });
});

Route::get('unauthorized', function () {
    return response()->json(['error' => 'Unauthorized.'], 401);
})->name('unauthorized');

Route::any('{segment}', function () {
    return response()->json(['error' => 'Bad request.'], 400);
})->where('segment', '.*');
