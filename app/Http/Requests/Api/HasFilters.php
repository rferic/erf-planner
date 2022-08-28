<?php

namespace App\Http\Requests\Api;

trait HasFilters
{
    protected function filtersRules(array $rules): array
    {
        $filtersRules = ['filters' => 'array'];

        foreach ($rules as $key => $value) {
            $filtersRules['filters.' . $key] = $value;
        }

        return $filtersRules;
    }
}
