<?php

namespace App\Http\Requests\Api\Core\User;

use App\Http\Requests\Api\HasFilters;
use App\Http\Requests\Api\HasPagination;
use App\Http\Requests\Api\HasSearchString;
use App\Http\Requests\Api\HasSorting;
use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class IndexRequest extends ApiRequest
{
    use HasFilters, HasPagination, HasSearchString, HasSorting;

    public const AVAILABLE_SORTING_PARAMS = ['id', 'name'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            $this->paginationRules(),
            $this->searchStringRules(),
            $this->sortingRules(),
            $this->filtersRules([
                'id' => 'numeric',
                'emails' => 'array',
                'emails.*' => 'string|email',
                'email' => 'array',
                'email.value' => 'string|email',
                'email.operator' => 'string|in:=,!=,like,notLike',
                'name' => 'array',
                'name.value' => 'string',
                'name.operator' => 'string|in:=,!=,like,notLike',
                'roles' => 'array',
                'roles.*' => 'string|exists:roles,name'
            ])
        ];
    }
}
