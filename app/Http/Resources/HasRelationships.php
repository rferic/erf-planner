<?php

namespace App\Http\Resources;

trait HasRelationships
{
    public function validateRelationships(): void
    {
        if (array_filter($this->relationships, static fn ($relationship) => !in_array($relationship, self::AVAILABLE_RELATIONSHIPS, true))) {
            throw new \InvalidArgumentException(__('Invalid relationship'));
        }
    }
}
