<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\QueryBuilder\Filters;
use App\Helpers\QueryBuilder\Pagination;
use App\Helpers\QueryBuilder\Sorting;
use App\Http\Controllers\Api\HasList;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HasPermissionMiddleware;
use App\Http\Requests\Api\Core\User\AssignRoleRequest;
use App\Http\Requests\Api\Core\User\IndexRequest;
use App\Http\Requests\Api\Core\User\PostImageRequest;
use App\Http\Requests\Api\Core\User\StoreRequest;
use App\Http\Requests\Api\Core\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Core\User;
use App\UseCases\Core\User\DestroyUseCase;
use App\UseCases\Core\User\GetQueryBuilderUseCase;
use App\UseCases\Core\User\PublishImageUseCase;
use App\UseCases\Core\User\StoreUseCase;
use App\UseCases\Core\User\SyncRolesUseCase;
use App\UseCases\Core\User\UpdateUseCase;
use Illuminate\Http\JsonResponse;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    use HasList, HasPermissionMiddleware;

    public const PERMISSION_SCOPE = 'users';

    public function index(IndexRequest $request): JsonResponse
    {
        $query = (new GetQueryBuilderUseCase(
            $request->input('search'),
            new Filters($request)
        ))->action();
        $results = $this->list($query, new Pagination($request), new Sorting($request));

        return ApiResponse::done(
            __('Users has been retrieved'),
            ApiResponse::parsePagination($results, UserResource::class)
        );
    }

    public function show(User $user): JsonResponse
    {
        return $this->responseUser($user, __('User has been retrieved'));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $user = (new StoreUseCase(
            $request->input('email'),
            $request->input('name'),
            $request->input('password')
        ))->action();

        if ($role = $request->input('role')) {
            $this->syncRole($user, $role);
            $user->load('roles');
        }

        return $this->responseUser($user, __('User has been created'));
    }

    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        $this->validateUser($user);
        $user = (new UpdateUseCase(
            $user,
            $request->input('email'),
            $request->input('name'),
            $request->input('password')
        ))->action();

        if ($role = $request->input('role')) {
            $this->syncRole($user, $role);
            $user->load('roles');
        }

        return $this->responseUser($user, __('User has been updated'));
    }

    public function postImage(PostImageRequest $request, User $user): JsonResponse
    {
        $this->validateUser($user);
        $user = (new PublishImageUseCase($user, $request->file('image')))->action();
        return $this->responseUser($user, __('Image has been published'));
    }

    public function assignRole(AssignRoleRequest $request, User $user): JsonResponse
    {
        $this->validateUser($user);
        (new SyncRolesUseCase($user, [$request->input('role')]))->action();
        $user->load('roles');
        return $this->responseUser($user, __('Role has been assigned'));
    }

    public function destroy(User $user): JsonResponse
    {
        $this->validateUser($user);
        $user = (new DestroyUseCase($user))->action();
        return $this->responseUser($user, __('User has been deleted'));
    }

    private function responseUser(User $user, string $message): JsonResponse
    {
        return ApiResponse::done($message, (new UserResource($user))->toArray(request()));
    }

    private function syncRole(User $user, string $role): void
    {
        (new SyncRolesUseCase($user, [$role]))->action();
    }

    private function validateUser(User $user): void
    {
        abort_if(
            $user->id === auth()->id(),
            Response::HTTP_CONFLICT,
            __('You cannot edit your own profile')
        );
    }
}
