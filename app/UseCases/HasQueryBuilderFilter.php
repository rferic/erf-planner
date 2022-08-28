<?php

namespace App\UseCases;

use App\Helpers\QueryBuilder\Filters;

trait HasQueryBuilderFilter
{
    public function __construct(
        protected ?string $search = null,
        protected ?Filters $filters = null
    )
    {}

    protected function parseValueToOperator(string $operator, string $value): string
    {
        return match ($operator) {
            'like', 'notLike' => '%'.$value.'%',
            default => $value,
        };
    }
}
