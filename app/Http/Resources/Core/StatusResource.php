<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
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
            'color' => $this->color,
            'text_color' => $this->text_color,
            'type' => $this->type,
            'is_started' => $this->is_started,
            'is_ended' => $this->is_ended,
            'weight' => $this->weight
        ];
    }
}
