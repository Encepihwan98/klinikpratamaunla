<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleWithRoleController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::post('/v1/login', [AuthController::class, 'login']);

Route::prefix('v1')->group(function () {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        // Route::post('register', 'AuthController@register');
        // Login User
        Route::post('login', [AuthController::class, 'login']);

        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('user', [AuthController::class, 'user']);
            Route::post('logout', [AuthController::class, 'logout']);

            Route::apiResource('roles', RoleController::class);
            Route::apiResource('users', UserController::class);
            Route::apiResource('modules', ModuleController::class);
            Route::apiResource('daftar-agama', AgamaController::class);
            Route::apiResource('r-modules', ModuleWithRoleController::class);
            Route::post('my-modules', [ModuleController::class, 'myModule']);

            Route::post('users/active/{id}', [UserController::class, 'active']);
            Route::post('modules/active/{id}', [ModuleController::class, 'active']);
        });
});
