<?php

namespace App\Http\Resources\Core;

use App\Http\Resources\HasRelationships;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    use HasRelationships;

    public const AVAILABLE_RELATIONSHIPS = [
        'client'
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
            'author' => new UserResource($this->author),
            'status' => new StatusResourceMinimal($this->status)
        ];

        if (in_array('client', $this->relationships, true)) {
            $data['client'] = new ClientResource($this->client);
        }

        return $data;
    }
}
