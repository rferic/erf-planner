<?php

namespace App\UseCases\Core\Client;

use App\Models\Core\Client;
use App\Models\Core\Status;

class UpdateUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Client $client,
        protected ?string $name,
        protected ?string $email,
        protected ?string $phone,
        protected ?string $web,
        protected ?Status $status
    )
    {}

	public function action(): Client
	{
		if ($this->status && $this->status->type !== Client::STATUS_TYPE) {
            throw new \RuntimeException(__('Status not found'));
        }

        $this->client->name = $this->name ?? $this->client->name;
        $this->client->email = $this->email ?? $this->client->email;
        $this->client->phone = $this->phone ?? $this->client->phone;
        $this->client->web = $this->web ?? $this->client->web;
        $this->client->status_id = $this->status ? $this->status->id : $this->client->status_id;
        $this->client->save();
        return $this->client;
	}
}
