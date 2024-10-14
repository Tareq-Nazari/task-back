<?php

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

Route::middleware('auth:sanctum')->group(function () {

    // task
    Route::post('/task', [\App\Http\Controllers\User\TaskController::class, 'store']);
    Route::post('/task/{task}', [\App\Http\Controllers\User\TaskController::class, 'update']);
    Route::delete('/task/{task}', [\App\Http\Controllers\User\TaskController::class, 'destroy']);
    Route::get('task', [\App\Http\Controllers\User\TaskController::class, 'index']);
    Route::get('task', [\App\Http\Controllers\User\TaskController::class, 'show']);

});
Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\Admin\AuthController::class, 'register']);