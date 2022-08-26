<?php

namespace App\UseCases\Core\Permission;

use Spatie\Permission\Models\Permission;

class GetQueryBuilderUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(protected ?string $search = null)
    {}

	public function action(): \Illuminate\Database\Eloquent\Builder
    {
		$query = Permission::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query;
	}
}
