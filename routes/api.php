<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Management\Project\ManagementProjectController;
use App\Http\Controllers\Api\Management\User\ManagementUserController;
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

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(static function () {

    /**
     * Auth
     */
    Route::prefix('/auth')->group(static function () {
        Route::get('/info', [AuthController::class, 'info']);
    });

    /**
     * Management
     */
    Route::prefix('/management')->group(static function () {

        /**
         * Users
         */
        Route::prefix('/users')->group(static function () {
            Route::get('/', [ManagementUserController::class, 'index']);
            Route::get('/show', [ManagementUserController::class, 'show']);
            Route::post('/', [ManagementUserController::class, 'store']);
            Route::put('/', [ManagementUserController::class, 'update']);
            Route::delete('/', [ManagementUserController::class, 'delete']);
        });

        /**
         * Projects
         */
        Route::prefix('/projects')->group(static function () {
            Route::get('/', [ManagementProjectController::class, 'index']);
            Route::get('/show', [ManagementProjectController::class, 'show']);
            Route::post('/', [ManagementProjectController::class, 'store']);
            Route::put('/', [ManagementProjectController::class, 'update']);
            Route::delete('/', [ManagementProjectController::class, 'delete']);
        });

    });
});
