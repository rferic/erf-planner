<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\QueryBuilder\Filters;
use App\Helpers\QueryBuilder\Pagination;
use App\Helpers\QueryBuilder\Sorting;
use App\Http\Controllers\Api\HasList;
use App\Http\Controllers\Api\HasStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HasPermissionMiddleware;
use App\Http\Requests\Api\Core\Client\IndexRequest;
use App\Http\Requests\Api\Core\Client\PostImageRequest;
use App\Http\Requests\Api\Core\Client\StoreRequest;
use App\Http\Requests\Api\Core\Client\UpdateRequest;
use App\Http\Resources\Core\ClientResource;
use App\Models\Core\Client;
use App\Models\Core\Status;
use App\UseCases\Core\Client\DestroyUseCase;
use App\UseCases\Core\Client\GetQueryBuilderUseCase;
use App\UseCases\Core\Client\PublishImageUseCase;
use App\UseCases\Core\Client\StoreUseCase;
use App\UseCases\Core\Client\UpdateUseCase;
use Illuminate\Http\JsonResponse;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;

class ClientsController extends Controller
{
    use HasList, HasPermissionMiddleware, HasStatus;

    public const PERMISSION_SCOPE = 'clients';
    public const STATUS_TYPE = Client::STATUS_TYPE;

    public function __construct()
    {
        $this->setMiddleware();
        $this->setStatusTypeInRequest();
    }

    public function index(IndexRequest $request): JsonResponse
    {
        $query = (new GetQueryBuilderUseCase(
            $request->input('search'),
            new Filters($request)
        ))->action();
        $results = $this->list($query, new Pagination($request), new Sorting($request));

        return ApiResponse::done(
            __('Clients has been retrieved'),
            ApiResponse::parsePagination($results, ClientResource::class, ['projects'])
        );
    }

    public function show(Client $client): JsonResponse
    {
        return $this->responseClient($client, __('Client has been retrieved'));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $client = (new StoreUseCase(
            $request->input('name'),
            $request->input('email'),
            $request->input('phone'),
            $request->input('web'),
            Status::findOrFail($request->input('status_id'))
        ))->action();
        return $this->responseClient($client, __('Client has been created'));
    }

    public function update(UpdateRequest $request, Client $client): JsonResponse
    {
        $client = (new UpdateUseCase(
            $client,
            $request->input('name'),
            $request->input('email'),
            $request->input('phone'),
            $request->input('web'),
            $request->input('status_id') ? Status::findOrFail($request->input('status_id')) : null
        ))->action();
        return $this->responseClient($client, __('Client has been updated'));
    }

    public function postImage(PostImageRequest $request, Client $client): JsonResponse
    {
        $client = (new PublishImageUseCase($client, $request->file('image')))->action();
        return $this->responseClient($client, __('Image has been published'));
    }

    public function destroy(Client $client): JsonResponse
    {
        (new DestroyUseCase($client))->action();
        return $this->responseClient($client, __('Client has been deleted'));
    }

    private function responseClient(Client $client, string $message): JsonResponse
    {
        return ApiResponse::done($message, (new ClientResource($client, ['projects']))->toArray(request()));
    }
}
