<?php

namespace App\UseCases\Core\Language;

use App\Models\Core\Language;
use App\UseCases\HasQueryBuilderFilter;

class GetQueryBuilderUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    use HasQueryBuilderFilter;

    public function action(): \Illuminate\Database\Eloquent\Builder
    {
        $query = Language::query();

        if ($this->search) {
            $query
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('iso_code', $this->search);
        }

        if ($this->filters) {
            $filter_enabled = $this->filters->filter('enabled');

            if (!is_null($filter_enabled)) {
                $query->where('enabled', $filter_enabled);
            }
        }

        return $query;
    }
}
