<?php

namespace App\Helpers\QueryBuilder;

use Illuminate\Http\Request;

class Filters
{
    public function __construct(protected array|Request $request)
    {
        $this->request = !is_array($request) ? $request->all() : $this->request;
    }

    public function filters(): array
    {
        return $this->request['filters'] ?? [];
    }

    public function filter(string $attribute): mixed
    {
        return $this->filters()[$attribute] ?? null;
    }
}
