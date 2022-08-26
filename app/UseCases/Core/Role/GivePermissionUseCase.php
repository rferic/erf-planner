<?php

namespace App\UseCases\Core\Role;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GivePermissionUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Role $role,
        protected string $permission
    )
    {}

    public function action(): Role
    {
        if (!Permission::where('name', $this->permission)->exists()) {
            throw new \RuntimeException(__('Permission not found'));
        }

        $this->role->givePermissionTo($this->permission);
        $this->role->load('permissions');
        return $this->role;
    }
}
