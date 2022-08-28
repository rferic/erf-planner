<?php

namespace App\Http\Controllers\Api;

use App\Helpers\QueryBuilder\Filters;
use App\Helpers\QueryBuilder\Pagination;
use App\Helpers\QueryBuilder\Sorting;
use App\Http\Controllers\HasPermissionMiddleware;
use App\Http\Requests\Api\Core\Status\DestroyRequest;
use App\Http\Requests\Api\Core\Status\IndexRequest;
use App\Http\Requests\Api\Core\Status\StoreRequest;
use App\Http\Requests\Api\Core\Status\UpdateRequest;
use App\Http\Resources\Core\StatusResource;
use App\Models\Core\Status;
use App\UseCases\Core\Status\DestroyUseCase;
use App\UseCases\Core\Status\GetQueryBuilderUseCase;
use App\UseCases\Core\Status\StoreUseCase;
use App\UseCases\Core\Status\UpdateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

trait HasStatus
{
    use HasList, HasPermissionMiddleware;

    public function statuses(IndexRequest $request): JsonResponse
    {
        $this->validatePermission();
        $this->validateStatusType();

        $dataRequest = $request->validated();
        $dataRequest['filters']['type'] = self::STATUS_TYPE;

        $query = (new GetQueryBuilderUseCase(
            $request->input('search'),
            new Filters($dataRequest)
        ))->action();
        $results = $this->list($query, new Pagination($request), new Sorting($request));

        return ApiResponse::done(
            __('Statuses has been retrieved'),
            ApiResponse::parsePagination($results, StatusResource::class)
        );
    }

    public function storeStatus(StoreRequest $request): JsonResponse
    {
        $this->validatePermission();
        $this->validateStatusType();

        $status = (new StoreUseCase(
            $request->input('name'),
            $request->input('color'),
            $request->input('text_color'),
            self::STATUS_TYPE,
            $request->input('is_started'),
            $request->input('is_ended'),
            (int)$request->input('weight')
        ))->action();
        return $this->responseStatus($status, __('Status has been created'));
    }

    public function updateStatus(UpdateRequest $request, Status $status): JsonResponse
    {
        $this->validatePermission();
        $this->validateStatusType();
        $this->validateStatusModel($status);

        $status = (new UpdateUseCase(
            $status,
            $request->input('name'),
            $request->input('color'),
            $request->input('text_color'),
            $request->input('is_started'),
            $request->input('is_ended'),
            (int)$request->input('weight')
        ))->action();
        return $this->responseStatus($status, __('Status has been created'));
    }

    public function destroyStatus(Status $status): JsonResponse
    {
        $this->validatePermission();
        $this->validateStatusType();
        $this->validateStatusModel($status);

        (new DestroyUseCase($status))->action();
        return $this->responseStatus($status, __('Status has been deleted'));
    }

    protected function setStatusTypeInRequest(): void
    {
        $action = Route::current()?->action['controller'];

        if (!$action) {
            return;
        }

        $method = explode('@', $action)[1];

        if (in_array($method, ['statuses', 'storeStatus', 'updateStatus', 'destroyStatus'])) {
            request()?->merge(['type' => self::STATUS_TYPE]);
        }
    }

    private function responseStatus(Status $status, string $message): JsonResponse
    {
        return ApiResponse::done(
            $message,
            (new StatusResource($status))->toArray(request())
        );
    }

    private function validatePermission(): void
    {
        $auth = auth()->user();
        $permission = $this->getPermissionScope('statuses');
        $hasAccess = !$permission || $auth?->hasRole(config('permission.role-super-admin')) || $auth?->can($permission);
        abort_if(!$hasAccess, Response::HTTP_UNAUTHORIZED, __('Unauthorized'));
    }

    private function validateStatusType(): void
    {
        if (!array_key_exists(static::STATUS_TYPE, Status::AVAILABLE_TYPES_CLASSES)) {
            throw new \RuntimeException(__('Invalid status type'));
        }
    }

    private function validateStatusModel(Status $status): void
    {
        if (static::STATUS_TYPE !== $status->type) {
            throw new \RuntimeException(__('Status not found'), Response::HTTP_NOT_FOUND);
        }
    }
}
