<?php

namespace App\Http\Resources\Core;

use App\Http\Resources\Resource;

class RoleResource extends Resource
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
            'permissions' => $this->name === config('permission.role-super-admin')
                ? ['*']
                : $this->permissions->pluck('name')
        ];
    }
}
