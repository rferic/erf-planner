<?php

namespace App\UseCases\Core\Role;

use Spatie\Permission\Models\Role;

class StoreUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected string $name
    )
    {}

    public function action(): Role
    {
        if (Role::where('name', $this->name)->exists()) {
            throw new \RuntimeException(__('Role already exists'));
        }

        Role::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);

        return Role::where('name', $this->name)->first();
    }
}
