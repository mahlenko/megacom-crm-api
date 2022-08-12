<?php

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

Route::prefix('v1')->group(function() {
    // Authorize access
    Route::middleware('auth:sanctum')->group(function() {
        // пользователи
        Route::prefix('users')->group(function() {
            Route::get('/', [\App\Http\Controllers\Api\V1\Users\Index::class, 'index']);
            Route::get('/me', [\App\Http\Controllers\Api\V1\Users\GetMe::class, 'index']);
            Route::get('/{id}', [\App\Http\Controllers\Api\V1\Users\Get::class, 'index'])->whereNumber('id');
            Route::get('/{id}/tokens', [\App\Http\Controllers\Api\V1\Users\Token\Get::class, 'index'])->whereNumber('id');
            Route::delete('/{id}', [\App\Http\Controllers\Api\V1\Users\Delete::class, 'index'])->whereNumber('id');

            Route::prefix('tokens')->group(function() {
                Route::get('/', [\App\Http\Controllers\Api\V1\Users\Token\Index::class, 'index']);
            });
        });

        // задачи
        Route::prefix('tasks')->group(function() {
            // ...
            Route::post('/', [\App\Http\Controllers\Api\V1\Tasks\Create::class, 'index']);
        });
    });

    // Guest access
    Route::prefix('users')->group(function() {
        Route::post('/', [\App\Http\Controllers\Api\V1\Users\Post::class, 'index']);

        Route::prefix('tokens')->group(function(){
            Route::post('/', [\App\Http\Controllers\Api\V1\Users\Token\Post::class, 'index']);
        });
    });

    // Checkout ping
    Route::prefix('ping')->group(function() {
        Route::get('external-db', [\App\Http\Controllers\Api\V1\Ping\External::class, 'index']);
    });
});

