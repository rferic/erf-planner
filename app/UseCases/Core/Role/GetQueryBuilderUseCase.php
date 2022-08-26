<?php

namespace App\UseCases\Core\Role;

use Spatie\Permission\Models\Role;

class GetQueryBuilderUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(protected ?string $search = null)
    {}

    public function action(): \Illuminate\Database\Eloquent\Builder
    {
        $query = Role::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query;
    }
}
