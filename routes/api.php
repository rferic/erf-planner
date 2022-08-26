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

// Public API routes
Route::prefix('core')->group(static function () {
    Route::post('auth/login', [\App\Http\Controllers\Api\Core\AuthController::class, 'login'])->name('auth.login');
});

// Private API routes
Route::middleware(['auth:api'])->group(static function () {
    Route::prefix('core')->group(static function () {
        Route::prefix('auth')->group(static function () {
            Route::post('logout', [\App\Http\Controllers\Api\Core\AuthController::class, 'logout'])->name('logout');
        });

        Route::prefix('me')->group(static function () {
            Route::get('/', [\App\Http\Controllers\Api\Core\MeController::class, 'me'])->name('show');
            Route::put('/', [\App\Http\Controllers\Api\Core\MeController::class, 'update'])->name('update');
            Route::post('/image', [\App\Http\Controllers\Api\Core\MeController::class, 'postImage'])->name('post-image');
            Route::delete('/', [\App\Http\Controllers\Api\Core\MeController::class, 'destroy'])->name('destroy');
        });

        Route::get('permissions', \App\Http\Controllers\Api\Core\PermissionsController::class)->name('permissions');

        Route::prefix('roles/{role}')->group(static function () {
            Route::patch('give-permission', [\App\Http\Controllers\Api\Core\RolesController::class, 'givePermission'])->name('givePermission');
            Route::patch('revoke-permission', [\App\Http\Controllers\Api\Core\RolesController::class, 'revokePermission'])->name('revokePermission');
            Route::patch('sync-permissions', [\App\Http\Controllers\Api\Core\RolesController::class, 'syncPermissions'])->name('syncPermissions');
        });
        Route::resource('roles', \App\Http\Controllers\Api\Core\RolesController::class)->except(['create', 'edit']);
    });
});
