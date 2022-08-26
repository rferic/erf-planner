<?php

namespace App\UseCases\Core\Auth;

use App\Models\Core\User;

class GenerateTokenUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct (
        protected User $user,
        protected bool $rememberMe
    )
    {}

	public function action(): \Laravel\Passport\PersonalAccessTokenResult
    {
        $this->user->token()?->revoke();

        $accessToken = $this->user->createToken('Personal Access Token');

        if ($this->rememberMe) {
            $accessToken->token->expires_at = now()->addMonth();
            $accessToken->token->save();
        }

        return $accessToken;
	}
}
