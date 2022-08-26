<?php

namespace App\Helpers\QueryBuilder;

use Illuminate\Http\Request;

class Pagination
{
    public function __construct(protected array|Request $request)
    {
        $this->request = !is_array($request) ? $request->all() : $this->request;
    }

    public function page(): int
    {
        if (!isset($this->request['pagination']['page'])) {
            return 1;
        }

        return (int)$this->request['pagination']['page'];
    }

    public function perPage(): int
    {
        if (!isset($this->request['pagination']['per_page'])) {
            return 10;
        }

        return (int)$this->request['pagination']['per_page'];
    }
}
