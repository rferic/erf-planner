<?php

namespace App\Http\Resources\Core;

use App\Http\Resources\Resource;

class StatusResourceMinimal extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_started' => $this->is_started,
            'is_ended' => $this->is_ended
        ];
    }
}
