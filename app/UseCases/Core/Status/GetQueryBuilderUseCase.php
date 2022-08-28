<?php

namespace App\UseCases\Core\Status;

use App\Models\Core\Status;
use App\UseCases\HasQueryBuilderFilter;

class GetQueryBuilderUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    use HasQueryBuilderFilter;

	public function action(): \Illuminate\Database\Eloquent\Builder
	{
		$query = Status::query();

        if ($this->search) {
            $query->where(function ($query) {
                $query
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filters) {
            if ($filter_id = $this->filters->filter('id')) {
                $query->where('id', $filter_id);
            }

            if ($filter_name = $this->filters->filter('name')) {
                $query->where(
                    'name',
                    $filter_name['operator'],
                    $this->parseValueToOperator($filter_name['operator'], $filter_name['value'])
                );
            }

            if ($filter_type = $this->filters->filter('type')) {
                $query->where('type', $filter_type);
            }

            $filter_is_started = $this->filters->filter('is_started');

            if (!is_null($filter_is_started)) {
                $query->where('is_started', $filter_is_started);
            }

            $filter_is_ended = $this->filters->filter('is_ended');

            if (!is_null($filter_is_ended)) {
                $query->where('is_ended', $filter_is_ended);
            }
        }

        return $query;
	}
}
