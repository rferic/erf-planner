<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'permissions' => $this->hasRole(config('permission.role-super-admin'))
                ? ['*']
                : $this->getAllPermissions()->pluck('name'),
            'image' => $this->image_url
        ];
    }
}
