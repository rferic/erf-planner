<?php

namespace App\Helpers\QueryBuilder;

use Illuminate\Http\Request;

class Sorting
{
    public function __construct(protected array|Request $request)
    {
        $this->request = !is_array($request) ? $request->all() : $this->request;
    }

    public function attribute(): ?string
    {
        return $this->request['sorting']['attribute'] ?? 'id';
    }

    public function direction(): string
    {
        return $this->request['sorting']['direction'] ?? 'asc';
    }
}
