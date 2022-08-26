<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class MeResource extends JsonResource
{
    public function __construct(
        \Illuminate\Contracts\Auth\Authenticatable|Model $resource,
        protected ?\Laravel\Passport\PersonalAccessTokenResult $userToken = null
    )
    {
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
        $data = ['user' => new UserResource($this->resource)];

        if ($this->userToken) {
            $data['token'] = [
                'type' => 'Bearer',
                'access_token' => $this->userToken->accessToken,
                'expires_at' => Carbon::parse($this->userToken->token->expires_at)->toDateTimeString()
            ];
        }

        return $data;
    }
}
