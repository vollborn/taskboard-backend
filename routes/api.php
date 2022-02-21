<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Management\Permission\ManagementPermissionController;
use App\Http\Controllers\Api\Management\Project\ManagementProjectController;
use App\Http\Controllers\Api\Management\Project\Sync\ManagementProjectSyncController;
use App\Http\Controllers\Api\Management\User\ManagementUserController;
use App\Http\Controllers\Api\Management\User\Sync\ManagementUserSyncController;
use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\Task\TaskController;
use Illuminate\Support\Facades\Route;

/**
 * Auth
 */
Route::prefix('/auth')->group(static function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(static function () {

    /**
     * Auth
     */
    Route::prefix('/auth')->group(static function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/', [AuthController::class, 'show']);
        Route::put('/', [AuthController::class, 'update']);
    });

    /**
     * Management
     */
    Route::prefix('/management')->group(static function () {

        /**
         * Management Permissions
         */
        Route::prefix('/permissions')->group(static function () {
            Route::get('/', [ManagementPermissionController::class, 'index']);
        });

        /**
         * Management Users
         */
        Route::prefix('/users')->group(static function () {
            Route::get('/', [ManagementUserController::class, 'index']);
            Route::get('/show', [ManagementUserController::class, 'show']);
            Route::post('/', [ManagementUserController::class, 'store']);
            Route::put('/', [ManagementUserController::class, 'update']);
            Route::delete('/', [ManagementUserController::class, 'delete']);

            Route::put('/projects', [ManagementUserSyncController::class, 'projects']);
            Route::put('/permissions', [ManagementUserSyncController::class, 'permissions']);
        });

        /**
         * Management Projects
         */
        Route::prefix('/projects')->group(static function () {
            Route::get('/', [ManagementProjectController::class, 'index']);
            Route::get('/show', [ManagementProjectController::class, 'show']);
            Route::post('/', [ManagementProjectController::class, 'store']);
            Route::put('/', [ManagementProjectController::class, 'update']);
            Route::delete('/', [ManagementProjectController::class, 'delete']);

            Route::put('/users', [ManagementProjectSyncController::class, 'users']);
        });

    });

    /**
     * Projects
     */
    Route::prefix('/projects')->group(static function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::get('/show', [ProjectController::class, 'show']);
    });

    /**
     * Tasks
     */
    Route::prefix('/tasks')->group(static function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::get('/show', [TaskController::class, 'show']);
        Route::post('/', [TaskController::class, 'store']);
        Route::put('/', [TaskController::class, 'update']);
        Route::put('/status', [TaskController::class, 'updateStatus']);
        Route::delete('/', [TaskController::class, 'delete']);
    });

});
