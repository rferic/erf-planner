<?php

namespace App\UseCases\Core\Auth;

use App\Http\Resources\Core\MeResource;
use Symfony\Component\HttpFoundation\Response;

class LoginUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct (
        protected string $email,
        protected string $password,
        protected bool $rememberMe
    )
    {}

	public function action(): array
	{
        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];

        if (!auth()->attempt($credentials, $this->rememberMe)) {
            throw new \RuntimeException('Unauthorized login attempt', Response::HTTP_UNAUTHORIZED);
        }

        $user = request()?->user();

        if (!$user) {
            throw new \RuntimeException('User not found', Response::HTTP_NOT_FOUND);
        }

        $token = (new GenerateTokenUseCase($user, $this->rememberMe))->action();

        return (new MeResource($user, $token))->toArray(request());
	}
}
