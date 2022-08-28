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
        try {
            $this->role->forceDelete();
        } catch (\Exception $_) {
            $this->role->delete();
        }

        return $this->role;
    }
}
