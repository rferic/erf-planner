<?php

namespace App\UseCases\Core\User;

use App\Models\Core\User;

class SyncRolesUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected User $user,
        protected array $roles
    )
    {}

	public function action(): bool
	{
        if (!$this->user->hasAnyRole($this->roles)) {
            $this->user->syncRoles($this->roles);
        }

        return true;
	}
}
