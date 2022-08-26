<?php

namespace App\UseCases\Core\Role;

use Spatie\Permission\Models\Role;

class SyncPermissionsUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Role $role,
        protected array $permissions
    )
    {}

    public function action(): Role
    {
        $this->role->syncPermissions($this->permissions);
        $this->role->load('permissions');
        return $this->role;
    }
}
