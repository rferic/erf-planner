<?php

namespace App\Http\Resources\Core;

use App\Http\Resources\HasRelationships;
use App\Http\Resources\Resource;

class ProjectResource extends Resource
{
    use HasRelationships;

    public const AVAILABLE_RELATIONSHIPS = [
        'author',
        'client',
        'users',
        'managers',
        'workers',
        'viewers'
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
            'name' => $this->name,
            'image' => $this->image_url,
            'email' => $this->email,
            'phone' => $this->phone,
            'web' => $this->web,
            'status' => new StatusResourceMinimal($this->status),
            'out_of_time' => $this->out_of_time,
        ];

        if (in_array('author', $this->relationships, true)) {
            $data['author'] = new UserResource($this->author);
        }

        if (in_array('client', $this->relationships, true)) {
            $data['client'] = new ClientResource($this->client);
        }

        if (in_array('users', $this->relationships, true)) {
            $data['users'] = ProjectUserResource::collection($this->users);
        }

        if (in_array('managers', $this->relationships, true)) {
            $data['managers'] = ProjectUserResource::collection($this->managers);
        }

        if (in_array('workers', $this->relationships, true)) {
            $data['workers'] = ProjectUserResource::collection($this->workers);
        }

        if (in_array('viewers', $this->relationships, true)) {
            $data['viewers'] = ProjectUserResource::collection($this->viewers);
        }

        return $data;
    }
}
