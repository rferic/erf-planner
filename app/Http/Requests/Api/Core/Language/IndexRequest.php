<?php

namespace App\Http\Requests\Api\Core\Language;

use App\Http\Requests\Api\HasFilters;
use App\Http\Requests\Api\HasPagination;
use App\Http\Requests\Api\HasSearchString;
use App\Http\Requests\Api\HasSorting;
use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class IndexRequest extends ApiRequest
{
    use HasFilters, HasPagination, HasSearchString, HasSorting;

    public const AVAILABLE_SORTING_PARAMS = ['id', 'name', 'iso_code'];

    public function rules(): array
    {
        return array_merge(
            $this->paginationRules(),
            $this->searchStringRules(),
            $this->sortingRules(),
            $this->filtersRules([
                'enabled' => 'nullable|boolean'
            ])
        );
    }
}
