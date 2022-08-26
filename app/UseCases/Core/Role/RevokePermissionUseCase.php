<?php

namespace App\UseCases\Core\Role;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RevokePermissionUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
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

        $this->role->revokePermissionTo($this->permission);
        $this->role->load('permissions');
        return $this->role;
    }
}
