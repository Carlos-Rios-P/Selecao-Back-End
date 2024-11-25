<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
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

Route::post('auth', [AuthController::class, 'login']);
Route::delete('logout', [AuthController::class, 'logout']);

Route::prefix('/user')->group(function () {
    Route::post('register', [UserController::class, 'store']);
});

Route::prefix('/comments')->group(function () {
    Route::get('/', [CommentController::class, 'index']);
});

Route::middleware(['jwt'])->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('me', [UserController::class, 'me']);
        Route::post('update/me', [UserController::class, 'updateMe']);
        Route::post('update/{id}', [UserController::class, 'update']);
    });

    Route::prefix('/comments')->group(function () {
        Route::post('/', [CommentController::class, 'store']);
    });
});
