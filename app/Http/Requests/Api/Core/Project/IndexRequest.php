<?php

namespace App\Http\Requests\Api\Core\Project;

use App\Http\Requests\Api\HasFilters;
use App\Http\Requests\Api\HasPagination;
use App\Http\Requests\Api\HasSearchString;
use App\Http\Requests\Api\HasSorting;

class IndexRequest extends \Labelgrup\LaravelUtilities\Core\Requests\ApiRequest
{
    use HasFilters, HasPagination, HasSearchString, HasSorting;

    public const AVAILABLE_SORTING_PARAMS = ['id', 'name'];

    public function rules(): array
    {
        return array_merge(
            $this->paginationRules(),
            $this->searchStringRules(),
            $this->sortingRules(),
            $this->filtersRules([
                'id' => 'numeric',
                'author' => 'integer|exists:users,id',
                'status' => 'integer|exists:statuses,id',
                'client' => 'integer|exists:clients,id',
                'name' => 'array',
                'name.value' => 'string',
                'name.operator' => 'string|in:=,!=,like,notLike',
                'out_of_time' => 'boolean',
            ])
        );
    }
}
