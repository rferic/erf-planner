<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\Me\PostImageRequest;
use App\Http\Requests\Api\Core\Me\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Core\User;
use App\UseCases\Core\User\DestroyUseCase;
use App\UseCases\Core\User\PublishImageUseCase;
use App\UseCases\Core\User\UpdateUseCase;
use Illuminate\Http\JsonResponse;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class MeController extends Controller
{
    protected ?User $auth;

    public function me(): JsonResponse
    {
        $this->loadAuthUser();
        return $this->response($this->auth);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $this->loadAuthUser();
        $user = (new UpdateUseCase(
            $this->auth,
            $request->input('email'),
            $request->input('name'),
            $request->input('password')
        ))->action();
        return $this->response($user);
    }

    public function postImage(PostImageRequest $request): JsonResponse
    {
        $this->loadAuthUser();
        $user = (new PublishImageUseCase($this->auth, $request->file('image')))->action();
        return $this->response($user);
    }

    public function destroy(): JsonResponse
    {
        $this->loadAuthUser();
        auth()->user()?->token()?->revoke();
        $user = (new DestroyUseCase($this->auth))->action();
        return $this->response($user);
    }

    private function loadAuthUser(): void
    {
        $this->auth = User::find(auth()->id());

        if (!$this->auth) {
            throw new \RuntimeException('Unauthenticated');
        }
    }

    private function response(User $user): JsonResponse
    {
        return ApiResponse::response((new UserResource($user))->toArray(request()), Response::HTTP_OK);
    }
}
