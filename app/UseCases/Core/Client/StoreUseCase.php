<?php

namespace App\UseCases\Core\Client;

use App\Models\Core\Client;
use App\Models\Core\Status;

class StoreUseCase extends \Labelgrup\LaravelUtilities\Core\UseCases\UseCase
{
    public function __construct(
        protected string $name,
        protected string $email,
        protected ?string $phone,
        protected ?string $web,
        protected Status $status
    )
    {}

	public function action(): Client
	{
		if ($this->status->type !== Client::STATUS_TYPE) {
            throw new \RuntimeException(__('Status not found'));
        }

        return Client::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'web' => $this->web,
            'status_id' => $this->status->id
        ]);
	}
}
