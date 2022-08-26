<?php

namespace App\Models;

use Illuminate\Support\Str;

trait HasImage
{
    protected function imageUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return new \Illuminate\Database\Eloquent\Casts\Attribute(
            get: fn ($value) => $this->image ? asset('storage/' . $this->image) : null,
            set: fn ($value) => $value
        );
    }

    protected function imageFolder(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return new \Illuminate\Database\Eloquent\Casts\Attribute(
            get: fn ($value) => Str::snake(Str::plural(class_basename($this)), '-') . '/' . $this->id,
            set: fn ($value) => $value
        );
    }
}
