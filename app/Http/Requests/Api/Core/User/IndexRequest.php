<?php

namespace App\Http\Requests\Api\Core\User;

use App\Http\Requests\Api\HasPagination;
use App\Http\Requests\Api\HasSearchString;
use App\Http\Requests\Api\HasSorting;
use Labelgrup\LaravelUtilities\Core\Requests\ApiRequest;

class IndexRequest extends ApiRequest
{
    use HasPagination, HasSearchString, HasSorting;

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
            [
                'filters' => 'array',
                'filters.id' => 'numeric',
                'filters.emails' => 'array',
                'filters.emails.*' => 'string|email',
                'filters.email' => 'array',
                'filters.email.value' => 'string|email',
                'filters.email.operator' => 'string|in:=,!=,like,notLike',
                'filters.name' => 'array',
                'filters.name.value' => 'string',
                'filters.name.operator' => 'string|in:=,!=,like,notLike',
                'roles' => 'array',
                'roles.*' => 'string|exists:roles,name',
            ]
        ];
    }
}
