<?php

namespace App\UseCases\Core\Client;

use App\Models\Core\Client;

class DestroyUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected Client $client
    )
    {}

	public function action(): Client
	{
        try {
            $this->client->forceDelete();
        } catch (\Exception $_) {
            $this->client->delete();
        }

        return $this->client;
	}
}
