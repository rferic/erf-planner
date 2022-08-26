<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\Auth\LoginRequest;
use App\UseCases\Core\Auth\LoginUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Labelgrup\LaravelUtilities\Helpers\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $useCase = new LoginUseCase(
            $request->input('email'),
            $request->input('password'),
            (bool)$request->input('remember_me')
        );

        return ApiResponse::response($useCase->handle()->getData(), Response::HTTP_OK);
    }

    public function logout(Request $request): JsonResponse
    {
        $auth = $request->user();

        if (!$auth) {
            return ApiResponse::fail(__('Unauthorized logout'), [], Response::HTTP_UNAUTHORIZED);
        }

        $auth->token()->revoke();

        return ApiResponse::done(__('Logout success'));
    }
}
