<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\QueryBuilder\Filters;
use App\Helpers\QueryBuilder\Pagination;
use App\Helpers\QueryBuilder\Sorting;
use App\Http\Controllers\Api\HasList;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HasPermissionMiddleware;
use App\Http\Requests\Api\Core\Language\IndexRequest;
use App\Http\Requests\Api\Core\Language\StoreRequest;
use App\Http\Requests\Api\Core\Language\UpdateRequest;
use App\Http\Resources\Core\LanguageResource;
use App\Models\Core\Language;
use App\UseCases\Core\Language\DestroyUseCase;
use App\UseCases\Core\Language\GetQueryBuilderUseCase;
use App\UseCases\Core\Language\StoreUseCase;
use App\UseCases\Core\Language\UpdateUseCase;
use Illuminate\Http\JsonResponse;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;

class LanguagesController extends Controller
{
    use HasList, HasPermissionMiddleware;

    public const PERMISSION_SCOPE = 'settings';

    public function index(IndexRequest $request): JsonResponse
    {
        $query = (new GetQueryBuilderUseCase(
            $request->input('search'),
            new Filters($request)
        ))->action();
        $results = $this->list($query, new Pagination($request), new Sorting($request));

        return ApiResponse::done(
            __('Language has been retrieved'),
            ApiResponse::parsePagination($results, LanguageResource::class)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $language = (new StoreUseCase(
            $request->input('name'),
            $request->input('iso_code'),
            $request->input('enabled')
        ))->action();
        return $this->responseLanguage($language, __('Language has been created'));
    }

    public function update(UpdateRequest $request, Language $language): JsonResponse
    {
        $language = (new UpdateUseCase(
            $language,
            $request->input('name'),
            $request->input('enabled')
        ))->action();
        return $this->responseLanguage($language, __('Language has been updated'));
    }

    public function destroy(Language $language): JsonResponse
    {
        (new DestroyUseCase($language))->action();
        return $this->responseLanguage($language, __('Language has been deleted'));
    }

    private function responseLanguage(Language $language, string $message): JsonResponse
    {
        return ApiResponse::done(
            $message,
            (new LanguageResource($language))->toArray(request())
        );
    }
}
