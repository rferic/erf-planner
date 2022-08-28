<?php

namespace App\Http\Resources\Core;

use App\Http\Resources\HasRelationships;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    use HasRelationships;

    public const AVAILABLE_RELATIONSHIPS = [
        'projects'
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
            'status' => new StatusResourceMinimal($this->status)
        ];

        if (in_array('projects', $this->relationships, true)) {
            $data['projects'] = ProjectResource::collection($this->projects);
        }

        return $data;
    }
}
