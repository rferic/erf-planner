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
            Route::patch('image', [\App\Http\Controllers\Api\Core\MeController::class, 'postImage'])->name('postImage');
            Route::delete('/', [\App\Http\Controllers\Api\Core\MeController::class, 'destroy'])->name('destroy');
        });

        Route::get('permissions', \App\Http\Controllers\Api\Core\PermissionsController::class)->name('permissions');

        Route::resource('roles', \App\Http\Controllers\Api\Core\RolesController::class)->except(['show', 'create', 'edit']);
        Route::prefix('roles')->group(static function () {
            Route::patch('{role}/give-permission', [\App\Http\Controllers\Api\Core\RolesController::class, 'givePermission'])->name('givePermission');
            Route::patch('{role}/revoke-permission', [\App\Http\Controllers\Api\Core\RolesController::class, 'revokePermission'])->name('revokePermission');
            Route::patch('{role}/sync-permissions', [\App\Http\Controllers\Api\Core\RolesController::class, 'syncPermissions'])->name('syncPermissions');
        });

        Route::resource('languages', \App\Http\Controllers\Api\Core\LanguagesController::class)->except(['show', 'create', 'edit']);

        Route::resource('users', \App\Http\Controllers\Api\Core\UsersController::class)->except(['create', 'edit']);
        Route::prefix('users')->group(static function () {
            Route::patch('{user}/image', [\App\Http\Controllers\Api\Core\UsersController::class, 'postImage'])->name('postImage');
            Route::patch('{user}/role', [\App\Http\Controllers\Api\Core\UsersController::class, 'assignRole'])->name('assignRole');
        });

        Route::prefix('clients')->group(static function () {
            Route::patch('{client}/image', [\App\Http\Controllers\Api\Core\ClientsController::class, 'postImage'])->name('clients.postImage');

            Route::get('statuses', [\App\Http\Controllers\Api\Core\ClientsController::class, 'statuses'])->name('clients.statuses.index');
            Route::post('statuses', [\App\Http\Controllers\Api\Core\ClientsController::class, 'storeStatus'])->name('clients.statuses.store');
            Route::put('statuses/{status}', [\App\Http\Controllers\Api\Core\ClientsController::class, 'updateStatus'])->name('clients.statuses.update');
            Route::delete('statuses/{status}', [\App\Http\Controllers\Api\Core\ClientsController::class, 'destroyStatus'])->name('clients.statuses.destroy');
        });
        Route::resource('clients', \App\Http\Controllers\Api\Core\ClientsController::class)->except(['create', 'edit']);

        Route::prefix('projects')->group(static function () {
            Route::patch('{project}/image', [\App\Http\Controllers\Api\Core\ProjectsController::class, 'postImage'])->name('projects.postImage');

            Route::patch('{project}/attach-user/{user}', [\App\Http\Controllers\Api\Core\ProjectsController::class, 'attachUser'])->name('projects.attachUser');
            Route::patch('{project}/detach-user/{user}', [\App\Http\Controllers\Api\Core\ProjectsController::class, 'detachUser'])->name('projects.detachUser');

            Route::get('statuses', [\App\Http\Controllers\Api\Core\ProjectsController::class, 'statuses'])->name('projects.statuses.index');
            Route::post('statuses', [\App\Http\Controllers\Api\Core\ProjectsController::class, 'storeStatus'])->name('projects.statuses.store');
            Route::put('statuses/{status}', [\App\Http\Controllers\Api\Core\ProjectsController::class, 'updateStatus'])->name('projects.statuses.update');
            Route::delete('statuses/{status}', [\App\Http\Controllers\Api\Core\ProjectsController::class, 'destroyStatus'])->name('projects.statuses.destroy');
        });
        Route::resource('projects', \App\Http\Controllers\Api\Core\ProjectsController::class)->except(['create', 'edit']);
    });
});
