<?php

namespace App\UseCases\Core\Role;

use Spatie\Permission\Models\Role;

class UpdateUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Role $role,
        protected string $name
    )
    {}

    public function action(): Role
    {
        $this->role->name = $this->name;
        $this->role->save();
        return $this->role;
    }
}
