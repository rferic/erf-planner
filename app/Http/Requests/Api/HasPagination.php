<?php

namespace App\Http\Requests\Api;

trait HasPagination
{
    protected function paginationRules(): array
    {
        return [
            'pagination' => 'nullable|array',
            'pagination.page' => 'nullable|numeric',
            'pagination.per_page' => [
                'nullable',
                'numeric',
                'between:1,500'
            ]
        ];
    }
}
