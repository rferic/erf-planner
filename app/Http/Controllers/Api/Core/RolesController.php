<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\QueryBuilder\Pagination;
use App\Helpers\QueryBuilder\Sorting;
use App\Http\Controllers\Api\HasList;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HasPermissionMiddleware;
use App\Http\Requests\Api\Core\Role\GivePermissionRequest;
use App\Http\Requests\Api\Core\Role\IndexRequest;
use App\Http\Requests\Api\Core\Role\RevokePermissionRequest;
use App\Http\Requests\Api\Core\Role\StoreRequest;
use App\Http\Requests\Api\Core\Role\SyncPermissionsRequest;
use App\Http\Requests\Api\Core\Role\UpdateRequest;
use App\Http\Resources\Core\RoleResource;
use App\UseCases\Core\Role\DestroyUseCase;
use App\UseCases\Core\Role\GetQueryBuilderUseCase;
use App\UseCases\Core\Role\GivePermissionUseCase;
use App\UseCases\Core\Role\RevokePermissionUseCase;
use App\UseCases\Core\Role\StoreUseCase;
use App\UseCases\Core\Role\SyncPermissionsUseCase;
use App\UseCases\Core\Role\UpdateUseCase;
use Illuminate\Http\JsonResponse;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    use HasList, HasPermissionMiddleware;

    public const PERMISSION_SCOPE = 'settings';

    public function index(IndexRequest $request): JsonResponse
    {
        $query = (new GetQueryBuilderUseCase($request->input('search')))->action();
        $results = $this->list($query, new Pagination($request), new Sorting($request));

        return ApiResponse::done(
            __('Roles has been retrieved'),
            ApiResponse::parsePagination($results, RoleResource::class)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        return (new StoreUseCase($request->input('name')))->handle()->responseToApi();
    }

    public function update(UpdateRequest$request, Role $role): JsonResponse
    {
        return (new UpdateUseCase($role, $request->input('name')))->handle()->responseToApi();
    }

    public function givePermission(GivePermissionRequest $request, Role $role): JsonResponse
    {
        return (new GivePermissionUseCase($role, $request->input('permission')))->handle()->responseToApi();
    }

    public function revokePermission(RevokePermissionRequest $request, Role $role): JsonResponse
    {
        return (new RevokePermissionUseCase($role, $request->input('permission')))->handle()->responseToApi();
    }

    public function syncPermissions(SyncPermissionsRequest $request, Role $role): JsonResponse
    {
        return (new SyncPermissionsUseCase($role, $request->input('permissions')))->handle()->responseToApi();
    }

    public function destroy(Role $role): JsonResponse
    {
        return (new DestroyUseCase($role))->handle()->responseToApi();
    }
}
