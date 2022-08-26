<?php

namespace App\Http\Requests\Api\Core\Permission;

use App\Http\Requests\Api\HasPagination;
use App\Http\Requests\Api\HasSearchString;
use App\Http\Requests\Api\HasSorting;
use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class IndexRequest extends ApiRequest
{
    use HasPagination, HasSearchString, HasSorting;

    public const AVAILABLE_SORTING_PARAMS = ['name'];

    public function rules(): array
    {
        return array_merge(
            $this->paginationRules(),
            $this->searchStringRules(),
            $this->sortingRules()
        );
    }
}
