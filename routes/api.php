<?php

use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::post('/users', [UserController::class, 'store']);
Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users/resetpass', [UserController::class, 'resetPassword']);
Route::post('/users/updatepass', [UserController::class, 'newPassword']);
Route::middleware('auth:api')->put('/users', [UserController::class, 'update']);
Route::get('/users', [UserController::class, 'viewAll']);
Route::middleware('auth:api')->get('/users/{id}', [UserController::class, 'view']);
Route::middleware('auth:api')->delete('/users/{id}', [UserController::class, 'delete']);
