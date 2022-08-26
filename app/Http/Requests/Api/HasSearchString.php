<?php

namespace App\Http\Requests\Api;

trait HasSearchString
{
    protected function searchStringRules(): array
    {
        return [
            'search' => 'nullable|string'
        ];
    }
}
