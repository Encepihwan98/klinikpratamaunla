<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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


Route::apiResource('/v1/roles', RoleController::class);
Route::apiResource('/v1/users', UserController::class);
Route::post('/v1/users/active/{id}', [UserController::class, 'active']);
// Route::post('/v1/login', [AuthController::class, 'login']);


// Route::group([

//     'middleware' => 'api',
//     'prefix' => 'v1'

// ], function ($router) {

//     Route::post('login', [AuthController::class, 'login']);
//     // Route::post('logout', 'AuthController@logout');
//     // Route::post('refresh', 'AuthController@refresh');
//     // Route::post('me', 'AuthController@me');

// });


Route::prefix('v1')->group(function () {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        // Route::post('register', 'AuthController@register');
        // Login User
        Route::post('login', [AuthController::class, 'login']);

        // Refresh the JWT Token
        Route::get('refresh', [AuthController::class, 'refresh']);

        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user', [AuthController::class, 'user']);
            // Logout user from application
            Route::post('logout', [AuthController::class, 'logout']);
        });
});
