<?php

namespace App\Http\Resources\Core;

use App\Http\Resources\Resource;

class ProjectUserResource extends Resource
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
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->roles->first()?->name,
            'type' => $this->pivot->type
        ];
    }
}
