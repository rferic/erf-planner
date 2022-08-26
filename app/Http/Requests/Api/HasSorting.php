<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

trait HasSorting
{
    protected function sortingRules(): array
    {
        return [
            'sorting' => 'nullable|array',
            'sorting.attribute' => [
                'nullable',
                'string',
                Rule::in(self::AVAILABLE_SORTING_PARAMS)
            ],
            'sorting.direction' => [
                'nullable',
                'string',
                Rule::in('asc', 'desc')
            ]
        ];
    }
}
