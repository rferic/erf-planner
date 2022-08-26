<?php

namespace App\UseCases\Core\Role;

use Spatie\Permission\Models\Role;

class DestroyUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Role $role
    )
    {}

    public function action(): Role
    {
        $this->role->delete();
        return $this->role;
    }
}
