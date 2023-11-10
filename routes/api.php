<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::prefix('auth')->group(function () {
   
});

Route::prefix('auth')->group(function () {
    Route::post('admin-register', [AuthController::class, 'adminRegister']);
    Route::post('register', [AuthController::class, 'userRegister']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group(['middleware' => ['auth:api', 'role:admin|user']], function () {
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

Route::group(['middleware' => ['auth:api', 'role:admin', 'check-user-status']], function () {
});

Route::any(
    '{any}',
    function () {
        return response()->json([
            'status_code' => 404,
            'message' => 'Page Not Found. Check method type Post/Get or URL',
        ], 404);
    }
)->where('any', '.*');