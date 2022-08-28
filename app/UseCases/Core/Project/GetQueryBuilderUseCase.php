<?php

namespace App\UseCases\Core\Project;

use App\Models\Core\Project;
use App\UseCases\HasQueryBuilderFilter;

class GetQueryBuilderUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    use HasQueryBuilderFilter;

    public function action(): \Illuminate\Database\Eloquent\Builder
    {
        $query = Project::query();

        if ($this->search) {
            $query->where(function ($query) {
                $query
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filters) {
            if ($filter_client = $this->filters->filter('client')) {
                $query->whereIn('client_id', $filter_client);
            }

            if ($filter_author = $this->filters->filter('author')) {
                $query->whereIn('author_id', $filter_author);
            }

            if ($filter_status = $this->filters->filter('status')) {
                $query->whereIn('status_id', $filter_status);
            }

            if ($filter_name = $this->filters->filter('name')) {
                $query->where(
                    'name',
                    $filter_name['operator'],
                    $this->parseValueToOperator($filter_name['operator'], $filter_name['value'])
                );
            }

            $is_out_of_time = $this->filters->filter('out_of_time');

            if (!is_null($is_out_of_time)) {
                $query->where('out_of_time', $is_out_of_time);
            }
        }

        return $query;
    }
}
