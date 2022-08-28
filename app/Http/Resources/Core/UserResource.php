<?php

namespace App\Http\Resources\Core;

use App\Http\Resources\HasRelationships;
use App\Http\Resources\Resource;

class UserResource extends Resource
{
    use HasRelationships;

    public const AVAILABLE_RELATIONSHIPS = [
        'projects',
        'manager_projects',
        'worker_projects',
        'viewer_projects'
    ];

    public function __construct($resource, protected array $relationships = [])
    {
        $this->validateRelationships();
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->roles->first()?->name,
            'permissions' => $this->hasRole(config('permission.role-super-admin'))
                ? ['*']
                : $this->getAllPermissions()->pluck('name'),
            'image' => $this->image_url
        ];

        if (in_array('projects', $this->relationships, true)) {
            $data['projects'] = ProjectResource::collection($this->projects, ['client']);
        }

        if (in_array('manager_projects', $this->relationships, true)) {
            $data['manager_projects'] = ProjectResource::collection($this->manager_projects, ['client']);
        }

        if (in_array('worker_projects', $this->relationships, true)) {
            $data['worker_projects'] = ProjectResource::collection($this->worker_projects, ['client']);
        }

        if (in_array('viewer_projects', $this->relationships, true)) {
            $data['viewer_projects'] = ProjectResource::collection($this->viewer_projects, ['client']);
        }

        return $data;
    }
}
