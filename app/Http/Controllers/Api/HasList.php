<?php

namespace App\Http\Controllers\Api;

use App\Helpers\QueryBuilder\Pagination;
use App\Helpers\QueryBuilder\Sorting;

trait HasList
{
    protected function list(
        \Illuminate\Database\Eloquent\Builder $query,
        ?Pagination $pagination = null,
        ?Sorting $sorting = null
    ): \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|array {
        return $this->getCollection($query, $pagination, $sorting);
    }

    protected function getCollection(
        \Illuminate\Database\Eloquent\Builder $query,
        ?Pagination $pagination = null,
        ?Sorting $sorting = null
    ): \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|array
    {
        if ($sorting) {
            $query->orderBy($sorting->attribute(), $sorting->direction());
        }

        if ($pagination) {
            return $query->paginate($pagination->perPage(), ['*'], 'page', $pagination->page());
        }

        return $query->get();
    }
}
