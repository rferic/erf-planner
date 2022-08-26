<?php

namespace App\UseCases\Core\User;

use App\Models\Core\User;

class DestroyUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(protected User $user)
    {}

	public function action(): User
	{
		$this->user->delete();
        return $this->user;
	}
}
