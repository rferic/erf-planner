<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\QueryBuilder\Pagination;
use App\Helpers\QueryBuilder\Sorting;
use App\Http\Controllers\Api\HasList;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\Permission\IndexRequest;
use App\Http\Resources\PermissionResource;
use App\UseCases\Core\Permission\GetQueryBuilderUseCase;
use Illuminate\Http\JsonResponse;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;

class PermissionsController extends Controller
{
    use HasList;

    public function __invoke(IndexRequest $request): JsonResponse
    {
        $query = (new GetQueryBuilderUseCase($request->search))->action();
        $results = $this->list($query, new Pagination($request), new Sorting($request));

        return ApiResponse::done(
            __('Permissions has been retrieved'),
            ApiResponse::parsePagination($results, PermissionResource::class)
        );
    }
}
