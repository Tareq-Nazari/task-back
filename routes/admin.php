<?php

use Illuminate\Support\Facades\Route;

Route::name('admin.')->prefix('admin')->middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout']);

    Route::group(['middleware' => ['permission:authorization']], function () {
        Route::post('/roles', [\App\Http\Controllers\Admin\PermissionController::class, 'storeRole']);
        Route::post('/assign-role-to-user', [\App\Http\Controllers\Admin\PermissionController::class, 'assignRole']);
        Route::post('/revoke-role-from-user', [\App\Http\Controllers\Admin\PermissionController::class, 'revokeRole']);
        Route::get('/permissions', [\App\Http\Controllers\Admin\PermissionController::class, 'getPermissions']);
        Route::get('/roles', [\App\Http\Controllers\Admin\PermissionController::class, 'getRoles']);
    });
    Route::get('/task', [\App\Http\Controllers\Admin\TaskController::class, 'index']);


});
Route::post('admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
Route::post('admin/register', [\App\Http\Controllers\Admin\AuthController::class, 'register']);
