<?php

namespace App\Http\Requests\Api\Core\Status;

use App\Http\Requests\Api\HasFilters;
use App\Http\Requests\Api\HasPagination;
use App\Http\Requests\Api\HasSearchString;
use App\Http\Requests\Api\HasSorting;
use App\Models\Core\Status;
use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class IndexRequest extends ApiRequest
{
    use HasFilters, HasPagination, HasSearchString, HasSorting;

    public const AVAILABLE_SORTING_PARAMS = ['id', 'name', 'type'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return array_merge(
            $this->paginationRules(),
            $this->searchStringRules(),
            $this->sortingRules(),
            $this->filtersRules([
                'id' => 'numeric',
                'name' => 'array',
                'name.value' => 'string',
                'name.operator' => 'string|in:=,!=,like,notLike',
                'type' => 'nullable|string|in:' . implode(',', array_keys(Status::AVAILABLE_TYPES_CLASSES)),
                'is_started' => 'boolean',
                'is_ended' => 'boolean'
            ])
        );
    }
}
