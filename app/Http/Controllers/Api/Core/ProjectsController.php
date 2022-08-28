<?php

namespace App\Http\Controllers\Api\Core;

use App\Helpers\Core\ProjectHelper;
use App\Helpers\QueryBuilder\Filters;
use App\Helpers\QueryBuilder\Pagination;
use App\Helpers\QueryBuilder\Sorting;
use App\Http\Controllers\Api\HasList;
use App\Http\Controllers\Api\HasStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HasPermissionMiddleware;
use App\Http\Requests\Api\Core\Project\AttachUserRequest;
use App\Http\Requests\Api\Core\Project\IndexRequest;
use App\Http\Requests\Api\Core\Project\PostImageRequest;
use App\Http\Requests\Api\Core\Project\StoreRequest;
use App\Http\Requests\Api\Core\Project\UpdateRequest;
use App\Http\Resources\Core\ProjectResource;
use App\Models\Core\Client;
use App\Models\Core\Project;
use App\Models\Core\Status;
use App\Models\Core\User;
use App\UseCases\Core\Project\AttachUserUseCase;
use App\UseCases\Core\Project\DestroyUseCase;
use App\UseCases\Core\Project\DetachUserUseCase;
use App\UseCases\Core\Project\GetQueryBuilderUseCase;
use App\UseCases\Core\Project\PublishImageUseCase;
use App\UseCases\Core\Project\StoreUseCase;
use App\UseCases\Core\Project\UpdateUseCase;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;

class ProjectsController extends Controller
{
    use HasList, HasPermissionMiddleware, HasStatus;

    public const PERMISSION_SCOPE = 'projects';
    public const STATUS_TYPE = Project::STATUS_TYPE;

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
            __('Projects has been retrieved'),
            ApiResponse::parsePagination($results, ProjectResource::class, ['client', 'author'])
        );
    }

    public function show(Project $project): JsonResponse
    {
        return $this->responseProject($project, __('Project has been retrieved'));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $deadline = $request->input('deadline');

        $project = (new StoreUseCase(
            $request->input('name'),
            $request->input('description'),
            $deadline ? Carbon::createFromFormat('Y-m-d', $request->input('deadline'))->endOfDay() : null,
            Client::findOrFail($request->input('client_id')),
            Status::findOrFail($request->input('status_id')),
            User::findOrFail(auth()->id())
        ))->action();
        return $this->responseProject($project, __('Project has been created'));
    }

    public function update(UpdateRequest $request, Project $project): JsonResponse
    {
        $deadline = $request->input('deadline');

        $project = (new UpdateUseCase(
            $project,
            $request->input('name'),
            $request->input('description'),
            $deadline ? Carbon::createFromFormat('Y-m-d', $request->input('deadline'))->endOfDay() : null,
            Client::findOrFail($request->input('client_id')),
            Status::findOrFail($request->input('status_id')),
        ))->action();
        return $this->responseProject($project, __('Project has been updated'));
    }

    public function postImage(PostImageRequest $request, Project $project): JsonResponse
    {
        $project = (new PublishImageUseCase($project, $request->file('image')))->action();
        return $this->responseProject($project, __('Image has been published'));
    }

    public function attachUser(AttachUserRequest $request, Project $project, User $user): JsonResponse
    {
        ProjectHelper::validateAuthAccess($project, ['manager']);
        $project = (new AttachUserUseCase($project, $user, $request->input('type')))->action();
        return $this->responseProject($project, __('User has been attached'));
    }

    public function detachUser(Project $project, User $user): JsonResponse
    {
        ProjectHelper::validateAuthAccess($project, ['manager']);
        $project = (new DetachUserUseCase($project, $user))->action();
        return $this->responseProject($project, __('User has been detached'));
    }

    public function destroy(Project $project): JsonResponse
    {
        (new DestroyUseCase($project))->action();
        return $this->responseProject($project, __('Project has been deleted'));
    }

    private function responseProject(Project $project, string $message): JsonResponse
    {
        return ApiResponse::done(
            $message,
            (new ProjectResource($project, ['client', 'author', 'users']))->toArray(request())
        );
    }
}
