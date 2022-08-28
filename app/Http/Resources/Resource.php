<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

abstract class Resource extends JsonResource
{
    public static function collection($resource, ...$params): Collection
    {
        return $resource->map(function ($item) use ($params) {
            return new static($item, ...$params);
        });
    }
}
